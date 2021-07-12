<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\InputValidator;
use App\Http\Controllers\Controller;
use App\Models\Dockerfile;
use App\Models\Model;
use App\Models\Sensor;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class SensorProcessingController extends Controller
{
    private $title = 'Sensor Processing';
    private $subtitle = 'Run processing to all datas collected by sensor to run prediction';
    private $app = 'management';
    private $idh = 'sensor-processing';

    public function index()
    {
        $data = [
            'app' => $this->app,
            'idh' => $this->idh,
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'state' => 'Index',
        ];

        return view('admin.pages.sensor-processing.index', $data);
    }

    public function get_datatable(Request $request)
    {
        $model = Sensor::select([
            '*',
        ])
        ->where("os", "like", "%$request->os%")
        ->where("arch", "like", "%$request->arch%")
        ->with(['model'])
        ->latest();
        $dt = DataTables::of($model);

        return $dt->make(true);
    }

    public function edit($id)
    {
        $result = Sensor::where('id', $id)->first();
        $model = Model::get();

        if ($result) {
            $data = [
                'app' => $this->app,
                'idh' => $this->idh,
                'title' => $this->title,
                'subtitle' => $this->subtitle,
                'state' => 'Ubah Data',
                'data' => $result,
                'model' => $model,
            ];

            return view('admin.pages.sensor-processing.edit', $data);
        }

        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $input = InputValidator::validateRequest($request, [
            'model' => 'required',
        ]);

        $sensor = Sensor::where('id', $id)->first();
        $sensor->model_id = $input->model;
        $sensor->save();

        return redirect()->route('admin.sensor-processing.index', ['update_status' => 'success']);
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
