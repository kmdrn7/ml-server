<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppVersion extends Model
{
    protected $table = 'AppVersion';
    protected $primaryKey = 'appID';
    protected $connection = 'alinamed';

    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'appID',
        'version',
    ];
}
