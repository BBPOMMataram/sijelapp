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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Pemilik Sampel';
        return view('admin.master.pemiliksampel', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'instansi' => 'required',
            'namapetugas' => 'required',
            'teleponpetugas' => 'required',
            'alamatinstansi' => 'required',
        ]);

        $data = new PemilikSampel();

        $data->nama_pemilik = $request->instansi;
        $data->nama_petugas = $request->namapetugas;
        $data->telepon_petugas = $request->teleponpetugas;
        $data->alamat_pemilik = $request->alamatinstansi;
        $data->save();

        return response(['status' => 1, 'msg' => 'Tambah data berhasil.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'instansi' => 'required',
            'namapetugas' => 'required',
            'teleponpetugas' => 'required',
            'alamatinstansi' => 'required',
        ]);

        $data = PemilikSampel::find($id);

        $data->nama_pemilik = $request->instansi;
        $data->nama_petugas = $request->namapetugas;
        $data->telepon_petugas = $request->teleponpetugas;
        $data->alamat_pemilik = $request->alamatinstansi;
        if(!$data->isDirty()){
            return response(['status' => 0, 'msg' => 'Tidak ada perubahan data.']);
        }
        $data->save();

        return response(['status' => 1, 'msg' => 'Ubah data berhasil.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        PemilikSampel::destroy($id);

        return response(['status' => 1, 'msg' => 'Hapus data berhasil.']);
    }
}
