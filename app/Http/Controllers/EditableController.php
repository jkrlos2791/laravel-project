<?php namespace App\Http\Controllers;

use App\Http\Controllers\controller;
use App\Models\Editable;
use App\Models\Concepto;
use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect ; 
use Session;
use DB;


class EditableController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'editable';
	static $per_page	= '10';

	public function __construct()
	{
		
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new Editable();
		
		$this->info = $this->model->makeInfo( $this->module);
		$this->access = $this->model->validAccess($this->info['id']);
	
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'editable',
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

		$sort = (!is_null($request->input('sort')) ? $request->input('sort') : 'planilla_id'); 
		$order = (!is_null($request->input('order')) ? $request->input('order') : 'asc');
		// End Filter sort and order for query 
		// Filter Search for query		
		$filter = 'AND periodo_id = "'.Session::get('periodo_id').'"';
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
		$pagination->setPath('editable');
		
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
        $this->data['campo']	= Session::get('descripcion_itd');
		$this->data['codigo']	= Session::get('codigo_itd');
		// Render into template
		//return dd($this->data['campo']);
		return view('editable.index2',$this->data);
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
			$this->data['row'] = $this->model->getColumnTable('planillas'); 
		}
		$this->data['fields'] 		=  \SiteHelpers::fieldLang($this->info['config']['forms']);
		
		$this->data['id'] = $id;
		return view('editable.form',$this->data);
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
			return view('editable.view',$this->data);
		} else {
			return Redirect::to('editable')->with('messagetext','Record Not Found !')->with('msgstatus','error');					
		}
	}	

	function postSave( Request $request)
	{
		
		$rules = $this->validateForm();
		$validator = Validator::make($request->all(), $rules);	
		if ($validator->passes()) {
			$data = $this->validatePost('tb_editable');
			
			$data[Session::get('codigo_itd')] = $request->input('codigo');
			
			$id = $this->model->insertRow($data , $request->input('planilla_id'));
			
			if(!is_null($request->input('apply')))
			{
				$return = 'editable/update/'.$id.'?return='.self::returnUrl();
			} else {
				$return = 'editable?return='.self::returnUrl();
			}

			// Insert logs into database
			if($request->input('planilla_id') =='')
			{
				\SiteHelpers::auditTrail( $request , 'New Data with ID '.$id.' Has been Inserted !');
			} else {
				\SiteHelpers::auditTrail($request ,'Data with ID '.$id.' Has been Updated !');
			}

			return Redirect::to($return)->with('messagetext',\Lang::get('core.note_success'))->with('msgstatus','success');
			
		} else {

			return Redirect::to('editable/update/'.$request->input('planilla_id'))->with('messagetext',\Lang::get('core.note_error'))->with('msgstatus','error')
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
			return Redirect::to('editable?return='.self::returnUrl())
        		->with('messagetext', \Lang::get('core.note_success_delete'))->with('msgstatus','success'); 
	
		} else {
			return Redirect::to('editable?return='.self::returnUrl())
        		->with('messagetext','No Item Deleted')->with('msgstatus','error');				
		}

	}	

	public static function display( )
	{
		$mode  = isset($_GET['view']) ? 'view' : 'default' ;
		$model  = new Editable();
		$info = $model::makeInfo('editable');

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
				return view('editable.public.view',$data);
			} 

		} else {

			$page = isset($_GET['page']) ? $_GET['page'] : 1;
			$params = array(
				'page'		=> $page ,
				'limit'		=>  (isset($_GET['rows']) ? filter_var($_GET['rows'],FILTER_VALIDATE_INT) : 10 ) ,
				'sort'		=> 'planilla_id' ,
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
			return view('editable.public.index',$data);			
		}


	}

	function postSavepublic( Request $request)
	{
		
		$rules = $this->validateForm();
		$validator = Validator::make($request->all(), $rules);	
		if ($validator->passes()) {
			$data = $this->validatePost('planillas');		
			 $this->model->insertRow($data , $request->input('planilla_id'));
			return  Redirect::back()->with('messagetext','<p class="alert alert-success">'.\Lang::get('core.note_success').'</p>')->with('msgstatus','success');
		} else {

			return  Redirect::back()->with('messagetext','<p class="alert alert-danger">'.\Lang::get('core.note_error').'</p>')->with('msgstatus','error')
			->withErrors($validator)->withInput();

		}	
	
	}
	
	function mostrar( Request $request)
	{
			$itd = Concepto::find($request->input('habilitado'));
			Session::put('codigo_itd', $itd->codigo);
			Session::put('descripcion_itd', $itd->descripcion);
			//return dd(Session::get('descripcion_itd'));
			return  Redirect::to('editable');		
	}

	function cargarComboConceptos(){
        $concepto=Concepto::where('empresa_id', '=', 0)->where('tipo_concepto', '=', 0)->orderBy('descripcion', 'ASC')->get();
        return response()->json($concepto);
	}

	function listar( Request $request){
	    $lista="";
	    $editables=Editable::where('periodo_id','=',Session::get('periodo_id'))->get();	
	    $empleados=Empleado::where('empresa_id','=',Session::get('empresa_id'))->where('estado_empleado_id','=',1)->get();
	    
	    foreach( $editables as $editable ){
            $flag=true;
    	    foreach( $empleados as $empleado ){
    	        if($editable->id_trabajador==$empleado->id_trabajador){
    	            $flag=false;
    	            break;
    	        }
            }
            if($flag){
                $editable->delete();       
            }
	    }
	    
	    foreach( $empleados as $empleado ){
	        $flag=true;
    	    foreach( $editables as $editable ){
    	        if($empleado->id_trabajador==$editable->id_trabajador){
    	            $flag=false;
    	            break;
    	        }
            }
            if($flag){
                $nuevaPlanilla = new Editable();
    			$nuevaPlanilla->id_trabajador = $empleado->id_trabajador;
    			$nuevaPlanilla->periodo_id = Session::get('periodo_id');
    			$nuevaPlanilla->save();    
            }
	    }
		$editables=Editable::where('periodo_id','=',Session::get('periodo_id'))->get();	
        foreach( $editables as $editable ){
			$empleado=Empleado::where('id_trabajador','=',$editable->id_trabajador)->first();
            if($empleado==null){
                $empleado=new Empleado();
            }
            $lista[] = array('id' => $editable->planilla_id, 'nombres' => $empleado->ape_paterno." ".$empleado->ape_materno.", ".$empleado->nombres,'conceptos' => $editable->{$request->concepto});
        }
        return response()->json($lista);
	}
	
	function obtener( Request $request){
        $editable=Editable::find(intval($request->id));
		return response()->json(array('planilla_id' => $editable->planilla_id, 'concepto' => $editable->{$request->codigoConcepto}));
	}
	
	function grabar( Request $request){
	    if($request->idEditable!=""){
	        $editable=Editable::find(intval($request->idEditable));
	        if($editable!=null){
				$partesCantidad=explode( ',', $request->cantidad );
				$cantidad = implode("", $partesCantidad);
				$editable->{$request->codigoConcepto}=floatval($cantidad);
                $editable->save(); 
				$empleado=Empleado::where('id_trabajador','=',$editable->id_trabajador)->first();				
	        }
	    }
		return response()->json(array('id' => $editable->planilla_id, 'nombres' => $empleado->ape_paterno." ".$empleado->ape_materno.", ".$empleado->nombres,'conceptos' => $editable->{$request->codigoConcepto}));
	}
	
}