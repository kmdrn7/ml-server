<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller
{
    private $title = 'Data Admin';
    private $subtitle = 'Data Admin';
    private $app = 'utilitas';
    private $idh = 'data-admin';

    public function index()
    {
        $data = [
            'app' => $this->app,
            'idh' => $this->idh,
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'state' => 'Index',
        ];

        return view('admin.pages.admin.index', $data);
    }

    public function get_datatable()
    {
        $model = Admin::select([
            '*',
        ]);
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

        return view('admin.pages.admin.insert', $data);
    }

    public function store(Request $request)
    {
        $object = $request->only([
            'nama',
            'email',
            'password',
            'password_confirmation',
        ]);

        Validator::make($object, [
            'nama' => 'required',
            'email' => 'required|unique:admin,email',
            'password' => 'required|confirmed',
        ])->validate();

        Admin::create([
            'serial' => Str::uuid(),
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.admin.index', ['input_status' => 'success']);
    }

    public function show($id)
    {
        if ($res = Admin::where('id_admin', $id)->first()) {
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
        $result = Admin::where('id_admin', $id)->first();

        if ($result) {
            $data = [
                'app' => $this->app,
                'idh' => $this->idh,
                'title' => $this->title,
                'subtitle' => $this->subtitle,
                'state' => 'Ubah Data',
                'data' => $result,
            ];

            return view('admin.pages.admin.edit', $data);
        }

        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $object = $request->only([
            'nama',
            'email',
        ]);

        Validator::make($object, [
            'nama' => 'required',
            'email' => 'required',
        ])->validate();

        Admin::where('id_admin', $id)->update([
            'nama' => $request->nama,
            'email' => $request->email,
        ]);

        if ('on' == $request->input('is_password')) {
            Admin::where('id_admin', $id)->update([
                'password' => Hash::make($request->input('password')),
            ]);
        }

        return redirect()->route('admin.admin.index', ['update_status' => 'success']);
    }

    public function destroy(Request $request)
    {
        if ($request->ajax()) {
            if (Admin::where('id_admin', $request->id)->delete()) {
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
