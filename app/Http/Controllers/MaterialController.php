<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MaterialRequest;

class MaterialController extends Controller
{
    public function index()
    {
    $materials = MaterialRequest::query()
        ->leftJoin('users', 'material_requests.request_by', '=', 'users.id')
        ->select([
            'material_requests.*', 
            'users.name as requester_name'
        ])
        ->latest()
        ->get();

    return view('vendor.materials', compact('materials'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:need_revision,rejected,approved',
            'remark' => 'nullable|string',
            'do_release' => 'required_if:status,approved|file|mimes:xlsx,xls|max:10240'
        ]);

        $material = MaterialRequest::findOrFail($id);
        
        $data = [
            'status' => $request->status,
            'remark' => $request->remark
        ];

        if ($request->status === 'approved') {
            $data['approval_date'] = now();
            
            if ($request->hasFile('do_release')) {
                $path = $request->file('do_release')->store('do_releases', 'public');
                $data['do_release'] = $path;
            }
        }

        $material->update($data);

        return redirect()->back()->with('success', 'Material request updated successfully');
    }
}
