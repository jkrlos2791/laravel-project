<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class categoriaocupacional extends Sximo  {
	
	protected $table = 'categoria_ocupacional';
	protected $primaryKey = 'cat_ocupacional_id';
	public $timestamps = false;

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT categoria_ocupacional.* FROM categoria_ocupacional  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE categoria_ocupacional.cat_ocupacional_id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
