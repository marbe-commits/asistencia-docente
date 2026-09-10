<x-app-layout>

    <x-slot name="header">

        <div class="flex justify-between items-center">

            <div>

                <h2
                    class="text-3xl font-bold"
                    style="color:#5b21b6;"
                >
                    Gestión de Clases
                </h2>

                <p
                    style="
                        color:#6d28d9;
                        margin-top:4px;
                    "
                >
                    Administración de sesiones activas y generación QR
                </p>

            </div>


            <a
                href="{{ route('clases.create') }}"
                style="
                    background:#6d28d9;
                    color:#ffffff;
                    padding:12px 20px;
                    border-radius:12px;
                    font-weight:600;
                    text-decoration:none;
                    box-shadow:0 10px 15px rgba(109,40,217,0.25);
                "
            >
                + Nueva Clase
            </a>

        </div>

    </x-slot>


    <div class="py-8">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">


            {{-- ========================================= --}}
            {{-- MENSAJE --}}
            {{-- ========================================= --}}

            @if(session('success'))

                <div
                    style="
                        background:#dcfce7;
                        color:#166534;
                        border:1px solid #86efac;
                        padding:15px 20px;
                        border-radius:12px;
                        margin-bottom:20px;
                        font-weight:600;
                    "
                >
                    {{ session('success') }}
                </div>

            @endif


            {{-- ========================================= --}}
            {{-- BUSCADOR --}}
            {{-- ========================================= --}}

            <div
                style="
                    background:#ffffff;
                    padding:20px;
                    border-radius:16px;
                    margin-bottom:24px;
                    border:1px solid #DDD6FE;
                    box-shadow:0 8px 20px rgba(109,40,217,0.12);
                    display:flex;
                    gap:12px;
                    align-items:center;
                "
            >

                <input
                    type="text"
                    id="buscarClase"
                    placeholder="Buscar clase, docente, materia o grupo..."
                    style="
                        flex:1;
                        padding:12px 14px;
                        border:2px solid #C4B5FD;
                        border-radius:12px;
                        outline:none;
                        background:#ffffff;
                        color:#374151;
                    "
                >

                <button
                    type="button"
                    onclick="buscarClase()"
                    style="
                        background:#6d28d9;
                        color:white;
                        border:none;
                        padding:12px 18px;
                        border-radius:12px;
                        cursor:pointer;
                        font-weight:600;
                        box-shadow:0 5px 12px rgba(109,40,217,0.25);
                        transition:0.3s;
                    "
                    onmouseover="this.style.background='#5b21b6'"
                    onmouseout="this.style.background='#6d28d9'"
                >

                     Buscar

                </button>

            </div>


            {{-- ========================================= --}}
            {{-- ESTADÍSTICAS --}}
            {{-- ========================================= --}}

            <div class="mb-6 grid md:grid-cols-4 gap-5">


                {{-- TOTAL CLASES --}}

                <div
                    style="
                        background:#6d28d9;
                        color:white;
                        padding:20px;
                        border-radius:16px;
                        box-shadow:0 10px 20px rgba(109,40,217,0.25);
                    "
                >

                    <p>
                        Total Clases
                    </p>

                    <h3
                        class="text-3xl font-bold mt-2"
                    >
                        {{ count($clases) }}
                    </h3>

                </div>


                {{-- CLASES ACTIVAS --}}

                <div
                    style="
                        background:#5b21b6;
                        color:white;
                        padding:20px;
                        border-radius:16px;
                        box-shadow:0 10px 20px rgba(91,33,182,0.25);
                    "
                >

                    <p>
                        Clases Activas
                    </p>

                    <h3
                        class="text-3xl font-bold mt-2"
                    >
                        {{ $clases->where('activa',1)->count() }}
                    </h3>

                </div>


                {{-- CLASES CERRADAS --}}

                <div
                    style="
                        background:#7c3aed;
                        color:white;
                        padding:20px;
                        border-radius:16px;
                        box-shadow:0 10px 20px rgba(124,58,237,0.25);
                    "
                >

                    <p>
                        Clases Cerradas
                    </p>

                    <h3
                        class="text-3xl font-bold mt-2"
                    >
                        {{ $clases->where('activa',0)->count() }}
                    </h3>

                </div>


                {{-- SISTEMA QR --}}

                <div
                    style="
                        background:#4c1d95;
                        color:white;
                        padding:20px;
                        border-radius:16px;
                        box-shadow:0 10px 20px rgba(76,29,149,0.25);
                    "
                >

                    <p>
                        Sistema QR
                    </p>

                    <h3
                        class="text-2xl font-bold mt-2"
                    >
                        Online
                    </h3>

                </div>


            </div>


            {{-- ========================================= --}}
            {{-- TABLA --}}
            {{-- ========================================= --}}

            <div
                style="
                    background:#ffffff;
                    border-radius:18px;
                    overflow:hidden;
                    box-shadow:0 10px 25px rgba(91,33,182,0.20);
                "
            >

                <div
                    style="
                        padding:20px;
                        background:#7c3aed;
                    "
                >

                    <h3
                        style="
                            font-size:20px;
                            font-weight:bold;
                            color:#ffffff;
                        "
                    >
                        Clases Registradas
                    </h3>

                </div>


                <div style="overflow-x:auto;">

                    <table
                        class="w-full"
                        id="tablaClases"
                    >

                        <thead
                            style="
                                background:#5b21b6;
                                color:white;
                            "
                        >

                            <tr>

                                <th class="p-4 text-left">
                                    Fecha
                                </th>

                                <th class="p-4 text-left">
                                    Docente
                                </th>

                                <th class="p-4 text-left">
                                    Materia
                                </th>

                                <th class="p-4 text-left">
                                    Grupo
                                </th>

                                <th class="p-4 text-left">
                                    QR Token
                                </th>

                                <th class="p-4 text-left">
                                    Estado
                                </th>

                                <th class="p-4 text-center">
                                    Acciones
                                </th>

                            </tr>

                        </thead>


                        <tbody>


                        @forelse($clases as $clase)

                            <tr
                                class="fila-clase"
                                style="
                                    border-bottom:1px solid #ddd;
                                    color:#1f2937;
                                    transition:0.2s;
                                "
                                onmouseover="this.style.background='#f3e8ff'"
                                onmouseout="this.style.background='#ffffff'"
                            >


                                {{-- FECHA --}}

                                <td class="p-4 font-semibold">

                                    {{ \Carbon\Carbon::parse($clase->fecha)->translatedFormat('d \d\e F \d\e Y') }}

                                </td>


                                {{-- DOCENTE --}}

                                <td class="p-4 font-semibold">

                                    {{ optional($clase->horario->docente)->nombre }}

                                </td>


                                {{-- MATERIA --}}

                                <td class="p-4">

                                    {{ optional($clase->horario->materia)->nombre }}

                                </td>


                                {{-- GRUPO --}}

                                <td class="p-4">

                                    <span
                                        style="
                                            background:#ede9fe;
                                            color:#6d28d9;
                                            padding:5px 12px;
                                            border-radius:999px;
                                            font-weight:600;
                                        "
                                    >

                                        {{ optional($clase->horario->grupo)->nombre }}

                                    </span>

                                </td>


                                {{-- QR TOKEN --}}

                                <td class="p-4">

                                    <span
                                        style="
                                            background:#f5f3ff;
                                            color:#5b21b6;
                                            padding:5px 10px;
                                            border-radius:8px;
                                            font-family:monospace;
                                        "
                                    >

                                        {{ $clase->qr_token }}

                                    </span>

                                </td>


                                {{-- ESTADO --}}

                                <td class="p-4">

                                    @if($clase->activa)

                                        <span
                                            style="
                                                background:#7c3aed;
                                                color:white;
                                                padding:5px 12px;
                                                border-radius:999px;
                                                font-weight:600;
                                            "
                                        >
                                            Activa
                                        </span>

                                    @else

                                        <span
                                            style="
                                                background:#4c1d95;
                                                color:white;
                                                padding:5px 12px;
                                                border-radius:999px;
                                                font-weight:600;
                                            "
                                        >
                                            Cerrada
                                        </span>

                                    @endif

                                </td>


                                {{-- ACCIONES --}}

                                <td class="p-4 text-center">

                                    <div
                                        class="flex justify-center gap-2 flex-wrap"
                                    >


                                        {{-- GENERAR QR --}}

                                        <a
                                            href="{{ route('qr.generar', $clase->id) }}"
                                            style="
                                                background:#8b5cf6;
                                                color:white;
                                                padding:8px 14px;
                                                border-radius:10px;
                                                text-decoration:none;
                                                font-weight:600;
                                                display:inline-flex;
                                                align-items:center;
                                                gap:5px;
                                            "
                                        >

                                            📱 Generar QR

                                        </a>


                                        {{-- ASISTENCIAS --}}

                                        <a
                                            href="{{ route('reportes.asistencias.form', $clase->id) }}"
                                            style="
                                                background:#6d28d9;
                                                color:white;
                                                padding:8px 14px;
                                                border-radius:10px;
                                                text-decoration:none;
                                                font-weight:600;
                                                display:inline-flex;
                                                align-items:center;
                                                gap:5px;
                                            "
                                        >

                                            📋 Asistencias

                                        </a>


                                        {{-- EDITAR --}}

                                        <a
                                            href="{{ route('clases.edit', $clase) }}"
                                            style="
                                                background:#7c3aed;
                                                color:white;
                                                padding:8px 14px;
                                                border-radius:10px;
                                                text-decoration:none;
                                                font-weight:600;
                                                display:inline-flex;
                                                align-items:center;
                                                gap:5px;
                                            "
                                        >

                                            ✏️ Editar

                                        </a>


                                        {{-- ELIMINAR --}}

                                        <form
                                            action="{{ route('clases.destroy', $clase) }}"
                                            method="POST"
                                            style="display:inline;"
                                        >

                                            @csrf

                                            @method('DELETE')


                                            <button
                                                type="submit"
                                                onclick="return confirm('Eliminar clase')"
                                                style="
                                                    background:#5b21b6;
                                                    color:white;
                                                    padding:8px 14px;
                                                    border-radius:10px;
                                                    border:none;
                                                    font-weight:600;
                                                    cursor:pointer;
                                                "
                                            >

                                                🗑️ Eliminar

                                            </button>

                                        </form>


                                    </div>

                                </td>


                            </tr>


                        @empty


                            <tr>

                                <td
                                    colspan="7"
                                    style="
                                        text-align:center;
                                        padding:40px;
                                        color:#6d28d9;
                                    "
                                >

                                    No hay clases registradas

                                </td>

                            </tr>


                        @endforelse


                        </tbody>

                    </table>

                </div>

            </div>


        </div>

    </div>


    {{-- ========================================= --}}
    {{-- BUSCADOR --}}
    {{-- ========================================= --}}

    <script>

        function buscarClase() {

            let texto =
                document
                    .getElementById('buscarClase')
                    .value
                    .toLowerCase()
                    .trim();


            let filas =
                document.querySelectorAll(
                    '.fila-clase'
                );


            filas.forEach(function(fila) {

                let contenido =
                    fila.textContent
                        .toLowerCase();


                if (contenido.includes(texto)) {

                    fila.style.display = '';

                } else {

                    fila.style.display = 'none';

                }

            });

        }


        document
            .getElementById('buscarClase')
            .addEventListener(
                'keyup',
                function(event) {

                    if (event.key === 'Enter') {

                        buscarClase();

                    }

                }
            );

    </script>


</x-app-layout>