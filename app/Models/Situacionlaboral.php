<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class situacionlaboral extends Sximo  {
	
	protected $table = 'situacion_laboral';
	protected $primaryKey = 'laboral_id';
	public $timestamps = false;

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT situacion_laboral.* FROM situacion_laboral  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE situacion_laboral.laboral_id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
