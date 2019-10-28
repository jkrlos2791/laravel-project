<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class horasextras extends Sximo  {
	
	protected $table = 'horas_extras';
	protected $primaryKey = 'hora_id';
	public $timestamps = false;

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT horas_extras.* FROM horas_extras  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE horas_extras.hora_id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
