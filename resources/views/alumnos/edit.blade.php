<x-app-layout>

    <x-slot name="header">
        <h2 class="text-2xl font-bold text-purple-900 px-4 sm:px-6 lg:px-8">
            🎓 Editar Registro de Alumno
        </h2>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8">

        <div class="max-w-5xl mx-auto">

            {{-- MENSAJES DE VALIDACIÓN --}}
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 rounded-xl p-5 shadow-sm">

                    <div class="font-bold mb-2 text-red-800">
                        ⚠️ No se pudieron guardar los cambios
                    </div>

                    <ul class="list-disc list-inside text-sm text-red-600">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>

                </div>
            @endif


            <div class="bg-white rounded-2xl shadow-xl border border-purple-200 overflow-hidden">

                {{-- ENCABEZADO CON COLOR FORZADO --}}
                <div class="p-6" style="background: linear-gradient(to right, #6b21a8, #4c1d95) !important; color: #ffffff !important;">

                    <h3 class="text-2xl font-bold" style="color: #ffffff !important;">
                        Actualizar Datos del Alumno
                    </h3>

                    <p class="mt-1" style="color: #f3e8ff !important;">
                        Modifique los campos correspondientes y guarde los cambios en el sistema.
                    </p>

                </div>


                {{-- FORMULARIO --}}
                <div class="p-8">

                    <form action="{{ route('alumnos.update', $alumno) }}" method="POST">

                        @csrf
                        @method('PUT')


                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">


                            {{-- MATRÍCULA --}}
                            <div>

                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Matrícula
                                </label>

                                <input
                                    type="text"
                                    name="matricula"
                                    value="{{ old('matricula', $alumno->matricula) }}"
                                    maxlength="9"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                    class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-purple-600 focus:border-purple-600"
                                    required
                                >

                                <p class="text-xs text-gray-500 mt-1">
                                    Debe contener 8 o 9 números.
                                </p>

                            </div>


                            {{-- NOMBRE --}}
                            <div>

                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Nombre
                                </label>

                                <input
                                    type="text"
                                    name="nombre"
                                    value="{{ old('nombre', $alumno->nombre) }}"
                                    class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-purple-600 focus:border-purple-600"
                                    required
                                >

                            </div>


                            {{-- APELLIDO PATERNO --}}
                            <div>

                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Apellido Paterno
                                </label>

                                <input
                                    type="text"
                                    name="apellido_paterno"
                                    value="{{ old('apellido_paterno', $alumno->apellido_paterno) }}"
                                    class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-purple-600 focus:border-purple-600"
                                    required
                                >

                            </div>


                            {{-- APELLIDO MATERNO --}}
                            <div>

                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Apellido Materno
                                </label>

                                <input
                                    type="text"
                                    name="apellido_materno"
                                    value="{{ old('apellido_materno', $alumno->apellido_materno) }}"
                                    class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-purple-600 focus:border-purple-600"
                                    required
                                >

                            </div>


                            {{-- CORREO --}}
                            <div>

                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Correo Electrónico
                                </label>

                                <input
                                    type="email"
                                    name="correo"
                                    value="{{ old('correo', $alumno->correo) }}"
                                    class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-purple-600 focus:border-purple-600"
                                    required
                                >

                            </div>


                            {{-- GRUPO --}}
                            <div>

                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Grupo
                                </label>

                                <select
                                    name="grupo_id"
                                    class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-purple-600 focus:border-purple-600"
                                    required
                                >

                                    <option value="">
                                        Seleccione un grupo
                                    </option>

                                    @foreach ($grupos as $grupo)

                                        <option
                                            value="{{ $grupo->id }}"
                                            {{ old('grupo_id', $alumno->grupo_id) == $grupo->id ? 'selected' : '' }}
                                        >
                                            {{ $grupo->nombre }}
                                        </option>

                                    @endforeach

                                </select>

                            </div>

                        </div>


                        {{-- BOTONES CON COLORES FORZADOS --}}
                        <div class="mt-10 flex flex-wrap gap-4">

                            <button
                                type="submit"
                                class="px-6 py-3 rounded-xl font-bold shadow-lg transition duration-200"
                                style="background-color: #6b21a8 !important; color: #ffffff !important;"
                            >
                                ✓ Actualizar Alumno
                            </button>


                            <a
                                href="{{ route('alumnos.index') }}"
                                class="px-6 py-3 rounded-xl font-bold shadow-lg transition duration-200"
                                style="background-color: #c084fc !important; color: #ffffff !important;"
                            >
                                ← Cancelar
                            </a>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>