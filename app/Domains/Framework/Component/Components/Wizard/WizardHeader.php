<?php

namespace App\Domains\Framework\Component\Components\Wizard;

use App\Domains\Framework\Component\Component;
use App\Domains\Framework\Component\Components\Wizard\Enums\WizardHeaderDesign;
use App\Domains\Framework\Component\Components\Wizard\Partials\WizardStep;
use App\Domains\Framework\Core\Utilities\ExportBuilder;

class WizardHeader extends Component
{
	private int $activeIndex = 0;

	/**
	 * @var array<int, WizardStep> $steps
	 */
	private array $steps = [];

	private string $design = WizardHeaderDesign::STEPS;

	public static function make(): self
	{
		return new self();
	}

	/**
	 * @param int $activeIndex
	 * @return static
	 */
	public function setActiveIndex(int $activeIndex)
	{
		$this->activeIndex = $activeIndex;

		return $this;
	}

	/**
	 * @param array<int, WizardStep> $steps
	 * @return static
	 */
	public function setSteps(array $steps)
	{
		$this->steps = $steps;

		return $this;
	}

	/**
	 * @param string $design
	 * @return static
	 */
	public function setDesign(string $design)
	{
		$this->design = $design;

		return $this;
	}

	private function updateSteps(): void
	{
		foreach ($this->steps as $index => $step) {
			$step
				->setIndex($index)
				->setHighlighted($this->activeIndex >= $index)
				->setActive($this->activeIndex === $index);
		}
	}

	/**
	 * @return array<mixed>
	 */
	public function export(): array
	{
		$this->updateSteps();

		return ExportBuilder::make($this)
			->addNodesProperty("steps", $this->steps)
			->addProperty("design", $this->design)
			->addProperty("activeIndex", $this->activeIndex)
			->export();
	}
}
