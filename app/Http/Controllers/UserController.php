<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('actions', function ($data) {
                    $btn = '<a href="#"><i class="fas fa-eye text-primary show"></i></a>';
                    $btn .= '<a href="#"><i class="fas fa-pen text-info edit mx-1"></i></a>';
                    if ($data->level !== 0) {
                        $btn .= '<a href="#"><i class="fas fa-trash text-danger delete"></i></a>';
                    }
                    return $btn;
                })
                ->addColumn('image', function($data){
                    $result = '<img src="'.Storage::url($data->image).'" alt="profile photo" width="50px" />';
                    return $result;
                })
                ->addColumn('level_string', function($data){
                    $result = '';
                        switch ($data->level) {
                            case 0:
                                $result = 'Super Admin';
                                break;
                            case 1:
                                $result = 'Petugas MA';
                                break;
                            case 2:
                                $result = 'Petugas Pengujian';
                                break;
            
                            default:
                                $result = 'Not defined';
                                break;
                        }
                    return $result;
                })
                ->rawColumns(['actions', 'image'])
                ->toJson();
        }
        $title = 'User Management';
        return view('admin.master.usermanagement', compact('title'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'username' => 'required|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'level' => 'required|digits_between:0,2',
        ]);

        $data = new User();

        $data->name = $request->name;
        $data->username = $request->username;
        $data->email = $request->email;
        $data->level = $request->level;
        $data->password = Hash::make('password');
        $data->save();

        if ($request->image) {
            $filename = $data->id . '.' . $request->image->getClientOriginalExtension();
            $path = $request->image->storeAs('profiles', $filename);
            $data->image = $path;
            $data->save();
        }

        return response(['status' => 1, 'msg' => 'Tambah data berhasil.']);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            // 'username' => ['required', Rule::unique('users')->ignore($id)],
            'email' => ['required','email', Rule::unique('users')->ignore($id)],
            'level' => 'required|digits_between:0,2',
        ]);

        $data = User::find($id);
        $data->name = $request->name;
        $data->username = $request->username;
        $data->email = $request->email;
        
        if ($data->level === 0 && $request->level != 0) {
            return response(['status' => 0, 'msg' => 'Tidak boleh merubah level superuser !!']);
        }

        $data->level = $request->level;

        // if(!$data->isDirty()){
        //     return response(['status' => 0, 'msg' => 'Tidak ada perubahan data.']);
        // }

        $data->save();

        if ($request->image) {
            Storage::delete($data->image);
            $filename = $data->id . '.' . $request->image->getClientOriginalExtension();
            $path = $request->image->storeAs('profiles', $filename);
            $data->image = $path;
            $data->save();
        }

        return response(['status' => 1, 'msg' => 'Ubah data berhasil.']);
    }

    public function destroy($id)
    {
        $data = User::find($id);
        if ($data->image !== 'noimage.png') {
            Storage::delete($data->image);
        }
        $data->delete();

        return response(['status' => 1, 'msg' => 'Hapus data berhasil.']);
    }

    public function resetpwd($id)
    {
        $data = User::find($id);
        $data->password = Hash::make('password');
        $data->save();
  
        return response(['status' => 1, 'msg' => 'Reset password berhasil.']);
    }
}
