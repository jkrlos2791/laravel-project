<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class chart extends Sximo  {
	
	protected $table = 'charts';
	protected $primaryKey = 'id_chart';
    public $timestamps = false;

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT jl_empleados.* FROM jl_empleados  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE jl_empleados.id_trabajador IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
