<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class liquidacion extends Sximo  {
	
	protected $table = 'liquidaciones';
	protected $primaryKey = 'liquidacion_id';
	public $timestamps = false;

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT liquidaciones.* FROM liquidaciones  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE liquidaciones.liquidacion_id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
