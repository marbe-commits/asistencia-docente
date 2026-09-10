<x-app-layout>

    <x-slot name="header">

        <div class="flex justify-between items-center">

            <div>

                <h2 class="text-3xl font-bold text-slate-800">
                    Gestion de Grupos
                </h2>

                <p class="text-gray-500 mt-1">
                    Administracion de grupos academicos
                </p>

            </div>

            <div class="flex flex-wrap gap-3">

                <!-- DESCARGAR PLANTILLA -->

                <a href="{{ route('grupos.plantilla') }}"
                   style="
                       background-color:#374151;
                       color:#ffffff;
                       display:inline-flex;
                       align-items:center;
                       padding:12px 20px;
                       border-radius:12px;
                       box-shadow:0 4px 10px rgba(0,0,0,.15);
                       font-weight:600;
                       text-decoration:none;
                       transition:all .2s ease;
                   "
                   onmouseover="this.style.backgroundColor='#1F2937'"
                   onmouseout="this.style.backgroundColor='#374151'">

                    📥 <span style="margin-left:8px;">Descargar plantilla</span>

                </a>


                <!-- IMPORTAR -->

                <button
                    type="button"
                    onclick="document.getElementById('archivoGrupos').click()"
                    class="bg-green-600 hover:bg-green-700 text-white px-5 py-3 rounded-xl shadow-lg font-semibold transition">

                    📤 Importar grupos

                </button>


                <!-- NUEVO GRUPO -->

                <a href="{{ route('grupos.create') }}"
                   class="bg-purple-600 hover:bg-purple-700 text-white px-5 py-3 rounded-xl shadow-lg font-semibold transition">

                    + Nuevo Grupo

                </a>

            </div>


            <!-- FORMULARIO OCULTO PARA IMPORTAR -->

            <form
                id="formImportarGrupos"
                action="{{ route('grupos.importar') }}"
                method="POST"
                enctype="multipart/form-data"
                class="hidden">

                @csrf

                <input
                    type="file"
                    id="archivoGrupos"
                    name="archivo"
                    accept=".csv,.txt"
                    onchange="document.getElementById('formImportarGrupos').submit()">

            </form>

        </div>

    </x-slot>


    <div class="py-8">

        @if(session('success'))

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-5">

                <div class="bg-green-100 border border-green-300 text-green-800 px-5 py-4 rounded-xl shadow">

                    ✅ {{ session('success') }}

                </div>

            </div>

        @endif


        @if(session('error'))

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-5">

                <div class="bg-red-100 border border-red-300 text-red-800 px-5 py-4 rounded-xl shadow">

                    ❌ {{ session('error') }}

                </div>

            </div>

        @endif


        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">


            <!-- BUSCADOR -->

            <div class="bg-white rounded-2xl shadow-lg p-5 mb-5">

                <div class="flex gap-3">

                    <div class="relative flex-1">

                        <input
                            type="text"
                            id="buscarGrupo"
                            placeholder="Buscar grupo..."
                            class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-purple-500 focus:border-purple-500 pr-12"
                        >

                        <span
                            class="absolute right-4 top-1/2 transform -translate-y-1/2 text-purple-600 text-xl">

                        </span>

                    </div>


                    <button
                        type="button"
                        onclick="buscarGrupo()"
                        class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-xl shadow font-semibold transition">

                        Buscar

                    </button>

                </div>

            </div>


            <!-- ESTADISTICAS -->

            <div class="mt-5 mb-6 grid md:grid-cols-3 gap-5">


                <!-- TOTAL GRUPOS -->

                <div class="bg-purple-600 text-white p-5 rounded-xl shadow">

                    <p>
                        Total Grupos
                    </p>

                    <h3
                        class="text-3xl font-bold mt-2"
                        id="totalGrupos">

                        {{ count($grupos) }}

                    </h3>

                </div>


                <!-- TOTAL ALUMNOS -->

                <div class="bg-purple-600 text-white p-5 rounded-xl shadow">

                    <p>
                        Total Alumnos
                    </p>

                    <h3
                        class="text-3xl font-bold mt-2"
                        id="totalAlumnos">

                        {{ $grupos->sum('numero_alumnos') }}

                    </h3>

                </div>


                <!-- ESTADO -->

                <div class="bg-purple-600 text-white p-5 rounded-xl shadow">

                    <p>
                        Estado Sistema
                    </p>

                    <h3 class="text-2xl font-bold mt-2">

                        Operativo

                    </h3>

                </div>

            </div>


            <!-- TABLA -->

            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">

                <div class="p-5 border-b">

                    <h3 class="text-xl font-bold text-gray-700">

                        Grupos Registrados

                    </h3>

                </div>


                <div class="overflow-x-auto">

                    <table class="w-full">

                        <thead class="bg-slate-800 text-white">

                            <tr>

                                <th class="p-4 text-left">
                                    ID
                                </th>

                                <th class="p-4 text-left">
                                    Grupo
                                </th>

                                <th class="p-4 text-left">
                                    Carrera
                                </th>

                                <th class="p-4 text-left">
                                    Cuatrimestre
                                </th>

                                <th class="p-4 text-left">
                                    Alumnos
                                </th>

                                <th class="p-4 text-center">
                                    Acciones
                                </th>

                            </tr>

                        </thead>


                        <tbody id="tablaGrupos">

                            @forelse($grupos as $grupo)

                            <tr
                                class="border-b hover:bg-gray-50 transition fila-grupo"
                                data-busqueda="{{ strtolower(
                                    $grupo->nombre . ' ' .
                                    $grupo->carrera . ' ' .
                                    $grupo->cuatrimestre
                                ) }}"
                                data-alumnos="{{ $grupo->numero_alumnos }}"
                            >

                                <!-- ID -->

                                <td class="p-4">

                                    {{ $grupo->id }}

                                </td>


                                <!-- GRUPO -->

                                <td class="p-4 font-semibold text-purple-700">

                                    {{ $grupo->nombre }}

                                </td>


                                <!-- CARRERA -->

                                <td class="p-4">

                                    {{ $grupo->carrera }}

                                </td>


                                <!-- CUATRIMESTRE -->

                                <td class="p-4">

                                    {{ $grupo->cuatrimestre }}

                                </td>


                                <!-- ALUMNOS -->

                                <td class="p-4">

                                    <span
                                        class="bg-blue-100 text-blue-700 px-4 py-2 rounded-full font-semibold">

                                        {{ $grupo->numero_alumnos }} alumnos

                                    </span>

                                </td>


                                <!-- ACCIONES -->

                                <td class="p-4 text-center">

                                    <div class="flex justify-center gap-2">

                                        <a
                                            href="{{ route('grupos.edit', $grupo) }}"
                                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg font-semibold transition">

                                            Editar

                                        </a>


                                        <form
                                            action="{{ route('grupos.destroy', $grupo) }}"
                                            method="POST"
                                            class="inline">

                                            @csrf

                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                onclick="return confirm('Deseas eliminar este grupo?')"
                                                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-semibold transition">

                                                Eliminar

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>


                            @empty

                            <tr>

                                <td
                                    colspan="6"
                                    class="text-center p-10 text-gray-500">

                                    No hay grupos registrados

                                </td>

                            </tr>

                            @endforelse


                            <!-- SIN RESULTADOS -->

                            <tr
                                id="sinResultados"
                                style="display:none;">

                                <td
                                    colspan="6"
                                    class="text-center p-10 text-gray-500">

                                    No se encontraron grupos

                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>


        </div>

    </div>


    <!-- BUSQUEDA -->

    <script>

        function buscarGrupo() {

            const texto =
                document
                    .getElementById('buscarGrupo')
                    .value
                    .toLowerCase()
                    .trim();


            const filas =
                document.querySelectorAll('.fila-grupo');


            const sinResultados =
                document.getElementById('sinResultados');


            let encontrados = 0;

            let totalAlumnos = 0;


            filas.forEach(function(fila) {

                const contenido =
                    fila.getAttribute('data-busqueda');


                const alumnos =
                    parseInt(
                        fila.getAttribute('data-alumnos')
                    ) || 0;


                if (contenido.includes(texto)) {

                    fila.style.display = '';

                    encontrados++;

                    totalAlumnos += alumnos;

                } else {

                    fila.style.display = 'none';

                }

            });


            /*
            |--------------------------------------------------------------------------
            | MOSTRAR MENSAJE
            |--------------------------------------------------------------------------
            */

            if (
                encontrados === 0 &&
                filas.length > 0
            ) {

                sinResultados.style.display = '';

            } else {

                sinResultados.style.display = 'none';

            }


            /*
            |--------------------------------------------------------------------------
            | ACTUALIZAR ESTADISTICAS
            |--------------------------------------------------------------------------
            */

            document
                .getElementById('totalGrupos')
                .textContent = encontrados;


            document
                .getElementById('totalAlumnos')
                .textContent = totalAlumnos;

        }


        /*
        |--------------------------------------------------------------------------
        | BUSCAR CON ENTER
        |--------------------------------------------------------------------------
        */

        document
            .getElementById('buscarGrupo')
            .addEventListener(
                'keyup',
                function(event) {

                    if (event.key === 'Enter') {

                        buscarGrupo();

                    }

                }
            );

    </script>

</x-app-layout>