<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Horario
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto">

            <div class="bg-white shadow rounded p-6">

                <form action="{{ route('horarios.update', $horario) }}" method="POST">

                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block mb-2">Docente</label>

                        <select name="docente_id" class="w-full border p-2 rounded">
                            @foreach($docentes as $docente)
                                <option value="{{ $docente->id }}"
                                    {{ $horario->docente_id == $docente->id ? 'selected' : '' }}>
                                    {{ $docente->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2">Materia</label>

                        <select name="materia_id" class="w-full border p-2 rounded">
                            @foreach($materias as $materia)
                                <option value="{{ $materia->id }}"
                                    {{ $horario->materia_id == $materia->id ? 'selected' : '' }}>
                                    {{ $materia->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2">Grupo</label>

                        <select name="grupo_id" class="w-full border p-2 rounded">
                            @foreach($grupos as $grupo)
                                <option value="{{ $grupo->id }}"
                                    {{ $horario->grupo_id == $grupo->id ? 'selected' : '' }}>
                                    {{ $grupo->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2">Aula</label>

                        <select name="aula_id" class="w-full border p-2 rounded">
                            @foreach($aulas as $aula)
                                <option value="{{ $aula->id }}"
                                    {{ $horario->aula_id == $aula->id ? 'selected' : '' }}>
                                    {{ $aula->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2">Día</label>

                        <select name="dia" class="w-full border p-2 rounded">

                            <option value="Lunes"
                                {{ $horario->dia == 'Lunes' ? 'selected' : '' }}>
                                Lunes
                            </option>

                            <option value="Martes"
                                {{ $horario->dia == 'Martes' ? 'selected' : '' }}>
                                Martes
                            </option>

                            <option value="Miercoles"
                                {{ $horario->dia == 'Miercoles' ? 'selected' : '' }}>
                                Miércoles
                            </option>

                            <option value="Jueves"
                                {{ $horario->dia == 'Jueves' ? 'selected' : '' }}>
                                Jueves
                            </option>

                            <option value="Viernes"
                                {{ $horario->dia == 'Viernes' ? 'selected' : '' }}>
                                Viernes
                            </option>

                            <option value="Sabado"
                                {{ $horario->dia == 'Sabado' ? 'selected' : '' }}>
                                Sábado
                            </option>

                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2">Hora Inicio</label>

                        <input
                            type="time"
                            name="hora_inicio"
                            value="{{ $horario->hora_inicio }}"
                            class="w-full border p-2 rounded">
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2">Hora Fin</label>

                        <input
                            type="time"
                            name="hora_fin"
                            value="{{ $horario->hora_fin }}"
                            class="w-full border p-2 rounded">
                    </div>

                    <button
                        type="submit"
                        class="bg-green-600 text-white px-4 py-2 rounded">
                        Actualizar Horario
                    </button>

                    <a href="{{ route('horarios.index') }}"
                       class="bg-gray-500 text-white px-4 py-2 rounded ml-2">
                        Cancelar
                    </a>

                </form>

            </div>

        </div>
    </div>
</x-app-layout>