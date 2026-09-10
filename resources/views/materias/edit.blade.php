<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Editar Materia
        </h2>
    </x-slot>

    <div class="py-8">

        <div class="max-w-4xl mx-auto">

            <div class="bg-white shadow rounded p-6">

                <form action="{{ route('materias.update', $materia) }}" method="POST">

                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block font-bold">Clave</label>

                        <input
                            type="text"
                            name="clave"
                            value="{{ $materia->clave }}"
                            class="w-full border rounded p-2"
                            required>

                        @error('clave')
                            <p class="text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold">Nombre</label>

                        <input
                            type="text"
                            name="nombre"
                            value="{{ $materia->nombre }}"
                            class="w-full border rounded p-2"
                            required>

                        @error('nombre')
                            <p class="text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold">Cuatrimestre</label>

                        <input
                            type="number"
                            name="cuatrimestre"
                            min="1"
                            max="12"
                            value="{{ $materia->cuatrimestre }}"
                            class="w-full border rounded p-2"
                            required>

                        @error('cuatrimestre')
                            <p class="text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold">Descripci¨®n</label>

                        <textarea
                            name="descripcion"
                            class="w-full border rounded p-2"
                            rows="4">{{ $materia->descripcion }}</textarea>
                    </div>

                    <button
                        type="submit"
                        class="bg-green-600 text-white px-4 py-2 rounded">

                        Actualizar Materia

                    </button>

                    <a
                        href="{{ route('materias.index') }}"
                        class="bg-gray-500 text-white px-4 py-2 rounded">

                        Cancelar

                    </a>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>