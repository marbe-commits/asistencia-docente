<x-app-layout>

    <x-slot name="header">

        <div class="flex justify-between items-center">

            <div>

                <h2 class="text-3xl font-bold" style="color:#5b21b6;">
                    Gestión de Horarios
                </h2>

                <p style="color:#6d28d9; margin-top:4px;">
                    Planeación académica y asignación de clases
                </p>

            </div>

            <a href="{{ route('horarios.create') }}"
               style="
                    background:#6d28d9;
                    color:#ffffff;
                    padding:12px 20px;
                    border-radius:12px;
                    font-weight:600;
                    text-decoration:none;
                    box-shadow:0 10px 15px rgba(109,40,217,0.25);
               ">

                + Nuevo Horario

            </a>

        </div>

    </x-slot>


    <div class="py-8">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">


            <!-- ========================================= -->
            <!-- BUSCADOR -->
            <!-- ========================================= -->

            <div style="
                background:#ffffff;
                border-radius:16px;
                padding:20px;
                margin-bottom:24px;
                box-shadow:0 8px 20px rgba(109,40,217,0.12);
                display:flex;
                gap:12px;
                align-items:center;
            ">

                <input
                    type="text"
                    id="buscarHorario"
                    placeholder="Buscar horario..."
                    style="
                        flex:1;
                        padding:12px 15px;
                        border:1px solid #c4b5fd;
                        border-radius:12px;
                        outline:none;
                        color:#374151;
                        background:#ffffff;
                    "
                >

                <button
                    type="button"
                    onclick="buscarHorario()"
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


            <!-- ========================================= -->
            <!-- ESTADÍSTICAS -->
            <!-- ========================================= -->

            <div class="mb-6 grid md:grid-cols-3 gap-5">


                <!-- TOTAL HORARIOS -->

                <div style="
                    background:#6d28d9;
                    color:white;
                    padding:20px;
                    border-radius:16px;
                    box-shadow:0 10px 20px rgba(109,40,217,0.25);
                ">

                    <p>
                        Total Horarios
                    </p>

                    <h3 class="text-3xl font-bold mt-2">

                        {{ count($horarios) }}

                    </h3>

                </div>


                <!-- CLASES PROGRAMADAS -->

                <div style="
                    background:#5b21b6;
                    color:white;
                    padding:20px;
                    border-radius:16px;
                    box-shadow:0 10px 20px rgba(91,33,182,0.25);
                ">

                    <p>
                        Clases Programadas
                    </p>

                    <h3 class="text-3xl font-bold mt-2">

                        {{ count($horarios) }}

                    </h3>

                </div>


                <!-- ESTADO ACADÉMICO -->

                <div style="
                    background:#7c3aed;
                    color:white;
                    padding:20px;
                    border-radius:16px;
                    box-shadow:0 10px 20px rgba(124,58,237,0.25);
                ">

                    <p>
                        Estado Académico
                    </p>

                    <h3 class="text-2xl font-bold mt-2">

                        Activo

                    </h3>

                </div>


            </div>


            <!-- ========================================= -->
            <!-- TABLA -->
            <!-- ========================================= -->

            <div style="
                background:#ffffff;
                border-radius:18px;
                overflow:hidden;
                box-shadow:0 10px 25px rgba(0,0,0,0.10);
                border:1px solid #DDD6FE;
            ">


                <div style="
                    padding:20px;
                    border-bottom:2px solid #7C3AED;
                ">

                    <h3 style="
                        font-size:20px;
                        font-weight:bold;
                        color:#5B21B6;
                    ">

                        Horarios Programados

                    </h3>

                </div>


                <div style="overflow-x:auto;">

                    <table class="w-full">

                        <thead style="
                            background:#7C3AED;
                            color:#ffffff;
                        ">

                            <tr>

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
                                    Aula
                                </th>

                                <th class="p-4 text-left">
                                    Día
                                </th>

                                <th class="p-4 text-left">
                                    Horario
                                </th>

                                <th class="p-4 text-center">
                                    Acciones
                                </th>

                            </tr>

                        </thead>


                        <tbody id="tablaHorarios">


                            @forelse($horarios as $horario)

                            <tr
                                class="fila-horario"
                                style="
                                    border-bottom:1px solid #ddd6fe;
                                    transition:0.2s;
                                    color:#1f2937;
                                "
                                onmouseover="this.style.background='#ede9fe'"
                                onmouseout="this.style.background='white'"
                            >


                                <!-- DOCENTE -->

                                <td class="p-4 font-semibold">

                                    {{ $horario->docente->nombre }}

                                </td>


                                <!-- MATERIA -->

                                <td class="p-4">

                                    {{ $horario->materia->nombre }}

                                </td>


                                <!-- GRUPO -->

                                <td class="p-4">

                                    <span style="
                                        background:#7c3aed;
                                        color:white;
                                        padding:4px 10px;
                                        border-radius:9999px;
                                    ">

                                        {{ $horario->grupo->nombre }}

                                    </span>

                                </td>


                                <!-- AULA -->

                                <td class="p-4">

                                    {{ $horario->aula->nombre }}

                                </td>


                                <!-- DÍA -->

                                <td class="p-4">

                                    <span style="
                                        background:#6d28d9;
                                        color:white;
                                        padding:4px 10px;
                                        border-radius:9999px;
                                    ">

                                        {{ $horario->dia }}

                                    </span>

                                </td>


                                <!-- HORARIO -->

                                <td class="p-4">

                                    <span style="
                                        background:#5b21b6;
                                        color:white;
                                        padding:4px 10px;
                                        border-radius:9999px;
                                    ">

                                        {{ $horario->hora_inicio }}
                                        -
                                        {{ $horario->hora_fin }}

                                    </span>

                                </td>


                                <!-- ACCIONES -->

                                <td class="p-4 text-center">

                                    <div class="flex justify-center gap-3">


                                        <!-- EDITAR -->

                                        <a
                                            href="{{ route('horarios.edit',$horario) }}"
                                            style="
                                                background:#7c3aed;
                                                color:white;
                                                padding:8px 14px;
                                                border-radius:10px;
                                                text-decoration:none;
                                                font-weight:600;
                                                transition:0.3s;
                                            "
                                            onmouseover="this.style.background='#6d28d9'"
                                            onmouseout="this.style.background='#7c3aed'"
                                        >

                                            Editar

                                        </a>


                                        <!-- ELIMINAR -->

                                        <form
                                            action="{{ route('horarios.destroy',$horario) }}"
                                            method="POST"
                                        >

                                            @csrf

                                            @method('DELETE')


                                            <button
                                                type="submit"
                                                onclick="return confirm('Eliminar horario')"
                                                style="
                                                    background:#5b21b6;
                                                    color:white;
                                                    padding:8px 14px;
                                                    border-radius:10px;
                                                    border:none;
                                                    cursor:pointer;
                                                    font-weight:600;
                                                    transition:0.3s;
                                                "
                                                onmouseover="this.style.background='#4c1d95'"
                                                onmouseout="this.style.background='#5b21b6'"
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
                                    colspan="7"
                                    style="
                                        text-align:center;
                                        padding:40px;
                                        color:#6d28d9;
                                    "
                                >

                                    No hay horarios registrados

                                </td>

                            </tr>

                            @endforelse


                        </tbody>

                    </table>

                </div>

            </div>


        </div>

    </div>


    <!-- ========================================= -->
    <!-- BUSQUEDA -->
    <!-- ========================================= -->

    <script>

        function buscarHorario() {

            let texto =
                document
                .getElementById('buscarHorario')
                .value
                .toLowerCase()
                .trim();

            let filas =
                document.querySelectorAll('.fila-horario');


            filas.forEach(function(fila) {

                let contenido =
                    fila.textContent.toLowerCase();


                if (contenido.includes(texto)) {

                    fila.style.display = '';

                } else {

                    fila.style.display = 'none';

                }

            });

        }


        document
        .getElementById('buscarHorario')
        .addEventListener('keyup', function(event) {

            if (event.key === 'Enter') {

                buscarHorario();

            }

        });

    </script>


</x-app-layout>