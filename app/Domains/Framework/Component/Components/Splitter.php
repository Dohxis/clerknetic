<?php

namespace App\Domains\Framework\Component\Components;

use App\Domains\Framework\Component\Component;
use App\Domains\Framework\Component\Traits\HasTitle;
use App\Domains\Framework\Core\Utilities\ExportBuilder;

class Splitter extends Component
{
	use HasTitle;

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
			->export();
	}
}
