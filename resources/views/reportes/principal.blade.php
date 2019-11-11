@extends('layouts.app')

@section('javascript')
<script src="{{ asset('js/reporte_principal.js') }}" defer></script>

@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
					Reportes por estado.
				</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
					@endif
                    <button type="button" id="btn-filtro-limpiar-busqueda" class="btn btn-primary btn-color float-right"><span class="oi oi-loop-circular"></span>&nbsp;Limpiar</button>
                    <div class="row">
                        <div class="col-md-5">

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text">Seleccione escuela:</label>
                                </div>
                                <select id="select-filtro-escuela" class="custom-select">
                                    <option value="0" selected disabled>Seleccionar escuela:</option>
                                    <option value="todas">Todas las escuelas</option>
                                </select>
                            </div>
        
                        <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text">Seleccione el estado.</label>
                                </div>
                                <select id="select-filtro-estado" class="custom-select">
                                    <option value="0" selected disabled>Seleccionar estado:</option>
                                    <option value="recien_ingresado">Recien ingresado</option>
                                    <option value="aprobado">Aprobado</option>
                                    <option value="oficializado">Oficializado</option>
                                    <option value="prorrogado">Prórrogado</option>
                                    <option value="extension_de_prorroga">Extensión de prórroga</option>
                                    <option value="prorroga_especial">Prórroga especial</option>
                                    <option value="abandonado">Abandonado</option>
                                    <option value="finalizado">Finalizado</option>
                                    <option value="deshabilitado">Deshabilitado</option>
                                   
                                </select>
                            </div>

                          
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text">¿Qué período desea?</label>
                                </div>
                                <select id="select-filtro-periodo" class="custom-select" onChange="periodoOnChange(this)">
                                    <option value="0" selected disabled>Seleccione un período</option>
                                    <option value="un_ciclo">Un ciclo</option>
                                    <option value="mas_ciclo">Más de un ciclo</option>
                                </select>
                            </div>
                        </div>   
                    </div>


                    <div class="col-md-5" id="select-un-ciclo" style="display:none;">
                    
                        <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text">Ciclo:</label>
                                </div>
                                <select id="select-filtro-ciclo" class="custom-select">
                                    <option value="0" selected disabled>Seleccione un ciclo</option>
                                    @foreach ($ciclos as $ciclo)
                                    <option value="{{ $ciclo->id}}">{{ $ciclo->ciclo}}</option>
                                    @endforeach
                                </select>
                        </div>
                    </div>

                    <div class="col-md-5" id="select-mas-ciclo" style="display:none;">
                    Seleccione período.
                        <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text">Ciclo inicio:</label>
                                </div>
                                <select id="select-filtro-cicloInicio" class="custom-select"> 
                                    <option value="0" selected disabled>Seleccione un ciclo</option>
                                    @foreach ($ciclos as $ciclo)
                                    <option value="{{ $ciclo->id}}">{{ $ciclo->ciclo}}</option>
                                    @endforeach
                                </select>
                        </div>
                        <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text">Ciclo fin:</label>
                                </div>
                                <select id="select-filtro-cicloFin" class="custom-select">
                                    <option value="0" selected disabled>Seleccione un ciclo</option>
                                    @foreach ($ciclos as $ciclo)
                                    <option value="{{ $ciclo->id}}">{{ $ciclo->ciclo}}</option>
                                    @endforeach
                                </select>
                        </div>

                    </div>

                    <div class="col-2 ">
                            <button class="btn btn-primary btn-color" id="generar-reporte" type="submit" role="button">
                                    <span class="oi oi-document"></span> Generar reporte
                                </button>
                    </div>


                
                </div>
            </div>
        </div>
    </div>
</div>
@endsection