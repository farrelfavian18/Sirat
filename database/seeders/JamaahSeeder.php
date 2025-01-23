<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jamaah;
use Faker\Factory as Faker;

class JamaahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) { 
            Jamaah::create([
                'id_paket' => rand(1, 2), 
                'id_perusahaan' => rand(1, 2), 
                'nama_jamaah' => $faker->name,
                'alamat' => $faker->address,
                'kartu_keluarga' => $faker->word . '.jpg',
                'ktp' => $faker->word . '.jpg',
                'no_telpon' => $faker->phoneNumber,
                'surat_kesehatan' => $faker->word . '.pdf',
                'visa' => $faker->word . '.pdf',
                'surat_pendukung' => $faker->word . '.pdf',
            ]);
        }
    }
}
