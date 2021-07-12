<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\FileHelper;
use App\Helpers\InputValidator;
use App\Http\Controllers\Controller;
use App\Models\Dockerfile;
use App\Models\Model;
use App\Models\Sensor;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class MLModelController extends Controller
{
    private $title = 'Machine Learning Model';
    private $subtitle = 'Train machine learning model and upload here to start predicting using it';
    private $app = 'management';
    private $idh = 'ml-model';

    public function index()
    {
        $data = [
            'app' => $this->app,
            'idh' => $this->idh,
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'state' => 'Index',
        ];

        return view('admin.pages.ml-model.index', $data);
    }

    public function get_datatable(Request $request)
    {
        $model = Model::select([
            '*',
        ])->latest();
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

        return view('admin.pages.ml-model.insert', $data);
    }

    public function store(Request $request)
    {
        $input = InputValidator::validateRequest($request, [
            'name' => 'required|unique:model,name',
            'scaler' => 'required',
            'joblib' => 'required',
            'features' => 'required',
        ]);

        $filename = '';
        $serial = Str::uuid();
        if ($request->file('joblib')) {
            try {
                $filename = FileHelper::rawUpload(
                    $request->file('joblib'),
                    'file/joblib',
                    $serial,
                );
            } catch (\Throwable $th) {
                return redirect()->back()->withErrors([
                    'img' => 'Terjadi kesalahan ketika menyimpan data'
                ])->withInput((array)$input);
            }
        }

        Model::create([
            'name' => $request->name,
            'features' => $request->features,
            'scaler' => $request->scaler,
            'joblib' => $filename,
        ]);

        return redirect()->route('admin.ml-model.index', ['input_status' => 'success']);
    }

    public function show($id)
    {
        if ($res = Model::where('id', $id)->first()) {
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
        $result = Model::where('id', $id)->first();

        if ($result) {
            $data = [
                'app' => $this->app,
                'idh' => $this->idh,
                'title' => $this->title,
                'subtitle' => $this->subtitle,
                'state' => 'Ubah Data',
                'data' => $result,
            ];

            return view('admin.pages.ml-model.edit', $data);
        }

        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $input = InputValidator::validateRequest($request, [
            'name' => 'required',
            'scaler' => 'required',
            'features' => 'required',
        ]);

        $model = Model::where('id', $id)->first();
        if ($request->file('joblib')) {
            FileHelper::delete('file/joblib/' . $model->joblib);
            try {
                $model->joblib = FileHelper::rawUpload(
                    $request->file('joblib'),
                    'file/joblib',
                    $model->id,
                );
            } catch (\Throwable $th) {
                return redirect()->back()->withErrors([
                    'img' => 'Terjadi kesalahan ketika menyimpan data'
                ])->withInput($request->all());
            }
        }
        $model->name = $request->name;
        $model->scaler = $input->scaler;
        $model->features = $input->features;
        $model->save();

        return redirect()->route('admin.ml-model.index', ['update_status' => 'success']);
    }

    public function destroy(Request $request)
    {
        if ($request->ajax()) {
            $model = Model::where('id', $request->id)->first();
            FileHelper::delete('file/joblib/' . $model->joblib);
            if ($model->delete()) {
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
