<?php

namespace App\Domains\Framework\Component\Components\Timeline;

use App\Domains\Framework\Component\Component;
use App\Domains\Framework\Core\Utilities\ExportBuilder;

class Timeline extends Component
{
	/**
	 * @var TimelineItem[] $timelineItems
	 */
	private array $timelineItems = [];

	public static function make(): self
	{
		return new self();
	}

	/**
	 * @param TimelineItem[] $timelineItems
	 * @return static
	 */
	public function setTimelineItems(array $timelineItems)
	{
		$this->timelineItems = $timelineItems;

		return $this;
	}

	/**
	 * @return array<mixed>
	 */
	public function export(): array
	{
		return ExportBuilder::make($this)
			->addNodesProperty("timelineItems", $this->timelineItems)
			->export();
	}
}
