<?php

namespace App\Domains\Framework\Component\Components;

use App\Domains\Framework\Component\Component;
use App\Domains\Framework\Component\Traits\HasActions;
use App\Domains\Framework\Component\Traits\HasDescription;
use App\Domains\Framework\Component\Traits\HasNodes;
use App\Domains\Framework\Component\Traits\HasTitle;
use App\Domains\Framework\Core\Utilities\ExportBuilder;

class Panel extends Component
{
	use HasTitle;
	use HasDescription;
	use HasNodes;
	use HasActions;

	private int $padding = 6;

	public static function make(): self
	{
		return new self();
	}

	/**
	 * @param int<0, 12> $padding
	 * @return static
	 */
	public function setPadding(int $padding)
	{
		$this->padding = $padding;

		return $this;
	}

	/**
	 * @return array<mixed>
	 */
	public function export(): array
	{
		return ExportBuilder::make($this)
			->mergeProperties($this->titleExport())
			->mergeProperties($this->descriptionExport())
			->mergeProperties($this->nodesExport())
			->mergeProperties($this->actionsExport())
			->addProperty("padding", $this->padding)
			->export();
	}
}
