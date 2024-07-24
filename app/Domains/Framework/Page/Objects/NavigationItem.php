<?php

namespace App\Domains\Framework\Page\Objects;

use App\Domains\Framework\Component\Traits\HasIcon;
use App\Domains\Framework\Component\Traits\HasTitle;
use App\Domains\Framework\Core\Interfaces\Exportable;
use App\Domains\Framework\Core\Utilities\ExportBuilder;
use App\Domains\Framework\Page\Page;

class NavigationItem implements Exportable
{
	use HasTitle;
	use HasIcon;

	private string $route;

	private string $activeMatch;

	private function __construct(string $route, string $title)
	{
		$this->route = $route;

		$this->activeMatch = $route;

		$this->setTitle($title);
	}

	public static function make(string $route, string $title): self
	{
		return new self($route, $title);
	}

	/**
	 * @param class-string<Page> $pageClass
	 * @return NavigationItem
	 */
	public static function fromPage(string $pageClass): NavigationItem
	{
		$page = new $pageClass();

		return new NavigationItem($page->route(), $page->title());
	}

	public function setActiveMatch(string $activeMatch): self
	{
		$this->activeMatch = $activeMatch;

		return $this;
	}

	public function export(): array
	{
		return ExportBuilder::make()
			->mergeProperties($this->titleExport())
			->mergeProperties($this->iconExport())
			->addProperty("route", $this->route)
			->addProperty("activeMatch", $this->activeMatch)
			->export();
	}
}
