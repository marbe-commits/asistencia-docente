<x-app-layout>

    <x-slot name="header">

        <div class="flex justify-between items-center">

            <div>

                <h2 class="text-3xl font-bold text-slate-800">
                    Gestion de Materias
                </h2>

                <p class="text-gray-500 mt-1">
                    Administracion del catalogo de materias academicas
                </p>

            </div>

            <div class="flex flex-wrap gap-3">

                <!-- DESCARGAR PLANTILLA -->

                <a href="{{ route('materias.plantilla') }}"
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
                    onclick="document.getElementById('archivoMaterias').click()"
                    class="bg-green-600 hover:bg-green-700 text-white px-5 py-3 rounded-xl shadow-lg font-semibold transition">

                    📤 Importar materias

                </button>


                <!-- NUEVA MATERIA -->

                <a href="{{ route('materias.create') }}"
                   class="bg-purple-600 hover:bg-purple-700 text-white px-5 py-3 rounded-xl shadow-lg font-semibold transition">

                    + Nueva Materia

                </a>

            </div>


            <!-- FORMULARIO OCULTO PARA IMPORTAR -->

            <form
                id="formImportarMaterias"
                action="{{ route('materias.importar') }}"
                method="POST"
                enctype="multipart/form-data"
                class="hidden">

                @csrf

                <input
                    type="file"
                    id="archivoMaterias"
                    name="archivo"
                    accept=".csv,.txt"
                    onchange="document.getElementById('formImportarMaterias').submit()">

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
                            id="buscarMateria"
                            placeholder="Buscar materia..."
                            class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-purple-500 focus:border-purple-500 pr-12"
                        >

                        <span
                            class="absolute right-4 top-1/2 transform -translate-y-1/2 text-purple-600 text-xl">

                        </span>

                    </div>


                    <button
                        type="button"
                        onclick="buscarMateria()"
                        class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-xl shadow font-semibold transition">

                        Buscar

                    </button>

                </div>

            </div>


            <!-- ESTADISTICAS -->

            <div class="mt-5 mb-6 grid md:grid-cols-3 gap-5">


                <!-- TOTAL -->

                <div class="bg-purple-600 text-white p-5 rounded-xl shadow">

                    <p>
                        Total Materias
                    </p>

                    <h3
                        class="text-3xl font-bold mt-2"
                        id="totalMaterias">

                        {{ count($materias) }}

                    </h3>

                </div>


                <!-- ACTIVAS -->

                <div class="bg-purple-600 text-white p-5 rounded-xl shadow">

                    <p>
                        Materias Activas
                    </p>

                    <h3
                        class="text-3xl font-bold mt-2"
                        id="materiasActivas">

                        {{ count($materias) }}

                    </h3>

                </div>


                <!-- ESTADO -->

                <div class="bg-purple-600 text-white p-5 rounded-xl shadow">

                    <p>
                        Estado del Sistema
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

                        Materias Registradas

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
                                    Clave
                                </th>

                                <th class="p-4 text-left">
                                    Nombre
                                </th>

                                <th class="p-4 text-left">
                                    Cuatrimestre
                                </th>

                                <th class="p-4 text-center">
                                    Estado
                                </th>

                            </tr>

                        </thead>


                        <tbody id="tablaMaterias">

                            @forelse($materias as $materia)

                            <tr
                                class="border-b hover:bg-gray-50 transition fila-materia"
                                data-busqueda="{{ strtolower(
                                    $materia->clave . ' ' .
                                    $materia->nombre . ' ' .
                                    $materia->cuatrimestre
                                ) }}"
                            >

                                <td class="p-4">

                                    {{ $materia->id }}

                                </td>


                                <td class="p-4 font-semibold text-purple-700">

                                    {{ $materia->clave }}

                                </td>


                                <td class="p-4">

                                    {{ $materia->nombre }}

                                </td>


                                <td class="p-4 text-gray-600">

                                    {{ $materia->cuatrimestre }}

                                </td>


                                <td class="p-4 text-center">

                                    <span
                                        class="bg-green-600 text-white px-4 py-2 rounded-full font-semibold shadow">

                                        Activa

                                    </span>

                                </td>

                            </tr>


                            @empty

                            <tr>

                                <td
                                    colspan="5"
                                    class="text-center p-10 text-gray-500">

                                    No hay materias registradas

                                </td>

                            </tr>

                            @endforelse


                            <tr
                                id="sinResultados"
                                style="display:none;">

                                <td
                                    colspan="5"
                                    class="text-center p-10 text-gray-500">

                                    No se encontraron materias

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

        function buscarMateria() {

            const texto =
                document
                    .getElementById('buscarMateria')
                    .value
                    .toLowerCase()
                    .trim();


            const filas =
                document.querySelectorAll('.fila-materia');


            const sinResultados =
                document.getElementById('sinResultados');


            let encontradas = 0;


            filas.forEach(function(fila) {

                const contenido =
                    fila.getAttribute('data-busqueda');


                if (contenido.includes(texto)) {

                    fila.style.display = '';

                    encontradas++;

                } else {

                    fila.style.display = 'none';

                }

            });


            if (
                encontradas === 0 &&
                filas.length > 0
            ) {

                sinResultados.style.display = '';

            } else {

                sinResultados.style.display = 'none';

            }


            document
                .getElementById('totalMaterias')
                .textContent = encontradas;


            document
                .getElementById('materiasActivas')
                .textContent = encontradas;

        }


        document
            .getElementById('buscarMateria')
            .addEventListener(
                'keyup',
                function(event) {

                    if (event.key === 'Enter') {

                        buscarMateria();

                    }

                }
            );

    </script>

</x-app-layout>