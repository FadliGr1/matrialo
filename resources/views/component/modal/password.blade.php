<div class="modal fade" id="editPassword" tabindex="-1" aria-labelledby="editPassword" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="document-title" id="editPassword">Edit Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3">
                <div class="row">
                    <form action="{{ route('security.update') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="new_password" class="form-label">Password Baru</label>
                            <input required type="password" class="form-control" id="new_password" name="new_password" aria-describedby="passwordHelp">
                            <div class="form-text" id="passwordHelp">Masukan password baru</div>
                        </div>
                        <div class="mb-3">
                            <label for="new_password_confirmation" class="form-label">Masukan Ulang Password Baru</label>
                            <input required type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" aria-describedby="passwordConfirmationHelp">
                            <div class="form-text" id="passwordConfirmationHelp">Masukan ulang password baru</div>
                        </div>
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Password Akun Saat Ini</label>
                            <input required type="password" class="form-control" id="current_password" name="current_password" aria-describedby="currentPasswordHelp">
                            <div class="form-text" id="currentPasswordHelp">Masukan password akun saat ini</div>
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