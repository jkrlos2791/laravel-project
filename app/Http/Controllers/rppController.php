<?php namespace App\Http\Controllers;
use App\Http\Controllers\controller;
use App\Models\rpp;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect ; 
use Session;

class rppController extends Controller {

	public function __construct(){
	}
	
	function obtenerChart(){
        $lista=Chart::get();
        return response()->json($lista);
	}

    public function index( Request $request ){
		return view('rpp.index');
	}	
	
}