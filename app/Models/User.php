<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    // konstanta role
    const ROLE_ADMIN = 'administrator';
    const ROLE_UKM = 'ukm';
    const ROLE_MAHASISWA = 'mahasiswa';
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'ukm_id',
        'is_verified'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_verified' => 'boolean',
            'password' => 'hashed',
        ];
    }
    public function isAdmin() {
        return $this->role === 'administrator';
    }

    public function isUkm() {
        return $this->role === 'ukm';
    }

    public function isMahasiswa() {
        return $this->role === 'mahasiswa';
    }
}
