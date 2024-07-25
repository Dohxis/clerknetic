<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\CentralConnection;

/**
 *
 *
 * @property int $id
 * @property string $organization_id
 * @property string $user_id
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\Organization $organization
 * @method static \Illuminate\Database\Eloquent\Builder|OrganizationUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrganizationUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrganizationUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrganizationUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrganizationUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrganizationUser whereOrganizationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrganizationUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrganizationUser whereUserId($value)
 * @mixin \Eloquent
 */
class OrganizationUser extends Model
{
	use HasFactory;

	use CentralConnection;

	/** @var array<int, string> */
	protected $guarded = [];

	public function organization()
	{
		return $this->belongsTo(Organization::class);
	}
}
