<?php

namespace App\Domains\Framework\Component\Traits;

use App\Domains\Framework\Core\Utilities\ExportBuilder;

trait HasImage
{
	private ?string $image = null;

	/**
	 * @param string|null $image
	 * @return static
	 */
	public function setImage(?string $image)
	{
		$this->image = $image;

		return $this;
	}

	/**
	 * @return array<mixed>
	 */
	private function imageExport(): array
	{
		return ExportBuilder::make()
			->addProperty("image", $this->image)
			->export();
	}
}
