<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;

class MprojectController extends Controller
{
    public function getData()
    {
        $projects = Project::with('projectManager')->get();
        $staffs = User::where('role', 'staff')->get();
        
        return view('manager.project', compact('projects', 'staffs'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'project_name' => 'required|string|max:255',
                'project_id' => 'required|string|unique:projects',
                'project_manager_id' => 'required|exists:users,id'
            ]);

            $project = Project::create($validated);

            // Log activity
            $activityController = new ActivityController();
            $activityController->store(
                auth()->user()->id,
                'create',
                'Created new project: ' . $project->project_name
            );

            return redirect()->back()->with('success', 'Project has been successfully added!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function update(Request $request, Project $project)
    {
        try {
            $validated = $request->validate([
                'project_name' => 'required|string|max:255',
                'project_id' => 'required|string|unique:projects,project_id,' . $project->id,
                'project_manager_id' => 'required|exists:users,id'
            ]);

            $oldData = [
                'project_name' => $project->project_name,
                'project_id' => $project->project_id,
                'project_manager_id' => $project->project_manager_id,
            ];

            $project->update($validated);

            // Log changes
            $activityController = new ActivityController();
            $changes = [];

            if ($oldData['project_name'] !== $validated['project_name']) {
                $changes[] = "project name from '{$oldData['project_name']}' to '{$validated['project_name']}'";
            }

            if ($oldData['project_id'] !== $validated['project_id']) {
                $changes[] = "project ID from '{$oldData['project_id']}' to '{$validated['project_id']}'";
            }

            if ($oldData['project_manager_id'] !== $validated['project_manager_id']) {
                $oldManager = User::find($oldData['project_manager_id'])->name;
                $newManager = User::find($validated['project_manager_id'])->name;
                $changes[] = "project manager from '{$oldManager}' to '{$newManager}'";
            }

            if (!empty($changes)) {
                $activityController->store(
                    auth()->user()->id,
                    'update',
                    'Updated project ' . $project->project_name . ': Changed ' . implode(', ', $changes)
                );
            }

            return redirect()->back()->with('success', 'Project has been successfully updated!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function destroy(Project $project)
    {
        try {
            $projectName = $project->project_name;
            $project->delete();

            // Log activity
            $activityController = new ActivityController();
            $activityController->store(
                auth()->user()->id,
                'delete',
                'Deleted project: ' . $projectName
            );

            return redirect()->back()->with('success', 'Project has been successfully deleted!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
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
            
            // Get projects data before deletion for logging
            $projects = Project::whereIn('id', $validIds)->get();
            $projectNames = $projects->pluck('project_name')->toArray();
            
            // Delete projects
            $deleted = Project::whereIn('id', $validIds)->delete();
            
            if ($deleted) {
                // Log activity for successful bulk delete
                $activityController = new ActivityController();
                $activityController->store(
                    auth()->user()->id, 
                    'delete', 
                    'Bulk delete projects: ' . implode(', ', $projectNames)
                );

                DB::commit();
                return redirect()->back()->with('success', $deleted . ' projects have been successfully deleted');
            } else {
                DB::rollback();
                return redirect()->back()->with('error', 'Failed to delete projects');
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
