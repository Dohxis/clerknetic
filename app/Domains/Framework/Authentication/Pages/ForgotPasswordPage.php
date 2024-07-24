<?php

namespace App\Domains\Framework\Authentication\Pages;

use App\Domains\Framework\Authentication\Forms\ForgotPasswordForm;
use App\Domains\Framework\Authentication\Partials\SubtitleWithLoginPageLink;
use App\Domains\Framework\Component\Components\Panel;
use App\Domains\Framework\Layout\Layout;
use App\Domains\Framework\Layout\Layouts\CentralLayout;
use App\Domains\Framework\Page\Page;

class ForgotPasswordPage extends Page
{
	public function title(): string
	{
		return "Reset your password";
	}

	public function route(): string
	{
		return "/auth/password/forgot";
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
				->setNodes([ForgotPasswordForm::make()]),
		];
	}

	public function operations(): array
	{
		return [ForgotPasswordForm::class];
	}
}
