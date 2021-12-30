<?php

namespace App\Http\Controllers;

use App\Models\Wadah2;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class Wadah2Controller extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Wadah2::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('actions', function ($data) {
                    $btn = '<a href="#"><i class="fas fa-trash text-danger delete"></i></a>';
                    return $btn;
                })
                ->rawColumns(['actions'])
                ->toJson();
        }
        $title = 'Wadah 2';
        return view('admin.master.wadah2', compact('title'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $data = new Wadah2();

        $data->name = $request->name;
        
        $data->save();

        return response(['status' => 1, 'msg' => 'Tambah data berhasil.']);
    }

    public function destroy($id)
    {
        Wadah2::destroy($id);

        return response(['status' => 1, 'msg' => 'Hapus data berhasil.']);
    }
}
