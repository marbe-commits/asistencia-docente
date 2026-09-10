<x-app-layout>

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <x-slot name="header">

        <div>

            <h2 class="text-2xl font-bold"
                style="color:#4C1D95;">

                Nuevo Horario

            </h2>

            <p class="text-gray-500 mt-1">

                Configure las clases semanales del docente.

            </p>

        </div>

    </x-slot>


    <div class="py-8">

        <div class="max-w-5xl mx-auto px-4">


            <div class="bg-white rounded-3xl shadow-xl overflow-hidden"
                 style="border:2px solid #E9D5FF;">


                <!-- ENCABEZADO -->

                <div class="p-8"
                     style="background:linear-gradient(135deg,#7C3AED,#5B21B6,#4C1D95);">

                    <h3 class="text-2xl font-bold text-white">

                        Información del Horario

                    </h3>

                    <p class="mt-2"
                       style="color:#E9D5FF;">

                        Asigne la materia, docente, grupo, aula y la frecuencia de clases semanales.

                    </p>

                </div>


                <div class="p-8">

                    <form action="{{ route('horarios.store') }}" method="POST">

                        @csrf

                        <!-- SELECCIÓN BASE -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

                            <div>

                                <label class="block text-sm font-semibold mb-2"
                                       style="color:#4C1D95;">

                                    Docente

                                </label>

                                <select name="docente_id"
                                        class="w-full rounded-xl px-4 py-3 outline-none transition"
                                        style="border:2px solid #DDD6FE;"
                                        onfocus="this.style.borderColor='#7C3AED'"
                                        onblur="this.style.borderColor='#DDD6FE'"
                                        required>

                                    <option value="" disabled selected>Seleccione un docente</option>

                                    @foreach($docentes as $docente)

                                        <option value="{{ $docente->id }}" {{ old('docente_id') == $docente->id ? 'selected' : '' }}>

                                            {{ $docente->nombre }}

                                        </option>

                                    @endforeach

                                </select>

                                <x-input-error :messages="$errors->get('docente_id')" class="mt-2" />

                            </div>

                            <div>

                                <label class="block text-sm font-semibold mb-2"
                                       style="color:#4C1D95;">

                                    Materia

                                </label>

                                <select name="materia_id"
                                        class="w-full rounded-xl px-4 py-3 outline-none transition"
                                        style="border:2px solid #DDD6FE;"
                                        onfocus="this.style.borderColor='#7C3AED'"
                                        onblur="this.style.borderColor='#DDD6FE'"
                                        required>

                                    <option value="" disabled selected>Seleccione una materia</option>

                                    @foreach($materias as $materia)

                                        <option value="{{ $materia->id }}" {{ old('materia_id') == $materia->id ? 'selected' : '' }}>

                                            {{ $materia->nombre }}

                                        </option>

                                    @endforeach

                                </select>

                                <x-input-error :messages="$errors->get('materia_id')" class="mt-2" />

                            </div>

                            <div>

                                <label class="block text-sm font-semibold mb-2"
                                       style="color:#4C1D95;">

                                    Grupo

                                </label>

                                <select name="grupo_id"
                                        class="w-full rounded-xl px-4 py-3 outline-none transition"
                                        style="border:2px solid #DDD6FE;"
                                        onfocus="this.style.borderColor='#7C3AED'"
                                        onblur="this.style.borderColor='#DDD6FE'"
                                        required>

                                    <option value="" disabled selected>Seleccione un grupo</option>

                                    @foreach($grupos as $grupo)

                                        <option value="{{ $grupo->id }}" {{ old('grupo_id') == $grupo->id ? 'selected' : '' }}>

                                            {{ $grupo->nombre }}

                                        </option>

                                    @endforeach

                                </select>

                                <x-input-error :messages="$errors->get('grupo_id')" class="mt-2" />

                            </div>

                            <div>

                                <label class="block text-sm font-semibold mb-2"
                                       style="color:#4C1D95;">

                                    Aula

                                </label>

                                <select name="aula_id"
                                        class="w-full rounded-xl px-4 py-3 outline-none transition"
                                        style="border:2px solid #DDD6FE;"
                                        onfocus="this.style.borderColor='#7C3AED'"
                                        onblur="this.style.borderColor='#DDD6FE'"
                                        required>

                                    <option value="" disabled selected>Seleccione un aula</option>

                                    @foreach($aulas as $aula)

                                        <option value="{{ $aula->id }}" {{ old('aula_id') == $aula->id ? 'selected' : '' }}>

                                            {{ $aula->nombre }}

                                        </option>

                                    @endforeach

                                </select>

                                <x-input-error :messages="$errors->get('aula_id')" class="mt-2" />

                            </div>

                        </div>

                        <!-- SELECCIÓN DE CANTIDAD DE CLASES -->
                        <div class="mb-8 p-6 rounded-2xl" style="background:#F8F5FF; border: 2px dashed #C4B5FD;">

                            <label class="block text-base font-bold mb-2" style="color:#4C1D95;">

                                ¿Cuántas clases a la semana imparte este horario?

                            </label>

                            <select id="clases_semana"
                                    name="clases_semana"
                                    onchange="generarCamposClases(this.value)"
                                    class="w-full md:w-1/3 rounded-xl px-4 py-3 outline-none transition bg-white"
                                    style="border:2px solid #DDD6FE;"
                                    required>

                                <option value="" disabled selected>Seleccione una opción</option>
                                <option value="1">1 Clase a la semana</option>
                                <option value="2">2 Clases a la semana</option>
                                <option value="3">3 Clases a la semana</option>
                                <option value="4">4 Clases a la semana</option>
                                <option value="5">5 Clases a la semana</option>

                            </select>

                        </div>

                        <!-- CONTENEDOR DINÁMICO DE FECHAS Y HORAS -->
                        <div id="contenedor_clases" class="space-y-6"></div>

                        <!-- ACCIONES -->
                        <div class="mt-10 flex items-center justify-end gap-4">

                            <a href="{{ route('horarios.index') }}"
                               class="px-6 py-3 rounded-xl font-bold transition"
                               style="background:#F3F4F6;color:#4B5563;"
                               onmouseover="this.style.background='#E5E7EB'"
                               onmouseout="this.style.background='#F3F4F6'">

                                Cancelar

                            </a>

                            <button type="submit"
                                    class="text-white px-8 py-3 rounded-xl font-bold transition shadow-lg"
                                    style="background:#7C3AED;box-shadow:0 10px 25px rgba(124,58,237,.25);"
                                    onmouseover="this.style.background='#6D28D9'"
                                    onmouseout="this.style.background='#7C3AED'">

                                Guardar Horario

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>

    <script>

    function generarCamposClases(cantidad) {

        const contenedor = document.getElementById('contenedor_clases');
        contenedor.innerHTML = ''; // Limpiar campos previos

        for (let i = 0; i < cantidad; i++) {

            const bloque = document.createElement('div');
            bloque.className = "p-6 rounded-2xl border transition";
            bloque.style.borderColor = "#DDD6FE";
            bloque.style.background = "#FFFFFF";

            bloque.innerHTML = `
                <h4 class="text-lg font-bold mb-4 flex items-center" style="color:#5B21B6;">
                    <span class="w-7 h-7 rounded-full flex items-center justify-center text-sm text-white mr-3" style="background:#7C3AED;">
                        ${i + 1}
                    </span>
                    Clase ${i + 1}
                </h4>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    <div>
                        <label class="block text-sm font-semibold mb-2" style="color:#4C1D95;">
                            Fecha de la Clase
                        </label>
                        <input type="text"
                               id="fecha_${i}"
                               name="clases[${i}][fecha]"
                               class="fecha-picker w-full rounded-xl px-4 py-3 outline-none transition"
                               style="border:2px solid #DDD6FE;"
                               placeholder="Seleccione la fecha"
                               required>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-2" style="color:#4C1D95;">
                            Hora de Inicio
                        </label>
                        <input type="time"
                               name="clases[${i}][hora_inicio]"
                               class="w-full rounded-xl px-4 py-3 outline-none transition"
                               style="border:2px solid #DDD6FE;"
                               required>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-2" style="color:#4C1D95;">
                            Hora de Fin
                        </label>
                        <input type="time"
                               name="clases[${i}][hora_fin]"
                               class="w-full rounded-xl px-4 py-3 outline-none transition"
                               style="border:2px solid #DDD6FE;"
                               required>
                    </div>

                </div>
            `;

            contenedor.appendChild(bloque);

            // Inicializar Flatpickr en cada input dinámico de fecha
            flatpickr(`#fecha_${i}`, {
                locale: "es",
                dateFormat: "Y-m-d",
                minDate: "today",
                disableMobile: true
            });

        }

    }

    </script>

</x-app-layout>