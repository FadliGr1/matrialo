<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ActivityController;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;


class UserController extends Controller
{
    public function getData()
    {
        $users = User::all(); 
        return view('manager.user', compact('users'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'username' => 'required|unique:users',
                'email' => 'required|email|unique:users',
                'position' => 'required',
                'role' => 'required|in:manager,vendor,admin,staff',
                'password' => 'required|confirmed',
                'profile_photo' => 'nullable|image',
                'sign_photo' => 'nullable|image',
            ]);

            $user = new User();
            $user->name = $request->name;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->position = $request->position;
            $user->role = $request->role;
            $user->password = Hash::make($request->password);

            if ($request->hasFile('profile_photo')) {
                $profilePhoto = $request->file('profile_photo');
                $profilePhotoPath = $profilePhoto->store('profile-photos', 'public');
                $user->profile_photo_path = $profilePhotoPath;
            } else {
                $user->profile_photo_path = 'profile-photos/default.png';
            }

            if ($request->hasFile('sign_photo')) {
                $signPhoto = $request->file('sign_photo');
                $signPhotoPath = $signPhoto->store('sign-photos', 'public');
                $user->sign_photo_path = $signPhotoPath;
            } else {
                $user->sign_photo_path = 'sign-photos/default.png';
            }

            $user->save();
            // Log::info('User added successfully', ['user' => $user]);

            $activityController = new ActivityController();
            $activityController->store(auth()->user()->id, 'create', 'User added: ' . $user->name); 

            return redirect()->route('manager.user')->with('success', 'User added successfully.');
        } catch (\Exception $e) {
            // Log::error('Error adding user', ['exception' => $e->getMessage()]);
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function update(Request $request)
    {
        try {
            $user = auth()->user();
            
            // Validasi role
            if ($request->has('role') && $user->role !== 'manager') {
                throw new \Exception('You are not authorized to modify role information');
            }

            $request->validate([
                'name' => 'required',
                'username' => 'required|unique:users,username,'.$user->id,
                'email' => 'required|email|unique:users,email,'.$user->id,
                'position' => 'required',
                'profile_photo' => 'nullable|image',
                'sign_photo' => 'nullable|image',
            ]);

            // Update basic info
            $user->name = $request->name;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->position = $request->position;

            // Handle profile photo
            if ($request->hasFile('profile_photo')) {
                if ($user->profile_photo_path && $user->profile_photo_path != 'profile-photos/default.png') {
                    Storage::disk('public')->delete($user->profile_photo_path);
                }
                $profilePhotoPath = $request->file('profile_photo')->store('profile-photos', 'public');
                $user->profile_photo_path = $profilePhotoPath;
            }

            // Handle sign photo
            if ($request->hasFile('sign_photo')) {
                if ($user->sign_photo_path && $user->sign_photo_path != 'sign-photos/default.png') {
                    Storage::disk('public')->delete($user->sign_photo_path);
                }
                $signPhotoPath = $request->file('sign_photo')->store('sign-photos', 'public');
                $user->sign_photo_path = $signPhotoPath;
            }

            $user->save();

            // Log activity
            $activityController = new ActivityController();
            $activityController->store(
                auth()->user()->id, 
                'update', 
                'Updated profile information'
            );

            return redirect()->back()->with('success', 'Profile updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function updatePassword(Request $request)
    {
        try {
            $request->validate([
                'current_password' => 'required',
                'password' => 'required|confirmed|min:6'
            ]);

            $user = auth()->user();

            // Check current password
            if (!Hash::check($request->current_password, $user->password)) {
                return redirect()->back()->with('error', 'Current password is incorrect');
            }

            // Update password
            $user->update([
                'password' => Hash::make($request->password)
            ]);

            // Log activity
            $activityController = new ActivityController();
            $activityController->store(
                auth()->user()->id,
                'update',
                'Password updated successfully'
            );

            return redirect()->back()->with('success', 'Password has been updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy(User $user)
    {
        if ($user->id == auth()->user()->id) {
            return redirect()->back()->with('warning', 'You cannot delete your own account.');
        }

        // Check relationships
        if ($user->projects()->exists()) {
            return redirect()->back()->with('error', 'Cannot delete user because they are assigned as Project Manager.');
        }

        if ($user->vendors()->exists()) {
            return redirect()->back()->with('error', 'Cannot delete user because they are assigned as Person Responsible in Vendor.');
        }

        $user->delete();

        $activityController = new ActivityController();
        $activityController->store(auth()->user()->id, 'delete', ' deleted user: ' . $user->username);
        return redirect()->route('manager.user')->with('success', 'User deleted successfully.');
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
            
            // Filter ID yang valid
            $validIds = array_filter($ids, function($id) {
                return is_numeric($id) && $id > 0;
            });
            
            if (empty($validIds)) {
                DB::rollback();
                return redirect()->back()->with('error', 'No valid ID to delete');
            }
            
            // Pisahkan ID yang bisa dihapus dan yang tidak
            $currentUserId = auth()->user()->id;
            $idsToDelete = array_filter($validIds, function($id) use ($currentUserId) {
                return $id != $currentUserId;
            });
            
            // Jika semua ID yang dipilih adalah ID user yang login
            if (empty($idsToDelete)) {
                DB::rollback();
                return redirect()->back()->with('warning', 'You cannot delete your own account');
            }

            // Check for relationships
            $usersWithRelations = User::whereIn('id', $idsToDelete)
            ->where(function($query) {
                $query->whereHas('projects')
                    ->orWhereHas('vendors', function($q) {
                        $q->whereNotNull('person_responsible');
                    });
            })
            ->get();

            if ($usersWithRelations->isNotEmpty()) {
                $restrictedUsers = [];
                foreach ($usersWithRelations as $user) {
                    $restrictions = [];
                    if ($user->projects()->exists()) {
                        $restrictions[] = "Project Manager";
                    }
                    if ($user->vendors()->exists()) {
                        $restrictions[] = "Vendor Person Responsible";
                    }
                    
                    $restrictedUsers[] = "{$user->name} (" . implode(", ", $restrictions) . ")";
                }

                DB::rollback();
                return redirect()->back()
                    ->with('error', 'Cannot delete the following users due to existing relationships: ' . implode('; ', $restrictedUsers));
            }
            \Log::info('Valid IDs to delete:', ['ids' => $idsToDelete]);
            
            // Ambil data users sebelum dihapus untuk log
            $users = User::whereIn('id', $idsToDelete)->get();
            $userNames = $users->pluck('name')->toArray();
            \Log::info('Users to delete:', ['count' => $users->count(), 'users' => $users->pluck('id')->toArray()]);
            
            // Hapus user
            $deleted = User::whereIn('id', $idsToDelete)->delete();
            \Log::info('Deleted count:', ['count' => $deleted]);
            
            if ($deleted) {
                // Log activity untuk bulk delete
                $activityController = new ActivityController();
                $activityController->store(
                    auth()->user()->id, 
                    'delete', 
                    'Bulk delete users: ' . implode(', ', $userNames)
                );

                $message = $deleted . ' data has been successfully deleted';
                if (in_array($currentUserId, $validIds)) {
                    $message .= ' (excluding your account)';
                    
                    $activityController->store(
                        auth()->user()->id, 
                        'warning', 
                        'Attempted to delete own account in bulk delete operation'
                    );
                }
                
                DB::commit();
                return redirect()->back()->with('success', $message);
            } else {
                $activityController = new ActivityController();
                $activityController->store(
                    auth()->user()->id, 
                    'error', 
                    'Failed to bulk delete users: ' . implode(', ', $userNames)
                );
                
                DB::rollback();
                return redirect()->back()->with('error', 'Failed to delete data');
            }
            
        } catch (\Exception $e) {
            $activityController = new ActivityController();
            $activityController->store(
                auth()->user()->id, 
                'error', 
                'Error in bulk delete operation: ' . $e->getMessage()
            );
            
            DB::rollback();
            \Log::error('Error in bulk delete:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
