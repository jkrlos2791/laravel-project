<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class anio extends Sximo  {
	
	protected $table = 'anios';
	protected $primaryKey = 'anio_id';
	public $timestamps = false;

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT anios.* FROM anios  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE anios.anio_id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
