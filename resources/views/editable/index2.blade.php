@extends('layouts.app2')
@section('content')
<div class="card">
<div class="card-header"><i class="fas fa-table"></i> Conceptos y Afectaciones</div>
<div class="card-body">
<div class="row">
    <div class="col-lg-12">
            <h5 id="tituloConcepto" class="d-flex justify-content-center mb-4"></h5>  
            <a id="buscar" class="btn btn-dark mb-4" role="button" href="javascript:void(0);" title="Buscar"><i class="fas fa-search"></i> Buscar</a>			
            <a id="editar" class="btn btn-dark mb-4" role="button" href="javascript:void(0);" title="Editar"><i class="fas fa-edit"></i> Editar</a>
    </div>
    <div class="col-lg-12">
        <table id="conceptos" class="table table-striped table-bordered" style="width:100%">
        </table>
    </div>
</div>
</div>
</div>
@include('editable/search')
@include('editable/form2')
<script type="text/javascript" src="{{ asset('jl/core/conceptos.js') }}"></script>		
<script>
$(function() {
    Pace.on("done", function(){
        $("#contents").fadeIn(300);
    });
});
</script>
@endsection