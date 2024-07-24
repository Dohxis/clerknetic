<?php

namespace App\Domains\Framework\Layout;

use Arpite\Core\Interfaces\Exportable;

abstract class Layout implements Exportable
{
	/**
	 * @return static
	 */
	abstract public static function make();
}
