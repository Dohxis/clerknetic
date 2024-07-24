<?php

namespace App\Domains\Framework\Page\Objects;

use App\Domains\Framework\Component\Traits\HasTitle;
use App\Domains\Framework\Core\Interfaces\Exportable;
use App\Domains\Framework\Core\Utilities\ExportBuilder;
use App\Domains\Framework\Page\Page;

class UserNavigationItem implements Exportable
{
	use HasTitle;

	private function __construct(private readonly string $route)
	{
		//
	}

	public static function make(string $route): self
	{
		return new self($route);
	}

	/**
	 * @param class-string<Page> $pageClass
	 * @return UserNavigationItem
	 */
	public static function fromPage(string $pageClass): UserNavigationItem
	{
		/** @var Page $page */
		$page = new $pageClass();

		return UserNavigationItem::make($page->route())->setTitle(
			$page->title()
		);
	}

	public function export(): array
	{
		return ExportBuilder::make()
			->mergeProperties($this->titleExport())
			->addProperty("route", $this->route)
			->export();
	}
}
