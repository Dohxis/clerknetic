<?php

namespace Database\Seeders;

use App\Domains\Tenancy\Models\Tenant;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $tenant = Tenant::create([]);

        Organization::create([
            'slug' => 'acme',
            'name' => 'Acme Inc.',
            'tenant_id' => $tenant->id,
        ]);

        Tenant::all()->runForEach(function () {
            User::factory()->create([
                'name' => 'John Doe',
                'email' => 'test@example.com',
            ]);
        });
    }
}
