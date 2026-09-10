<!DOCTYPE html>
<html lang="es">
<head>

    <meta charset="UTF-8">

    <title>Reporte General de Asistencias</title>

    <style>

        body{
            font-family: Arial, Helvetica, sans-serif;
            font-size:12px;
        }

        h1{
            text-align:center;
            color:#4C1D95;
            margin-bottom:5px;
        }

        h3{
            text-align:center;
            color:#6D28D9;
            margin-bottom:20px;
        }

        table{
            width:100%;
            border-collapse:collapse;
        }

        th{
            background:#7C3AED;
            color:white;
            padding:8px;
            border:1px solid #000;
        }

        td{
            border:1px solid #000;
            padding:8px;
        }

    </style>

</head>

<body>

<h1>
Sistema de Control de Asistencia Estudiantil mediante Validación QR y Geolocalización
</h1>

<h3>
Universidad Politécnica de Texcoco
</h3>

<table>

    <thead>

        <tr>

            <th>ID</th>

            <th>Matrícula</th>

            <th>Alumno</th>

            <th>Materia</th>

            <th>Grupo</th>

            <th>Fecha / Hora</th>

            <th>Estado</th>

        </tr>

    </thead>

    <tbody>

    @foreach($asistencias as $asistencia)

        <tr>

            <td>{{ $asistencia->id }}</td>

            <td>
                {{ optional($asistencia->alumno)->matricula }}
            </td>

            <td>
                {{ optional($asistencia->alumno)->nombre }}
                {{ optional($asistencia->alumno)->apellido_paterno }}
                {{ optional($asistencia->alumno)->apellido_materno }}
            </td>

            <td>
                {{ optional($asistencia->clase->horario->materia)->nombre }}
            </td>

            <td>
                {{ optional($asistencia->clase->horario->grupo)->nombre }}
            </td>

            <td>
                {{ \Carbon\Carbon::parse($asistencia->fecha_hora)->format('d/m/Y H:i') }}
            </td>

            <td>
                {{ $asistencia->estado }}
            </td>

        </tr>

    @endforeach

    </tbody>

</table>

</body>
</html>