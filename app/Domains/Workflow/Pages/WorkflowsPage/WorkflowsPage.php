<?php

namespace App\Domains\Workflow\Pages\WorkflowsPage;

use App\Domains\Framework\Page\Page;

class WorkflowsPage extends Page
{
	public function title(): string
	{
		return "Workflows";
	}

	public function route(): string
	{
		return "/workflows";
	}

	public function nodes(): array
	{
		return [];
	}
}
