<?php

namespace App\Domains\Framework\Authentication\Pages;

use App\Domains\Framework\Authentication\Forms\RegisterForm;
use App\Domains\Framework\Authentication\Partials\SubtitleWithLoginPageLink;
use App\Domains\Framework\Component\Components\Panel;
use App\Domains\Framework\Layout\Layout;
use App\Domains\Framework\Layout\Layouts\CentralLayout;
use App\Domains\Framework\Page\Page;

class RegisterPage extends Page
{
	public function route(): string
	{
		return "/auth/register";
	}

	public function title(): string
	{
		return "Create new account";
	}

	public function layout(): Layout
	{
		return CentralLayout::make()
			->setTitle($this->title())
			->setSubtitle(SubtitleWithLoginPageLink::make());
	}

	public function nodes(): array
	{
		return [
			Panel::make()
				->setPadding(10)
				->setNodes([RegisterForm::make()]),
		];
	}

	public function operations(): array
	{
		return [RegisterForm::class];
	}
}
