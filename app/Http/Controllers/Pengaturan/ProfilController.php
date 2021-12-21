<?php

namespace App\Http\Controllers\Pengaturan;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller
{
    public function index()
    {
        $title = 'Profil';
        return view('admin.pengaturan.profil', compact('title'));
    }

    public function changepwd(Request $request)
    {
        $this->validate($request, [
            'current' => 'required',
            'new' => 'required',
            'new2' => 'required|same:new',
        ],[],[
            'new' => 'New Password',
            'new2' => 'Second New Password',
        ]);

        if (!Hash::check($request->current, auth()->user()->password)) {
            return response(['status' => 0, 'msg' => 'Current password is not match our record']);
        }

        $user = User::find(auth()->user()->id);
        $user->password = Hash::make($request->new);
        $user->save();

        return response(['status' => 1, 'msg' => 'Update password success']);
    }
}
