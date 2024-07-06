<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PagesController extends Controller
{
    public function welcome()
    {
        return view('welcome');
    }

    // Administrator/Super Admin/Manager
    public function dashboardIndex()
    {
        return view('dashboard.index');
    }

    public function dashboardUser()
    {
        $users = User::paginate(10);

        return view('dashboard.user', compact('users'));
    }

    // adduser
    public function storeUser(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'role' => 'required',
            'profile_photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'signature_photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Buat user baru
        $user = new User();
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->jabatan = $request->jabatan;
        $user->password = bcrypt($request->password);
        $user->role = $request->role;

        // Simpan profile photo
        if ($request->hasFile('profile_photo')) {
            $profilePhotoPath = $request->file('profile_photo')->store('profile-photos', 'public');
            $user->profile_photo_path = $profilePhotoPath;
        }

        // Simpan signature photo
        if ($request->hasFile('signature_photo')) {
            $signaturePhotoPath = $request->file('signature_photo')->store('signature-photos', 'public');
            $user->signature_photo_path = $signaturePhotoPath;
        }

        // Simpan user
        $user->save();

        // Redirect dengan pesan sukses
        return redirect('/user')->with('success', 'User berhasil ditambahkan');
    }

    // profile
    public function settingProfile(Request $request)
    {
        $user = Auth::user();
        return view('setting.profile', compact('user'));
    }

    // view user
    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    // show user setting
    public function showSetting()
    {
        return view('dashboard.setting');
    }

    // update user setting
    public function updateSetting(Request $request)
    {
        $user = Auth::user();

        // Validasi input
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users,username,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'jabatan' => 'required',
            'role' => 'required',
            'current_password' => 'required',
            'profile_photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'signature_photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Verifikasi password saat ini
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with('error', 'Password saat ini tidak cocok.');
        }

        // Update user
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->jabatan = $request->jabatan;
        $user->role = $request->role;

        // Simpan profile photo
        if ($request->hasFile('profile_photo')) {
            $profilePhotoPath = $request->file('profile_photo')->store('profile-photos', 'public');
            $user->profile_photo_path = $profilePhotoPath;
        }

        // Simpan signature photo
        if ($request->hasFile('signature_photo')) {
            $signaturePhotoPath = $request->file('signature_photo')->store('signature-photos', 'public');
            $user->signature_photo_path = $signaturePhotoPath;
        }

        // Simpan user
        $user->save();

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Profil berhasil diperbarui');
    }

    // search user
    public function ajaxSearch(Request $request)
    {
        $query = $request->input('query');
        $users = User::where('name', 'LIKE', "%$query%")
            ->orWhere('email', 'LIKE', "%$query%")
            ->get();

        return response()->json($users);
    }

    // getuser
    public function getUser($id)
    {
        $user = User::findOrFail($id);
        return view('component.detail', compact('user'));
    }

    // updateUser
    public function updateUser()
    {
        return view('dashboard.setting');
    }

    // setting security
    public function settingSecurity()
    {
        return view('setting.security');
    }

    // update password
    public function updateSecurity(Request $request)
    {
        // Validasi input
        $request->validate([
            'new_password' => 'required|confirmed',
            'current_password' => 'required',
        ], [
            'new_password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);
        $user = Auth::user();

        // Cek apakah current_password cocok dengan password user saat ini
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->route('security.update')->with('error', 'Password saat ini salah.');
        }

        // validasi new_password
        if (strlen($request->new_password) < 8) {
            return redirect()->route('security.update')->with('error', 'Password baru harus minimal 8 karakter.');
        }

        // Update password user
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('security.update')->with('success', 'Password berhasil diperbarui.');
    }

    // Setting App

    public function settingApp()
    {
        return view('setting.app');
    }

    public function Integration()
    {
        return view('setting.integration');
    }
}
