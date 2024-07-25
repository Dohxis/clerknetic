<?php

namespace Database\Seeders;

use App\Domains\Tenancy\Models\Tenant;
use App\Models\Organization;
use App\Models\OrganizationUser;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $tenant = Tenant::create(['id' => 'tnt_01j3fhd5m8fcy9n6xmnyqkfr27']);

        $organization = Organization::create([
            'slug' => 'acme',
            'name' => 'Acme Inc.',
            'tenant_id' => $tenant->id,
        ]);

        $globalUser = User::create([
            'email' => 'test@example.com'
        ]);

        OrganizationUser::create([
            'organization_id' => $organization->id,
            'user_id' => $globalUser->id,
        ]);

        $tenant->run(function () use ($globalUser) {
            User::factory()->create([
                'id' => $globalUser->id,
                'email' => $globalUser->email,
                'name' => 'John Doe',
            ]);
        });
    }
}
