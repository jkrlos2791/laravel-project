<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class niveleducativo extends Sximo  {
	
	protected $table = 'nivel_educativo';
	protected $primaryKey = 'nivel_educativo_id';
	public $timestamps = false;

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT nivel_educativo.* FROM nivel_educativo  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE nivel_educativo.nivel_educativo_id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
