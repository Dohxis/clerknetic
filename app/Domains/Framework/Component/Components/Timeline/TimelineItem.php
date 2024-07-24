<?php

namespace App\Domains\Framework\Component\Components\Timeline;

use Carbon\CarbonImmutable;
use App\Domains\Framework\Component\Component;
use App\Domains\Framework\Component\Traits\HasDescription;
use App\Domains\Framework\Component\Traits\HasTitle;
use App\Domains\Framework\Core\Utilities\ExportBuilder;

class TimelineItem extends Component
{
	use HasTitle;
	use HasDescription;

	private ?CarbonImmutable $date = null;

	public static function make(): self
	{
		return new self();
	}

	/**
	 * @param CarbonImmutable|null $date
	 * @return static
	 */
	public function setDate(?CarbonImmutable $date)
	{
		$this->date = $date;

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
			->addProperty("date", $this->date)
			->export();
	}
}
