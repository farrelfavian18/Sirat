<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{
    protected $fillable = [
        'id_perusahaans',
        'id_users',
        'keterangan',
        'dokumen_surat',
        'note',
    ];

    public function perusahaan()
    {
        return $this->belongsTo(Paket::class, 'id_perusahaans');
    }
    public function users()
    {
        return $this->belongsTo(User::class, 'id_users');
    }
}
