<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Asistencia Docente</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-r from-blue-900 to-indigo-900 min-h-screen">

<div class="flex items-center justify-center min-h-screen">

    <div class="bg-white p-10 rounded-2xl shadow-2xl text-center w-full max-w-2xl">

        <h1 class="text-5xl font-bold text-blue-800 mb-4">
            Sistema Inteligente de Control de Asistencia Docente
        </h1>

        <p class="text-gray-600 text-lg mb-8">
            Gestión de docentes, materias, grupos, horarios,
            clases, asistencias y reportes.
        </p>

        <div class="flex justify-center gap-6">

            <a href="{{ route('login') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-lg text-xl font-bold shadow">
                Iniciar Sesión
            </a>

            <a href="{{ route('register') }}"
               class="bg-green-600 hover:bg-green-700 text-white px-8 py-4 rounded-lg text-xl font-bold shadow">
                Registrarse
            </a>

        </div>

        <div class="mt-10 border-t pt-6">

            <h2 class="text-xl font-semibold mb-4">
                Funciones del Sistema
            </h2>

            <div class="grid grid-cols-2 gap-4 text-left">

                <div>✅ Gestión de Docentes</div>
                <div>✅ Gestión de Materias</div>

                <div>✅ Gestión de Grupos</div>
                <div>✅ Gestión de Aulas</div>

                <div>✅ Gestión de Horarios</div>
                <div>✅ Gestión de Clases</div>

                <div>✅ Control de Asistencias</div>
                <div>✅ Reportes PDF</div>

                <div>🚀 Código QR</div>
                <div>🚀 Reportes Excel</div>

            </div>

        </div>

    </div>

</div>

</body>
</html>