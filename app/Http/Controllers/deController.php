<?php namespace App\Http\Controllers;
use App\Http\Controllers\controller;
use App\Models\de;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect ; 
use Session;

class deController extends Controller {

	public function __construct(){
	}
	
	function obtenerChart(){
        $lista=Chart::get();
        return response()->json($lista);
	}

    public function index( Request $request ){
		return view('de.index');
	}	
	
}