@extends('layouts.navbar') 
@section('content')
<div class="content">
    <div class="document-card">
        <div class="row">
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
    </div>
</div>
@endsection
