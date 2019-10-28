<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class situacionespecial extends Sximo  {
	
	protected $table = 'situacion_especial';
	protected $primaryKey = 'situacion_especial_id';
	public $timestamps = false;

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT situacion_especial.* FROM situacion_especial  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE situacion_especial.situacion_especial_id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
