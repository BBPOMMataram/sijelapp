<?php

namespace App\Http\Controllers;

use App\Events\GuestArrived;
use App\Models\GuestBook;
use App\Models\PemilikSampel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class GuestBookController extends Controller
{
    public function index2()
    {
        $title = 'Data Tamu';
        return view('admin.guestbook.index', compact('title'));
    }

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
        $data->selfie = $request->file("selfie");

        try {
            $folderName = 'guest-images';
            // $path = Storage::put($folderName, $data->selfie);
            $path = $request->file("selfie")->store($folderName);
            $data->selfie = $path;
        } catch (\Exception $th) {
            return response()->json(['message' => $th->getMessage()], 400);
        }

        $data->save();

        $data->service = $data->serviceType->name;

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

    public function guestbook_dt()
    {
        $data = GuestBook::with('serviceType')->latest();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('actions', function ($data) {
                $btn = '<a href="#"><i class="fas fa-eye text-primary show"></i></a>';
                // $btn .= '<a href="#"><i class="fas fa-pen text-info edit mx-1"></i></a>';
                // $btn .= '<a href="#"><i class="fas fa-trash text-danger delete"></i></a>';

                return $btn;
            })
            ->addColumn('selfie', function ($data) {
                $result = '<img src="' . $data->selfie . '" alt="profile photo" width="50px" />';
                return $result;
            })
            ->addColumn('service', function ($data) {
                return $data->serviceType->name;
            })
            ->rawColumns(['actions', 'selfie'])
            ->toJson();
    }
}
