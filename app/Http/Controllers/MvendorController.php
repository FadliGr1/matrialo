<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ActivityController;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\User;

class MvendorController extends Controller
{
    public function getData()
    {
        $vendors = Vendor::with('user')->get();
        $vendorUsers = User::where('role', 'vendor')->get();
        return view('manager.vendor', compact('vendors', 'vendorUsers'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'vendor_name' => 'required',
            'address' => 'required',
            'warehouse_address' => 'required',
            'person_responsible' => 'nullable|exists:users,id',
        ]);

        $vendor = Vendor::create($validatedData);

        $activityController = new ActivityController();
        $activityController->store(auth()->user()->id, 'create', 'Vendor added: ' . $vendor->vendor_name);

        return redirect()->route('manager.vendor')->with('success', 'Vendor added successfully.');
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $vendor = Vendor::findOrFail($id);
            
            // Update vendor
            $vendor->update([
                'vendor_name' => $request->vendor_name,
                'address' => $request->address,
                'warehouse_address' => $request->warehouse_address,
                'person_responsible' => $request->user_id  // Ubah ini sesuai nama kolom di database
            ]);

            // Log activity
            $activityController = new ActivityController();
            $activityController->store(
                auth()->user()->id, 
                'update', 
                'Vendor updated: ' . $vendor->vendor_name
            );

            DB::commit();
            return redirect()->back()->with('success', 'Vendor has been successfully updated');

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Error updating vendor:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'Failed to update vendor');
        }
    }

    public function destroy(Vendor $vendor)
    {
        $vendor->delete();

        $activityController = new ActivityController();
        $activityController->store(auth()->user()->id, 'delete', ' deleted vendor: ' . $vendor->vendor_name);
        return redirect()->route('manager.vendor')->with('success', 'Vendor deleted successfully.');
    }

    public function bulkDestroy(Request $request)
    {
        DB::beginTransaction();
        try {
            \Log::info('Request data:', $request->all());
            
            $ids = $request->input('ids');
            \Log::info('IDs received:', ['ids' => $ids]);
            
            if (!is_array($ids) || empty($ids)) {
                DB::rollback();
                return redirect()->back()->with('error', 'No data selected');
            }
            
            // Filter valid IDs
            $validIds = array_filter($ids, function($id) {
                return is_numeric($id) && $id > 0;
            });
            
            if (empty($validIds)) {
                DB::rollback();
                return redirect()->back()->with('error', 'No valid ID to delete');
            }
            
            \Log::info('Valid IDs to delete:', ['ids' => $validIds]);
            
            // Get vendors data before deletion for logging
            $vendors = Vendor::whereIn('id', $validIds)->get();
            $vendorNames = $vendors->pluck('vendor_name')->toArray();
            
            // Delete vendors
            $deleted = Vendor::whereIn('id', $validIds)->delete();
            
            if ($deleted) {
                // Log activity for successful bulk delete
                $activityController = new ActivityController();
                $activityController->store(
                    auth()->user()->id, 
                    'delete', 
                    'Bulk delete vendors: ' . implode(', ', $vendorNames)
                );

                DB::commit();
                return redirect()->back()->with('success', $deleted . ' vendors have been successfully deleted');
            } else {
                DB::rollback();
                return redirect()->back()->with('error', 'Failed to delete vendors');
            }
            
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Error in bulk delete:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
