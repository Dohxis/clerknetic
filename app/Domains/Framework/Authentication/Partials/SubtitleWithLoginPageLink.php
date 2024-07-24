<?php

namespace App\Domains\Framework\Authentication\Partials;

use App\Domains\Framework\Component\Components\Link\Link;
use App\Domains\Framework\Component\Components\Text;

class SubtitleWithLoginPageLink
{
	public static function make(): Text
	{
		return Text::make(
			"Or ",
			Link::make()
				->setTitle("login to existing account")
				->setLink(route("login"))
		);
	}
}
