<?php

namespace App\Domains\Framework\Form\Actions;

use App\Domains\Framework\Component\Component;
use App\Domains\Framework\Form\Fields\Field;

class GetNestedFieldsAction
{
	/**
	 * @param array<int, Component> $nodes
	 * @return array<int, Field<mixed>>
	 */
	public function execute(array $nodes): array
	{
		return $this->getFields($nodes);
	}

	/**
	 * @param array<int, Component>|null $nodes
	 * @return array<int, Field<mixed>>
	 */
	private function getFields(array $nodes = null): array
	{
		return array_reduce(
			$nodes ?? [],
			function ($previousFields, Component $node) {
				if ($node instanceof Field) {
					return array_merge($previousFields, [$node]);
				} elseif (method_exists($node, "getNodes")) {
					return array_merge(
						$previousFields,
						$this->getFields($node->getNodes())
					);
				}

				return $previousFields;
			},
			[]
		);
	}
}
