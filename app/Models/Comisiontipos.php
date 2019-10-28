<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class comisiontipos extends Sximo  {
	
	protected $table = 'comision_tipos';
	protected $primaryKey = 'comision_tipo_id';
	public $timestamps = false;

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT comision_tipos.* FROM comision_tipos  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE comision_tipos.comision_tipo_id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
