<?php

namespace App\Models;

use App\Domains\Core\Traits\HasNamedId;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasNamedId;

    use HasFactory;

    use Notifiable;

    protected string $namedIdPrefix = "usr";

    /** @var array<int, string> */
    protected $guarded = [];

    /**  @var array<int, string> */
    protected $hidden = ["password", "remember_token"];

    /**  @return array<string, string> */
    protected function casts(): array
    {
        return [
            "email_verified_at" => "datetime",
            "password" => "hashed",
        ];
    }

    public function organizations()
    {
        return $this->belongsToMany(Organization::class)->withTimestamps();
    }
}
