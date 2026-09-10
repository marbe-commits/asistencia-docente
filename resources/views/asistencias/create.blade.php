<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-slate-800">
             Nueva Asistencia
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto">

            <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">

                <div class="p-6" style="background: linear-gradient(to right, #7C3AED, #5B21B6);">

                    <h3 class="text-2xl font-bold text-white">
                        Información de Asistencia
                    </h3>
                    <p class="mt-1" style="color:#E9D5FF;">
                        Registre el estatus de presencia del docente para la sesión seleccionada.
                    </p>
                </div>

                <div class="p-8">
                    <form action="{{ route('asistencias.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Clase / Fecha
                                </label>
                                <select name="clase_id" 
                                        class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                    @foreach($clases as $clase)
                                        <option value="{{ $clase->id }}">
                                            📆 {{ $clase->fecha }} 
                                            @if($clase->horario && $clase->horario->materia)
                                                - {{ $clase->horario->materia->nombre }}
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Docente
                                </label>
                                <select name="docente_id" 
                                        class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                    @foreach($docentes as $docente)
                                        <option value="{{ $docente->id }}">
                                            👨‍🏫 {{ $docente->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                        <hr class="border-gray-200 my-6">

                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Estado
                            </label>
                            <select name="estado" 
                                    class="w-full md:w-1/2 rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                <option value="Asistencia">✅ Asistencia</option>
                                <option value="Retardo">⏳ Retardo</option>
                                <option value="Falta">❌ Falta</option>
                            </select>
                        </div>

                        <div class="mt-10 flex gap-4">
                            <button type="submit"
                                    class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl font-bold shadow-lg transition duration-200">
                                Guardar Asistencia
                            </button>

                            <a href="{{ route('asistencias.index') }}"
                               class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-xl font-bold shadow-lg transition duration-200">
                                Cancelar
                            </a>
                        </div>

                    </form>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>