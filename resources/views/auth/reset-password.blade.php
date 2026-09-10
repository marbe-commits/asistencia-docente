<x-guest-layout>
    <div class="flex min-h-screen bg-gradient-to-br from-purple-700 via-purple-600 to-indigo-700">
        
        <!-- Columna izquierda: Formulario -->
        <div class="flex-1 flex justify-center items-center p-8">
            <div class="w-full max-w-md bg-white shadow-2xl rounded-xl p-8">
                <div class="text-center mb-6">
                    <h2 class="text-3xl font-extrabold text-purple-700">🔒 Restablecer contraseña</h2>
                    <p class="text-gray-500 mt-2">Ingresa tu nueva contraseña para continuar</p>
                </div>

                <form method="POST" action="{{ route('password.store') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <!-- Email -->
                    <div class="mb-4">
                        <x-input-label for="email" :value="__('Correo electrónico')" />
                        <x-text-input id="email" class="block mt-1 w-full border rounded-lg px-3 py-2 focus:ring focus:ring-purple-300" 
                            type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500" />
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <x-input-label for="password" :value="__('Nueva contraseña')" />
                        <x-text-input id="password" class="block mt-1 w-full border rounded-lg px-3 py-2 focus:ring focus:ring-purple-300" 
                            type="password" name="password" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-6">
                        <x-input-label for="password_confirmation" :value="__('Confirmar contraseña')" />
                        <x-text-input id="password_confirmation" class="block mt-1 w-full border rounded-lg px-3 py-2 focus:ring focus:ring-purple-300"
                            type="password_confirmation" name="password_confirmation" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-500" />
                    </div>

                    <!-- Botón -->
                    <div class="flex items-center justify-center">
                        <x-primary-button class="w-full bg-purple-700 hover:bg-purple-800 text-white font-semibold py-3 px-4 rounded-lg transition duration-300 ease-in-out transform hover:scale-105">
                            {{ __('Restablecer contraseña') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Columna derecha: Imagen decorativa -->
        <div class="hidden md:flex flex-1 justify-center items-center bg-white">
            <img src=<img src=<img src="{{ asset('imagenes/padlock.png') }}" alt="Seguridad contrase�a" class="max-w-sm">


        </div>
    </div>
</x-guest-layout>
