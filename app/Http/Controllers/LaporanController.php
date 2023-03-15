<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\PemilikSampel;
use App\Models\ProdukSampel;
use App\Models\TerimaSampel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

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
            ->groupBy('id_kategori');
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


    public function rekapsampelpolisi()
    {
        $title = 'REKAP LAPORAN PENGUJIAN PIHAK KETIGA';
        $bidang = Kategori::where('status', 1)->get();
        return view('admin.laporan.jumlah-sampel-polisi', compact('title', 'bidang'));
    }

    public function dtrekapsampelpolisi($tahun = null)
    {
        $data = DB::table('permintaan')
            ->select(
                'nama_pemilik',
                'nama_sampel',
                // DB::raw("SUM(CASE WHEN nama_sampel LIKE '%shabu%' THEN 1 ELSE NULL END) as shabu_count"),
                // DB::raw("SUM(CASE WHEN nama_sampel LIKE '%ganja%' THEN 1 ELSE NULL END) as ganja_count"),
                // DB::raw("SUM(CASE WHEN nama_sampel LIKE '%ekstasi%' THEN 1 ELSE NULL END) as ekstasi_count"),
                // DB::raw("SUM(CASE WHEN nama_sampel NOT LIKE '%shabu%' AND nama_sampel NOT LIKE '%ganja%' AND nama_sampel NOT LIKE '%ekstasi%' THEN 1 ELSE NULL END) as lainnya_count"),
            )
            ->leftJoin('pemilik_sampel', 'permintaan.id_pemilik', '=', 'pemilik_sampel.id_pemilik')
            ->where('nama_pemilik', 'like', '%polda%')
            ->orWhere('nama_pemilik', 'like', '%resor%')
            ->orWhere('nama_pemilik', 'like', '%narkotika%')
            ->orWhere('nama_pemilik', 'like', '%sektor%')
            ->orderBy('nama_pemilik')
            ->groupBy('nama_pemilik')
            ->get();

        if (isset($tahun)) {
            $data = DB::table('permintaan')
                ->select(
                    'nama_pemilik',
                    'nama_sampel',
                    // DB::raw("SUM(CASE WHEN nama_sampel LIKE '%shabu%' AND year(created_at)='$tahun' THEN 1 ELSE NULL END) as shabu_count"),
                    // DB::raw("SUM(CASE WHEN nama_sampel LIKE '%ganja%' AND year(created_at)='$tahun' THEN 1 ELSE NULL END) as ganja_count"),
                    // DB::raw("SUM(CASE WHEN nama_sampel LIKE '%ekstasi%' AND year(created_at)='$tahun' THEN 1 ELSE NULL END) as ekstasi_count"),
                    // DB::raw("SUM(CASE WHEN nama_sampel NOT LIKE '%shabu%' AND nama_sampel NOT LIKE '%ganja%' AND nama_sampel NOT LIKE '%ekstasi%' AND year(created_at)='$tahun' THEN 1 ELSE NULL END) as lainnya_count"),
                )
                ->leftJoin('pemilik_sampel', 'permintaan.id_pemilik', '=', 'pemilik_sampel.id_pemilik')
                ->where('nama_pemilik', 'like', '%polda%')
                ->orWhere('nama_pemilik', 'like', '%resor%')
                ->orWhere('nama_pemilik', 'like', '%narkotika%')
                ->orWhere('nama_pemilik', 'like', '%sektor%')
                ->orderBy('nama_pemilik')
                // ->groupBy('nama_pemilik')
                ->whereYear('created_at', $tahun)
                ->get();
        }

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('shabu_count', function ($data) {
                // $keyword = 'shabu';

                // $shabu_count = substr_count(strtolower($data->nama_sampel), strtolower($keyword));

                $data->nama_sampel = substr_count($data->nama_sampel, 'shabu');

                return $data->nama_sampel;
            })
            ->addColumn('ganja_count', function ($data) {
                return 'ganja_count';
            })
            ->addColumn('ekstasi_count', function ($data) {
                return 'ekstasi_count';
            })
            ->addColumn('lainnya_count', function ($data) {
                return 'lainnya_count';
            })
            ->addColumn('total_count', function ($data) {
                // $total = $data->shabu_count + $data->ganja_count + $data->ekstasi_count + $data->lainnya_count;
                // return $total;
                return 'total_count';
            })
            ->toJson();
    }
}
