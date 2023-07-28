<?php

namespace App\Http\Controllers;

use App\Models\TerimaSampel;
use App\Models\TodoList;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $title = 'Dashboard';
        $samplePerKategori = TerimaSampel::with('kategori')
            ->whereYear('created_at', now()->year)
            ->groupBy('id_kategori')
            ->get();

        $data = [
            'userCount' => User::all()->count(),
            'allSampleThisYear' => TerimaSampel::whereYear('created_at', now()->year)->sum('jumlah_sampel'),
            'sampleToday' => TerimaSampel::whereDay('created_at', now()->day)
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('jumlah_sampel'),
            'sampleNapzaThisYear' => TerimaSampel::where('id_kategori', 1)->whereYear('created_at', now()->year)->sum('jumlah_sampel'), //1 id kategori napza
            'listKategoriName' => $samplePerKategori->pluck('kategori.nama_kategori'),
            'samplePerKategori' => TerimaSampel::with('kategori')
                ->whereYear('created_at', now()->year)
                ->groupBy('id_kategori')
                ->selectRaw('*, sum(jumlah_sampel) as jumlahSampel')->get()->pluck('jumlahSampel')
        ];
        
        return view('admin.dashboard.index', compact('title', 'data'));
    }

}
