<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perusahaan extends Model
{
    protected $fillable = [
        'nama_cabang',
        'kota_kabupaten',
        'alamat',
        'nama_pimpinan',
        'nib_cabang',
        'pdf_nib',
        'pdf_akta_cabang',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'id_cabang');
        // return $this->hasOne(Karyawan::class, 'cabang_id','id');
    }

    // Relasi ke tabel `pakets`
    public function pakets()
    {
        return $this->hasMany(Paket::class, 'id_perusahaan');
    }
}
