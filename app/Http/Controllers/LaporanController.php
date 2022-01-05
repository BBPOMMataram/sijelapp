<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\ProdukSampel;
use App\Models\TerimaSampel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class LaporanController extends Controller
{
    public function jumlahsampel()
    {
        $title = 'LAPORAN';
        return view('admin.laporan.jumlahsampel', compact('title'));
    }

    public function dtjumlahsampel()
    {
        $data = TerimaSampel::with(['kategori']);
        return DataTables::of($data)
            ->addIndexColumn()
            ->toJson();
    }

    public function dtrekapsampel()
    {
        // $data = ProdukSampel::with(
        //     [
        //         'ujiproduk',
        //         'ujiproduk.parameter',
        //         'ujiproduk.parameter.metodeuji',
        //         'permintaan.pemiliksampel' => function($query){
        //             // $query->where('permintaan.id_kategori', 1);
        //         },
        //         'permintaan.tracking' => function($query){
        //             // $query->where('permintaan.id_kategori', 1);
        //         },
        //         'permintaan.kategori' => function($query){
        //             $query->where('kategori.id_kategori', 1);
        //         },
        //         'permintaan' => function($query){
        //             $query->where('permintaan.id_kategori', 1);
        //         },
        //         'user',
        //     ],
        // )
        // ->orderBy('id_permintaan', 'desc');

            $data = TerimaSampel::with('kategori', 'pemiliksampel', 'tracking', 'produksampel.ujiproduk.parameter.metodeuji', 'produksampel.user')
            ->latest();
            
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('tanggalterima', function ($data) {
                if (isset($data->created_at)) {
                    return $data->created_at->isoFormat('D MMM Y (H:mm:ss)');
                } elseif (isset($data->tanggal_terima)) {
                    return $data->tanggal_terima->isoFormat('D MMM Y (H:mm:ss)');
                } else {
                    return '-';
                }
            })
            ->addColumn('tanggalestimasi', function ($data) {
                if (isset($data->tracking->tanggal_estimasi)) {
                    return $data->tracking->tanggal_estimasi->isoFormat('D MMM Y');
                } else {
                    return '-';
                }
            })
            ->addColumn('tanggalselesaiuji', function ($data) {
                if (isset($data->tracking->tanggal_selesai_uji)) {
                    return $data->tracking->tanggal_selesai_uji->isoFormat('D MMM Y (H:mm:ss)');
                } else {
                    return '-';
                }
            })
            ->addColumn('tanggallegalisir', function ($data) {
                if (isset($data->tracking->tanggal_legalisir)) {
                    return $data->tracking->tanggal_legalisir->isoFormat('D MMM Y (H:mm:ss)');
                } else {
                    return '-';
                }
            })
            ->addColumn('selesaidalamhari', function ($data) {
                if (isset($data->tracking->tanggal_legalisir)) {
                    $tgl_legalisir = $data->tracking->tanggal_legalisir;
                    if (isset($data->created_at)) {
                        $count = $tgl_legalisir->diffForHumans($data->created_at);
                        return $count;
                    } elseif (isset($data->tanggal_terima)) {
                        $count = $tgl_legalisir->diffForHumans($data->tanggal_terima);
                        return $count;
                    }
                } else {
                    return '-';
                }
            })
            ->addColumn('tandaterima', function ($data) {
                $tt = '-';
                if (isset($data->tracking->tanda_terima)) {
                    $tt = '<img src="'.Storage::url($data->tracking->tanda_terima).'" width="60px">';
                }

                return $tt;
            })
            ->rawColumns(['tandaterima'])
            ->toJson();
    }

    public function rekapsampel()
    {
        $title = 'REKAP LAPORAN PENGUJIAN PIHAK KETIGA';
        $bidang = Kategori::where('status', 1)->get();
        return view('admin.laporan.rekapsampel', compact('title', 'bidang'));
    }
}
