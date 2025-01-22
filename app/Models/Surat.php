<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{
    protected $fillable = [
        'id_perusahaan',
        'id_user',
        'keterangan',
        'dokumen_surat',
        'note',
    ];

    public function perusahaan()
    {
        return $this->belongsTo(Paket::class, 'id_perusahaan');
    }
    public function users()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
