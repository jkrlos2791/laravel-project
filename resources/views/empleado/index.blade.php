@extends('layouts.app')

@section('content')
{{--*/ usort($tableGrid, "SiteHelpers::_sort") /*--}}

 <section class="content-header">
      <h1>
         {{ $pageTitle }}
        <small></small>
			@if($access['is_add'] ==1)
	   		<a href="{{ URL::to('empleado/update?return='.$return) }}" class="tips btn btn-xs btn-success btn-sm btn-circle"  title="{{ Lang::get('core.btn_create') }}">
			<i class="fa  fa-plus "></i></a>
			@endif 
      </h1>
    </section>

  <div class="content">
      <!-- Page header -->
	  
<div class="box box-primary ">
	<div class="box-header with-border"> 
		<div class="box-header-tools pull-left" > 
<h4>Buscar Empleado</h4>
		</div>
	</div>

	<div class="box-body"> 	
 <ul class="parsley-error-list">
			@foreach($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>	
        {!! Form::open(array('url'=>'empleado_buscar', 'class'=>'form-horizontal')) !!} 
		<div class="col-md-1">
		</div> 
         <div class="col-md-10">
 		 <div class="form-group  " >
		 <label for="empresa" class=" control-label col-md-3 text-right"> Seleccione nombres o DNI </label>
		 <div class="col-md-6">				
         {!!  Form::select('id_trabajador', $empleado,null,['class'=>'select2' ])  !!}
		 </div> 
		 <div class="col-md-3" >
				<button class="btn btn-primary btn-sm" type="submit" > <i class="fa fa-search"></i>Buscar</button>				
		 </div>
		 </div> 
		 </div> 
        <div class="col-md-1">
		</div>		 
		{!! Form::close() !!}

	</div>
</div>	
	</div>	  

<script>
$(document).ready(function(){

	$('.do-quick-search').click(function(){
		$('#SximoTable').attr('action','{{ URL::to("core/users/multisearch")}}');
		$('#SximoTable').submit();
	});
	
});	
</script>		
@stop