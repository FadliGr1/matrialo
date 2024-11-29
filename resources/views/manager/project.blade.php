@extends('layouts.navbar')
@section('content')
<div class="row">
    <div class="col-12">
        <h2 class="content-title">Project</h2>
        <h5 class="content-desc mb-4">Build your project</h5>
    </div>

    <div class="col-12">
        <div class="statistics-card">
            <span class="d-flex justify-content-between align-content-center">
                <h3 class="content-desc">List of vendors</h3>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProject">
                    <i class="fas fa-user-plus"></i> Add Project
                </button>
            </span>
              
            <div class="table-responsive">        
                <table id="myTable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Project Name</th>
                            <th>Project ID</th>
                            <th>Project Manager</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($projects as $index => $project)
                        <tr data-id="{{ $project->id }}">
                            
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $project->project_name }}</td>
                            <td>{{ $project->project_id }}</td>
                            <td>{{ $project->projectManager->name }}</td>
                            <td>
                                <button type="button" class="action-btn view-btn" title="View" 
                                    data-bs-toggle="modal" data-bs-target="#viewProjectModal{{ $project->id }}">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button type="button" class="action-btn delete-btn" title="Delete" 
                                    onclick="deleteConfirmation(
                                        '{{ $project->id }}', 
                                        '{{ $project->project_name }}', 
                                        'project',
                                        '{{ route('manager.project.destroy', $project->id) }}'
                                    )">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Modal Edit Project (di dalam loop) --}}
<div class="modal fade" id="viewProjectModal{{ $project->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content p-3">
            <div class="modal-header">
                <h5 class="modal-title">Edit Project</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('manager.project.update', $project->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="project_name" class="form-label">Project Name</label>
                        <input type="text" class="form-control" name="project_name" 
                            value="{{ $project->project_name }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="project_id" class="form-label">Project ID</label>
                        <input type="text" class="form-control" name="project_id" 
                            value="{{ $project->project_id }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="project_manager_id" class="form-label">Project Manager</label>
                        <select class="form-select" name="project_manager_id" required>
                            @foreach($staffs as $staff)
                                <option value="{{ $staff->id }}" 
                                    {{ $project->project_manager_id == $staff->id ? 'selected' : '' }}>
                                    {{ $staff->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary col-12">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- Modal Add Project --}}
<div class="modal fade" id="addProject" tabindex="-1" aria-labelledby="addProjectLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content p-3">
            <div class="modal-header">
                <h5 class="modal-title" id="addProjectLabel">Add Project</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('manager.project.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="project_name" class="form-label">Project Name</label>
                        <input type="text" class="form-control @error('project_name') is-invalid @enderror" 
                            name="project_name" value="{{ old('project_name') }}" required>
                        @error('project_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="project_id" class="form-label">Project ID</label>
                        <input type="text" class="form-control @error('project_id') is-invalid @enderror" 
                            name="project_id" value="{{ old('project_id') }}" required>
                        @error('project_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="project_manager_id" class="form-label">Project Manager</label>
                        <select class="form-select @error('project_manager_id') is-invalid @enderror" 
                            name="project_manager_id" required>
                            <option value="">Select Project Manager</option>
                            @foreach($staffs as $staff)
                                <option value="{{ $staff->id }}">{{ $staff->name }}</option>
                            @endforeach
                        </select>
                        @error('project_manager_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary col-12">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection