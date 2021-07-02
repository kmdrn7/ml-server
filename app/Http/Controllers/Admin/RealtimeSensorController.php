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
    private $app = 'realtime-sensor';
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

    public function getDiskInfo()
    {
        $total = Cache::remember('disk_size', 60 * 24, function () {
            return Config::where('key', 'disk_size')->first()->value;
        });
        $homedir = config('app.home');
        $process = Process::fromShellCommandline('du -sc '.$homedir." | awk 'NR==1 { print $1 }'");
        $process->run();
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        $output = $process->getOutput();
        $result = str_replace("\n", '', $output);
        $result = (int) $result / 1000;

        return response()->json([
            'dipakai' => number_format($result, 0, ',', '.'),
            'sisa' => number_format($total - $result, 0, ',', '.'),
            'raw' => [
                'dipakai' => $result,
                'sisa' => $total - $result,
            ],
        ]);
    }
}
