@extends("layouts.app2")
@section("content")
<div class="card">
<div class="card-header"><i class="fas fa-table"></i> Datos</div>
<div class="card-body">
<div class="row">		
		<div class="col-lg-12">	
			<div class="accordion" id="accordionExample">
			  <div class="card">
				<div class="card-header" id="heading5">
				  <h5 class="mb-0">
					<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse5" aria-expanded="true" aria-controls="collapse5">
					  Gráfico
					</button>
				  </h5>
				</div>
				<div id="collapse5" class="collapse show" aria-labelledby="heading5" data-parent="#accordionExample">
				  <div class="card-body">
				    <div class="form-group row " >
    		            <select id="campo" name="campo" class="form-control col-md-6" onchange="actualizarChart()" ></select>
    		            <select id="tipoChart" name="tipoChart" class="form-control col-md-6" onchange="actualizarTipoChart()" >
    	                    <option value="bar">bar</option> 
    	                    <option value="pie">pie</option> 
    		            </select>
		            </div>
					<canvas id="myChart" width="400" height="100"></canvas>
				  </div>
				</div>
			  </div>
			  
			  <div class="card">
				<div class="card-header" id="heading6">
				  <h5 class="mb-0">
					<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse6" aria-expanded="true" aria-controls="collapse6">
					  Data
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
					<table id="rasens" class="table table-striped table-bordered" style="width:100%"></table>
				  </div>
				</div>
			  </div>
			  
			</div>
		</div>
</div>
</div>
</div>
<script type="text/javascript" src="{{ asset("jl/core/rasen.js") }}"></script>		
<script>
$(function() {
    Pace.on("done", function(){
        $("#contents").fadeIn(1000);
    });
});
</script>
@endsection