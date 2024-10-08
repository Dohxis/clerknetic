<?php

namespace App\Domains\Framework\Component\Components\PricingPlans;

use App\Domains\Framework\Component\Component;
use App\Domains\Framework\Component\Traits\HasButtons;
use App\Domains\Framework\Core\Utilities\ExportBuilder;

class PricingPlanInterval extends Component
{
	use HasButtons;

	private bool $active = false;

	private int $price = 0;

	public static function make(): self
	{
		return new self();
	}

	/**
	 * @param int $price
	 * @return static
	 */
	public function setPrice(int $price)
	{
		$this->price = $price;

		return $this;
	}

	/**
	 * @param bool $active
	 * @return static
	 */
	public function active(bool $active = true)
	{
		$this->active = $active;

		return $this;
	}

	/**
	 * @return array<mixed>
	 */
	public function export(): array
	{
		return ExportBuilder::make($this)
			->mergeProperties($this->buttonsExport())
			->addProperty("price", $this->price)
			->addProperty("active", $this->active)
			->export();
	}
}
