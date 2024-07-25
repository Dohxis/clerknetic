<?php

namespace App\Domains\Framework\Layout\Layouts\UnauthorizedLayout;

use App\Domains\Framework\Core\Utilities\ExportBuilder;
use App\Domains\Framework\Layout\Layout;

class UnauthorizedLayout extends Layout
{
	private string $panelTitle;

	private string $panelDescription;

	private string $panelDescriptionLinkText;

	private string $panelDescriptionLinkHref;

	public static function make(): self
	{
		return new self();
	}

	public function setPanelTitle(string $panelTitle): self
	{
		$this->panelTitle = $panelTitle;

		return $this;
	}

	public function setPanelDescription(string $panelDescription): self
	{
		$this->panelDescription = $panelDescription;

		return $this;
	}

	public function setPanelDescriptionLinkText(
		string $panelDescriptionLinkText
	): self {
		$this->panelDescriptionLinkText = $panelDescriptionLinkText;

		return $this;
	}

	public function setPanelDescriptionLinkHref(
		string $panelDescriptionLinkHref
	): self {
		$this->panelDescriptionLinkHref = $panelDescriptionLinkHref;

		return $this;
	}

	/**
	 * @return array<string, mixed>
	 */
	public function export(): array
	{
		return ExportBuilder::make($this)
			->addProperty("panelTitle", $this->panelTitle)
			->addProperty("panelDescription", $this->panelDescription)
			->addProperty(
				"panelDescriptionLinkText",
				$this->panelDescriptionLinkText
			)
			->addProperty(
				"panelDescriptionLinkHref",
				$this->panelDescriptionLinkHref
			)
			->export();
	}
}
