@extends('layouts.app2')
@section('content')
<button id="guardarEmpleado" type="button" class="btn btn-primary flotante"><i class="fas fa-save"></i> Guardar</button>
<div class="card">
<div class="card-header"><i class="fas fa-table"></i> Datos del Trabajador</div>
<div class="card-body">
<div class="row">		
		<div class="col-lg-12">	
			<div class="accordion" id="accordionExample">
			  <form id="formEmpleado">
			  <input id="idEmpleado" name="idEmpleado" type="hidden" />
			  </form>
			</div>
		</div>
</div>
</div>
</div>
<canvas id="myChart" width="400" height="100"></canvas>
<script type="text/javascript" src="{{ asset('jl/core/charts.js') }}"></script>	
<script>
$(function() {
    Pace.on("done", function(){
        $("#contents").fadeIn(1000);
    });
});
</script>
@endsection