@extends('layouts.app')

@section('javascript')

<link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
					Editar nombre del trabajo de graduación.
				</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
					@endif
						
                    <form class="form-horizontal" method="POST" action="{{ route('tdg.guardarNombre') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="card">
                            <div class="card-body bg-light">
                               <p class="negrita">Nombre actual:</p> {{$tdgs->nombre}} 
                            </div>
                          </div>
                          <br>

                        <div class="row form-group{{ $errors->has('nombre_nuevo') ? ' has-error' : '' }}">
                            <label for="nombre_nuevo" class="textlabel col-md-3 offset-1 control-label required">Nuevo nombre</label>
                            <div class="col-md-6">
								<textarea id="nombre_nuevo" type="text" class="textarea form-control" name="nombre_nuevo" value="{{old('nombre_nuevo')}}" rows="10" cols="50" required autofocus></textarea>
                                @if ($errors->has('nombre_nuevo'))
                                    <span class="help-block">
                                       {{ $errors->first('nombre_nuevo') }}
                                    </span>
                                @endif
                            </div>
                        </div>

						
                        <div class="form-group{{ $errors->has('tdg_id') ? ' has-error' : '' }}">
                            <input type="hidden" name="tdg_id" value="{{$tdgs->id}}">
                        </div>

                        <div class="row form-group">
                        <div class="col-2 offset-4">
                            <a class="btn btn-danger" href="/listar/tdg/editar" role="button">
                                Cancelar
                            </a>
                        </div>
                        <div class="col-2 ">
                        <button class="btn btn-primary btn-color" type="submit" role="button">
                                <span class="oi oi-document"></span> Guardar
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