<?php

namespace App\Http\Controllers;

use App\Models\TerimaSampel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TerimaSampelController extends Controller
{
    public function dtterimasampel()
    {
        $data = TerimaSampel::with('pemiliksampel', 'kategori')
            ->where('status', 1)->orderBy('created_at');
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('created_at', function($data){
                return $data->created_at ? $data->created_at->isoFormat('D MMM Y (H:mm:ss)') : '-';
            })
            ->addColumn('no_urut', function($data){
                return '<a href='. route('detailterimasampel.index', $data->id_permintaan) .'>'.$data->no_urut_penerimaan.'</a>';
            })
            ->addColumn('actions', function ($data) {
                $btn = '<a href="#"><i class="fas fa-eye text-primary show"></i></a>';
                $btn .= '<a href="#"><i class="fas fa-pen text-info edit mx-1"></i></a>';
                $btn .= '<a href="#"><i class="fas fa-trash text-danger delete"></i></a>';
                return $btn;
            })
            ->rawColumns(['actions', 'no_urut'])
            ->toJson();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Penerimaan Sampel';
        return view('admin.master.terimasampel', compact('title'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'id_pemilik' => 'required',
            'kode_sampel' => 'required',
            'kemasan_sampel' => 'required',
            'berat_sampel' => 'required',
            'jumlah_sampel' => 'required|numeric',
            'no_urut_penerimaan' => 'required|numeric',
            'nama_sampel' => 'required',
        ]);

        $data = new TerimaSampel();

        $data->id_pemilik = $request->id_pemilik;
        $data->kode_sampel = $request->kode_sampel;
        $data->kemasan_sampel = $request->kemasan_sampel;
        $data->berat_sampel = $request->berat_sampel;
        $data->jumlah_sampel = $request->jumlah_sampel;
        $data->no_urut_penerimaan = $request->no_urut_penerimaan;
        $data->nama_sampel = $request->nama_sampel;
        $data->id_kategori = $request->id_kategori;

        $data->save();

        return response(['status' => 1, 'msg' => 'Tambah data berhasil.']);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'id_pemilik' => 'required',
            'kode_sampel' => 'required',
            'kemasan_sampel' => 'required',
            'berat_sampel' => 'required',
            'jumlah_sampel' => 'required|numeric',
            'no_urut_penerimaan' => 'required|numeric',
            'nama_sampel' => 'required',
        ]);

        $data = TerimaSampel::find($id);

        $data->id_pemilik = $request->id_pemilik;
        $data->kode_sampel = $request->kode_sampel;
        $data->kemasan_sampel = $request->kemasan_sampel;
        $data->berat_sampel = $request->berat_sampel;
        $data->jumlah_sampel = $request->jumlah_sampel;
        $data->no_urut_penerimaan = $request->no_urut_penerimaan;
        $data->nama_sampel = $request->nama_sampel;
        $data->id_kategori = $request->id_kategori;

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
        TerimaSampel::destroy($id);

        return response(['status' => 1, 'msg' => 'Hapus data berhasil.']);
    }
}
