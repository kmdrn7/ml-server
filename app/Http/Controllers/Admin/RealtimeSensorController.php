<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Config;
use App\Models\Sensor;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class RealtimeSensorController extends Controller
{
    private $title = 'Realtime Sensor';
    private $subtitle = 'Menunjukkan data sensor secara realtime';
    private $app = 'dashboard';
    private $idh = 'realtime-sensor';

    public function index()
    {
        $sensor = Sensor::all();

        $data = [
            'app' => $this->app,
            'idh' => $this->idh,
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'sensor' => $sensor,
        ];

        return view('admin.pages.realtime-sensor.index', $data);
    }

    public function show($serial)
    {
        $sensor = Sensor::where('serial', $serial)->first();
        return response()->json([
            'status' => 200,
            'data' => $sensor,
        ]);
    }

}
