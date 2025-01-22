<?php

namespace Database\Seeders;

use App\Models\Perusahaan;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PerusahaanSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Perusahaan::create([
            'id'=> 1,
            'nama_cabang' =>'Arraudah',
            'kota_kabupaten' =>'Palembang',
            'alamat' =>'Jalan Veteran',
            'nama_pimpinan' =>'A.Farisi',
            'nib_cabang' =>'42578942',
            'pdf_nib' =>'TEST',
            'pdf_akta_cabang' =>'TEST',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Perusahaan::create([
            'id'=> 2,
            'nama_cabang' =>'Arraudah Jambi',
            'kota_kabupaten' =>'Jambi',
            'alamat' =>'Jalan Sudirman',
            'nama_pimpinan' =>'Luna',
            'nib_cabang' =>'42532323',
            'pdf_nib' =>'HAI',
            'pdf_akta_cabang' =>'HAI',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
