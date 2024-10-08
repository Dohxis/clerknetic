<?php

namespace App\Domains\Framework\Form\Actions;

use App\Domains\Framework\Component\Component;
use App\Domains\Framework\Form\Fields\Field;

class GetNestedFieldsDefaultValuesAction
{
	/**
	 * @param Component[] $nodes
	 * @return array<string, mixed>
	 */
	public function execute(array $nodes, object $formValues): array
	{
		$fields = app(GetNestedFieldsAction::class)->execute($nodes);

		return array_reduce(
			$fields,
			function (array $previous, Component $field) use ($formValues) {
				if ($field instanceof Field) {
					$previous = array_merge(
						$previous,
						$field->getDefaultValue($formValues)
					);
				}

				return $previous;
			},
			[]
		);
	}
}
