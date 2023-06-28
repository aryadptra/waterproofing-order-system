<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $user = User::all();

        return view('admin.user.index', [
            'user' => $user,
        ]);
    }

    public function create()
    {
        return view('admin.user.create');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required|min:3|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|max:255',
            'role' => 'required|in:admin,user',
        ]);

        if ($request->password) {
            $password = bcrypt($request->password);

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone ?? null,
                'address' => $request->address ?? null,
                'password' => $password,
                'role' => $request->role,
            ]);
        }

        return redirect()->route('admin.user.index')->with('success', 'User berhasil ditambahkan');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('admin.user.edit', [
            'user' => $user,
        ]);
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required|min:3|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'nullable|numeric',
            'address' => 'nullable|min:3|max:255',
            'password' => 'nullable|min:8|max:255',
            'role' => 'required|in:admin,user',
        ]);

        $name = $request->name;
        $email = $request->email;
        $phone = $request->phone;
        $address = $request->address;
        $role = $request->role;

        // If password is not empty, then update password
        if ($request->password) {
            $password = bcrypt($request->password);

            $user = User::findOrFail($id);
            $user->update([
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'address' => $address,
                'password' => $password,
                'role' => $role,
            ]);
        } else {
            $user = User::findOrFail($id);
            $user->update([
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'address' => $address,
                'role' => $role,
            ]);
        }

        return redirect()->route('admin.user.index')->with('success', 'User berhasil diupdate');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.user.index')->with('success', 'User berhasil dihapus');
    }
}
