<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class tipotrabajador extends Sximo  {
	
	protected $table = 'tipo_trabajador';
	protected $primaryKey = 'tipo_trabajador_id';
	public $timestamps = false;

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT tipo_trabajador.* FROM tipo_trabajador  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE tipo_trabajador.tipo_trabajador_id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
