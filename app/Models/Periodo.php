<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class periodo extends Sximo  {
	
	protected $table = 'periodos';
	protected $primaryKey = 'periodo_id';
	public $timestamps = false;

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT periodos.* FROM periodos  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE periodos.periodo_id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
