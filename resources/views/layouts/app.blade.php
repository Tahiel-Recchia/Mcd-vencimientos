<!doctype html>
<html lang="es">
<head>
    <style>
        /* Fuerza todos los iconos con clase w-6 a tener tamaño fijo inmediatamente */
        svg.w-6 { width: 1.5rem; height: 1.5rem; }
        /* Si usas otros tamaños, agrégalos: */
        svg.w-5 { width: 1.25rem; height: 1.25rem; }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
</head>
<body>
<div class="flex flex-col h-screen bg-gray-100">


@yield('content')

</body>
</html>
