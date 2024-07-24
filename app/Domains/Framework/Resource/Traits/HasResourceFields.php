<?php

namespace App\Domains\Framework\Resource\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use App\Domains\Framework\Component\Component;
use App\Domains\Framework\Form\Actions\GetNestedFieldsAction;
use App\Domains\Framework\Form\Fields\Field;
use App\Domains\Framework\Form\Fields\TextField;
use App\Domains\Framework\Resource\Enums\ResourcePageType;

trait HasResourceFields
{
	/**
	 * @return array<int, Component>
	 */
	protected function fields(ResourcePageType $pageType): array
	{
		$modelInstance = $this->getModelInstance();
		$primaryKey = $modelInstance->getKeyName();

		return [
			TextField::make(
				Str::of($primaryKey)->headline()->lower()->ucfirst(),
				$primaryKey
			)->setDisabled(),
		];
	}

	/**
	 * @param ResourcePageType $pageType
	 * @return Collection<int, Field<mixed>>
	 */
	private function getFieldsFor(ResourcePageType $pageType): Collection
	{
		$nodes = $this->fields($pageType);
		$fields = app(GetNestedFieldsAction::class)->execute($nodes);

		return collect($fields)
			->filter(fn(Field $field) => $field->shouldShowOn($pageType))
			->values();
	}
}
