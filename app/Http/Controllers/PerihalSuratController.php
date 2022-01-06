<?php

namespace App\Http\Controllers;

use App\Models\PerihalSurat;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PerihalSuratController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = PerihalSurat::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('actions', function ($data) {
                    $btn = '<a href="#"><i class="fas fa-trash text-danger delete"></i></a>';
                    return $btn;
                })
                ->rawColumns(['actions'])
                ->toJson();
        }
        $title = 'Perihal Surat';
        return view('admin.master.perihalsurat', compact('title'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $data = new PerihalSurat();

        $data->name = $request->name;
        
        $data->save();

        return response(['status' => 1, 'msg' => 'Tambah data berhasil.']);
    }

    public function destroy($id)
    {
        PerihalSurat::destroy($id);

        return response(['status' => 1, 'msg' => 'Hapus data berhasil.']);
    }
}