<?php

namespace App\Domains\Framework\Component;

use App\Domains\Framework\Core\Interfaces\Exportable;

abstract class Component implements Exportable
{
	/**
	 * @return array<mixed>
	 */
	abstract public function export(): array;

	/**
	 * @deprecated use ternary operator instead
	 *
	 * @param bool $show
	 * @return array<int, static>
	 */
	public function show(bool $show)
	{
		if ($show) {
			return [$this];
		}

		return [];
	}
}
