<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class snpafp extends Sximo  {
	
	protected $table = 'snp_afps';
	protected $primaryKey = 'snp_afp_id';
	public $timestamps = false;

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT snp_afps.* FROM snp_afps  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE snp_afps.snp_afp_id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
