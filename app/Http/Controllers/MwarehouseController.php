<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ActivityController;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Warehouse;

class MwarehouseController extends Controller
{
    public function getData() 
    {
        $warehouses = Warehouse::select([
            'id',
            'name',
            'address',
            'pole_capacity',
            'cable_capacity',
            'acc_capacity',
            'used_pole_capacity',
            'used_cable_capacity',
            'used_acc_capacity'
        ])->get();
        return view('manager.warehouse', compact('warehouses'));
    }

    public function store(Request $request)
    {
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'pole_capacity' => 'required|integer|min:0',
            'cable_capacity' => 'required|integer|min:0',
            'acc_capacity' => 'required|integer|min:0',
        ]);

        try {
            
            $validated['used_pole_capacity'] = 0;
            $validated['used_cable_capacity'] = 0;
            $validated['used_acc_capacity'] = 0;

            
            $warehouse = Warehouse::create($validated);

            // Log activity
            $activityController = new ActivityController();
            $activityController->store(
                auth()->user()->id, 
                'create',
                'Created new warehouse: ' . $warehouse->name
            );

            return redirect()->back()
                ->with('success', 'Warehouse has been successfully added!');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to add warehouse. Please try again!' . $e->getMessage());
        }
    }

    public function update(Request $request, Warehouse $warehouse)
    {
        try {
            // Validasi input
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'address' => 'required|string',
                'pole_capacity' => [
                    'required',
                    'integer',
                    function ($attribute, $value, $fail) use ($warehouse) {
                        if ($value < $warehouse->used_pole_capacity) {
                            $fail('Pole capacity cannot be less than currently used capacity (' . $warehouse->used_pole_capacity . ')');
                        }
                    }
                ],
                'cable_capacity' => [
                    'required',
                    'integer',
                    function ($attribute, $value, $fail) use ($warehouse) {
                        if ($value < $warehouse->used_cable_capacity) {
                            $fail('Cable capacity cannot be less than currently used capacity (' . $warehouse->used_cable_capacity . ')');
                        }
                    }
                ],
                'acc_capacity' => [
                    'required',
                    'integer',
                    function ($attribute, $value, $fail) use ($warehouse) {
                        if ($value < $warehouse->used_acc_capacity) {
                            $fail('Acc capacity cannot be less than currently used capacity (' . $warehouse->used_acc_capacity . ')');
                        }
                    }
                ],
            ]);

            // Simpan data lama sebelum update
            $oldData = [
                'name' => $warehouse->name,
                'address' => $warehouse->address,
                'pole_capacity' => $warehouse->pole_capacity,
                'cable_capacity' => $warehouse->cable_capacity,
                'acc_capacity' => $warehouse->acc_capacity,
            ];

            // Update warehouse
            $warehouse->update($validated);

            // Log activity untuk setiap perubahan
            $activityController = new ActivityController();
            $changes = [];

            // Cek perubahan nama
            if ($oldData['name'] !== $validated['name']) {
                $changes[] = "name from '{$oldData['name']}' to '{$validated['name']}'";
            }

            // Cek perubahan alamat
            if ($oldData['address'] !== $validated['address']) {
                $changes[] = "address from '{$oldData['address']}' to '{$validated['address']}'";
            }

            // Cek perubahan kapasitas pole
            if ((int)$oldData['pole_capacity'] !== (int)$validated['pole_capacity']) {
                $changes[] = "pole capacity from {$oldData['pole_capacity']} to {$validated['pole_capacity']}";
            }

            // Cek perubahan kapasitas cable
            if ((int)$oldData['cable_capacity'] !== (int)$validated['cable_capacity']) {
                $changes[] = "cable capacity from {$oldData['cable_capacity']} to {$validated['cable_capacity']}";
            }

            // Cek perubahan kapasitas acc
            if ((int)$oldData['acc_capacity'] !== (int)$validated['acc_capacity']) {
                $changes[] = "acc capacity from {$oldData['acc_capacity']} to {$validated['acc_capacity']}";
            }

            // Log hanya jika ada perubahan
            if (!empty($changes)) {
                $activityController->store(
                    auth()->user()->id,
                    'update',
                    'Updated warehouse ' . $validated['name'] . ': Changed ' . implode(', ', $changes)
                );
            }

            return redirect()->back()->with('success', 'Warehouse has been successfully updated!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function destroy(Warehouse $warehouse)
    {
        try {
            // Cek apakah ada kapasitas yang terpakai
            if ($warehouse->used_pole_capacity > 0 || 
                $warehouse->used_cable_capacity > 0 || 
                $warehouse->used_acc_capacity > 0) {
                return redirect()->back()
                    ->with('warning', 'Cannot delete warehouse that still has items stored!');
            }

            $warehouseName = $warehouse->name;
            $warehouse->delete();

            // Log activity
            $activityController = new ActivityController();
            $activityController->store(
                auth()->user()->id, 
                'delete',
                'Deleted warehouse: ' . $warehouseName
            );
            return redirect()->back()->with('success', 'Warehouse has been successfully deleted!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to process your request. Please try again! ' . $e->getMessage());
        }
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
        
        // Get warehouses data before deletion for logging
        $warehouses = Warehouse::whereIn('id', $validIds)->get();
        
        // Cek kapasitas terpakai
        foreach($warehouses as $warehouse) {
            if ($warehouse->used_pole_capacity > 0 || 
                $warehouse->used_cable_capacity > 0 || 
                $warehouse->used_acc_capacity > 0) {
                DB::rollback();
                return redirect()->back()
                    ->with('warning', 'Cannot delete warehouse ' . $warehouse->name . ' because it still has items stored!');
            }
        }

        $warehouseNames = $warehouses->pluck('name')->toArray();
        
        // Delete warehouses
        $deleted = Warehouse::whereIn('id', $validIds)->delete();
        
        if ($deleted) {
            // Log activity for successful bulk delete 
            $activityController = new ActivityController();
            $activityController->store(
                auth()->user()->id, 
                'delete', 
                'Bulk delete warehouses: ' . implode(', ', $warehouseNames)
            );

            DB::commit();
            return redirect()->back()->with('success', $deleted . ' warehouses have been successfully deleted');
        } else {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to delete warehouses');
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
