<x-guest-layout>

    <div class="min-h-screen flex">

        <!-- LADO IZQUIERDO -->
        <div class="hidden lg:flex lg:w-3/5 items-center justify-center p-16"
             style="background:linear-gradient(135deg,#7C3AED,#5B21B6,#4C1D95);">

            <div class="max-w-xl text-white">

                <h1 class="text-6xl font-black leading-tight">
                    AsistenciaQR
                </h1>

                <p class="mt-8 text-xl leading-9 text-purple-100">

                    Plataforma institucional diseñada para optimizar la gestión académica mediante el control inteligente de asistencia estudiantil utilizando validación mediante códigos QR, geolocalización y generación automática de reportes.

                </p>

                <div class="mt-12 space-y-5">

                    <div class="p-5 rounded-2xl flex items-center"
                         style="background:rgba(255,255,255,.15);backdrop-filter:blur(10px);">

                        🔒 <span class="ml-3 font-medium">Seguridad avanzada de acceso</span>

                    </div>

                    <div class="p-5 rounded-2xl flex items-center"
                         style="background:rgba(255,255,255,.15);backdrop-filter:blur(10px);">

                        📱 <span class="ml-3 font-medium">Control automatizado mediante QR</span>

                    </div>

                    <div class="p-5 rounded-2xl flex items-center"
                         style="background:rgba(255,255,255,.15);backdrop-filter:blur(10px);">

                        📊 <span class="ml-3 font-medium">Administración centralizada y reportes</span>

                    </div>

                </div>

            </div>

        </div>

        <!-- FORMULARIO -->
        <div class="w-full lg:w-2/5 flex items-center justify-center p-8"
             style="background:#F8F5FF;">

            <div class="w-full max-w-lg rounded-3xl p-10"
                 style="background:white;
                        border:2px solid #DDD6FE;
                        box-shadow:0 20px 45px rgba(124,58,237,.15);">

                <div class="text-center mb-10">

                    <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-5"
                         style="background:#EDE9FE;">

                        <span class="text-4xl">🎓</span>

                    </div>

                    <h2 class="text-4xl font-bold"
                        style="color:#4C1D95;">

                        Iniciar Sesión

                    </h2>

                    <p class="mt-3"
                       style="color:#6B5B95;">

                        Acceso al Sistema Académico

                    </p>

                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}">

                    @csrf

                    <!-- EMAIL -->
                    <div>

                        <label class="block text-sm font-semibold mb-2"
                               style="color:#4C1D95;">

                            Correo electrónico

                        </label>

                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="ejemplo@correo.com"

                            class="w-full rounded-xl px-5 py-4 text-lg outline-none transition"

                            style="
                                border:2px solid #DDD6FE;
                            "

                            onfocus="this.style.borderColor='#7C3AED'"
                            onblur="this.style.borderColor='#DDD6FE'"

                            required
                            autofocus>

                        <x-input-error :messages="$errors->get('email')" class="mt-2" />

                    </div>

                    <!-- PASSWORD -->
                    <div class="mt-6">

                        <label class="block text-sm font-semibold mb-2"
                               style="color:#4C1D95;">

                            Contraseña

                        </label>

                        <div class="flex w-full">

                            <!-- CAMPO CONTRASEÑA -->
                            <input
                                id="password"
                                type="password"
                                name="password"
                                placeholder="••••••••"

                                class="flex-1 rounded-l-xl px-5 py-4 text-lg outline-none transition"

                                style="
                                    border:2px solid #DDD6FE;
                                    border-right:none;
                                "

                                onfocus="this.style.borderColor='#7C3AED'"
                                onblur="this.style.borderColor='#DDD6FE'"

                                required>

                            <!-- BOTÓN DEL OJO -->
                            <button
                                type="button"
                                onclick="mostrarPassword()"

                                class="w-14 flex items-center justify-center rounded-r-xl transition"

                                style="
                                    background:white;
                                    border:2px solid #DDD6FE;
                                    color:#4C1D95;
                                "

                                onmouseover="this.style.color='#7C3AED'"
                                onmouseout="this.style.color='#4C1D95'"

                                aria-label="Mostrar contraseña">

                                <!-- OJO CERRADO / NORMAL -->
                                <svg
                                    id="iconoOjo"
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="22"
                                    height="22"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round">

                                    <path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/>

                                    <circle cx="12" cy="12" r="3"/>

                                </svg>

                            </button>

                        </div>

                        <x-input-error
                            :messages="$errors->get('password')"
                            class="mt-2" />

                    </div>

                    <!-- RECORDAR -->
                    <div class="mt-6 flex items-center justify-between">

                        <label class="flex items-center">

                            <input type="checkbox"
                                   name="remember"
                                   style="accent-color:#7C3AED;">

                            <span class="ml-3"
                                  style="color:#6B5B95;">

                                Recordarme

                            </span>

                        </label>

                    </div>

                    <!-- BOTÓN -->
                    <div class="mt-8">

                        <button
                            type="submit"

                            class="w-full text-white py-4 rounded-xl text-lg font-bold transition"

                            style="
                                background:#7C3AED;
                                box-shadow:0 10px 25px rgba(124,58,237,.25);
                            "

                            onmouseover="this.style.background='#6D28D9'"
                            onmouseout="this.style.background='#7C3AED'">

                            Entrar al Sistema

                        </button>

                    </div>

                    <!-- LINKS -->
                    <div class="mt-8 text-center space-y-4">

                        @if (Route::has('password.request'))

                            <div>

                                <a href="{{ route('password.request') }}"
                                   style="color:#7C3AED;font-weight:600;">

                                    ¿Olvidaste tu contraseña?

                                </a>

                            </div>

                        @endif

                        <div>

                            <a href="{{ route('register') }}"
                               style="color:#5B21B6;font-weight:600;">

                                Crear cuenta nueva

                            </a>

                        </div>

                    </div>

                </form>

            </div>

        </div>

    </div>

    <script>

    function mostrarPassword() {

        const password = document.getElementById('password');
        const icono = document.getElementById('iconoOjo');

        if (password.type === 'password') {

            password.type = 'text';

            // OJO TACHADO
            icono.innerHTML = `
                <path d="M3 3l18 18"></path>
                <path d="M10.58 10.58a2 2 0 0 0 2.83 2.83"></path>
                <path d="M9.88 4.24A10.76 10.76 0 0 1 12 4c5 0 8.5 4 10 8a15.8 15.8 0 0 1-3.17 5.06"></path>
                <path d="M6.61 6.61C4.62 7.9 3.24 9.76 2 12c1.5 4 5 8 10 8a10.8 10.8 0 0 0 4.39-.92"></path>
            `;

        } else {

            password.type = 'password';

            // OJO NORMAL
            icono.innerHTML = `
                <path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"></path>
                <circle cx="12" cy="12" r="3"></circle>
            `;

        }

    }

    </script>

</x-guest-layout>