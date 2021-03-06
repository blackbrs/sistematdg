<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>TDG-FIA</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/sweetalert2.js') }}" defer></script>
    <script src="{{ asset('lib/jquery-ui/jquery-ui.js') }}" defer></script>
    <script src="{{ asset('lib/DataTables/datatables.js') }}" defer></script>
    @yield('javascript')

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/estilos.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/jquery-ui/jquery-ui.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/DataTables/datatables.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/open-iconic/font/css/open-iconic-bootstrap.css') }}" rel="stylesheet">

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/home') }}">FIA</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>


                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    @can('tdg.ingresar')
                      <li class="nav-item navegacion-item">
                        <a class="nav-link" href="{{ url('/ingresar/tdg') }}"> Ingresar perfil</a>
                      </li>
                    @endcan

                  @can('student.ingresar')
                    <li class="nav-item navegacion-item">
                      <a class="nav-link" href="{{ url('/todos/estudiantes/sistema') }}"> Estudiantes</a>
                    </li>
                  @endcan
                  @can('professor.ingresar')
                    <li class="nav-item navegacion-item">
                      <a class="nav-link" href="{{ url('/todos/profesores/sistema') }}"> Docentes</a>
                    </li>
                  @endcan
                  @can('ratificar.listar')
                  <li class="nav-item navegacion-item">
                    <a class="nav-link" href="{{ url('/listar/tdg/ratificacion') }}">Resolución de solicitudes</a>
                  </li>
                  @endcan
                  @can('solicitudes.listar')
                  <li class="nav-item navegacion-item">
                    <a class="nav-link" href="{{ url('/listar/tdg/solicitudes') }}"> Solicitudes</a>
                  </li>
                  @endcan
                  @can('assignments.filtro')
                  <li class="nav-item navegacion-item">
                    <a class="nav-link" href="{{ url('/listar/tdg/asignar') }}"> Asignar grupo</a>
                  </li>
                  @endcan
                  @can('tdg.filtroGestionarEscuela')
                  <li class="nav-item navegacion-item">
                    <a class="nav-link" href="{{ url('/listar/tdg/gestionar/escuela') }}"> Gestionar TDG</a>
                  </li>
                  @endcan

                  @can('tdg.filtroGestionarGeneral')
                  <li class="nav-item navegacion-item">
                    <a class="nav-link" href="{{ url('/listar/tdg/gestionar/general') }}">Ver detalles</a>
                  </li>
                  @endcan
                   @can('request.filtroVerSolicitudesGeneral')
                  <li class="nav-item navegacion-item">
                    <a class="nav-link" href="{{ url('/listar/ver/solicitudes/general') }}">Ver solicitudes</a>
                  </li>
                  @endcan
                  @can('request.filtroVerSolicitudesEscuela')
                  <li class="nav-item navegacion-item">
                    <a class="nav-link" href="{{ url('/listar/ver/solicitudes/escuela') }}"> Ver solicitudes</a>
                  </li>
                  @endcan
                  @can('agreement.listar_acuerdos')
                  <li class="nav-item navegacion-item">
                    <a class="nav-link" href="{{ url('/listar/acuerdos/jd') }}">Acuerdos</a>
                  </li>
                  @endcan
                  @can('tdg.filtroTdgEditar')
                  <li class="nav-item navegacion-item">
                    <a class="nav-link" href="{{ url('/listar/tdg/editar') }}">Edición</a>
                  </li>
                  @endcan
                  @can('mail.create')
                   <li class="nav-item navegacion-item">
                    <a class="nav-link" href="{{ url('/correo/crear') }}">Correo</a>
                  </li>
                  @endcan
                  @can('reporte.principal')
                  <li class="nav-item navegacion-item">
                    <a class="nav-link" href="{{ url('/reporte/principal') }}">Reportes</a>
                  </li>
                  @endcan

                  @can('reporte.principal_escuela')
                  <li class="nav-item navegacion-item">
                    <a class="nav-link" href="{{ url('/reporte/principal/escuela') }}">Reportes</a>
                  </li>
                  @endcan

                  @can('menu')
                  <li class="nav-item dropdown ">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle navegacion-item" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        <span class="caret">Administración</span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        @can('month.show')
                        <a class="dropdown-item cerrar-sesion-color" href="{{ url('/listar/prorroga') }}">Editar prórrogas</a>
                        @endcan
                        @can('user.index')
                        <a class="dropdown-item cerrar-sesion-color" href="{{ url('/todos/usuarios/sistema') }}">Gestionar usuarios</a>
                        @endcan
                        @can('semester.ingresar')
                        <a class="dropdown-item cerrar-sesion-color" href="{{ url('/ingresar/ciclo') }}">Ciclos</a>
                        @endcan

                    </div>
                </li>
                @endcan

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item navegacion-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Iniciar sesión') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <!--<li class="nav-item">
                                 <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>-->
                            @endif
                        @else

                            <li class="nav-item dropdown ">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle navegacion-item" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->nombre }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item cerrar-sesion-color" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Cerrar sesión
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>

                                    <a class="dropdown-item cerrar-sesion-color" href="{{ url('/ayuda') }}"> Ayuda</a>
                                </div>




                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
