<?php

namespace Modules\Location\database\seeders;

use Illuminate\Database\Seeder;
use Modules\Location\App\Models\Location;
use Modules\Tenant\App\Models\Tenant;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        $systemTenant = Tenant::where('subdomain', 'main')->first();
        $alphaTenant  = Tenant::where('subdomain', 'alpha')->first();
        $betaTenant   = Tenant::where('subdomain', 'beta')->first();

        $demoLocations = [
            // System HQ
            [
                'tenant_id'      => $systemTenant?->id,
                'name'           => 'Global Headquarters',
                'code'           => 'HQ-MAIN',
                'country'        => 'United States',
                'state'          => 'California',
                'city'           => 'San Francisco',
                'address_line_1' => '500 Howard Street, Suite 400',
                'address_line_2' => 'Building B',
                'postal_code'    => '94105',
                'phone'          => '+1 (415) 555-0199',
                'email'          => 'hq@saas.local',
                'is_primary'     => true,
                'status'         => 'active',
                'notes'          => 'Primary administrative headquarters.',
            ],
            [
                'tenant_id'      => $systemTenant?->id,
                'name'           => 'European Tech Hub',
                'code'           => 'HUB-EU',
                'country'        => 'United Kingdom',
                'state'          => 'England',
                'city'           => 'London',
                'address_line_1' => '25 Bank Street, Canary Wharf',
                'postal_code'    => 'E14 5JP',
                'phone'          => '+44 20 7946 0912',
                'email'          => 'london@saas.local',
                'is_primary'     => false,
                'status'         => 'active',
                'notes'          => 'European engineering and support hub.',
            ],

            // Alpha Tenant Locations
            [
                'tenant_id'      => $alphaTenant?->id,
                'name'           => 'Alpha Main Office',
                'code'           => 'ALPHA-HQ',
                'country'        => 'United States',
                'state'          => 'New York',
                'city'           => 'New York',
                'address_line_1' => '100 Broadway, 15th Floor',
                'postal_code'    => '10005',
                'phone'          => '+1 (212) 555-0143',
                'email'          => 'office@alphacorp.com',
                'is_primary'     => true,
                'status'         => 'active',
                'notes'          => 'Alpha Corporation main office.',
            ],
            [
                'tenant_id'      => $alphaTenant?->id,
                'name'           => 'Alpha Logistics Center',
                'code'           => 'ALPHA-WH1',
                'country'        => 'United States',
                'state'          => 'Texas',
                'city'           => 'Austin',
                'address_line_1' => '8200 Metropolis Drive',
                'postal_code'    => '78744',
                'phone'          => '+1 (512) 555-0188',
                'email'          => 'logistics@alphacorp.com',
                'is_primary'     => false,
                'status'         => 'active',
                'notes'          => 'Distribution and fulfillment warehouse.',
            ],

            // Beta Tenant Locations
            [
                'tenant_id'      => $betaTenant?->id,
                'name'           => 'Beta Innovation Lab',
                'code'           => 'BETA-LAB',
                'country'        => 'Germany',
                'state'          => 'Bavaria',
                'city'           => 'Munich',
                'address_line_1' => 'Leopoldstraße 120',
                'postal_code'    => '80802',
                'phone'          => '+49 89 2017 3400',
                'email'          => 'munich@betasolutions.com',
                'is_primary'     => true,
                'status'         => 'active',
                'notes'          => 'Research and development center.',
            ],
        ];

        foreach ($demoLocations as $loc) {
            Location::firstOrCreate(
                ['name' => $loc['name'], 'tenant_id' => $loc['tenant_id']],
                $loc
            );
        }
    }
}
