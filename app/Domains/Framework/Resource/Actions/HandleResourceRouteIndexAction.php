<?php

namespace App\Domains\Framework\Resource\Actions;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Str;
use Inertia\Response;
use App\Domains\Framework\Component\Component;
use App\Domains\Framework\Component\Components\Button\Button;
use App\Domains\Framework\Component\Components\Link\Link;
use App\Domains\Framework\Component\Components\PaginatedTable\PaginatedTable;
use App\Domains\Framework\Component\Components\Table\Cells\TableLinks;
use App\Domains\Framework\Component\Components\Table\TableRow;
use App\Domains\Framework\Component\Components\Text;
use App\Domains\Framework\Component\Enums\Icon;
use App\Domains\Framework\Core\Utilities\Translate;
use App\Domains\Framework\Responses\StructuredPageResponse;

class HandleResourceRouteIndexAction
{
	/**
	 * @param StructuredPageResponse $response
	 * @param Builder<Model>|BelongsTo<Model, Model>|HasMany<Model> $query
	 * @param array<string, string|Text> $columns
	 * @param string $modelHeadline
	 * @param string $routeCreateLink
	 * @param string $routeEditLink
	 * @param string $routeDeleteLink
	 * @param string|null $modelRouteKeyName
	 * @return Response
	 * @throws Exception
	 */
	public function execute(
		StructuredPageResponse $response,
		Builder|Relation|HasMany $query,
		array $columns,
		string $modelHeadline,
		string $routeCreateLink,
		string $routeEditLink,
		string $routeDeleteLink,
		?string $modelRouteKeyName
	): Response {
		$paginatedTable = PaginatedTable::make()
			->setTitle(Str::of($modelHeadline)->plural())
			->setPanelActions([
				Button::make()
					->setTitle(
						Translate::text("Create new") .
							" " .
							Str::of($modelHeadline)->lower()
					)
					->setIcon(Icon::PLUS)
					->setLink($routeCreateLink),
			])
			->setQuery($query->orderByDesc("created_at"))
			->setRow(function (Model $model) use (
				$columns,
				$routeEditLink,
				$routeDeleteLink,
				$modelRouteKeyName
			) {
				$tableRow = TableRow::make($model->{$model->getKeyName()});

				$values = collect($columns)->keys()->map(
					// TODO: allow developer to write his own custom parsers for each field
					fn(string $key) => $this->parseValueForDisplay(
						$model->{$key}
					)
				);

				$routeKeyValue = $model->{$modelRouteKeyName};

				return $tableRow->setValues([
					...$values->all(),
					TableLinks::make()->setNodes([
						Link::make()
							->setTitle("Edit")
							->setLink(
								(string) Str::of($routeEditLink)->replace(
									"{model}",
									$routeKeyValue
								)
							),
						Link::make()
							->setTitle("Delete")
							->asDelete()
							->setAction(
								(string) Str::of($routeDeleteLink)->replace(
									"{model}",
									$routeKeyValue
								)
							),
					]),
				]);
			});

		collect($columns)->each(
			fn(string|Text $name, string $key) => $paginatedTable->addColumn(
				$name instanceof Text
					? Str::of($key)->headline()->lower()->ucfirst()
					: $name,
				$key
			)
		);

		$paginatedTable->addLinksColumn();

		return $response->setNodes([$paginatedTable])->export();
	}

	private function parseValueForDisplay(
		string|int|float|bool|null $value
	): string {
		if (is_bool($value)) {
			return $value ? Translate::text("Yes") : Translate::text("No");
		}

		return (string) $value;
	}
}
