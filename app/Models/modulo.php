<?php namespace App\Models;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class modulo extends Sximo  {
	
	protected $table = 'modulo';
	protected $primaryKey = 'modulo_id';
	public $timestamps = false;

	public function __construct() {
		parent::__construct();
	}
	
}