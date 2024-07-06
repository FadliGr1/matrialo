<div class="modal fade" id="editUser" tabindex="-1" aria-labelledby="editUser" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="document-title" id="editUser">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3">
                <div class="row">
                    <form action="{{ route('setting.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input required type="text" class="form-control" id="name" name="name" value="{{ old('name', Auth::user()->name) }}" aria-describedby="nameHelp">
                            <div class="form-text" id="nameHelp">masukan nama lengkap</div>
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input required type="text" class="form-control" id="username" name="username" value="{{ old('username', Auth::user()->username) }}" aria-describedby="usernameHelp">
                            <div class="form-text" id="usernameHelp">masukan username</div>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input required type="email" class="form-control" id="email" name="email" value="{{ old('email', Auth::user()->email) }}" aria-describedby="emailHelp">
                            <div class="form-text" id="emailHelp">masukan email</div>
                        </div>
                        <div class="mb-3">
                            <label for="jabatan" class="form-label">Jabatan</label>
                            <input required type="text" class="form-control" id="jabatan" name="jabatan" value="{{ old('jabatan', Auth::user()->jabatan) }}" aria-describedby="jabatanHelp">
                            <div class="form-text" id="jabatanHelp">masukan jabatan</div>
                        </div>
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Password Akun Saat Ini</label>
                            <input required type="password" class="form-control" id="current_password" name="current_password" aria-describedby="currentPasswordHelp">
                            <div class="form-text" id="currentPasswordHelp">masukan password akun saat ini</div>
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select required class="form-select" id="role" name="role" aria-describedby="roleHelp">
                                <option value="" disabled>Pilih Role</option>
                                <option value="admin" {{ Auth::user()->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="vendor" {{ Auth::user()->role == 'vendor' ? 'selected' : '' }}>Vendor</option>
                                <option value="project manager" {{ Auth::user()->role == 'project manager' ? 'selected' : '' }}>Project Manager</option>
                                <option value="staf" {{ Auth::user()->role == 'staf' ? 'selected' : '' }}>Staf</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="profile_photo" class="form-label">Profile Photo</label>
                            <input type="file" class="form-control" id="profile_photo" name="profile_photo" aria-describedby="profilePhotoHelp">
                            <div class="form-text" id="profilePhotoHelp">masukan profile photo</div>
                        </div>
                        <div class="mb-3">
                            <label for="signature_photo" class="form-label">Signature Photo</label>
                            <input type="file" class="form-control" id="signature_photo" name="signature_photo" aria-describedby="signaturePhotoHelp">
                            <div class="form-text" id="signaturePhotoHelp">masukan signature photo</div>
                        </div>
                        <button type="submit" class="btn btn-sm col-12 btn-primary">Update</button>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm col-12" data-bs-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>