<?php

namespace App\Providers;

use App\Domains\Framework\Authentication\Pages\SignInPage;
use App\Domains\Framework\Layout\Layouts\AuthorizedLayout\AuthorizedLayout;
use App\Domains\Framework\Page\Objects\NavigationItem;
use App\Domains\Framework\Page\Resolvers\LayoutResolver;
use App\Domains\Framework\Page\Resolvers\NavigationResolver;
use App\Models\OrganizationUser;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
	public function register(): void
	{
		if ($this->app->isLocal()) {
			$this->app->register(
				\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class
			);
		}

		$this->app->singleton(
			LayoutResolver::class,
			fn() => AuthorizedLayout::make()
		);

		$this->app->singleton(
			NavigationResolver::class,
			fn() => new NavigationResolver([
				NavigationItem::make("/acme/workflows", "Workflows"),
			])
		);
	}

	public function boot(): void
	{
		Model::preventLazyLoading(!app()->isProduction());

		Date::use(CarbonImmutable::class);
	}

	public static function getHomepage(): string
	{
		/** @var User|null $user */
		$user = Auth::user();

		if ($user === null) {
			return SignInPage::getRoute();
		}

		$organizationUser = OrganizationUser::whereUserId($user->id)->first();

		$organizationSlug = $organizationUser->organization->slug;

		return "/" . $organizationSlug . "/workflows";
	}
}
