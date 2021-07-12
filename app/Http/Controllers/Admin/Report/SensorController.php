<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Mongo\RealtimeResult;
use App\Models\Sensor;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Pimlie\DataTables\MongodbDataTable;

class SensorController extends Controller
{
    private $title = 'Report Sensor';
    private $subtitle = 'Reporting all data colected by sensors';
    private $app = 'report';
    private $idh = 'report-sensor';

    public function index()
    {
        $data = [
            'app' => $this->app,
            'idh' => $this->idh,
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'state' => 'Index',
        ];

        return view('admin.pages.report.sensor.index', $data);
    }

    public function get_datatable()
    {
        $model = Sensor::select([
            '*',
        ]);
        $dt = DataTables::of($model);

        return $dt->make(true);
    }

    public function show($serial)
    {
        $data = [
            'app' => $this->app,
            'idh' => $this->idh,
            'title' => "Detail Report Sensor",
            'subtitle' => "Detailed report about sensor [$serial]",
            'state' => 'Index',
            'serial' => $serial,
        ];

        return view('admin.pages.report.sensor.view', $data);
    }

    public function get_datatable_view(Request $request)
    {
        $model = RealtimeResult::where('sensor_serial', $request->serial)
        ->select([
            '*',
        ]);
        return (new MongodbDataTable($model))->toJson();
    }
}
