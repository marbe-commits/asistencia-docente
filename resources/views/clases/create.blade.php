<x-app-layout>

    <x-slot name="header">

        <div class="flex items-center justify-between">

            <div>
                <h2 class="text-2xl font-bold text-slate-800">
                    📚 Nueva Clase
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Crear una nueva sesión de clase
                </p>
            </div>

            <a href="{{ route('clases.index') }}"
               class="px-5 py-2.5 bg-gray-600 hover:bg-gray-700 text-white rounded-xl font-semibold transition">
                ← Regresar
            </a>

        </div>

    </x-slot>


    <div class="py-10 bg-slate-50 min-h-screen">

        <div class="max-w-5xl mx-auto px-4">

            @if(session('error'))

                <div class="mb-6 p-4 rounded-xl bg-red-100 border border-red-300 text-red-700">
                    {{ session('error') }}
                </div>

            @endif


            @if($errors->any())

                <div class="mb-6 p-4 rounded-xl bg-red-100 border border-red-300 text-red-700">

                    <ul class="list-disc ml-5">

                        @foreach($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif


            <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-200">

                <!-- ENCABEZADO -->

                <div class="bg-gradient-to-r from-violet-600 via-indigo-600 to-blue-600 px-8 py-7">

                    <div class="flex items-center gap-4">

                        <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center text-3xl">
                            📚
                        </div>

                        <div>

                            <h1 class="text-2xl font-bold text-white">
                                Crear nueva clase
                            </h1>

                            <p class="text-indigo-100 mt-1">
                                Configura la sesión y posteriormente genera su código QR.
                            </p>

                        </div>

                    </div>

                </div>


                <!-- FORMULARIO -->

                <form action="{{ route('clases.store') }}"
                      method="POST"
                      class="p-8">

                    @csrf


                    <!-- HORARIO -->

                    <div class="mb-8">

                        <h3 class="text-lg font-bold text-slate-800 mb-4">
                            🗓️ Selección del horario
                        </h3>

                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Horario asignado
                        </label>

                        <select name="horario_id"
                                id="horario_id"
                                required
                                class="w-full rounded-xl border-gray-300 shadow-sm focus:border-violet-500 focus:ring-violet-500">

                            <option value="">
                                -- Selecciona un horario --
                            </option>

                            @forelse($horarios as $horario)

                                <option value="{{ $horario->id }}"
                                    data-materia="{{ $horario->materia->nombre ?? 'Sin materia' }}"
                                    data-grupo="{{ $horario->grupo->nombre ?? 'Sin grupo' }}"
                                    data-aula="{{ $horario->aula->nombre ?? 'Sin aula' }}"
                                    data-dia="{{ $horario->dia }}"
                                    data-inicio="{{ $horario->hora_inicio }}"
                                    data-fin="{{ $horario->hora_fin }}">

                                    {{ $horario->materia->nombre ?? 'Sin materia' }}
                                    —
                                    {{ $horario->grupo->nombre ?? 'Sin grupo' }}
                                    —
                                    {{ $horario->aula->nombre ?? 'Sin aula' }}
                                    —
                                    {{ $horario->dia }}
                                    —
                                    {{ $horario->hora_inicio }} - {{ $horario->hora_fin }}

                                </option>

                            @empty

                                <option value="">
                                    No tienes horarios disponibles
                                </option>

                            @endforelse

                        </select>

                    </div>


                    <!-- INFORMACIÓN AUTOMÁTICA -->

                    <div id="infoHorario"
                         class="hidden mb-8">

                        <h3 class="text-lg font-bold text-slate-800 mb-4">
                            📋 Información de la clase
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

                            <div class="bg-violet-50 border border-violet-200 rounded-2xl p-5">

                                <div class="text-sm text-violet-600 font-semibold">
                                    Materia
                                </div>

                                <div id="materiaTexto"
                                     class="text-lg font-bold text-slate-800 mt-1">
                                </div>

                            </div>


                            <div class="bg-blue-50 border border-blue-200 rounded-2xl p-5">

                                <div class="text-sm text-blue-600 font-semibold">
                                    Grupo
                                </div>

                                <div id="grupoTexto"
                                     class="text-lg font-bold text-slate-800 mt-1">
                                </div>

                            </div>


                            <div class="bg-emerald-50 border border-emerald-200 rounded-2xl p-5">

                                <div class="text-sm text-emerald-600 font-semibold">
                                    Aula
                                </div>

                                <div id="aulaTexto"
                                     class="text-lg font-bold text-slate-800 mt-1">
                                </div>

                            </div>

                        </div>


                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mt-5">

                            <div class="bg-gray-50 border rounded-2xl p-5">

                                <div class="text-sm text-gray-500 font-semibold">
                                    Día
                                </div>

                                <div id="diaTexto"
                                     class="text-lg font-bold text-slate-800 mt-1">
                                </div>

                            </div>


                            <div class="bg-gray-50 border rounded-2xl p-5">

                                <div class="text-sm text-gray-500 font-semibold">
                                    Horario
                                </div>

                                <div id="horaTexto"
                                     class="text-lg font-bold text-slate-800 mt-1">
                                </div>

                            </div>

                        </div>

                    </div>


                    <!-- FECHA -->

                    <div class="mb-8">

                        <h3 class="text-lg font-bold text-slate-800 mb-4">
                            📅 Fecha de la clase
                        </h3>

                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Fecha
                        </label>

                        <input type="date"
                               name="fecha"
                               value="{{ old('fecha', date('Y-m-d')) }}"
                               required
                               class="w-full rounded-xl border-gray-300 shadow-sm focus:border-violet-500 focus:ring-violet-500">

                        <p class="text-sm text-gray-500 mt-2">
                            Selecciona el día en que se impartirá esta sesión.
                        </p>

                    </div>


                    <!-- BOTONES -->

                    <div class="border-t pt-6 flex flex-col sm:flex-row gap-4">

                        <button type="submit"
                                class="flex-1 bg-gradient-to-r from-violet-600 to-indigo-600 hover:from-violet-700 hover:to-indigo-700 text-white px-6 py-4 rounded-xl font-bold shadow-lg transition">

                            💾 Crear Clase

                        </button>


                        <a href="{{ route('clases.index') }}"
                           class="sm:w-48 text-center bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-4 rounded-xl font-bold transition">

                            Cancelar

                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>


    <!-- JAVASCRIPT -->

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const select = document.getElementById('horario_id');

            const info = document.getElementById('infoHorario');

            const materia = document.getElementById('materiaTexto');
            const grupo = document.getElementById('grupoTexto');
            const aula = document.getElementById('aulaTexto');
            const dia = document.getElementById('diaTexto');
            const hora = document.getElementById('horaTexto');


            function actualizarHorario() {

                const option = select.options[select.selectedIndex];

                if (!option || !option.value) {

                    info.classList.add('hidden');

                    return;
                }


                materia.textContent = option.dataset.materia || 'Sin materia';

                grupo.textContent = option.dataset.grupo || 'Sin grupo';

                aula.textContent = option.dataset.aula || 'Sin aula';

                dia.textContent = option.dataset.dia || 'Sin día';

                hora.textContent =
                    (option.dataset.inicio || '') +
                    ' - ' +
                    (option.dataset.fin || '');


                info.classList.remove('hidden');
            }


            select.addEventListener('change', actualizarHorario);

        });

    </script>

</x-app-layout>
