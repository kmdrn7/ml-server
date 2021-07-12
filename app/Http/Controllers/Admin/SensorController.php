<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\InputValidator;
use App\Http\Controllers\Controller;
use App\Models\Dockerfile;
use App\Models\Sensor;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class SensorController extends Controller
{
    private $title = 'Sensor';
    private $subtitle = 'Data Sensor';
    private $app = 'management';
    private $idh = 'data-sensor';

    public function index()
    {
        $data = [
            'app' => $this->app,
            'idh' => $this->idh,
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'state' => 'Index',
        ];

        return view('admin.pages.sensor.index', $data);
    }

    public function get_datatable(Request $request)
    {
        $model = Sensor::select([
            '*',
        ])
        ->where("os", "like", "%$request->os%")
        ->where("arch", "like", "%$request->arch%")
        ->latest();
        $dt = DataTables::of($model);

        return $dt->make(true);
    }

    public function create()
    {
        $data = [
            'app' => $this->app,
            'idh' => $this->idh,
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'state' => 'Tambah Data',
        ];

        return view('admin.pages.sensor.insert', $data);
    }

    public function store(Request $request)
    {
        $input = InputValidator::validateRequest($request, [
            'name' => 'required|unique:sensor,name',
            'os' => 'required',
            'arch' => 'required',
        ]);

        $serial = Str::uuid();
        $dockerfile = Dockerfile::where('os', $request->os)
            ->where('arch', $request->arch)
            ->where('key', 'depulso')
            ->first()->dockerfile;
        $dockerfile = str_replace(" ##\n", " $serial\n", $dockerfile);
        $dockerfile = str_replace(" ###\n", " $request->interface\n", $dockerfile);
        $dockerfile = str_replace(" ####\n", " $request->kafka_topic\n", $dockerfile);
        $dockerfile = str_replace(" #####\n", " $request->kafka_host\n", $dockerfile);
        $dockerfile = str_replace(" ######\n", " $request->kafka_port\n", $dockerfile);
        $dockerfile = str_replace(" #######", " $request->mlserver", $dockerfile);

        $dockerfile_seer = Dockerfile::where('os', $request->os)
            ->where('arch', $request->arch)
            ->where('key', 'seer')
            ->first()->dockerfile;
        $dockerfile_seer = str_replace(" ##\n", " $serial\n", $dockerfile_seer);
        $dockerfile_seer = str_replace(" ####\n", " $request->mlserver", $dockerfile_seer);
        $dockerfile_seer = str_replace(" #####\n", " $request->kafka_topic\n", $dockerfile_seer);
        $dockerfile_seer = str_replace(" ######\n", " $request->kafka_host\n", $dockerfile_seer);
        $dockerfile_seer = str_replace(" #######\n", " $request->kafka_port\n", $dockerfile_seer);
        $dockerfile_seer = str_replace(" ########\n", " $request->kafka_client\n", $dockerfile_seer);
        $dockerfile_seer = str_replace(" #########\n", " $request->kafka_group\n", $dockerfile_seer);

        $config = json_encode([
            'LISTEN_INTERFACE' => $request->interface,
            'MLSERVER_URL' => $request->mlserver,
            'KAFKA_HOST' => $request->kafka_host,
            'KAFKA_PORT' => $request->kafka_port,
            'KAFKA_TOPIC' => $request->kafka_topic,
            'KAFKA_GROUP' => $request->kafka_group,
        ]);

        Sensor::create([
            'serial' => $serial,
            'name' => $input->name,
            'os' => $input->os,
            'arch' => $input->arch,
            'config' => $config,
            'status' => 0,
            'dockerfile' => $dockerfile,
            'dockerfile_seer' => $dockerfile_seer,
        ]);

        return redirect()->route('admin.sensor.index', ['input_status' => 'success']);
    }

    public function show($id)
    {
        if ($res = Sensor::where('id', $id)->first()) {
            $data = [
                'status' => 200,
                'data' => [
                    'res' => $res,
                ],
                'msg' => 'Data ditemukan',
            ];
        } else {
            $data = [
                'status' => 500,
                'data' => '',
                'msg' => 'Data tidak ada',
            ];
        }

        return response($data);
    }

    public function edit($id)
    {
        $result = Sensor::where('id', $id)->first();

        if ($result) {
            $data = [
                'app' => $this->app,
                'idh' => $this->idh,
                'title' => $this->title,
                'subtitle' => $this->subtitle,
                'state' => 'Ubah Data',
                'data' => $result,
            ];

            return view('admin.pages.sensor.edit', $data);
        }

        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $input = InputValidator::validateRequest($request, [
            'name' => 'required',
            'os' => 'required',
            'arch' => 'required',
        ]);

        $config = json_encode([
            'LISTEN_INTERFACE' => $request->interface,
            'MLSERVER_URL' => $request->mlserver,
            'KAFKA_HOST' => $request->kafka_host,
            'KAFKA_PORT' => $request->kafka_port,
            'KAFKA_TOPIC' => $request->kafka_topic,
            'KAFKA_GROUP' => $request->kafka_group,
        ]);

        $model = Sensor::where('id', $id)->first();
        $model->name = $input->name;
        $model->os = $input->os;
        $model->arch = $input->arch;
        $model->config = $config;
        $model->save();

        return redirect()->route('admin.sensor.index', ['update_status' => 'success']);
    }

    public function destroy(Request $request)
    {
        if ($request->ajax()) {
            $pharmacy = Sensor::where('id', $request->id)->first();
            if ($pharmacy->delete()) {
                $data = [
                    'status' => 200,
                    'msg' => 'Data deleted successfully',
                ];
            } else {
                $data = [
                    'status' => 500,
                    'msg' => "Can't delete data",
                ];
            }
        } else {
            $data = [
                'status' => 404,
                'msg' => 'Not a post ajax request',
            ];
        }

        return response($data);
    }
}
