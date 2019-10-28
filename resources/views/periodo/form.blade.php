@extends('layouts.app')

@section('content')

<section class="content-header">
  <h1>
   {{ $pageTitle }}
    <small></small>
  </h1>
</section>

  <div class="content">
 
 	<div class="box box-danger ">

	<div class="box-header with-border"> 
		<div class="box-header-tools pull-left" >
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

		 {!! Form::open(array('url'=>'periodo/save?return='.$return, 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}
<div class="col-md-12">
						<fieldset>
				{!! Form::hidden('periodo_id', $row['periodo_id']) !!}					
									  <div class="form-group  " >
										<label for="Mes Id" class=" control-label col-md-4 text-left"> Mes</label>
										<div class="col-md-7">
										  <select name='mes_id' rows='5' id='mes_id' class='select2 '   ></select> 
										 </div> 
										 <div class="col-md-1">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="Anio Id" class=" control-label col-md-4 text-left"> Año </label>
										<div class="col-md-7">
										  <select name='anio_id' rows='5' id='anio_id' class='select2 '   ></select> 
										 </div> 
										 <div class="col-md-1">
										 	
										 </div>
									  </div> </fieldset>
			</div>
			
			

		
			<div style="clear:both"></div>	
				
					
				  <div class="form-group">
					<label class="col-sm-4 text-right">&nbsp;</label>
					<div class="col-sm-8">	
					<button type="submit" name="apply" class="btn btn-info btn-sm" ><i class="fa  fa-check-circle"></i> {{ Lang::get('core.sb_apply') }}</button>
					<button type="submit" name="submit" class="btn btn-primary btn-sm" ><i class="fa  fa-save "></i> {{ Lang::get('core.sb_save') }}</button>
					<button type="button" onclick="location.href='{{ URL::to('periodo?return='.$return) }}' " class="btn btn-warning btn-sm "><i class="fa  fa-arrow-circle-left "></i>  {{ Lang::get('core.sb_cancel') }} </button>
					</div>	  
			
				  </div> 
		 
		 {!! Form::close() !!}
	</div>
</div>		 
</div>	
</div>			 
   <script type="text/javascript">
	$(document).ready(function() { 
		
		
		$("#mes_id").jCombo("{!! url('periodo/comboselect?filter=meses:mes_id:mes') !!}",
		{  selected_value : '{{ $row["mes_id"] }}' });
		
		$("#anio_id").jCombo("{!! url('periodo/comboselect?filter=anios:anio_id:anio') !!}",
		{  selected_value : '{{ $row["anio_id"] }}' });
		 

		$('.removeMultiFiles').on('click',function(){
			var removeUrl = '{{ url("periodo/removefiles?file=")}}'+$(this).attr('url');
			$(this).parent().remove();
			$.get(removeUrl,function(response){});
			$(this).parent('div').empty();	
			return false;
		});		
		
	});
	</script>		 
@stop