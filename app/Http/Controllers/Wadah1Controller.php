<?php

namespace App\Http\Controllers;

use App\Models\Wadah1;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class Wadah1Controller extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Wadah1::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('actions', function ($data) {
                    $btn = '<a href="#"><i class="fas fa-trash text-danger delete"></i></a>';
                    return $btn;
                })
                ->rawColumns(['actions'])
                ->toJson();
        }
        $title = 'Wadah 1';
        return view('admin.master.wadah1', compact('title'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $data = new Wadah1();

        $data->name = $request->name;
        
        $data->save();

        return response(['status' => 1, 'msg' => 'Tambah data berhasil.']);
    }

    public function destroy($id)
    {
        Wadah1::destroy($id);

        return response(['status' => 1, 'msg' => 'Hapus data berhasil.']);
    }
}
