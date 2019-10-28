<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class parametria extends Sximo  {
	
	protected $table = 'parametria';
	protected $primaryKey = 'parametria_id';
	public $timestamps = false;

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT parametria.* FROM parametria  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE parametria.parametria_id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
