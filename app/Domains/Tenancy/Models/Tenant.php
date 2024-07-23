<?php

namespace App\Domains\Tenancy\Models;

use App\Domains\Core\Traits\HasNamedId;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;

class Tenant extends BaseTenant implements TenantWithDatabase
{
	use HasNamedId;

	use HasDatabase;

	protected string $namedIdPrefix = "tnt";
}
