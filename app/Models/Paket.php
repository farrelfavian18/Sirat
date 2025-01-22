<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
    protected $fillable = [
        'nama_paket',
        'tanggal_kepulangan',
        'tanggal_keberangkatan',
        'hotel_madinah',
        'hotel_mekkah',
        'program',
        'harga',
        'pesawat',
        'total_seat',
        'jenis_paket'
    ];
    
    public function jamaahs()
    {
        return $this->hasMany(Jamaah::class, 'id_paket');
    }

    public function fasilitas()
    {
        return $this->hasMany(Fasilitas::class, 'id_paket');
    }

}
