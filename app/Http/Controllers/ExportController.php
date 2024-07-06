<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use Exception;

class ExportController extends Controller
{
    public function exportUsers()
    {
        try {
            $file = Excel::download(new UsersExport, 'users.xlsx');
            session()->flash('success', 'File berhasil diunduh.');
            return $file;
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengunduh file.');
        }
    }
}
