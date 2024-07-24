<?php

namespace App\Domains\Framework\Form\Form;

use App\Domains\Framework\Component\Component;
use App\Domains\Framework\Component\Traits\HasButtonColor;
use App\Domains\Framework\Component\Traits\HasButtonDesign;
use App\Domains\Framework\Component\Traits\HasTitle;
use App\Domains\Framework\Core\Utilities\ExportBuilder;

class FormButton extends Component
{
	use HasTitle;
	use HasButtonDesign;
	use HasButtonColor;

	/**
	 * @var array<string, mixed>
	 */
	private array $withData = [];

	private ?string $forceActionResponseType = null;

	private bool $withoutFrontendValidation = false;

	public static function make(): self
	{
		return new self();
	}

	/**
	 * @param array<string, mixed> $withData
	 * @return $this
	 */
	public function withData(array $withData): self
	{
		$this->withData = $withData;

		return $this;
	}

	/**
	 * @param ?string $forceActionResponseType
	 * @return $this
	 */
	public function forceActionResponseType(
		?string $forceActionResponseType
	): self {
		$this->forceActionResponseType = $forceActionResponseType;

		return $this;
	}

	public function withoutFrontendValidation(
		bool $withoutFrontendValidation = true
	): self {
		$this->withoutFrontendValidation = $withoutFrontendValidation;

		return $this;
	}

	/**
	 * @return array<mixed>
	 */
	public function export(): array
	{
		return ExportBuilder::make($this)
			->mergeProperties($this->titleExport())
			->mergeProperties($this->buttonDesignExport())
			->mergeProperties($this->buttonColorExport())
			->addProperty("withData", $this->withData)
			->addProperty(
				"forceActionResponseType",
				$this->forceActionResponseType
			)
			->addProperty(
				"withoutFrontendValidation",
				$this->withoutFrontendValidation
			)
			->export();
	}
}
