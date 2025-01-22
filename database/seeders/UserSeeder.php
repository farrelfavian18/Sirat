<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'=> 'superadmin',
            'id_cabang' =>1,
            'email' =>'superadmin@gmail.com',
            'role' =>'superadmin',
            'no_wa' =>'083432432432',
            'alamat' =>'Jalan Veteran',
            'email_verified_at' =>  now(),
            'password' => bcrypt('12345678')
        ]);

        User::create([
            'name'=> 'admin',
            'id_cabang' =>1,
            'email' =>'admin@gmail.com',
            'role' =>'admin',
            'no_wa' =>'08343665432',
            'alamat' =>'Jalan Limbungan',
            'email_verified_at' =>  now(),
            'password' => bcrypt('12345678')
        ]);

        User::create([
            'name'=> 'Billy',
            'id_cabang' =>1,
            'email' =>'billy@gmail.com',
            'role' =>'user',
            'no_wa' =>'0834365552',
            'alamat' =>'Jalan Tembesu',
            'email_verified_at' =>  now(),
            'password' => bcrypt('12345678')
        ]);
    }
}
