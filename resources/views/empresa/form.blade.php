@extends('layouts.app')

@section('content')

<section class="content-header">
  <h1>
   {{ $pageTitle }}
    <small></small>
	<a href="{{ URL::to('empresa/update?return='.$return) }}" class="tips btn btn-xs btn-success btn-sm btn-circle"  title="{{ Lang::get('core.btn_create') }}">
			<i class="fa  fa-plus "></i></a>
  </h1>
</section>

  <div class="content">
 <div class="box box-danger ">
 	<div class="box-header with-border"> 
		<div class="box-header-tools pull-left" >
		<h4>Acceso</h4>
		</div>
	</div>	
 <div class="box-body">
 <ul class="parsley-error-list">
			@foreach($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>
        {!! Form::open(array('url'=>'empresa_ingresar', 'class'=>'form-horizontal')) !!} 
		<div class="col-md-1">
		</div> 
         <div class="col-md-10">
 		 <div class="form-group  " >
		 <label for="empresa" class=" control-label col-md-3 text-right"> Empresa </label>
		 <div class="col-md-6">				
         {!!  Form::select('empresa', $empresa,null,['class'=>'select2' ])  !!}
		 </div> 
		 <div class="col-md-3" >
				<button class="btn btn-primary btn-sm" type="submit" > <i class="fa fa-sign-in"></i>Ingresar</button>				
		 </div>
		 </div> 
		 </div> 
        <div class="col-md-1">
		</div>		 
		{!! Form::close() !!}
 </div>
 </div>
 	<div class="box box-danger ">
	<div class="box-header with-border"> 
		<div class="box-header-tools pull-left" >
		<h4>Información</h4>
		</div>
	</div>	
<div class="box-body">
		<ul class="parsley-error-list">
			@foreach($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>

		 {!! Form::open(array('url'=>'empresa/save?return='.$return, 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}
      <div class="col-md-6">
	  {!! Form::hidden('empresa_id', $row['empresa_id']) !!}
                                   <div class="form-group  " >
									<label for="Razon Social" class=" control-label col-md-4 text-left"> Razon Social </label>
									<div class="col-md-8">
									 <input  type='text' name='razon_social' id='razon_social' value='{{ $row['razon_social'] }}' 
						     class='form-control ' /> 
									 </div> 
								  </div>
                                   <div class="form-group  " >
									<label for="Ruc" class=" control-label col-md-4 text-left"> Ruc </label>
									<div class="col-md-8">
									 <input  type='text' name='ruc' id='ruc' value='{{ $row['ruc'] }}' 
						     class='form-control ' />
									 </div> 
								  </div>
                                  <div class="form-group  " >
									<label for="Sector" class=" control-label col-md-4 text-left"> Sector </label>
									<div class="col-md-8">
									 <select name='sector_id' rows='5' id='sector_id' class='select2 '   ></select>
									 </div> 
								  </div>	
								  <div class="form-group  " >
									<label for="Dirección" class=" control-label col-md-4 text-left"> Dirección </label>
									<div class="col-md-8">
									 <input  type='text' name='direccion' id='direccion' value='{{ $row['direccion'] }}' 
						     class='form-control ' /> 
									 </div> 
								  </div>	
								  <div class="form-group  " >
									<label for="Nº" class=" control-label col-md-4 text-left"> Nº </label>
									<div class="col-md-8">
									  <input  type='text' name='num_direccion' id='num_direccion' value='{{ $row['num_direccion'] }}' 
						     class='form-control ' /> 
									 </div> 
								  </div>	
								  <div class="form-group  " >
									<label for="Urbanización" class=" control-label col-md-4 text-left"> Urbanización </label>
									<div class="col-md-8">
									 <input  type='text' name='urbanizacion' id='urbanizacion' value='{{ $row['urbanizacion'] }}' 
						     class='form-control ' /> 
									 </div> 
								  </div>	
								  <div class="form-group  " >
									<label for="Departamento" class=" control-label col-md-4 text-left"> Departamento </label>
									<div class="col-md-8">
									<select name='departamento_id' rows='5' id='departamento_id' class='select2 '   ></select> 
									 </div> 
								  </div>	
								  <div class="form-group  " >
									<label for="Provincia" class=" control-label col-md-4 text-left"> Provincia </label>
									<div class="col-md-8">
									  <select name='provincia_id' rows='5' id='provincia_id' class='select2 '   ></select> 
									 </div> 
								  </div>	
								  <div class="form-group  " >
									<label for="Distrito" class=" control-label col-md-4 text-left"> Distrito </label>
									<div class="col-md-8">
									 <select name='distrito_id' rows='5' id='distrito_id' class='select2 '   ></select> 
									 </div> 
								  </div>	
      </div>
	  
      <div class="col-md-6">
                           <div class="form-group  " >
									<label for="Teléfono" class=" control-label col-md-4 text-left"> Teléfono </label>
									<div class="col-md-8">
									 <input  type='text' name='telefono' id='telefono' value='{{ $row['telefono'] }}' 
						     class='form-control ' /> 
									 </div> 
								  </div>
                                   <div class="form-group  " >
									<label for="Email" class=" control-label col-md-4 text-left"> Email </label>
									<div class="col-md-8">
									 <input  type='text' name='email' id='email' value='{{ $row['email'] }}' 
						     class='form-control ' /> 
									 </div> 
								  </div>
                                  <div class="form-group  " >
									<label for="Página Web" class=" control-label col-md-4 text-left"> Página Web </label>
									<div class="col-md-8">
									 <input  type='text' name='pagina_web' id='pagina_web' value='{{ $row['pagina_web'] }}' 
						     class='form-control ' /> 
									 </div> 
								  </div>	
								  <div class="form-group  " >
									<label for="Representante Legal" class=" control-label col-md-4 text-left"> Representante Legal </label>
									<div class="col-md-8">
									 <input  type='text' name='representante' id='representante' value='{{ $row['representante'] }}' 
						     class='form-control ' /> 
									 </div> 
								  </div>	
								  <div class="form-group  " >
									<label for="Cargo" class=" control-label col-md-4 text-left"> Cargo </label>
									<div class="col-md-8">
									 <input  type='text' name='cargo' id='cargo' value='{{ $row['cargo'] }}' 
						     class='form-control ' /> 
									 </div> 
								  </div>	
								  <div class="form-group  " >
									<label for="Tipo de Documento" class=" control-label col-md-4 text-left"> Tipo de Documento </label>
									<div class="col-md-8">
									 <select name='tipo_documento_id' rows='5' id='tipo_documento_id' class='select2 '   ></select> 
									 </div> 
								  </div>	
								  <div class="form-group  " >
									<label for="Nº de Documento" class=" control-label col-md-4 text-left"> Nº de Documento </label>
									<div class="col-md-8">
									 <input  type='text' name='num_documento' id='num_documento' value='{{ $row['num_documento'] }}' 
						     class='form-control ' /> 
									 </div> 
								  </div>	
								  <div class="form-group  " >
									<label for="Logo" class=" control-label col-md-4 text-left"> Logo </label>
									<div class="col-md-8">
									 <input  type='file' name='logo' id='logo' @if($row['logo'] =='') class='required' @endif style='width:150px !important;'  />
					 	<div >
						{!! SiteHelpers::showUploadedFile($row['logo'],'/uploads/logos/') !!}			
						</div>					
									 </div> 
								  </div>	
	  </div>	
				
			<div style="clear:both"></div>	
									
				  <div class="form-group">
					<label class="col-sm-6 text-right">
					<button type="submit" name="apply" class="btn btn-primary btn-sm" ><i class="fa  fa-save "></i> {{ Lang::get('core.sb_save') }}</button>
					</label>
					{!! Form::close() !!}
					<div class="col-sm-6">	
					{!! Form::open(array('url'=>'empresa_eliminar', 'class'=>'form-horizontal')) !!} 
					{!! Form::hidden('empresa_id', $row['empresa_id']) !!}
                    <button type="submit" name="eliminar" class="btn btn-primary btn-sm" ><i class="fa  fa-trash "></i> Eliminar</button>
                    {!! Form::close() !!}
					</div>	  			
				  </div> 		 
	</div>
</div>		 
</div>			 
   <script type="text/javascript">
	$(document).ready(function() { 
		
		
		$("#sector_id").jCombo("{!! url('empresa/comboselect?filter=sectores:sector_id:nombre') !!}",
		{  selected_value : '{{ $row["sector_id"] }}' });
		
		$("#distrito_id").jCombo("{!! url('empresa/comboselect?filter=distritos:distrito_id:nombre') !!}&parent=provincia_id:",
		{  parent: '#provincia_id', selected_value : '{{ $row["distrito_id"] }}' });
		
		$("#provincia_id").jCombo("{!! url('empresa/comboselect?filter=provincias:provinvia_id:nombre') !!}&parent=departamento_id:",
		{  parent: '#departamento_id', selected_value : '{{ $row["provincia_id"] }}' });
		
		$("#departamento_id").jCombo("{!! url('empresa/comboselect?filter=departamentos:departamento_id:nombre') !!}",
		{  selected_value : '{{ $row["departamento_id"] }}' });
		
		$("#tipo_documento_id").jCombo("{!! url('empresa/comboselect?filter=tipo_documento:tipo_documento_id:codigo|descripcion') !!}",
		{  selected_value : '{{ $row["tipo_documento_id"] }}' });
		 

		$('.removeMultiFiles').on('click',function(){
			var removeUrl = '{{ url("empresa/removefiles?file=")}}'+$(this).attr('url');
			$(this).parent().remove();
			$.get(removeUrl,function(response){});
			$(this).parent('div').empty();	
			return false;
		});		
		
	});
	</script>		 
@stop