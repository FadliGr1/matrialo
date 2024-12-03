@extends('layouts.navbar')
@section('content')
<div class="row">
    <div class="col-12">
        <h2 class="content-title">Materials</h2>
        <h5 class="content-desc mb-4">Monitor material resources</h5>
    </div>

    <div class="col-12">
        <div class="statistics-card">
            <span class="d-flex justify-content-between align-content-center">
                <h3 class="content-desc">List of material request</h3>
            </span>
            <div class="table-responsive">
                <table id="myTable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Request By</th>
                            <th>Site</th>
                            <th>Request Date</th>
                            <th>Approval Date</th>
                            <th>Status</th>
                            <th>Remark</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($materials as $material)
                            <tr data-id="{{ $material->id }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $material->requester_name }}</td>
                                <td>{{ $material->site_id }}</td>
                                <td>{{ $material->request_date }}</td>
                                <td>{{ $material->approval_date ?? '-' }}</td>
                                <td>{{ str_replace('_', ' ', ucfirst($material->status)) }}</td>
                                <td>{{ $material->remark }}</td>
                                <td>
                                    <button type="button" class="action-btn view-btn" title="View" data-bs-toggle="modal" data-bs-target="#viewMaterialModal{{ $material->id }}">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    {{-- <button type="button" class="action-btn delete-btn" title="Delete"
                                        onclick="deleteConfirmation(
                                            '{{ $material->id }}',
                                            'Material Request #{{ $material->id }}',
                                            'material',
                                            '{{ route('vendor.materials.destroy', $material->id) }}'
                                        )">
                                        <i class="fas fa-trash-alt"></i>
                                    </button> --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
           
        </div>
    </div>
</div>

<!-- modal view/edit -->
@foreach($materials as $material)
<div class="modal fade" id="viewMaterialModal{{ $material->id }}" tabindex="-1" aria-labelledby="viewMaterialModalLabel{{ $material->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewMaterialModalLabel{{ $material->id }}">Document Review</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('vendor.materials.update', $material->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <!-- Material Request Document Section -->
                    <div class="mb-4 document-card" >
                        <h6 class="mb-3">Material Request</h6>
                        <div class="document-item p-3">
                            <div class="d-flex justify-content-start align-items-center">
                                <div class="document-icon box">
                                    <img src="{{asset('img/home/document/archive.svg')}}" alt="Document Icon">
                                </div>
                        
                                <div class="d-flex flex-column justify-content-between align-items-start">
                                    <h2 class="document-title">{{ pathinfo($material->document, PATHINFO_FILENAME) }}</h2>
                                    @php
                                        $filePath = public_path('storage/' . $material->document);
                                        $filesize = file_exists($filePath) ? filesize($filePath) : 0;
                                        $filesize = number_format($filesize / 1048576, 2);
                                        $extension = strtoupper(pathinfo($material->document, PATHINFO_EXTENSION));
                                    @endphp
                                    <span class="document-desc">{{ $filesize }} MB • {{ $extension }}</span>
                                </div>
                            </div>
                        
                            <a href="{{ asset('storage/'.$material->document) }}" download class="btn-statistics">
                                <img src="{{asset('img/global/download.svg')}}" alt="Download Icon">
                            </a>
                        </div>
                        
                    </div>

                    <!-- Status Section -->
                    <div class="mb-4">
                        <h6 class="mb-3">Set Status</h6>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-secondary status-btn" data-status="need_revision">
                                <i class="fas fa-sync-alt me-1"></i> Need Revision
                            </button>
                            <button type="button" class="btn btn-danger status-btn" data-status="rejected">
                                <i class="fas fa-times me-1"></i> Rejected
                            </button>
                            <button type="button" class="btn btn-success status-btn" data-status="approved">
                                <i class="fas fa-check me-1"></i> Approved
                            </button>
                        </div>
                        <input type="hidden" name="status" id="status{{ $material->id }}">
                    </div>

                    <!-- Remarks Section -->
                    <div class="mb-4">
                        <h6 class="mb-3">Remarks</h6>
                        <textarea class="form-control" name="remark" rows="4" placeholder="Enter your remarks here">{{ $material->remark }}</textarea>
                    </div>

                    <!-- DO Release Upload Section (visible only when approved) -->
                    <div class="mb-4 do-release-section" style="display: {{ $material->status === 'approved' ? 'block' : 'none' }};">
                        <h6 class="mb-3">Upload DO Release</h6>
                        <div class="border rounded p-3 text-center upload-area">
                            <input type="file" name="do_release" id="doRelease{{ $material->id }}" class="d-none" accept=".xlsx,.xls">
                            <label for="doRelease{{ $material->id }}" class="mb-0 w-100 cursor-pointer">
                                <i class="fas fa-upload mb-2"></i>
                                <p class="mb-1">Drop your file here, or click to browse</p>
                                <small class="text-muted">Maximum file size: 10MB</small>
                            </label>
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

<style>
    .upload-area {
        border: 2px dashed #ccc;
        padding: 20px;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .upload-area:hover {
        border-color: #0d6efd;
    }
    
    .status-btn.active {
        opacity: 1;
    }
    
    .status-btn {
        opacity: 0.7;
        transition: all 0.3s ease;
    }
    
    .cursor-pointer {
        cursor: pointer;
    }
    </style>

@endsection