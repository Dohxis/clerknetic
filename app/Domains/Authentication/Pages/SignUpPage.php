<?php

namespace App\Domains\Authentication\Pages;

use App\Domains\Authentication\Forms\SignUpForm;
use App\Domains\Framework\Layout\Layout;
use App\Domains\Framework\Layout\Layouts\UnauthorizedLayout\UnauthorizedLayout;
use App\Domains\Framework\Page\Page;

class SignUpPage extends Page
{
	public function route(): string
	{
		return "/sign-up";
	}

	public function title(): string
	{
		return "Sign up";
	}

	public function layout(): Layout
	{
		return UnauthorizedLayout::make()
			->setPanelTitle("Create your account")
			->setPanelDescription("Already have an account?")
			->setPanelDescriptionLinkText("Sign in")
			->setPanelDescriptionLinkHref(SignInPage::getRoute());
	}

	public function nodes(): array
	{
		return [SignUpForm::make()];
	}

	public function operations(): array
	{
		return [SignUpForm::class];
	}
}
