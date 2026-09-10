<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Aula
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow rounded p-6">

                <form action="{{ route('aulas.update',$aula) }}" method="POST">

                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block font-bold">Nombre</label>
                        <input type="text"
                               name="nombre"
                               value="{{ $aula->nombre }}"
                               class="w-full border rounded p-2"
                               required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold">Edificio</label>
                        <input type="text"
                               name="edificio"
                               value="{{ $aula->edificio }}"
                               class="w-full border rounded p-2"
                               required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold">Capacidad</label>
                        <input type="number"
                               name="capacidad"
                               value="{{ $aula->capacidad }}"
                               class="w-full border rounded p-2"
                               required>
                    </div>

                    <button type="submit"
                            class="bg-green-600 text-white px-4 py-2 rounded">
                        Actualizar Aula
                    </button>

                    <a href="{{ route('aulas.index') }}"
                       class="bg-gray-500 text-white px-4 py-2 rounded">
                        Cancelar
                    </a>

                </form>

            </div>

        </div>
    </div>
</x-app-layout>