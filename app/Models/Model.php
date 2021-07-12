<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;

class Model extends BaseModel
{
    protected $table = 'model';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'name',
        'features',
        'joblib',
        'scaler',
    ];
}
