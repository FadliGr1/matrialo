<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    {{-- <link rel="stylesheet" href="./css/index.css"> --}}
    @vite(['resources/css/index.css'])

    <title>Matrialo - Login </title>
</head>

<body>
    <div class="screen-cover d-none d-xl-none"></div>

    <div class="content container d-flex justify-content-center align-items-center" style="height: 100vh">
        <div class="row">
            <div class="col-12 col-lg-12">     
                <div class="statistics-card px-5">
                    @include('component.alert.success')
                    @include('component.alert.error')
                    <form action="/login-process" method="POST">
                        @csrf
                        <div class="mb-3">
                            <p class="text-center fw-bold mt-3">Masuk</p>    
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control" id="email" aria-describedby="emailhelp" placeholder="your@email.com">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" id="password" aria-describedby="passwordhelp" placeholder="Password">
                        </div>
                        <!-- recaptcha v3 -->
                        {{-- {!! NoCaptcha::renderJs() !!}
                        {!! NoCaptcha::display() !!} --}}
                        <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
                        <button type="submit" class="btn btn-primary col-12 rounded-5 mt-3">Masuk</button>
                    </form>
            </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var toastEl = document.getElementById('loginToast');
                if (toastEl) {
                    var toast = new bootstrap.Toast(toastEl);
                    toast.show();
                }
            });
        </script>



</body>

</html>