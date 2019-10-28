<?php namespace App\Http\Controllers;

use App\Models\Suspension;
use App\Models\Empleado;
use App\Models\Contrato;
use App\Models\Gratificacion;
use App\Http\Controllers\controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect ; 
use Session;
use DB;


class GratificacionController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'gratificacion';
	static $per_page	= '10';

	public function __construct()
	{
		
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new Gratificacion();
		
		$this->info = $this->model->makeInfo( $this->module);
		$this->access = $this->model->validAccess($this->info['id']);
	
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'gratificacion',
			'return'	=> self::returnUrl()
			
		);
		
		\App::setLocale(CNF_LANG);
		if (defined('CNF_MULTILANG') && CNF_MULTILANG == '1') {

		$lang = (\Session::get('lang') != "" ? \Session::get('lang') : CNF_LANG);
		\App::setLocale($lang);
		}  


		
	}

	public function getIndex( Request $request )
	{
		if(Session::get('empresa_id') == null){
        return Redirect::to('dashboard');	
		}

		if($this->access['is_view'] ==0) 
			return Redirect::to('dashboard')
				->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');

		$sort = (!is_null($request->input('sort')) ? $request->input('sort') : 'gratificacion_id'); 
		$order = (!is_null($request->input('order')) ? $request->input('order') : 'asc');
		// End Filter sort and order for query 
		// Filter Search for query		
		$filter = '';	
		if(!is_null($request->input('search')))
		{
			$search = 	$this->buildSearch('maps');
			$filter = $search['param'];
			$this->data['search_map'] = $search['maps'];
		} 

		
		$page = $request->input('page', 1);
		$params = array(
			'page'		=> $page ,
			'limit'		=> (!is_null($request->input('rows')) ? filter_var($request->input('rows'),FILTER_VALIDATE_INT) : static::$per_page ) ,
			'sort'		=> $sort ,
			'order'		=> $order,
			'params'	=> $filter,
			'global'	=> (isset($this->access['is_global']) ? $this->access['is_global'] : 0 )
		);
		// Get Query 
		$results = $this->model->getRows( $params );		
		
		// Build pagination setting
		$page = $page >= 1 && filter_var($page, FILTER_VALIDATE_INT) !== false ? $page : 1;	
		$pagination = new Paginator($results['rows'], $results['total'], $params['limit']);	
		$pagination->setPath('gratificacion');
		
		$this->data['rowData']		= $results['rows'];
		// Build Pagination 
		$this->data['pagination']	= $pagination;
		// Build pager number and append current param GET
		$this->data['pager'] 		= $this->injectPaginate();	
		// Row grid Number 
		$this->data['i']			= ($page * $params['limit'])- $params['limit']; 
		// Grid Configuration 
		$this->data['tableGrid'] 	= $this->info['config']['grid'];
		$this->data['tableForm'] 	= $this->info['config']['forms'];	
		// Group users permission
		$this->data['access']		= $this->access;
		// Detail from master if any
		
		// Master detail link if any 
		$this->data['subgrid']	= (isset($this->info['config']['subgrid']) ? $this->info['config']['subgrid'] : array()); 
		// Render into template
		return view('gratificacion.index',$this->data);
	}	



	function getUpdate(Request $request, $id = null)
	{
	
		if($id =='')
		{
			if($this->access['is_add'] ==0 )
			return Redirect::to('dashboard')->with('messagetext',\Lang::get('core.note_restric'))->with('msgstatus','error');
		}	
		
		if($id !='')
		{
			if($this->access['is_edit'] ==0 )
			return Redirect::to('dashboard')->with('messagetext',\Lang::get('core.note_restric'))->with('msgstatus','error');
		}				
				
		$row = $this->model->find($id);
		if($row)
		{
			$this->data['row'] =  $row;
		} else {
			$this->data['row'] = $this->model->getColumnTable('gratificaciones'); 
		}
		$this->data['fields'] 		=  \SiteHelpers::fieldLang($this->info['config']['forms']);
		
		$this->data['id'] = $id;
		return view('gratificacion.form',$this->data);
	}	

	public function getShow( Request $request, $id = null)
	{

		if($this->access['is_detail'] ==0) 
		return Redirect::to('dashboard')
			->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');
					
		$row = $this->model->getRow($id);
		if($row)
		{
			$this->data['row'] =  $row;
			$this->data['fields'] 		=  \SiteHelpers::fieldLang($this->info['config']['grid']);
			$this->data['id'] = $id;
			$this->data['access']		= $this->access;
			$this->data['subgrid']	= (isset($this->info['config']['subgrid']) ? $this->info['config']['subgrid'] : array()); 
			$this->data['prevnext'] = $this->model->prevNext($id);
			return view('gratificacion.view',$this->data);
		} else {
			return Redirect::to('gratificacion')->with('messagetext','Record Not Found !')->with('msgstatus','error');					
		}
	}	

	function postSave( Request $request)
	{
		
		$rules = $this->validateForm();
		$validator = Validator::make($request->all(), $rules);	
		if ($validator->passes()) {
			$data = $this->validatePost('tb_gratificacion');
				
			$id = $this->model->insertRow($data , $request->input('gratificacion_id'));
			
			if(!is_null($request->input('apply')))
			{
				$return = 'gratificacion/update/'.$id.'?return='.self::returnUrl();
			} else {
				$return = 'gratificacion?return='.self::returnUrl();
			}

			// Insert logs into database
			if($request->input('gratificacion_id') =='')
			{
				\SiteHelpers::auditTrail( $request , 'New Data with ID '.$id.' Has been Inserted !');
			} else {
				\SiteHelpers::auditTrail($request ,'Data with ID '.$id.' Has been Updated !');
			}

			return Redirect::to($return)->with('messagetext',\Lang::get('core.note_success'))->with('msgstatus','success');
			
		} else {

			return Redirect::to('gratificacion/update/'.$request->input('gratificacion_id'))->with('messagetext',\Lang::get('core.note_error'))->with('msgstatus','error')
			->withErrors($validator)->withInput();
		}	
	
	}	

	public function postDelete( Request $request)
	{
		
		if($this->access['is_remove'] ==0) 
			return Redirect::to('dashboard')
				->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');
		// delete multipe rows 
		if(count($request->input('ids')) >=1)
		{
			$this->model->destroy($request->input('ids'));
			
			\SiteHelpers::auditTrail( $request , "ID : ".implode(",",$request->input('ids'))."  , Has Been Removed Successfull");
			// redirect
			return Redirect::to('gratificacion?return='.self::returnUrl())
        		->with('messagetext', \Lang::get('core.note_success_delete'))->with('msgstatus','success'); 
	
		} else {
			return Redirect::to('gratificacion?return='.self::returnUrl())
        		->with('messagetext','No Item Deleted')->with('msgstatus','error');				
		}

	}	

	public static function display( )
	{
		$mode  = isset($_GET['view']) ? 'view' : 'default' ;
		$model  = new Gratificacion();
		$info = $model::makeInfo('gratificacion');

		$data = array(
			'pageTitle'	=> 	$info['title'],
			'pageNote'	=>  $info['note']
			
		);

		if($mode == 'view')
		{
			$id = $_GET['view'];
			$row = $model::getRow($id);
			if($row)
			{
				$data['row'] =  $row;
				$data['fields'] 		=  \SiteHelpers::fieldLang($info['config']['grid']);
				$data['id'] = $id;
				return view('gratificacion.public.view',$data);
			} 

		} else {

			$page = isset($_GET['page']) ? $_GET['page'] : 1;
			$params = array(
				'page'		=> $page ,
				'limit'		=>  (isset($_GET['rows']) ? filter_var($_GET['rows'],FILTER_VALIDATE_INT) : 10 ) ,
				'sort'		=> 'gratificacion_id' ,
				'order'		=> 'asc',
				'params'	=> '',
				'global'	=> 1 
			);

			$result = $model::getRows( $params );
			$data['tableGrid'] 	= $info['config']['grid'];
			$data['rowData'] 	= $result['rows'];	

			$page = $page >= 1 && filter_var($page, FILTER_VALIDATE_INT) !== false ? $page : 1;	
			$pagination = new Paginator($result['rows'], $result['total'], $params['limit']);	
			$pagination->setPath('');
			$data['i']			= ($page * $params['limit'])- $params['limit']; 
			$data['pagination'] = $pagination;
			return view('gratificacion.public.index',$data);			
		}


	}

	function postSavepublic( Request $request)
	{
		
		$rules = $this->validateForm();
		$validator = Validator::make($request->all(), $rules);	
		if ($validator->passes()) {
			$data = $this->validatePost('gratificaciones');		
			 $this->model->insertRow($data , $request->input('gratificacion_id'));
			return  Redirect::back()->with('messagetext','<p class="alert alert-success">'.\Lang::get('core.note_success').'</p>')->with('msgstatus','success');
		} else {

			return  Redirect::back()->with('messagetext','<p class="alert alert-danger">'.\Lang::get('core.note_error').'</p>')->with('msgstatus','error')
			->withErrors($validator)->withInput();

		}	
	
	}	

     function calculo (){
		   //Eliminar Gratificaciones		   		   
		   $gratificaciones = Gratificacion::where('periodo_id', '=', Session::get('periodo_id'))->get();
		   $empleados = Empleado::where('empresa_id', '=', Session::get('empresa_id'))->get();
		   foreach ($gratificaciones as $gratificacion) {
		   	  foreach ($empleados as $empleado) {
				if($gratificacion->id_trabajador == $empleado->id_trabajador){
				$gratificacion->delete();	
				}  
			  } 
		   }
		   //Calcular Gratificaciones
		   $empleados = Empleado::where('empresa_id', '=', Session::get('empresa_id'))->get();
		   foreach ($empleados as $empleado) {			   
		   $gratificacion = new Gratificacion(); 
		   $gratificacion->id_trabajador = $empleado->id_trabajador;
		   $gratificacion->periodo_id = Session::get('periodo_id');
		   $contrato = Contrato::where('id_trabajador','=',$gratificacion->id_trabajador)->orderBy('contrato_id','asc')->first();
		   $gratificacion->haber_basico = $contrato->sueldo;
		   if( $empleado->carga_familiar == 1 ) { 
		   $gratificacion->asig_fam = 85; 
		   }
		   $gratificacion->total_rem_com = $gratificacion->haber_basico+$gratificacion->asig_fam+$gratificacion->pro_rem_var;		   
		   if(date("Y", strtotime($contrato->fecha_ingreso))<Session::get('anio')){
		   $gratificacion->ts_meses = 6;
		   $gratificacion->ts_dias = 0;
		   }	
           else{
		   if(date("j", strtotime($contrato->fecha_ingreso))>1){
		   $gratificacion->ts_meses = 6 - date("n", strtotime($contrato->fecha_ingreso));
		   $gratificacion->ts_dias = cal_days_in_month(CAL_GREGORIAN, date("n", strtotime($contrato->fecha_ingreso)), 
		   date("Y", strtotime($contrato->fecha_ingreso))) - date("j", strtotime($contrato->fecha_ingreso)) + 1;
		   }
		   else{
		   $gratificacion->ts_meses = 6 - date("n", strtotime($contrato->fecha_ingreso)) + 1;   
		   $gratificacion->ts_dias = 0;
		   }
		   }
           $suspensiones = Suspension::where('id_trabajador', '=', $empleado->id_trabajador)->get();
		   $dias_faltas=0;
		   foreach ($suspensiones as $suspension){
		   if(date("Y", strtotime($suspension->fecha_inicio))==Session::get('anio') && date("n", strtotime($suspension->fecha_inicio))<=6){
		   $dias_faltas = $suspension->nro_dias + $dias_faltas;	   
		   }
		   }
		   $gratificacion->faltas = $dias_faltas;	
           $total_dias_computables=$gratificacion->ts_meses*30+$gratificacion->ts_dias-$gratificacion->faltas;
           $gratificacion->tc_meses = floor($total_dias_computables / 30);   
		   $gratificacion->tc_dias = $total_dias_computables % 30;
           $gratificacion->grati_30334 = +($gratificacion->total_rem_com / 6 * $gratificacion->tc_meses) + 
		   ($gratificacion->total_rem_com / 180 * $gratificacion->tc_dias); 
           if($empleado->servicios_propios!=1){
		   $gratificacion->boni_30334 = $gratificacion->grati_30334 * 6.75 / 100;	   
		   }
           else{
		   $gratificacion->boni_30334 = $gratificacion->grati_30334 * 9 / 100;   
		   }		   
		   $gratificacion->total_grati = $gratificacion->grati_30334 + $gratificacion->boni_30334;
		   $gratificacion->save(); 
		   }
	       return Redirect::to('gratificacion')->with('message', 'El cálculo se realizó con éxito.');   	        
   }

}