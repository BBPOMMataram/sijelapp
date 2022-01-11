<?php

namespace App\Http\Controllers;

use App\Models\PerihalSurat;
use App\Models\ProdukSampel;
use App\Models\TerimaSampel;
use App\Models\UjiProduk;
use App\Models\User;
use App\Models\Wadah1;
use App\Models\Wadah2;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class DetailTerimaSampelController extends Controller
{
    public function dtdetailterimasampel($id)
    {
        $data = ProdukSampel::with('ujiproduk', 'ujiproduk.parameter', 'ujiproduk.parameter.metodeuji', 'user')
            ->where('id_permintaan', $id);
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('tanggal_surat', function($data){
                // return $data->tanggal_surat ? $data->tanggal_surat->isoFormat('D MMM Y') : '-';
                return $data->tanggal_surat ? $data->tanggal_surat->isoFormat('Y-M-D') : '-';
            })
            ->addColumn('actions', function ($data) {
                $btn = '<a href="#"><i class="fas fa-pen text-info edit"></i></a>';
                $btn .= '<a href="'.route('print.basegel', $data->id_produk_sampel).'" target="_blank"><i class="fas fa-print text-primary mx-2 basegel"></i></a>';
                $btn .= '<a href="'.route('print.bapenimbangan', $data->id_produk_sampel).'" target="_blank"><i class="fas fa-print text-danger bapenimbangan"></i></a>';

                if ($data->lhu) {
                    $btn .= '<a href="'. route('download.lhu', $data->lhu) .'"><i class="fas fa-download text-success ml-2 downloadlhu"></i></a>';
                }
                return $btn;
            })
            ->addColumn('download', function ($data) {
                $btn = '-';

                if ($data->lhu) {
                    $btn = '<a href="'. route('download.lhu', $data->lhu) .'"><i class="fas fa-download text-success ml-2"></i></a>';
                }
                return $btn;
            })
            ->rawColumns(['actions', 'download'])
            ->toJson();
    }

    public function index($id)
    {
        $permintaan = TerimaSampel::find($id);
        $title = 'Detail Penerimaan Sampel<br>' . '<b>' . $permintaan->kategori->nama_kategori . '</b>' . ' (' . $permintaan->no_urut_penerimaan . ')';

        $wadah1 = Wadah1::all();
        $wadah2 = Wadah2::all();
        $perihal = PerihalSurat::all();

        return view('admin.terimasampel.detailterimasampel', compact('title', 'id', 'wadah1', 'wadah2', 'perihal'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nama_produk' => 'required',
            'p_uji' => 'required',
            'p_uji.*' => 'required',
            'j_uji.*' => 'required',
        ]);

        $produksampel = ProdukSampel::whereIn('id_produk_sampel', $request->nama_produk);
        foreach ($produksampel->get() as $value) {
            $produksampel->update([
                'nomor_surat' => $request->nomor_surat,
                'tanggal_surat' => $request->tanggal_surat,
                'perihal' => $request->perihal,
                'tersangka' => $request->tersangka,
                'wadah1' => $request->wadah1,
                'wadah2' => $request->wadah2,
        ]);

            foreach ($request->p_uji as $i => $v) {
                $data = new UjiProduk();
                $data->id_produk_sampel = $value->id_produk_sampel;
                $data->id_parameter = $v;
                $data->jumlah_pengujian = $request->j_uji[$i];
                $data->save();
            }
        }
        // dd($request->all());
        // //handle when kode sampel duplicate
        // $duplicateSampel = ProdukSampel::where([
        //     'id_permintaan' => $id_permintaan,
        //     'kode_sampel' => $request->kode_sampel
        // ])->first();

        // if ($duplicateSampel) {
        //     return response(['status' => 0, 'msg' => 'Kode sampel sudah ada.', 'data' => $duplicateSampel]);
        // }

        // $data = new ProdukSampel;

        // $data->id_permintaan = $id_permintaan;
        // $data->nama_produk = $request->nama_produk;
        // $data->kode_sampel = $request->kode_sampel;

        // $data->save();

        // $newIdProdukSampel = $data->id_produk_sampel;

        return response(['status' => 1, 'msg' => 'Update data berhasil.']);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nama_produk' => 'required',
            // 'kode_sampel' => 'required',
        ]);

        $data = ProdukSampel::find($id);

        $data->nama_produk = $request->nama_produk;
        $data->nomor_surat = $request->nomor_surat;
        $data->tanggal_surat = $request->tanggal_surat;
        $data->perihal = $request->perihal;
        $data->tersangka = $request->tersangka;
        $data->wadah1 = $request->wadah1;
        $data->wadah2 = $request->wadah2;

        // $data->kode_sampel = $request->kode_sampel;

        // if(!$data->isDirty()){
        //     return response(['status' => 0, 'msg' => 'Tidak ada perubahan data.']);
        // }
        $data->save();

        $kajiulang = TerimaSampel::find($data->id_permintaan);

        $datasampel = ProdukSampel::where('id_permintaan', $data->id_permintaan)->get();

        $newnamasampel = '';
        foreach ($datasampel as $value) {
            $newnamasampel .= $value->nama_produk . ', ';
        }

        $kajiulang->nama_sampel = substr($newnamasampel, 0, -2);
        $kajiulang->save();

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
        $produksampel = ProdukSampel::with(['ujiproduk', 'ujiproduk.parameter', 'ujiproduk.parameter.metodeuji'])->where('id_permintaan', $id)->get();

        return view('prints.kajiulang', compact('title', 'permintaan', 'produksampel'));
    }

    public function printfplp($id)
    {
        $title = 'FPLP BADAN POM';
        $permintaan = TerimaSampel::find($id);
        $produksampel = ProdukSampel::with(['ujiproduk', 'ujiproduk.parameter.metodeuji'])->where('id_permintaan', $id)->get();

        return view('prints.fplp', compact('title', 'permintaan', 'produksampel'));
    }

    public function printbasegel($id)
    {

        // FUNGSI TERBILANG OLEH : MALASNGODING.COM
        // WEBSITE : WWW.MALASNGODING.COM
        // AUTHOR : https://www.malasngoding.com/author/admin

        function penyebut($nilai)
        {
            $nilai = abs($nilai);
            $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
            $temp = "";
            if ($nilai < 12) {
                $temp = " " . $huruf[$nilai];
            } else if ($nilai < 20) {
                $temp = penyebut($nilai - 10) . " belas";
            } else if ($nilai < 100) {
                $temp = penyebut($nilai / 10) . " puluh" . penyebut($nilai % 10);
            } else if ($nilai < 200) {
                $temp = " seratus" . penyebut($nilai - 100);
            } else if ($nilai < 1000) {
                $temp = penyebut($nilai / 100) . " ratus" . penyebut($nilai % 100);
            } else if ($nilai < 2000) {
                $temp = " seribu" . penyebut($nilai - 1000);
            } else if ($nilai < 1000000) {
                $temp = penyebut($nilai / 1000) . " ribu" . penyebut($nilai % 1000);
            } else if ($nilai < 1000000000) {
                $temp = penyebut($nilai / 1000000) . " juta" . penyebut($nilai % 1000000);
            } else if ($nilai < 1000000000000) {
                $temp = penyebut($nilai / 1000000000) . " milyar" . penyebut(fmod($nilai, 1000000000));
            } else if ($nilai < 1000000000000000) {
                $temp = penyebut($nilai / 1000000000000) . " trilyun" . penyebut(fmod($nilai, 1000000000000));
            }
            return $temp;
        }

        function terbilang($nilai)
        {
            if ($nilai < 0) {
                $hasil = "minus " . trim(penyebut($nilai));
            } else {
                $hasil = trim(penyebut($nilai));
            }
            return $hasil;
        }

        $day = now()->dayName;
        $date = now()->day;
        $month = now()->monthName;
        $year = now()->year;

        $tglterbilang = ucwords($day . ' Tanggal ' . terbilang($date) . ' Bulan ' . $month . ' Tahun ' . terbilang($year));

        $title = 'BA PEMBUKAAN SEGEL BARANG BUKTI';
        $produksampel = ProdukSampel::with(['ujiproduk', 'ujiproduk.parameter.metodeuji', 'permintaan.kategori', 'permintaan.pemiliksampel'])->find($id);
        // $permintaan = TerimaSampel::with('pemiliksampel')->find($produksampel->id_permintaan);
        // $produksampel->tanggal_surat = $produksampel->tanggal_surat->isoFormat('D MMM Y');
        $users = User::all();
        
        return view('prints.basegel', compact('title', 'produksampel', 'tglterbilang', 'users'));
    }

    public function printbapenimbangan($id)
    {
        function penyebut($nilai)
        {
            $nilai = abs($nilai);
            $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
            $temp = "";
            if ($nilai < 12) {
                $temp = " " . $huruf[$nilai];
            } else if ($nilai < 20) {
                $temp = penyebut($nilai - 10) . " belas";
            } else if ($nilai < 100) {
                $temp = penyebut($nilai / 10) . " puluh" . penyebut($nilai % 10);
            } else if ($nilai < 200) {
                $temp = " seratus" . penyebut($nilai - 100);
            } else if ($nilai < 1000) {
                $temp = penyebut($nilai / 100) . " ratus" . penyebut($nilai % 100);
            } else if ($nilai < 2000) {
                $temp = " seribu" . penyebut($nilai - 1000);
            } else if ($nilai < 1000000) {
                $temp = penyebut($nilai / 1000) . " ribu" . penyebut($nilai % 1000);
            } else if ($nilai < 1000000000) {
                $temp = penyebut($nilai / 1000000) . " juta" . penyebut($nilai % 1000000);
            } else if ($nilai < 1000000000000) {
                $temp = penyebut($nilai / 1000000000) . " milyar" . penyebut(fmod($nilai, 1000000000));
            } else if ($nilai < 1000000000000000) {
                $temp = penyebut($nilai / 1000000000000) . " trilyun" . penyebut(fmod($nilai, 1000000000000));
            }
            return $temp;
        }

        function terbilang($nilai)
        {
            if ($nilai < 0) {
                $hasil = "minus " . trim(penyebut($nilai));
            } else {
                $hasil = trim(penyebut($nilai));
            }
            return $hasil;
        }

        $day = now()->dayName;
        $date = now()->day;
        $month = now()->monthName;
        $year = now()->year;

        $tglterbilang = ucwords($day . ' Tanggal ' . terbilang($date) . ' Bulan ' . $month . ' Tahun ' . terbilang($year));

        $title = 'BA PENIMBANGAN BARANG BUKTI';
        $produksampel = ProdukSampel::with(['ujiproduk', 'ujiproduk.parameter.metodeuji', 'permintaan.kategori', 'permintaan.pemiliksampel'])->find($id);
        $users = User::all();
        
        return view('prints.bapenimbangan', compact('title', 'produksampel', 'tglterbilang', 'users'));
    }
}
