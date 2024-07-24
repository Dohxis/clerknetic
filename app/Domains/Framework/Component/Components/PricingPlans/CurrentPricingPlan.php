<?php

namespace App\Domains\Framework\Component\Components\PricingPlans;

use App\Domains\Framework\Component\Component;
use App\Domains\Framework\Component\Traits\HasButtons;
use App\Domains\Framework\Component\Traits\HasDescription;
use App\Domains\Framework\Component\Traits\HasTitle;
use App\Domains\Framework\Core\Utilities\ExportBuilder;

class CurrentPricingPlan extends Component
{
	use HasTitle;
	use HasDescription;
	use HasButtons;

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
			->mergeProperties($this->descriptionExport())
			->mergeProperties($this->buttonsExport())
			->export();
	}
}
