<?php

namespace App\Http\Controllers\Admin\Laporan;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PesanController extends Controller
{
    private $title = 'Laporan Pesan';
    private $subtitle = 'Data laporan pesan';
    private $app = 'report';
    private $idh = 'laporan-pesan';

    public function index()
    {
        $data = [
            'app' => $this->app,
            'idh' => $this->idh,
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'state' => 'Index',
        ];

        return view('admin.pages.laporan.pesan.index', $data);
    }

    public function get_datatable()
    {
        $model = Message::select([
            '*',
        ]);
        $dt = DataTables::of($model);

        return $dt->make(true);
    }

    public function show($id)
    {
        if ($res = Message::where('guid_message', $id)->first()) {
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
            $model = Message::where('guid_message', $request->id)->first();
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
