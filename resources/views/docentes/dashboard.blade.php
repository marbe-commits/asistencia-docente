<x-app-layout>

    <x-slot name="header">

        <div class="flex justify-between items-center px-4 sm:px-6 lg:px-8">

            <div>

                <h2 class="text-3xl font-bold"
                    style="color:#4C1D95;">

                    👨‍🏫 Panel del Docente

                </h2>

                <p style="color:#6B5B95;" class="mt-1">

                    Bienvenido, {{ Auth::user()->name }}

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


    <div class="py-8 px-4 sm:px-6 lg:px-8"
         style="background:#F8F5FF; min-height:70vh;">

        <div class="max-w-7xl mx-auto">


            <!-- BIENVENIDA -->

            <div class="rounded-3xl p-6 mb-8 shadow-xl"
                 style="background:linear-gradient(135deg,#7C3AED,#4C1D95); color:white;">

                <h3 class="text-2xl font-bold">

                    ¡Bienvenido, {{ Auth::user()->name }}! 👋

                </h3>

                <p class="mt-2 opacity-90">

                    Desde este panel puedes consultar y gestionar
                    tus horarios, clases y asistencias.

                </p>

            </div>


            <!-- MODULOS DEL DOCENTE -->

            <div class="mb-6">

                <h3 class="text-2xl font-bold"
                    style="color:#4C1D95;">

                    📚 Mis módulos

                </h3>

                <p style="color:#6B5B95;" class="mt-1">

                    Accede a las funciones disponibles para docentes.

                </p>

            </div>


            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">


                <!-- HORARIOS -->

                <a href="{{ route('horarios.index') }}"
                   class="rounded-3xl p-6 shadow-xl transition duration-300 hover:-translate-y-2 hover:shadow-2xl"
                   style="background:white;border:2px solid #E9D5FF;">

                    <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-3xl mb-5"
                         style="background:#F3E8FF;">

                        ⏰

                    </div>

                    <h4 class="text-xl font-bold"
                        style="color:#4C1D95;">

                        Horarios

                    </h4>

                    <p class="mt-2"
                       style="color:#6B5B95;">

                        Consulta tus horarios de clase.

                    </p>

                    <div class="mt-5">

                        <span class="inline-block px-5 py-2 rounded-xl text-white"
                              style="background:#7C3AED;">

                            Ver horarios →

                        </span>

                    </div>

                </a>


                <!-- CLASES -->

                <a href="{{ route('clases.index') }}"
                   class="rounded-3xl p-6 shadow-xl transition duration-300 hover:-translate-y-2 hover:shadow-2xl"
                   style="background:white;border:2px solid #E9D5FF;">

                    <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-3xl mb-5"
                         style="background:#F3E8FF;">

                        📝

                    </div>

                    <h4 class="text-xl font-bold"
                        style="color:#4C1D95;">

                        Clases

                    </h4>

                    <p class="mt-2"
                       style="color:#6B5B95;">

                        Administra tus clases y genera los códigos QR.

                    </p>

                    <div class="mt-5">

                        <span class="inline-block px-5 py-2 rounded-xl text-white"
                              style="background:#7C3AED;">

                            Ver clases →

                        </span>

                    </div>

                </a>


                <!-- ASISTENCIAS -->

                <a href="{{ route('asistencias.index') }}"
                   class="rounded-3xl p-6 shadow-xl transition duration-300 hover:-translate-y-2 hover:shadow-2xl"
                   style="background:white;border:2px solid #E9D5FF;">

                    <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-3xl mb-5"
                         style="background:#F3E8FF;">

                        ✅

                    </div>

                    <h4 class="text-xl font-bold"
                        style="color:#4C1D95;">

                        Asistencias

                    </h4>

                    <p class="mt-2"
                       style="color:#6B5B95;">

                        Consulta y registra las asistencias.

                    </p>

                    <div class="mt-5">

                        <span class="inline-block px-5 py-2 rounded-xl text-white"
                              style="background:#7C3AED;">

                            Ver asistencias →

                        </span>

                    </div>

                </a>


            </div>


        </div>

    </div>

</x-app-layout>