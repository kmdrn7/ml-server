<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $table = 'Account';
    protected $primaryKey = 'serial';
    protected $connection = 'alinamed';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'serial',
        'alpha',
        'beta',
    ];
}
