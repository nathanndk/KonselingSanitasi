<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Address;

class AddressSeeder extends Seeder
{
    public function run(): void
    {
        $addresses = [
            [
                'id' => 1,
                'street' => 'Jl. Merdeka No.1',
                'subdistrict_id' => 1,
                'district_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'street' => 'Jl. Raya Bogor KM 23',
                'subdistrict_id' => 2,
                'district_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'street' => 'Jl. Raya Serpong No.88',
                'subdistrict_id' => 3,
                'district_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($addresses as $address) {
            Address::firstOrCreate(['id' => $address['id']], $address);
        }
    }
}
