<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class nacionalidad extends Sximo  {
	
	protected $table = 'nacionalidad';
	protected $primaryKey = 'nacionalidad_id';
	public $timestamps = false;

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT nacionalidad.* FROM nacionalidad  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE nacionalidad.nacionalidad_id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
