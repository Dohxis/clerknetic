<?php

namespace App\Domains\Framework\Authentication\Pages;

use App\Domains\Framework\Authentication\Forms\SignInForm;
use App\Domains\Framework\Layout\Layout;
use App\Domains\Framework\Layout\Layouts\UnauthorizedLayout\UnauthorizedLayout;
use App\Domains\Framework\Page\Page;

class SignInPage extends Page
{
	public function route(): string
	{
		return "/sign-in";
	}

	public function routeName(): string
	{
		return "sign-in";
	}

	public function title(): string
	{
		return "Sign in";
	}

	public function layout(): Layout
	{
		return UnauthorizedLayout::make()
			->setPanelTitle("Sign in to Clerknetic")
			->setPanelDescription("Don't have an account?")
			->setPanelDescriptionLinkText("Sign up")
			->setPanelDescriptionLinkHref(SignUpPage::getRoute());
	}

	public function nodes(): array
	{
		return [SignInForm::make()];
	}

	public function operations(): array
	{
		return [SignInForm::class];
	}
}
