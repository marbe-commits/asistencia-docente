<nav class="fixed top-0 left-0 h-screen w-72 shadow-2xl flex flex-col"
     style="background-color: #3b0a57;">

    {{-- ENCABEZADO --}}
    <div class="p-6 border-b border-purple-900">

        <h1 class="text-white text-3xl font-bold">
            🎓 Asistencia QR
        </h1>

        <p class="text-white text-sm mt-1">
        </p>

    </div>


    {{-- MENÚ --}}
    <div class="flex-1 p-5 space-y-2 overflow-y-auto">

        {{-- DASHBOARD --}}
        <a href="{{ route('dashboard') }}"
           class="flex items-center gap-3 text-white hover:bg-purple-700 px-4 py-3 rounded-xl transition">

            <span>📊</span>

            Dashboard

        </a>


        {{-- ================================================= --}}
        {{-- ADMINISTRADOR --}}
        {{-- ================================================= --}}

        @if(Auth::user()->rol === 'administrador')

            <div class="pt-5 pb-2">

                <p class="text-purple-300 text-xs font-bold uppercase px-4">
                    Administración
                </p>

            </div>


            {{-- DOCENTES --}}
            <a href="{{ route('docentes.index') }}"
               class="flex items-center gap-3 text-white hover:bg-purple-700 px-4 py-3 rounded-xl transition">

                <span>👨‍🏫</span>

                Docentes

            </a>


            {{-- MATERIAS --}}
            <a href="{{ route('materias.index') }}"
               class="flex items-center gap-3 text-white hover:bg-purple-700 px-4 py-3 rounded-xl transition">

                <span>📚</span>

                Materias

            </a>


            {{-- GRUPOS --}}
            <a href="{{ route('grupos.index') }}"
               class="flex items-center gap-3 text-white hover:bg-purple-700 px-4 py-3 rounded-xl transition">

                <span>👥</span>

                Grupos

            </a>


            {{-- ALUMNOS --}}
            <a href="{{ route('alumnos.index') }}"
               class="flex items-center gap-3 text-white hover:bg-purple-700 px-4 py-3 rounded-xl transition">

                <span>🎓</span>

                Alumnos

            </a>


            {{-- AULAS --}}
            <a href="{{ route('aulas.index') }}"
               class="flex items-center gap-3 text-white hover:bg-purple-700 px-4 py-3 rounded-xl transition">

                <span>🏫</span>

                Aulas

            </a>


            {{-- ================================================= --}}
            {{-- MÓDULOS GENERALES DEL SISTEMA --}}
            {{-- ================================================= --}}

            <div class="pt-5 pb-2">

                <p class="text-purple-300 text-xs font-bold uppercase px-4">
                    Gestión Académica
                </p>

            </div>


            {{-- HORARIOS --}}
            <a href="{{ route('horarios.index') }}"
               class="flex items-center gap-3 text-white hover:bg-purple-700 px-4 py-3 rounded-xl transition">

                <span>⏰</span>

                Horarios

            </a>


            {{-- CLASES --}}
            <a href="{{ route('clases.index') }}"
               class="flex items-center gap-3 text-white hover:bg-purple-700 px-4 py-3 rounded-xl transition">

                <span>📝</span>

                Clases

            </a>


            {{-- ASISTENCIAS --}}
            <a href="{{ route('asistencias.index') }}"
               class="flex items-center gap-3 text-white hover:bg-purple-700 px-4 py-3 rounded-xl transition">

                <span>✅</span>

                Asistencias

            </a>

        @endif


        {{-- ================================================= --}}
        {{-- DOCENTE --}}
        {{-- ================================================= --}}

        @if(Auth::user()->rol === 'docente')

            <div class="pt-5 pb-2">

                <p class="text-purple-300 text-xs font-bold uppercase px-4">
                    Gestión Docente
                </p>

            </div>


            {{-- HORARIOS --}}
            <a href="{{ route('horarios.index') }}"
               class="flex items-center gap-3 text-white hover:bg-purple-700 px-4 py-3 rounded-xl transition">

                <span>⏰</span>

                Horarios

            </a>


            {{-- CLASES --}}
            <a href="{{ route('clases.index') }}"
               class="flex items-center gap-3 text-white hover:bg-purple-700 px-4 py-3 rounded-xl transition">

                <span>📝</span>

                Clases

            </a>


            {{-- ASISTENCIAS --}}
            <a href="{{ route('asistencias.index') }}"
               class="flex items-center gap-3 text-white hover:bg-purple-700 px-4 py-3 rounded-xl transition">

                <span>✅</span>

                Asistencias

            </a>

        @endif

    </div>


    {{-- USUARIO --}}
    <div class="p-5 border-t border-purple-900">

        <div class="text-white mb-3">

            <p class="font-bold">
                {{ Auth::user()->name }}
            </p>

            <p class="text-sm text-purple-300">

                @if(Auth::user()->rol === 'administrador')

                    👑 Administrador

                @elseif(Auth::user()->rol === 'docente')

                    👨‍🏫 Docente

                @endif

            </p>

        </div>


        {{-- CERRAR SESIÓN --}}
        <form method="POST" action="{{ route('logout') }}">

            @csrf

            <button type="submit"
                    class="w-full flex items-center justify-center gap-2
                           bg-purple-700 hover:bg-purple-600
                           text-white px-4 py-3 rounded-xl
                           transition shadow-lg">

                🚪 Cerrar sesión

            </button>

        </form>

    </div>

</nav>