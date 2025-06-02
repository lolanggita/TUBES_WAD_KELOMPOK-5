<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = ['ukm_id', 'title', 'description', 'image_path'];

    public function ukm()
    {
        return $this->belongsTo(\App\Models\User::class, 'ukm_id');
    }
}