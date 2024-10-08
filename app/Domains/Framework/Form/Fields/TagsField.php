<?php

namespace App\Domains\Framework\Form\Fields;

use App\Domains\Framework\Component\Rules\ArrayItemsDistinctRule;
use App\Domains\Framework\Core\Utilities\ExportBuilder;
use App\Domains\Framework\Form\Fields\Field;

/**
 * @extends Field<array<int, string>>
 */
class TagsField extends Field
{
	private function __construct(string $label, ?string $name = null)
	{
		parent::__construct($label, $name);

		$this->setDefaultValue([]);

		$this->addValidationRule("array");
		$this->addValidationRule(new ArrayItemsDistinctRule());

		// TODO: add validation rules that each item is string: "{name}.*.string".
		//       With current validation rules system, is not possible to validate
		//       array children.
	}

	public static function make(string $label, ?string $name = null): self
	{
		return new self($label, $name);
	}

	/**
	 * @return array<string, mixed>
	 */
	public function export(): array
	{
		return ExportBuilder::make($this)
			->mergeProperties($this->fieldExport())
			->export();
	}
}
