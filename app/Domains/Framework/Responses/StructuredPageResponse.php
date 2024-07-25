<?php

namespace App\Domains\Framework\Responses;

use App\Domains\Framework\Component\Traits\HasNodes;
use App\Domains\Framework\Component\Traits\HasTitle;
use App\Domains\Framework\Core\Utilities\ExportBuilder;
use App\Domains\Framework\Layout\Layout;
use App\Domains\Framework\Layout\Layouts\AuthorizedLayout\AuthorizedLayout;
use App\Domains\Framework\Page\Resolvers\LayoutResolver;
use App\Domains\Framework\Page\Resolvers\NavigationResolver;
use App\Domains\Framework\Page\Resolvers\UserNavigationResolver;
use Inertia\Inertia;
use Inertia\Response;

class StructuredPageResponse
{
	use HasTitle;
	use HasNodes;

	private Layout|null $layout = null;

	/**
	 * @var array<int, array{
	 *     title: string,
	 *     count: int|null,
	 *     icon: string|null,
	 *     link: string,
	 *     active: bool
	 * }> $tabs
	 */
	private array $tabs = [];

	private string|null $tabsDesign = null;

	public static function make(): self
	{
		return new self();
	}

	/**
	 * @param Layout|null $layout
	 * @return static
	 */
	public function setLayout(Layout|null $layout)
	{
		$this->layout = $layout;

		return $this;
	}

	/**
	 * @param array<int, array{
	 *     title: string,
	 *     count: int|null,
	 *     icon: string|null,
	 *     link: string,
	 *     active: bool
	 * }> $tabs
	 * @return static
	 */
	public function setTabs(array $tabs)
	{
		$this->tabs = $tabs;

		return $this;
	}

	/**
	 * @param string|null $tabsDesign
	 * @return static
	 */
	public function setTabsDesign(string|null $tabsDesign)
	{
		$this->tabsDesign = $tabsDesign;

		return $this;
	}

	private function getLayout(): Layout
	{
		if ($this->layout !== null) {
			return $this->layout;
		}

		/** @var Layout|LayoutResolver $layout */
		$layout = app(LayoutResolver::class);

		if ($layout instanceof LayoutResolver) {
			return AuthorizedLayout::make();
		}

		return $layout;
	}

	/**
	 * @return array<int, mixed>
	 */
	private function getNavigation(): array
	{
		$navigation = app(NavigationResolver::class);

		return ExportBuilder::exportArray($navigation->getNavigationItems());
	}

	/**
	 * @return array<int, mixed>
	 */
	private function getUserNavigation(): array
	{
		$navigation = app(UserNavigationResolver::class);

		return ExportBuilder::exportArray($navigation->getNavigationItems());
	}

	public function export(): Response
	{
		return Inertia::render("StructuredPage", [
			"layout" => $this->getLayout()->export(),
			"layoutProperties" => [
				"title" => __($this->title),
				"navigation" => $this->getNavigation(),
				"userNavigation" => $this->getUserNavigation(),
				"tabs" => $this->tabs,
				"tabsDesign" => $this->tabsDesign,
			],
			"nodes" => ExportBuilder::exportArray($this->nodes),
		]);
	}
}
