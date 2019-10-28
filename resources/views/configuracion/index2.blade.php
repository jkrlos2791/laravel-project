@extends('layouts.app2')
@section('content')
<button id="guardarConfiguracion" type="button" class="btn btn-primary flotante"><i class="fas fa-save"></i> Guardar</button>    
<div class="card">
<div class="card-header"><i class="fas fa-table"></i> Datos del Sistema</div>
<div class="card-body">
<div class="row">		
		<div class="col-lg-12">	
			<div class="accordion" id="accordionExample">
			  <form id="formConfiguracion">
			  <div class="card">
				<div class="card-header" id="headingOne">
				  <h5 class="mb-0">
					<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
					  Datos Generales
					</button>
				  </h5>
				</div>
				<div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
				  <div class="card-body">			  
					<div class="form-group row " >
						<label class=" control-label col-md-2 text-left"> Remuneracion Minima Vital * </label>
						<div class="col-md-4">
							<input id="rmv" name="rmv" type="text" class="form-control" ></input>  
						</div>
					</div> 
				  </div>
				</div>
			  </div>
			  <div class="card">
				<div class="card-header" id="heading6">
				  <h5 class="mb-0">
					<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse6" aria-expanded="true" aria-controls="collapse6">
					  Porcentajes AFP
					</button>
				  </h5>
				</div>
				<div id="collapse6" class="collapse" aria-labelledby="heading6" data-parent="#accordionExample">
				  <div class="card-body">				  
					<div class="col-lg-12">
							<button id="nuevoPorcentaje" class="btn btn-dark mb-4" type="button" title="Nuevo">
							<i class="fas fa-plus-square"></i> Nuevo</button>
							<button id="eliminarPorcentaje" class="btn btn-dark mb-4" type="button" title="Eliminar">
							<i class="fas fa-trash-alt"></i> Eliminar</button>
					</div>				  				  
					<table id="porcentajes" class="table table-striped table-bordered" style="width:100%"></table>
				  </div>
				</div>
			  </div>
			  </form>
			  <div class="card">
				<div class="card-header" id="heading7">
				  <h5 class="mb-0">
					<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse7" aria-expanded="true" aria-controls="collapse7">
					  Importacion
					</button>
				  </h5>
				</div>
				<div id="collapse7" class="collapse" aria-labelledby="heading7" data-parent="#accordionExample">
				  <div class="card-body">		
  					<div class="form-group row">
                            <label class=" control-label col-md-2 text-left"> Formatos </label>
                            <div class="col-md-4">
                                <a href="http://planilla.asecoint.com.pe/uploads/formatos/Empleados.xlsx">Empleados</a>,     
                                <a href="http://planilla.asecoint.com.pe/uploads/formatos/Subsidios.xlsx">Subsidios</a>,
                                <a href="http://planilla.asecoint.com.pe/uploads/formatos/Conceptos.xlsx">Conceptos</a>
                            </div>
					</div>
					<div class="form-group row">
                            <label class=" control-label col-md-2 text-left"> Importar </label>
                            <div class="col-md-4">
                                <select id="tipoImportacion" name="tipoImportacion" class="form-control" onchange="elegirImportacion()" >
                                    <option >Seleccione...</option>
                                    <option value="Empleados">Empleados</option>
                                    <option value="Subsidios">Subsidios</option>
                                    <option value="Conceptos">Conceptos</option>
                                </select>
                            </div>
                            <div class="col-md-4">
            					{!! Form::open([ 'id' => 'archivo', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data', 'data-parsley-validate']) !!}
                                    {!! Form::file('import_file') !!}
					                <button type="submit" name="importar" class="btn btn-primary" ><i class="fa fa-upload"></i> Importar</button>
				                {!! Form::close() !!}
                            </div>
					</div>
				  </div>
				</div>
			  </div>
			</div>
		</div>
</div>
</div>
</div>
@include('configuracion/formporcentajeafp')
<script type="text/javascript" src="{{ asset('jl/core/configuraciones.js') }}"></script>	
<script>
$(function() {
    Pace.on("done", function(){
        $("#contents").fadeIn(1000);
    });
});
</script>
@endsection