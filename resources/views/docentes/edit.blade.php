<x-app-layout>

    <x-slot name="header">
        <h2 class="text-2xl font-bold text-purple-900 px-4 sm:px-6 lg:px-8">
            👨‍🏫 Editar Registro de Docente
        </h2>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8">

        <div class="max-w-5xl mx-auto">

            <div class="bg-white rounded-2xl shadow-xl border border-purple-200 overflow-hidden">

                <!-- Encabezado unificado -->
                <div class="bg-gradient-to-r from-purple-700 to-purple-900 p-6">

                    <h3 class="text-2xl font-bold text-white">
                        Actualizar Datos del Profesor
                    </h3>

                    <p class="text-purple-100 mt-1">
                        Modifique los campos correspondientes y guarde los cambios en el sistema.
                    </p>

                </div>

                <!-- Formulario -->
                <div class="p-8">

                    <form action="{{ route('docentes.update', $docente) }}" method="POST">

                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <!-- Número -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Número de Empleado
                                </label>

                                <input 
                                    type="text"
                                    name="numero_empleado"
                                    value="{{ old('numero_empleado', $docente->numero_empleado) }}"
                                    class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-purple-600 focus:border-purple-600"
                                    required>
                            </div>

                            <!-- Nombre -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Nombre
                                </label>

                                <input 
                                    type="text"
                                    name="nombre"
                                    value="{{ old('nombre', $docente->nombre) }}"
                                    class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-purple-600 focus:border-purple-600"
                                    required>
                            </div>

                            <!-- Apellido paterno -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Apellido Paterno
                                </label>

                                <input 
                                    type="text"
                                    name="apellido_paterno"
                                    value="{{ old('apellido_paterno', $docente->apellido_paterno) }}"
                                    class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-purple-600 focus:border-purple-600"
                                    required>
                            </div>

                            <!-- Apellido materno -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Apellido Materno
                                </label>

                                <input 
                                    type="text"
                                    name="apellido_materno"
                                    value="{{ old('apellido_materno', $docente->apellido_materno) }}"
                                    class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-purple-600 focus:border-purple-600"
                                    required>
                            </div>

                            <!-- Correo -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Correo Electrónico
                                </label>

                                <input 
                                    type="email"
                                    name="correo"
                                    value="{{ old('correo', $docente->correo) }}"
                                    class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-purple-600 focus:border-purple-600"
                                    required>
                            </div>

                            <!-- Teléfono -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Teléfono
                                </label>

                                <input 
                                    type="tel"
                                    name="telefono"
                                    id="telefono"
                                    value="{{ old('telefono', $docente->telefono) }}"
                                    maxlength="10"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                    placeholder="Ej. 5512345678"
                                    class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-purple-600 focus:border-purple-600">
                            </div>

                        </div>

                        <!-- Botones -->
                        <div class="mt-10 flex gap-4">

                            <button 
                                type="submit"
                                class="bg-purple-700 hover:bg-purple-800 text-white px-6 py-3 rounded-xl font-bold shadow-lg transition">
                                Actualizar Docente
                            </button>

                            <a 
                                href="{{ route('docentes.index') }}"
                                class="bg-purple-400 hover:bg-purple-500 text-white px-6 py-3 rounded-xl font-bold shadow-lg transition">
                                Cancelar
                            </a>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>