@extends('layouts.app')

@section('content')

    <div class="container-fluid">

	        <div class="row bg-title">
            <!-- .page title -->
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Inicio</h4> </div>
            <!-- /.page title -->
			 <!-- .breadcrumb -->			 
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12"> 
            </div>
            <!-- /.breadcrumb -->
        </div>

<!-- .row -->
        <div class="row">		
		<div class="white-box"> 
	<div class="row row-in"  >

						<div class="col-lg-4 col-sm-6 row-in-br">
			 <ul class="col-in">
                                <li>
                                    <a href="{{ URL::to('empresa/update') }}">
                                        <span class="circle circle-md bg-danger"><i class="ti-plus"></i></span>
                                    </a>    
                                </li>
                                <li >
                                    <h4>Acceso</h4>
                                    <p> Acceder Empresa</p>
                                    
                                </li>
                            </ul>
		</div>		
		<div class="col-lg-4 col-sm-6 row-in-br">
			 <ul class="col-in">
                                <li>
                                    <a href="{{ URL::to('importacion_datos') }}">
                                        <span class="circle circle-md bg-danger"><i class="ti-plus"></i></span>
                                    </a>    
                                </li>
                                <li >
                                    <h4>Importación</h4>
                                    <p> Importar Empleados, Subsidios y Conceptos</p>
                                    
                                </li>
                            </ul>
		</div>
	</div>
</div>  
</div>
	 
</div>
@stop