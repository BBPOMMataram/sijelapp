<?php

namespace App\Http\Controllers;

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
}