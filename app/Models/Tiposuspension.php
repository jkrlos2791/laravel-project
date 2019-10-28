<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class tiposuspension extends Sximo  {
	
	protected $table = 'tipo_suspensiones';
	protected $primaryKey = 'tipo_suspension_id';
	public $timestamps = false;

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT tipo_suspensiones.* FROM tipo_suspensiones  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE tipo_suspensiones.tipo_suspension_id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
