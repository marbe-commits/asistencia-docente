<x-app-layout>

<x-slot name="header">
    <h2 class="text-2xl font-bold text-slate-800">
        Registrar Nuevo Docente
    </h2>
</x-slot>

<div class="py-8">

<div class="max-w-5xl mx-auto">

<div class="bg-white rounded-2xl shadow-xl border overflow-hidden">

<div class="p-6" style="background: linear-gradient(to right, #7C3AED, #5B21B6);">

    <h3 class="text-2xl font-bold text-white">
        Información del Docente
    </h3>

    <p class="mt-1" style="color:#E9D5FF;">
        Complete los datos del profesor
    </p>

</div>

</div>

<div class="p-8">

<form action="{{ route('docentes.store') }}" method="POST">

@csrf

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

<!-- NUMERO -->

<div>

<label class="block font-semibold mb-2">
Número de Empleado
</label>

<input
type="text"
name="numero_empleado"
value="{{ old('numero_empleado') }}"
placeholder="Se genera automático"
class="w-full rounded-xl border-gray-300">

@error('numero_empleado')
<p class="text-red-500 text-sm">{{ $message }}</p>
@enderror

</div>

<!-- NOMBRE -->

<div>

<label class="block font-semibold mb-2">
Nombre
</label>

<input
type="text"
name="nombre"
value="{{ old('nombre') }}"
class="w-full rounded-xl border-gray-300"
required>

@error('nombre')
<p class="text-red-500 text-sm">{{ $message }}</p>
@enderror

</div>

<!-- AP PATERNO -->

<div>

<label class="block font-semibold mb-2">
Apellido Paterno
</label>

<input
type="text"
name="apellido_paterno"
value="{{ old('apellido_paterno') }}"
class="w-full rounded-xl border-gray-300"
required>

@error('apellido_paterno')
<p class="text-red-500 text-sm">{{ $message }}</p>
@enderror

</div>

<!-- AP MATERNO -->

<div>

<label class="block font-semibold mb-2">
Apellido Materno
</label>

<input
type="text"
name="apellido_materno"
value="{{ old('apellido_materno') }}"
class="w-full rounded-xl border-gray-300"
required>

@error('apellido_materno')
<p class="text-red-500 text-sm">{{ $message }}</p>
@enderror

</div>

<!-- CORREO -->

<div>

<label class="block font-semibold mb-2">
Correo
</label>

<input
type="email"
name="correo"
value="{{ old('correo') }}"
class="w-full rounded-xl border-gray-300"
required>

@error('correo')
<p class="text-red-500 text-sm">{{ $message }}</p>
@enderror

</div>

<!-- TELEFONO -->

<div>

<label class="block font-semibold mb-2">
Teléfono
</label>

<input
type="tel"
name="telefono"
maxlength="10"
oninput="this.value=this.value.replace(/[^0-9]/g,'')"
placeholder="10 dígitos"
class="w-full rounded-xl border-gray-300">

@error('telefono')
<p class="text-red-500 text-sm">{{ $message }}</p>
@enderror

</div>

</div>

<div class="mt-10 flex gap-4">

<button
type="submit"
class="bg-green-600 text-white px-6 py-3 rounded-xl">

Guardar Docente

</button>

<a
href="{{ route('docentes.index') }}"
class="bg-gray-500 text-white px-6 py-3 rounded-xl">

Cancelar

</a>

</div>

</form>

</div>
</div>
</div>
</div>

</x-app-layout>