<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold leading-tight text-gray-800">
            📷 Escanear Código QR
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-lg px-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-2xl border border-gray-100">
                
                {{-- Encabezado --}}
                <div class="bg-slate-50 border-b border-gray-100 p-6 text-center">
                    <div class="inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-indigo-50 text-2xl mb-2 shadow-inner">
                        📱
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">
                        Registrar Asistencia
                    </h3>
                    <p class="mt-1 text-xs text-gray-500">
                        Escanea el código QR con la cámara o ingresa el texto manualmente.
                    </p>
                </div>

                <div class="p-6">
                    {{-- Alertas de Sesión --}}
                    @if (session('success'))
                        <div class="mb-5 rounded-xl bg-emerald-50 p-4 text-emerald-800 border border-emerald-200/60 flex items-start space-x-3">
                            <span class="text-lg">✅</span>
                            <p class="text-sm font-medium">{{ session('success') }}</p>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-5 rounded-xl bg-rose-50 p-4 text-rose-800 border border-rose-200/60 flex items-start space-x-3">
                            <span class="text-lg">⚠️</span>
                            <p class="text-sm font-medium">{{ session('error') }}</p>
                        </div>
                    @endif

                    {{-- Visor de la Cámara QR --}}
                    <div class="mb-6">
                        <div id="reader" class="w-full overflow-hidden rounded-2xl border-2 border-dashed border-indigo-200 bg-gray-50"></div>
                        <p id="qr-feedback" class="mt-2 text-center text-xs font-semibold text-gray-500">
                            Cargando lector de cámara...
                        </p>
                    </div>

                    {{-- Formulario --}}
                    <form id="form-asistencia" action="{{ route('alumnos.registrar') }}" method="POST" class="space-y-5">
                        @csrf

                        <!-- CÓDIGO QR -->
                        <div>
                            <label for="codigo" class="block text-sm font-bold text-gray-700 mb-1.5">
                                🔑 Código QR
                            </label>
                            <input 
                                type="text" 
                                name="codigo" 
                                id="codigo"
                                value="{{ old('codigo') }}"
                                placeholder="El código se completará automáticamente" 
                                required
                                class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-gray-900 placeholder-gray-400 p-3 text-sm transition"
                            />
                            @error('codigo')
                                <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- GPS (CAMPOS OCULTOS) -->
                        <input type="hidden" name="latitud" id="latitud">
                        <input type="hidden" name="longitud" id="longitud">

                        <!-- ESTADO GPS -->
                        <div id="geo-card" class="rounded-xl bg-amber-50 border border-amber-200/60 p-3.5 transition-colors duration-200">
                            <p id="geo-status" class="text-xs font-semibold text-amber-800 flex items-center space-x-2">
                                <span class="animate-pulse">📍</span>
                                <span>Obteniendo ubicación GPS...</span>
                            </p>
                        </div>

                        <!-- BOTÓN -->
                        <button 
                            type="submit" 
                            id="btn-registrar" 
                            disabled 
                            class="w-full rounded-xl bg-emerald-600 py-3.5 text-sm font-bold text-white shadow-md hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed transition duration-150"
                        >
                            ✅ Registrar Asistencia
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    {{-- Librería HTML5 QR Code --}}
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const latInput = document.getElementById('latitud');
            const lngInput = document.getElementById('longitud');
            const btn = document.getElementById('btn-registrar');
            const status = document.getElementById('geo-status');
            const card = document.getElementById('geo-card');
            const codigoInput = document.getElementById('codigo');
            const qrFeedback = document.getElementById('qr-feedback');
            const form = document.getElementById('form-asistencia');

            let gpsObtenido = false;

            /*
            |--------------------------------------------------------------------------
            | GEOLOCALIZACIÓN
            |--------------------------------------------------------------------------
            */
            if ("geolocation" in navigator) {
                navigator.geolocation.getCurrentPosition(
                    function (position) {
                        latInput.value = position.coords.latitude;
                        lngInput.value = position.coords.longitude;
                        gpsObtenido = true;

                        status.innerHTML = '<span>✅</span> <span>Ubicación GPS obtenida correctamente.</span>';
                        status.className = 'text-xs font-semibold text-emerald-800 flex items-center space-x-2';
                        card.className = 'rounded-xl bg-emerald-50 border border-emerald-200/60 p-3.5 transition-colors duration-200';

                        btn.disabled = false;
                    },
                    function (error) {
                        console.error("Error GPS:", error);
                        status.innerHTML = '<span>❌</span> <span>Error al obtener ubicación. Activa el GPS de tu dispositivo.</span>';
                        status.className = 'text-xs font-semibold text-rose-800 flex items-center space-x-2';
                        card.className = 'rounded-xl bg-rose-50 border border-rose-200/60 p-3.5 transition-colors duration-200';
                    },
                    {
                        enableHighAccuracy: true,
                        timeout: 10000,
                        maximumAge: 0
                    }
                );
            } else {
                status.innerHTML = '<span>❌</span> <span>Tu navegador no soporta geolocalización.</span>';
                status.className = 'text-xs font-semibold text-rose-800 flex items-center space-x-2';
                card.className = 'rounded-xl bg-rose-50 border border-rose-200/60 p-3.5 transition-colors duration-200';
            }

            /*
            |--------------------------------------------------------------------------
            | ESCÁNER QR CON CÁMARA
            |--------------------------------------------------------------------------
            */
            function onScanSuccess(decodedText, decodedResult) {
                codigoInput.value = decodedText;
                qrFeedback.innerText = "✨ ¡Código QR detectado!";
                qrFeedback.className = "mt-2 text-center text-xs font-bold text-emerald-600";

                // Si ya se obtuvo la ubicación, envía el formulario automáticamente
                if (gpsObtenido) {
                    html5QrcodeScanner.clear();
                    form.submit();
                }
            }

            function onScanFailure(error) {
                // Errores continuos de búsqueda de frame (se ignoran para evitar ruido)
            }

            let html5QrcodeScanner = new Html5QrcodeScanner(
                "reader",
                { 
                    fps: 10, 
                    qrbox: { width: 220, height: 220 },
                    rememberLastUsedCamera: true
                },
                /* verbose= */ false
            );

            html5QrcodeScanner.render(onScanSuccess, onScanFailure);
            qrFeedback.innerText = "Apunta la cámara hacia el código QR de la clase.";
        });
    </script>
</x-app-layout>