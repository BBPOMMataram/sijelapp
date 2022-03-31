<?php

namespace App\Http\Controllers;

use App\Models\ParameterUji;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ParameterUjiController extends Controller
{
    public function dtparameteruji()
    {
        $data = ParameterUji::with('metodeuji')
            ->where('status', 1)
            ->orderBy('parameter_uji');
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function ($data) {
                $btn = '<a href="#"><i class="fas fa-eye text-primary show"></i></a>';
                $btn .= '<a href="#"><i class="fas fa-pen text-info edit mx-1"></i></a>';
                // $btn .= '<a href="#"><i class="fas fa-trash text-danger delete"></i></a>';
                return $btn;
            })
            ->rawColumns(['actions'])
            ->toJson();
    }
    
    public function index()
    {
        $title = 'Metode Uji';
        return view('admin.master.parameteruji', compact('title'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'namaparameter' => 'required',
            'metode' => 'required',
            // 'kode' => 'required',
        ]);

        $data = new ParameterUji();

        $data->parameter_uji = $request->namaparameter;
        $data->id_kode_layanan = $request->metode;
        $data->kode = $request->kode;
        $data->save();

        return response(['status' => 1, 'msg' => 'Tambah data berhasil.']);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'namaparameter' => 'required',
            'metode' => 'required',
            // 'kode' => 'required',
        ]);

        $data = ParameterUji::find($id);

        $data->parameter_uji = $request->namaparameter;
        $data->id_kode_layanan = $request->metode;
        $data->kode = $request->kode;

        if (!$data->isDirty()) {
            return response(['status' => 0, 'msg' => 'Tidak ada perubahan data.']);
        }
        $data->save();

        return response(['status' => 1, 'msg' => 'Ubah data berhasil.']);
    }
    
    public function destroy($id)
    {
        ParameterUji::destroy($id);

        return response(['status' => 1, 'msg' => 'Hapus data berhasil.']);
    }
}
