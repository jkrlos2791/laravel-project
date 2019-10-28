<?php namespace App\Http\Controllers;

use App\Http\Controllers\controller;
use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect ; 
use Session;

class ServiciosShangelController extends Controller {
	
	function obtenerEmpresa(Request $request){
		$empresa = Empresa::where('ruc','=',$request->nro)->first();
		if($empresa==null){
		    return $empresa="princesa esa empresa no existe.";
		}
		return $empresa->razon_social;
	}

}