<x-app-layout>

    <x-slot name="header">
        <h2 class="text-2xl font-bold text-slate-800 px-4 sm:px-6 lg:px-8">
            👥 Registrar Nuevo Grupo
        </h2>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8">

        <div class="max-w-5xl mx-auto">

            <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">

                <!-- Encabezado -->
                <div class="bg-gradient-to-r from-purple-600 to-indigo-700 p-6">

                    <h3 class="text-2xl font-bold text-white">
                        Información del Grupo Académico
                    </h3>

                    <p class="text-purple-100 mt-1">
                        Capture los datos correspondientes al grupo escolar.
                    </p>

                </div>

                <!-- Formulario -->
                <div class="p-8">

                    <form action="{{ route('grupos.store') }}" method="POST">

                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <!-- Nombre -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Nombre del Grupo
                                </label>

                                <input
                                    type="text"
                                    name="nombre"
                                    value="{{ old('nombre') }}"
                                    placeholder="Ej: TI-401"
                                    class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                                    required>
                            </div>

                            <!-- Carrera -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Carrera
                                </label>

                                <input
                                    type="text"
                                    name="carrera"
                                    value="{{ old('carrera') }}"
                                    placeholder="Ej: Ingeniería en Software"
                                    class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                                    required>
                            </div>

                            <!-- Cuatrimestre -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Cuatrimestre
                                </label>

                                <input
                                    type="number"
                                    name="cuatrimestre"
                                    value="{{ old('cuatrimestre') }}"
                                    placeholder="Ej: 4"
                                    class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                                    required>
                            </div>

                            <!-- Número alumnos -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Número de Alumnos
                                </label>

                                <input
                                    type="number"
                                    name="numero_alumnos"
                                    value="{{ old('numero_alumnos') }}"
                                    placeholder="Ej: 35"
                                    class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                                    required>
                            </div>

                        </div>

                        <!-- Botones -->
                        <div class="mt-10 flex gap-4">

                            <button
                                type="submit"
                                class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl font-bold shadow-lg transition">
                                Guardar Grupo
                            </button>

                            <a
                                href="{{ route('grupos.index') }}"
                                class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-xl font-bold shadow-lg transition">
                                Cancelar
                            </a>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>