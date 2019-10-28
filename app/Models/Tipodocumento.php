<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class tipodocumento extends Sximo  {
	
	protected $table = 'tipo_documento';
	protected $primaryKey = 'tipo_documento_id';
	public $timestamps = false;

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT tipo_documento.* FROM tipo_documento  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE tipo_documento.tipo_documento_id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
