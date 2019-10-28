<?php namespace App\Models;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class ef extends Sximo  {
	
	protected $table = 'ef';
	protected $primaryKey = 'ef_id';
	public $timestamps = false;

	public function __construct() {
		parent::__construct();
	}
	
}