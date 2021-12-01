<?php

namespace App\Http\Controllers;

use App\Models\ProdukSampel;
use App\Models\TerimaSampel;
use App\Models\UjiProduk;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DetailTerimaSampelController extends Controller
{
    public function dtdetailterimasampel($id)
    {
        $data = ProdukSampel::with('ujiproduk', 'ujiproduk.parameter', 'ujiproduk.parameter.metodeuji')
            ->where('id_permintaan', $id);
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function () {
                $btn = '<a href="#"><i class="fas fa-eye text-primary show"></i></a>';
                $btn .= '<a href="#"><i class="fas fa-pen text-info edit mx-1"></i></a>';
                $btn .= '<a href="#"><i class="fas fa-trash text-danger delete"></i></a>';
                return $btn;
            })
            ->rawColumns(['actions'])
            ->toJson();
    }

    public function index($id)
    {
        $permintaan = TerimaSampel::find($id);
        $title = 'Detail Penerimaan Sampel<br>'.'<b>'.$permintaan->kategori->nama_kategori.'</b>'.' (' . $permintaan->no_urut_penerimaan . ')';
        return view('admin.terimasampel.detailterimasampel', compact('title', 'id'));
    }

    public function store(Request $request, $id_permintaan)
    {
        $this->validate($request, [
            'nama_produk' => 'required',
            'kode_sampel' => 'required',
        ]);

        //handle when kode sampel duplicate
        $duplicateSampel = ProdukSampel::where([
            'id_permintaan' => $id_permintaan,
            'kode_sampel' => $request->kode_sampel
        ])->first();

        if ($duplicateSampel) {
            return response(['status' => 0, 'msg' => 'Kode sampel sudah ada.', 'data' => $duplicateSampel]);
        }

        $data = new ProdukSampel;

        $data->id_permintaan = $id_permintaan;
        $data->nama_produk = $request->nama_produk;
        $data->kode_sampel = $request->kode_sampel;

        $data->save();

        $newIdProdukSampel = $data->id_produk_sampel;

        return response(['status' => 1, 'msg' => 'Tambah data berhasil.', 'newId' => $newIdProdukSampel]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nama_produk' => 'required',
            'kode_sampel' => 'required',
        ]);

        $data = ProdukSampel::find($id);

        $data->nama_produk = $request->nama_produk;
        $data->kode_sampel = $request->kode_sampel;

        // if(!$data->isDirty()){
        //     return response(['status' => 0, 'msg' => 'Tidak ada perubahan data.']);
        // }
        $data->save();

        return response(['status' => 1, 'msg' => 'Ubah data berhasil.']);
    }

    public function destroy($id)
    {
        ProdukSampel::destroy($id);

        return response(['status' => 1, 'msg' => 'Hapus data berhasil.']);
    }

    // detail terima sampel
    public function deleteparameteruji($id)
    {
        UjiProduk::destroy($id);

        return response(['status' => 1, 'msg' => 'Auto saved.']);
    }

    public function storeparameteruji(Request $request, $id_produk_sampel)
    {
        $this->validate($request, [
            'id_parameter' => 'required',
            'jumlah_pengujian' => 'required|numeric|min:1',
        ], [], [
            'id_parameter' => "Parameter Uji"
        ]);
        $oldData = UjiProduk::where([
            'id_produk_sampel' => $id_produk_sampel,
            'id_parameter' => $request->id_parameter,
        ])->first();

        if ($oldData) { //jika parameter uji sama maka tambah jumlah pengujian saja
            $data = UjiProduk::find($oldData->id_uji_produk);
            $data->jumlah_pengujian += $request->jumlah_pengujian;
        } else {
            $data = new UjiProduk();
            $data->id_produk_sampel = $id_produk_sampel;
            $data->id_parameter = $request->id_parameter;
            $data->jumlah_pengujian = $request->jumlah_pengujian;
        }
        $data->save();

        return response(['status' => 1, 'msg' => 'Auto saved.']);
    }

    public function datadetailparameteruji($id)
    {
        $data = UjiProduk::with(['parameter', 'parameter.metodeuji'])->where('id_produk_sampel', $id)->get();
        return $data;
    }

    public function printkajiulang($id)
    {
        $title = 'Kaji Ulang Sampel';
        $permintaan = TerimaSampel::find($id);
        $produksampel = ProdukSampel::with(['ujiproduk','ujiproduk.parameter', 'ujiproduk.parameter.metodeuji'])->where('id_permintaan', $id)->get();

        return view('prints.kajiulang', compact('title', 'permintaan', 'produksampel'));
    }

    public function printfplp($id)
    {
        $title = 'FPLP BADAN POM';
        $permintaan = TerimaSampel::find($id);
        $produksampel = ProdukSampel::with(['ujiproduk', 'ujiproduk.parameter.metodeuji'])->where('id_permintaan', $id)->get();

        return view('prints.fplp', compact('title', 'permintaan', 'produksampel'));
    }
}
