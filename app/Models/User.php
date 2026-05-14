<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'no_hp',
        'spesialisasi',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relasi: pasien yang ditangani sebagai DPJP
    public function patients()
    {
        return $this->hasMany(Patient::class, 'dpjp_id');
    }

    // Relasi: pasien yang diinput oleh user ini
    public function inputtedPatients()
    {
        return $this->hasMany(Patient::class, 'created_by');
    }

    public function isDokter(): bool
    {
        return in_array($this->role, ['dokter', 'admin']);
    }

    public function isPerawat(): bool
    {
        return in_array($this->role, ['perawat', 'admin']);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}
