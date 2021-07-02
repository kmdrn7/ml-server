<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Config;
use App\Models\Sensor;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class DashboardController extends Controller
{
    private $title = 'Dashboard';
    private $subtitle = 'Halaman dashboard';
    private $app = 'dashboard';
    private $idh = 'dashboard';

    public function root()
    {
        return redirect(config('app.admin_url').'/dashboard');
    }

    public function index()
    {
        $count = [
            'sensor' => Sensor::count(),
        ];

        $data = [
            'app' => $this->app,
            'idh' => $this->idh,
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'count' => $count,
        ];

        return view('admin.pages.dashboard', $data);
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
