<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class periocidad extends Sximo  {
	
	protected $table = 'periocidad';
	protected $primaryKey = 'periodo_id';
	public $timestamps = false;

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT periocidad.* FROM periocidad  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE periocidad.periodo_id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
