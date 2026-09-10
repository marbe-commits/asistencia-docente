<x-guest-layout>

<div class="min-h-screen flex">

    <!-- LADO IZQUIERDO -->
    <div class="hidden lg:flex lg:w-3/5 items-center justify-center p-16"
         style="background:linear-gradient(135deg,#7C3AED,#5B21B6,#4C1D95);">

        <div class="max-w-xl text-white">

            <h1 class="text-6xl font-black leading-tight">
                Crear Cuenta
            </h1>

            <p class="mt-8 text-xl leading-9 text-purple-100">

                Registra nuevos usuarios autorizados para acceder al sistema 
                institucional y administrar el control academico

            </p>

            <div class="mt-12 space-y-5">

                <div class="p-5 rounded-2xl flex items-center"
                     style="background:rgba(255,255,255,.15);backdrop-filter:blur(10px);">

                     <span class="ml-3 font-medium">Acceso institucional seguro </span>

                </div>

                <div class="p-5 rounded-2xl flex items-center"
                     style="background:rgba(255,255,255,.15);backdrop-filter:blur(10px);">

                     <span class="ml-3 font-medium">Gestion centralizada</span>

                </div>

                <div class="p-5 rounded-2xl flex items-center"
                     style="background:rgba(255,255,255,.15);backdrop-filter:blur(10px);">

                     <span class="ml-3 font-medium">Plataforma protegida</span>

                </div>

            </div>

        </div>

    </div>

    <!-- FORMULARIO -->
    <div class="w-full lg:w-2/5 flex items-center justify-center p-8"
         style="background:#F8F5FF;">

        <div class="w-full max-w-lg rounded-3xl p-10"
             style="
                background:white;
                border:2px solid #DDD6FE;
                box-shadow:0 20px 45px rgba(124,58,237,.15);
             ">

            <div class="text-center mb-10">

                <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-5"
                     style="background:#EDE9FE;">

                    <span class="text-4xl">🎓</span>

                </div>

                <h2 class="text-4xl font-bold"
                    style="color:#4C1D95;">

                    Registro de Usuario

                </h2>

                <p class="mt-3"
                   style="color:#6B5B95;">

                    Crear nueva cuenta de acceso

                </p>

            </div>

            <form method="POST" action="{{ route('register') }}">

                @csrf

                <!-- NOMBRE -->

                <div>

                    <label class="block text-sm font-semibold mb-2"
                           style="color:#4C1D95;">

                        Nombre completo

                    </label>

                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        required
                        autofocus

                        class="w-full rounded-xl px-5 py-4 text-lg outline-none transition"

                        style="border:2px solid #DDD6FE;"

                        onfocus="this.style.borderColor='#7C3AED'"
                        onblur="this.style.borderColor='#DDD6FE'">

                    <x-input-error :messages="$errors->get('name')" class="mt-2"/>

                </div>

                <!-- EMAIL -->

                <div class="mt-6">

                    <label class="block text-sm font-semibold mb-2"
                           style="color:#4C1D95;">

                        Correo electrónico

                    </label>

                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required

                        class="w-full rounded-xl px-5 py-4 text-lg outline-none transition"

                        style="border:2px solid #DDD6FE;"

                        onfocus="this.style.borderColor='#7C3AED'"
                        onblur="this.style.borderColor='#DDD6FE'">

                    <x-input-error :messages="$errors->get('email')" class="mt-2"/>

                </div>

                <!-- PASSWORD -->

                <div class="mt-6">

                    <label class="block text-sm font-semibold mb-2"
                           style="color:#4C1D95;">

                        Contraseña

                    </label>

                    <input
                        type="password"
                        name="password"
                        required

                        class="w-full rounded-xl px-5 py-4 text-lg outline-none transition"

                        style="border:2px solid #DDD6FE;"

                        onfocus="this.style.borderColor='#7C3AED'"
                        onblur="this.style.borderColor='#DDD6FE'">

                    <x-input-error :messages="$errors->get('password')" class="mt-2"/>

                </div>

                <!-- CONFIRMAR PASSWORD -->

                <div class="mt-6">

                    <label class="block text-sm font-semibold mb-2"
                           style="color:#4C1D95;">

                        Confirmar contraseña

                    </label>

                    <input
                        type="password"
                        name="password_confirmation"
                        required

                        class="w-full rounded-xl px-5 py-4 text-lg outline-none transition"

                        style="border:2px solid #DDD6FE;"

                        onfocus="this.style.borderColor='#7C3AED'"
                        onblur="this.style.borderColor='#DDD6FE'">

                </div>

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

                        Crear Cuenta

                    </button>

                </div>

                <div class="mt-8 text-center">

                    <a href="{{ route('login') }}"
                       style="color:#5B21B6;font-weight:600;">

                        Ya tengo una cuenta

                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

</x-guest-layout>