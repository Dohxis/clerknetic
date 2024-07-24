<?php

namespace App\Domains\Framework\Component\Components\Link;

use App\Domains\Framework\Component\ButtonTemplate;
use App\Domains\Framework\Component\Traits\HasTextAlign;
use App\Domains\Framework\Core\Utilities\ExportBuilder;
use Exception;

class Link extends ButtonTemplate
{
	use HasTextAlign;

	public static function make(): self
	{
		return new self();
	}

	/**
	 * @return array<string, mixed>
	 * @throws Exception
	 */
	public function export(): array
	{
		return ExportBuilder::make($this)
			->mergeProperties($this->textAlignExport())
			->mergeProperties($this->buttonTemplateExport())
			->export();
	}
}
