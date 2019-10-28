@extends('layouts.app2')
@section('content')
<div class="card">
<div class="card-header"><i class="fas fa-table"></i> Principal</div>
<div class="card-body">
<div class="row">
    <div class="col-lg-12" id="sectorIngresarEmpresa">
			<div class="col-md-12">
        		  <div class="form-group row " >
                    <label class=" control-label col-md-1 text-left"> Empresa </label>
        			<div class="col-md-5">
        			    <select id="empresaIngresar" name="empresaIngresar" class="form-control" >
        			    </select>  
        			 </div>
        			 <div class="col-md-4">
        			 </div> 
        		  </div> 					
			</div>
    </div>
    <div class="col-lg-12">
    </div>
</div>
</div>
</div>
<script type="text/javascript" src="{{ asset('jl/core/principales.js') }}"></script>	
<script>
$(function() {
    Pace.on("done", function(){
        $("#contents").fadeIn(300);
    });
});
</script>
@endsection