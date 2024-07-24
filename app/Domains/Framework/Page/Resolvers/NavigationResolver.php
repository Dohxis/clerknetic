<?php

namespace App\Domains\Framework\Page\Resolvers;

use App\Domains\Framework\Page\Objects\NavigationItem;

class NavigationResolver
{
	/**
	 * @param array<int, NavigationItem> $navigationItems
	 */
	public function __construct(private readonly array $navigationItems = [])
	{
		//
	}

	/**
	 * @param array<int, NavigationItem> $navigationItems
	 * @return self
	 */
	public static function make(array $navigationItems = []): self
	{
		return new self($navigationItems);
	}

	/**
	 * @return array<int, NavigationItem>
	 */
	public function getNavigationItems(): array
	{
		return $this->navigationItems;
	}
}
