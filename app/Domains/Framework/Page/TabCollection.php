<?php

namespace App\Domains\Framework\Page;

use App\Domains\Framework\Component\Components\Tabs\Enums\TabsDesign;
use App\Domains\Framework\Core\Traits\HasRegisterRoutes;

abstract class TabCollection
{
	use HasRegisterRoutes;

	public string $tabsDesign = TabsDesign::REGULAR;

	abstract public function title(): string;

	/**
	 * @return array<int, class-string<TabPage>>
	 */
	abstract public function tabs(): array;

	public function registerRoutes(): void
	{
		foreach ($this->tabs() as $tabClass) {
			$tabClass::register();
		}
	}
}
