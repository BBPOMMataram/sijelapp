<?php

namespace App\Http\Controllers;

use App\Models\MetodeUji;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MetodeUjiController extends Controller
{
    public function dtmetodeuji()
    {
        $data = MetodeUji::where('status', 1)->orderBy('metode');
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function ($data) {
                $btn = '<a href="#"><i class="fas fa-eye text-primary show"></i></a>';
                $btn .= '<a href="#"><i class="fas fa-pen text-info edit mx-1"></i></a>';
                // $btn .= '<a href="#"><i class="fas fa-trash text-danger delete"></i></a>';
                return $btn;
            })
            ->rawColumns(['actions'])
            ->toJson();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Metode Uji';
        return view('admin.master.metodeuji', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'metode' => 'required',
            'kodelayanan' => 'required',
            'biaya' => 'required|numeric',
        ]);

        $data = new MetodeUji();

        $data->metode = $request->metode;
        $data->kode_layanan = $request->kodelayanan;
        $data->biaya = $request->biaya;
        $data->save();

        return response(['status' => 1, 'msg' => 'Tambah data berhasil.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'metode' => 'required',
            'kodelayanan' => 'required',
            'biaya' => 'required|numeric',
        ]);

        $data = MetodeUji::find($id);

        $data->metode = $request->metode;
        $data->kode_layanan = $request->kodelayanan;
        $data->biaya = $request->biaya;
        if(!$data->isDirty()){
            return response(['status' => 0, 'msg' => 'Tidak ada perubahan data.']);
        }
        $data->save();

        return response(['status' => 1, 'msg' => 'Ubah data berhasil.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        MetodeUji::destroy($id);

        return response(['status' => 1, 'msg' => 'Hapus data berhasil.']);
    }
}