<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class gratificacion extends Sximo  {
	
	protected $table = 'gratificaciones';
	protected $primaryKey = 'gratificacion_id';
	public $timestamps = false;

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT gratificaciones.* FROM gratificaciones  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE gratificaciones.gratificacion_id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
