<?php

namespace App\Providers;

use App\Domains\Framework\Layout\Layouts\AuthorizedLayout\AuthorizedLayout;
use App\Domains\Framework\Page\Objects\NavigationItem;
use App\Domains\Framework\Page\Resolvers\LayoutResolver;
use App\Domains\Framework\Page\Resolvers\NavigationResolver;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        if ($this->app->isLocal()) {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }

        $this->app->singleton(LayoutResolver::class, fn() => AuthorizedLayout::make());

        $this->app->singleton(NavigationResolver::class, fn() => new NavigationResolver([
            NavigationItem::make("/acme/workflows", "Workflows"),
        ]));
    }

    public function boot(): void
    {
        Model::preventLazyLoading(!app()->isProduction());

        Date::use(CarbonImmutable::class);
    }
}
