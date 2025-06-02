<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends Model
{
    use HasFactory;

    // Kolom yang boleh di‐mass‐assignment
    protected $fillable = [
        'title',
        'description',
        'start_time',
        'end_time',
        'is_registrable',
        'created_by',
    ];

    /**
     * Relasi ke User (creator/admin yang membuat event).
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Relasi ke EventRegistration (jika user mendaftar).
     */
    public function registrations()
    {
        return $this->hasMany(EventRegistration::class);
    }

    /**
     * Relasi ke Comment (jika ada komentar di event).
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
