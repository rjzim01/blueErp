<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;

class User extends Authenticatable implements FilamentUser
{
    use Notifiable;

    protected $table = 'tb_users';

    protected $fillable = [
        'name',
        'mobile',
        'username',
        'email',
        'password',
        'role',
        'group_id',
        'outlet',
        'active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'p_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'active' => 'boolean',
        ];
    }
    
    public function canAccessPanel(\Filament\Panel $panel): bool
    {
        return true;
    }
}