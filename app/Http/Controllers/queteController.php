<?php namespace App\Http\Controllers;
use App\Http\Controllers\controller;
use App\Models\quete;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect ; 
use Session;

class queteController extends Controller {

	public function __construct(){
	}
	
	function obtenerChart(){
        $lista=Chart::get();
        return response()->json($lista);
	}

    public function index( Request $request ){
		return view('quete.index');
	}	
	
}