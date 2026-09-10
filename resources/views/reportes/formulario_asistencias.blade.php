<x-app-layout>

    <x-slot name="header">

        <div>

            <h2
                class="text-3xl font-bold"
                style="color:#5b21b6;"
            >
                📋 Lista de Asistencia
            </h2>

            <p
                style="
                    color:#6d28d9;
                    margin-top:5px;
                "
            >
                Genera la lista de asistencia de esta clase por rango de fechas
            </p>

        </div>

    </x-slot>


    <div class="py-8">

        <div
            class="max-w-5xl mx-auto sm:px-6 lg:px-8"
        >


            {{-- INFORMACIÓN DE LA CLASE --}}

            <div
                style="
                    background:#ffffff;
                    border-radius:20px;
                    padding:25px;
                    margin-bottom:25px;
                    box-shadow:0 10px 25px rgba(91,33,182,.15);
                    border:1px solid #ddd6fe;
                "
            >

                <h3
                    style="
                        color:#5b21b6;
                        font-size:22px;
                        font-weight:bold;
                        margin-bottom:20px;
                    "
                >
                    Información de la clase
                </h3>


                <div
                    class="grid md:grid-cols-2 gap-5"
                >

                    {{-- DOCENTE --}}

                    <div>

                        <p
                            style="
                                color:#6b7280;
                                font-size:14px;
                            "
                        >
                            Docente
                        </p>

                        <p
                            style="
                                color:#111827;
                                font-size:18px;
                                font-weight:700;
                            "
                        >
                            {{ optional($clase->horario->docente)->nombre }}
                        </p>

                    </div>


                    {{-- MATERIA --}}

                    <div>

                        <p
                            style="
                                color:#6b7280;
                                font-size:14px;
                            "
                        >
                            Materia
                        </p>

                        <p
                            style="
                                color:#111827;
                                font-size:18px;
                                font-weight:700;
                            "
                        >
                            {{ optional($clase->horario->materia)->nombre }}
                        </p>

                    </div>


                    {{-- GRUPO --}}

                    <div>

                        <p
                            style="
                                color:#6b7280;
                                font-size:14px;
                            "
                        >
                            Grupo
                        </p>

                        <span
                            style="
                                display:inline-block;
                                background:#ede9fe;
                                color:#6d28d9;
                                padding:7px 15px;
                                border-radius:999px;
                                font-weight:700;
                            "
                        >
                            {{ optional($clase->horario->grupo)->nombre }}
                        </span>

                    </div>


                    {{-- FECHA DE CLASE --}}

                    <div>

                        <p
                            style="
                                color:#6b7280;
                                font-size:14px;
                            "
                        >
                            Fecha de clase
                        </p>

                        <p
                            style="
                                color:#111827;
                                font-size:18px;
                                font-weight:700;
                            "
                        >
                            {{ \Carbon\Carbon::parse($clase->fecha)->format('d/m/Y') }}
                        </p>

                    </div>

                </div>

            </div>


            {{-- FORMULARIO --}}

            <div
                style="
                    background:#F5F3FF;
                    border:1px solid #C4B5FD;
                    border-radius:20px;
                    padding:30px;
                    box-shadow:0 10px 25px rgba(91,33,182,.10);
                "
            >

                <h3
                    style="
                        color:#5b21b6;
                        font-size:22px;
                        font-weight:bold;
                        margin-bottom:8px;
                    "
                >
                    Seleccionar periodo
                </h3>


                <p
                    style="
                        color:#6b7280;
                        margin-bottom:25px;
                    "
                >
                    Selecciona el periodo que deseas incluir en el reporte.
                </p>


                <form
                    method="GET"
                    action="{{ route('reportes.asistencias.descargar', $clase->id) }}"
                >

                    <div
                        class="grid md:grid-cols-2 gap-6"
                    >

                        {{-- FECHA INICIAL --}}

                        <div>

                            <label
                                style="
                                    display:block;
                                    color:#4c1d95;
                                    font-weight:700;
                                    margin-bottom:8px;
                                "
                            >
                                Fecha inicial
                            </label>

                            <input
                                type="date"
                                name="fecha_inicio"
                                value="{{ $clase->fecha }}"
                                required
                                style="
                                    width:100%;
                                    padding:12px 14px;
                                    border:2px solid #c4b5fd;
                                    border-radius:12px;
                                    background:#ffffff;
                                    color:#374151;
                                "
                            >

                        </div>


                        {{-- FECHA FINAL --}}

                        <div>

                            <label
                                style="
                                    display:block;
                                    color:#4c1d95;
                                    font-weight:700;
                                    margin-bottom:8px;
                                "
                            >
                                Fecha final
                            </label>

                            <input
                                type="date"
                                name="fecha_fin"
                                value="{{ $clase->fecha }}"
                                required
                                style="
                                    width:100%;
                                    padding:12px 14px;
                                    border:2px solid #c4b5fd;
                                    border-radius:12px;
                                    background:#ffffff;
                                    color:#374151;
                                "
                            >

                        </div>

                    </div>


                    {{-- BOTONES --}}

                    <div
                        class="flex justify-end gap-4 mt-8"
                    >

                        <a
                            href="{{ route('clases.index') }}"
                            style="
                                background:#e5e7eb;
                                color:#374151;
                                padding:12px 22px;
                                border-radius:12px;
                                font-weight:600;
                                text-decoration:none;
                            "
                        >
                            ← Regresar
                        </a>


                        <button
                            type="submit"
                            style="
                                background:#6d28d9;
                                color:#ffffff;
                                padding:12px 22px;
                                border-radius:12px;
                                font-weight:700;
                                border:none;
                                cursor:pointer;
                                box-shadow:0 8px 15px rgba(109,40,217,.25);
                            "
                        >
                            📄 Descargar PDF
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>