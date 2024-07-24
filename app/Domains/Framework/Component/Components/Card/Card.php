<?php

namespace App\Domains\Framework\Component\Components\Card;

use App\Domains\Framework\Component\Component;
use App\Domains\Framework\Component\Components\Card\Enums\CardDesignEnum;
use App\Domains\Framework\Component\Traits\HasButtons;
use App\Domains\Framework\Component\Traits\HasDescription;
use App\Domains\Framework\Component\Traits\HasImage;
use App\Domains\Framework\Component\Traits\HasTitle;
use App\Domains\Framework\Core\Utilities\ExportBuilder;

class Card extends Component
{
	use HasTitle;
	use HasDescription;
	use HasImage;
	use HasButtons;

	private ?string $design = CardDesignEnum::REGULAR;

	public static function make(): self
	{
		return new self();
	}

	/**
	 * @return static
	 */
	public function asRegular()
	{
		$this->design = CardDesignEnum::REGULAR;

		return $this;
	}

	/**
	 * @return static
	 */
	public function asVertical()
	{
		$this->design = CardDesignEnum::VERTICAL;

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
			->mergeProperties($this->imageExport())
			->mergeProperties($this->buttonsExport())
			->addProperty("design", $this->design)
			->export();
	}
}
