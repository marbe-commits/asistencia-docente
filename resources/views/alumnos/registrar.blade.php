<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registrar Asistencia</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .card {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            max-width: 360px;
            width: 90%;
            text-align: center;
        }
        h2 {
            margin-top: 0;
            color: #1f2937;
        }
        .status {
            font-size: 14px;
            color: #6b7280;
            margin-bottom: 20px;
        }
        input[type="text"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 16px;
            text-align: center;
        }
        button {
            width: 100%;
            padding: 12px;
            background-color: #2563eb;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }
        button:disabled {
            background-color: #9ca3af;
            cursor: not-allowed;
        }
    </style>
</head>

<body>

    <div class="card">
        <h2>Registrar Asistencia</h2>

        <p id="mensaje" class="status">Obteniendo ubicación...</p>

        <form id="formulario" action="{{ route('alumnos.registrar') }}" method="POST">
            @csrf
            <input type="hidden" name="codigo" value="{{ $qr->codigo }}">
            <input type="hidden" id="latitud" name="latitud">
            <input type="hidden" id="longitud" name="longitud">

            <input type="text" 
                   name="matricula" 
                   id="matricula" 
                   placeholder="Ingresa tu matrícula" 
                   required>

            <button type="submit" id="btnGuardar" disabled>Registrar Asistencia</button>
        </form>
    </div>

    <script>
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function(posicion) {
                document.getElementById('latitud').value = posicion.coords.latitude;
                document.getElementById('longitud').value = posicion.coords.longitude;

                document.getElementById('mensaje').innerHTML = "📍 Ubicación obtenida correctamente.";
                document.getElementById('mensaje').style.color = "#16a34a"; // Texto verde
                
                // Habilitar botón de envío una vez que tenemos la localización
                document.getElementById('btnGuardar').disabled = false;
            },
            function(error) {
                document.getElementById('mensaje').innerHTML = "❌ No fue posible obtener la ubicación. Activa el GPS de tu dispositivo.";
                document.getElementById('mensaje').style.color = "#dc2626"; // Texto rojo
            },
            {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 0
            }
        );
    } else {
        document.getElementById('mensaje').innerHTML = "Este dispositivo no soporta geolocalización.";
    }
    </script>

</body>
</html>