<?php

namespace App\Domains\Framework\Component\Traits;

use App\Domains\Framework\Core\Utilities\ExportBuilder;

trait HasWithPanel
{
	protected bool $withPanel = true;

	/** @return static */
	public function withPanel(bool $withPanel = true)
	{
		$this->withPanel = $withPanel;

		return $this;
	}

	/** @return static */
	public function withoutPanel()
	{
		$this->withPanel = false;

		return $this;
	}

	/**
	 * @return array<mixed>
	 */
	private function withPanelExport(): array
	{
		return ExportBuilder::make()
			->addProperty("withPanel", $this->withPanel)
			->export();
	}
}
