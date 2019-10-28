@extends('layouts.app')

@section('content')

<section class="content-header">
  <h1>
   Importación
    <small></small>
  </h1>
</section>

<div class="content">
 	<div class="box box-danger ">
	<div class="box-header with-border"> 
		<div class="box-header-tools pull-left" >
		<h4>Importar Empleados</h4>
		</div>
	</div>	
<div class="box-body">
		<ul class="parsley-error-list">
			@foreach($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>
		 @if (Session::has('message'))
	      <div class="alert alert-success">{{ Session::get('message') }}</div> 
         @endif 

	{!! Form::open(['route' => 'empleados.importar', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data', 'data-parsley-validate']) !!}
      <div class="col-md-6">
								  <div class="form-group  " >
                                    {!! Form::file('import_file') !!}
								  </div>	
      </div>
	  
      <div class="col-md-6">

	  </div>	
				
			<div style="clear:both"></div>	
									
				  <div class="form-group">
					<label class="col-sm-6 text-right">
					<button type="submit" name="importar" class="btn btn-primary btn-sm" ><i class="fa  fa-save "></i> Importar Empleados</button>
					</label>
					{!! Form::close() !!}
					<div class="col-sm-6">	
					</div>	  			
				  </div> 
				  
	</div>
</div>

 	<div class="box box-danger ">
	<div class="box-header with-border"> 
		<div class="box-header-tools pull-left" >
		<h4>Importar Subsidios</h4>
		</div>
	</div>	
<div class="box-body">
		<ul class="parsley-error-list">
			@foreach($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>
		 @if (Session::has('message'))
	      <div class="alert alert-success">{{ Session::get('message') }}</div> 
         @endif 

	{!! Form::open(['route' => 'subsidios.importar', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data', 'data-parsley-validate']) !!}
      <div class="col-md-6">
								  <div class="form-group  " >
                                    {!! Form::file('import_file') !!}
								  </div>	
      </div>
	  
      <div class="col-md-6">

	  </div>	
				
			<div style="clear:both"></div>	
									
				  <div class="form-group">
					<label class="col-sm-6 text-right">
					<button type="submit" name="importar" class="btn btn-primary btn-sm" ><i class="fa  fa-save "></i> Importar Subsidios</button>
					</label>
					{!! Form::close() !!}
					<div class="col-sm-6">	
					</div>	  			
				  </div> 
				  
	</div>
</div>	

 	<div class="box box-danger ">
	<div class="box-header with-border"> 
		<div class="box-header-tools pull-left" >
		<h4>Importar Conceptos</h4>
		</div>
	</div>	
<div class="box-body">
		<ul class="parsley-error-list">
			@foreach($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>
		 @if (Session::has('message'))
	      <div class="alert alert-success">{{ Session::get('message') }}</div> 
         @endif 

	{!! Form::open(['route' => 'conceptos.importar', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data', 'data-parsley-validate']) !!}
      <div class="col-md-6">
								  <div class="form-group  " >
                                    {!! Form::file('import_file') !!}
								  </div>	
      </div>
	  
      <div class="col-md-6">

	  </div>	
				
			<div style="clear:both"></div>	
									
				  <div class="form-group">
					<label class="col-sm-6 text-right">
					<button type="submit" name="importar" class="btn btn-primary btn-sm" ><i class="fa  fa-save "></i> Importar Conceptos</button>
					</label>
					{!! Form::close() !!}
					<div class="col-sm-6">	
					</div>	  			
				  </div> 
				  
	</div>
</div>		
</div>

<script>
</script>
@stop