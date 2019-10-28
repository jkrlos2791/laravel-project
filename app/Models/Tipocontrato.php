<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class tipocontrato extends Sximo  {
	
	protected $table = 'tipo_contrato';
	protected $primaryKey = 'tipo_contrato_id';
	public $timestamps = false;

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT tipo_contrato.* FROM tipo_contrato  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE tipo_contrato.tipo_contrato_id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
