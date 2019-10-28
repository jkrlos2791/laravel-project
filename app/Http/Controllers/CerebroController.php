<?php namespace App\Http\Controllers;
use App\Http\Controllers\controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect ; 
use Session;
use File;
use Response;
use DB;
use ZipArchive;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\modulo;
use App\Models\Chart;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class CerebroController extends Controller {

	public function __construct(){
	}
	
	public function mostrar(Request $request){
        return view('cerebro.index');
	}
	
	public function listarModulos(Request $request){
	    $modulos=modulo::get();
	    return response()->json($modulos);
	}
	
	public function crearModulo(Request $request){
	    $this->crearModelo($request->nombre);
	    $this->crearControlador($request->nombre);
	    $this->crearVista($request->nombre);
	    $this->crearRuta($request->nombre);
	    $this->crearJs($request->nombre);
	    $this->importarData($request);
	    $modulo=$this->guardarModulo($request->nombre);
	    return response()->json($modulo);
	}
	
	public function crearModelo($nombre){
	    $ruta = "/home/asecoint/jlplanilla/app/Models/".$nombre.".php";
    	$info =
"<?php namespace App\Models;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class ".$nombre." extends Sximo  {
	
	protected \$table = '".$nombre."';
	protected \$primaryKey = '".$nombre."_id';
	public \$timestamps = false;

	public function __construct() {
		parent::__construct();
	}
	
}";
    	File::put($ruta,$info);
	}
	
	public function crearControlador($nombre){
	    $ruta = "/home/asecoint/jlplanilla/app/Http/Controllers/".$nombre."Controller.php";
    	$info =
"<?php namespace App\Http\Controllers;
use App\Http\Controllers\controller;
use App\Models\\".$nombre.";
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect ; 
use Session;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class ".$nombre."Controller extends Controller {

	public function __construct(){
	}

    public function index( Request \$request ){
		return view('".$nombre.".index');
	}
	
	function listar(){
        \$lista=".$nombre."::get();
        return response()->json(\$lista);
	}
	
	function cabecera(){
	    
        \$lista=Schema::getColumnListing('".$nombre."');
        return response()->json(\$lista);
	}
	
	function graficar(Request \$request){
	    if(\$request->campo!=null){
            \$campo=\$request->campo;
	    }
	    else{
            \$campo='raz_soc';  
	    }
	    \$condiciones =".$nombre."::select(\$campo)->distinct()->get();
	    \$lista = array();
	    \$lista1 = array();
	    \$lista2 = array();
        foreach (\$condiciones as \$condicion) {	
            \$valor=".$nombre."::where(\$campo,'=',\$condicion->\$campo)->count();
            array_push(\$lista1, \$condicion->\$campo);
            array_push(\$lista2, \$valor);
        }   
        array_push(\$lista, \$lista1, \$lista2);
        return response()->json(\$lista);
	}
	
}";
    	File::put($ruta,$info);
	}
	
	public function crearVista($nombre){
        if(!file_exists("/home/asecoint/jlplanilla/resources/views/".$nombre."")){
	        File::makeDirectory("/home/asecoint/jlplanilla/resources/views/".$nombre."");
	    }
	    $ruta = "/home/asecoint/jlplanilla/resources/views/".$nombre."/index.blade.php";
    	$info =
'@extends("layouts.app2")
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
					<table id="'.$nombre.'s" class="table table-striped table-bordered" style="width:100%"></table>
				  </div>
				</div>
			  </div>
			  
			</div>
		</div>
</div>
</div>
</div>
<script type="text/javascript" src="{{ asset("jl/core/'.$nombre.'.js") }}"></script>		
<script>
$(function() {
    Pace.on("done", function(){
        $("#contents").fadeIn(1000);
    });
});
</script>
@endsection';
    	File::put($ruta,$info);
	}
	
	public function crearJs($nombre){
	    $ruta = public_path()."/jl/core/".$nombre.".js";
    	$info =
'$(document).ready(function(){
    crearTabla();
    obtener();
    cargarCombos();
});

var ctx = document.getElementById("myChart");
var config = {
type: "bar",
data: {
    labels: [],
    datasets: [{
        label: "Datos",
        data: [],
        backgroundColor: "rgba(63, 104, 191, 0.64)",
        borderColor: "rgba(63, 104, 191, 1)",
        borderWidth: 1
    }]
},
options: {
    scales: {
        yAxes: [{
            ticks: {
                beginAtZero: true
            }
        }]
    }
}
};
var myChart = new Chart(ctx, config);

function obtener(){
	$.ajax({
        type: "get",
        url: "./'.$nombre.'Listar",
        success: function (data) {
			if(data!=""){
				$("#'.$nombre.'s").DataTable().clear().draw();
				$("#'.$nombre.'s").DataTable().rows.add(data).draw();
			}
        },
        error: function(error){
        }
    });
}

function crearDataTable(idTablaReal,data,columnas){
	var dt=$("#"+idTablaReal).DataTable({
	        language: {
                url: "./jl/datatables/language/Spanish.json"
            },
	        data: data,
			pageLength: 20,
	     	responsive:false,
	     	fixedHeader: true,
	        columns:columnas,
			select: true,
			scrollX: true,
			scrollY: "200px",
            scrollCollapse: true,
			order: [[ 1, "asc" ]],
	});
	try {
		new $.fn.dataTable.FixedHeader(dt, {
	        "alwaysCloneTop": true
		});
	} catch (e) {
	}
}

var columnas=[];
function crearTabla(){
	$.ajax({
        type: "get",
        url: "./'.$nombre.'Cabecera",
        success: function (data) {
			if(data!=""){
			    columnas.push({ data: null,defaultContent:"",className:"select-checkbox",orderable:false,"width":"2%"});
                for (var i = 0; i < data.length; i++) {
	                columnas.push({ title: data[i],data:data[i],"width": "6%" });
                }
	            crearDataTable("'.$nombre.'s",null,columnas); 
			}
        },
        error: function(error){
        }
    });
}

function cargarCombos(){
	$.ajax({
        type: "get",
        url: "./'.$nombre.'Cabecera",
        success: function (data) {
            var selectList = document.getElementById("campo");
            var option = document.createElement("option");
		    option.value = "";
		    option.text = "Seleccione...";
		    selectList.appendChild(option);
            for (var i = 0; i < data.length; i++) {
                option = document.createElement("option");
                option.value = data[i];
                option.text = data[i];
                selectList.appendChild(option);
            }    
        },
        error: function(error){
        }
    });
}

function refreshData(chart, labels, data, label) {
    chart.data.labels = labels;
    chart.data.datasets[0].label = label;
    chart.data.datasets[0].data = data;
    chart.update();
}

function actualizarChart() {
	$.ajax({
        type: "post",
        url: "./'.$nombre.'Graficar",
        data: {campo: $("#campo").val()},
        success: function (data) {
            refreshData(myChart, data[0], data[1], $("#campo").val());
        },
        error: function(error){
        }
    });
}

function actualizarTipoChart() {
    if (myChart) {
        myChart.destroy();
    }
    var temp = jQuery.extend(true, {}, config);
    temp.type = $("#tipoChart").val();
    myChart = new Chart(ctx, temp);
    myChart.update();
}';
    	File::put($ruta,$info);
	}
	
	public function crearRuta($nombre){
	    $ruta="/home/asecoint/jlplanilla/app/Http/routes.php";
	    $info="";
        $archivo = fopen($ruta, "r");
        while(!feof($archivo)){
            $linea = fgets($archivo);
            $info =$info.$linea;
        }
        fclose($archivo);
    	$info =$info."
Route::get('".$nombre."', '".$nombre."Controller@index');"."
Route::get('".$nombre."Listar', '".$nombre."Controller@listar');"."
Route::get('".$nombre."Cabecera', '".$nombre."Controller@cabecera');"."
Route::post('".$nombre."Graficar', '".$nombre."Controller@graficar');";
    	File::put($ruta,$info);
	}
	
	public function guardarModulo($nombre){
        $modulo=new modulo();
        $modulo->nombre=$nombre;
        $modulo->save();
        return $modulo;
	}
	
	public function eliminarModulo(Request $request){
	    $modulo=modulo::find($request->modulo_id);
	    $rutaModelo = "/home/asecoint/jlplanilla/app/Models/".$modulo->nombre.".php";
	    if(file_exists($rutaModelo)){
	        unlink($rutaModelo);
	    }
	    $rutaControlador = "/home/asecoint/jlplanilla/app/Http/Controllers/".$modulo->nombre."Controller.php";
	    if(file_exists($rutaControlador)){
	        unlink($rutaControlador);
	    }
	    $rutaVista = "/home/asecoint/jlplanilla/resources/views/".$modulo->nombre."";
        $this->delete_directory($rutaVista);
        Schema::dropIfExists($modulo->nombre);
        $modulo->delete();
        return response()->json($modulo);
	}
	
    function delete_directory($dirname) {
             if (is_dir($dirname))
               $dir_handle = opendir($dirname);
         if (!$dir_handle)
              return false;
         while($file = readdir($dir_handle)) {
               if ($file != "." && $file != "..") {
                    if (!is_dir($dirname."/".$file))
                         unlink($dirname."/".$file);
                    else
                         delete_directory($dirname.'/'.$file);
               }
         }
         closedir($dir_handle);
         rmdir($dirname);
         return true;
    }
    
	public function importarData($request){
		if(Input::hasFile('import_file')){
            Schema::dropIfExists($request->nombre);
            $path = Input::file('import_file')->getRealPath();
            $reader = Excel::load($path)->get();
            $headerRow = $reader->first()->keys()->toArray();
            Schema::create($request->nombre, function (Blueprint $table) use ($headerRow) {
                foreach ($headerRow as $key => $column) {	
                    $table->string($column)->nullable();
                }
            });
			$data = Excel::load($path, function($reader) {})->get();
			if(!empty($data) && $data->count()){
			    foreach ($data as $key => $value) {	
			        $model_name = app("App\\Models\\".$request->nombre);
                    $table=new $model_name;
        			foreach ($headerRow as $key => $column) {	
                        $table->$column = $value->$column;
                    }
        			$table->save();
				}        
			}
        }
	}
	
}