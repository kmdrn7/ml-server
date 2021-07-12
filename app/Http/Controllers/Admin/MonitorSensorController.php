<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Config;
use App\Models\Sensor;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

use function PHPSTORM_META\map;

class MonitorSensorController extends Controller
{
    private $title = 'Monitor Sensor';
    private $subtitle = 'Monitoring all sensor in realtime';
    private $app = 'dashboard';
    private $idh = 'monitor-sensor';

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

        return view('admin.pages.monitor-sensor.index', $data);
    }

    public function data($os, $arch)
    {
        if ($os == "all") $os = "";
        if ($arch == "all") $arch = "";
        $sensors = Sensor::where('os', 'like', "%$os%")->where('arch', 'like', "%$arch%")->get();
        return response()->json([
            'status' => 200,
            'data' => $sensors,
        ]);
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
