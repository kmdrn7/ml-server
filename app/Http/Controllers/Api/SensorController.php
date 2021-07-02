<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sensor;

class SensorController extends Controller
{
    public function healthz($sensorSerial)
    {
        Sensor::where("serial", $sensorSerial)->update([
            "status" => 1,
            "last_healthcheck" => now(),
        ]);

        return response()->json([
            'status' => 'OK',
        ], 200);
    }
}
