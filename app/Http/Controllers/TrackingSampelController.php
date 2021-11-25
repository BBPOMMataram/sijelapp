<?php

namespace App\Http\Controllers;

use App\Models\StatusSampel;
use App\Models\TrackingSampel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TrackingSampelController extends Controller
{
    public function dtstatussampel()
    {
        $data = TrackingSampel::with(['permintaan', 'status', 'permintaan.pemiliksampel'])
            ->orderBy('id_tracking', 'desc');
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('permintaan.no_urut_penerimaan', function ($data) {
                return $data->permintaan ? $data->permintaan->no_urut_penerimaan : '-';
            })
            ->addColumn('permintaan.kode_sampel', function ($data) {
                return $data->permintaan ? $data->permintaan->kode_sampel : '-';
            })
            ->addColumn('permintaan.pemiliksampel.nama_pemilik', function ($data) {
                return $data->permintaan ? $data->permintaan->pemiliksampel->nama_pemilik : '-';
            })
            ->addColumn('permintaan.pemiliksampel.nama_petugas', function ($data) {
                return $data->permintaan ? $data->permintaan->pemiliksampel->nama_petugas : '-';
            })
            ->addColumn('permintaan.pemiliksampel.telepon_petugas', function ($data) {
                return $data->permintaan ? $data->permintaan->pemiliksampel->telepon_petugas : '-';
            })
            ->addColumn('status.label', function ($data) {
                return $data->status ? $data->status->label : '-';
            })
            ->addColumn('permintaan.created_at', function ($data) {
                $res = '-';
                if ($data->permintaan) {
                    if ($data->permintaan->created_at) {
                        $res = $data->permintaan->created_at->isoFormat('D MMM Y \p\u\k\u\l H:mm');
                    }
                }
                return $res;
            })
            ->addColumn('actions', function ($data) {

                $btn = '<a href="#"><i class="fas fa-angle-double-right text-danger nextstep"></i></a>';
                $btn .= '<a href="#"><i class="fas fa-eye text-primary ml-2 show"></i></a>';
                $data->status ? $btn : $btn = '-';
                return $btn;
            })
            ->rawColumns(['actions'])
            ->toJson();
    }

    public function liststatussampel()
    {
        return StatusSampel::all();
    }

    public function index()
    {
        $title = 'Status Sampel';
        return view('admin.statussampel', compact('title'));
    }

    public function nextstep($id_tracking)
    {
        $laststatus = StatusSampel::latest('id')->first();

        $data = TrackingSampel::find($id_tracking);
        if ($data->id_status_sampel === $laststatus->id) {
            return response(['status' => 0, 'msg' => 'Sampel sudah diambil.']);
        }

        $data->id_status_sampel += 1;

        switch ($data->id_status_sampel) {
            case 1:
                $data->tanggal_verifikasi = now();
                break;
            case 2:
                $data->tanggal_kaji_ulang = now();
                break;
            case 3:
                $data->tanggal_pembayaran = now();
                break;
            case 4:
                $data->tanggal_pengujian = now();
                break;
            case 5:
                $data->tanggal_selesai_uji = now();
                break;
            case 6:
                $data->tanggal_legalisir = now();
                break;
            case 7:
                $data->tanggal_selesai = now();
                break;
            case 8:
                $data->tanggal_diambil = now();
                break;
            default:
                return response(['status' => 0, 'msg' => 'Gagal update tanggal step.']);
                break;
        }

        $data->save();
        return response(['status' => 1, 'msg' => 'Berhasil update data.']);
    }
}
