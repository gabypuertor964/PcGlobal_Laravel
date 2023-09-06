@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <p>Panel Administrador</p>

    <form action="{{route("logout")}}" method="post">
        @csrf
        
        <button type="submit" class="btn btn-primary">Cerrar Sesion</button>
      </form>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop