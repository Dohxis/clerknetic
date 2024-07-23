<?php

namespace App\Domains\Tenancy\Resolvers;

use App\Models\Organization;
use Illuminate\Routing\Route;
use Stancl\Tenancy\Contracts\Tenant;
use Stancl\Tenancy\Exceptions\TenantCouldNotBeIdentifiedByPathException;

class PathTenantResolver extends \Stancl\Tenancy\Resolvers\PathTenantResolver
{
    public function resolveWithoutCache(...$args): Tenant
    {
        /** @var Route $route */
        $route = $args[0];

        if ($slug = $route->parameter(static::$tenantParameterName)) {
            $route->forgetParameter(static::$tenantParameterName);

            $organization = Organization::where("slug", $slug)->first();

            if (!$organization) {
                throw new TenantCouldNotBeIdentifiedByPathException($slug);
            }

            if ($tenant = tenancy()->find($organization->tenant_id)) {
                return $tenant;
            }
        }

        throw new TenantCouldNotBeIdentifiedByPathException($slug);
    }
}
