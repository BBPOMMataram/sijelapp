<?php

namespace App\Http\Controllers;

use App\Models\StatusSampel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class StatusUjiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Status Uji';
        return view('admin.master.statusuji', compact('title'));
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
        //
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
            'label' => 'required',
        ]);

        $data = StatusSampel::find($id);

        $data->label = $request->label;
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
        //
    }

    public function dtstatusuji()
    {
        $data = StatusSampel::all();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function ($data) {
                $btn = '<a href="#"><i class="fas fa-pen text-info edit mx-1"></i></a>';
                return $btn;
            })
            ->rawColumns(['actions'])
            ->toJson();
    }
}
