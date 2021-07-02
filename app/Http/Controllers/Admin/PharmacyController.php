<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Alinamed\Graphql;
use App\Helpers\Alinamed\InputValidator;
use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Pharmacy;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class PharmacyController extends Controller
{
    private $title = 'Klinik';
    private $subtitle = 'Klinik';
    private $app = 'master';
    private $idh = 'data-klinik';

    private function getQueryHashedPassword ($password) {
        return <<<GQL
        query {
            hashedPassword(password: "$password")
        }
        GQL;
    }

    public function index()
    {
        $data = [
            'app' => $this->app,
            'idh' => $this->idh,
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'state' => 'Index'
        ];

        return view('admin.pages.pharmacy.index', $data);
    }

    public function get_datatable()
    {
        $model = Pharmacy::select([
            '*',
        ])->oldest();
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
            'state' => 'Tambah Data'
        ];

        return view('admin.pages.pharmacy.insert', $data);
    }

    public function store(Request $request)
    {
        $input = InputValidator::validateRequest($request, [
            'name' => 'required|unique:alinamed.Pharmacy,name',
            'alpha' => 'required|unique:alinamed.Account,alpha',
            'beta' => 'required',
            'address' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'phone' => 'required',
        ]);

        $response = Graphql::sendRequest($this->getQueryHashedPassword($request->beta));
        $beta = $response->data->hashedPassword;
        $serial = Str::uuid();
        Account::create([
            'serial' => $serial,
            'alpha' => $input->alpha,
            'beta' => $beta,
        ]);
        Pharmacy::create([
            'serial' => $serial,
            'name' => $input->name,
            'address' => $input->address,
            'latitude' => $input->latitude,
            'longitude' => $input->longitude,
            'phone' => $input->phone,
        ]);

        return redirect()->route('admin.pharmacy.index', ['input_status' => 'success']);
    }

    public function show($id)
    {
        if ($res = Pharmacy::where('serial', $id)->first()) {
            $account = Account::select(['alpha'])->where('serial', $id)->first();
            $data = [
                'status' => 200,
                'data' => [
                    'res' => $res,
                    'account' => $account,
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
        $result = Pharmacy::where('serial', $id)->first();
        $account = Account::select(['alpha'])->where('serial', $id)->first();

        if ($result) {
            $data = [
                'app' => $this->app,
                'idh' => $this->idh,
                'title' => $this->title,
                'subtitle' => $this->subtitle,
                'state' => 'Ubah Data',
                'data' => $result,
                'account' => $account,
            ];

            return view('admin.pages.pharmacy.edit', $data);
        }

        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $input = InputValidator::validateRequest($request, [
            'name' => 'required',
            'alpha' => 'required',
            'address' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'phone' => 'required',
        ]);

        $model = Pharmacy::where('serial', $id)->first();
        $account = Account::where('serial', $id)->first();
        $model->name = $input->name;
        $model->address = $input->address;
        $model->latitude = $input->latitude;
        $model->longitude = $input->longitude;
        $model->phone = $input->phone;
        $account->alpha = $input->alpha;
        if($request->beta){
            $response = Graphql::sendRequest($this->getQueryHashedPassword($request->beta));
            $account->beta = $response->data->hashedPassword;
        }
        $model->save();
        $account->save();

        return redirect()->route('admin.pharmacy.index', ['update_status' => 'success']);
    }

    public function destroy(Request $request)
    {
        if ($request->ajax()) {
            $pharmacy = Pharmacy::where('serial', $request->id)->first();
            $account = Account::where('serial', $request->id)->first();
            if ($pharmacy->delete() && $account->delete()) {
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
