<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function index(string $locale)
    {
        $admins = Admin::all();
        return view('admin.account.index', compact('admins', 'locale'));
    }

    public function store(Request $request, string $locale)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins',
            'password' => 'required|string|min:8|confirmed',
        ]);

        Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.account.index', ['locale' => $locale])->with('success', 'Admin account berhasil dibuat!');
    }

    public function update(Request $request, string $locale, $id)
    {
        $admin = Admin::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email,' . $admin->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $data = ['name' => $request->name, 'email' => $request->email];
        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $admin->update($data);
        return redirect()->route('admin.account.index', ['locale' => $locale])->with('success', 'Admin account berhasil diupdate!');
    }

    public function destroy(string $locale, $id)
    {
        if ($id == auth('admin')->id()) {
            return redirect()->route('admin.account.index', ['locale' => $locale])->with('error', 'Tidak bisa menghapus akun sendiri!');
        }
        Admin::findOrFail($id)->delete();
        return redirect()->route('admin.account.index', ['locale' => $locale])->with('success', 'Admin account berhasil dihapus!');
    }
}
