<?php namespace App\Http\Controllers;

use App\Http\Controllers\controller;
use App\Models\Anio;
use App\Models\Planilla;
use App\Models\Gratificacion;
use App\Models\Rentaquinta;
use App\Models\Periodo;
use App\Models\Derechohabiente;
use App\Models\Contrato;
use App\Models\Suspension;
use App\Models\Centrocosto;
use App\Models\Empleado;
use App\Models\Empresa;
use App\Models\Sector;
use App\Models\Tipodocumento;
use App\Models\Mes;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect ; 
use Session;
use DB;
use Illuminate\Support\Facades\Storage;

class EmpresaController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'empresa';
	static $per_page	= '10';

	public function __construct()
	{
		
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new Empresa();
		
		$this->info = $this->model->makeInfo( $this->module);
		$this->access = $this->model->validAccess($this->info['id']);
	
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'empresa',
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

		if($this->access['is_view'] ==0) 
			return Redirect::to('dashboard')
				->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');

		$sort = (!is_null($request->input('sort')) ? $request->input('sort') : 'empresa_id'); 
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
		$pagination->setPath('empresa');
		
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
		return view('empresa.index2',$this->data);
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
			$this->data['row'] = $this->model->getColumnTable('empresas'); 
		}
		$this->data['fields'] 		=  \SiteHelpers::fieldLang($this->info['config']['forms']);
		
		$this->data['id'] = $id;
		return view('empresa.form',$this->data);
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
			return view('empresa.view',$this->data);
		} else {
			return Redirect::to('empresa')->with('messagetext','Record Not Found !')->with('msgstatus','error');					
		}
	}	

	function postSave( Request $request)
	{
		
		$rules = $this->validateForm();
		$validator = Validator::make($request->all(), $rules);	
		if ($validator->passes()) {
			$data = $this->validatePost('tb_empresa');
				
			$id = $this->model->insertRow($data , $request->input('empresa_id'));
			
			$periodo = Periodo::where('empresa_id','=',$id)->first();
			$fecha_actual = getdate();
			if($periodo == null){
			$anio = Anio::where('anio','=',strval($fecha_actual['year']))->first();
			if($anio == null){
			$anio = new Anio();
			$anio->anio = $fecha_actual['year'];
			$anio->save();		
			}
			$periodo = new Periodo();
			$periodo->mes_id = $fecha_actual['mon'];
			$periodo->anio_id = $anio->anio_id;
			$periodo->empresa_id = $id;
			$periodo->save();
			}
			
			if(!is_null($request->input('apply')))
			{
				$return = 'empresa/update/'.$id.'?return='.self::returnUrl();
			} else {
				$return = 'empresa?return='.self::returnUrl();
			}

			// Insert logs into database
			if($request->input('empresa_id') =='')
			{
				\SiteHelpers::auditTrail( $request , 'New Data with ID '.$id.' Has been Inserted !');
			} else {
				\SiteHelpers::auditTrail($request ,'Data with ID '.$id.' Has been Updated !');
			}

			return Redirect::to($return)->with('messagetext',\Lang::get('core.note_success'))->with('msgstatus','success');
			
		} else {

			return Redirect::to('empresa/update/'.$request->input('empresa_id'))->with('messagetext',\Lang::get('core.note_error'))->with('msgstatus','error')
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
			return Redirect::to('empresa?return='.self::returnUrl())
        		->with('messagetext', \Lang::get('core.note_success_delete'))->with('msgstatus','success'); 
	
		} else {
			return Redirect::to('empresa?return='.self::returnUrl())
        		->with('messagetext','No Item Deleted')->with('msgstatus','error');				
		}

	}	

	public static function display( )
	{
		$mode  = isset($_GET['view']) ? 'view' : 'default' ;
		$model  = new Empresa();
		$info = $model::makeInfo('empresa');

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
				return view('empresa.public.view',$data);
			} 

		} else {

			$page = isset($_GET['page']) ? $_GET['page'] : 1;
			$params = array(
				'page'		=> $page ,
				'limit'		=>  (isset($_GET['rows']) ? filter_var($_GET['rows'],FILTER_VALIDATE_INT) : 10 ) ,
				'sort'		=> 'empresa_id' ,
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
			return view('empresa.public.index',$data);			
		}


	}

	function postSavepublic( Request $request)
	{
		
		$rules = $this->validateForm();
		$validator = Validator::make($request->all(), $rules);	
		if ($validator->passes()) {
			$data = $this->validatePost('empresas');		
			 $this->model->insertRow($data , $request->input('empresa_id'));
			return  Redirect::back()->with('messagetext','<p class="alert alert-success">'.\Lang::get('core.note_success').'</p>')->with('msgstatus','success');
		} else {

			return  Redirect::back()->with('messagetext','<p class="alert alert-danger">'.\Lang::get('core.note_error').'</p>')->with('msgstatus','error')
			->withErrors($validator)->withInput();

		}	
	
	}
	
	public function ingresar(Request $request)
	{
            $empresa_id = $request->input('empresa');
            $empresa = \App\Models\Empresa::find($empresa_id);
			Session::put('oempresa', $empresa);
            Session::put('empresa_id', $empresa->empresa_id);
            Session::put('sector_id', $empresa->sector_id)  ;
            Session::put('empresa', $empresa->razon_social);
            $periodo = Periodo::where('empresa_id', '=', Session::get('empresa_id'))->orderBy('periodo_id', 'DESC')->first();
			if($periodo==null){
			$hoy = getdate();
			$anio = Anio::where('anio', '=', $hoy['year'])->first();
			if($anio==null){
			$anio = new Anio();
			$anio->anio = $hoy['year'];
			$anio->save();	
			}
			$periodo = new Periodo();
			$periodo->mes_id = $hoy['mon'];
			$periodo->anio_id = $anio->anio_id;
			$periodo->empresa_id = $empresa->empresa_id;
			$periodo->save();
			}
			$mes = DB::table('meses')->where('mes_id','=',$periodo->mes_id)->first();
		    $anio = DB::table('anios')->where('anio_id','=',$periodo->anio_id)->first();
			Session::put('periodo_id', $periodo->periodo_id);
			Session::put('semana_id', '26');
			Session::put('mes', $mes->mes);
			Session::put('mes_codigo', $mes->codigo);
			Session::put('mes_id', $periodo->mes_id);
            Session::put('anio', $anio->anio);
            Session::put('trabajador_id', null);
            Session::put('afp_id', null);
			return Redirect::to('empresa/update/'.$empresa_id);
	}

    public function eliminar( Request $request)
	{
		if($request->input('empresa_id')!=null){	
           //Eliminar Planillas		   		   
		   $planillas = Planilla::get();
		   $periodos = Periodo::where('empresa_id', '=', $request->input('empresa_id'))->get();
		   foreach ($planillas as $planilla) {
		   	  foreach ($periodos as $periodo) {
				if($planilla->periodo_id == $periodo->periodo_id){
				$planilla->delete();	
				}  
			  } 
		   }		
		   //Eliminar Gratificaciones		   		   
		   $gratificaciones = Gratificacion::get();
		   $periodos = Periodo::where('empresa_id', '=', $request->input('empresa_id'))->get();
		   foreach ($gratificaciones as $gratificacion) {
		   	  foreach ($periodos as $periodo) {
				if($gratificacion->periodo_id == $periodo->periodo_id){
				$gratificacion->delete();	
				}  
			  } 
		   }
		   //Eliminar Retenciones 5ta		   		   
		   $retenciones = Rentaquinta::get();
		   $periodos = Periodo::where('empresa_id', '=', $request->input('empresa_id'))->get();
		   foreach ($retenciones as $retencion) {
		   	  foreach ($periodos as $periodo) {
				if($retencion->periodo_id == $periodo->periodo_id){
				$retencion->delete();	
				}  
			  } 
		   }
		   //Eliminar Periodos
		   $empleados = Periodo::where('empresa_id', '=', $request->input('empresa_id'))->delete();
		   //Eliminar Derecho Habientes		   		   
		   $habientes = Derechohabiente::get();
		   $empleados = Empleado::where('empresa_id', '=', $request->input('empresa_id'))->get();
		   foreach ($habientes as $habiente) {
		   	  foreach ($empleados as $empleado) {
				if($habiente->id_trabajador == $empleado->id_trabajador){
				$habiente->delete();	
				}  
			  } 
		   }
           //Eliminar Contratos		   		   
		   $contratos = Contrato::get();
		   $empleados = Empleado::where('empresa_id', '=', $request->input('empresa_id'))->get();
		   foreach ($contratos as $contrato) {
		   	  foreach ($empleados as $empleado) {
				if($contrato->id_trabajador == $empleado->id_trabajador){
				$contrato->delete();	
				}  
			  } 
		   }
		   //Eliminar Suspensiones		   		   
		   $suspensiones = Suspension::get();
		   $empleados = Empleado::where('empresa_id', '=', $request->input('empresa_id'))->get();
		   foreach ($suspensiones as $suspension) {
		   	  foreach ($empleados as $empleado) {
				if($suspension->id_trabajador == $empleado->id_trabajador){
				$suspension->delete();	
				}  
			  } 
		   }
		   //Eliminar Centro de costos
		   $centroCostos = Centrocosto::where('empresa_id', '=', $request->input('empresa_id'))->delete();
		   //Eliminar Empleados
		   $empleados = Empleado::where('empresa_id', '=', $request->input('empresa_id'))->delete();
		   //Eliminar Empresa
		   $empresa = Empresa::find($request->input('empresa_id'));
		   $empresa->delete();
		    //Limpiar Sesión
            Session::put('empresa_id', null);
            Session::put('sector_id', null)  ;
            Session::put('empresa', null);
			Session::put('periodo_id', null);
			Session::put('semana_id', null);
			Session::put('mes', null);
            Session::put('anio', null);
            Session::put('trabajador_id', null);
            Session::put('afp_id', null);
	    }
		return Redirect::to('empresa/update')->with('messagetext', \Lang::get('core.note_success_delete'))->with('msgstatus','success'); 
	}
	
	function cargarComboEmpresas(){
        $lista=Empresa::orderBy('razon_social', 'ASC')->get();
        return response()->json($lista);
	}
	
	function capturarIdEmpresa(Request $request){
        Session::put('empresa_id_form', $request->empresa);
		$id=Session::get('empresa_id_form');
        return response()->json($id);
	}
	
	function cargarComboSectores(){
        $lista=Sector::orderBy('nombre', 'ASC')->get();
		return response()->json($lista);
	}

	function cargarComboDocumentos(){
        $lista=Tipodocumento::orderBy('tipo_documento_id', 'ASC')->get();
		return response()->json($lista);
	}

	function cargarComboMeses(){
        $lista=Mes::orderBy('mes_id', 'ASC')->get();
		return response()->json($lista);
	}
	
	function cargarComboAnios(){
        $lista=Anio::orderBy('anio_id', 'ASC')->get();
		return response()->json($lista);
	}

	function obtenerEmpresa(){
		if(Session::get('empresa_id_form')!=null){
			$empresa=Empresa::find(Session::get('empresa_id_form'));	
		}
		else{
			$empresa="";	
		}		
        return response()->json($empresa);
	}

	function listarPeriodos(){
		$lista="";
		if(Session::get('empresa_id_form')!=null && Session::get('empresa_id_form')!=""){
			$periodos=Periodo::where('empresa_id','=',Session::get('empresa_id_form'))->orderBy('mes_id', 'desc')->orderBy('anio_id', 'desc')->get();
			foreach( $periodos as $periodo ){
				$mes=Mes::where('mes_id','=',$periodo->mes_id)->first();
				if($mes==null){
					$mes=new Mes();
				}
				$anio=Anio::where('anio_id','=',$periodo->anio_id)->first();
				if($anio==null){
					$anio=new Anio();
				}
				$lista[] = array('periodo_id' => $periodo->periodo_id, 'mes' => $mes->mes, 'anio' => $anio->anio);
			}
		}
        return response()->json($lista);
	}

	function listarCentroCostos(){
		$lista="";
		if(Session::get('empresa_id_form')!=null && Session::get('empresa_id_form')!=""){
			$centroCostos=Centrocosto::where('empresa_id','=',Session::get('empresa_id_form'))->get();
			foreach( $centroCostos as $centroCosto ){
				$lista[] = array('centro_costo_id' => $centroCosto->centro_costo_id, 'centro_costo' => $centroCosto->centro_costo);
			}
		}
        return response()->json($lista);
	}

	function grabar( Request $request){
	    if($request->idEmpresa!=""){
	        $empresa=Empresa::find(intval($request->idEmpresa));
	    }
	    else{
    	    $empresa=new Empresa();
	    }
		if($empresa!=null){
			$empresa->razon_social=$request->razonSocial;
			$empresa->ruc=$request->ruc;
			$empresa->sector_id=intval($request->sector);
			$empresa->direccion=$request->direccion;
			$empresa->telefono=intval($request->telefono);
			$empresa->email=$request->email;
			$empresa->representante=$request->representante;
			$empresa->tipo_documento_id=intval($request->tipoDoc);
			$empresa->num_documento=intval($request->nroDoc);
			$empresa->save();
		}		
        return response()->json($empresa);
	}

	function grabarPeriodo( Request $request){
	    $periodo=Periodo::where('mes_id','=',intval($request->mes))->where('anio_id','=',intval($request->anio))->where('empresa_id','=',Session::get('empresa_id_form'))->first();
	    if($periodo==null){
    	    if($request->idPeriodo!=""){
    	        $periodo=Periodo::find(intval($request->idPeriodo));
    	    }
    	    else{
        	    $periodo=new Periodo();
    			$periodo->empresa_id=intval(Session::get('empresa_id_form'));
    	    }
    		if($periodo!=null){
    			$periodo->mes_id=intval($request->mes);
    			$periodo->anio_id=intval($request->anio);
    			$periodo->save();	 
    		}
    		$mes=Mes::where('mes_id','=',$periodo->mes_id)->first();
    		if($mes==null){
    			$mes=new Mes();
    		}
    		$anio=Anio::where('anio_id','=',$periodo->anio_id)->first();
    		if($anio==null){
    			$anio=new Anio();
    		}
    		$array = array('periodo_id' => $periodo->periodo_id, 'mes' => $mes->mes, 'anio' => $anio->anio);
    		
    		$empleados = Empleado::where('empresa_id','=',Session::get('empresa_id_form'))->where('estado_empleado_id','=',1)->get();	
    		foreach($empleados as $empleado){
    		  $planilla = new Planilla();
    		  $planilla->id_trabajador = $empleado->id_trabajador;
    		  $planilla->periodo_id =  $periodo->periodo_id;
    		  $planilla->save();
    		}
            return response()->json($array);
	    }
	    else{
	         return response()->json("PERIODO_EXISTE");        
	    }
	}

	function eliminarPeriodo( Request $request){
		$periodo=Periodo::find(intval($request->periodo_id));
		$periodo->delete();
		return response()->json($periodo);
	}

	function grabarCentroCosto( Request $request){
	    $centroCosto=Centrocosto::where('centro_costo','=',$request->centroCosto)->where('empresa_id','=',Session::get('empresa_id_form'))->first();
	    if($centroCosto==null){
    	    if($request->idCentroCosto!=""){
    	        $centroCosto=Centrocosto::find(intval($request->idCentroCosto));
    	    }
    	    else{
        	    $centroCosto=new Centrocosto();
    			$centroCosto->empresa_id=intval(Session::get('empresa_id_form'));
    	    }
    		if($centroCosto!=null){
    			$centroCosto->centro_costo=$request->centroCosto;
    			$centroCosto->save();	 
    		}
    		$array = array('centro_costo_id' => $centroCosto->centro_costo_id, 'centro_costo' => $centroCosto->centro_costo);
            return response()->json($array);
	    }
	    else{
	        return response()->json("CC_EXISTE");      
	    }
	}
    
	function eliminarCentroCosto( Request $request){
		$centroCosto=Centrocosto::find(intval($request->centro_costo_id));
		$centroCosto->delete();
		return response()->json($centroCosto);
	}
    
	public function ingresarEmpresa(Request $request){
        $idEmpresa = $request->input('idEmpresa');
        $idPeriodo = $request->input('idPeriodo');
        $empresa = \App\Models\Empresa::find($idEmpresa);
        if($empresa!=null){
            Session::put('oempresa', $empresa);
            Session::put('empresa_id', $empresa->empresa_id);
            Session::put('sector_id', $empresa->sector_id)  ;
            Session::put('empresa', $empresa->razon_social);
            
            Session::put('periodo_id', null);
    		Session::put('semana_id', null);
    		Session::put('mes', null);
    		Session::put('mes_codigo', null);
    		Session::put('mes_id', null);
            Session::put('anio', null);
            Session::put('trabajador_id', null);
            Session::put('afp_id', null);    
            if($idPeriodo!=null && $idPeriodo!=""){
                $periodo = Periodo::find(intval($idPeriodo));
                if($periodo!=null){
                    $mes = DB::table('meses')->where('mes_id','=',$periodo->mes_id)->first();
            	    $anio = DB::table('anios')->where('anio_id','=',$periodo->anio_id)->first();
            		Session::put('periodo_id', $periodo->periodo_id);
            		Session::put('semana_id', '26');
            		Session::put('mes', $mes->mes);
            		Session::put('mes_codigo', $mes->codigo);
            		Session::put('mes_id', $periodo->mes_id);
                    Session::put('anio', $anio->anio);
                    Session::put('trabajador_id', null);
                    Session::put('afp_id', null);        
                }
            }
        }
		return response()->json($empresa);
	}

	public function ingresarPeriodo(Request $request){
        $periodo_id = $request->input('periodo_id');
        $periodo = \App\Models\Periodo::find($periodo_id);
    	$mes = DB::table('meses')->where('mes_id','=',$periodo->mes_id)->first();
    	$anio = DB::table('anios')->where('anio_id','=',$periodo->anio_id)->first();
        Session::put('periodo_id', $periodo->periodo_id);
        Session::put('semana_id', '26');
        Session::put('mes', $mes->mes);
    	Session::put('mes_codigo', $mes->codigo);
    	Session::put('mes_id', $periodo->mes_id);
        Session::put('anio', $anio->anio);
        Session::put('trabajador_id', null);
        Session::put('afp_id', null);
        $empresa = \App\Models\Empresa::find($periodo->empresa_id);
		Session::put('oempresa', $empresa);
        Session::put('empresa_id', $empresa->empresa_id);
        Session::put('sector_id', $empresa->sector_id)  ;
        Session::put('empresa', $empresa->razon_social);
        return response()->json($periodo);
	}
	
	function cargarComboPeriodos(Request $request){
	    $lista="";
	    $periodos=Periodo::where('empresa_id','=',$request->idEmpresa)->orderBy('mes_id', 'desc')->orderBy('anio_id', 'desc')->get();
		foreach( $periodos as $periodo ){
    		$mes=Mes::where('mes_id','=',$periodo->mes_id)->first();
    		if($mes==null){
    			$mes=new Mes();
    		}
    		$anio=Anio::where('anio_id','=',$periodo->anio_id)->first();
    		if($anio==null){
    			$anio=new Anio();
    		}
    		$lista[] = array('periodo_id' => $periodo->periodo_id, 'mes' => $mes->mes, 'anio' => $anio->anio);
		}
        return response()->json($lista);
	}

    function cargarLogo(Request $request){
        $logo = $request->file('file');
        $path = 'uploads/logos/';
        $empresa = Empresa::find(Session::get('empresa_id_form'));
        $logo->move($path , $empresa->ruc.'.png');
    }    

}