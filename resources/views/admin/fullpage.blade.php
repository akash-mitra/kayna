<!DOCTYPE html>
<html lang="en">

<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>BlogTheory Admin Installation</title>
        <link href="{{ mix('/css/app.css') }}" rel="stylesheet" />
        @yield('css')
</head>

<body class="font-sans bg-grey-lightest">

        <main>
        @yield('main')
        </main>
        
        <script src="{{ mix('/js/app.js') }}"></script>

        @yield('script')
</body>

</html>