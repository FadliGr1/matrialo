@extends('layouts.navbar')
@section('content')
    <div class="content">
        <div class="document-card">
            <div class="row">
                <div class="col-12">
                        <h2 class="content-title">Security</h2>
                        <h5 class="content-desc mb-4">Lock your account</h5>
                </div>
            </div>
            <div class="row" style="margin-top: -50px;">
                <div class="col">
                    @include('component.tabs.navtabs')
                </div>
            </div>
            <div class="row mt-3">
                <div class="col d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="document-title">Password</h2>
                        <p class="document-desc">Perbarui kata sandi anda secara berkala</p>
                    </div>
                    <button class="btn btn-sm btn-outline-warning px-3 ms-2" data-bs-toggle="modal" data-bs-target="#editPassword">Ubah Sandi</button>
                </div>
                @include('component.modal.password')
            </div>
            <div class="row mt-3">
                <div class="col d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="document-title">Two Factor Authentication</h2>
                        <p class="document-desc">Tambahkan lapisan keamanan tambahan</p>
                    </div>
                    <div class="form-check form-switch">
                        <input type="checkbox" class="form-check-input" role="switch" id="twoFactor">
                        <label for="twoFactor" class="form-check-label" ></label>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection