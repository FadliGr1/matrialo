<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Matrialo - Material Management System Login">
    <title>Matrialo - Material Management System</title>
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    @vite(['resources/css/main.css'])
</head>
<body>
    <main class="container">
        <div class="row ">
            <div class="col d-flex justify-content-center">
                <div class="login-container">
                    <!-- Logo Section -->
                    <header class="text-center mb-4">
                        <div class="logo-wrapper">
                            <i class="fas fa-boxes fa-3x" style="color: var(--primary-color);"></i>
                        </div>
                        <h1 class="logo-text">Matrialo</h1>
                        <p class="subtitle">Material Management System</p>
                    </header>
                    @yield('content')
                    <!-- Helper Text -->
                    <p class="helper-text text-center">
                        Need help? Contact your system administrator
                    </p>
                </div>
            </div>
        </div>
    </main>
    <!-- Version Text -->
    <div class="version-text">
        Matrialo v1.0.0
    </div>

    @if(session()->has('success'))
    <script>
        Toastify({
            text: "{{ session('success') }}",
            duration: 3000,
            gravity: "top",
            position: "right",
            stopOnFocus: true,
            style: {
                background: "linear-gradient(to right, #0BAB64, #3BB78F)",
                borderRadius: "8px",
                padding: "16px",
                color: "white",
                boxShadow: "0 8px 16px -4px rgba(59, 183, 143, 0.15)",
                fontSize: "14px",
                fontWeight: "500"
            }
        }).showToast();
    </script>
    @endif

    @if(session()->has('error'))
        <script>
            Toastify({
                text: "{{ session('error') }}",
                duration: 3000,
                gravity: "top",
                position: "right",
                stopOnFocus: true,
                style: {
                    background: "linear-gradient(to right, #FF416C, #FF4B2B)",
                    borderRadius: "8px",
                    padding: "16px",
                    color: "white",
                    boxShadow: "0 8px 16px -4px rgba(255, 65, 108, 0.15)",
                    fontSize: "14px",
                    fontWeight: "400"
                }
            }).showToast();
        </script>
    @endif

    @if(session()->has('warning'))
        <script>
            Toastify({
                text: "{{ session('warning') }}",
                duration: 3000,
                gravity: "top",
                position: "right",
                stopOnFocus: true,
                style: {
                    background: "linear-gradient(to right, #F7971E, #FFD200)",
                    borderRadius: "8px",
                    padding: "16px",
                    color: "#1F2937",
                    boxShadow: "0 8px 16px -4px rgba(247, 151, 30, 0.15)",
                    fontSize: "14px",
                    fontWeight: "500"
                }
            }).showToast();
        </script>
    @endif

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
</body>
</html>