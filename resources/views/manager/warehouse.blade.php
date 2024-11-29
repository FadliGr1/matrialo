@extends('layouts.navbar')
@section('content')
<div class="row">
    <div class="col-12">
        <h2 class="content-title">Warehouse</h2>
        <h5 class="content-desc mb-4">Smart inventory management</h5>
    </div>

    <div class="col-12">
        <div class="statistics-card">
            <span class="d-flex justify-content-between align-content-center">
                <h3 class="content-desc">List of vendors</h3>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addWarehouse">
                    <i class="fas fa-user-plus"></i> Add Warehouse
                </button>
            </span>
              
            <div class="table-responsive">        
                <table id="myTable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Capacity Usage</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($warehouses as $index => $warehouse)
                        @php
                            $poleUsage = $warehouse->used_pole_capacity ? ($warehouse->used_pole_capacity / $warehouse->pole_capacity) * 100 : 0;
                            $cableUsage = $warehouse->used_cable_capacity ? ($warehouse->used_cable_capacity / $warehouse->cable_capacity) * 100 : 0;
                            $accUsage = $warehouse->used_acc_capacity ? ($warehouse->used_acc_capacity / $warehouse->acc_capacity) * 100 : 0;
                            
                            $averageUsage = ($poleUsage + $cableUsage + $accUsage) / 3;
                            
                            $colorClass = $averageUsage > 80 ? 'danger' : ($averageUsage > 50 ? 'warning' : 'success');
                        @endphp
                        <tr data-id="{{ $warehouse->id }}">
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $warehouse->name }}</td>
                            <td>{{ $warehouse->address }}</td>
                            <td>
                                <div class="progress">
                                    <div class="progress-bar bg-{{ $colorClass }}" 
                                         role="progressbar" 
                                         style="width: {{ $averageUsage }}%"
                                         aria-valuenow="{{ $averageUsage }}" 
                                         aria-valuemin="0" 
                                         aria-valuemax="100">
                                        {{ number_format($averageUsage, 1) }}%
                                    </div>
                                </div>
                                <small class="mt-1 d-block">
                                    Pole: {{ number_format($poleUsage, 1) }}% | 
                                    Cable: {{ number_format($cableUsage, 1) }}% | 
                                    Acc: {{ number_format($accUsage, 1) }}%
                                </small>
                            </td>
                            <td>
                                <button type="button" class="action-btn view-btn" title="View" data-bs-toggle="modal" data-bs-target="#viewWarehouseModal{{ $warehouse->id }}">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button type="button" class="action-btn delete-btn" title="Delete" 
                                    onclick="deleteConfirmation(
                                        '{{ $warehouse->id }}', 
                                        '{{ $warehouse->name }}', 
                                        'warehouse',
                                        '{{ route('manager.warehouse.destroy', $warehouse->id) }}'
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
<div class="modal fade" id="addWarehouse" tabindex="-1" aria-labelledby="addWarehouseLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content p-3">
            <div class="modal-header">
                <h5 class="modal-title" id="addWarehouseLabel">Add User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('manager.warehouse.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Warehouse Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
            
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control @error('address') is-invalid @enderror" 
                                  id="address" name="address" rows="3" required>{{ old('address') }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
            
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="pole_capacity" class="form-label">Pole Capacity</label>
                            <input type="number" class="form-control @error('pole_capacity') is-invalid @enderror" 
                                   id="pole_capacity" name="pole_capacity" value="{{ old('pole_capacity') }}" required>
                            @error('pole_capacity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
            
                        <div class="col-md-4 mb-3">
                            <label for="cable_capacity" class="form-label">Cable Capacity</label>
                            <input type="number" class="form-control @error('cable_capacity') is-invalid @enderror" 
                                   id="cable_capacity" name="cable_capacity" value="{{ old('cable_capacity') }}" required>
                            @error('cable_capacity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
            
                        <div class="col-md-4 mb-3">
                            <label for="acc_capacity" class="form-label">Acc Capacity</label>
                            <input type="number" class="form-control @error('acc_capacity') is-invalid @enderror" 
                                   id="acc_capacity" name="acc_capacity" value="{{ old('acc_capacity') }}" required>
                            @error('acc_capacity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary col-12">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal View/Edit Warehouse --}}
@foreach($warehouses as $warehouse)
<div class="modal fade" id="viewWarehouseModal{{ $warehouse->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content p-3">
            <div class="modal-header">
                <h5 class="modal-title">Edit Warehouse</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('manager.warehouse.update', $warehouse->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Warehouse Name</label>
                        <input type="text" class="form-control" name="name" value="{{ $warehouse->name }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control" name="address" rows="3" required>{{ $warehouse->address }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="pole_capacity" class="form-label">Pole Capacity</label>
                            <input type="number" class="form-control" name="pole_capacity" value="{{ $warehouse->pole_capacity }}" required>
                            <small class="text-muted">Used: {{ $warehouse->used_pole_capacity }}</small>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="cable_capacity" class="form-label">Cable Capacity</label>
                            <input type="number" class="form-control" name="cable_capacity" value="{{ $warehouse->cable_capacity }}" required>
                            <small class="text-muted">Used: {{ $warehouse->used_cable_capacity }}</small>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="acc_capacity" class="form-label">Acc Capacity</label>
                            <input type="number" class="form-control" name="acc_capacity" value="{{ $warehouse->acc_capacity }}" required>
                            <small class="text-muted">Used: {{ $warehouse->used_acc_capacity }}</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Delete Confirmation --}}
<div class="modal fade" id="deleteWarehouseModal{{ $warehouse->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete warehouse "{{ $warehouse->name }}"?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('manager.warehouse.destroy', $warehouse->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

@push('scripts')
<script>
function deleteWarehouse(id) {
    if (confirm('Are you sure you want to delete this warehouse?')) {
        // Assuming you're using Laravel's form method spoofing
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/warehouses/${id}`;
        form.innerHTML = `
            @csrf
            @method('DELETE')
        `;
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endpush
@endsection