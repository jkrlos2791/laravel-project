<?php namespace App\Http\Controllers;

use App\Http\Controllers\controller;
use App\Models\Boleta;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect ;
use App\Models\Periodo;
use Session;

class BoletaController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'empleado';
	static $per_page	= '10';

	public function __construct()
	{		
	}

	public function getIndex( Request $request )
	{

		if($this->access['is_view'] ==0) 
			return Redirect::to('dashboard')
				->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');

		$sort = (!is_null($request->input('sort')) ? $request->input('sort') : 'id_trabajador'); 
		$order = (!is_null($request->input('order')) ? $request->input('order') : 'asc');
		// End Filter sort and order for query 
		// Filter Search for query		
		$filter = 'AND empresa_id = "'.Session::get('empresa_id').'"';
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
		$pagination->setPath('empleado');
		
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
		return view('empleado.index',$this->data);
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
			$this->data['fields'] 		=  \SiteHelpers::fieldLang($this->info['config']['forms']);	
		$this->data['id'] = $id;
		return view('empleado.form',$this->data);
		} else {
			$this->data['row'] = $this->model->getColumnTable('jl_empleados'); 
			$this->data['fields'] 		=  \SiteHelpers::fieldLang($this->info['config']['forms']);
		
		$this->data['id'] = $id;
		return view('empleado.formCreate',$this->data);
		}
		
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
			return view('empleado.view',$this->data);
		} else {
			return Redirect::to('empleado')->with('messagetext','Record Not Found !')->with('msgstatus','error');					
		}
	}	

	function postSave( Request $request, $id =0)
	{
		
		$rules = $this->validateForm();
		//$rules['num_doc'] = 'required|unique:jl_empleados,num_doc,'.$request->id_trabajador.',id_trabajador';
		//$rules['nro_factura'] = 'required|unique:jl_facturas,nro_factura,'.$request->factura_id.',factura_id';
		$validator = Validator::make($request->all(), $rules);
		
		if ($validator->passes()) {
			
			$data = $this->validatePost('tb_empleado');
	
			$data['empresa_id'] = Session::get('empresa_id');	
		
			$id = $this->model->insertRow($data , $request->input('id_trabajador'));
			
			if(!is_null($request->input('apply')))
			{
				$return = 'empleado/update/'.$id.'?return='.self::returnUrl();
			} else {
				$return = 'empleado/detail/'.$id.'?return='.self::returnUrl();
			}

			// Insert logs into database
			if($request->input('id_trabajador') =='')
			{
				\SiteHelpers::auditTrail( $request , 'New Data with ID '.$id.' Has been Inserted !');
			} else {
				\SiteHelpers::auditTrail($request ,'Data with ID '.$id.' Has been Updated !');
			}

			return Redirect::to($return)->with('messagetext',\Lang::get('core.note_success'))->with('msgstatus','success');
			
		} else {

			return Redirect::to('empleado/update/'.$request->input('id_trabajador'))->with('messagetext',\Lang::get('core.note_error'))->with('msgstatus','error')
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
			return Redirect::to('empleado?return='.self::returnUrl())
        		->with('messagetext', \Lang::get('core.note_success_delete'))->with('msgstatus','success'); 
	
		} else {
			return Redirect::to('empleado?return='.self::returnUrl())
        		->with('messagetext','No Item Deleted')->with('msgstatus','error');				
		}

	}	

	public static function display( )
	{
		$mode  = isset($_GET['view']) ? 'view' : 'default' ;
		$model  = new Empleado();
		$info = $model::makeInfo('empleado');

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
				return view('empleado.public.view',$data);
			} 

		} else {

			$page = isset($_GET['page']) ? $_GET['page'] : 1;
			$params = array(
				'page'		=> $page ,
				'limit'		=>  (isset($_GET['rows']) ? filter_var($_GET['rows'],FILTER_VALIDATE_INT) : 10 ) ,
				'sort'		=> 'id_trabajador' ,
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
			return view('empleado.public.index',$data);			
		}


	}

	function postSavepublic( Request $request)
	{
		
		$rules = $this->validateForm();
		$validator = Validator::make($request->all(), $rules);	
		if ($validator->passes()) {
			$data = $this->validatePost('jl_empleados');		
			 $this->model->insertRow($data , $request->input('id_trabajador'));
			return  Redirect::back()->with('messagetext','<p class="alert alert-success">'.\Lang::get('core.note_success').'</p>')->with('msgstatus','success');
		} else {

			return  Redirect::back()->with('messagetext','<p class="alert alert-danger">'.\Lang::get('core.note_error').'</p>')->with('msgstatus','error')
			->withErrors($validator)->withInput();

		}	
	
	}
	
	public function descargarBoletas() 
    {      
     $nro=0;  
     //$planillas	 = \App\Models\Planilla::where('periodo_id', '=', Session::get('periodo_id'))->get();
	$planillas = \App\Models\Planilla::where('periodo_id','=',Session::get('periodo_id'))
					             ->leftJoin('jl_empleados', 'jl_empleados.id_trabajador','=','planillas.id_trabajador')
								 ->leftJoin('afps', 'afps.afp_id','=','jl_empleados.afp_id')
								 ->leftJoin('empresas', 'empresas.empresa_id','=','jl_empleados.empresa_id')
								 ->leftJoin('contratos', 'contratos.id_trabajador','=','jl_empleados.id_trabajador')
								 ->select('jl_empleados.num_doc','jl_empleados.ape_paterno','jl_empleados.ape_materno','jl_empleados.fecha_nacimiento',
								 'jl_empleados.nombres','jl_empleados.centro_costo','afps.nombre','jl_empleados.n_cuspp',
								 'jl_empleados.fecha_nacimiento','dias_computables', 'contratos.sueldo', 'contratos.fecha_ingreso', 'c0121', 'c0201', 
								 'c0118', 'c0916', 'c0915', 'c0402', 'c0107',
							    'importe_hn', 'base_imponible', 'c0909', 'c0917', 'c0902', 'c0403', 
								 'incentivos', 'c0903', 'total_ingresos', 'c0601', 'c0608', 
								 'c0606', 'afp', 'c0605', 'c0706', 'c0607', 'eps', 
								 'c0701', 'prestamos', 'total_descuentos', 
								 'neto_pagar', 'essalud', 'empresas.razon_social', 'empresas.direccion', 'empresas.num_direccion', 'empresas.ruc')
								 ->get();
	//return dd($planillas);
    $view =  \View::make('boletas.boletapago2', compact('planillas', 'nro'))->render();
    $pdf = \App::make('snappy.pdf.wrapper');
    $pdf->loadHTML($view);
  
	return $pdf->stream('pdf'); 
		  
    }
	
	




}