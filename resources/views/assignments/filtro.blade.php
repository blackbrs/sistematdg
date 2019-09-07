@extends('layouts.app')

@section('javascript')
<script src="{{ asset('js/filtro_tdg_asignaciones.js') }}" defer></script>
<link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
					Trabajos de graduación aprobados
				</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
					@endif
						
                    <br>
                    <div class="row">
                        <div class="col-md-1">
                            <button type="button" id="btn-filtro-limpiar-busqueda" class="btn btn-outline-dark">Limpiar Búsqueda</button>
                        </div>
                    </div>
                    <br>
                    @include('filtro_codigo_nombre')

                    <table id="table-filtro-tdgs" class="table table-striped">
                        <thead>
                            <tr>
                            <th scope="col">Código</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Asignar</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection