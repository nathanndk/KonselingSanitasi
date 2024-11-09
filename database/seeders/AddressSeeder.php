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
                'street' => 'Jl. Merdeka No.1',
                'subdistrict_code' => 'KD01', // Gunakan kode sesuai tabel `subdistrict`
                'district_code' => 'KC01',     // Gunakan kode sesuai tabel `district`
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'street' => 'Jl. Raya Bogor KM 23',
                'subdistrict_code' => 'KD02',
                'district_code' => 'KC02',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'street' => 'Jl. Raya Serpong No.88',
                'subdistrict_code' => 'KD03',
                'district_code' => 'KC03',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($addresses as $address) {
            Address::firstOrCreate([
                'street' => $address['street'],
                'subdistrict_code' => $address['subdistrict_code'],
                'district_code' => $address['district_code'],
            ], $address);
        }
    }
}
