<?php

namespace App\Models;

use App\Domains\Core\Traits\HasNamedId;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
	use HasFactory;

	use HasNamedId;

	protected string $namedIdPrefix = "org";

	/** @var array<int, string> */
	protected $guarded = [];
}
