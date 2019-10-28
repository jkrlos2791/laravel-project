<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class rentaquinta extends Sximo  {
	
	protected $table = 'quinta_retenciones';
	protected $primaryKey = 'quinta_id';
    public $timestamps = false;
	
	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT quinta_retenciones.* FROM quinta_retenciones  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE quinta_retenciones.quinta_id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
