<x-app-layout>

    <x-slot name="header">

        <div class="flex justify-between items-center">

            <div>

                <h2 class="text-3xl font-bold text-purple-900">
                    Gestion de Aulas
                </h2>

                <p class="text-purple-700 mt-1">
                    Administracion de espacios academicos e infraestructura
                </p>

            </div>

            <div class="flex items-center gap-3 flex-wrap">

                <a href="{{ route('aulas.create') }}"
                   style="
                        background:#6d28d9;
                        color:#ffffff;
                        padding:12px 20px;
                        border-radius:12px;
                        font-weight:600;
                        box-shadow:0 10px 15px rgba(109,40,217,0.35);
                        text-decoration:none;
                        display:inline-block;
                   ">

                    + Nuevo Aula

                </a>


                <a href="{{ route('aulas.plantilla') }}"
                   style="
                        background:#7c3aed;
                        color:#ffffff;
                        padding:12px 20px;
                        border-radius:12px;
                        font-weight:600;
                        box-shadow:0 10px 15px rgba(124,58,237,0.30);
                        text-decoration:none;
                        display:inline-block;
                   ">

                     Descargar plantilla

                </a>


                <form action="{{ route('aulas.importar') }}"
                      method="POST"
                      enctype="multipart/form-data"
                      style="margin:0;">

                    @csrf

                    <input
                        type="file"
                        name="archivo"
                        id="archivoAulas"
                        accept=".csv,.txt"
                        style="display:none;"
                        onchange="this.form.submit();"
                    >

                    <label
                        for="archivoAulas"
                        style="
                            background:#5b21b6;
                            color:#ffffff;
                            padding:12px 20px;
                            border-radius:12px;
                            font-weight:600;
                            box-shadow:0 10px 15px rgba(91,33,182,0.30);
                            cursor:pointer;
                            display:inline-block;
                        ">

                         Importar aulas

                    </label>

                </form>

            </div>

        </div>

    </x-slot>


    <div class="py-8">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">


            @if(session('success'))

                <div style="
                    background:#ede9fe;
                    color:#5b21b6;
                    padding:15px 20px;
                    border-radius:12px;
                    margin-bottom:20px;
                    font-weight:600;
                ">

                    {{ session('success') }}

                </div>

            @endif


            @if(session('error'))

                <div style="
                    background:#fee2e2;
                    color:#991b1b;
                    padding:15px 20px;
                    border-radius:12px;
                    margin-bottom:20px;
                    font-weight:600;
                ">

                    {{ session('error') }}

                </div>

            @endif


            @if($errors->any())

                <div style="
                    background:#fee2e2;
                    color:#991b1b;
                    padding:15px 20px;
                    border-radius:12px;
                    margin-bottom:20px;
                ">

                    <strong>Se encontraron errores</strong>

                    <ul style="margin-top:8px; padding-left:20px;">

                        @foreach($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif


            <div style="
                background:#ffffff;
                border-radius:16px;
                padding:20px;
                margin-bottom:24px;
                box-shadow:0 8px 20px rgba(109,40,217,0.12);
                display:flex;
                gap:12px;
                align-items:center;
            ">

                <input
                    type="text"
                    id="buscarAula"
                    placeholder="Buscar aula"
                    style="
                        flex:1;
                        padding:12px 15px;
                        border:1px solid #c4b5fd;
                        border-radius:12px;
                        outline:none;
                        color:#374151;
                        background:#ffffff;
                    "
                >

                <button
                    type="button"
                    onclick="buscarAula()"
                    style="
                        background:#6d28d9;
                        color:white;
                        border:none;
                        padding:12px 18px;
                        border-radius:12px;
                        cursor:pointer;
                        font-weight:600;
                        box-shadow:0 5px 12px rgba(109,40,217,0.25);
                    ">

                    Buscar

                </button>

            </div>


            <div class="mb-6 grid md:grid-cols-3 gap-5">


                <div style="
                    background:#6d28d9;
                    color:white;
                    padding:20px;
                    border-radius:16px;
                    box-shadow:0 10px 20px rgba(109,40,217,0.25);
                ">

                    <p>
                        Total Aulas
                    </p>

                    <h3 class="text-3xl font-bold mt-2">

                        {{ count($aulas) }}

                    </h3>

                </div>


                <div style="
                    background:#5b21b6;
                    color:white;
                    padding:20px;
                    border-radius:16px;
                    box-shadow:0 10px 20px rgba(91,33,182,0.25);
                ">

                    <p>
                        Capacidad Total
                    </p>

                    <h3 class="text-3xl font-bold mt-2">

                        {{ $aulas->sum('capacidad') }}

                    </h3>

                </div>


                <div style="
                    background:#7c3aed;
                    color:white;
                    padding:20px;
                    border-radius:16px;
                    box-shadow:0 10px 20px rgba(124,58,237,0.25);
                ">

                    <p>
                        Aulas Activas
                    </p>

                    <h3 class="text-3xl font-bold mt-2">

                        {{ $aulas->where('activa',1)->count() }}

                    </h3>

                </div>

            </div>


            <div style="
                background:#ffffff;
                border-radius:18px;
                box-shadow:0 10px 25px rgba(109,40,217,0.15);
                overflow:hidden;
            ">

                <div style="
                    padding:20px;
                    border-bottom:2px solid #7c3aed;
                ">

                    <h3 style="
                        font-size:20px;
                        font-weight:bold;
                        color:#5b21b6;
                    ">

                        Aulas Registradas

                    </h3>

                </div>


                <div style="overflow-x:auto;">

                    <table class="w-full">

                        <thead style="
                            background:#6d28d9;
                            color:#ffffff;
                        ">

                            <tr>

                                <th class="p-4 text-left">
                                    ID
                                </th>

                                <th class="p-4 text-left">
                                    Nombre
                                </th>

                                <th class="p-4 text-left">
                                    Edificio
                                </th>

                                <th class="p-4 text-left">
                                    Capacidad
                                </th>

                                <th class="p-4 text-left">
                                    Estado
                                </th>

                                <th class="p-4 text-center">
                                    Acciones
                                </th>

                            </tr>

                        </thead>


                        <tbody id="tablaAulas">

                            @forelse($aulas as $aula)

                                <tr
                                    class="fila-aula"
                                    style="
                                        border-bottom:1px solid #ddd6fe;
                                        transition:0.2s;
                                    "
                                    onmouseover="this.style.background='#ede9fe'"
                                    onmouseout="this.style.background='white'"
                                >

                                    <td class="p-4">
                                        {{ $aula->id }}
                                    </td>


                                    <td
                                        class="p-4"
                                        style="
                                            font-weight:600;
                                            color:#6d28d9;
                                        "
                                    >

                                        {{ $aula->nombre }}

                                    </td>


                                    <td class="p-4">

                                        {{ $aula->edificio }}

                                    </td>


                                    <td class="p-4">

                                        <span style="
                                            background:#ddd6fe;
                                            color:#5b21b6;
                                            padding:4px 10px;
                                            border-radius:9999px;
                                            font-weight:600;
                                        ">

                                            {{ $aula->capacidad }} alumnos

                                        </span>

                                    </td>


                                    <td class="p-4">

                                        @if($aula->activa)

                                            <span style="
                                                background:#c4b5fd;
                                                color:#4c1d95;
                                                padding:4px 10px;
                                                border-radius:9999px;
                                                font-weight:600;
                                            ">

                                                Activa

                                            </span>

                                        @else

                                            <span style="
                                                background:#a78bfa;
                                                color:#ffffff;
                                                padding:4px 10px;
                                                border-radius:9999px;
                                                font-weight:600;
                                            ">

                                                Inactiva

                                            </span>

                                        @endif

                                    </td>


                                    <td class="p-4 text-center">

                                        <div class="flex justify-center gap-3">


                                            <a
                                                href="{{ route('aulas.edit', $aula) }}"
                                                style="
                                                    background:#8b5cf6;
                                                    color:white;
                                                    padding:8px 14px;
                                                    border-radius:10px;
                                                    text-decoration:none;
                                                    font-weight:600;
                                                "
                                            >

                                                Editar

                                            </a>


                                            <form
                                                action="{{ route('aulas.destroy', $aula) }}"
                                                method="POST"
                                                style="display:inline;"
                                            >

                                                @csrf

                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    onclick="return confirm('Eliminar aula')"
                                                    style="
                                                        background:#5b21b6;
                                                        color:white;
                                                        padding:8px 14px;
                                                        border-radius:10px;
                                                        border:none;
                                                        cursor:pointer;
                                                        font-weight:600;
                                                    "
                                                >

                                                    Eliminar

                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="6"
                                        style="
                                            text-align:center;
                                            padding:40px;
                                            color:#6d28d9;
                                        "
                                    >

                                        No hay aulas registradas

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>


    <script>

        function buscarAula() {

            let texto = document
                .getElementById('buscarAula')
                .value
                .toLowerCase()
                .trim();

            let filas = document.querySelectorAll('.fila-aula');

            filas.forEach(function(fila) {

                let contenido = fila.textContent.toLowerCase();

                if (contenido.includes(texto)) {

                    fila.style.display = '';

                } else {

                    fila.style.display = 'none';

                }

            });

        }


        document
            .getElementById('buscarAula')
            .addEventListener('keyup', function(event) {

                if (event.key === 'Enter') {

                    buscarAula();

                }

            });

    </script>

</x-app-layout>
