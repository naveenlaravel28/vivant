<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ setting('site_name', config('app.name')) }}</title>

    <!-- Fonts -->
    <link href="{{ asset('site/assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet"> -->
    <link href="{{ asset('site/assets/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('site/assets/css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('site/css/sweetalerts.min.css') }}">

    @stack('css')

</head>
<body>
    <div id="app">
        <main class="py-4">
            @auth
                @include('site/includes/header')
            @endauth
            @yield('content')
        </main>
    </div>
    @stack('modal')
    <!-- Optional JavaScript; choose one of the two! -->
    <script src="{{ asset('site/assets/js/jquery.js') }}"></script>
    <!-- Bootstrap Core JS -->
    <script src="{{ asset('site/assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('site/assets/js/bootstrap.min.js') }}"></script>

    @stack('scripts')

    <script src="{{ asset('site/js/sweetalerts.js') }}"></script>

    @if ($errors->any())
        <script>
            Swal.fire({
                title: 'Error!',
                text: 'Please check the errors below.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        </script>
    @endif

    @if (session('success'))
        <script>
            Swal.fire({
                title: 'Success!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonText: 'OK'
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                title: 'Error!',
                text: "{{ session('error') }}",
                icon: 'error',
                confirmButtonText: 'OK'
            });
        </script>
    @endif

</body>
</html>
