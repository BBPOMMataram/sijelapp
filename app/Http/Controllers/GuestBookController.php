<?php

namespace App\Http\Controllers;

use App\Events\GuestArrived;
use App\Models\GuestBook;
use App\Models\PemilikSampel;
use Illuminate\Http\Request;

class GuestBookController extends Controller
{
    public function index(Request $request)
    {
        $value_per_page = $request->query('value_per_page');

        //handle request without pagination
        if (!$value_per_page) {
            $data = GuestBook::all();
            return response()->json($data);
        }

        $data = GuestBook::paginate($value_per_page);
        //add query string to all response links
        $data->appends(['value_per_page' => $value_per_page]);


        return response()->json($data);
    }

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

    public function getByName($name)
    {
        $guest = GuestBook::where('name', $name)->first();
        if (!$guest) {
            $guest = PemilikSampel::where('nama_petugas', $name)->first();
            $guest->hp = $guest->telepon_petugas;
            $guest->email = $guest->email_petugas;
            $guest->pangkat = $guest->pangkat_petugas;
            $guest->jabatan = $guest->jabatan_petugas;
            $guest->company = $guest->nama_pemilik;
            $guest->address = $guest->alamat_pemilik;
        }

        return response()->json($guest);
    }
}
