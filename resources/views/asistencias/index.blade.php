<x-app-layout>

    {{-- ========================================================= --}}
    {{-- HEADER --}}
    {{-- ========================================================= --}}

    <x-slot name="header">

        <div class="flex justify-between items-center">

            <div>

                <h2
                    class="text-3xl font-bold"
                    style="color:#5b21b6;"
                >
                    Control de Asistencias
                </h2>

                <p
                    style="
                        color:#6d28d9;
                        margin-top:4px;
                    "
                >
                    Consulta y administracion de asistencias por profesor y grupo
                </p>

            </div>

        </div>

    </x-slot>


    {{-- ========================================================= --}}
    {{-- CONTENIDO --}}
    {{-- ========================================================= --}}

    <div
        class="py-8"
        style="
            background:#F8F5FF;
            min-height:100vh;
        "
    >

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">


            {{-- ================================================= --}}
            {{-- MENSAJE DE ÉXITO --}}
            {{-- ================================================= --}}

            @if(session('success'))

                <div
                    style="
                        background:#dcfce7;
                        color:#166534;
                        border:1px solid #86efac;
                        padding:15px 20px;
                        border-radius:14px;
                        margin-bottom:20px;
                        font-weight:600;
                    "
                >
                    {{ session('success') }}
                </div>

            @endif


            {{-- ================================================= --}}
            {{-- MENSAJE DE ERROR --}}
            {{-- ================================================= --}}

            @if(session('error'))

                <div
                    style="
                        background:#fee2e2;
                        color:#991b1b;
                        border:1px solid #fca5a5;
                        padding:15px 20px;
                        border-radius:14px;
                        margin-bottom:20px;
                        font-weight:600;
                    "
                >
                    {{ session('error') }}
                </div>

            @endif


            {{-- ================================================= --}}
            {{-- BOTONES --}}
            {{-- ================================================= --}}

            <div class="flex flex-wrap gap-4 mb-6">

                {{-- NUEVA ASISTENCIA --}}

                <a
                    href="{{ route('asistencias.create') }}"
                    style="
                        background:#6d28d9;
                        color:white;
                        padding:12px 20px;
                        border-radius:12px;
                        font-weight:600;
                        text-decoration:none;
                        box-shadow:0 5px 15px rgba(109,40,217,.25);
                    "
                >
                    + Nueva Asistencia
                </a>


                {{-- REPORTE GENERAL --}}

                <a
                    href="{{ route('reportes.asistencias.pdf') }}"
                    style="
                        background:#5b21b6;
                        color:white;
                        padding:12px 20px;
                        border-radius:12px;
                        font-weight:600;
                        text-decoration:none;
                        box-shadow:0 5px 15px rgba(91,33,182,.25);
                    "
                >
                     Descargar reporte general
                </a>


                {{-- REPORTE POR PROFESOR --}}
                {{-- Usa el profesor seleccionado en el filtro --}}

                @if(request('docente_id'))

                    <a
                        href="{{ route('reportes.asistencias.profesor', ['docente_id' => request('docente_id')]) }}"
                        style="
                            background:#7C3AED;
                            color:white;
                            padding:12px 20px;
                            border-radius:12px;
                            font-weight:600;
                            text-decoration:none;
                            box-shadow:0 5px 15px rgba(124,58,237,.25);
                        "
                    >
                         Descargar por profesor
                    </a>

                @else

                    <button
                        type="button"
                        onclick="alert('Primero selecciona un profesor en el filtro de asistencias.')"
                        style="
                            background:#A78BFA;
                            color:white;
                            padding:12px 20px;
                            border-radius:12px;
                            font-weight:600;
                            border:none;
                            cursor:pointer;
                            box-shadow:0 5px 15px rgba(124,58,237,.15);
                        "
                    >
                         Descargar por profesor
                    </button>

                @endif

            </div>


            {{-- ================================================= --}}
            {{-- BUSCADOR --}}
            {{-- ================================================= --}}

            <div
                style="
                    background:#FFFFFF;
                    padding:20px;
                    border-radius:18px;
                    margin-bottom:20px;
                    border:1px solid #DDD6FE;
                    box-shadow:0 8px 20px rgba(109,40,217,.10);
                "
            >

                <form
                    action="{{ route('asistencias.index') }}"
                    method="GET"
                    class="flex flex-col md:flex-row gap-3"
                >

                    {{-- CONSERVAR FILTROS --}}

                    @if(request('docente_id'))

                        <input
                            type="hidden"
                            name="docente_id"
                            value="{{ request('docente_id') }}"
                        >

                    @endif


                    @if(request('grupo_id'))

                        <input
                            type="hidden"
                            name="grupo_id"
                            value="{{ request('grupo_id') }}"
                        >

                    @endif


                    <div class="flex-1 relative">

                        <input
                            type="text"
                            name="buscar"
                            value="{{ request('buscar') }}"
                            placeholder="Buscar asistencia..."
                            style="
                                width:100%;
                                padding:12px 50px 12px 16px;
                                border:2px solid #DDD6FE;
                                border-radius:12px;
                                outline:none;
                                background:#ffffff;
                                color:#374151;
                            "
                        >

                        <span
                            style="
                                position:absolute;
                                right:16px;
                                top:50%;
                                transform:translateY(-50%);
                                font-size:20px;
                                color:#6d28d9;
                            "
                        >
                            &#128269;
                        </span>

                    </div>


                    <button
                        type="submit"
                        style="
                            background:#6d28d9;
                            color:white;
                            padding:12px 25px;
                            border-radius:12px;
                            border:none;
                            font-weight:700;
                            cursor:pointer;
                            box-shadow:0 5px 15px rgba(109,40,217,.25);
                        "
                    >
                        Buscar
                    </button>


                    @if(request('buscar'))

                        <a
                            href="{{ route('asistencias.index') }}"
                            style="
                                background:#EDE9FE;
                                color:#5B21B6;
                                padding:12px 22px;
                                border-radius:12px;
                                font-weight:700;
                                text-decoration:none;
                                display:flex;
                                align-items:center;
                                justify-content:center;
                            "
                        >
                            Limpiar
                        </a>

                    @endif

                </form>

            </div>


            {{-- ================================================= --}}
            {{-- ESTADÍSTICAS --}}
            {{-- ================================================= --}}

            <div class="mb-6 grid md:grid-cols-4 gap-5">


                {{-- ASISTENCIAS --}}

                <div
                    style="
                        background:linear-gradient(
                            135deg,
                            #7C3AED,
                            #6D28D9
                        );
                        color:white;
                        padding:22px;
                        border-radius:18px;
                        box-shadow:0 8px 20px rgba(109,40,217,.20);
                    "
                >

                    <p>
                        Asistencias
                    </p>

                    <h3 class="text-3xl font-bold mt-2">

                        {{ $asistencias->where('estado','Asistencia')->count() }}

                    </h3>

                </div>


                {{-- RETARDOS --}}

                <div
                    style="
                        background:linear-gradient(
                            135deg,
                            #8B5CF6,
                            #7C3AED
                        );
                        color:white;
                        padding:22px;
                        border-radius:18px;
                        box-shadow:0 8px 20px rgba(109,40,217,.20);
                    "
                >

                    <p>
                        Retardos
                    </p>

                    <h3 class="text-3xl font-bold mt-2">

                        {{ $asistencias->where('estado','Retardo')->count() }}

                    </h3>

                </div>


                {{-- FALTAS --}}

                <div
                    style="
                        background:linear-gradient(
                            135deg,
                            #6D28D9,
                            #5B21B6
                        );
                        color:white;
                        padding:22px;
                        border-radius:18px;
                        box-shadow:0 8px 20px rgba(109,40,217,.20);
                    "
                >

                    <p>
                        Faltas
                    </p>

                    <h3 class="text-3xl font-bold mt-2">

                        {{ $asistencias->where('estado','Falta')->count() }}

                    </h3>

                </div>


                {{-- TOTAL --}}

                <div
                    style="
                        background:linear-gradient(
                            135deg,
                            #4C1D95,
                            #3B0764
                        );
                        color:white;
                        padding:22px;
                        border-radius:18px;
                        box-shadow:0 8px 20px rgba(76,29,149,.25);
                    "
                >

                    <p>
                        Total registros
                    </p>

                    <h3 class="text-3xl font-bold mt-2">

                        {{ $asistencias->count() }}

                    </h3>

                </div>

            </div>


            {{-- ================================================= --}}
            {{-- FILTROS --}}
            {{-- ================================================= --}}

            <div
                style="
                    background:white;
                    padding:24px;
                    border-radius:20px;
                    margin-bottom:25px;
                    border:1px solid #DDD6FE;
                    box-shadow:0 10px 25px rgba(109,40,217,.10);
                "
            >

                <div class="mb-5">

                    <h3
                        style="
                            color:#4c1d95;
                            font-size:20px;
                            font-weight:700;
                        "
                    >
                        Filtrar asistencias
                    </h3>

                    <p
                        style="
                            color:#7c3aed;
                            font-size:14px;
                            margin-top:4px;
                        "
                    >
                        Selecciona un profesor, un grupo o ambos.
                    </p>

                </div>


                <form
                    action="{{ route('asistencias.index') }}"
                    method="GET"
                >

                    {{-- CONSERVAR BUSQUEDA --}}

                    @if(request('buscar'))

                        <input
                            type="hidden"
                            name="buscar"
                            value="{{ request('buscar') }}"
                        >

                    @endif


                    <div class="grid md:grid-cols-2 gap-5">


                        {{-- PROFESOR --}}

                        <div>

                            <label
                                for="docente_id"
                                style="
                                    display:block;
                                    color:#4c1d95;
                                    font-weight:700;
                                    margin-bottom:8px;
                                "
                            >
                                Profesor
                            </label>

                            <select
                                id="docente_id"
                                name="docente_id"
                                style="
                                    width:100%;
                                    padding:12px 15px;
                                    border:2px solid #DDD6FE;
                                    border-radius:12px;
                                    background:white;
                                    color:#374151;
                                    outline:none;
                                "
                            >

                                <option value="">
                                    Todos los profesores
                                </option>

                                @foreach($docentes as $docente)

                                    <option
                                        value="{{ $docente->id }}"
                                        {{ request('docente_id') == $docente->id ? 'selected' : '' }}
                                    >

                                        {{ $docente->nombre }}

                                        @if(!empty($docente->apellido_paterno))
                                            {{ $docente->apellido_paterno }}
                                        @endif

                                        @if(!empty($docente->apellido_materno))
                                            {{ $docente->apellido_materno }}
                                        @endif

                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- GRUPO --}}

                        <div>

                            <label
                                for="grupo_id"
                                style="
                                    display:block;
                                    color:#4c1d95;
                                    font-weight:700;
                                    margin-bottom:8px;
                                "
                            >
                                Grupo
                            </label>

                            <select
                                id="grupo_id"
                                name="grupo_id"
                                style="
                                    width:100%;
                                    padding:12px 15px;
                                    border:2px solid #DDD6FE;
                                    border-radius:12px;
                                    background:white;
                                    color:#374151;
                                    outline:none;
                                "
                            >

                                <option value="">
                                    Todos los grupos
                                </option>

                                @foreach($grupos as $grupo)

                                    <option
                                        value="{{ $grupo->id }}"
                                        {{ request('grupo_id') == $grupo->id ? 'selected' : '' }}
                                    >
                                        {{ $grupo->nombre }}
                                    </option>

                                @endforeach

                            </select>

                        </div>

                    </div>


                    <div class="flex flex-wrap gap-3 mt-6">

                        <button
                            type="submit"
                            style="
                                background:#6d28d9;
                                color:white;
                                padding:12px 22px;
                                border-radius:12px;
                                border:none;
                                font-weight:700;
                                cursor:pointer;
                            "
                        >
                            Aplicar filtros
                        </button>


                        <a
                            href="{{ route('asistencias.index') }}"
                            style="
                                background:#EDE9FE;
                                color:#5B21B6;
                                padding:12px 22px;
                                border-radius:12px;
                                font-weight:700;
                                text-decoration:none;
                            "
                        >
                            Limpiar filtros
                        </a>

                    </div>

                </form>

            </div>


            {{-- ================================================= --}}
            {{-- TABLA --}}
            {{-- ================================================= --}}

            <div
                style="
                    background:white;
                    border-radius:20px;
                    overflow:hidden;
                    box-shadow:0 10px 25px rgba(109,40,217,.12);
                "
            >

                <div
                    style="
                        padding:20px;
                        background:linear-gradient(
                            135deg,
                            #7c3aed,
                            #5b21b6
                        );
                    "
                >

                    <h3
                        style="
                            font-size:21px;
                            font-weight:bold;
                            color:white;
                        "
                    >
                        Registro de Asistencias
                    </h3>

                    <p
                        style="
                            color:#EDE9FE;
                            margin-top:4px;
                            font-size:14px;
                        "
                    >
                        {{ count($asistencias) }} registros encontrados
                    </p>

                </div>


                <div style="overflow-x:auto;">

                    <table
                        class="w-full"
                        style="min-width:1000px;"
                    >

                        <thead
                            style="
                                background:#6d28d9;
                                color:white;
                            "
                        >

                            <tr>

                                <th class="p-4 text-left">Alumno</th>

                                <th class="p-4 text-left">Grupo</th>

                                <th class="p-4 text-left">Profesor</th>

                                <th class="p-4 text-left">Materia</th>

                                <th class="p-4 text-left">Fecha / Hora</th>

                                <th class="p-4 text-left">Estado</th>

                                <th class="p-4 text-left">Ubicacion</th>

                                <th class="p-4 text-center">Acciones</th>

                            </tr>

                        </thead>


                        <tbody>

                        @forelse($asistencias as $asistencia)

                            <tr
                                style="
                                    border-bottom:1px solid #E9D5FF;
                                    transition:.2s;
                                "
                                onmouseover="this.style.background='#F5F3FF'"
                                onmouseout="this.style.background='#FFFFFF'"
                            >

                                {{-- ALUMNO --}}

                                <td
                                    class="p-4"
                                    style="
                                        color:#4C1D95;
                                        font-weight:700;
                                    "
                                >

                                    @if($asistencia->alumno)

                                        {{ $asistencia->alumno->nombre }}
                                        {{ $asistencia->alumno->apellido_paterno }}
                                        {{ $asistencia->alumno->apellido_materno }}

                                    @else

                                        <span style="color:#9CA3AF;">
                                            Alumno no identificado
                                        </span>

                                    @endif

                                </td>


                                {{-- GRUPO --}}

                                <td class="p-4">

                                    @if(
                                        $asistencia->clase &&
                                        $asistencia->clase->horario &&
                                        $asistencia->clase->horario->grupo
                                    )

                                        <span
                                            style="
                                                background:#EDE9FE;
                                                color:#5B21B6;
                                                padding:6px 12px;
                                                border-radius:999px;
                                                font-size:13px;
                                                font-weight:700;
                                            "
                                        >
                                            {{ $asistencia->clase->horario->grupo->nombre }}
                                        </span>

                                    @else

                                        <span style="color:#9CA3AF;">
                                            Sin grupo
                                        </span>

                                    @endif

                                </td>


                                {{-- PROFESOR --}}

                                <td class="p-4">

                                    @if($asistencia->docente)

                                        {{ $asistencia->docente->nombre }}

                                        @if(!empty($asistencia->docente->apellido_paterno))
                                            {{ $asistencia->docente->apellido_paterno }}
                                        @endif

                                        @if(!empty($asistencia->docente->apellido_materno))
                                            {{ $asistencia->docente->apellido_materno }}
                                        @endif

                                    @elseif(
                                        $asistencia->clase &&
                                        $asistencia->clase->horario &&
                                        $asistencia->clase->horario->docente
                                    )

                                        {{ $asistencia->clase->horario->docente->nombre }}

                                    @else

                                        <span style="color:#9CA3AF;">
                                            Sin profesor
                                        </span>

                                    @endif

                                </td>


                                {{-- MATERIA --}}

                                <td class="p-4">

                                    @if(
                                        $asistencia->clase &&
                                        $asistencia->clase->horario &&
                                        $asistencia->clase->horario->materia
                                    )

                                        {{ $asistencia->clase->horario->materia->nombre }}

                                    @else

                                        <span style="color:#9CA3AF;">
                                            Sin materia
                                        </span>

                                    @endif

                                </td>


                                {{-- FECHA --}}

                                <td
                                    class="p-4"
                                    style="
                                        color:#374151;
                                        white-space:nowrap;
                                    "
                                >
                                    {{ $asistencia->fecha_hora }}
                                </td>


                                {{-- ESTADO --}}

                                <td class="p-4">

                                    @if($asistencia->estado == 'Asistencia')

                                        <span
                                            style="
                                                background:#DCFCE7;
                                                color:#166534;
                                                padding:6px 12px;
                                                border-radius:999px;
                                                font-weight:700;
                                                font-size:13px;
                                            "
                                        >
                                            Asistencia
                                        </span>

                                    @elseif($asistencia->estado == 'Retardo')

                                        <span
                                            style="
                                                background:#FEF3C7;
                                                color:#92400E;
                                                padding:6px 12px;
                                                border-radius:999px;
                                                font-weight:700;
                                                font-size:13px;
                                            "
                                        >
                                            Retardo
                                        </span>

                                    @else

                                        <span
                                            style="
                                                background:#FEE2E2;
                                                color:#991B1B;
                                                padding:6px 12px;
                                                border-radius:999px;
                                                font-weight:700;
                                                font-size:13px;
                                            "
                                        >
                                            Falta
                                        </span>

                                    @endif

                                </td>


                                {{-- UBICACION --}}

                                <td
                                    class="p-4"
                                    style="
                                        color:#6B7280;
                                        font-size:13px;
                                    "
                                >

                                    <div>
                                        Lat:
                                        {{ $asistencia->latitud }}
                                    </div>

                                    <div>
                                        Lon:
                                        {{ $asistencia->longitud }}
                                    </div>

                                </td>


                                {{-- ACCIONES --}}

                                <td class="p-4 text-center">

                                    <div class="flex justify-center gap-2">

                                        <a
                                            href="{{ route('asistencias.edit', $asistencia) }}"
                                            style="
                                                background:#8B5CF6;
                                                color:white;
                                                padding:8px 14px;
                                                border-radius:10px;
                                                text-decoration:none;
                                                font-weight:600;
                                            "
                                        >
                                            Editar
                                        </a>


                                        <form
                                            action="{{ route('asistencias.destroy', $asistencia) }}"
                                            method="POST"
                                        >

                                            @csrf

                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                onclick="return confirm('Eliminar registro de asistencia')"
                                                style="
                                                    background:#DC2626;
                                                    color:white;
                                                    padding:8px 14px;
                                                    border-radius:10px;
                                                    border:none;
                                                    font-weight:600;
                                                    cursor:pointer;
                                                "
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
                                    colspan="8"
                                    style="
                                        text-align:center;
                                        padding:60px 20px;
                                        color:#7C3AED;
                                        font-weight:bold;
                                    "
                                >

                                    No hay asistencias que coincidan con los filtros.

                                </td>

                            </tr>

                        @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>