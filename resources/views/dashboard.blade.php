<x-app-layout>

    <x-slot name="header">

        <div class="flex justify-between items-center px-4 sm:px-6 lg:px-8">

            <div>

                <h2 class="text-3xl font-bold"
                    style="color:#4C1D95;">

                    📊 Dashboard Administrativo

                </h2>

                <p style="color:#6B5B95;" class="mt-1">

                    Sistema de Control de Asistencia Estudiantil mediante Validación QR y Geolocalización.
                    

                </p>

            </div>

            <div x-data="{ open: false }" class="relative">

                <button
                    @click="open = !open"

                    class="text-white px-5 py-3 rounded-xl shadow-lg flex items-center gap-2"

                    style="background:#7C3AED;">

                    👋 {{ Auth::user()->name }}

                </button>

                <div
                    x-show="open"
                    @click.away="open = false"

                    class="absolute right-0 mt-2 w-56 rounded-xl shadow-xl z-50"

                    style="background:white;border:2px solid #DDD6FE;">

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <button
                            type="submit"

                            class="w-full text-left px-4 py-3"

                            style="color:#7C3AED;">

                            🚪 Cerrar Sesión

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </x-slot>


    <div class="py-6 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto"
         style="background:#F8F5FF;">


        <!-- TARJETAS -->
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">

            <div class="rounded-3xl p-6 text-white shadow-xl"
                 style="background:linear-gradient(135deg,#A855F7,#7C3AED);">

                <p class="opacity-90">Docentes</p>

                <h3 class="text-4xl font-bold mt-2">

                    {{ $totalDocentes }}

                </h3>

                <p class="mt-2">👨‍🏫 Registrados</p>

            </div>


            <div class="rounded-3xl p-6 text-white shadow-xl"
                 style="background:linear-gradient(135deg,#8B5CF6,#6D28D9);">

                <p class="opacity-90">Materias</p>

                <h3 class="text-4xl font-bold mt-2">

                    {{ $totalMaterias }}

                </h3>

                <p class="mt-2">📚 Activas</p>

            </div>


            <div class="rounded-3xl p-6 text-white shadow-xl"
                 style="background:linear-gradient(135deg,#7C3AED,#5B21B6);">

                <p class="opacity-90">Clases</p>

                <h3 class="text-4xl font-bold mt-2">

                    {{ $totalClases }}

                </h3>

                <p class="mt-2">📝 Programadas</p>

            </div>


            <div class="rounded-3xl p-6 text-white shadow-xl"
                 style="background:linear-gradient(135deg,#6D28D9,#4C1D95);">

                <p class="opacity-90">Asistencias</p>

                <h3 class="text-4xl font-bold mt-2">

                    {{ $totalAsistencias }}

                </h3>

                <p class="mt-2">✅ Registradas</p>

            </div>

        </div>



        <!-- GRÁFICAS -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

            <div class="rounded-3xl p-6 shadow-xl"
                 style="background:white;border:2px solid #E9D5FF;">

                <h3 class="text-xl font-bold mb-4"
                    style="color:#4C1D95;">

                    📈 Estadísticas Generales

                </h3>

                <canvas id="barChart"></canvas>

            </div>


            <div class="rounded-3xl p-6 shadow-xl"
                 style="background:white;border:2px solid #E9D5FF;">

                <h3 class="text-xl font-bold mb-4"
                    style="color:#4C1D95;">

                    📊 Distribución de Asistencia

                </h3>

                <canvas id="pieChart"></canvas>

            </div>

        </div>



        <!-- ACTIVIDAD -->
        <div class="rounded-3xl p-6 shadow-xl"
             style="background:white;border:2px solid #E9D5FF;">

            <h3 class="text-xl font-bold mb-6"
                style="color:#4C1D95;">

                📌 Actividad Reciente

            </h3>

            <div class="space-y-4">

                <div class="p-4 rounded-xl"
                     style="background:#F3E8FF;color:#4C1D95;">

                    👨‍🏫 Nuevo docente registrado

                </div>

                <div class="p-4 rounded-xl"
                     style="background:#F3E8FF;color:#4C1D95;">

                    📚 Nueva materia agregada

                </div>

                <div class="p-4 rounded-xl"
                     style="background:#F3E8FF;color:#4C1D95;">

                    📝 Clase programada

                </div>

                <div class="p-4 rounded-xl"
                     style="background:#F3E8FF;color:#4C1D95;">

                    📍 Asistencia registrada hoy

                </div>

            </div>

        </div>

    </div>


{{-- CHART JS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

    // BARRAS
    const ctx = document.getElementById('barChart');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Docentes', 'Materias', 'Clases', 'Asistencias'],
            datasets: [{
                label: 'Sistema',
                data: [15, 12, 8, 20],
                backgroundColor: [
                '#A855F7',
                '#8B5CF6',
                '#7C3AED',
                '#5B21B6'
                ]   
            }]
        },
        options: {
            responsive: true
        }
    });


    // PASTEL
    const pie = document.getElementById('pieChart');

    new Chart(pie, {
        type: 'pie',
        data: {
            labels: ['Presentes', 'Retardos', 'Faltas'],
            datasets: [{
                data: [70,20,10],
                backgroundColor: [
                '#A855F7',
                '#7C3AED',
                '#4C1D95'
                ]
            }]
        },
        options: {
            responsive: true
        }
    });

</script>

</x-app-layout>