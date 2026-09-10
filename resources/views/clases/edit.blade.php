<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Clase
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto">

            <div class="bg-white shadow rounded p-6">

                <form action="{{ route('clases.update',$clase) }}" method="POST">

                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block mb-2">Horario</label>

                        <select name="horario_id"
                                class="w-full border p-2 rounded">

                            @foreach($horarios as $horario)

                                <option value="{{ $horario->id }}"
                                {{ $clase->horario_id == $horario->id ? 'selected' : '' }}>

                                    {{ $horario->docente->nombre }}
                                    -
                                    {{ $horario->materia->nombre }}
                                    -
                                    {{ $horario->grupo->nombre }}
                                    -
                                    {{ $horario->dia }}

                                </option>

                            @endforeach

                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2">Fecha</label>

                        <input
                            type="date"
                            name="fecha"
                            value="{{ $clase->fecha }}"
                            class="w-full border p-2 rounded"
                            required>
                    </div>

                    <button
                        type="submit"
                        class="bg-green-600 text-white px-4 py-2 rounded">

                        Actualizar Clase

                    </button>

                    <a href="{{ route('clases.index') }}"
                       class="bg-gray-500 text-white px-4 py-2 rounded ml-2">

                        Cancelar

                    </a>

                </form>

            </div>

        </div>
    </div>
</x-app-layout>