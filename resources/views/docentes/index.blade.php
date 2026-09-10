<x-app-layout>

    <x-slot name="header">

        <div class="flex justify-between items-center">

            <div>

                <h2
                    class="text-3xl font-bold"
                    style="color:#4C1D95;"
                >
                    Gestión de Docentes
                </h2>

                <p
                    class="mt-1"
                    style="color:#6B5B95;"
                >
                    Administración de docentes registrados en el sistema
                </p>

            </div>


            <div class="flex gap-3 flex-wrap">


                {{-- NUEVO DOCENTE --}}

                <a
                    href="{{ route('docentes.create') }}"
                    class="text-white px-6 py-3 rounded-xl shadow-lg font-semibold transition duration-300 hover:scale-105"
                    style="background:linear-gradient(135deg,#8B5CF6,#6D28D9);"
                >

                    + Nuevo Docente

                </a>


                {{-- DESCARGAR PLANTILLA --}}

                <a
                    href="{{ route('docentes.plantilla') }}"
                    class="text-white px-6 py-3 rounded-xl shadow-lg font-semibold transition duration-300 hover:scale-105"
                    style="background:linear-gradient(135deg,#2563EB,#1D4ED8);"
                >

                    Descargar plantilla

                </a>


                {{-- IMPORTAR DOCENTES --}}

                <button
                    type="button"
                    onclick="document.getElementById('archivoDocentes').click()"
                    class="text-white px-6 py-3 rounded-xl shadow-lg font-semibold transition duration-300 hover:scale-105"
                    style="background:linear-gradient(135deg,#059669,#047857);"
                >

                    Importar docentes

                </button>


                {{-- FORMULARIO DE IMPORTACIÓN --}}

                <form
                    id="formDocentes"
                    action="{{ route('docentes.importar') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    class="hidden"
                >

                    @csrf

                    <input
                        type="file"
                        id="archivoDocentes"
                        name="archivo"
                        accept=".csv,.txt"
                        onchange="document.getElementById('formDocentes').submit()"
                    >

                </form>

            </div>

        </div>

    </x-slot>


    <div
        class="py-8"
        style="background:#F8F5FF; min-height:100vh;"
    >

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">


            {{-- MENSAJE DE ÉXITO --}}

            @if(session('success'))

                <div
                    class="mb-6 p-4 rounded-xl shadow"
                    style="background:#DCFCE7;color:#166534;border:1px solid #86EFAC;"
                >

                    {{ session('success') }}

                </div>

            @endif


            {{-- MENSAJE DE ERROR --}}

            @if(session('error'))

                <div
                    class="mb-6 p-4 rounded-xl shadow"
                    style="background:#FEE2E2;color:#991B1B;border:1px solid #FCA5A5;"
                >

                    {{ session('error') }}

                </div>

            @endif


            {{-- ERRORES DE IMPORTACIÓN --}}

            @if(session('importacion_errores'))

                <div
                    class="mb-6 p-4 rounded-xl shadow"
                    style="background:#FEF3C7;color:#92400E;border:1px solid #FCD34D;"
                >

                    <strong>
                        Detalles de la importación
                    </strong>

                    <ul class="mt-2 list-disc list-inside">

                        @foreach(session('importacion_errores') as $error)

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

                <form
                    method="GET"
                    action="{{ route('docentes.index') }}"
                    class="flex gap-3"
                >

                    <input
                        type="text"
                        name="buscar"
                        value="{{ request('buscar') }}"
                        placeholder="Buscar docente..."
                        class="flex-1 rounded-xl px-5 py-3 outline-none"
                        style="border:2px solid #DDD6FE;"
                    >


                    <button
                        type="submit"
                        class="text-white px-6 py-3 rounded-xl font-semibold shadow-lg"
                        style="background:linear-gradient(135deg,#8B5CF6,#6D28D9);"
                    >

                        Buscar

                    </button>

                </form>

            </div>


            {{-- TABLA --}}

            <div
                class="bg-white rounded-3xl shadow-xl overflow-hidden border"
                style="border-color:#DDD6FE;"
            >

                <div
                    class="p-6 border-b"
                    style="border-color:#E9D5FF;"
                >

                    <h3
                        class="text-2xl font-bold"
                        style="color:#4C1D95;"
                    >

                        Docentes Registrados

                    </h3>

                </div>


                <div class="overflow-x-auto">

                    <table class="w-full">

                        <thead
                            style="background:#5B21B6;color:white;"
                        >

                            <tr>

                                <th class="p-4 text-left">
                                    ID
                                </th>

                                <th class="p-4 text-left">
                                    No. Empleado
                                </th>

                                <th class="p-4 text-left">
                                    Nombre Completo
                                </th>

                                <th class="p-4 text-left">
                                    Correo
                                </th>

                                <th class="p-4 text-center">
                                    Acciones
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse($docentes as $docente)

                                <tr
                                    class="border-b hover:bg-purple-50 transition"
                                >

                                    <td class="p-4">
                                        {{ $docente->id }}
                                    </td>


                                    <td
                                        class="p-4 font-semibold"
                                        style="color:#6D28D9;"
                                    >

                                        {{ $docente->numero_empleado }}

                                    </td>


                                    <td class="p-4">

                                        {{ $docente->nombre }}
                                        {{ $docente->apellido_paterno }}
                                        {{ $docente->apellido_materno }}

                                    </td>


                                    <td class="p-4">

                                        {{ $docente->correo }}

                                    </td>


                                    <td class="p-4">

                                        <div
                                            class="flex justify-center gap-3"
                                        >

                                            <a
                                                href="{{ route('docentes.edit',$docente) }}"
                                                class="text-white px-4 py-2 rounded-lg shadow transition hover:scale-105"
                                                style="background:#7C3AED;"
                                            >

                                                Editar

                                            </a>


                                            <form
                                                action="{{ route('docentes.destroy',$docente) }}"
                                                method="POST"
                                            >

                                                @csrf

                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    onclick="return confirm('Eliminar docente')"
                                                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg shadow transition hover:scale-105"
                                                >

                                                    Eliminar

                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="5"
                                        class="text-center p-12"
                                        style="color:#6B5B95;"
                                    >

                                        No hay docentes registrados

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>


            {{-- ESTADÍSTICAS --}}

            <div
                class="mt-8 grid md:grid-cols-3 gap-6"
            >

                <div
                    class="text-white p-6 rounded-3xl shadow-xl"
                    style="background:linear-gradient(135deg,#A855F7,#7C3AED);"
                >

                    <p>
                        Total Docentes
                    </p>

                    <h3
                        class="text-4xl font-bold mt-2"
                    >

                        {{ count($docentes) }}

                    </h3>

                </div>


                <div
                    class="text-white p-6 rounded-3xl shadow-xl"
                    style="background:linear-gradient(135deg,#8B5CF6,#6D28D9);"
                >

                    <p>
                        Docentes Activos
                    </p>

                    <h3
                        class="text-4xl font-bold mt-2"
                    >

                        {{ $docentes->where('activo',1)->count() }}

                    </h3>

                </div>


                <div
                    class="text-white p-6 rounded-3xl shadow-xl"
                    style="background:linear-gradient(135deg,#6D28D9,#4C1D95);"
                >

                    <p>
                        Estado del Sistema
                    </p>

                    <h3
                        class="text-3xl font-bold mt-2"
                    >

                        Operativo

                    </h3>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>