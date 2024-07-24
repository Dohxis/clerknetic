<?php

namespace App\Domains\Framework\Layout\Layouts;

use App\Domains\Framework\Core\Utilities\ExportBuilder;
use App\Domains\Framework\Layout\Layout;

class TopSideLayout extends Layout
{
	public static function make(): self
	{
		return new self();
	}

	/**
	 * @return array<string, mixed>
	 */
	public function export(): array
	{
		return ExportBuilder::make($this)->export();
	}
}
