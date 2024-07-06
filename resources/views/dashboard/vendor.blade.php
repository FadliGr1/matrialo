@extends ('layouts.navbar')
@section('content')
<div class="content">
    <div class="row">
        <div class="col-12">
            <h2 class="content-title">Vendor</h2>
            <h5 class="content-desc mb-4">Manage vendor</h5>
        </div>
        <div class="col-12 d-flex justify-content-end">
            <button class="btn btn-sm btn-primary view-user-btn px-3" type="button" data-bs-toggle="modal" data-bs-target="#addvendor">Tambah</button>
            @include('component.modal.addvendor')
            @include('component.modal.viewvendor')
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12">
            <div class="document-card">
                <div class="table-responsive">
                    <table class="table caption-top align-middle table-hover">
                        <caption>List of vendors</caption>
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Vendor Name</th>
                                <th scope="col">Alamat</th>
                                <th scope="col">Alamat Gudang</th>
                                <th scope="col">Penanggung Jawab</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($vendors as $vendor)
                            <tr>
                                <td>{{ $vendor->id }}</td>
                                <td>{{ $vendor->vendor_name }}</td>
                                <td>{{ $vendor->alamat }}</td>
                                <td>{{ $vendor->alamat_gudang }}</td>
                                <td>{{ $vendor->penanggungJawab->name }}</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-success col-12 view-vendor-btn px-3" style="border-radius: 14px;" type="button" data-bs-toggle="modal" data-bs-target="#viewVendorModal" data-vendor-id="{{ $vendor->id }}">View</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="d-flex justify-content-center mt-3">
                {{ $vendors->links() }}
            </div>
        </div>
    </div>
</div>
@endsection