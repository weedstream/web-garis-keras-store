<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('img/kkk.jpg') }}">
    <title>Garis Keras Store</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="scroll-smooth">
    <div class="bg-neutral-950">
        @include('frontend.component.navbar')
        @yield('content')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
</body>
</html>
