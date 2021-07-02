<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dockerfile extends Model
{
    protected $table = 'dockerfile';

    protected $fillable = [
        'os',
        'arch',
        'dockerfile',
    ];
}
