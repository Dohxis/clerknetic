<?php

namespace App\Domains\Framework\Form\Traits;

use App\Arpite\OperationStore;

trait HasStore
{
	protected OperationStore $store;

	final protected function initStore(): void
	{
		$this->store = new OperationStore();
	}
}
