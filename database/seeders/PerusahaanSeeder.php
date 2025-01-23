<?php

namespace Database\Seeders;

use App\Models\Perusahaan;
use App\Models\Paket;
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

        Paket::create([
            'nama_paket' => 'Umroh1',
            'tanggal_kepulangan'=> '2022-01-21',
            'tanggal_keberangkatan'=> '2022-01-24',
            'hotel_madinah'=> 'Madin',
            'hotel_mekkah'=> 'Madin',
            'program'=> 'Program Pusat',
            'harga'=> 10000000,
            'pesawat'=> 'Garuda',
            'total_seat'=> 2,
            'jenis_paket'=> 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Paket::create([
            'nama_paket' => 'Umroh2',
            'tanggal_kepulangan'=> '2022-01-21',
            'tanggal_keberangkatan'=> '2022-01-24',
            'hotel_madinah'=> 'Mekkah',
            'hotel_mekkah'=> 'Madinah',
            'program'=> 'Program Pusat',
            'harga'=> 20000000,
            'pesawat'=> 'Garuda',
            'total_seat'=> 2,
            'jenis_paket'=> 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
