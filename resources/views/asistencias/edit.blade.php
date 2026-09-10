<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Asistencia
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto">

            <div class="bg-white shadow rounded p-6">

                <form action="{{ route('asistencias.update',$asistencia) }}" method="POST">

                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block mb-2">Clase</label>

                        <select name="clase_id" class="w-full border p-2 rounded">

                            @foreach($clases as $clase)

                                <option value="{{ $clase->id }}"
                                    {{ $asistencia->clase_id == $clase->id ? 'selected' : '' }}>
                                    {{ $clase->fecha }}
                                </option>

                            @endforeach

                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2">Docente</label>

                        <select name="docente_id" class="w-full border p-2 rounded">

                            @foreach($docentes as $docente)

                                <option value="{{ $docente->id }}"
                                    {{ $asistencia->docente_id == $docente->id ? 'selected' : '' }}>
                                    {{ $docente->nombre }}
                                </option>

                            @endforeach

                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2">Estado</label>

                        <select name="estado" class="w-full border p-2 rounded">

                            <option value="Asistencia"
                                {{ $asistencia->estado == 'Asistencia' ? 'selected' : '' }}>
                                Asistencia
                            </option>

                            <option value="Retardo"
                                {{ $asistencia->estado == 'Retardo' ? 'selected' : '' }}>
                                Retardo
                            </option>

                            <option value="Falta"
                                {{ $asistencia->estado == 'Falta' ? 'selected' : '' }}>
                                Falta
                            </option>

                        </select>
                    </div>

                    <button
                        type="submit"
                        class="bg-green-600 text-white px-4 py-2 rounded">

                        Actualizar Asistencia

                    </button>

                    <a href="{{ route('asistencias.index') }}"
                       class="bg-gray-500 text-white px-4 py-2 rounded ml-2">

                        Cancelar

                    </a>

                </form>

            </div>

        </div>
    </div>
</x-app-layout>