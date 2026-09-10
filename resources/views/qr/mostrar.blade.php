<x-app-layout>

    <x-slot name="header">

        <div class="flex justify-between items-center">

            

            <a href="{{ route('clases.index') }}"
               class="bg-gray-600 hover:bg-gray-700 text-white px-5 py-2 rounded-xl">

                ← Regresar

            </a>

        </div>

    </x-slot>

    <div class="py-10">

        <div class="max-w-6xl mx-auto">

            @if(session('success'))

                <div class="mb-6 bg-green-100 border border-green-500 text-green-700 px-6 py-4 rounded-xl">

                    {{ session('success') }}

                </div>

            @endif

            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">

                <div class="bg-gradient-to-r from-indigo-700 to-blue-700 p-6">

                    <h2 class="text-3xl font-bold text-white text-center">

                        SISTEMA DE ASISTENCIA DOCENTE

                    </h2>

                </div>

                <div class="grid md:grid-cols-2">

                    <div class="p-10 space-y-5">

                        <h3 class="text-xl font-bold border-b pb-3">

                            Información de la Clase

                        </h3>

                        <p>

                            <strong>Materia:</strong>

                            {{ $clase->horario->materia->nombre }}

                        </p>

                        <p>

                            <strong>Docente:</strong>

                            {{ $clase->horario->docente->nombre }}

                        </p>

                        <p>

                            <strong>Grupo:</strong>

                            {{ $clase->horario->grupo->nombre }}

                        </p>

                        <p>

                            <strong>Aula:</strong>

                            {{ $clase->horario->aula->nombre }}

                        </p>

                        <p>

                            <strong>Fecha:</strong>

                            {{ $clase->fecha }}

                        </p>

                        <p>

                            <strong>Código:</strong>

                        </p>

                        <div class="bg-slate-100 rounded-lg p-3 font-mono">

                            {{ $codigoQR->codigo }}

                        </div>

                        <div class="mt-6">

                            <p class="text-lg">

                                ⏳ Expira en:

                                <strong id="contador">

                                    02:00

                                </strong>

                            </p>

                        </div>

                        @if($codigoQR->activo)

                            <span class="bg-green-600 text-white px-5 py-2 rounded-full">

                                🟢 ACTIVO

                            </span>

                        @else

                            <span class="bg-red-600 text-white px-5 py-2 rounded-full">

                                🔴 FINALIZADO

                            </span>

                        @endif

                    </div>

                    <div class="flex items-center justify-center p-10">

                        <img
                            src="https://api.qrserver.com/v1/create-qr-code/?size=330x330&data={{ urlencode(route('qr.registrar',$codigoQR->codigo)) }}"
                            class="rounded-xl shadow-2xl border-8 border-white">

                    </div>

                </div>

                <div class="bg-slate-100 p-6 flex justify-center gap-5">

                    <form action="{{ route('qr.actualizar',$codigoQR->id) }}" method="POST">

                        @csrf

                        <button
                            type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-bold">

                            🔄 Actualizar QR

                        </button>

                    </form>


                    <form action="{{ route('qr.finalizar',$codigoQR->id) }}" method="POST">

                        @csrf

                        <button
                            onclick="return confirm('¿Desea finalizar esta clase?')"
                            type="submit"
                            class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl font-bold">

                            🔴 Finalizar Clase

                        </button>

                    </form>

                </div>

                <hr class="my-8">

                <div class="px-8 pb-8">

                    <h2 class="text-2xl font-bold text-slate-800 mb-6">

                        👨‍🎓 Alumnos que han registrado asistencia

                    </h2>

                    <div class="overflow-hidden rounded-2xl shadow-xl">

                        <table class="w-full">

                            <thead class="bg-indigo-700 text-white">

                                <tr>

                                    <th class="p-4 text-left">

                                        Hora

                                    </th>

                                    <th class="p-4 text-left">

                                        Matrícula

                                    </th>

                                    <th class="p-4 text-left">

                                        Alumno

                                    </th>

                                    <th class="p-4 text-center">

                                        Estado

                                    </th>

                                </tr>

                            </thead>

                            <tbody>

                                @forelse($asistencias as $asistencia)

                                    <tr class="border-b hover:bg-gray-100">

                                        <td class="p-4">

                                            {{ \Carbon\Carbon::parse($asistencia->fecha_hora)->format('H:i:s') }}

                                        </td>

                                        <td class="p-4 font-bold">

                                            {{ optional($asistencia->alumno)->matricula }}

                                        </td>

                                        <td class="p-4">

                                            {{ optional($asistencia->alumno)->nombre }}
                                            {{ optional($asistencia->alumno)->apellido_paterno }}
                                            {{ optional($asistencia->alumno)->apellido_materno }}

                                        </td>

                                        <td class="p-4 text-center">

                                            <span class="bg-green-600 text-white px-4 py-2 rounded-full">

                                                ✔ {{ $asistencia->estado }}

                                            </span>

                                        </td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td colspan="4" class="text-center p-10 text-gray-500">

                                            Ningún alumno ha registrado asistencia todavía.

                                        </td>

                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>

<script>

let tiempo = 120;

setInterval(function(){

    let m = Math.floor(tiempo / 60);

    let s = tiempo % 60;

    document.getElementById('contador').innerHTML =
        String(m).padStart(2,'0') + ":" +
        String(s).padStart(2,'0');

    if(tiempo > 0){

        tiempo--;

    }

},1000);

</script>

</x-app-layout>