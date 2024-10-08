<?php

namespace App\Domains\Framework\Component\Components\Tooltip;

use App\Domains\Framework\Component\Component;
use App\Domains\Framework\Component\Components\Tooltip\Enums\Placement;
use App\Domains\Framework\Component\Traits\HasNodes;
use App\Domains\Framework\Core\Utilities\ExportBuilder;

class Tooltip extends Component
{
	use HasNodes;

	private ?string $content = null;

	private string $placement = Placement::TOP;

	public static function make(): self
	{
		return new self();
	}

	public function setContent(?string $content): self
	{
		$this->content = $content;

		return $this;
	}

	public function placementLeft(): self
	{
		$this->placement = Placement::LEFT;

		return $this;
	}

	public function placementRight(): self
	{
		$this->placement = Placement::RIGHT;

		return $this;
	}

	public function placementTop(): self
	{
		$this->placement = Placement::TOP;

		return $this;
	}

	public function placementBottom(): self
	{
		$this->placement = Placement::BOTTOM;

		return $this;
	}

	/**
	 * @return array<mixed>
	 */
	public function export(): array
	{
		return ExportBuilder::make($this)
			->mergeProperties($this->nodesExport())
			->addProperty(
				"content",
				$this->content === null ? null : __($this->content)
			)
			->addProperty("placement", $this->placement)
			->export();
	}
}
