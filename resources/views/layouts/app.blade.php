<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Sistema Inteligente de Asistencia Docente</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-100">

<div class="flex min-h-screen">

    {{-- Sidebar --}}
    @include('layouts.navigation')

    {{-- Contenido principal --}}
    <div class="flex-1 ml-64">

        {{-- Header --}}
        @if (isset($header))
        <header class="bg-white shadow-lg border-b">
            <div class="px-8 py-5">
                {{ $header }}
            </div>
        </header>
        @endif

        {{-- Contenido --}}
        <main class="p-8 bg-gray-50 min-h-screen">
            {{ $slot }}
        </main>

    </div>

</div>

</body>
</html>