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

    public function show($serial)
    {
        $sensor = Sensor::where('serial', $serial)
                ->with(['model'])->first();
        return response()->json([
            'status' => 200,
            'data' => $sensor,
        ]);
    }

    public function model($serial)
    {
        $sensor = Sensor::where('serial', $serial)
                ->with(['model'])->first();
        return response()->download(public_path('storage/file/joblib/'.$sensor->model->joblib));
    }

    public function config($serial)
    {
        $config = Sensor::where('serial', $serial)
                ->with(['model'])->first()->config;
        return response()->json([
            'status' => 200,
            'data' => [
                'config' => $config,
            ],
        ]);
    }
}
