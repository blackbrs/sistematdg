@extends('layouts.app')

@section('javascript')
<script src="{{ asset('js/script.js') }}" defer></script>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Bienvenido al sistema.</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <center> Ha ingresado al sistema de gestión de trabajos de graduación.</center>
                    <img src="img/home.png" class="img-thumbnail" alt="Responsive image">
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
<div class="text-center">
   
</div>
<br>
<br>

@endsection
