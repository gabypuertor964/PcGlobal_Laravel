{{-- Extender del layout principal --}}
@extends('adminlte::page')

{{-- Complemento titulo --}}
@section('title', 'Editar PQRS')

{{-- Titulo principal --}}
@section('content_header')
    <h1 class="text-center font-weight-bold font-italic">Ver PQRS</h1>
@stop

{{-- Declaración de dependencias adicionales --}}
@section('adminlte_css_pre')
    @vite([
        'resources/css/tailwind.css',
        'resources/js/font-awesome.js',
        'resources/css/admin.css'
    ])  
@endsection

{{-- Contenido principal --}}
@section('content')

    {{-- Visualizacion de errores --}}
    @include('components.alert')
    {{-- Card de la factura --}}
    <div class="bg-white shadow-md invoice-card">
        {{-- Título: Información básica --}}
        <p class="text-lg text-center border-b w-fit mx-auto mt-3">Información básica</p>

        {{-- Apartado: Información básica --}}
        <div class="invoice-card-content basics">
            <ul class="list-none">
                {{-- Título --}}
                <li>
                    <span class="font-semibold">Título: </span> 
                    {{$pqrs->title}}
                </li>
                
                {{-- Típo de PQRS --}}
                <li>
                    <span class="font-semibold">Típo de PQRS: </span> 
                    {{$pqrs->type->name}}
                </li>

                {{-- Fecha y hora --}}
                <li>
                    <span class="font-semibold">Fecha y hora: </span> 
                    @if ($pqrs->date_ocurrence === null)
                        N/A
                    @else
                        {{$pqrs->date_ocurrence}}
                    @endif
                </li>

                {{-- Estado --}}
                <li>
                    <span class="font-semibold">Estado: </span> 
                    {{$pqrs->state->name}}
                </li>
            </ul>
        </div>

        {{-- Título: Información básica --}}
        <p class="text-lg text-center border-b w-fit mx-auto mt-3">Más información</p>

        {{-- Apartado: Información del cliente --}}
        <div class="invoice-card-content basics grid grid-cols-1 lg:grid-cols-3 text-center">

            
            {{-- Nombres del cliente --}}
            <p class="flex flex-col">
                <span class="font-semibold">Nombres del cliente:</span> 
                {{$pqrs->client->fullName()}}
            </p>

            {{-- Descripción de la PQRS --}}
            <p class="flex flex-col">
                <span class="font-semibold">Descripción</span> 
                {{$pqrs->description}}
            </p>

            @if($pqrs->worker === null)
                {{-- Nombres del trabajador --}}
                <p class="flex flex-col">
                    <span class="font-semibold">Nombres del empleado que respondió:</span> 
                    <span class="font-semibold">N/A</span>
                    (La PQRS aún no ha sido respondida) 
                </p>
            @else
                {{-- Nombres del trabajador --}}
                <p class="flex flex-col">
                    <span class="font-semibold">Nombres del empleado que respondió:</span> 
                    {{$pqrs->client->fullName()}}
                </p>
            @endif
            
        </div>        

        {{-- Título: Detalles --}}
        <p class="text-lg text-center border-b w-fit mx-auto mt-3">Respuesta</p>

        {{-- Apartado: Respuesta del empleado --}}
        <div class="invoice-card-content basics ">
            <form action="{{route("admin.pqrs.update", $pqrs->slug)}}" method="post">
                {{-- Tóken CSRF --}}
                @csrf
                
                {{-- Método --}}
                @method("PUT")

                <div class="mb-3">
                    <label for="response">Descripción</label>
                    <textarea placeholder="A continuación escribe la respuesta para el caso..." class="form-control" name="response" rows="8" maxlength="500" minlength="1" required></textarea>
                </div>

                {{-- Botones del formulario --}}
                <div class="text-center mt-3">
                    {{-- Boton: Guardar --}}
                    <div class="button-tooltip w-1/3 lg:w-1/4" data-tooltip="Confirmar actualización">
                        <button type="submit" class="btn btn-success col-12">
                            <i class="fa-solid fa-check"></i>
                        </button>
                    </div>
        
                    {{-- Boton: Cancelar --}}
                    <div class="button-tooltip w-1/3 lg:w-1/4" data-tooltip="Cancelar actualización">
                        <a class="btn btn-danger col-12" href="{{route("admin.pqrs.index")}}" role="button">
                            <i class="fa-solid fa-plus fa-rotate-by" style="--fa-rotate-angle: 45deg;"></i>
                        </a>
                    </div>
                </div>

            </form>
        </div>

    </div>
    
@endsection