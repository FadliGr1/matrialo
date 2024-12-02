@extends('layouts.navbar')
@section('content')
<div class="row">
    <div class="col-12">
        <h2 class="content-title">Settings</h2>
        <h5 class="content-desc mb-4">Manage your app</h5>
    </div>

    
    <div class="col-12">
        <div class="statistics-card p-lg-4 p-2">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs" id="settingTabs" role="tablist">
                        @if($user->role === 'manager')
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="account-tab" data-bs-toggle="tab" data-bs-target="#app" type="button" role="tab">
                                <i class="fa-solid fa-fire"></i> App
                            </button>
                        </li>
                        @endif
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="security-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab">
                                <i class="fa-regular fa-user"></i> Profile
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="notification-tab" data-bs-toggle="tab" data-bs-target="#security" type="button" role="tab">
                                <i class="fa-solid fa-shield-halved"></i> Security
                            </button>
                        </li>
                        @if($user->role === 'manager')
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="appearance-tab" data-bs-toggle="tab" data-bs-target="#integration" type="button" role="tab">
                                <i class="fa-brands fa-cloudversify"></i> Integration
                            </button>
                        </li> 
                        @endif
                    </ul>
                </div>
                
                <div class="card-body px-3">
                    <div class="tab-content" id="settingTabsContent">
                        <!-- App Tab -->
                        @if($user->role === 'manager')
                        <div class="tab-pane fade show active" id="app" role="tabpanel">
                            <h5 class="content-title mb-4">App Settings</h5>
                            <div class="document-card">
                                <div class="document-item" data-bs-toggle="modal" data-bs-target="#generalSettingsModal" style="cursor: pointer;">
                                    <div class="d-flex justify-content-start align-items-center">
                                        <div class="document-icon globe">
                                            <img src="{{asset('img/home/document/gear-solid.svg')}}" alt="">
                                        </div>
                                        <div class="d-flex flex-column justify-content-between align-items-start">
                                            <h2 class="document-title">General</h2>
                                            <span class="document-desc text-black">
                                                basic settings & configurations
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="document-item" data-bs-toggle="modal" data-bs-target="#mailSettingsModal" style="cursor: pointer;">
                                    <div class="d-flex justify-content-start align-items-center">
                                        <div class="document-icon globe">
                                            <img src="{{asset('img/home/document/envelope-open-solid.svg')}}" alt="">
                                        </div>
                                        <div class="d-flex flex-column justify-content-between align-items-start">
                                            <h2 class="document-title">Mailing System</h2>
                                            <span class="document-desc text-black" >
                                                configure your mail system
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="document-item">
                                    <div class="d-flex justify-content-start align-items-center">
                                        <div class="document-icon globe">
                                            <img src="{{asset('img/home/document/folder-closed-solid.svg')}}" alt="">
                                        </div>
                                        <div class="d-flex flex-column justify-content-between align-items-start">
                                            <h2 class="document-title">File Manager</h2>
                                            <span class="document-desc text-black" >
                                                    flexible cloud & local storage manager
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="document-item py-2 px-1">
                                    <div class="d-flex justify-content-start align-items-center">
                                        <div class="document-icon globe">
                                            <img src="{{asset('img/home/document/cloud-arrow-up-solid.svg')}}" alt="">
                                        </div>
                                        <div class="d-flex flex-column justify-content-between align-items-start">
                                            <h2 class="document-title">Backup</h2>
                                            <span class="document-desc text-black" >
                                                Secure your data
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>  
                        </div>
                        @endif
                
                        <!-- Profile Tab -->
                        <div class="tab-pane fade" id="profile" role="tabpanel">
                            <h5 class="content-title mb-4">Profile Settings</h5>
                            <form id="profileForm" action="{{ route('manager.user.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="profile-photo mb-4">
                                    <div class="profile-image">
                                        <img src="{{ auth()->user()->profile_photo_path 
                                            ? asset('storage/'.auth()->user()->profile_photo_path) 
                                            : asset('img/default-avatar.png') }}" 
                                            alt="Profile" class="rounded-circle" width="100" height="100">
                                    </div>
                                    <div class="profile-buttons mt-2">
                                        <input type="file" name="profile_photo" id="profile_photo" class="d-none" accept="image/*">
                                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="$('#profile_photo').click()">
                                            <i class="fas fa-camera"></i> Change
                                        </button>
                                    </div>
                                </div>
                            
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Full Name</label>
                                        <input type="text" class="form-control" name="name" value="{{ auth()->user()->name }}" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Username</label>
                                        <input type="text" class="form-control" name="username" value="{{ auth()->user()->username }}" required>
                                    </div>
                                </div>
                            
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email" value="{{ auth()->user()->email }}" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Position</label>
                                        <input type="text" class="form-control" name="position" value="{{ auth()->user()->position }}" required>
                                    </div>
                                </div>
                            
                                <div class="row">
                                    @if(auth()->user()->role === 'manager')
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Role</label>
                                            <input type="text" class="form-control" value="{{ auth()->user()->role }}" disabled>
                                        </div>
                                    @endif
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Signature</label>
                                        <input type="file" name="sign_photo" class="form-control" accept="image/*">
                                        @if(auth()->user()->sign_photo_path)
                                            <img src="{{ asset('storage/'.auth()->user()->sign_photo_path) }}" 
                                                 alt="Signature" height="50" class="mt-2">
                                        @endif
                                    </div>
                                </div>
                            
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Update
                                    </button>
                                </div>
                            </form>
                        </div>
                
                        <!-- Security Tab -->
                        <div class="tab-pane fade" id="security" role="tabpanel">
                            <h5 class="content-title mb-4">Security Settings</h5>
                            <div class="document-card" >
                                <div class="document-item py-2 px-1" data-bs-toggle="modal" data-bs-target="#changePasswordModal" style="cursor: pointer;">
                                    <div class="d-flex justify-content-start align-items-center">
                                        <div class="document-icon globe">
                                            <img src="{{asset('img/home/document/key-solid.svg')}}" alt="">
                                        </div>
                                        <div class="d-flex flex-column justify-content-between align-items-start">
                                            <h2 class="document-title">Password</h2>
                                            <span class="document-desc text-black">
                                                secure your password
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                
                        <!-- Integration Tab -->
                        @if($user->role === 'manager')
                        <div class="tab-pane fade" id="integration" role="tabpanel">
                            <h5 class="content-title mb-4">Integration Settings</h5>
                            <!-- Integration content -->
                            <div class="document-card" >
                                <div class="document-item py-2 px-1" data-bs-toggle="modal" data-bs-target="#s3SettingsModal" style="cursor: pointer;">
                                    <div class="d-flex justify-content-start align-items-center">
                                        <div class="document-icon globe">
                                            <img src="{{asset('img/home/document/cloud-meatball-solid.svg')}}" alt="">
                                        </div>
                                        <div class="d-flex flex-column justify-content-between align-items-start">
                                            <h2 class="document-title">AWS S3 Compatible</h2>
                                            <span class="document-desc text-black">
                                                setup S3 storage connection
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
    </div>

</div>

{{-- general modal --}}
<div class="modal fade" id="generalSettingsModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">General Settings</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="generalSettingsForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">App Name</label>
                        <input type="text" class="form-control" name="settings[app_name]" 
                               value="{{ $settings['app_name'] ?? '' }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">App Description</label>
                        <textarea class="form-control" name="settings[app_description]" rows="3">{{ $settings['app_description'] ?? '' }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">App Version</label>
                        <input type="text" class="form-control" name="settings[app_version]" 
                               value="{{ $settings['app_version'] ?? '' }}">
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

<!-- Mailing System Modal -->
<div class="modal fade" id="mailSettingsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Mail System Configuration</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="mailSettingsForm">
                @csrf
                <div class="modal-body">
                    <!-- Mail Driver Selection -->
                    <div class="mb-4">
                        <label class="form-label">Mail Driver</label>
                        <select class="form-select" name="settings[mail_driver]" id="mailDriver">
                            <option value="smtp" {{ ($settings['mail_driver'] ?? '') == 'smtp' ? 'selected' : '' }}>SMTP</option>
                        </select>
                    </div>

                    <!-- SMTP Configuration (hidden by default) -->
                    <div id="smtpConfig" style="display: none;">
                        <div class="mb-3">
                            <label class="form-label">SMTP Host</label>
                            <input type="text" class="form-control" name="settings[smtp_host]" 
                                   value="{{ $settings['smtp_host'] ?? '' }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">SMTP Port</label>
                            <input type="text" class="form-control" name="settings[smtp_port]" 
                                   value="{{ $settings['smtp_port'] ?? '' }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">SMTP Username</label>
                            <input type="text" class="form-control" name="settings[smtp_username]" 
                                   value="{{ $settings['smtp_username'] ?? '' }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">SMTP Password</label>
                            <input type="password" class="form-control" name="settings[smtp_password]" 
                                   value="{{ $settings['smtp_password'] ?? '' }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">SMTP Encryption</label>
                            <select class="form-select" name="settings[smtp_encryption]">
                                <option value="tls" {{ ($settings['smtp_encryption'] ?? '') == 'tls' ? 'selected' : '' }}>TLS</option>
                                <option value="ssl" {{ ($settings['smtp_encryption'] ?? '') == 'ssl' ? 'selected' : '' }}>SSL</option>
                            </select>
                        </div>
                    </div>

                    <!-- From Email Configuration -->
                    <div class="mb-3">
                        <label class="form-label">From Email Address</label>
                        <input type="email" class="form-control" name="settings[mail_from_address]" 
                               value="{{ $settings['mail_from_address'] ?? '' }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">From Name</label>
                        <input type="text" class="form-control" name="settings[mail_from_name]" 
                               value="{{ $settings['mail_from_name'] ?? '' }}" required>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <div>
                        <button type="button" class="btn btn-info" id="testMailBtn">
                            <i class="fas fa-paper-plane"></i> Test Mail
                        </button>
                    </div>
                    <div>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Test Mail Modal -->
<div class="modal fade" id="testMailModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Send Test Email</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="testMailForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Test Email To</label>
                        <input type="email" class="form-control" name="test_email" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Send Test</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Change Password -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="changePasswordForm" action="{{ route('manager.user.password.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Current Password</label>
                        <input type="password" class="form-control" name="current_password" 
                               placeholder="your current password" required>
                    </div>
 
                    <div class="mb-3">
                        <label class="form-label">New Password</label>
                        <input type="password" class="form-control" name="password"
                               placeholder="••••••" required>
                    </div>
 
                    <div class="mb-3">
                        <label class="form-label">Re New Password</label>
                        <input type="password" class="form-control" name="password_confirmation"
                               placeholder="••••••" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary w-100">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- modal aws --}}
<!-- S3 Settings Modal -->
<div class="modal fade" id="s3SettingsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content p-3">
            <div class="modal-header">
                <h5 class="modal-title">AWS S3 Compatible Storage Settings</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="s3SettingsForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Access Key ID</label>
                        <input type="text" class="form-control" name="settings[aws_access_key_id]" 
                            value="{{ $settings['aws_access_key_id'] ?? '' }}">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Secret Access Key</label>
                        <input type="password" class="form-control" name="settings[aws_secret_access_key]" 
                            value="{{ $settings['aws_secret_access_key'] ?? '' }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Default Region</label>
                        <input type="text" class="form-control" name="settings[aws_default_region]" 
                            value="{{ $settings['aws_default_region'] ?? '' }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Bucket</label>
                        <input type="text" class="form-control" name="settings[aws_bucket]" 
                            value="{{ $settings['aws_bucket'] ?? '' }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Endpoint URL</label>
                        <input type="text" class="form-control" name="settings[aws_endpoint]" 
                            value="{{ $settings['aws_endpoint'] ?? '' }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Use Path Style Endpoint</label>
                        <select class="form-select" name="settings[aws_use_path_style_endpoint]">
                            <option value="true" {{ ($settings['aws_use_path_style_endpoint'] ?? '') == 'true' ? 'selected' : '' }}>Yes</option>
                            <option value="false" {{ ($settings['aws_use_path_style_endpoint'] ?? '') == 'false' ? 'selected' : '' }}>No</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-info" id="testS3Btn">
                        <i class="fas fa-vial"></i> Test Connection
                    </button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .nav-tabs .nav-link {
        color: #495057;
        border: none;
        padding: 1rem 1.5rem;
    }
    
    .nav-tabs .nav-link:hover {
        border: none;
        color: #0d6efd;
    }
    
    .nav-tabs .nav-link.active {
        color: #0d6efd;
        background: none;
        border: none;
        border-bottom: 2px solid #0d6efd;
    }
    
    .card-header {
        margin-top: -5%;
    }
    </style>
@endsection