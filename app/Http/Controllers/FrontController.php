<?php

namespace App\Http\Controllers;

use App\Models\ProdukSampel;
use App\Models\TerimaSampel;
use App\Models\TrackingSampel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class FrontController extends Controller
{
    public function trackingsampel()
    {
        return view('index');
    }

    public function dttrackingsampel(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'g-recaptcha-response' => 'required|captcha',
            ],
            [
                'g-recaptcha-response.required' => 'Please resolve the Recapthca'
            ]
        );

        $permintaan = TerimaSampel::where('resi', $id)->latest()->first();
        if (!$permintaan) {
            return response(['status' => 0, 'msg' => 'Data Sampel tidak ditemukan.']);
        }
        $data = TrackingSampel::with(['permintaan', 'status', 'permintaan.pemiliksampel'])
            ->where('id_permintaan', $permintaan->id_permintaan);
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
                        $res = $data->permintaan->created_at->isoFormat('D MMM Y \p\u\k\u\l H:mm:ss');
                    }
                }
                return $res;
            })
            ->addColumn('tanggal_verifikasi', function ($data) {
                $res = '-';
                if ($data->tanggal_verifikasi) {
                    $res = $data->tanggal_verifikasi->isoFormat('D MMM Y \p\u\k\u\l H:mm:ss');
                }
                return $res;
            })
            ->addColumn('tanggal_kaji_ulang', function ($data) {
                $res = '-';
                if ($data->tanggal_kaji_ulang) {
                    $res = $data->tanggal_kaji_ulang->isoFormat('D MMM Y \p\u\k\u\l H:mm:ss');
                }
                return $res;
            })
            ->addColumn('tanggal_pembayaran', function ($data) {
                $res = '-';
                if ($data->tanggal_pembayaran) {
                    $res = $data->tanggal_pembayaran->isoFormat('D MMM Y \p\u\k\u\l H:mm:ss');
                }
                return $res;
            })
            ->addColumn('tanggal_pengujian', function ($data) {
                $res = '-';
                if ($data->tanggal_pengujian) {
                    $res = $data->tanggal_pengujian->isoFormat('D MMM Y \p\u\k\u\l H:mm:ss');
                }
                return $res;
            })
            ->addColumn('tanggal_selesai_uji', function ($data) {
                $res = '-';
                if ($data->tanggal_selesai_uji) {
                    $res = $data->tanggal_selesai_uji->isoFormat('D MMM Y \p\u\k\u\l H:mm:ss');
                }
                return $res;
            })
            ->addColumn('tanggal_legalisir', function ($data) {
                $res = '-';
                if ($data->tanggal_legalisir) {
                    $res = $data->tanggal_legalisir->isoFormat('D MMM Y \p\u\k\u\l H:mm:ss');
                }
                return $res;
            })
            ->addColumn('tanggal_selesai', function ($data) {
                $res = '-';
                if ($data->tanggal_selesai) {
                    $res = $data->tanggal_selesai->isoFormat('D MMM Y \p\u\k\u\l H:mm:ss');
                }
                return $res;
            })
            ->addColumn('tanggal_diambil', function ($data) {
                $res = '-';
                if ($data->tanggal_diambil) {
                    $res = $data->tanggal_diambil->isoFormat('D MMM Y \p\u\k\u\l H:mm:ss');
                }
                return $res;
            })
            ->addColumn('tanggal_estimasi', function ($data) {
                $res = '-';
                if ($data->tanggal_estimasi) {
                    $res = $data->tanggal_estimasi->isoFormat('D MMM Y \p\u\k\u\l H:mm:ss');
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

    public function submittandaterima(Request $request, $id)
    {
        // dd($request->all());
        $this->validate($request, [
            'tanda_terima' => 'required',
            'nama_pengambil' => 'required',
        ]);

        $data = TrackingSampel::where('id_permintaan', $id)->first();

        $data->tanggal_diambil = now();
        $data->nama_pengambil = $request->nama_pengambil;
        $data->id_status_sampel += 1;

        if ($data->save()) {
            $signed = $request->tanda_terima;
            $encoded_image = explode(",", $signed)[1];
            $decoded_image = base64_decode($encoded_image);
            Storage::put('signatures/' . $data->id_tracking . '.png', $decoded_image);
            $data->tanda_terima = 'signatures/' . $data->id_tracking . '.png';
            $data->save();
        }
        return response(['status' => 1, 'msg' => 'Berhasil, Terima kasih.']);
    }

    public function tarifpengujian()
    {
        return view('tarifpengujian');
    }
}
