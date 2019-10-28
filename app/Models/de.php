<?php namespace App\Models;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class de extends Sximo  {
	
	protected $table = 'de';
	protected $primaryKey = 'de_id';
	public $timestamps = false;

	public function __construct() {
		parent::__construct();
	}
	
}