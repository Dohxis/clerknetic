<?php

namespace App\Domains\Framework\Component\Traits;

use App\Domains\Framework\Core\Utilities\ExportBuilder;

trait HasAction
{
	private ?string $action = null;

	/**
	 * @param string|null $action
	 * @return static
	 */
	public function setAction(?string $action)
	{
		$this->action = $action;

		return $this;
	}

	/**
	 * @return array<mixed>
	 */
	private function actionExport(): array
	{
		return ExportBuilder::make()
			->addProperty("action", $this->action)
			->export();
	}
}
