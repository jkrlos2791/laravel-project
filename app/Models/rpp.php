<?php namespace App\Models;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class rpp extends Sximo  {
	
	protected $table = 'rpp';
	protected $primaryKey = 'rpp_id';
	public $timestamps = false;

	public function __construct() {
		parent::__construct();
	}
	
}