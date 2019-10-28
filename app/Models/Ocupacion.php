<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class ocupacion extends Sximo  {
	
	protected $table = 'ocupacion';
	protected $primaryKey = 'ocupacion_id';
	public $timestamps = false;

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT ocupacion.* FROM ocupacion  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE ocupacion.ocupacion_id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
