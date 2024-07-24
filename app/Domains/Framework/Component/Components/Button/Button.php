<?php

namespace App\Domains\Framework\Component\Components\Button;

use App\Domains\Framework\Component\ButtonTemplate;
use App\Domains\Framework\Component\Traits\HasButtonDesign;
use App\Domains\Framework\Component\Traits\HasDisabled;
use App\Domains\Framework\Component\Traits\HasIcon;
use App\Domains\Framework\Core\Utilities\ExportBuilder;

class Button extends ButtonTemplate
{
	use HasDisabled;
	use HasButtonDesign;
	use HasIcon;

	private bool $fullWidth = false;

	public static function make(): self
	{
		return new self();
	}

	/**
	 * @param bool $fullWidth
	 * @return static
	 */
	public function setFullWidth(bool $fullWidth = true)
	{
		$this->fullWidth = $fullWidth;

		return $this;
	}

	/**
	 * @return array<string, mixed>
	 */
	public function export(): array
	{
		return ExportBuilder::make($this)
			->mergeProperties($this->buttonTemplateExport())
			->mergeProperties($this->disabledExport())
			->mergeProperties($this->iconExport())
			->addProperty("design", $this->design)
			->addProperty("fullWidth", $this->fullWidth)
			->export();
	}
}
