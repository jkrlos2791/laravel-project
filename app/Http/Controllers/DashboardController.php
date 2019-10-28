<?php namespace App\Http\Controllers;

use App\Http\Controllers;
use Illuminate\Http\Request;
use Validator, Input, Redirect ;
use Carbon\Carbon;
use Session;

class DashboardController extends Controller {

	public function __construct()
	{
		parent::__construct();
        $this->data = array(
            'pageTitle' =>  '',
            'pageNote'  =>  '',
            
        );			
	}

	public function getIndex( Request $request )
	{
		
		$this->data['online_users'] = \DB::table('tb_users')->orderBy('last_activity','desc')->limit(10)->get(); 
		$this->data['active'] = '';
		if(Session::get('fid') == null){
		    //return Redirect::to('empresa/update/');	
		     return redirect()->guest('user/login');
		}
		    //return view('dashboard.pasos',$this->data);
            return view('principal.index2',$this->data);
	}	

	public function getDashboard()
	{
		
	}


}