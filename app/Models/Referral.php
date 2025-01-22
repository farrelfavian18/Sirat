<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    protected $fillable = [
        'id_user',
        'id_jamaah',
        'total_referals',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function referral()
    {
        return $this->belongsTo(User::class, 'id_jamaah');
    }
}
