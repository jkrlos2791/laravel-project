@extends('layouts.app')

@section('content')

  <div class="page-content row">
    <!-- Page header -->

 
 	<div class="page-content-wrapper m-t">


<div class="sbox">
	<div class="sbox-title"> 
		<div class="sbox-tools pull-left" >
			<a href="{{ url($pageModule.'?return='.$return) }}" class="tips btn btn-xs btn-default"  title="{{ Lang::get('core.btn_back') }}" ><i class="fa  fa-arrow-left"></i></a> 
		</div>
		<div class="sbox-tools " >
			@if(Session::get('gid') ==1)
				<a href="{{ URL::to('sximo/module/config/'.$pageModule) }}" class="tips btn btn-xs btn-default" title=" {{ Lang::get('core.btn_config') }}" ><i class="fa  fa-ellipsis-v"></i></a>
			@endif 			
		</div> 

	</div>
	<div class="sbox-content"> 	

		<ul class="parsley-error-list">
			@foreach($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>	

		 {!! Form::open(array('url'=>'liquidacion/save?return='.$return, 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}
<div class="col-md-12">
						<fieldset><legend> Liquidaciones</legend>
									
									  <div class="form-group  " >
										<label for="Liquidacion Id" class=" control-label col-md-4 text-left"> Liquidacion Id </label>
										<div class="col-md-7">
										  <input  type='text' name='liquidacion_id' id='liquidacion_id' value='{{ $row['liquidacion_id'] }}' 
						     class='form-control ' /> 
										 </div> 
										 <div class="col-md-1">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="Id Trabajador" class=" control-label col-md-4 text-left"> Id Trabajador </label>
										<div class="col-md-7">
										  <input  type='text' name='id_trabajador' id='id_trabajador' value='{{ $row['id_trabajador'] }}' 
						     class='form-control ' /> 
										 </div> 
										 <div class="col-md-1">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="Periodo Id" class=" control-label col-md-4 text-left"> Periodo Id </label>
										<div class="col-md-7">
										  <input  type='text' name='periodo_id' id='periodo_id' value='{{ $row['periodo_id'] }}' 
						     class='form-control ' /> 
										 </div> 
										 <div class="col-md-1">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="Cargo" class=" control-label col-md-4 text-left"> Cargo </label>
										<div class="col-md-7">
										  <input  type='text' name='cargo' id='cargo' value='{{ $row['cargo'] }}' 
						     class='form-control ' /> 
										 </div> 
										 <div class="col-md-1">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="Centro Costo" class=" control-label col-md-4 text-left"> Centro Costo </label>
										<div class="col-md-7">
										  <input  type='text' name='centro_costo' id='centro_costo' value='{{ $row['centro_costo'] }}' 
						     class='form-control ' /> 
										 </div> 
										 <div class="col-md-1">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="Fecha Ingreso" class=" control-label col-md-4 text-left"> Fecha Ingreso </label>
										<div class="col-md-7">
										  <input  type='text' name='fecha_ingreso' id='fecha_ingreso' value='{{ $row['fecha_ingreso'] }}' 
						     class='form-control ' /> 
										 </div> 
										 <div class="col-md-1">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="Fecha Cese" class=" control-label col-md-4 text-left"> Fecha Cese </label>
										<div class="col-md-7">
										  <input  type='text' name='fecha_cese' id='fecha_cese' value='{{ $row['fecha_cese'] }}' 
						     class='form-control ' /> 
										 </div> 
										 <div class="col-md-1">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="Condicion Trabajo" class=" control-label col-md-4 text-left"> Condicion Trabajo </label>
										<div class="col-md-7">
										  <input  type='text' name='condicion_trabajo' id='condicion_trabajo' value='{{ $row['condicion_trabajo'] }}' 
						     class='form-control ' /> 
										 </div> 
										 <div class="col-md-1">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="Tiempo Servicio" class=" control-label col-md-4 text-left"> Tiempo Servicio </label>
										<div class="col-md-7">
										  <input  type='text' name='tiempo_servicio' id='tiempo_servicio' value='{{ $row['tiempo_servicio'] }}' 
						     class='form-control ' /> 
										 </div> 
										 <div class="col-md-1">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="Faltas" class=" control-label col-md-4 text-left"> Faltas </label>
										<div class="col-md-7">
										  <input  type='text' name='faltas' id='faltas' value='{{ $row['faltas'] }}' 
						     class='form-control ' /> 
										 </div> 
										 <div class="col-md-1">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="Tiempo Computable" class=" control-label col-md-4 text-left"> Tiempo Computable </label>
										<div class="col-md-7">
										  <input  type='text' name='tiempo_computable' id='tiempo_computable' value='{{ $row['tiempo_computable'] }}' 
						     class='form-control ' /> 
										 </div> 
										 <div class="col-md-1">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="Motivo Cese" class=" control-label col-md-4 text-left"> Motivo Cese </label>
										<div class="col-md-7">
										  <input  type='text' name='motivo_cese' id='motivo_cese' value='{{ $row['motivo_cese'] }}' 
						     class='form-control ' /> 
										 </div> 
										 <div class="col-md-1">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="Sistema Pension" class=" control-label col-md-4 text-left"> Sistema Pension </label>
										<div class="col-md-7">
										  <input  type='text' name='sistema_pension' id='sistema_pension' value='{{ $row['sistema_pension'] }}' 
						     class='form-control ' /> 
										 </div> 
										 <div class="col-md-1">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="Tipo Comision Afp" class=" control-label col-md-4 text-left"> Tipo Comision Afp </label>
										<div class="col-md-7">
										  <input  type='text' name='tipo_comision_afp' id='tipo_comision_afp' value='{{ $row['tipo_comision_afp'] }}' 
						     class='form-control ' /> 
										 </div> 
										 <div class="col-md-1">
										 	
										 </div>
									  </div> </fieldset>
			</div>
			
			

		
			<div style="clear:both"></div>	
				
					
				  <div class="form-group">
					<label class="col-sm-4 text-right">&nbsp;</label>
					<div class="col-sm-8">	
					<button type="submit" name="apply" class="btn btn-info btn-sm" ><i class="icon-checkmark-circle2"></i> {{ Lang::get('core.sb_apply') }}</button>
					<button type="submit" name="submit" class="btn btn-primary btn-sm" ><i class="icon-bubble-check"></i> {{ Lang::get('core.sb_save') }}</button>
					<button type="button" onclick="location.href='{{ URL::to('liquidacion?return='.$return) }}' " class="btn btn-warning btn-sm "><i class="icon-cancel-circle2 "></i>  {{ Lang::get('core.sb_cancel') }} </button>
					</div>	  
			
				  </div> 
		 
		 {!! Form::close() !!}
	</div>
</div>		 
</div>	
</div>			 
   <script type="text/javascript">
	$(document).ready(function() { 
		
		 

		$('.removeMultiFiles').on('click',function(){
			var removeUrl = '{{ url("liquidacion/removefiles?file=")}}'+$(this).attr('url');
			$(this).parent().remove();
			$.get(removeUrl,function(response){});
			$(this).parent('div').empty();	
			return false;
		});		
		
	});
	</script>		 
@stop