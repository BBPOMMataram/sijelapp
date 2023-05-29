<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInstansiRequest;
use App\Http\Requests\UpdateInstansiRequest;
use App\Models\InstansiPemilikSampel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class InstansiPemilikSampelController extends Controller
{
    public function index()
    {
        $title = 'Instansi Pemilik Sampel';
        return view('admin.instansi_pemilik.index', compact('title'));
    }

    public function store(StoreInstansiRequest $request)
    {
        $data = new InstansiPemilikSampel();
        $data->nama = $request->nama;
        $data->alamat = $request->alamat;

        $data->save();

        return response()->json([
            "status" => 1,
            "msg" => "Saved",
            "data" => $data,
        ]);
    }

    public function update(UpdateInstansiRequest $request, InstansiPemilikSampel $instansipemilik)
    {
        $instansipemilik->nama = $request->nama;
        $instansipemilik->alamat = $request->alamat;

        if (!$instansipemilik->isDirty()) {
            return response(['status' => 0, 'msg' => 'No data changed']);
        }

        $instansipemilik->save();
        return response(['status' => 1, 'msg' => 'Updated']);
    }

    public function destroy($id)
    {
        $data = InstansiPemilikSampel::find($id);
        $data->delete();

        return response(['status' => 1, 'msg' => 'Removed']);
    }

    public function instansipemilik_dt()
    {
        $data = InstansiPemilikSampel::latest();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function ($data) {
                $btn = '<a href="#"><i class="fas fa-eye text-primary show"></i></a>';
                $btn .= '<a href="#"><i class="fas fa-pen text-info edit mx-1"></i></a>';
                if ($data->level !== 0) {
                    $btn .= '<a href="#"><i class="fas fa-trash text-danger delete"></i></a>';
                }
                return $btn;
            })
            ->rawColumns(['actions'])
            ->toJson();
    }
}
