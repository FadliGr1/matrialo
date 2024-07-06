<div class="modal fade" id="addvendor" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="document-title" id="exampleModalLabel">Tambah User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3">
                <div class="row">
                    <form action="{{route('vendor.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="vendor_name" class="form-label">Nama Vendor</label>
                            <input required type="text" class="form-control" id="vendor_name" name="vendor_name" aria-describedby="nameHelp">
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <input required type="text" class="form-control" id="alamat" name="alamat" aria-describedby="usernameHelp">
                        </div>
                        <div class="mb-3">
                            <label for="alamat_gudang" class="form-label">Alamat Gudang</label>
                            <input required type="text" class="form-control" id="alamat_gudang" name="alamat_gudang" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label for="penanggung_jawab" class="form-label">Penanggung Jawab</label>
                            <select required class="form-select" id="penanggung_jawab" name="penanggung_jawab" aria-describedby="roleHelp">
                                <option selected>Pilih user</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-sm col-12 btn-primary">Tambah</button>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm col-12" data-bs-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>