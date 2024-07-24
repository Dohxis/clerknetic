<?php

namespace App\Domains\Framework\Component\Components\FilesDisplay;

use App\Domains\Framework\Component\Component;
use App\Domains\Framework\Component\Traits\HasNodes;
use App\Domains\Framework\Core\Utilities\ExportBuilder;

class FilesDisplay extends Component
{
	use HasNodes;

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
			->export();
	}
}
