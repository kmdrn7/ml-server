<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    protected $table = 'sensor';
    protected $primaryKey = 'id';

    protected $fillable = [
        'serial',
        'name',
        'status',
        'os',
        'arch',
        'dockerfile',
        'healthcheck'
    ];
}
