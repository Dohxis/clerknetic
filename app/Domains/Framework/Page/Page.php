<?php

namespace App\Domains\Framework\Page;

use App\Domains\Framework\Component\Component;
use App\Domains\Framework\Core\Traits\HasRegisterRoutes;
use App\Domains\Framework\Core\Traits\HasResolveHelpers;
use App\Domains\Framework\Core\Utilities\ExportBuilder;
use App\Domains\Framework\Core\Utilities\RouteUtility;
use App\Domains\Framework\Form\Operation;
use App\Domains\Framework\Layout\Layout;
use App\Domains\Framework\Layout\Layouts\AuthorizedLayout\AuthorizedLayout;
use App\Domains\Framework\Page\Resolvers\LayoutResolver;
use App\Domains\Framework\Page\Resolvers\NavigationResolver;
use App\Domains\Framework\Responses\StructuredPageResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Inertia\Response;

abstract class Page extends Controller
{
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	use HasRegisterRoutes;
	use HasResolveHelpers;

	abstract public function title(): string;

	abstract public function route(): string;

	/**
	 * @return Component[]
	 */
	abstract public function nodes(): array;

	public function routeName(): ?string
	{
		return null;
	}

	/**
	 * @return string[]
	 */
	public function operations(): array
	{
		return [];
	}

	/**
	 * @return Component[]
	 */
	public function actions(): array
	{
		return [];
	}

	public function layout(): Layout
	{
		/**
		 * @var Layout|LayoutResolver $layout
		 */
		$layout = app(LayoutResolver::class);

		if ($layout instanceof LayoutResolver) {
			return AuthorizedLayout::make();
		}

		return $layout;
	}

	/**
	 * @return array{route: string, title: string, activeMatch: string}[]
	 */
	public function navigation(): array
	{
		$navigation = app(NavigationResolver::class);

		return ExportBuilder::exportArray($navigation->getNavigationItems());
	}

	public static function getRoute(): string
	{
		$page = new static();

		return $page->route();
	}

	public static function getRouteName(): string
	{
		$page = new static();

		return $page->routeName();
	}

	protected function getPageTitle(): string
	{
		return $this->title();
	}

	/**
	 * @return array<int, array{
	 *     title: string,
	 *     count: int|null,
	 *     icon: string|null,
	 *     link: string,
	 *     active: bool
	 * }>
	 */
	protected function getTabs(): array
	{
		return [];
	}

	protected function getTabsDesign(): ?string
	{
		return null;
	}

	public function handleRequest(): Response
	{
		return StructuredPageResponse::make()
			->setTitle($this->getPageTitle())
			->setLayout($this->layout())
			->setTabs($this->getTabs())
			->setTabsDesign($this->getTabsDesign())
			->setNodes($this->nodes())
			->export();
	}

	public function registerRoutes(): void
	{
		foreach ($this->operations() as $operationClass) {
			/** @var Operation $operation */
			$operation = new $operationClass();

			$operation::register();
		}

		$routeName = $this->routeName();

		$route = RouteUtility::get(
			$this->route(),
			fn() => $this->handleRequest()
		);

		if ($routeName !== null) {
			$route->name($routeName);
		}
	}
}
