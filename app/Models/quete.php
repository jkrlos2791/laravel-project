<?php namespace App\Models;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class quete extends Sximo  {
	
	protected $table = 'quete';
	protected $primaryKey = 'quete_id';
	public $timestamps = false;

	public function __construct() {
		parent::__construct();
	}
	
}