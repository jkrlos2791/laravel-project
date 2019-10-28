<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class serviciopropio extends Sximo  {
	
	protected $table = 'servicios_propios';
	protected $primaryKey = 'servicios_id';
	public $timestamps = false;

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT servicios_propios.* FROM servicios_propios  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE servicios_propios.servicios_id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
