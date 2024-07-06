<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AWSConfig;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Exception;

class AWSController extends Controller
{
    public function showConfigForm()
    {
        $awsConfig = AWSConfig::first();
        return view('setting.integration', compact('awsConfig'));
    }

    public function saveConfig(Request $request)
    {
        $request->validate([
            'aws_access_key' => 'required',
            'aws_secret_key' => 'required',
            'aws_bucket' => 'required',
            'aws_region' => 'required',
            'aws_endpoint' => 'required',
        ]);

        $awsConfig = AWSConfig::firstOrCreate([]);
        $awsConfig->update([
            'aws_access_key' => $request->aws_access_key,
            'aws_secret_key' => $request->aws_secret_key,
            'aws_bucket' => $request->aws_bucket,
            'aws_region' => $request->aws_region,
            'aws_endpoint' => $request->aws_endpoint,
        ]);

        return redirect()->back()->with('success', 'AWS S3 Config berhasil disimpan!');
    }

    public function testConnection()
    {
        try {
            // Coba membuat direktori 'test-folder'
            $result = Storage::disk('s3')->makeDirectory('Matrialo S3');

            // Jika berhasil, hapus direktori dan kembali dengan pesan sukses
            if ($result) {
                // Storage::disk('s3')->deleteDirectory('');
                return back()->with('success', 'Koneksi berhasil, Anda akan melihat folder baru "Matrialo S3" di bucket Anda.');
            } else {
                return back()->with('error', 'Koneksi Gagal.');
            }
        } catch (Exception $e) {
            // Tangkap exception dan kembalikan pesan error
            return back()->with('error', 'Koneksi Gagal, periksa konfigurasi anda lalu coba lagi.');
        }
    }
}
