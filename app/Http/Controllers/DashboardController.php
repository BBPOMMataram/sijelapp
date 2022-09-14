<?php

namespace App\Http\Controllers;

use App\Models\TerimaSampel;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $title = 'Dashboard';
        $data = [
            'userCount' => User::all()->count(),
            'allSampleThisYear' => TerimaSampel::whereYear('created_at', now()->year)->sum('jumlah_sampel'),
            'sampleToday' => TerimaSampel::whereDay('created_at', now()->day)
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('jumlah_sampel'),
            'sampleNapzaThisYear' => TerimaSampel::where('id_kategori', 1)->whereYear('created_at', now()->year)->sum('jumlah_sampel'), //1 id kategori napza
        ];
        return view('admin.index', compact('title', 'data'));
    }
}
