<?php namespace App\Models;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class chart extends Sximo  {
	
	protected $table = 'data';
	protected $primaryKey = 'id_data';

	public function __construct() {
		parent::__construct();
		
	}
	
}