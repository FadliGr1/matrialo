<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

     {{-- Font Awesome Icon --}}
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    {{-- Datatable --}}
    <link href="https://cdn.datatables.net/v/se/jszip-3.10.1/dt-2.1.8/b-3.2.0/b-html5-3.2.0/sl-2.1.0/datatables.min.css" rel="stylesheet">
    
    @vite(['resources/css/index.css'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <title>Matrialo - Material Management System</title>
</head>

<body>

    <div class="screen-cover d-none d-xl-none"></div>

    <div class="row">
        <div class="col-12 col-lg-3 col-navbar d-none d-xl-block">
 
            <aside class="sidebar">
                <a href="" class="sidebar-logo">
                    <div class="d-flex justify-content-start align-items-center">
                        <img src="{{asset('img/global/logo.svg')}}" alt="">
                        <span>{{ $settings['app_name'] ?? 'Default App Name' }}</span>
                    </div>

                    <button id="toggle-navbar" onclick="toggleNavbar()">
                        <img src="{{asset('img/global/navbar-times.svg')}}" alt="">
                    </button>
                </a>

                <h5 class="sidebar-title">Daily Use</h5>
                @if(auth()->user()->isManager())
                <a href="/manager/dashboard" class="sidebar-item {{ Request::is('manager/dashboard') ? 'active' : ''}}" onclick="toggleActive(this)">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21 14H14V21H21V14Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M10 14H3V21H10V14Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M21 3H14V10H21V3Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M10 3H3V10H10V3Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>

                    <span>Overview</span>
                </a>
               
                <a href="/manager/user" class="sidebar-item {{ Request::is('manager/user') ? 'active' : ''}}" onclick="toggleActive(this)">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M23 21V19C22.9993 18.1137 22.7044 17.2528 22.1614 16.5523C21.6184 15.8519 20.8581 15.3516 20 15.13" stroke="#ABB3C4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M17 21V19C17 17.9391 16.5786 16.9217 15.8284 16.1716C15.0783 15.4214 14.0609 15 13 15H5C3.93913 15 2.92172 15.4214 2.17157 16.1716C1.42143 16.9217 1 17.9391 1 19V21" stroke="#ABB3C4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M16 3.13C16.8604 3.35031 17.623 3.85071 18.1676 4.55232C18.7122 5.25392 19.0078 6.11683 19.0078 7.005C19.0078 7.89318 18.7122 8.75608 18.1676 9.45769C17.623 10.1593 16.8604 10.6597 16 10.88" stroke="#ABB3C4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M9 11C11.2091 11 13 9.20914 13 7C13 4.79086 11.2091 3 9 3C6.79086 3 5 4.79086 5 7C5 9.20914 6.79086 11 9 11Z" stroke="#ABB3C4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>

                    <span>Users</span>
                </a>

                <a href="/manager/vendor" class="sidebar-item {{ Request::is('manager/vendor') ? 'active' : ''}}" onclick="toggleActive(this)">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 9L12 2L21 9V20C21 20.5304 20.7893 21.0391 20.4142 21.4142C20.0391 21.7893 19.5304 22 19 22H5C4.46957 22 3.96086 21.7893 3.58579 21.4142C3.21071 21.0391 3 20.5304 3 20V9Z" stroke="#ABB3C4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M9 22V12H15V22" stroke="#ABB3C4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>

                    <span>Vendors</span>
                </a>

                <a href="/manager/warehouse" class="sidebar-item {{ Request::is('manager/warehouse') ? 'active' : ''}}" onclick="toggleActive(this)">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 7H4C2.89543 7 2 7.89543 2 9V19C2 20.1046 2.89543 21 4 21H20C21.1046 21 22 20.1046 22 19V9C22 7.89543 21.1046 7 20 7Z" stroke="#ABB3C4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M16 21V5C16 4.46957 15.7893 3.96086 15.4142 3.58579C15.0391 3.21071 14.5304 3 14 3H10C9.46957 3 8.96086 3.21071 8.58579 3.58579C8.21071 3.96086 8 4.46957 8 5V21" stroke="#ABB3C4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>

                    <span>Warehouse</span>
                </a>

                <a href="/manager/project" class="sidebar-item {{ Request::is('manager/project') ? 'active' : ''}}" onclick="toggleActive(this)">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 1V23" stroke="#ABB3C4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M17 5H9.5C8.57174 5 7.6815 5.36875 7.02513 6.02513C6.36875 6.6815 6 7.57174 6 8.5C6 9.42826 6.36875 10.3185 7.02513 10.9749C7.6815 11.6313 8.57174 12 9.5 12H14.5C15.4283 12 16.3185 12.3687 16.9749 13.0251C17.6313 13.6815 18 14.5717 18 15.5C18 16.4283 17.6313 17.3185 16.9749 17.9749C16.3185 18.6313 15.4283 19 14.5 19H6" stroke="#ABB3C4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>

                    <span>Project</span>
                </a>
                @endif

                @if(auth()->user()->isVendor())
                {{-- <h5 class="sidebar-title">Others</h5> --}}

                <a href="/vendor/dashboard" class="sidebar-item {{ Request::is('vendor/dashboard') ? 'active' : ''}}" onclick="toggleActive(this)">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21 14H14V21H21V14Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M10 14H3V21H10V14Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M21 3H14V10H21V3Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M10 3H3V10H10V3Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>

                    <span>Overview</span>
                </a>

                <a href="/vendor/materials" class="sidebar-item {{ Request::is('vendor/materials') ? 'active' : ''}}" onclick="toggleActive(this)">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21 16V8C20.9996 7.64927 20.9071 7.30481 20.7315 7.00116C20.556 6.69751 20.3037 6.44536 20 6.27L13 2.27C12.696 2.09446 12.3511 2.00205 12 2.00205C11.6489 2.00205 11.304 2.09446 11 2.27L4 6.27C3.69626 6.44536 3.44398 6.69751 3.26846 7.00116C3.09294 7.30481 3.00036 7.64927 3 8V16C3.00036 16.3507 3.09294 16.6952 3.26846 16.9988C3.44398 17.3025 3.69626 17.5546 4 17.73L11 21.73C11.304 21.9055 11.6489 21.9979 12 21.9979C12.3511 21.9979 12.696 21.9055 13 21.73L20 17.73C20.3037 17.5546 20.556 17.3025 20.7315 16.9988C20.9071 16.6952 20.9996 16.3507 21 16Z" stroke="#ABB3C4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M3.27002 6.96L12 12.01L20.73 6.96" stroke="#ABB3C4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M12 22.08V12" stroke="#ABB3C4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>

                    <span>Materials Requests</span>
                </a>

                <a href="/vendor/dorelease" class="sidebar-item {{ Request::is('vendor/dorelease') ? 'active' : ''}}" onclick="toggleActive(this)">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 9L12 2L21 9V20C21 20.5304 20.7893 21.0391 20.4142 21.4142C20.0391 21.7893 19.5304 22 19 22H5C4.46957 22 3.96086 21.7893 3.58579 21.4142C3.21071 21.0391 3 20.5304 3 20V9Z" stroke="#ABB3C4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M9 22V12H15V22" stroke="#ABB3C4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>

                    <span>DO Release</span>
                </a>

                @endif
                <a href="{{ getSettingRoute() }}" class="sidebar-item {{ Request::is('*/setting') ? 'active' : ''}}" onclick="toggleActive(this)">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15Z" stroke="#ABB3C4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M19.4 15C19.2669 15.3016 19.2272 15.6362 19.286 15.9606C19.3448 16.285 19.4995 16.5843 19.73 16.82L19.79 16.88C19.976 17.0657 20.1235 17.2863 20.2241 17.5291C20.3248 17.7719 20.3766 18.0322 20.3766 18.295C20.3766 18.5578 20.3248 18.8181 20.2241 19.0609C20.1235 19.3037 19.976 19.5243 19.79 19.71C19.6043 19.896 19.3837 20.0435 19.1409 20.1441C18.8981 20.2448 18.6378 20.2966 18.375 20.2966C18.1122 20.2966 17.8519 20.2448 17.6091 20.1441C17.3663 20.0435 17.1457 19.896 16.96 19.71L16.9 19.65C16.6643 19.4195 16.365 19.2648 16.0406 19.206C15.7162 19.1472 15.3816 19.1869 15.08 19.32C14.7842 19.4468 14.532 19.6572 14.3543 19.9255C14.1766 20.1938 14.0813 20.5082 14.08 20.83V21C14.08 21.5304 13.8693 22.0391 13.4942 22.4142C13.1191 22.7893 12.6104 23 12.08 23C11.5496 23 11.0409 22.7893 10.6658 22.4142C10.2907 22.0391 10.08 21.5304 10.08 21V20.91C10.0723 20.579 9.96512 20.258 9.77251 19.9887C9.5799 19.7194 9.31074 19.5143 9 19.4C8.69838 19.2669 8.36381 19.2272 8.03941 19.286C7.71502 19.3448 7.41568 19.4995 7.18 19.73L7.12 19.79C6.93425 19.976 6.71368 20.1235 6.47088 20.2241C6.22808 20.3248 5.96783 20.3766 5.705 20.3766C5.44217 20.3766 5.18192 20.3248 4.93912 20.2241C4.69632 20.1235 4.47575 19.976 4.29 19.79C4.10405 19.6043 3.95653 19.3837 3.85588 19.1409C3.75523 18.8981 3.70343 18.6378 3.70343 18.375C3.70343 18.1122 3.75523 17.8519 3.85588 17.6091C3.95653 17.3663 4.10405 17.1457 4.29 16.96L4.35 16.9C4.58054 16.6643 4.73519 16.365 4.794 16.0406C4.85282 15.7162 4.81312 15.3816 4.68 15.08C4.55324 14.7842 4.34276 14.532 4.07447 14.3543C3.80618 14.1766 3.49179 14.0813 3.17 14.08H3C2.46957 14.08 1.96086 13.8693 1.58579 13.4942C1.21071 13.1191 1 12.6104 1 12.08C1 11.5496 1.21071 11.0409 1.58579 10.6658C1.96086 10.2907 2.46957 10.08 3 10.08H3.09C3.42099 10.0723 3.742 9.96512 4.0113 9.77251C4.28059 9.5799 4.48572 9.31074 4.6 9C4.73312 8.69838 4.77282 8.36381 4.714 8.03941C4.65519 7.71502 4.50054 7.41568 4.27 7.18L4.21 7.12C4.02405 6.93425 3.87653 6.71368 3.77588 6.47088C3.67523 6.22808 3.62343 5.96783 3.62343 5.705C3.62343 5.44217 3.67523 5.18192 3.77588 4.93912C3.87653 4.69632 4.02405 4.47575 4.21 4.29C4.39575 4.10405 4.61632 3.95653 4.85912 3.85588C5.10192 3.75523 5.36217 3.70343 5.625 3.70343C5.88783 3.70343 6.14808 3.75523 6.39088 3.85588C6.63368 3.95653 6.85425 4.10405 7.04 4.29L7.1 4.35C7.33568 4.58054 7.63502 4.73519 7.95941 4.794C8.28381 4.85282 8.61838 4.81312 8.92 4.68H9C9.29577 4.55324 9.54802 4.34276 9.72569 4.07447C9.90337 3.80618 9.99872 3.49179 10 3.17V3C10 2.46957 10.2107 1.96086 10.5858 1.58579C10.9609 1.21071 11.4696 1 12 1C12.5304 1 13.0391 1.21071 13.4142 1.58579C13.7893 1.96086 14 2.46957 14 3V3.09C14.0013 3.41179 14.0966 3.72618 14.2743 3.99447C14.452 4.26276 14.7042 4.47324 15 4.6C15.3016 4.73312 15.6362 4.77282 15.9606 4.714C16.285 4.65519 16.5843 4.50054 16.82 4.27L16.88 4.21C17.0657 4.02405 17.2863 3.87653 17.5291 3.77588C17.7719 3.67523 18.0322 3.62343 18.295 3.62343C18.5578 3.62343 18.8181 3.67523 19.0609 3.77588C19.3037 3.87653 19.5243 4.02405 19.71 4.21C19.896 4.39575 20.0435 4.61632 20.1441 4.85912C20.2448 5.10192 20.2966 5.36217 20.2966 5.625C20.2966 5.88783 20.2448 6.14808 20.1441 6.39088C20.0435 6.63368 19.896 6.85425 19.71 7.04L19.65 7.1C19.4195 7.33568 19.2648 7.63502 19.206 7.95941C19.1472 8.28381 19.1869 8.61838 19.32 8.92V9C19.4468 9.29577 19.6572 9.54802 19.9255 9.72569C20.1938 9.90337 20.5082 9.99872 20.83 10H21C21.5304 10 22.0391 10.2107 22.4142 10.5858C22.7893 10.9609 23 11.4696 23 12C23 12.5304 22.7893 13.0391 22.4142 13.4142C22.0391 13.7893 21.5304 14 21 14H20.91C20.5882 14.0013 20.2738 14.0966 20.0055 14.2743C19.7372 14.452 19.5268 14.7042 19.4 15V15Z" stroke="#ABB3C4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    <span>Settings</span>
                </a>

                <a href="#" class="sidebar-item" onclick="confirmLogout(event)">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M16 17L21 12L16 7" stroke="#ABB3C4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M21 12H9" stroke="#ABB3C4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M9 21H5C4.46957 21 3.96086 20.7893 3.58579 20.4142C3.21071 20.0391 3 19.5304 3 19V5C3 4.46957 3.21071 3.96086 3.58579 3.58579C3.96086 3.21071 4.46957 3 5 3H9" stroke="#ABB3C4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span>Logout</span>
                </a>

            </aside>

        </div>

        <div class="col-12 col-xl-9">
            <div class="nav">
                <div class="d-flex justify-content-between align-items-center w-100 mb-3 mb-md-0">
                    <div class="d-flex justify-content-start align-items-center">
                        <button id="toggle-navbar" onclick="toggleNavbar()">
                            <img src="{{asset('img/global/burger.svg')}}" class="mb-2" alt="">
                        </button>
                        <h2 class="nav-title">Hi, {{Auth::user()->username}}</h2>
                    </div>
                    <button class="btn-notif d-block d-md-none" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"><img src="{{asset('img/global/bell.svg')}}" alt=""></button>
                </div>

                <div class="d-flex justify-content-between align-items-center nav-input-container">
                    <button class="btn-notif d-none d-md-block" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"><img src="{{asset('img/global/bell.svg')}}" alt=""></button>
                </div>
            </div>
            <div class="content">
                @yield('content')
            </div>
        </div>
    </div>
    {{-- Off Canvas Notification --}}
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">
          <h5 id="offcanvasRightLabel">Notification</h5>
          <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <x-activity />
        </div>
      </div>

    
      {{-- Jquery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    {{-- Bootstrap --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    {{-- datatable --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/v/se/jszip-3.10.1/dt-2.1.8/b-3.2.0/b-html5-3.2.0/sl-2.1.0/datatables.min.js"></script>

    {{-- error handling --}}
    @if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '{{ session('success') }}',
        });
    </script>
    @endif

    @if (session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '{{ session('error') }}',
        });
    </script>
    @endif

    @if (session('warning'))
    <script>
        Swal.fire({
            icon: 'warning',
            title: 'Warning',
            text: '{{ session('warning') }}',
        });
    </script>
    @endif

    {{-- Navbar --}}
    <script>
        const navbar = document.querySelector('.col-navbar')
        const cover = document.querySelector('.screen-cover')

        const sidebar_items = document.querySelectorAll('.sidebar-item')

        function toggleNavbar() {
            navbar.classList.toggle('d-none')
            cover.classList.toggle('d-none')
        }

        function toggleActive(e) {
            sidebar_items.forEach(function (v, k) {
                v.classList.remove('active')
            })
            e.closest('.sidebar-item').classList.add('active')

        }
    </script>

    {{-- Datatable --}}
    <script>
        $('#myTable').DataTable( {
            buttons: [
                 'excel', 'pdf',
                 {
                    text: '<i class="fas fa-trash-alt"></i> Delete',
                    className: 'delete-btn',
                    action: function(e, dt, node, config) {
                        var selectedRows = dt.rows({ selected: true }).nodes();
                        
                        if (selectedRows.length === 0) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Warning',
                                text: 'Please select data to delete!'
                            });
                            return;
                        }
                        
                        var ids = [];
                        $(selectedRows).each(function() {
                            var id = $(this).data('id');
                            if (id) {
                                ids.push(id);
                            }
                        });
                        
                        console.log('IDs to delete:', ids);
                        
                        if (ids.length === 0) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to get IDs from selected data'
                            });
                            return;
                        }

                        // Menentukan tipe dan route berdasarkan URL saat ini
                        let currentPath = window.location.pathname;
                        let type, route;

                        if (currentPath.includes('/user')) {
                            type = 'users';
                            route = '{{ route("manager.user.bulk-destroy") }}';
                        } else if (currentPath.includes('/vendor')) {
                            type = 'vendors';
                            route = '{{ route("manager.vendor.bulk-destroy") }}';
                        } else if (currentPath.includes('/warehouse')) {
                            type = 'warehouses';
                            route = '{{ route("manager.warehouse.bulk-destroy") }}';
                        } else if (currentPath.includes('/project')) {
                            type = 'projects';
                            route = '{{ route("manager.project.bulk-destroy") }}';
                        }
                        
                        Swal.fire({
                            title: 'Are you sure?',
                            text: `You will delete ${ids.length} selected ${type}!`,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, delete them!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                const form = document.createElement('form');
                                form.method = 'POST';
                                form.action = route;
                                
                                // CSRF token
                                const csrfToken = document.createElement('input');
                                csrfToken.type = 'hidden';
                                csrfToken.name = '_token';
                                csrfToken.value = document.querySelector('meta[name="csrf-token"]').content;
                                form.appendChild(csrfToken);
                                
                                // Method spoofing
                                const methodField = document.createElement('input');
                                methodField.type = 'hidden';
                                methodField.name = '_method';
                                methodField.value = 'DELETE';
                                form.appendChild(methodField);
                                
                                // Add selected IDs
                                ids.forEach(id => {
                                    const idField = document.createElement('input');
                                    idField.type = 'hidden';
                                    idField.name = 'ids[]';
                                    idField.value = id;
                                    form.appendChild(idField);
                                });
                                
                                document.body.appendChild(form);
                                form.submit();
                            }
                        });
                    }
                }
            ],
            layout: {
                topStart: 'buttons'
            },
            select: true,
            columnDefs: [
                            {
                                targets: [0], // Kolom ID (index 0)
                                visible: false,
                                searchable: false
                            }
                        ],
            language: {
                search: "Search:",
                lengthMenu: "Show _MENU_ entries",
                info: "Showing _START_ to _END_ of _TOTAL_ entries",
                infoEmpty: "No entries available",
                zeroRecords: "No matching records found",
                processing: "Processing...",
                paginate: {
                    first: "First",
                    last: "Last",
                    next: "Next",
                    previous: "Previous"
                },
                aria: {
                    sortAscending: ": activate to sort column ascending",
                    sortDescending: ": activate to sort column descending"
                }
            }
        } );
    </script>

    {{-- sweetalert --}}
    <script>
        function deleteConfirmation(id, name, type, route, isBulk = false) {
            Swal.fire({
                title: 'Are you sure?',
                text: isBulk ? `You will delete selected ${type}s!` : `You will delete ${type} "${name}"!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = route;
                    
                    let formContent = `
                        <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').content}">
                        <input type="hidden" name="_method" value="DELETE">
                    `;

                    if (isBulk && Array.isArray(id)) {
                        id.forEach(itemId => {
                            formContent += `<input type="hidden" name="ids[]" value="${itemId}">`;
                        });
                    } else {
                        formContent += `<input type="hidden" name="id" value="${id}">`;
                    }

                    form.innerHTML = formContent;
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
        function confirmLogout(event) {
            event.preventDefault();
            
            Swal.fire({
                title: 'Are you sure?',
                text: "You will be logged out from your session!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, logout!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '/logout';
                }
            });
        }
    </script>

    {{-- toolstips --}}
    <script>
        $(document).ready(function(){
            $('[data-bs-toggle="tooltip"]').tooltip();
        });
    </script>

    {{-- setting --}}
    <script>
        $(document).ready(function() {
            $('#generalSettingsForm').on('submit', function(e) {
                e.preventDefault();
                
                var formData = new FormData(this);
                
                $.ajax({
                    url: "{{ route('settings.general.update') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if(response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.success
                            }).then(function() {
                                $('#generalSettingsModal').modal('hide');
                                location.reload();
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseJSON.error || 'Something went wrong!'
                        });
                    }
                });
            });
        });
    </script>

    {{-- mailing system --}}
    <script>
        $(document).ready(function() {
            // Toggle SMTP Config visibility
            $('#mailDriver').change(function() {
                if($(this).val() === 'smtp') {
                    $('#smtpConfig').slideDown();
                } else {
                    $('#smtpConfig').slideUp();
                }
            }).trigger('change');
        
            // Save Mail Settings
            $('#mailSettingsForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('settings.mail.update') }}",
                    type: "POST",
                    data: $(this).serialize(),
                    success: function(response) {
                        if(response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.success
                            }).then(function() {
                                $('#mailSettingsModal').modal('hide');
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseJSON.error || 'Something went wrong!'
                        });
                    }
                });
            });
        
            // Test Mail Button
            $('#testMailBtn').click(function() {
                $('#mailSettingsModal').modal('hide');
                $('#testMailModal').modal('show');
            });
        
            // Send Test Mail
            $('#testMailForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('settings.mail.test') }}",
                    type: "POST",
                    data: $(this).serialize(),
                    beforeSend: function() {
                        Swal.fire({
                            title: 'Sending...',
                            text: 'Sending test email',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Test email sent successfully!'
                        }).then(function() {
                            $('#testMailModal').modal('hide');
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseJSON.error || 'Failed to send test email'
                        });
                    }
                });
            });
        });
    </script>

    {{-- aws config --}}
    <script>
        $(document).ready(function() {
            $('#s3SettingsForm').on('submit', function(e) {
            e.preventDefault();
            
            let formData = $(this).serialize();
            console.log('Form data:', formData);  // Debug form data
            
            $.ajax({
                url: "{{ route('settings.storage.update') }}",
                type: "POST",
                data: formData,
                success: function(response) {
                    console.log('Success:', response);  // Debug response
                    if(response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.success
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', xhr.responseText);  // Debug error
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: xhr.responseJSON?.error || 'Something went wrong!'
                    });
                }
            });
        });

        $('#testS3Btn').click(function() {
        $.ajax({
            url: "{{ route('settings.storage.test') }}",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function() {
                Swal.fire({
                    title: 'Testing...',
                    text: 'Testing S3 connection',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            },
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response.success
                });
            },
            error: function(xhr, status, error) {
                console.error('Error details:', xhr.responseJSON);  // Tambahkan ini untuk debug
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: xhr.responseJSON?.error || 'Failed to test connection'
                });
            }
            });
        });
            });
    </script>

    {{-- view / update materials --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle status button clicks
            const statusButtons = document.querySelectorAll('.status-btn');
            statusButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const status = this.dataset.status;
                    const modalId = this.closest('.modal').id;
                    const doReleaseSection = this.closest('.modal-content').querySelector('.do-release-section');
                    
                    // Update hidden status input
                    document.querySelector(`#${modalId} input[name="status"]`).value = status;
                    
                    // Reset all buttons to default state
                    this.closest('.modal-content').querySelectorAll('.status-btn').forEach(btn => {
                        btn.classList.remove('active');
                    });
                    
                    // Activate clicked button
                    this.classList.add('active');
                    
                    // Show/hide DO Release section
                    if (status === 'approved') {
                        doReleaseSection.style.display = 'block';
                    } else {
                        doReleaseSection.style.display = 'none';
                    }
                });
            });
        });
    </script>
    
</body>

</html>