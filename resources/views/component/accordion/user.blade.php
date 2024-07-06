<div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
    <div class="accordion-body">
        <div class="row mb-3">
            <div class="col-12">
                <div class="d-flex justify-content-center">
                    <img class="img-fluid" id="profile-photo" src="{{ Storage::url($user->profile_photo_path) }}" alt="">
                </div>
            </div>
            <div class="col-12 col-sm-6 mt-3">
                <span class="document-desc">Nama Lengkap</span>
                <h2 class="document-title" id="user-name">{{ $user->name }}</h2>
            </div>
            <div class="col-12 col-sm-6 mt-3">
                <span class="document-desc">Username</span>
                <h2 class="document-title" id="user-username">{{ $user->username }}</h2>
            </div>
            <div class="col-12 col-sm-6 mt-3">
                <span class="document-desc">Email</span>
                <h2 class="document-title" id="user-email">{{ $user->email }}</h2>
            </div>
            <div class="col-12 col-sm-6 mt-3">
                <span class="document-desc">Jabatan</span>
                <h2 class="document-title" id="user-jabatan">{{ $user->jabatan }}</h2>
            </div>
            <div class="col-12 col-sm-6 mt-3">
                <span class="document-desc">Role</span>
                <h2 class="document-title" id="user-role">{{ $user->role }}</h2>
            </div>
            <div class="col-12 mt-3">
                <h2 class="document-desc">Signature</h2>
                <a id="signature-link" href="{{ $user->signature_photo_path ? Storage::url($user->signature_photo_path) : '#' }}" target="_blank">lihat Signature</a>
            </div>
        </div>
        <div class="row">
            <div class="col d-flex justify-content-end">
                <button type="button" class="btn btn-sm btn-primary px-5" data-bs-toggle="modal" data-bs-target="#editUser">Edit</button>
                <button class="btn btn-sm btn-warning px-3 ms-2" data-bs-toggle="modal" data-bs-target="#editPassword">Ubah Sandi</button>
            </div>
            @include('component.modal.edit')
            @include('component.modal.password')
        </div>
    </div>
</div>