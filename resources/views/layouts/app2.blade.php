<!DOCTYPE html> 
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> {{ CNF_APPNAME }} </title>
    <link rel="shortcut icon" href="{{ asset('favicon.ico')}}" type="image/x-icon">	
	<link href="{{ asset('jl/bootstrap4/css/bootstrap.min.css')}}" rel="stylesheet">
	<link href="{{ asset('jl/datatables/datatables.min.css')}}" rel="stylesheet"> 
	<link href="{{ asset('jl/jqueryui/jquery-ui-themes-1.12.1/themes/base/jquery-ui.css')}}" rel="stylesheet"> 
	<link href="{{ asset('jl/select24/select2-4.0.6-rc.1/dist/css/select2.min.css')}}" rel="stylesheet">
	<link href="{{ asset('jl/fontawesome5/fontawesome-all.min.css')}}" rel="stylesheet">
	<link href="{{ asset('jl/core/styles/estilo1.css')}}" rel="stylesheet">
	<link href="{{ asset('jl/pace/pace-theme-loading-bar.css')}}" rel="stylesheet">
	<link href="{{ asset('jl/dropzone/dropzone.min.css')}}" rel="stylesheet">	
	<script type="text/javascript" src="{{ asset('jl/jquery3/jquery-3.3.1.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('jl/bootstrap4/js/bootstrap.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('jl/datatables/datatables.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('jl/jqueryui/jquery-ui-1.12.1/jquery-ui.js') }}"></script>
	<script type="text/javascript" src="{{ asset('jl/select24/select2-4.0.6-rc.1/dist/js/select2.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('jl/sweetalert/sweetalert.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('jl/maskmoney/jquery.maskMoney.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('jl/accounting/accounting.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('jl/pace/pace.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('jl/dropzone/dropzone.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('jl/chart/Chart.js') }}"></script>
	<style>
		.flotante {
			display:scroll;
			position:fixed;
			bottom:300px;
			right:0px;
			z-index:1;
		}		
		#contents {
			display: none;
		}
	</style>
</head>
<body>
	<div id="contents">
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-dark">
        <a class="navbar-brand" href="#">JL planilla</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
				@if(Session::get('periodo_id'))
                	<li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdownEmpleados" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-clipboard-list"></i> Planilla
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ url('planillageneracion') }}"><i class="fas fa-eye"></i> Mostrar </a>
                            <a id="calcularPlanilla" class="dropdown-item" href="javascript:void(0)"><i class="fas fa-calculator"></i> Calcular </a>
                        </div>
                    </li>
                    <li class="nav-item">
    					<a class="nav-link" href="{{ url('editable') }}"><i class="fas fa-arrows-alt-v"></i> Conceptos y Afectaciones</a>
                    </li>
				@endif
                @if(Session::get('empresa'))
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdownEmpleados" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-users"></i> Empleados
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a id="buscarEmpleado" class="dropdown-item" href="javascript:void(0)"><i class="fas fa-search"></i> Buscar </a>
                            <a id="nuevoEmpleado" class="dropdown-item" href="javascript:void(0)"><i class="fas fa-plus-square"></i> Nuevo </a>
                        </div>
                    </li>
				@endif
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdownEmpresas" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-building"></i> Empresas
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a id="buscarEmpresa" class="dropdown-item" href="javascript:void(0)"><i class="fas fa-search"></i> Buscar </a>
                        <a id="nuevoEmpresa" class="dropdown-item" href="javascript:void(0)"><i class="fas fa-plus-square"></i> Nuevo </a>
                    </div>
                </li>
            </ul>
            <div class="dropdown">
                <button class="btn btn-success my-2 my-sm-0" type="button" id="entrarEmpresa" aria-haspopup="true" aria-expanded="false">
    				@if(Session::get('empresa'))
    					{{ Session::get('empresa') }} - {{ Session::get('mes') }} {{ Session::get('anio') }} 
    				@else
    				    Iniciar empresa
    				@endif
    			</button>
            </div>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user"></i> Bienvenido, <b>{{ Session::get('fid')}} </b> 
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ URL::to('configuracion')}}"><i class="fas fa-cogs"></i>  Configuracion </a>
                        <a class="dropdown-item" href="http://planilla.asecoint.com.pe/uploads/formatos/Manual.pdf" target="_blank"><i class="fas fa-file-pdf"></i> 
                        Manual </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ URL::to('user/logout')}}"><i class="fas fa-sign-out-alt"></i> {{ Lang::get('core.m_logout') }}</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <main role="main" class="container-fluid">
        <input id="hiddenEmpresa" name="hiddenEmpresa" type="hidden" value="{{ Session::get('empresa') }}" />
        <input id="hiddenPeriodo" name="hiddenPeriodo" type="hidden" value="{{ Session::get('periodo_id') }}" />
        @yield('content')	
    </main>
	@include('empleado/form2')
	@include('empresa/form2')
	@include('empresa/formingreso')
	@include('planillageneracion/formcalculo')
	</div>
	<script type="text/javascript" src="{{ asset('jl/core/app.js') }}"></script>	
</body> 
</html>