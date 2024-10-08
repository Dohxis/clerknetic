<?php

namespace App\Domains\Framework\Form\Fields\RadiosField;

use App\Domains\Framework\Component\Exceptions\MethodNotAllowedException;
use App\Domains\Framework\Core\Utilities\ExportBuilder;
use App\Domains\Framework\Form\Fields\Enums\ValidationRule;
use App\Domains\Framework\Form\Fields\Field;
use Illuminate\Validation\Rule;

/**
 * @extends Field<string|int|bool|null>
 */
class RadiosField extends Field
{
	/**
	 * @var RadioButton[] $nodes
	 */
	private array $nodes = [];

	private function __construct(string $label, ?string $name = null)
	{
		parent::__construct($label, $name);

		$this->setDefaultValue(null);
	}

	public static function make(string $label, ?string $name = null): self
	{
		return new self($label, $name);
	}

	/**
	 * @param RadioButton[] $nodes
	 * @return $this
	 */
	public function setNodes(array $nodes): self
	{
		$this->nodes = $nodes;

		$this->removeValidationRule(ValidationRule::RULE_IN);
		$this->addValidationRule(
			Rule::in(
				array_map(
					fn(RadioButton $radioButton) => $radioButton->getValue(),
					$this->nodes
				)
			)
		);

		return $this;
	}

	/**
	 * @throws MethodNotAllowedException
	 */
	public function setOptional(bool $optional = true): static
	{
		throw new MethodNotAllowedException(__METHOD__);
	}

	/**
	 * @return array<string, mixed>
	 */
	public function export(): array
	{
		return ExportBuilder::make($this)
			->mergeProperties($this->fieldExport())
			->addNodesProperty("radios", $this->nodes)
			->export();
	}
}
