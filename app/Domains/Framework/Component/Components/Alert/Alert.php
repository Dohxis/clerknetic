<?php

namespace App\Domains\Framework\Component\Components\Alert;

use App\Domains\Framework\Component\Component;
use App\Domains\Framework\Component\Components\Alert\Enums\AlertType;
use App\Domains\Framework\Component\Traits\HasDescription;
use App\Domains\Framework\Component\Traits\HasTitle;
use App\Domains\Framework\Core\Utilities\ExportBuilder;

class Alert extends Component
{
	use HasTitle;
	use HasDescription;

	private string $confirmButtonText = "Confirm";

	private string $cancelButtonText = "Cancel";

	private ?string $type = AlertType::DANGER;

	public static function make(): self
	{
		return new self();
	}

	/**
	 * @param string $confirmButtonText
	 * @return static
	 */
	public function setConfirmButtonText(string $confirmButtonText)
	{
		$this->confirmButtonText = $confirmButtonText;

		return $this;
	}

	/**
	 * @param string $cancelButtonText
	 * @return static
	 */
	public function setCancelButtonText(string $cancelButtonText)
	{
		$this->cancelButtonText = $cancelButtonText;

		return $this;
	}

	/**
	 * @param string|null $type
	 * @return static
	 */
	public function setType(?string $type)
	{
		$this->type = $type;

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
			->addProperty("confirmButtonText", __($this->confirmButtonText))
			->addProperty("cancelButtonText", __($this->cancelButtonText))
			->addProperty("type", $this->type)
			->export();
	}
}
