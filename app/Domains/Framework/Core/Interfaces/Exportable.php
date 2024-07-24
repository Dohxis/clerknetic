<?php

namespace App\Domains\Framework\Core\Interfaces;

interface Exportable
{
	/**
	 * @return array<mixed>
	 */
	public function export(): array;
}
