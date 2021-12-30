<?php

namespace App\Http\Controllers;

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
        $data = ProdukSampel::with(
            [
                'ujiproduk',
                'ujiproduk.parameter',
                'ujiproduk.parameter.metodeuji',
                'permintaan.pemiliksampel',
                'permintaan.kategori',
                'permintaan.tracking',
                'permintaan',
                'user',
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
            ->addColumn('tandaterima', function ($data) {
                $tt = '-';
                if (isset($data->permintaan->tracking->tanda_terima)) {
                    $tt = '<img src="'.Storage::url($data->permintaan->tracking->tanda_terima).'" width="60px">';
                }

                return $tt;
            })
            ->rawColumns(['tandaterima'])
            ->toJson();
    }

    public function rekapsampel()
    {
        $title = 'LAPORAN';
        return view('admin.laporan.rekapsampel', compact('title'));
    }
}
