<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\User;

class VendorController extends Controller
{
    public function show($id)
    {
        $vendor = Vendor::with('penanggungJawab')->findOrFail($id);
        return response()->json($vendor);
    }

    public function create()
    {
        $vendors = Vendor::with('penanggungJawab')->paginate(10);
        $users = User::where('role', 'vendor')->get();

        // Load view dengan data users
        return view('dashboard.vendor', compact('users', 'vendors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'vendor_name' => 'required|string|max:255',
            'alamat' => 'required|string',
            'alamat_gudang' => 'required|string',
            'penanggung_jawab' => 'required|exists:users,id',
        ]);

        // Simpan vendor baru
        Vendor::create([
            'vendor_name' => $request->vendor_name,
            'alamat' => $request->alamat,
            'alamat_gudang' => $request->alamat_gudang,
            'penanggung_jawab' => $request->penanggung_jawab,
        ]);

        // Redirect kembali ke halaman vendor dengan pesan sukses
        return redirect()->route('vendor.index')->with('success', 'Vendor created successfully.');
    }
}
