@extends('layouts.app2')
@section('content')
<button id="crearModulo" type="button" class="btn btn-primary flotante"><i class="fas fa-save"></i> crear Modulo</button>
<div class="card">
<div class="card-header"><i class="fas fa-table"></i> Datos</div>
<div class="card-body">
<div class="row">		
		<div class="col-lg-12">	
			<div class="accordion" id="accordionExample">
			  <form id="formEmpresa">
			  <input id="idEmpresa" name="idEmpresa" type="hidden" />
			  <div class="card">
				<div class="card-header" id="heading6">
				  <h5 class="mb-0">
					<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse6" aria-expanded="true" aria-controls="collapse6">
					  Modulos
					</button>
				  </h5>
				</div>
				<div id="collapse6" class="collapse show" aria-labelledby="heading6" data-parent="#accordionExample">
				  <div class="card-body">				  
					<div class="col-lg-12">
							<button id="nuevoModulo" class="btn btn-dark mb-4" type="button" title="Nuevo">
							<i class="fas fa-plus-square"></i> Nuevo</button>
							<button id="eliminarModulo" class="btn btn-dark mb-4" type="button" title="Eliminar">
							<i class="fas fa-trash-alt"></i> Eliminar</button>
					</div>				  				  
					<table id="modulos" class="table table-striped table-bordered" style="width:100%"></table>
				  </div>
				</div>
			  </div>
			  </form>
			</div>
		</div>
</div>
</div>
</div>
@include('cerebro/form')
<script type="text/javascript" src="{{ asset('jl/core/cerebro.js') }}"></script>	
<script>
$(function() {
    Pace.on("done", function(){
        $("#contents").fadeIn(1000);
    });
});
</script>
@endsection