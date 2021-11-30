<?php

namespace App\Http\Controllers;

use App\Models\ProdukSampel;
use App\Models\TerimaSampel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LaporanController extends Controller
{
    public function jumlahsampel()
    {
        $title = 'JUMLAH SAMPEL PIHAK KETIGA';
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
        $data = ProdukSampel::with(
            [
                'ujiproduk' => function($q){
                    // $q->orderBy('id_uji_produk');
                },
                'ujiproduk.parameter' => function($q){
                    // $q->orderBy('id_parameter');
                },
                'ujiproduk.parameter.metodeuji' => function($q){
                    // $q->orderBy('id_kode_layanan');
                },
                'permintaan.pemiliksampel' => function($q){
                    // $q->orderBy('id_pemilik');
                },
                'permintaan.kategori' => function($q){
                    // $q->orderBy('id_kategori');
                },
                'permintaan.tracking' => function($q){
                    // $q->orderBy('id_tracking');
                },
                'permintaan' => function($q){
                    // $q->latest();
                },
            ],
        )->orderBy('id_permintaan', 'desc');

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('tanggalterima', function ($data) {
                if (isset($data->permintaan->created_at)) {
                    return $data->permintaan->created_at->isoFormat('D MMM Y (H:mm:ss)');
                } elseif (isset($data->permintaan->tanggal_terima)) {
                    return $data->permintaan->tanggal_terima->isoFormat('D MMM Y (H:mm:ss)');
                } else {
                    return '-';
                }
            })
            ->addColumn('tanggalestimasi', function ($data) {
                if (isset($data->permintaan->tracking->tanggal_estimasi)) {
                    return $data->permintaan->tracking->tanggal_estimasi->isoFormat('D MMM Y');
                } else {
                    return '-';
                }
            })
            ->addColumn('tanggalselesaiuji', function ($data) {
                if (isset($data->permintaan->tracking->tanggal_selesai_uji)) {
                    return $data->permintaan->tracking->tanggal_selesai_uji->isoFormat('D MMM Y');
                } else {
                    return '-';
                }
            })
            ->addColumn('tanggallegalisir', function ($data) {
                if (isset($data->permintaan->tracking->tanggal_legalisir)) {
                    return $data->permintaan->tracking->tanggal_legalisir->isoFormat('D MMM Y (H:mm:ss)');
                } else {
                    return '-';
                }
            })
            ->addColumn('selesaidalamhari', function ($data) {
                if (isset($data->permintaan->tracking->tanggal_legalisir)) {
                    $tgl_legalisir = $data->permintaan->tracking->tanggal_legalisir;
                    if (isset($data->permintaan->created_at)) {
                        $count = $tgl_legalisir->diffForHumans($data->permintaan->created_at);
                        return $count;
                    } elseif (isset($data->permintaan->tanggal_terima)) {
                        $count = $tgl_legalisir->diffForHumans($data->permintaan->tanggal_terima);
                        return $count;
                    }
                } else {
                    return '-';
                }
            })
            ->toJson();
    }

    public function rekapsampel()
    {
        $title = 'REKAP LAPORAN PENGUJIAN PIHAK KETIGA';
        return view('admin.laporan.rekapsampel', compact('title'));
    }
}
