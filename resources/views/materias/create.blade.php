<x-app-layout>

    <x-slot name="header">
        <h2 class="text-2xl font-bold text-slate-800">
            Registrar Nueva Materia
        </h2>
    </x-slot>

    <div class="py-8">

        <div class="max-w-5xl mx-auto">

            <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">

                <!-- ENCABEZADO -->
                <div class="p-6" style="background: linear-gradient(to right, #7C3AED, #5B21B6);">
                    <h3 class="text-2xl font-bold text-white">
                        Informacion de la Materia
                    </h3>

                    <p class="mt-1" style="color:#E9D5FF;">
                        Registre una nueva asignatura dentro del sistema.
                    </p>

                </div>

                <!-- FORMULARIO -->
                <div class="p-8">

                    <form action="{{ route('materias.store') }}" method="POST">

                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <!-- CLAVE -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Clave
                                </label>

                                <input
                                    type="text"
                                    name="clave"
                                    placeholder="Ej: MAT101"
                                    maxlength="9"
                                    class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-green-500"
                                    required>

                                @error('clave')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- NOMBRE -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Nombre
                                </label>

                                <input
                                    type="text"
                                    name="nombre"
                                    placeholder="Ej: Programacion Web"
                                    class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-green-500"
                                    required>

                                @error('nombre')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- CUATRIMESTRE -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Cuatrimestre
                                </label>

                                <input
                                    type="number"
                                    name="cuatrimestre"
                                    min="1"
                                    max="12"
                                    placeholder="Solo 1 al 12"
                                    class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-green-500"
                                    required>

                                @error('cuatrimestre')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div></div>

                        </div>

                        <!-- DESCRIPCION -->
                        <div class="mt-6">

                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Descripcion
                            </label>

                            <textarea
                                name="descripcion"
                                rows="5"
                                placeholder="Escriba una descripcion..."
                                class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-green-500"></textarea>

                        </div>

                        <!-- BOTONES -->
                        <div class="mt-10 flex gap-4">

                            <button
                                type="submit"
                                class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl font-bold shadow-lg">

                                Guardar Materia

                            </button>

                            <a
                                href="{{ route('materias.index') }}"
                                class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-xl font-bold shadow-lg">

                                Cancelar

                            </a>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>