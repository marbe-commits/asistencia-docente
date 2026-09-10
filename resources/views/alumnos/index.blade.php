<x-app-layout>

    <x-slot name="header">

        <div class="flex justify-between items-center">

            <div>

                <h2 class="text-3xl font-bold" style="color:#4C1D95;">
                    Gestión de Alumnos
                </h2>

                <p class="mt-1" style="color:#6B5B95;">
                    Administración de alumnos registrados en el sistema
                </p>

            </div>


            <div class="flex gap-3 flex-wrap">

                {{-- NUEVO ALUMNO --}}
                <a href="{{ route('alumnos.create') }}"
                   class="text-white px-6 py-3 rounded-xl shadow-lg font-semibold transition duration-300 hover:scale-105"
                   style="background:linear-gradient(135deg,#8B5CF6,#6D28D9);">

                    + Nuevo Alumno

                </a>


                {{-- PLANTILLA CSV --}}
                <a href="{{ route('alumnos.plantilla') }}"
                   class="text-white px-6 py-3 rounded-xl shadow-lg font-semibold transition duration-300 hover:scale-105"
                   style="background:linear-gradient(135deg,#2563EB,#1D4ED8);">

                    📄 Descargar plantilla

                </a>


                {{-- IMPORTAR CSV --}}
                <button
                    type="button"
                    onclick="document.getElementById('archivoCSV').click()"
                    class="text-white px-6 py-3 rounded-xl shadow-lg font-semibold transition duration-300 hover:scale-105"
                    style="background:linear-gradient(135deg,#059669,#047857);">

                    📥 Importar alumnos

                </button>


                <form
                    id="formCSV"
                    action="{{ route('alumnos.importar') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    class="hidden">

                    @csrf

                    <input
                        type="file"
                        id="archivoCSV"
                        name="archivo"
                        accept=".csv,.txt"
                        onchange="document.getElementById('formCSV').submit()">

                </form>

            </div>

        </div>

    </x-slot>


    <div class="py-8" style="background:#F8F5FF; min-height:100vh;">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">


            {{-- MENSAJE DE ÉXITO --}}

            @if(session('success'))

                <div class="mb-6 p-4 rounded-xl shadow"
                     style="
                        background:#DCFCE7;
                        color:#166534;
                        border:1px solid #86EFAC;
                     ">

                    ✅ {{ session('success') }}

                </div>

            @endif


            {{-- MENSAJE DE ERROR --}}

            @if(session('error'))

                <div class="mb-6 p-4 rounded-xl shadow"
                     style="
                        background:#FEE2E2;
                        color:#991B1B;
                        border:1px solid #FCA5A5;
                     ">

                    ❌ {{ session('error') }}

                </div>

            @endif


            {{-- ERRORES DE VALIDACIÓN --}}

            @if($errors->any())

                <div class="mb-6 p-4 rounded-xl shadow"
                     style="
                        background:#FEF3C7;
                        color:#92400E;
                        border:1px solid #FCD34D;
                     ">

                    <strong>
                        ⚠️ Se encontraron errores:
                    </strong>

                    <ul class="mt-2 list-disc list-inside">

                        @foreach($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif


            {{-- ERRORES DE IMPORTACIÓN --}}

            @if(session('errores_importacion'))

                <div class="mb-6 p-4 rounded-xl shadow"
                     style="
                        background:#FFF7ED;
                        color:#9A3412;
                        border:1px solid #FDBA74;
                     ">

                    <strong>
                        ⚠️ Algunos alumnos no pudieron importarse:
                    </strong>

                    <ul class="mt-2 list-disc list-inside">

                        @foreach(session('errores_importacion') as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif


            {{-- BUSCADOR --}}

            <div
                class="bg-white rounded-3xl shadow-xl p-5 mb-6 border"
                style="border-color:#DDD6FE;"
            >

                <div class="flex gap-3 items-center">


                    {{-- INPUT --}}

                    <div
                        style="
                            position:relative;
                            flex:1;
                        "
                    >

                        {{-- LUPA --}}

                        <span
                            style="
                                position:absolute;
                                left:16px;
                                top:50%;
                                transform:translateY(-50%);
                                color:#7C3AED;
                                font-size:18px;
                                pointer-events:none;
                            "
                        >
                            
                        </span>


                        <input
                            type="text"
                            id="buscarAlumno"
                            placeholder="Buscar alumno..."
                            class="w-full rounded-xl px-5 py-3 outline-none transition"
                            style="
                                border:2px solid #DDD6FE;
                                padding-left:45px;
                            "
                            onkeyup="filtrarAlumnos()"
                        >

                    </div>


                    {{-- BOTÓN BUSCAR --}}

                    <button
                        type="button"
                        onclick="filtrarAlumnos()"
                        class="text-white px-6 py-3 rounded-xl shadow-lg font-semibold transition duration-300 hover:scale-105"
                        style="
                            background:linear-gradient(
                                135deg,
                                #8B5CF6,
                                #6D28D9
                            );
                        "
                    >

                        Buscar

                    </button>

                </div>

            </div>


            {{-- ESTADÍSTICAS --}}

            <div class="mt-0 mb-6 grid md:grid-cols-3 gap-6">


                {{-- TOTAL ALUMNOS --}}

                <div
                    class="text-white p-6 rounded-3xl shadow-xl"
                    style="
                        background:linear-gradient(
                            135deg,
                            #A855F7,
                            #7C3AED
                        );
                    "
                >

                    <p>
                        Total Alumnos
                    </p>

                    <h3 class="text-4xl font-bold mt-2">

                        {{ count($alumnos) }}

                    </h3>

                </div>


                {{-- ACTIVOS --}}

                <div
                    class="text-white p-6 rounded-3xl shadow-xl"
                    style="
                        background:linear-gradient(
                            135deg,
                            #8B5CF6,
                            #6D28D9
                        );
                    "
                >

                    <p>
                        Activos
                    </p>

                    <h3 class="text-4xl font-bold mt-2">

                        {{ count($alumnos) }}

                    </h3>

                </div>


                {{-- ESTADO DEL SISTEMA --}}

                <div
                    class="text-white p-6 rounded-3xl shadow-xl"
                    style="
                        background:linear-gradient(
                            135deg,
                            #6D28D9,
                            #4C1D95
                        );
                    "
                >

                    <p>
                        Estado del Sistema
                    </p>

                    <h3 class="text-3xl font-bold mt-2">

                        Operativo

                    </h3>

                </div>

            </div>


            {{-- TABLA --}}

            <div
                class="bg-white rounded-3xl shadow-xl overflow-hidden border"
                style="border-color:#DDD6FE;"
            >


                {{-- TÍTULO --}}

                <div
                    class="p-6 border-b"
                    style="border-color:#E9D5FF;"
                >

                    <h3
                        class="text-2xl font-bold"
                        style="color:#4C1D95;"
                    >

                        Alumnos Registrados

                    </h3>

                </div>


                {{-- TABLA RESPONSIVA --}}

                <div style="overflow-x:auto;">

                    <table
                        class="w-full"
                        id="tablaAlumnos"
                    >

                        <thead
                            style="
                                background:#5B21B6;
                                color:white;
                            "
                        >

                            <tr>

                                <th class="p-4 text-left">
                                    ID
                                </th>

                                <th class="p-4 text-left">
                                    Matrícula
                                </th>

                                <th class="p-4 text-left">
                                    Nombre
                                </th>

                                <th class="p-4 text-left">
                                    Correo
                                </th>

                                <th class="p-4 text-left">
                                    Grupo
                                </th>

                                <th class="p-4 text-center">
                                    Acciones
                                </th>

                            </tr>

                        </thead>


                        <tbody>


                            @forelse($alumnos as $alumno)


                            <tr
                                class="fila-alumno border-b hover:bg-purple-50 transition"
                                style="border-color:#E5E7EB;"
                            >


                                {{-- ID --}}

                                <td class="p-4">

                                    {{ $alumno->id }}

                                </td>


                                {{-- MATRÍCULA --}}

                                <td
                                    class="p-4 font-semibold"
                                    style="color:#6D28D9;"
                                >

                                    {{ $alumno->matricula }}

                                </td>


                                {{-- NOMBRE --}}

                                <td class="p-4">

                                    {{ $alumno->nombre }}
                                    {{ $alumno->apellido_paterno }}
                                    {{ $alumno->apellido_materno }}

                                </td>


                                {{-- CORREO --}}

                                <td class="p-4">

                                    {{ $alumno->correo }}

                                </td>


                                {{-- GRUPO --}}

                                <td class="p-4">

                                    <span
                                        class="px-4 py-2 rounded-full text-sm font-semibold"
                                        style="
                                            background:#EDE9FE;
                                            color:#5B21B6;
                                        "
                                    >

                                        {{ $alumno->grupo->nombre ?? 'Sin grupo' }}

                                    </span>

                                </td>


                                {{-- ACCIONES --}}

                                <td class="p-4">

                                    <div
                                        class="flex justify-center gap-3"
                                    >


                                        {{-- EDITAR --}}

                                        <a
                                            href="{{ route('alumnos.edit',$alumno) }}"
                                            class="text-white px-4 py-2 rounded-lg shadow transition hover:scale-105"
                                            style="
                                                background:#7C3AED;
                                            "
                                        >

                                            ✏ Editar

                                        </a>


                                        {{-- ELIMINAR --}}

                                        <form
                                            action="{{ route('alumnos.destroy',$alumno) }}"
                                            method="POST"
                                        >

                                            @csrf

                                            @method('DELETE')


                                            <button
                                                type="submit"
                                                onclick="return confirm('¿Eliminar alumno?')"
                                                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg shadow transition hover:scale-105"
                                            >

                                                🗑 Eliminar

                                            </button>

                                        </form>


                                    </div>

                                </td>

                            </tr>


                            @empty


                            <tr>

                                <td
                                    colspan="6"
                                    class="text-center p-12"
                                    style="color:#6B5B95;"
                                >

                                    No hay alumnos registrados

                                </td>

                            </tr>


                            @endforelse


                        </tbody>

                    </table>

                </div>

            </div>


        </div>

    </div>


    {{-- JAVASCRIPT DEL BUSCADOR --}}

    <script>

        function filtrarAlumnos() {

            const input =
                document.getElementById('buscarAlumno');

            const texto =
                input.value
                    .toLowerCase()
                    .trim();


            const filas =
                document.querySelectorAll(
                    '#tablaAlumnos tbody .fila-alumno'
                );


            filas.forEach(function(fila) {

                const contenido =
                    fila.textContent.toLowerCase();


                if (contenido.includes(texto)) {

                    fila.style.display = '';

                } else {

                    fila.style.display = 'none';

                }

            });

        }

    </script>


</x-app-layout>