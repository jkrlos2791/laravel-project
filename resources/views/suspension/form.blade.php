@extends('layouts.app')

@section('content')

<section class="content-header">
  <h1>
   {{ $pageTitle }} del trabajador
    <small></small>
  </h1>
</section>

  <div class="content">
 	<div class="box box-danger ">
	<div class="box-header with-border"> 
		<div class="box-header-tools pull-left" >
		<h4>{{ Session::get('trabajador')->ape_paterno}} {{ Session::get('trabajador')->ape_materno}}, {{ Session::get('trabajador')->nombres}}</h4>
		</div>
		<div class="box-header-tools pull-right" >
		<a href="{{ url($pageModule.'?return='.$return) }}" class="tips btn btn-xs btn-warning btn-sm btn-circle"  title="{{ Lang::get('core.btn_back') }}" ><i class="fa  fa-arrow-left"></i></a>
		</div>
	</div>	
<div class="box-body">
		<ul class="parsley-error-list">
			@foreach($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>

		 {!! Form::open(array('url'=>'suspension/save?return='.$return, 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}
<div class="col-md-12">
          <fieldset>
				{!! Form::hidden('suspension_id', $row['suspension_id']) !!}
							
									<div class="form-group  " >
										<label for="Tipo Suspension" class=" control-label col-md-2 text-left"> Tipo de Suspension </label>
										<div class="col-md-8">
										  <select name='tipo_suspension_id' rows='5' id='tipo_suspension_id' class='select2 '   ></select> 
										 </div>
									</div>
									<div class="form-group  " >
										<label for="Fecha Inicio" class=" control-label col-md-2 text-left"> Fecha de Inicio </label>
										<div class="col-md-3">
										  
				<div class="input-group m-b" style="width:150px !important;">
					{!! Form::text('fecha_inicio', $row['fecha_inicio'],array('class'=>'form-control date','id'=>'fecha_inicio')) !!}
					<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
				</div> 
										 </div>
										<label for="Fecha Fin" class=" control-label col-md-2 text-left"> Fecha de Fin </label>
										<div class="col-md-3">
										  
				<div class="input-group m-b" style="width:150px !important;">
					{!! Form::text('fecha_fin', $row['fecha_fin'],array('class'=>'form-control date','id'=>'fecha_fin')) !!}
					<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
				</div> 
										 </div>
								
									  </div>   										
									  					
									   </fieldset>
			</div>
			
			

		
			<div style="clear:both"></div>	
				
					
				  <div class="form-group">
					<label class="col-sm-4 text-right">&nbsp;</label>
					<div class="col-sm-8">	
					<button type="submit" name="apply" class="btn btn-info btn-sm" ><i class="fa  fa-check-circle"></i> {{ Lang::get('core.sb_apply') }}</button>
					<button type="submit" name="submit" class="btn btn-primary btn-sm" ><i class="fa  fa-save"></i> {{ Lang::get('core.sb_save') }}</button>
					<button type="button" onclick="location.href='{{ URL::to('suspension?return='.$return) }}' " class="btn btn-warning btn-sm "><i class="fa  fa-arrow-circle-left "></i>  {{ Lang::get('core.sb_cancel') }} </button>
					</div>	  
			
				  </div> 
		 
		 {!! Form::close() !!}
	</div>
</div>		 
</div>	
</div>			 
   <script type="text/javascript">
	$(document).ready(function() { 
		
		
		$("#tipo_suspension_id").jCombo("{!! url('suspension/comboselect?filter=tipo_suspensiones:tipo_suspension_id:codigo|descripcion') !!}",
		{  selected_value : '{{ $row["tipo_suspension_id"] }}' });
		 

		$('.removeMultiFiles').on('click',function(){
			var removeUrl = '{{ url("suspension/removefiles?file=")}}'+$(this).attr('url');
			$(this).parent().remove();
			$.get(removeUrl,function(response){});
			$(this).parent('div').empty();	
			return false;
		});		
		
	});
	</script>		 
@stop