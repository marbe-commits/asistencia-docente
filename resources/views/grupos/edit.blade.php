<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-purple-900 leading-tight">
            Editar Grupo
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow rounded p-6 border border-purple-300">

                <form action="{{ route('grupos.update', $grupo) }}" method="POST">

                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block font-bold text-purple-900">Nombre</label>
                        <input type="text"
                               name="nombre"
                               value="{{ $grupo->nombre }}"
                               class="w-full border border-purple-300 rounded p-2 focus:ring-2 focus:ring-purple-700 focus:border-purple-700"
                               required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold text-purple-900">Carrera</label>
                        <input type="text"
                               name="carrera"
                               value="{{ $grupo->carrera }}"
                               class="w-full border border-purple-300 rounded p-2 focus:ring-2 focus:ring-purple-700 focus:border-purple-700"
                               required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold text-purple-900">Cuatrimestre</label>
                        <input type="number"
                               name="cuatrimestre"
                               value="{{ $grupo->cuatrimestre }}"
                               class="w-full border border-purple-300 rounded p-2 focus:ring-2 focus:ring-purple-700 focus:border-purple-700"
                               required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold text-purple-900">Número de Alumnos</label>
                        <input type="number"
                               name="numero_alumnos"
                               value="{{ $grupo->numero_alumnos }}"
                               class="w-full border border-purple-300 rounded p-2 focus:ring-2 focus:ring-purple-700 focus:border-purple-700"
                               required>
                    </div>

                    <button type="submit"
                            class="bg-purple-800 hover:bg-purple-900 text-white px-4 py-2 rounded font-bold">
                        Actualizar Grupo
                    </button>

                    <a href="{{ route('grupos.index') }}"
                       class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded font-bold">
                        Cancelar
                    </a>

                </form>

            </div>

        </div>
    </div>
</x-app-layout>