<?php

namespace App\Http\Controllers;

use App\Events\GuestArrived;
use App\Models\GuestBook;
use App\Models\PemilikSampel;
use Illuminate\Http\Request;

class GuestBookController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string'],
            'hp' => ['required', 'string'],
            'service' => ['required'],
        ]);

        $data = new GuestBook();
        $data->name = $request->name;
        $data->hp = $request->hp;
        $data->service = $request->service;
        $data->company = $request->company;
        $data->address = $request->address;
        $data->email = $request->email;
        $data->pangkat = $request->pangkat;
        $data->jabatan = $request->jabatan;

        if ($request->selfie) {
            $filename = $data->id . '.' . $request->selfie->getClientOriginalExtension();
            $path = $request->selfie->storeAs('guests', $filename);
            $data->selfie = $path;
        }

        $data->save();

        GuestArrived::dispatch(['data' => $data]);

        return response()->json(['status' => 1, 'msg' => 'Saved', 'data' => $data]);
    }

    public function getAllGuests_Sijelapp()
    {
        $data = PemilikSampel::all();
        return $data;
    }
}
