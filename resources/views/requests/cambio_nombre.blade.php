@extends('layouts.app')

@section('javascript')
<script src="{{ asset('') }}" defer></script>
<link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
					Ingresar solicitud de cambio de nombre
				</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
					@endif
						
                    <form class="form-horizontal" method="POST" action="{{ route('request_name.guardar') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="card">
                            <div class="card-body bg-light">
                               <p class="negrita">Nombre actual:</p> {{$tdgs->nombre}} 
                            </div>
                          </div>
                          <br>

                        <div class="row form-group{{ $errors->has('nuevo_nombre') ? ' has-error' : '' }}">
                            <label for="nuevo_nombre" class="textlabel col-md-3 offset-1 control-label required">Nuevo nombre</label>
                            <div class="col-md-6">
								<textarea id="nuevo_nombre" type="text" class="textarea form-control" name="nuevo_nombre" value="{{old('nuevo_nombre')}}" rows="10" cols="50" required autofocus></textarea>
                                @if ($errors->has('nuevo_nombre'))
                                    <span class="help-block">
                                       {{ $errors->first('nuevo_nombre') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="row form-group{{ $errors->has('justificacion') ? ' has-error' : '' }}">
                            <label for="justificacion" class="textlabel col-md-3 offset-1 control-label required">Justificación</label>
                            <div class="col-md-6">
								<textarea id="justificacion" type="text" class="textarea form-control" name="justificacion" value="{{old('justificacion')}}" rows="10" cols="50" required autofocus></textarea>
                                @if ($errors->has('justificacion'))
                                    <span class="help-block">
                                       {{ $errors->first('justificacion') }}
                                    </span>
                                @endif
                            </div>
                        </div>  
						
                        <div class="form-group{{ $errors->has('tdg_id') ? ' has-error' : '' }}">
                            <input type="hidden" name="tdg_id" value="{{$tdgs->id}}">
                        </div>

                        <div class="row form-group">
                            <div class="col-md-2 offset-4">
                                <button type="submit" class="btn btn-primary btn-color">
                                    Guardar solicitud
                                </button>
                            </div>
						</div>
						
                    </form>
                    
                </div>
                <div class="card-footer text-muted">
                    Todos los campos marcados con <span style="color:red">*</span> son obligatorios y deben ser llenados.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection