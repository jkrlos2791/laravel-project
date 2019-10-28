@extends('layouts.app2')
@section('content')
<div class="card">
<div class="card-header"><i class="fas fa-table"></i> Planilla de Remuneraciones</div>
<div class="card-body">
<div class="row">		
		<div class="col-lg-12">	
			<div class="accordion" id="accordionExample">
			  <form id="formConfiguracion">
			  <div class="card">
				<div class="card-header" id="headingOne">
				  <h5 class="mb-0">
					<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
					  Planilla
					</button>
				  </h5>
				</div>
				<div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
				  <div class="card-body">			  
                    <div class="col-lg-12">
                            <a id="exportar" class="btn btn-dark mb-4" role="button" href="javascript:void(0)" title="Exportar">
                			<i class="fas fa-file-excel"></i> Exportar</a>
                			<a id="descargarBoletas" class="btn btn-dark mb-4" role="button" href="{{ URL::to('descargar_boletas') }}" title="Boletas" target="_blank" >
                			<i class="fas fa-file-pdf"></i> Boletas</a>
                    </div>
                    <table id="planilla" class="table table-striped table-bordered" style="width:100%"></table>
				  </div>
				</div>
			  </div>
			  <div class="card">
				<div class="card-header" id="heading6">
				  <h5 class="mb-0">
					<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse6" aria-expanded="true" aria-controls="collapse6">
					  Liquidacion
					</button>
				  </h5>
				</div>
				<div id="collapse6" class="collapse" aria-labelledby="heading6" data-parent="#accordionExample">
				  <div class="card-body">				  
					<table id="liquidacion" class="table table-striped table-bordered" style="width:100%"></table>
				  </div>
				</div>
			  </div>
			  </form>
			</div>
		</div>
</div>    
</div>
</div>
@include('planillageneracion/export')
<script type="text/javascript" src="{{ asset('jl/core/planillas.js') }}"></script>	
<script>
$(function() {
    Pace.on("done", function(){
        $("#contents").fadeIn(300);
    });
});
</script>
@endsection