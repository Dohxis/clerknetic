<?php

namespace App\Domains\Framework\Component\Components;

use App\Domains\Framework\Component\Component;
use App\Domains\Framework\Component\ResponsiveValue;
use App\Domains\Framework\Component\Traits\HasGap;
use App\Domains\Framework\Component\Traits\HasNodes;
use App\Domains\Framework\Core\Utilities\ExportBuilder;

class Grid extends Component
{
	use HasNodes;
	use HasGap;

	/** @var ResponsiveValue<array<int, int>> $columns */
	private ResponsiveValue $columns;

	private function __construct()
	{
		$this->columns = ResponsiveValue::make([]);

		$this->setGap(4);
	}

	public static function make(): self
	{
		return new self();
	}

	/**
	 * @param array<int, int> $default
	 * @param array<int, int>|null $sm
	 * @param array<int, int>|null $md
	 * @param array<int, int>|null $lg
	 * @param array<int, int>|null $xl
	 * @return static
	 */
	public function setColumns(
		array $default = [],
		array|null $sm = null,
		array|null $md = null,
		array|null $lg = null,
		array|null $xl = null
	) {
		$this->columns = ResponsiveValue::make($default, $sm, $md, $lg, $xl);

		return $this;
	}

	/**
	 * @return array<string, mixed>
	 */
	public function export(): array
	{
		return ExportBuilder::make($this)
			->mergeProperties($this->nodesExport())
			->mergeProperties($this->gapExport())
			->addProperty("columns", $this->columns)
			->export();
	}
}
