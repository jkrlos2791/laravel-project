<?php namespace App\Models;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class rasen extends Sximo  {
	
	protected $table = 'rasen';
	protected $primaryKey = 'rasen_id';
	public $timestamps = false;

	public function __construct() {
		parent::__construct();
	}
	
}