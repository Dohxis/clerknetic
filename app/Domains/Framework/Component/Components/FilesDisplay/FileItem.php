<?php

namespace App\Domains\Framework\Component\Components\FilesDisplay;

use App\Domains\Framework\Component\Component;
use App\Domains\Framework\Component\Traits\HasNodes;
use App\Domains\Framework\Component\Traits\HasTitle;
use App\Domains\Framework\Core\Utilities\ExportBuilder;

class FileItem extends Component
{
	use HasTitle;
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
			->mergeProperties($this->titleExport())
			->mergeProperties($this->nodesExport())
			->export();
	}
}
