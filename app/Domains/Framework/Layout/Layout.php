<?php

namespace App\Domains\Framework\Layout;

use App\Domains\Framework\Core\Interfaces\Exportable;

abstract class Layout implements Exportable
{
	/**
	 * @return static
	 */
	abstract public static function make();
}
