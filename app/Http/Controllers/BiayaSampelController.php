<?php

namespace App\Http\Controllers;

use App\Models\BiayaSampel;
use App\Models\JenisSampel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class BiayaSampelController extends Controller
{
    public function index()
    {
        $title = 'Biaya Uji';
        return view('admin.master.biayauji', compact('title'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'namaparameter' => 'required',
            'metode' => 'required',
        ]);

        $data = new ParameterUji();

        $data->parameter_uji = $request->namaparameter;
        $data->id_kode_layanan = $request->metode;
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
            'namaparameter' => 'required',
            'metode' => 'required',
        ]);

        $data = ParameterUji::find($id);

        $data->parameter_uji = $request->namaparameter;
        $data->id_kode_layanan = $request->metode;

        if (!$data->isDirty()) {
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
        ParameterUji::destroy($id);

        return response(['status' => 1, 'msg' => 'Hapus data berhasil.']);
    }

    public function dtbiayauji()
    {
        $data = BiayaSampel::all();
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

    public function dtjenissampel()
    {
        $data = JenisSampel::all();
        return DataTables::of($data)
            ->addIndexColumn()
            ->toJson();
    }

    public function dthargaproduk($id = null)
    {
        $data = DB::table('harga_produk')->get();
        if ($id) {
            $data = DB::table('harga_produk')->where('id_produk', $id)->get();
        }
        return DataTables::of($data)
            ->addIndexColumn()
            ->rawColumns(['keterangan'])
            ->toJson();
    }
    
}