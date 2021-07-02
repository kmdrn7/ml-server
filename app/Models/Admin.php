<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    public $incrementing = false;

    protected $table = 'admin';
    protected $primaryKey = 'id_admin';
    protected $guard = 'admin';

    protected $fillable = [
        'serial',
        'nama',
        'email',
        'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower($value);
    }

    public function getEmailAttribute($value)
    {
        return strtolower($value);
    }
}
