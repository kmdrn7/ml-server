<?php

namespace App\Models\Mongo;

use Jenssegers\Mongodb\Eloquent\Model as BaseModel;

class RealtimeResult extends BaseModel
{
    protected $connection = 'mongodb';
    protected $collection = 'realtime_result';

    protected $fillable = [
        'sensor_serial',
        'src_ip',
        'src_port',
        'dst_ip',
        'dst_port',
        'protocol',
        'timestamp',
        'prediction'
    ];
}
