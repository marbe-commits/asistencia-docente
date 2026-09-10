<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22%232563EB%22><path d=%22M12 2L1 8l11 6 9-4.91V17h2V9L12 2z%22/><path d=%22M4.14 11.51l-1.04.57C3.04 12.1 3 12.19 3 12.29v3.42c0 .6.36 1.15.92 1.39l7.5 3.22c.37.16.79.16 1.16 0l7.5-3.22c.56-.24.92-.79.92-1.39v-3.42c0-.1-.04-.19-.1-.21l-1.04-.57-6.22 3.4c-.65.35-1.43.35-2.08 0l-6.22-3.4z%22/></svg>">

    <title>Sistema de Asistencia Docente</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">

<div body class="bg-gray-100">
        {{ $slot }}
    </div>
</div>

</body>
</html>