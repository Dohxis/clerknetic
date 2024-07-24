<?php

namespace App\Domains\Framework\Authentication\Pages;

use App\Domains\Framework\Authentication\Partials\SubtitleWithLoginPageLink;
use App\Domains\Framework\Component\Components\Panel;
use App\Domains\Framework\Component\Components\Text;
use App\Domains\Framework\Layout\Layout;
use App\Domains\Framework\Layout\Layouts\CentralLayout;
use App\Domains\Framework\Page\Page;

class ForgotPasswordEmailSentPage extends Page
{
	public function title(): string
	{
		return "Reset your password";
	}

	public function route(): string
	{
		return "/auth/password/sent";
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
				->setNodes([Text::make("passwords.sent")]),
		];
	}
}
