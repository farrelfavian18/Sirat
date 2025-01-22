<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{
    protected $fillable = [
        'id_paket',
        'id_perusahaan',
        'nama_jamaah',
        'kota_kabupaten',
        'alamat',
        'kartu_keluarga',
        'ktp',
        'no_telpon',
        'surat_kesehatan',
        'visa',
        'surat_pendukung',
    ];

    public function paket()
    {
        return $this->belongsTo(Paket::class, 'id_paket');
    }
}
