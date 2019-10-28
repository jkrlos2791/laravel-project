@extends('layouts.app')

@section('content')

    <div class="container-fluid">

	        <div class="row bg-title">
            <!-- .page title -->
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">{{ $pageTitle }} @if($access['is_add'] ==1)
	   		<a href="{{ URL::to('empleado/update?return='.$return) }}" class="tips btn btn-xs btn-success btn-sm btn-circle"  title="">
			<i class="fa  fa-plus "></i></a>
			@endif 
			</h4> </div>
            <!-- /.page title -->
			 <!-- .breadcrumb -->
			 
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12"> 
			    <div class="box-header-tools pull-right" >
	  <a href="{{ url('empleado?return='.$return) }}" class="tips btn btn-xs btn-warning btn-sm btn-circle"><i class="fa  fa-arrow-left"></i></a>
	</div>
            </div>
            <!-- /.breadcrumb -->
        </div>

<!-- .row -->
        <div class="row">
		
		<div class="white-box"> 
			<div class="row row-in"  >

		<div class="form-group  " >
		 <label for="Empleado" class="col-md-2 "> Seleccione nombres o DNI </label>
		 <div class="col-md-7">
		        {!! Form::model($row, ['route' => ['empleado.buscar']] ) !!}
                                    {!!  Form::select('id_trabajador', $empleado,null,['class'=>'select2' ])  !!}
		 </div> 
		 <div class="col-md-3">
				<button class="btn btn-primary btn-xs" type="submit" > <i class=""></i>
			    <span class="fa fa-search"></span>Buscar</button>
				{!! Form::close() !!}
		 </div>
		</div>
	
    </div>	
		</div>
		
		</div>
		
<!-- .row -->
        <div class="row">
		
		<div class="white-box"> 
	<div class="row row-in"  >

						<div class="col-lg-4 col-sm-6 row-in-br">
			 <ul class="col-in">
                                <li>
                                    <a href="{{ URL::to('empleado/update/'.$row->id_trabajador.'?return='.$return) }}">
                                        <span class="circle circle-md bg-danger"><i class="ti-plus"></i></span>
                                    </a>    
                                </li>
                                <li >
                                    <h4>{{ Lang::get('core.general') }}</h4>
                                    <p> {{ Lang::get('core.general_info') }}</p>
                                    
                                </li>
                            </ul>
		</div>
				<div class="col-lg-4 col-sm-6 row-in-br">
			 <ul class="col-in">
                                <li>
                                    <a href="{{ URL::to('dato/update/'.$row->id_trabajador.'?return='.$return) }}">
                                        <span class="circle circle-md bg-danger"><i class="ti-plus"></i></span>
                                    </a>    
                                </li>
                                <li >
                                    <h4>{{ Lang::get('core.datos') }}</h4>
                                    <p> {{ Lang::get('core.datos_info') }}</p>
                                    
                                </li>
                            </ul>
		</div>
		<div class="col-lg-4 col-sm-6 b-0">
			 <ul class="col-in">
                                <li>
                                    <a href="{{ URL::to('contrato') }}">
                                        <span class="circle circle-md bg-danger"><i class="ti-plus"></i></span>
                                    </a>    
                                </li>
                                <li >
                                    <h4>{{ Lang::get('core.contratos') }}</h4>
                                    <p> {{ Lang::get('core.contratos_info') }}</p>
                                    
                                </li>
                            </ul>
		</div>
	</div>
	<legend></legend>
	<div class="row row-in"  >
				<div class="col-lg-4 col-sm-6 row-in-br">
			 <ul class="col-in">
                                <li>
                                    <a href="{{ URL::to('derechohabiente') }}">
                                        <span class="circle circle-md bg-danger"><i class="ti-plus"></i></span>
                                    </a>    
                                </li>
                                <li >
                                    <h4>{{ Lang::get('core.derechohabiente') }}</h4>
                                    <p> {{ Lang::get('core.derechohabiente_info') }}</p>
                                    
                                </li>
                            </ul>
		</div>
		<div class="col-lg-4 col-sm-6 b-0">
			 <ul class="col-in">
                                <li>
                                    <a href="{{ URL::to('suspension') }}">
                                        <span class="circle circle-md bg-danger"><i class="ti-plus"></i></span>
                                    </a>    
                                </li>
                                <li >
                                    <h4>{{ Lang::get('core.suspensiones') }}</h4>
                                    <p> {{ Lang::get('core.suspensiones_info') }}</p>
                                    
                                </li>
                            </ul>
		</div>
	</div>

</div>  
</div>
	 
</div>	  
@stop