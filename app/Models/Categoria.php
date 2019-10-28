<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class categoria extends Sximo  {
	
	protected $table = 'categorias';
	protected $primaryKey = 'categoria_id';
	public $timestamps = false;

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT categorias.* FROM categorias  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE categorias.categoria_id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
