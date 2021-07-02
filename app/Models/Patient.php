<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $table = 'Patient';
    protected $primaryKey = 'serial';
    protected $connection = 'alinamed';

    public $incrementing = false;
    public $timestamps = false;

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    protected $fillable = [
        'name',
        'nik',
    ];
}
