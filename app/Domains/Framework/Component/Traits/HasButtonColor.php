<?php

namespace App\Domains\Framework\Component\Traits;

use App\Domains\Framework\Component\Enums\ButtonColor;
use App\Domains\Framework\Core\Utilities\ExportBuilder;

trait HasButtonColor
{
	private string $color = ButtonColor::PRIMARY;

	/**
	 * @return static
	 */
	public function asColorPrimary()
	{
		$this->color = ButtonColor::PRIMARY;

		return $this;
	}

	/**
	 * @return static
	 */
	public function asColorRed()
	{
		$this->color = ButtonColor::RED;

		return $this;
	}

	/**
	 * @return static
	 */
	public function asColorYellow()
	{
		$this->color = ButtonColor::YELLOW;

		return $this;
	}

	/**
	 * @return static
	 */
	public function asColorGray()
	{
		$this->color = ButtonColor::GRAY;

		return $this;
	}

	/**
	 * @return array<mixed>
	 */
	private function buttonColorExport(): array
	{
		return ExportBuilder::make()
			->addProperty("color", $this->color)
			->export();
	}
}
