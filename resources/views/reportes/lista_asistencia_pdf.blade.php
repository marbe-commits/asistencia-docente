<!DOCTYPE html>

<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>
        Lista de Asistencia
    </title>

    <style>

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            color: #1f2937;
        }

        .encabezado {
            text-align: center;
            margin-bottom: 20px;
        }

        .universidad {
            font-size: 18px;
            font-weight: bold;
            color: #5b21b6;
        }

        .titulo {
            font-size: 15px;
            font-weight: bold;
            margin-top: 8px;
            color: #6d28d9;
        }

        .informacion {
            width: 100%;
            margin-bottom: 20px;
        }

        .informacion td {
            padding: 5px;
        }

        .label {
            font-weight: bold;
            color: #5b21b6;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #6d28d9;
            color: white;
            padding: 8px;
            text-align: left;
        }

        td {
            border: 1px solid #ddd6fe;
            padding: 7px;
        }

        tr:nth-child(even) {
            background: #f5f3ff;
        }

        .asistencia {
            color: #166534;
            font-weight: bold;
        }

        .retardo {
            color: #92400e;
            font-weight: bold;
        }

        .falta {
            color: #991b1b;
            font-weight: bold;
        }

        .estadisticas {
            margin-top: 20px;
        }

        .estadisticas td {
            text-align: center;
            font-weight: bold;
        }

        .footer {
            margin-top: 25px;
            text-align: center;
            color: #6b7280;
            font-size: 9px;
        }

    </style>

</head>


<body>


    {{-- ENCABEZADO --}}

    <div class="encabezado">

        <div class="universidad">
            UNIVERSIDAD POLITÉCNICA DE TEXCOCO
        </div>

        <div class="titulo">
            LISTA DE ASISTENCIA
        </div>

    </div>


    {{-- INFORMACIÓN --}}

    <table class="informacion">

        <tr>

            <td>

                <span class="label">
                    Docente:
                </span>

                {{ optional($clase->horario->docente)->nombre }}

            </td>


            <td>

                <span class="label">
                    Materia:
                </span>

                {{ optional($clase->horario->materia)->nombre }}

            </td>

        </tr>


        <tr>

            <td>

                <span class="label">
                    Grupo:
                </span>

                {{ optional($clase->horario->grupo)->nombre }}

            </td>


            <td>

                <span class="label">
                    Periodo:
                </span>

                {{ \Carbon\Carbon::parse($fechaInicio)->format('d/m/Y') }}

                -

                {{ \Carbon\Carbon::parse($fechaFin)->format('d/m/Y') }}

            </td>

        </tr>

    </table>


    {{-- TABLA --}}

    <table>

        <thead>

            <tr>

                <th>
                    #
                </th>

                <th>
                    Matrícula
                </th>

                <th>
                    Alumno
                </th>

                <th>
                    Fecha
                </th>

                <th>
                    Hora
                </th>

                <th>
                    Estado
                </th>

            </tr>

        </thead>


        <tbody>

        @forelse($asistencias as $index => $asistencia)

            <tr>

                <td>
                    {{ $index + 1 }}
                </td>


                <td>
                    {{ optional($asistencia->alumno)->matricula }}
                </td>


                <td>

                    {{ optional($asistencia->alumno)->nombre }}

                    {{ optional($asistencia->alumno)->apellido_paterno }}

                    {{ optional($asistencia->alumno)->apellido_materno }}

                </td>


                <td>

                    {{ \Carbon\Carbon::parse($asistencia->fecha_hora)->format('d/m/Y') }}

                </td>


                <td>

                    {{ \Carbon\Carbon::parse($asistencia->fecha_hora)->format('H:i') }}

                </td>


                <td>

                    @if($asistencia->estado === 'Asistencia')

                        <span class="asistencia">
                            ASISTENCIA
                        </span>

                    @elseif($asistencia->estado === 'Retardo')

                        <span class="retardo">
                            RETARDO
                        </span>

                    @else

                        <span class="falta">
                            FALTA
                        </span>

                    @endif

                </td>

            </tr>


        @empty

            <tr>

                <td
                    colspan="6"
                    style="text-align:center;"
                >
                    No existen registros de asistencia
                    para el periodo seleccionado.
                </td>

            </tr>

        @endforelse

        </tbody>

    </table>


    {{-- ESTADÍSTICAS --}}

    <table class="estadisticas">

        <tr>

            <td>

                Asistencias

                <br>

                {{ $asistencias->where('estado', 'Asistencia')->count() }}

            </td>


            <td>

                Retardos

                <br>

                {{ $asistencias->where('estado', 'Retardo')->count() }}

            </td>


            <td>

                Faltas

                <br>

                {{ $asistencias->where('estado', 'Falta')->count() }}

            </td>


            <td>

                Total

                <br>

                {{ $asistencias->count() }}

            </td>

        </tr>

    </table>


    <div class="footer">

        Reporte generado por el sistema de asistencia

    </div>


</body>

</html>