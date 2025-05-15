<!DOCTYPE html>
<html lang="en-gb" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <title>Cuisine Website</title>
    <link rel="icon" href="{{ asset('images/icon-cuisine.png') }}" type="image/png">
    <script src="{{ asset('js/uikit.js') }}"></script>
    <link rel="shortcut icon" type="image/png" href="{{ asset('img/favicon.png') }}">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Leckerli+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('css/main.css') }}" >

    {{-- <script src="https://cdn.tailwindcss.com"/> --}}


</head>

<body>


    <div class="preloader">
        <div class="preloader__image"></div>
    </div>

    @include('components.nav-header')

    {{-- <div class="uk-section uk-section-default"> --}}



    <!-- Main Content Section -->

    @yield('content')


    <!-- Footer Section -->

    {{-- </div> --}}
    @include('components.nav-footer')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>
