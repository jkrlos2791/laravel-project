<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class tipopago extends Sximo  {
	
	protected $table = 'tipo_pago';
	protected $primaryKey = 'tipo_pago_id';
	public $timestamps = false;

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT tipo_pago.* FROM tipo_pago  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE tipo_pago.tipo_pago_id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
