<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\ProdukSampel;
use App\Models\TerimaSampel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class LaporanController extends Controller
{
    public function jumlahsampel()
    {
        $title = 'LAPORAN JUMLAH PENGUJIAN PIHAK KETIGA';
        return view('admin.laporan.jumlahsampel', compact('title'));
    }

    public function dtjumlahsampel($tahun)
    {
        $data = TerimaSampel::with(['kategori', 'tracking'])
            // ->whereYear('created_at', $tahun)
            ->groupBy('id_kategori')
            ->orderBy('id_kategori');

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('januarimasuk', function ($d) use ($tahun) {
                $res = $d->whereHas('tracking', function ($q) {
                    $q->whereMonth('tanggal_pembayaran', '1');
                })->where('id_kategori', $d->id_kategori)
                    // ->whereMonth('created_at', '1')
                    ->whereYear('created_at', $tahun)
                    ->sum('jumlah_sampel');
                return $res;
            })
            ->addColumn('januarikeluar', function ($d) use ($tahun) {
                $res = $d
                    ->whereHas('tracking', function ($q) {
                        $q->whereMonth('tanggal_selesai', '1');
                    })
                    ->where('id_kategori', $d->id_kategori)
                    ->whereYear('created_at', $tahun)
                    ->sum('jumlah_sampel');
                return $res;
            })
            ->addColumn('februarimasuk', function ($d) use ($tahun) {
                $res = $d->whereHas('tracking', function ($q) {
                    $q->whereMonth('tanggal_pembayaran', '2');
                })->where('id_kategori', $d->id_kategori)
                    // ->whereMonth('created_at', '2')
                    ->whereYear('created_at', $tahun)
                    ->sum('jumlah_sampel');
                return $res;
            })
            ->addColumn('februarikeluar', function ($d) use ($tahun) {
                $res = $d
                    ->whereHas('tracking', function ($q) {
                        $q->whereMonth('tanggal_selesai', '2');
                    })
                    ->where('id_kategori', $d->id_kategori)
                    ->whereYear('created_at', $tahun)
                    ->sum('jumlah_sampel');
                return $res;
            })
            ->addColumn('maretmasuk', function ($d) use ($tahun) {
                $res = $d->whereHas('tracking', function ($q) {
                    $q->whereMonth('tanggal_pembayaran', '3');
                })->where('id_kategori', $d->id_kategori)
                    // ->whereMonth('created_at', '3')
                    ->whereYear('created_at', $tahun)
                    ->sum('jumlah_sampel');
                return $res;
            })
            ->addColumn('maretkeluar', function ($d) use ($tahun) {
                $res = $d
                    ->whereHas('tracking', function ($q) {
                        $q->whereMonth('tanggal_selesai', '3');
                    })
                    ->where('id_kategori', $d->id_kategori)
                    ->whereYear('created_at', $tahun)
                    ->sum('jumlah_sampel');
                return $res;
            })
            ->addColumn('aprilmasuk', function ($d) use ($tahun) {
                $res = $d->whereHas('tracking', function ($q) {
                    $q->whereMonth('tanggal_pembayaran', '4');
                })->where('id_kategori', $d->id_kategori)
                    // ->whereMonth('created_at', '4')
                    ->whereYear('created_at', $tahun)
                    ->sum('jumlah_sampel');
                return $res;
            })
            ->addColumn('aprilkeluar', function ($d) use ($tahun) {
                $res = $d
                    ->whereHas('tracking', function ($q) {
                        $q->whereMonth('tanggal_selesai', '4');
                    })
                    ->where('id_kategori', $d->id_kategori)
                    ->whereYear('created_at', $tahun)
                    ->sum('jumlah_sampel');
                return $res;
            })
            ->addColumn('meimasuk', function ($d) use ($tahun) {
                $res = $d->whereHas('tracking', function ($q) {
                    $q->whereMonth('tanggal_pembayaran', '5');
                })->where('id_kategori', $d->id_kategori)
                    // ->whereMonth('created_at', '5')
                    ->whereYear('created_at', $tahun)
                    ->sum('jumlah_sampel');
                return $res;
            })
            ->addColumn('meikeluar', function ($d) use ($tahun) {
                $res = $d
                    ->whereHas('tracking', function ($q) {
                        $q->whereMonth('tanggal_selesai', '5');
                    })
                    ->where('id_kategori', $d->id_kategori)
                    ->whereYear('created_at', $tahun)
                    ->sum('jumlah_sampel');
                return $res;
            })
            ->addColumn('junimasuk', function ($d) use ($tahun) {
                $res = $d->whereHas('tracking', function ($q) {
                    $q->whereMonth('tanggal_pembayaran', '6');
                })->where('id_kategori', $d->id_kategori)
                    // ->whereMonth('created_at', '6')
                    ->whereYear('created_at', $tahun)
                    ->sum('jumlah_sampel');
                return $res;
            })
            ->addColumn('junikeluar', function ($d) use ($tahun) {
                $res = $d
                    ->whereHas('tracking', function ($q) {
                        $q->whereMonth('tanggal_selesai', '6');
                    })
                    ->where('id_kategori', $d->id_kategori)
                    ->whereYear('created_at', $tahun)
                    ->sum('jumlah_sampel');
                return $res;
            })
            ->addColumn('julimasuk', function ($d) use ($tahun) {
                $res = $d->whereHas('tracking', function ($q) {
                    $q->whereMonth('tanggal_pembayaran', '7');
                })->where('id_kategori', $d->id_kategori)
                    // ->whereMonth('created_at', '7')
                    ->whereYear('created_at', $tahun)
                    ->sum('jumlah_sampel');
                return $res;
            })
            ->addColumn('julikeluar', function ($d) use ($tahun) {
                $res = $d
                    ->whereHas('tracking', function ($q) {
                        $q->whereMonth('tanggal_selesai', '7');
                    })
                    ->where('id_kategori', $d->id_kategori)
                    ->whereYear('created_at', $tahun)
                    ->sum('jumlah_sampel');
                return $res;
            })
            ->addColumn('agustusmasuk', function ($d) use ($tahun) {
                $res = $d->whereHas('tracking', function ($q) {
                    $q->whereMonth('tanggal_pembayaran', '8');
                })->where('id_kategori', $d->id_kategori)
                    // ->whereMonth('created_at', '8')
                    ->whereYear('created_at', $tahun)
                    ->sum('jumlah_sampel');
                return $res;
            })
            ->addColumn('agustuskeluar', function ($d) use ($tahun) {
                $res = $d
                    ->whereHas('tracking', function ($q) {
                        $q->whereMonth('tanggal_selesai', '8');
                    })
                    ->where('id_kategori', $d->id_kategori)
                    ->whereYear('created_at', $tahun)
                    ->sum('jumlah_sampel');
                return $res;
            })
            ->addColumn('septembermasuk', function ($d) use ($tahun) {
                $res = $d->whereHas('tracking', function ($q) {
                    $q->whereMonth('tanggal_pembayaran', '9');
                })->where('id_kategori', $d->id_kategori)
                    // ->whereMonth('created_at', '9')
                    ->whereYear('created_at', $tahun)
                    ->sum('jumlah_sampel');
                return $res;
            })
            ->addColumn('septemberkeluar', function ($d) use ($tahun) {
                $res = $d
                    ->whereHas('tracking', function ($q) {
                        $q->whereMonth('tanggal_selesai', '9');
                    })
                    ->where('id_kategori', $d->id_kategori)
                    ->whereYear('created_at', $tahun)
                    ->sum('jumlah_sampel');
                return $res;
            })
            ->addColumn('oktobermasuk', function ($d) use ($tahun) {
                $res = $d->whereHas('tracking', function ($q) {
                    $q->whereMonth('tanggal_pembayaran', '10');
                })->where('id_kategori', $d->id_kategori)
                    // ->whereMonth('created_at', '10')
                    ->whereYear('created_at', $tahun)
                    ->sum('jumlah_sampel');
                return $res;
            })
            ->addColumn('oktoberkeluar', function ($d) use ($tahun) {
                $res = $d
                    ->whereHas('tracking', function ($q) {
                        $q->whereMonth('tanggal_selesai', '10');
                    })
                    ->where('id_kategori', $d->id_kategori)
                    ->whereYear('created_at', $tahun)
                    ->sum('jumlah_sampel');
                return $res;
            })
            ->addColumn('novembermasuk', function ($d) use ($tahun) {
                $res = $d->whereHas('tracking', function ($q) {
                    $q->whereMonth('tanggal_pembayaran', '11');
                })->where('id_kategori', $d->id_kategori)
                    // ->whereMonth('created_at', '11')
                    ->whereYear('created_at', $tahun)
                    ->sum('jumlah_sampel');
                return $res;
            })
            ->addColumn('novemberkeluar', function ($d) use ($tahun) {
                $res = $d
                    ->whereHas('tracking', function ($q) {
                        $q->whereMonth('tanggal_selesai', '11');
                    })
                    ->where('id_kategori', $d->id_kategori)
                    ->whereYear('created_at', $tahun)
                    ->sum('jumlah_sampel');
                return $res;
            })
            ->addColumn('desembermasuk', function ($d) use ($tahun) {
                $res = $d->whereHas('tracking', function ($q) {
                    $q->whereMonth('tanggal_pembayaran', '12');
                })->where('id_kategori', $d->id_kategori)
                    // ->whereMonth('created_at', '12')
                    ->whereYear('created_at', $tahun)
                    ->sum('jumlah_sampel');
                return $res;
            })
            ->addColumn('desemberkeluar', function ($d) use ($tahun) {
                $res = $d
                    ->whereHas('tracking', function ($q) {
                        $q->whereMonth('tanggal_selesai', '12');
                    })
                    ->where('id_kategori', $d->id_kategori)
                    ->whereYear('created_at', $tahun)
                    ->sum('jumlah_sampel');
                return $res;
            })
            ->addColumn('totalmasuk', function ($d) use ($tahun) {
                $res = $d->where('id_kategori', $d->id_kategori)
                    // ->where(DB::RAW('month(created_at)'), ['1','2','3','4','5','6','7','8','9','10','11','12'])
                    ->whereYear('created_at', $tahun)
                    ->sum('jumlah_sampel');
                return $res;
            })
            ->addColumn('totalkeluar', function ($d) use ($tahun) {
                $res = $d
                    ->whereHas('tracking', function ($q) {
                        $q->whereIn(DB::RAW('month(tanggal_selesai)'), [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]);
                    })
                    ->where('id_kategori', $d->id_kategori)
                    ->whereYear('created_at', $tahun)
                    ->sum('jumlah_sampel');
                return $res;
            })
            ->toJson();
    }

    public function rekapsampel()
    {
        $title = 'REKAP LAPORAN PENGUJIAN PIHAK KETIGA';
        $bidang = Kategori::where('status', 1)->get();
        return view('admin.laporan.rekapsampel', compact('title', 'bidang'));
    }

    public function dtrekapsampel($kategori = null, $tahun = null, $bulan = null)
    {
        $data = TerimaSampel::with('kategori', 'pemiliksampel', 'tracking', 'produksampel.ujiproduk.parameter.metodeuji', 'produksampel.user')
            ->latest();

        if (isset($kategori) && $kategori !== 'null') {
            $data = $data->where('id_kategori', $kategori);
        }

        if (isset($tahun)) {
            $data = $data->whereYear('created_at', $tahun);
        }

        if (isset($bulan)) {
            $data = $data->whereMonth('created_at', $bulan);
        }

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('tanggalterima', function ($data) {
                // if (isset($data->created_at)) {
                //     return $data->created_at->isoFormat('D MMM Y (H:mm:ss)');
                // } elseif (isset($data->tanggal_terima)) {
                //     return $data->tanggal_terima->isoFormat('D MMM Y (H:mm:ss)');
                // } else {
                //     return '-';
                // }
                $tglterima = '-';
                if (isset($data->tracking->tanggal_pembayaran)) {
                    $tglterima = $data->tracking->tanggal_pembayaran->isoFormat('D MMM Y (H:mm:ss)');
                }

                return $tglterima;
            })
            ->addColumn('tanggalestimasi', function ($data) {
                if (isset($data->tracking->tanggal_estimasi)) {
                    return $data->tracking->tanggal_estimasi->isoFormat('D MMM Y');
                } else {
                    return '-';
                }
            })
            ->addColumn('tanggalselesai', function ($data) {
                if (isset($data->tracking->tanggal_selesai)) {
                    return $data->tracking->tanggal_selesai->isoFormat('D MMM Y (H:mm:ss)');
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
                if (isset($data->tracking->tanggal_selesai)) {
                    $tgl_selesai = $data->tracking->tanggal_selesai;
                    if (isset($data->tracking->tanggal_pembayaran)) {
                        $count = $tgl_selesai->diffForHumans($data->tracking->tanggal_pembayaran);
                        return $count;
                    }
                    // elseif (isset($data->tanggal_terima)) {
                    //     $count = $tgl_legalisir->diffForHumans($data->tanggal_terima);
                    //     return $count;
                    // }
                } else {
                    return '-';
                }
            })
            ->addColumn('tandaterima', function ($data) {
                $tt = '-';
                if (isset($data->tracking->tanda_terima)) {
                    $tt = '<img src="' . Storage::url($data->tracking->tanda_terima) ?? '#' . '" width="60px">';
                }

                return $tt;
            })
            ->rawColumns(['tandaterima'])
            ->toJson();
    }


    public function pengguna()
    {
        $title = 'REKAP LAPORAN PENGUJIAN PIHAK KETIGA';
        $bidang = Kategori::where('status', 1)->get();
        return view('admin.laporan.pengguna', compact('title', 'bidang'));
    }

    public function dtpengguna($tahun = null, $bulan = null)
    {
        $data = DB::table('permintaan')
            ->select(
                'pemilik_sampel.nama_pemilik',
                'tracking_sampel.tanggal_pembayaran',
                'pemilik_sampel.nama_petugas',
                'pemilik_sampel.telepon_petugas',
                'pemilik_sampel.email_petugas',
                'created_at'
            )
            ->join('pemilik_sampel', 'permintaan.id_pemilik', '=', 'pemilik_sampel.id_pemilik')
            ->join('tracking_sampel', 'permintaan.id_permintaan', '=', 'tracking_sampel.id_permintaan')
            ->groupBy('pemilik_sampel.nama_petugas')
            ->latest();

        if (isset($tahun)) {
            $data = $data->whereYear('created_at', $tahun);
        }

        if (isset($bulan)) {
            $data = $data->whereMonth('created_at', $bulan);
        }

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('tanggalterima', function ($data) {
                $tglterima = '-';
                if (isset($data->tanggal_pembayaran)) {
                    $tglterima = date('d M Y', strtotime($data->tanggal_pembayaran));
                }

                return $tglterima;
            })
            ->toJson();
    }
}
