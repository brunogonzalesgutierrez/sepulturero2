<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use Notifiable, SoftDeletes, HasRoles;

    protected $fillable = ['empleado_id', 'cliente_id', 'username', 'email', 'password', 'estado', 'intentos_fallidos', 'bloqueado_hasta', 'two_factor_secret', 'two_factor_enabled',];

    protected $hidden = ['password', 'remember_token', 'two_factor_secret',];

    protected $casts = [
        'bloqueado_hasta' => 'datetime',
        'password'        => 'hashed',
        'two_factor_enabled' => 'boolean',
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    // Para login por username en vez de email
    public function getAuthIdentifierName()
    {
        return 'username';
    }

}
