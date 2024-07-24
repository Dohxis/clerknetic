<?php

namespace App\Domains\Framework\Component\Components\PricingPlans;

use App\Domains\Framework\Component\Component;
use App\Domains\Framework\Component\Traits\HasDescription;
use App\Domains\Framework\Component\Traits\HasTitle;
use App\Domains\Framework\Core\Utilities\ExportBuilder;

class CurrentPricingPlans extends Component
{
	use HasTitle;
	use HasDescription;

	/**
	 * @var array<int, CurrentPricingPlan> $plans
	 */
	private array $plans = [];

	public static function make(): self
	{
		return new self();
	}

	/**
	 * @param array<int, CurrentPricingPlan> $plans
	 * @return static
	 */
	public function setPlans(array $plans)
	{
		$this->plans = $plans;

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
			->addNodesProperty("plans", $this->plans)
			->export();
	}
}
