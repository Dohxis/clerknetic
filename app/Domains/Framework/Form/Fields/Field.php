<?php

namespace App\Domains\Framework\Form\Fields;

use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use App\Domains\Framework\Component\Component;
use App\Domains\Framework\Component\Components\Text;
use App\Domains\Framework\Component\Rules\DeepEqualRule;
use App\Domains\Framework\Component\Traits\HasDisabled;
use App\Domains\Framework\ResourceFieldConfiguration\Traits\HasResourceConfigurations;
use App\Domains\Framework\Core\Utilities\ExportBuilder;
use App\Domains\Framework\Form\Fields\Classes\Dependee;

/**
 * @template TDefaultValue
 */
abstract class Field extends Component
{
	use HasDisabled, HasResourceConfigurations;

	private string $name;

	private string|Text $label;

	private ?string $placeholder = null;

	private ?string $explanation = null;

	/** @var mixed $defaultValue */
	protected mixed $defaultValue = null;

	/** @var Collection<int, mixed> $validationRules */
	private Collection $validationRules;

	/** @var Collection<int, Dependee> $dependees */
	private Collection $dependees;

	/**
	 * @throws Exception
	 */
	public function __construct(string|Text $label, ?string $name = null)
	{
		if ($name === null && $label instanceof Text) {
			throw new Exception(
				"When component Text is used for field label, the name must be provided."
			);
		}

		$this->bootHasResourceConfigurations();

		$this->label = $label;

		$this->name = $name === null ? Str::snake($label) : $name;

		$this->validationRules = collect(["required"]);

		/** @phpstan-ignore-next-line  */
		$this->dependees = collect([]);
	}

	public function setOptional(bool $optional = true): static
	{
		if ($optional) {
			$this->removeValidationRule("required");

			$this->addValidationRule("nullable");
		} else {
			$this->addValidationRule("required");

			$this->removeValidationRule("nullable");
		}

		return $this;
	}

	public function setExplanation(?string $explanation): static
	{
		$this->explanation = $explanation;

		return $this;
	}

	public function setPlaceholder(?string $placeholder): static
	{
		$this->placeholder = $placeholder;

		return $this;
	}

	/**
	 * @param TDefaultValue $defaultValue
	 * @return static
	 */
	public function setDefaultValue($defaultValue): static
	{
		$this->defaultValue = $defaultValue;

		return $this;
	}

	public function addValidationRule(object|string $rule): static
	{
		if (is_object($rule)) {
			$this->removeValidationRule($rule);
		} else {
			$ruleName = explode(":", $rule, 2)[0];
			$this->removeValidationRule($ruleName);
		}

		$this->validationRules->push($rule);

		return $this;
	}

	public function removeValidationRule(object|string $newRule): static
	{
		$this->validationRules = $this->validationRules->filter(function (
			$existingRule
		) use ($newRule) {
			if (is_object($existingRule) && is_object($newRule)) {
				return class_basename($newRule) !==
					class_basename($existingRule);
			}

			if (is_object($newRule)) {
				return class_basename($newRule) !== $existingRule;
			}

			if (is_object($existingRule)) {
				return $newRule !== class_basename($existingRule);
			}

			return $newRule !== $existingRule &&
				!Str::startsWith($existingRule, $newRule . ":");
		});

		return $this;
	}

	/**
	 * @param object $initialFormValues
	 * @param object $unvalidatedFormValues
	 * @return array<string, mixed>
	 */
	public function getValidationRules(
		object $initialFormValues,
		object $unvalidatedFormValues
	): array {
		$initialFieldValue = property_exists($initialFormValues, $this->name)
			? $initialFormValues->{$this->name}
			: $this->defaultValue;

		/**
		 * We allow only default value to be submitted
		 * when field is disabled
		 */
		$fieldRules = $this->disabled
			? [new DeepEqualRule($initialFieldValue)]
			: $this->validationRules->values()->all();

		$newFieldValue = property_exists($unvalidatedFormValues, $this->name)
			? $unvalidatedFormValues->{$this->name}
			: $initialFieldValue;
		if ($this->name === "enable_stock_management") {
			ray($this->name);
			ray($initialFieldValue);
			ray($newFieldValue);
		}

		$activeDependeesValidationsRules = $this->getActiveDependees(
			$newFieldValue
		)->reduce(
			fn(array $previous, Dependee $dependee) => array_merge(
				$previous,
				$dependee->getFieldsValidationRules(
					initialFormValues: $initialFormValues,
					unvalidatedFormValues: $unvalidatedFormValues
				)
			),
			[]
		);

		return array_merge(
			[$this->name => $fieldRules],
			$activeDependeesValidationsRules
		);
	}

	public function getLabel(): string|Text
	{
		return $this->label;
	}

	public function getName(): string
	{
		return $this->name;
	}

	/**
	 * @param object $initialFormValues
	 * @return array<string, mixed>
	 */
	public function getDefaultValue(object $initialFormValues): array
	{
		$defaultFieldValue = property_exists($initialFormValues, $this->name)
			? $initialFormValues->{$this->name}
			: $this->defaultValue;

		$activeDependeesDefaultValues = $this->getActiveDependees(
			$defaultFieldValue
		)->reduce(
			fn(array $previous, Dependee $dependee) => array_merge(
				$previous,
				$dependee->getFieldsDefaultValues()
			),
			[]
		);

		return array_merge(
			[$this->name => $defaultFieldValue],
			$activeDependeesDefaultValues
		);
	}

	/**
	 * @param Dependee $dependee
	 * @return static
	 */
	public function addDependee(Dependee $dependee)
	{
		$this->dependees->add($dependee);

		return $this;
	}

	/**
	 * @param Dependee[] $dependees
	 * @return static
	 */
	public function addDependees(array $dependees)
	{
		$this->dependees = $this->dependees->merge($dependees);

		return $this;
	}

	protected function isRequired(): bool
	{
		return $this->validationRules->contains("required");
	}

	/**
	 * @param mixed $fieldValue
	 * @return Collection<int, Dependee>
	 */
	private function getActiveDependees(mixed $fieldValue): Collection
	{
		return $this->dependees->filter(
			fn(Dependee $dependee) => $dependee->isActive($fieldValue)
		);
	}

	/**
	 * @return array<string, mixed>
	 */
	protected function fieldExport(): array
	{
		return ExportBuilder::make()
			->mergeProperties($this->disabledExport())
			->addProperty("name", $this->name)
			->addProperty(
				"label",
				$this->label instanceof Text ? $this->label : __($this->label)
			)
			->addProperty("defaultValue", $this->defaultValue)
			->addProperty("explanation", $this->explanation)
			->addProperty("placeholder", $this->placeholder)
			->addProperty("required", $this->isRequired())
			->addNodesProperty("dependees", $this->dependees->all())
			->export();
	}
}
