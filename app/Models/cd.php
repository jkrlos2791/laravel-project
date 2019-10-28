<?php namespace App\Models;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class cd extends Sximo  {
	
	protected $table = 'cd';
	protected $primaryKey = 'cd_id';
	public $timestamps = false;

	public function __construct() {
		parent::__construct();
	}
	
}