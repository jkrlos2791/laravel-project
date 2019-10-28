@extends('layouts.app')

@section('content')

    <div class="container-fluid">

	        <div class="row bg-title">
            <!-- .page title -->
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">{{ $pageTitle }}</h4> </div>
            <!-- /.page title -->
			 <!-- .breadcrumb -->
			 
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12"> 
			    <div class="box-header-tools pull-right" >
	  <a href="{{ url('dashboard?return='.$return) }}" class="tips btn btn-xs btn-warning btn-sm btn-circle"><i class="fa  fa-arrow-left"></i></a>
	</div>
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
                                    <a href="{{ URL::to('planillageneracion') }}">
                                        <span class="circle circle-md bg-danger"><i class="ti-plus"></i></span>
                                    </a>    
                                </li>
                                <li >
                                    <h4>Planilla</h4>
                                    <p> Planilla general del periodo</p>
                                    
                                </li>
                            </ul>
		</div>		
		<div class="col-lg-4 col-sm-6 row-in-br">
			 <ul class="col-in">
                                <li>
                                    <a href="{{ URL::to('editable') }}">
                                        <span class="circle circle-md bg-danger"><i class="ti-plus"></i></span>
                                    </a>    
                                </li>
                                <li >
                                    <h4>{{ Lang::get('core.conceptos_editables') }}</h4>
                                    <p> {{ Lang::get('core.conceptos_editables_info') }}</p>
                                    
                                </li>
                            </ul>
		</div>
		<div class="col-lg-4 col-sm-6 b-0">
			 <ul class="col-in">
                                <li>
                                    <a href="{{ URL::to('otrosconceptos') }}">
                                        <span class="circle circle-md bg-danger"><i class="ti-plus"></i></span>
                                    </a>    
                                </li>
                                <li >
                                    <h4>{{ Lang::get('core.otrosconceptos') }}</h4>
                                    <p> {{ Lang::get('core.otrosconceptos_info') }}</p>
                                    
                                </li>
                            </ul>
		</div>
	</div>
	<legend></legend>
	<div class="row row-in"  >
				<div class="col-lg-4 col-sm-6 row-in-br">
			 <ul class="col-in">
                                <li>
                                    <a href="{{ URL::to('periodo') }}">
                                        <span class="circle circle-md bg-danger"><i class="ti-plus"></i></span>
                                    </a>    
                                </li>
                                <li >
                                    <h4>{{ Lang::get('core.periodos') }}</h4>
                                    <p> {{ Lang::get('core.periodos_info') }}</p>
                                    
                                </li>
                            </ul>
		</div>
		<div class="col-lg-4 col-sm-6 row-in-br">
			 <ul class="col-in">
                                <li>
                                    <a href="{{ URL::to('gratificacion') }}">
                                        <span class="circle circle-md bg-danger"><i class="ti-plus"></i></span>
                                    </a>    
                                </li>
                                <li >
                                    <h4> Gratificación </h4>
                                    <p> Planilla de gratificaciones </p>
                                    
                                </li>
                            </ul>
		</div>
				<div class="col-lg-4 col-sm-6 b-0">
			 <ul class="col-in">
                                <li>
                                    <a href="{{ URL::to('rentaquinta/update') }}">
                                        <span class="circle circle-md bg-danger"><i class="ti-plus"></i></span>
                                    </a>    
                                </li>
                                <li >
                                    <h4>Retención de 5ta</h4>
                                    <p> Cálculo de rentención del periodo</p>
                                    
                                </li>
                            </ul>
		</div>
		</div>
<legend></legend>
	<div class="row row-in"  >
					<div class="col-lg-4 col-sm-6 row-in-br">
			 <ul class="col-in">
                                <li>
                                    <a href="{{ URL::to('liquidacion') }}">
                                        <span class="circle circle-md bg-danger"><i class="ti-plus"></i></span>
                                    </a>    
                                </li>
                                <li >
                                    <h4>Liquidaciones</h4>
                                    <p> Liquidaciones por periodo</p>
                                    
                                </li>
                            </ul>
		</div>
				<div class="col-lg-4 col-sm-6 row-in-br">
			 <ul class="col-in">
                                <li>
                                    <a href="{{ URL::to('archivos_generacion') }}">
                                        <span class="circle circle-md bg-danger"><i class="ti-plus"></i></span>
                                    </a>    
                                </li>
                                <li >
                                    <h4> Generación de Archivos </h4>
                                    <p> Generación de archivos Plame y AFP </p>
                                    
                                </li>
                            </ul>
		</div>
	</div>
</div>  
</div>
	 
</div>
@stop