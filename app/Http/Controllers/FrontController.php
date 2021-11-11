<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function trackingsampel()
    {
        return view('index');
    }

    public function tarifpengujian()
    {
        return view('tarifpengujian');
    }
}
