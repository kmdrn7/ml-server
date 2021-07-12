<?php

namespace App\Models;

use App\Models\Model as ModelML;
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
        'config',
        'dockerfile',
        'dockerfile_seer',
        'healthcheck',
        'model_id',
    ];

    public function model()
    {
        return $this->hasOne(ModelML::class, 'id', 'model_id');
    }
}
