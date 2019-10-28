<?php namespace App\Http\Controllers;
use App\Http\Controllers\controller;
use App\Models\modulo;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect ; 
use Session;

class moduloController extends Controller {

	protected $data = array();	
	public $module = 'dato';
	static $per_page	= '10';

	public function __construct(){
	}
	
	function obtenerChart(){
        $lista=Chart::get();
        return response()->json($lista);
	}

    public function index( Request $request ){
		return view('modulo.index');
	}	
	
}