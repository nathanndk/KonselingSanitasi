<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Address;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $addresses = [
            [
                'street' => 'Jl. Merdeka No.1',
                'subdistrict' => 'Gambir',
                'district' => 'Jakarta Pusat',
                'city' => 'Jakarta',
                'province' => 'DKI Jakarta',
            ],
            [
                'street' => 'Jl. Raya Bogor KM 23',
                'subdistrict' => 'Cimanggis',
                'district' => 'Depok',
                'city' => 'Depok',
                'province' => 'Jawa Barat',
            ],
            [
                'street' => 'Jl. Raya Serpong No.88',
                'subdistrict' => 'Serpong',
                'district' => 'Tangerang Selatan',
                'city' => 'Tangerang Selatan',
                'province' => 'Banten',
            ],
        ];

        foreach ($addresses as $address) {
            Address::create($address);
        }
    }
}
