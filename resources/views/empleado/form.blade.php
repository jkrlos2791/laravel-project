@extends('layouts.app')

@section('content')

<section class="content-header">
  <h1>
   {{ $pageTitle }}
    <small></small>
	<a href="{{ URL::to('empleado/update?return='.$return) }}" class="tips btn btn-xs btn-success btn-sm btn-circle"  title="{{ Lang::get('core.btn_create') }}">
			<i class="fa  fa-plus "></i></a>
  </h1>
</section>

  <div class="content">
 	<div class="box box-danger ">
	<div class="box-header with-border"> 
		<div class="box-header-tools pull-left" >
		<h4>Información</h4>
		</div>
		<div class="box-header-tools pull-right" >
		<a href="{{ URL::to('empleado')}}" class="tips btn btn-xs btn-warning btn-sm btn-circle"  title="{{ Lang::get('core.btn_back') }}" ><i class="fa  fa-arrow-left"></i></a> 
		</div>
	</div>	
<div class="box-body">
		<ul class="parsley-error-list">
			@foreach($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>


		 {!! Form::open(array('url'=>'empleado/save?return='.$return, 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}
<div class="col-md-6">
				{!! Form::hidden('id_trabajador', $row['id_trabajador']) !!}	
						


									<div class="form-group  " >
										<label for="Codigo del Trabajador" class=" control-label col-md-4 text-left"> Codigo del Trabajador </label>
										<div class="col-md-8">
										  <input  type='text' name='codigo_trabajador' id='codigo_trabajador' value='{{ $row['codigo_trabajador'] }}' 
						     class='form-control ' /> 
										 </div> 
									  </div>
									
									
									  <div class="form-group  " >
										<label for="Apellido Paterno" class=" control-label col-md-4 text-left"> Apellido Paterno </label>
										<div class="col-md-8">
										  <input  type='text' name='ape_paterno' id='ape_paterno' value='{{ $row['ape_paterno'] }}' 
						     class='form-control ' /> 
										 </div> 
									  </div> 					
									  <div class="form-group  " >
										<label for="Apellido Materno" class=" control-label col-md-4 text-left"> Apellido Materno </label>
										<div class="col-md-8">
										  <input  type='text' name='ape_materno' id='ape_materno' value='{{ $row['ape_materno'] }}' 
						     class='form-control ' /> 
										 </div> 
									  </div> 					
									  <div class="form-group  " >
										<label for="Nombres" class=" control-label col-md-4 text-left"> Nombres </label>
										<div class="col-md-8">
										  <input  type='text' name='nombres' id='nombres' value='{{ $row['nombres'] }}' 
						     class='form-control ' /> 
										 </div> 
									  </div> 					
									  <div class="form-group  " >
										<label for="Tipo de documento" class=" control-label col-md-4 text-left"> Tipo de documento </label>
										<div class="col-md-8">
										  <select name='tipo_doc' rows='5' id='tipo_doc' class='select2 '   ></select> 
										 </div> 
									  </div> 	
									  <div class="form-group  " >
										<label for="Número de documento" class=" control-label col-md-4 text-left"> Número de documento </label>
										<div class="col-md-8">
										  <input  type='text' name='num_doc' id='num_doc' value='{{ $row['num_doc'] }}' 
						     class='form-control ' /> 
										 </div> 
									  </div> 
<div class="form-group  " >
										<label for="Sexo" class=" control-label col-md-4 text-left"> Sexo </label>
										<div class="col-md-8">
										  
					<label class='radio radio-inline'>
					<input type='radio' name='sexo' value ='Femenino'  @if($row['sexo'] == 'Femenino') checked="checked" @endif > Femenino </label>
					<label class='radio radio-inline'>
					<input type='radio' name='sexo' value ='Masculino'  @if($row['sexo'] == 'Masculino') checked="checked" @endif > Masculino </label> 
										 </div> 
									  </div> 										  
			</div>
<div class="col-md-6">						
<div class="form-group  " >
										<label for="Estado Civil" class=" control-label col-md-4 text-left"> Estado Civil </label>
										<div class="col-md-8">
										  
					<label class='radio radio-inline'>
					<input type='radio' name='estado_civil' value ='Soltero'  @if($row['estado_civil'] == 'Soltero') checked="checked" @endif > Soltero </label>
					<label class='radio radio-inline'>
					<input type='radio' name='estado_civil' value ='Casado'  @if($row['estado_civil'] == 'Casado') checked="checked" @endif > Casado </label> 
										 </div> 
									  </div> 					
									  <div class="form-group  " >
										<label for="Celular" class=" control-label col-md-4 text-left"> Celular </label>
										<div class="col-md-8">
										  <input  type='text' name='celular' id='celular' value='{{ $row['celular'] }}' 
						     class='form-control ' /> 
										 </div> 
									  </div> 					
									  <div class="form-group  " >
										<label for="E-mail" class=" control-label col-md-4 text-left"> E-mail </label>
										<div class="col-md-8">
										  <input  type='text' name='email' id='email' value='{{ $row['email'] }}' 
						     class='form-control ' /> 
										 </div> 
									  </div>
									<div class="form-group  " >
										<label for="Estado" class=" control-label col-md-4 text-left"> Estado </label>
										<div class="col-md-8">
										  <select name='estado_empleado_id' rows='5' id='estado_empleado_id' class='select2 '   ></select> 
										 </div> 
									  </div>
									  <div class="form-group  " >
										<label for="Centro Costo" class=" control-label col-md-4 text-left"> Centro Costo </label>
										<div class="col-md-8">
                                    {!!  Form::select('centro_costo', $centrosCosto, null, ['placeholder'=>'Seleccione un Centro de Costo...', "class" => "select2 "])  !!}
										 </div> 
									  </div>									
									 <div class="form-group  " >
										<label for="Centro Costo 2" class=" control-label col-md-4 text-left"> Centro Costo 2</label>
										<div class="col-md-8">
                                    {!!  Form::select('centro_costo2', $centrosCosto, null, ['placeholder'=>'Seleccione un Centro de Costo...', "class" => "select2 "])  !!}
										 </div> 
									  </div>
									<div class="form-group  " >
										<label for="Avatar" class=" control-label col-md-4 text-left"> Foto </label>
										<div class="col-md-8">
										  <input  type='file' name='avatar' id='avatar'/>
					 	<div >
						{!! SiteHelpers::showUploadedFile($row['avatar'],'/uploads/empleados/') !!}
						
						</div>										 
										 </div> 
									  </div>									  
</div>					
			<div style="clear:both"></div>	
				
					
				  <div class="form-group">
					<label class="col-sm-6 text-right">
					<button type="submit" name="apply" class="btn btn-primary btn-sm" ><i class="fa  fa-save"></i> {{ Lang::get('core.sb_save') }}</button>
					</label>
					<div class="col-sm-6">	
					
					</div>	  
			
				  </div> 
		 
		 {!! Form::close() !!}
	</div>
</div>		 
</div>	
</div>			 
   <script type="text/javascript">
	$(document).ready(function() { 
		$("#empresa_id").jCombo("{!! url('empleado/comboselect?filter=empresas:empresa_id:razon_social') !!}",
		{  selected_value : '{{ $row["empresa_id"] }}' });
		
		$("#tipo_doc").jCombo("{!! url('empleado/comboselect?filter=tipo_documento:tipo_documento_id:codigo|descripcion') !!}",
		{  selected_value : '{{ $row["tipo_doc"] }}' });
		
		$("#centro_costo").jCombo("{!! url('empleado/comboselect?filter=centro_costos:centro_costo_id:centro_costo') !!}",
		{  selected_value : '{{ $row["centro_costo"] }}' });
		
		$("#centro_costo2").jCombo("{!! url('empleado/comboselect?filter=centro_costos:centro_costo_id:centro_costo') !!}",
		{  selected_value : '{{ $row["centro_costo2"] }}' });
		 
		$("#estado_empleado_id").jCombo("{!! url('empleado/comboselect?filter=estado_empleados:estado_empleado_id:nombre') !!}",
		{  selected_value : '{{ $row["estado_empleado_id"] }}' });
		
		$('.removeMultiFiles').on('click',function(){
			var removeUrl = '{{ url("empleado/removefiles?file=")}}'+$(this).attr('url');
			$(this).parent().remove();
			$.get(removeUrl,function(response){});
			$(this).parent('div').empty();	
			return false;
		});		
		
	});
	</script>		 
@stop