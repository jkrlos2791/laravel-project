<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class estadoempleado extends Sximo  {
	
	protected $table = 'estado_empleados';
	protected $primaryKey = 'estado_empleado_id';
	public $timestamps = false;

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT estado_empleados.* FROM estado_empleados  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE estado_empleados.estado_empleado_id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
