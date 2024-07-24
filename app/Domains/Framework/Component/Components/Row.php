<?php

namespace App\Domains\Framework\Component\Components;

use App\Domains\Framework\Component\Component;
use App\Domains\Framework\Component\Traits\HasGap;
use App\Domains\Framework\Component\Traits\HasNodes;
use App\Domains\Framework\Core\Utilities\ExportBuilder;

class Row extends Component
{
	use HasNodes;
	use HasGap;

	public static function make(): self
	{
		return new self();
	}

	/**
	 * @return array<mixed>
	 */
	public function export(): array
	{
		return ExportBuilder::make($this)
			->mergeProperties($this->nodesExport())
			->mergeProperties($this->gapExport())
			->export();
	}
}
