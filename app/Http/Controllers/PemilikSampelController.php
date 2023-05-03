<?php

namespace App\Http\Controllers;

use App\Models\PemilikSampel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PemilikSampelController extends Controller
{
    public function dtpemiliksampel()
    {
        $data = PemilikSampel::where('status', 1)->orderBy('nama_pemilik');
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
        $title = 'Pemilik Sampel';
        return view('admin.master.pemiliksampel', compact('title'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'instansi' => 'required',
            'namapetugas' => 'required',
            'nikpetugas' => 'required',
            'nippetugas' => 'required',
            'npwppetugas' => 'required',
            'teleponpetugas' => 'required',
            'alamatinstansi' => 'required',
            'emailpetugas' => 'required|email',
            'pangkatpetugas' => 'required',
            'jabatanpetugas' => 'required',
        ]);

        $data = new PemilikSampel();

        $data->nama_pemilik = $request->instansi;
        $data->nama_petugas = $request->namapetugas;
        $data->nik_petugas = $request->nikpetugas;
        $data->nip_petugas = $request->nippetugas;
        $data->npwp_petugas = $request->npwppetugas;
        $data->telepon_petugas = $request->teleponpetugas;
        $data->email_petugas = $request->emailpetugas;
        $data->pangkat_petugas = $request->pangkatpetugas;
        $data->jabatan_petugas = $request->jabatanpetugas;
        $data->alamat_pemilik = $request->alamatinstansi;
        $data->save();

        return response(['status' => 1, 'msg' => 'Tambah data berhasil.']);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'instansi' => 'required',
            'namapetugas' => 'required',
            'nikpetugas' => 'required',
            'nippetugas' => 'required',
            'npwppetugas' => 'required',
            'teleponpetugas' => 'required',
            'alamatinstansi' => 'required',
            'emailpetugas' => 'required|email',
            'pangkatpetugas' => 'required',
            'jabatanpetugas' => 'required',
        ]);

        $data = PemilikSampel::find($id);

        $data->nama_pemilik = $request->instansi;
        $data->nama_petugas = $request->namapetugas;
        $data->nik_petugas = $request->nikpetugas;
        $data->nip_petugas = $request->nippetugas;
        $data->npwp_petugas = $request->npwppetugas;
        $data->telepon_petugas = $request->teleponpetugas;
        $data->email_petugas = $request->emailpetugas;
        $data->pangkat_petugas = $request->pangkatpetugas;
        $data->jabatan_petugas = $request->jabatanpetugas;
        $data->alamat_pemilik = $request->alamatinstansi;

        if (!$data->isDirty()) {
            return response(['status' => 0, 'msg' => 'Tidak ada perubahan data.']);
        }
        $data->save();

        return response(['status' => 1, 'msg' => 'Ubah data berhasil.']);
    }

    public function destroy($id)
    {
        PemilikSampel::destroy($id);

        return response(['status' => 1, 'msg' => 'Hapus data berhasil.']);
    }
}
