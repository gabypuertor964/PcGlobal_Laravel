{{-- Extender del layout principal --}}
@extends('adminlte::page')

{{-- Complemento titulo --}}
@section('title', 'Historial Facturacion')

{{-- Titulo principal --}}
@section('content_header')
    <div class="flex flex-col md:flex-row gap-y-2 justify-content-between align-items-center text-center">
        <h1 class="font-weight-bold font-italic">Historial de Facturacion</h1>
    </div>
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

    <div class="text-center">
        
        {{-- Visualizacion de mensajes --}}
        @include('components.alert')
        
        {{-- Tabla de datos --}}
        <table class="table table-striped table-bordered">
        
            {{-- Cabecera de la tabla --}}
            <thead>
                <tr>
                    <th class="hidden lg:table-cell">Fecha</th>
                    <th class="hidden lg:table-cell">Hora</th>
                    <th>Cliente</th>
                    <th>Valor Total</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            
            {{-- Cuerpo de la tabla --}}
            <tbody>
                @forelse ($facturations as $facturation)
                <tr>
                    <td class="align-middle hidden lg:table-cell">{{$facturation->datetime["date"]}}</td>
                    <td class="align-middle hidden lg:table-cell">{{$facturation->datetime["time"]}}</td>
                    <td class="align-middle">{{$facturation->client->fullName()}}</td>
                        <td class="align-middle">${{number_format($facturation->total, 0, ',', '.')}}</td>
                        <td class="align-middle">{{$facturation->state->name}}</td>
                        <td>
                            <div class="flex justify-center gap-2 w-full">

                                {{-- Boton Ver --}}
                                <div class="button-tooltip" data-tooltip="Ver factura">
                                    <a class="btn btn-primary" href="{{route('admin.facturation.show', $facturation->slug)}}" role="button">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                </div>
                                
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">Aun no se ha registrado ninguna transacción.</td>
                    </tr>
                @endforelse
            </tbody>

        </table>

        {{-- Paginacion --}}
        <div class="flex justify-center mb-3">{{ $facturations->links('pagination::tailwind') }}</div>
    </div>

@endsection