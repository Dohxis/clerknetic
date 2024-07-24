<?php

namespace App\Domains\Framework\Authentication\Pages;

use App\Domains\Framework\Authentication\Forms\LoginForm;
use App\Domains\Framework\Component\Components\Link\Link;
use App\Domains\Framework\Component\Components\Panel;
use App\Domains\Framework\Component\Components\Text;
use App\Domains\Framework\Layout\Layout;
use App\Domains\Framework\Layout\Layouts\CentralLayout;
use App\Domains\Framework\Page\Page;

class LoginPage extends Page
{
	public function route(): string
	{
		return "/auth/login";
	}

	public function routeName(): string
	{
		return "login";
	}

	public function title(): string
	{
		return "Login to your account";
	}

	public function layout(): Layout
	{
		$layout = CentralLayout::make()->setTitle($this->title());

		if (AuthenticationPages::isRegistrationEnabled()) {
			$layout->setSubtitle(
				Text::make(
					"Or ",
					Link::make()
						->setTitle("create new account")
						->toPage(RegisterPage::class)
				)
			);
		}

		return $layout;
	}

	public function nodes(): array
	{
		return [
			Panel::make()
				->setPadding(10)
				->setNodes([LoginForm::make()]),
		];
	}

	public function operations(): array
	{
		return [LoginForm::class];
	}
}
