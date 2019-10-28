<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class mes extends Sximo  {
	
	protected $table = 'meses';
	protected $primaryKey = 'mes_id';
	public $timestamps = false;

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT meses.* FROM meses  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE meses.mes_id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
