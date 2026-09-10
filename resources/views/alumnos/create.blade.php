<x-app-layout>

    <x-slot name="header">
        <h2 class="text-2xl font-bold text-slate-800">
            Registrar Nuevo Alumno
        </h2>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8">

        <div class="max-w-5xl mx-auto">

            <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">

                <div class="p-6" style="background: linear-gradient(to right, #7C3AED, #5B21B6);">

                    <h3 class="text-2xl font-bold text-white">
                        Informacion del Alumno
                    </h3>

                   <p class="mt-1" style="color:#E9D5FF;">
                        Complete los datos para registrar un nuevo alumno.
                    </p>

                </div>

                <div class="p-8">

                    <form action="{{ route('alumnos.store') }}" method="POST">

                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Matricula
                                </label>

                                <input
                                    type="text"
                                    name="matricula"
                                    value="{{ old('matricula') }}"
                                    maxlength="9"
                                    oninput="this.value=this.value.replace(/[^0-9]/g,'')"
                                    placeholder="Ej: 221650235"
                                    class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    required>

                                @error('matricula')
                                    <p class="text-red-600 text-sm mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Nombre
                                </label>

                                <input
                                    type="text"
                                    name="nombre"
                                    value="{{ old('nombre') }}"
                                    oninput="this.value=this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ ]/g,'')"
                                    placeholder="Nombre"
                                    class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    required>

                                @error('nombre')
                                    <p class="text-red-600 text-sm mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Apellido Paterno
                                </label>

                                <input
                                    type="text"
                                    name="apellido_paterno"
                                    value="{{ old('apellido_paterno') }}"
                                    oninput="this.value=this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ ]/g,'')"
                                    placeholder="Apellido paterno"
                                    class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    required>

                                @error('apellido_paterno')
                                    <p class="text-red-600 text-sm mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Apellido Materno
                                </label>

                                <input
                                    type="text"
                                    name="apellido_materno"
                                    value="{{ old('apellido_materno') }}"
                                    oninput="this.value=this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ ]/g,'')"
                                    placeholder="Apellido materno"
                                    class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    required>

                                @error('apellido_materno')
                                    <p class="text-red-600 text-sm mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Correo Electronico
                                </label>

                                <input
                                    type="email"
                                    name="correo"
                                    value="{{ old('correo') }}"
                                    placeholder="correo@universidad.com"
                                    class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    required>

                                @error('correo')
                                    <p class="text-red-600 text-sm mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Grupo
                                </label>

                                <select
                                    name="grupo_id"
                                    class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    required>

                                    <option value="">Seleccione grupo</option>

                                    @foreach($grupos as $grupo)
                                        <option value="{{ $grupo->id }}" {{ old('grupo_id') == $grupo->id ? 'selected' : '' }}>
                                            {{ $grupo->nombre }}
                                        </option>
                                    @endforeach

                                </select>

                                @error('grupo_id')
                                    <p class="text-red-600 text-sm mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>

                        <div class="mt-10 flex gap-4">

                            <button
                                type="submit"
                                class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl font-bold shadow-lg transition">
                                Guardar Alumno
                            </button>

                            <a
                                href="{{ route('alumnos.index') }}"
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
