<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        return view('user.user.dashboard');
    }

    public function profile()
    {
        return view('user.user.profile');
    }

    // Index Profile
    public function indexProfile()
    {
        return view('user.user.profile');
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'email',
            'phone' => 'required|numeric',
            'address' => 'required|string|max:255',
        ]);

        $user = User::find(Auth::user()->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address
        ]);

        if ($user->save()) {
            return redirect()->back()->with('success', 'Profile berhasil diupdate');
        } else {


            return redirect()->back()->with('error', 'Profile gagal diupdate');
        }
    }
}
