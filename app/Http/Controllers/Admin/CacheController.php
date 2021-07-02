<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Yajra\DataTables\Facades\DataTables;

class CacheController extends Controller
{
    private $title = 'Cache Manager';
    private $subtitle = 'Cache Manager';
    private $app = 'utilitas';
    private $idh = 'cache-manager';

    public function index()
    {
        $data = [
            'app' => $this->app,
            'idh' => $this->idh,
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'state' => 'Index',
        ];

        return view('admin.pages.cache.index', $data);
    }

    public function get_datatable()
    {
        $model = $this->getData();
        $dt = DataTables::of($model);

        return $dt->make(true);
    }

    public function show($id)
    {
        if ($res = $this->getData()->where('key', $id)->first()) {
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

    public function destroy(Request $request)
    {
        if ($request->ajax()) {
            if ($this->getData()->where('key', $request->id)->count() > 0) {
                Cache::forget($request->id);
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

    private function getData()
    {
        return collect([]);
    }
}
