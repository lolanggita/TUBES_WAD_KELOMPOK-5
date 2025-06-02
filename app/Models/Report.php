<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $table = 'reports';

    protected $fillable = [
        'judul',
        'deskripsi',
        'tanggal',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
