@extends('layouts.navbar')
@section('content')
<div class="row">
    <div class="col-12">
        <h2 class="content-title">Users</h2>
        <h5 class="content-desc mb-4">Controll user access & roles</h5>
    </div>

    <div class="col-12">
        <div class="statistics-card">
            <span class="d-flex justify-content-between align-content-center">
                <h3 class="content-desc">List of users</h3>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUser">
                    <i class="fas fa-user-plus"></i> Add User
                </button>
            </span>
              
            <div class="table-responsive">        
                <table id="myTable" class="table table-striped">
                    <thead>
                        <tr>
                            <th style="display: none">No</th>
                            <th>Pict</th>
                            <th>Full Name</th>
                            <th>Position</th>
                            <th>Role</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    @foreach ($users as $user)
                        <tr data-id="{{ $user->id }}">
                            <td style="display: none">{{ $loop->iteration }}</td>
                            <td><img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="{{ $user->name }}" width="50" height="50" class="rounded-circle"></td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->position }}</td>
                            <td>{{ $user->role }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <button type="button" class="action-btn view-btn" title="View" data-bs-toggle="modal" data-bs-target="#viewUserModal{{ $user->id }}">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button type="button" class="action-btn delete-btn" title="Delete" 
                                    onclick="deleteConfirmation(
                                        '{{ $user->id }}', 
                                        '{{ $user->name }}', 
                                        'user',
                                        '{{ route('manager.user.destroy', $user->id) }}'
                                    )">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>

{{-- modal add user --}}
<div class="modal fade" id="addUser" tabindex="-1" aria-labelledby="addUserLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content p-3">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserLabel">Add User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('manager.user.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="position" class="form-label">Position</label>
                        <input type="text" class="form-control" id="position" name="position" required>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-select" id="role" name="role" required>
                            <option value="manager">Manager</option>
                            <option value="vendor">Vendor</option>
                            <option value="admin">Admin</option>
                            <option value="staff">Staff</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                    </div>
                    <div class="mb-3">
                        <label for="profile_photo" class="form-label">Profile Picture</label>
                        <input type="file" class="form-control" id="profile_photo" name="profile_photo">
                    </div>
                    <div class="mb-3">
                        <label for="sign_photo" class="form-label">Sign Picture</label>
                        <input type="file" class="form-control" id="sign_photo" name="sign_photo">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary col-12">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- modal view user --}}
@foreach ($users as $user)
    <div class="modal fade" id="viewUserModal{{ $user->id }}" tabindex="-1" aria-labelledby="viewUserModalLabel{{ $user->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title " id="viewUserModalLabel{{ $user->id }}">User Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="d-flex flex-column align-items-center">
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $user->profile_photo_path) }}" 
                                alt="{{ $user->name }}" 
                                class="rounded-circle shadow-sm" 
                                width="100" height="100">
                        </div>
                        <h5 class="content-title">{{ $user->name }}</h5>
                        <p class="content-desc">{{ $user->username }}</p>
                    </div>
                    <hr>
                    <div class="px-2">
                        <p><strong>Email:</strong> {{ $user->email }}</p>
                        <p><strong>Position:</strong> {{ $user->position }}</p>
                        <p><strong>Role:</strong> 
                            <span class="badge bg-success">{{ ucfirst($user->role) }}</span>
                        </p>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
@endforeach


{{-- modal delete user --}}
@foreach ($users as $user)
    <div class="modal fade" id="deleteUserModal{{ $user->id }}" tabindex="-1" aria-labelledby="deleteUserModalLabel{{ $user->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteUserModalLabel{{ $user->id }}">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this user?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('manager.user.destroy', $user->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach

@endsection
