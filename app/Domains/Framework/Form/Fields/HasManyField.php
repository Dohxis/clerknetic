<?php

namespace App\Domains\Framework\Form\Fields;

use App\Domains\Framework\Component\Component;
use App\Domains\Framework\Core\Utilities\ExportBuilder;
use App\Domains\Framework\Form\Actions\GetNestedFieldsAction;
use App\Domains\Framework\Form\Actions\GetNestedFieldsDefaultValuesAction;
use App\Domains\Framework\Form\Fields\Classes\Dependee;
use Exception;
use Illuminate\Support\Collection;

/**
 * @extends Field<Collection<int, Component>|array<int, Component>>
 */
class HasManyField extends Field
{
	/** @var Collection<int, Component> $unparsedDefaultValue */
	private Collection $unparsedDefaultValue;

	private string $addButtonText = "Add new";

	/**
	 * @var Component[] $template
	 */
	private array $template = [];

	private function __construct(string $label, ?string $name = null)
	{
		parent::__construct($label, $name);

		$this->setDefaultValue([]);

		$this->setOptional();
		$this->addValidationRule("array");
	}

	public static function make(string $label, ?string $name = null): self
	{
		return new self($label, $name);
	}

	/**
	 * @param Component[] $nodes
	 * @return static
	 */
	public function setTemplate(array $nodes)
	{
		$this->template = $nodes;
		$this->updateDefaultValue();

		return $this;
	}

	public function setAddButtonText(string $addButtonText): static
	{
		$this->addButtonText = $addButtonText;

		return $this;
	}

	public function setDefaultValue($defaultValue): static
	{
		$this->unparsedDefaultValue = is_array($defaultValue)
			? collect($defaultValue)
			: $defaultValue;
		$this->updateDefaultValue();

		return $this;
	}

	public function getValidationRules(
		object $initialFormValues,
		object $unvalidatedFormValues
	): array {
		$rules = parent::getValidationRules(
			initialFormValues: $initialFormValues,
			unvalidatedFormValues: $unvalidatedFormValues
		);

		$fields = $this->getFields();
		$itemValidationRules = array_reduce(
			$fields,
			function ($previous, Field $field) use (
				$initialFormValues,
				$unvalidatedFormValues
			) {
				$fieldsRules = $field->getValidationRules(
					initialFormValues: $initialFormValues,
					unvalidatedFormValues: $unvalidatedFormValues
				);

				$newName = $this->getName() . ".*." . $field->getName();
				$previous[$newName] = $fieldsRules[$field->getName()];

				return $previous;
			},
			[]
		);

		return array_merge($rules, $itemValidationRules);
	}

	/**
	 * @throws Exception
	 * @return static
	 */
	public function addDependee(Dependee $dependee)
	{
		throw new Exception(
			"Dependees are not implemented for HasManyField yet."
		);
	}

	/**
	 * @throws Exception
	 * @param Dependee[] $dependees
	 * @return static
	 */
	public function addDependees(array $dependees)
	{
		throw new Exception(
			"Dependees are not implemented for HasManyField yet."
		);
	}

	/**
	 * Parses unparsed default value and sets
	 * that value to field's default value
	 */
	private function updateDefaultValue(): void
	{
		$fields = $this->getFields();

		if (count($fields) === 0) {
			parent::setDefaultValue([]);
			return;
		}

		$parsedDefaultValue = $this->unparsedDefaultValue->map(
			fn($unparsedItemValues) => array_reduce(
				$fields,
				function ($previous, Field $field) use ($unparsedItemValues) {
					$name = $field->getName();

					if (
						/** @phpstan-ignore-next-line  */
						is_array($unparsedItemValues) &&
						array_key_exists($name, $unparsedItemValues)
					) {
						$previous[$name] = $unparsedItemValues[$name];
					} elseif (
						is_object($unparsedItemValues) &&
						property_exists($unparsedItemValues, $name)
					) {
						$previous[$name] = $unparsedItemValues->$name;
					} else {
						throw new Exception(
							'Value was not found for field "' .
								$name .
								'" in given default value.'
						);
					}

					return $previous;
				},
				[]
			)
		);

		parent::setDefaultValue($parsedDefaultValue->toArray());
	}

	/**
	 * @return array<mixed>
	 */
	private function getTemplateDefaultValue(): array
	{
		return app(GetNestedFieldsDefaultValuesAction::class)->execute(
			$this->template,
			(object) [] // TODO: rework form default values and dependers. for now by passing [], dependers in has-many might not work properly
		);
	}

	/**
	 * @return Field<mixed>[]
	 */
	private function getFields(): array
	{
		return app(GetNestedFieldsAction::class)->execute($this->template);
	}

	/**
	 * @return array<mixed>
	 */
	public function export(): array
	{
		$templateDefaultValue = $this->getTemplateDefaultValue();

		return ExportBuilder::make($this)
			->mergeProperties($this->fieldExport())
			->addProperty("addButtonText", $this->addButtonText)
			->addNodesProperty("template", $this->template)
			->addProperty("templateDefaultValue", $templateDefaultValue)
			->export();
	}
}
