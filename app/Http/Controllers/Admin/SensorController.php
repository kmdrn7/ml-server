<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\InputValidator;
use App\Http\Controllers\Controller;
use App\Models\Sensor;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class SensorController extends Controller
{
    private $title = 'Sensor';
    private $subtitle = 'Data Sensor';
    private $app = 'master';
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
        ]);

        Sensor::create([
            'serial' => Str::uuid(),
            'name' => $input->name,
            'status' => 1,
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
        ]);

        $model = Sensor::where('id', $id)->first();
        $model->name = $input->name;
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
