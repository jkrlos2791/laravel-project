<?php namespace App\Http\Controllers;
use App\Http\Controllers\controller;
use App\Models\rasen;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect ; 
use Session;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class rasenController extends Controller {

	public function __construct(){
	}

    public function index( Request $request ){
		return view('rasen.index');
	}
	
	function listar(){
        $lista=rasen::get();
        return response()->json($lista);
	}
	
	function cabecera(){
	    
        $lista=Schema::getColumnListing('rasen');
        return response()->json($lista);
	}
	
	function graficar(Request $request){
	    if($request->campo!=null){
            $campo=$request->campo;
	    }
	    else{
            $campo='raz_soc';  
	    }
	    $condiciones =rasen::select($campo)->distinct()->get();
	    $lista = array();
	    $lista1 = array();
	    $lista2 = array();
        foreach ($condiciones as $condicion) {	
            $valor=rasen::where($campo,'=',$condicion->$campo)->count();
            array_push($lista1, $condicion->$campo);
            array_push($lista2, $valor);
        }   
        array_push($lista, $lista1, $lista2);
        return response()->json($lista);
	}
	
}