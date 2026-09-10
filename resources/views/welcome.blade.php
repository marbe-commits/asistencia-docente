<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AsistenciaQR</title>

    @vite(['resources/css/app.css'])
    
    <style>
    html{
        scroll-behavior: smooth;
    }
</style>
</head>

<body style="background:#F8F5FF;" class="min-h-screen">

    <!-- NAVBAR -->
    <nav class="shadow-sm sticky top-0 z-50" 
    style="background:#FFFFFF;border-bottom:2px solid #D8B4FE;">

        <div class="max-w-7xl mx-auto px-10 py-5 flex justify-between items-center">

            <div class="flex items-center gap-4">

            <img
                src="{{ asset('imagenes/logo.png') }}"
                alt="Logo Asistencia QR"
                style="width:70px; height:70px; object-fit:contain;">
        
            <div>
                <h1 class="text-3xl font-bold" style="color:#4C1D95;">
                    Asistencia QR
                </h1>
        
                <p class="text-sm" style="color:#6B5B95;">
                    Plataforma Académica Inteligente
                </p>
            </div>
        
        </div>

            <a href="{{ route('login') }}" 
            style="background:#7E57C2; color:white;" 
            class="px-6 py-3 rounded-xl font-semibold transition">

                Iniciar sesión

            </a>

        </div>

    </nav>


    <!-- HERO -->
    <section class="max-w-7xl mx-auto px-10 py-24">

        <div class="grid lg:grid-cols-2 gap-20 items-center">

            <div>

                <h1 class="text-6xl font-black text-slate-900 leading-tight"
                style="color:#4A148C;">

                    Sistema Inteligente  
                    <br>
                    de Asistencia  
                    <br>
                    Académica QR

                </h1>

                <p class="text-gray-500 text-xl mt-8 leading-9"
                style="color:#6A1B9A;">

                    Plataforma desarrollada para automatizar el control de asistencia docente,
                    validar registros mediante código QR y generar reportes académicos institucionales.

                </p>

                <div class="mt-10 flex flex-wrap gap-4">

                    <a href="{{ route('login') }}" 
                    style="background:#7E57C2; color:white;" 
                    class="px-6 py-3 rounded-xl font-semibold transition">

                        Acceder al Sistema

                    </a>

                    <a href="#funciona" 
                    style="background:#7E57C2; color:white;" 
                    class="px-6 py-3 rounded-xl font-semibold transition">

                        Ver funcionamiento

                    </a>

                </div>

            </div>


                <!-- PANEL DERECHO -->
                <div>
                
                    <div class="rounded-3xl shadow-2xl p-10"
                         style="background:#FFFFFF;
                                border:2px solid #DDD6FE;
                                box-shadow:0 20px 45px rgba(124,58,237,.15);">
                
                        <h2 class="text-3xl font-bold text-center"
                            style="color:#4C1D95;">
                
                            AsistenciaQR
                
                        </h2>
                
                        <p class="text-center mt-3"
                           style="color:#6B5B95;">
                
                            Plataforma inteligente para el control de asistencia docente mediante
                            códigos QR y validación de ubicación en tiempo real.
                
                        </p>
                
                        <hr style="margin:25px 0;border:1px solid #E9D5FF;">
                
                        <div class="space-y-4">
                
                            <div style="background:#F5F3FF;
                                        color:#4C1D95;
                                        padding:16px;
                                        border-radius:14px;
                                        font-weight:600;">
                
                                📱 Registro mediante código QR
                
                            </div>
                
                            <div style="background:#F5F3FF;
                                        color:#4C1D95;
                                        padding:16px;
                                        border-radius:14px;
                                        font-weight:600;">
                
                                📍 Validación de ubicación GPS
                
                            </div>
                
                            <div style="background:#F5F3FF;
                                        color:#4C1D95;
                                        padding:16px;
                                        border-radius:14px;
                                        font-weight:600;">
                
                                📄 Generación automática de reportes PDF
                
                            </div>
                
                            <div style="background:#F5F3FF;
                                        color:#4C1D95;
                                        padding:16px;
                                        border-radius:14px;
                                        font-weight:600;">
                
                                🔒 Información protegida y segura
                
                            </div>
                
                        </div>
                
                        <div class="mt-8 p-5 rounded-2xl"
                             style="background:#7C3AED;color:white;">
                
                            <h3 class="text-xl font-bold">
                
                                Sistema Institucional
                
                            </h3>
                
                            <p class="mt-2 text-sm">
                
                                Diseñado para optimizar el registro de asistencia docente,
                                mejorar la seguridad y automatizar la generación de reportes.
                
                            </p>
                
                        </div>
                
                    </div>
                
                </div>

            </div>

        </div>

    </section>

<!-- COMO FUNCIONA -->
<section id="funciona" class="py-16" style="background:#F8F5FF;">

    <div class="max-w-6xl mx-auto px-8">

        <h2 class="text-4xl font-bold text-center" style="color:#4C1D95;">
            ¿Cómo funciona el sistema?
        </h2>

        <p class="text-center mt-3 mb-12"
           style="color:#6B5B95; font-size:17px;">

            El registro de asistencia se realiza en cinco sencillos pasos.

        </p>

        <div class="grid md:grid-cols-5 gap-4">

            <!-- Paso 1 -->
            <div class="text-center p-5 rounded-2xl"
                 style="background:white;
                        border:1px solid #DDD6FE;
                        box-shadow:0 8px 18px rgba(124,58,237,.08);">

                <div style="font-size:42px;">👨‍🏫</div>

                <h3 class="mt-3 font-bold" style="color:#4C1D95;">
                    Inicia sesión
                </h3>

                <p class="mt-2" style="font-size:14px;color:#6B5B95;">
                    Accede al sistema.
                </p>

            </div>

            <!-- Paso 2 -->
            <div class="text-center p-5 rounded-2xl"
                 style="background:white;
                        border:1px solid #DDD6FE;
                        box-shadow:0 8px 18px rgba(124,58,237,.08);">

                <div style="font-size:42px;">📱</div>

                <h3 class="mt-3 font-bold" style="color:#4C1D95;">
                    Escanea QR
                </h3>

                <p class="mt-2" style="font-size:14px;color:#6B5B95;">
                    Lee el código QR.
                </p>

            </div>

            <!-- Paso 3 -->
            <div class="text-center p-5 rounded-2xl"
                 style="background:white;
                        border:1px solid #DDD6FE;
                        box-shadow:0 8px 18px rgba(124,58,237,.08);">

                <div style="font-size:42px;">📍</div>

                <h3 class="mt-3 font-bold" style="color:#4C1D95;">
                    GPS
                </h3>

                <p class="mt-2" style="font-size:14px;color:#6B5B95;">
                    Se valida la ubicación.
                </p>

            </div>

            <!-- Paso 4 -->
            <div class="text-center p-5 rounded-2xl"
                 style="background:white;
                        border:1px solid #DDD6FE;
                        box-shadow:0 8px 18px rgba(124,58,237,.08);">

                <div style="font-size:42px;">✅</div>

                <h3 class="mt-3 font-bold" style="color:#4C1D95;">
                    Registro
                </h3>

                <p class="mt-2" style="font-size:14px;color:#6B5B95;">
                    Se guarda la asistencia.
                </p>

            </div>

            <!-- Paso 5 -->
            <div class="text-center p-5 rounded-2xl"
                 style="background:white;
                        border:1px solid #DDD6FE;
                        box-shadow:0 8px 18px rgba(124,58,237,.08);">

                <div style="font-size:42px;">📄</div>

                <h3 class="mt-3 font-bold" style="color:#4C1D95;">
                    Reportes
                </h3>

                <p class="mt-2" style="font-size:14px;color:#6B5B95;">
                    PDF y Excel.
                </p>

            </div>

        </div>

    </div>

</section>
</body>
</html>