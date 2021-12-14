<?php

namespace App\Http\Controllers\Pengaturan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    public function index()
    {
        $title = 'Profil';
        return view('admin.pengaturan.profil', compact('title'));
    }
}
