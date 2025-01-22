<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jamaah extends Model
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

    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class, 'id_perusahaan');
    }
    
    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class, 'id_jamaah');
    }
}
