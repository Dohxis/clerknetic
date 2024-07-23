<?php

namespace App\Domains\Core\Utilities;

use Illuminate\Support\Str;

class IdUtility
{
	public static function generateId(): string
	{
		return Str::lower(Str::ulid());
	}

	public static function generateNamedId(string $idName): string
	{
		return $idName . "_" . IdUtility::generateId();
	}
}
