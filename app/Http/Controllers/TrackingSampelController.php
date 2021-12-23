<?php

namespace App\Http\Controllers;

use App\Models\ProdukSampel;
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
                $userlevel = auth()->user()->level;
                $status = $data->id_status_sampel;

                $btn = '';
                if ($userlevel === 2) {
                    if (in_array($status, [3, 4, 5])) {
                        $btn .= '<a href="#"><i class="fas fa-angle-double-right text-danger nextstep"></i></a>';
                    }
                } else {
                    $btn .= '<a href="#"><i class="fas fa-angle-double-right text-danger nextstep"></i></a>';
                }
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

    public function nextstep(Request $request, $id_tracking)
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
                $data->tanggal_estimasi = $request->tanggal_estimasi;
                break;
            case 4:
                $data->tanggal_pengujian = now();
                // $produksampel = ProdukSampel::where('id_permintaan', $data->id_permintaan)->get();
                // $produksampel->hasil_uji = $request->hasil_uji;
                // $produksampel->save();
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
                // $produksampel = ProdukSampel::where('id_permintaan', $data->id_permintaan)->get();
                // $produksampel->tersangka = $request->tersangka;
                // $produksampel->save();
                break;
            default:
                return response(['status' => 0, 'msg' => 'Gagal update tanggal step.']);
                break;
        }

        $data->save();
        return response(['status' => 1, 'msg' => 'Berhasil update data.']);
    }

    public function cancelstep($id_tracking)
    {
        $data = TrackingSampel::find($id_tracking);
        if ($data->id_status_sampel === 0) {
            return response(['status' => 0, 'msg' => 'Sampel belum diverifikasi.']);
        }

        $data->id_status_sampel -= 1;

        switch ($data->id_status_sampel) {
            case 0:
                $data->tanggal_verifikasi = null;
                break;
            case 1:
                $data->tanggal_kaji_ulang = null;
                break;
            case 2:
                $data->tanggal_pembayaran = null;
                $data->tanggal_estimasi = null;
                break;
            case 3:
                $data->tanggal_pengujian = null;
                break;
            case 4:
                $data->tanggal_selesai_uji = null;
                break;
            case 5:
                $data->tanggal_legalisir = null;
                break;
            case 6:
                $data->tanggal_selesai = null;
                break;
            case 7:
                $data->tanggal_diambil = null;
                break;
            default:
                return response(['status' => 0, 'msg' => 'Gagal cancel step.']);
                break;
        }

        $data->save();
        return response(['status' => 1, 'msg' => 'Berhasil cancel step.']);
    }

    public function sampelselesai()
    {
        $title = 'Sampel Selesai (Sudah diambil)';
        return view('admin.sampelselesai', compact('title'));
    }

    public function dtsampelselesai()
    {
        $data = TrackingSampel::with(['permintaan', 'status', 'permintaan.pemiliksampel'])
            ->where('id_status_sampel', 8) //id status sampel diambil
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

                $btn = '<a href="#"><i class="fas fa-eye text-primary show"></i></a>';
                $data->status ? $btn : $btn = '-';
                return $btn;
            })
            ->rawColumns(['actions'])
            ->toJson();
    }
}
