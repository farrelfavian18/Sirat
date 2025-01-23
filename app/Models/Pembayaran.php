<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $fillable = [
        'id_jamaah',
        'tanggal_pembayaran',
        'jumlah_pembayaran',
        'keterangan',
        'penerima',
        'bukti_pembayaran',
    ];
    
    public function jamaah()
{
    return $this->belongsTo(Jamaah::class, 'id_jamaah');
}

}
