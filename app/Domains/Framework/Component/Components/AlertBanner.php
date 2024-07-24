<?php

namespace App\Domains\Framework\Component\Components;

use App\Domains\Framework\Component\Component;
use App\Domains\Framework\Component\Enums\Icon;
use App\Domains\Framework\Component\Traits\HasButtons;
use App\Domains\Framework\Component\Traits\HasDescription;
use App\Domains\Framework\Component\Traits\HasIcon;
use App\Domains\Framework\Core\Utilities\ExportBuilder;

class AlertBanner extends Component
{
	use HasDescription;
	use HasButtons;
	use HasIcon;

	public function __construct()
	{
		$this->setIcon(Icon::INFORMATION);
	}

	public static function make(): self
	{
		return new self();
	}

	/**
	 * @return array<string, mixed>
	 */
	public function export(): array
	{
		return ExportBuilder::make($this)
			->mergeProperties($this->iconExport())
			->mergeProperties($this->descriptionExport())
			->mergeProperties($this->buttonsExport())
			->export();
	}
}
