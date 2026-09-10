<x-app-layout>

    <x-slot name="header">
        <h2 class="text-2xl font-bold text-slate-800 px-4 sm:px-6 lg:px-8">
            Registrar Nueva Aula
        </h2>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8">

        <div class="max-w-5xl mx-auto">

            <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">

                        <!-- Encabezado -->
                        <div class="bg-gradient-to-r from-purple-600 to-violet-700 p-6">
                    
                            <h3 class="text-2xl font-bold text-white">
                                Informacion del Aula
                            </h3>
                    
                            <p class="text-purple-100 mt-1">
                                Registre aulas disponibles dentro de la institucion.
                            </p>
                    
                        </div>

                <!-- Formulario -->
                <div class="p-8">

                    <form action="{{ route('aulas.store') }}" method="POST">

                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <!-- Nombre -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Nombre del Aula
                                </label>

                                <input
                                    type="text"
                                    name="nombre"
                                    value="{{ old('nombre') }}"
                                    placeholder="Ej: Aula A-204"
                                    class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                    required>
                            </div>

                            <!-- Edificio -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Edificio
                                </label>

                                <input
                                    type="text"
                                    name="edificio"
                                    value="{{ old('edificio') }}"
                                    placeholder="Ej: Edificio B"
                                    class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                    required>
                            </div>

                            <!-- Capacidad (Bloquea negativos como -20) -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Capacidad de Estudiantes
                                </label>

                                <input
                                    type="number"
                                    name="capacidad"
                                    value="{{ old('capacidad') }}"
                                    min="1"
                                    max="200"
                                    oninput="if(this.value < 1) this.value = ''; if(this.value > 200) this.value = 200;"
                                    placeholder="Ej: 40"
                                    class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                    required>
                            </div>

                            <!-- Espacio estructural -->
                            <div></div>

                        </div>

                        <!-- Botones -->
                        <div class="mt-10 flex gap-4">

                            <button
                                type="submit"
                                class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl font-bold shadow-lg transition">
                                Guardar Aula
                            </button>

                            <a
                                href="{{ route('aulas.index') }}"
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