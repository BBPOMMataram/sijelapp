<?php

namespace App\Http\Controllers;

use App\Models\ProdukSampel;
use App\Models\StatusSampel;
use App\Models\TerimaSampel;
use App\Models\TrackingSampel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class TerimaSampelController extends Controller
{
    public function dtterimasampel()
    {
        $data = TerimaSampel::with('pemiliksampel', 'kategori')
            ->where('status', 1)->orderBy('created_at', 'desc');
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
    
    public function index()
    {
        $title = 'Penerimaan Sampel';
        return view('admin.terimasampel.terimasampel', compact('title'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'id_pemilik' => 'required',
            'kode_sampel_arr.*' => 'required',
            'kemasan_sampel' => 'required',
            'berat_sampel' => 'required',
            'jumlah_sampel' => 'required|numeric',
            'no_urut_penerimaan' => 'required|numeric',
            'nama_sampel_arr.*' => 'required',
        ]);


        $data = new TerimaSampel();

        $data->id_pemilik = $request->id_pemilik;
        $data->kemasan_sampel = $request->kemasan_sampel;
        $data->berat_sampel = $request->berat_sampel;
        $data->jumlah_sampel = $request->jumlah_sampel;
        $data->no_urut_penerimaan = $request->no_urut_penerimaan;
        $data->id_kategori = $request->id_kategori;

        $data->resi = Str::random(6);
        $data->save();
        
        $namasampel = '';
        foreach ($request->nama_sampel_arr as $i => $value) {
            $detailsampel = new ProdukSampel();
            $detailsampel->id_permintaan = $data->id_permintaan;
            $detailsampel->nama_produk = $value;
            $detailsampel->kode_sampel = $request->kode_sampel_arr[$i];
            $detailsampel->save();
            $namasampel .= $value . ', ';
        }
        
        //nama & kode sampel utk kaji ulang
        if($request->kode_sampel === $detailsampel->kode_sampel){
            $data->kode_sampel = $request->kode_sampel;
        }else{
            $data->kode_sampel = $request->kode_sampel.' - '.$detailsampel->kode_sampel;
        }
        $data->nama_sampel = substr($namasampel, 0, -2);
        $data->save();
        

        //add data for tracking sampel
        $datatracking = new TrackingSampel();
        $datatracking->id_permintaan = $data->id_permintaan;
        $datatracking->save();

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
        TrackingSampel::where('id_permintaan', $id)->delete();

        return response(['status' => 1, 'msg' => 'Hapus data berhasil.']);
    }

    public function lastnourut($idkategori)
    {
        $data = TerimaSampel::where('id_kategori', $idkategori)
        ->where('no_urut_penerimaan', 'like', '%'.now()->year)->orderByDesc('id_permintaan')->first();
        return $data;
    }
}
