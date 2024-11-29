@extends('layouts.navbar')
@section('content')
<div class="row">
    <div class="col-12">
        <h2 class="content-title">Vendor</h2>
        <h5 class="content-desc mb-4">Scale-up your bussiness</h5>
    </div>

    <div class="col-12">
        <div class="statistics-card">
            <span class="d-flex justify-content-between align-content-center">
                <h3 class="content-desc">List of vendors</h3>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addVendor">
                    <i class="fas fa-user-plus"></i> Add Vendor
                </button>
            </span>
              
            <div class="table-responsive">        
                <table id="myTable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Vendor</th>
                            <th>Address</th>
                            <th>Warehouse Address</th>
                            <th>Responsible</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($vendors as $vendor)
                            <tr data-id="{{ $vendor->id }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $vendor->vendor_name }}</td>
                                <td>{{ $vendor->address }}</td>
                                <td>{{ $vendor->warehouse_address }}</td>
                                <td>{{ $vendor->user ? $vendor->user->name : '-' }}</td>
                                <td>
                                    <button type="button" class="action-btn view-btn" title="View" data-bs-toggle="modal" data-bs-target="#viewVendorModal{{ $vendor->id }}">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button type="button" class="action-btn delete-btn" title="Delete"
                                        onclick="deleteConfirmation(
                                            '{{ $vendor->id }}',
                                            '{{ $vendor->vendor_name }}',
                                            'vendor',
                                            '{{ route('manager.vendor.destroy', $vendor->id) }}'
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

{{-- modal add vendor --}}
<div class="modal fade" id="addVendor" tabindex="-1" aria-labelledby="addUserLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content p-3">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserLabel">Add User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('manager.vendor.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="vendor_name" class="form-label">Vendor Name</label>
                        <input type="text" class="form-control" id="vendor_name" name="vendor_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="warehouse_address" class="form-label">Warehouse Address</label>
                        <textarea class="form-control" id="warehouse_address" name="warehouse_address" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="person_responsible" class="form-label">Person Responsible</label>
                        <select class="form-select" id="person_responsible" name="person_responsible">
                            <option value="">Select Person Responsible</option>
                            @foreach ($vendorUsers as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary col-12">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit/view Vendor -->
@foreach ($vendors as $vendor)
    <div class="modal fade" id="viewVendorModal{{ $vendor->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content p-3">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Vendor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('manager.vendor.update', $vendor->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="vendor_name" class="form-label">Vendor Name</label>
                            <input type="text" class="form-control" name="vendor_name" 
                                value="{{ $vendor->vendor_name }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control" name="address" required>{{ $vendor->address }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="warehouse_address" class="form-label">Warehouse Address</label>
                            <textarea class="form-control" name="warehouse_address" required>{{ $vendor->warehouse_address }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="user_id" class="form-label">Responsible Person</label>
                            <select class="form-select" name="user_id" required>
                                @foreach($vendorUsers as $user)
                                    <option value="{{ $user->id }}" 
                                        {{ $vendor->person_responsible == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
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
@endforeach

{{-- modal delete vendor --}}
@foreach ($vendors as $vendor)
    <!-- Modal Delete Vendor -->
    <div class="modal fade" id="deleteVendorModal{{ $vendor->id }}" tabindex="-1" aria-labelledby="deleteVendorModalLabel{{ $vendor->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteVendorModalLabel{{ $vendor->id }}">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete vendor "{{ $vendor->vendor_name }}"?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('manager.vendor.destroy', $vendor->id) }}" method="POST" style="display: inline">
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