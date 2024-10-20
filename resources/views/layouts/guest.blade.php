<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth/auth.css') }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{asset('js/jquery.min.js')}}"></script>
</head>

<body style="background-color: #F9FDFF;">
    <div class="font-sans text-gray-900 antialiased">
        {{ $slot }}
    </div>
    <script>
        $(".loader-wrapper").hide();
        $('#forgetForm').on('submit', function() {
            $(".loader-wrapper").show();
        })
    </script>
</body>

</html>