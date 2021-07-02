<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ConfigController extends Controller
{
    private $title = 'Data Konfigurasi';
    private $subtitle = 'Data Konfigurasi';
    private $app = 'utilitas';
    private $idh = 'konfigurasi';

    public function index()
    {
        $data = [
            'app' => $this->app,
            'idh' => $this->idh,
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'state' => 'Index',
        ];

        return view('admin.pages.config.index', $data);
    }

    public function get_datatable()
    {
        $model = Config::select([
            '*',
        ]);
        $dt = DataTables::of($model);

        return $dt->make(true);
    }

    public function show($id)
    {
        if ($res = Config::where('guid_config', $id)->first()) {
            $data = [
                'status' => 200,
                'data' => $res,
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
        $result = Config::where('guid_config', $id)->first();

        if ($result) {
            $data = [
                'app' => $this->app,
                'idh' => $this->idh,
                'title' => $this->title,
                'subtitle' => $this->subtitle,
                'state' => 'Ubah Data',
                'data' => $result,
            ];

            return view('admin.pages.config.edit', $data);
        }

        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $object = $request->only([
            'value',
        ]);

        Validator::make($object, [
            'value' => 'required',
        ])->validate();

        $config = Config::where('guid_config', $id)->first();
        $config->value = $object['value'];
        $config->save();

        Cache::forget($config->key);

        return redirect()->route('admin.config.index', ['update_status' => 'success']);
    }
}
