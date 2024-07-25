<?php

namespace App\Domains\Framework\Page\Resolvers;

use App\Domains\Framework\Page\Objects\UserNavigationItem;

class UserNavigationResolver
{
    /**
     * @param array<int, UserNavigationItem> $navigationItems
     */
    public function __construct(private readonly array $navigationItems = [])
    {
        //
    }

    /**
     * @param array<int, UserNavigationItem> $navigationItems
     * @return self
     */
    public static function make(array $navigationItems = []): self
    {
        return new self($navigationItems);
    }

    /**
     * @return array<int, UserNavigationItem>
     */
    public function getNavigationItems(): array
    {
        return $this->navigationItems;
    }
}
