<?php namespace App\Http\Controllers;

use App\Http\Controllers\controller;
use App\Models\Planillageneracion;
use App\Models\Planilla;
use App\Models\Empleado;
use App\Models\Afp;
use App\Models\Concepto;
use App\Models\Suspension;
use App\Models\Tiposuspension;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect ; 
use DB;
use Session;
use Maatwebsite\Excel\Facades\Excel;
use DateTime;


class PlanillageneracionController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'planillageneracion';
	static $per_page	= '10';

	public function __construct()
	{
		
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new Planillageneracion();
		
		$this->info = $this->model->makeInfo( $this->module);
		$this->access = $this->model->validAccess($this->info['id']);
	
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'planillageneracion',
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
        if(Session::get('lista')=='obreros'){
         $filter = 'AND semana_id = "'.Session::get('semana_id').'" AND periodo_id = "'.Session::get('periodo_id').'"';   
        }else{
         $filter = 'AND semana_id = 0 AND periodo_id = "'.Session::get('periodo_id').'"';   
        }
		
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
		$pagination->setPath('planillageneracion');
		
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
		return view('planillageneracion.index2',$this->data);
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
		return view('planillageneracion.form',$this->data);
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
			return view('planillageneracion.view',$this->data);
		} else {
			return Redirect::to('planillageneracion')->with('messagetext','Record Not Found !')->with('msgstatus','error');					
		}
	}	

	function postSave( Request $request)
	{
		
		$rules = $this->validateForm();
		$validator = Validator::make($request->all(), $rules);	
		if ($validator->passes()) {
			$data = $this->validatePost('tb_planillageneracion');
				
			$id = $this->model->insertRow($data , $request->input('planilla_id'));
			
			if(!is_null($request->input('apply')))
			{
				$return = 'planillageneracion/update/'.$id.'?return='.self::returnUrl();
			} else {
				$return = 'planillageneracion?return='.self::returnUrl();
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

			return Redirect::to('planillageneracion/update/'.$request->input('planilla_id'))->with('messagetext',\Lang::get('core.note_error'))->with('msgstatus','error')
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
			return Redirect::to('planillageneracion?return='.self::returnUrl())
        		->with('messagetext', \Lang::get('core.note_success_delete'))->with('msgstatus','success'); 
	
		} else {
			return Redirect::to('planillageneracion?return='.self::returnUrl())
        		->with('messagetext','No Item Deleted')->with('msgstatus','error');				
		}

	}	

	public static function display( )
	{
		$mode  = isset($_GET['view']) ? 'view' : 'default' ;
		$model  = new Planillageneracion();
		$info = $model::makeInfo('planillageneracion');

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
				return view('planillageneracion.public.view',$data);
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
			return view('planillageneracion.public.index',$data);			
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
            Session::put('lista', 'empleados');
			return  Redirect::to('planillageneracion');		
	}

	function mostrarObreros( Request $request)
	{
			Session::put('lista', 'obreros');
			return  Redirect::to('planillageneracion');		
	}

	function listar( Request $request){
        $planillas=Planillageneracion::where('periodo_id','=',Session::get('periodo_id'))->get();
        foreach( $planillas as $planilla ){
            $empleado=Empleado::where('id_trabajador','=',$planilla->id_trabajador)->first();
            if($empleado==null){
                $empleado=new Empleado();
            }
			$afp=Afp::where('afp_id','=',$empleado->afp_id)->first();
            if($afp==null){
                $afp=new Afp();
            }
            $lista[] = array('id' => $planilla->planilla_id, 'num_doc' => $empleado->num_doc, 'nombres' => $empleado->ape_paterno." ".$empleado->ape_materno.", ".$empleado->nombres, 
			'centro_costo' => $empleado->centro_costo,'afp' => $afp->nombre, 'cussp' => $empleado->n_cussp, 'total_ingresos' => $planilla->total_ingresos, 
			'total_descuentos' => $planilla->total_descuentos, 'neto_pagar' => $planilla->neto_pagar);
        }
        return response()->json($lista);
	}

	function exportar (Request $request){
	   $centroCosto = \Request::input('centroCosto');
       $regimenPen = \Request::input('regimenPen');
	   Excel::create('PLANILLA', function($excel) use($centroCosto, $regimenPen){                 		         
			 $excel->sheet('Planilla', function($sheet) use($centroCosto, $regimenPen){	
			 $campos = DB::getSchemaBuilder()->getColumnListing('planillas');
			 for ($i = 3; $i <= count($campos)-15; $i++) {  
				$nombrecampos = Concepto::where('codigo','=',$campos[$i])->first();				 
			 }
			$planillas = Planilla::where('periodo_id','=',Session::get('periodo_id'))
			 ->leftJoin('jl_empleados', 'jl_empleados.id_trabajador','=','planillas.id_trabajador')
			 ->leftJoin('afps', 'afps.afp_id','=','jl_empleados.afp_id')
			 //->leftJoin('snp_afps', 'snp_afps.snp_afp_id','=','jl_empleados.snp_afp_id')
			 ->leftJoin('contratos', 'contratos.id_trabajador','=','jl_empleados.id_trabajador')
			 ->select('jl_empleados.num_doc','jl_empleados.ape_paterno','jl_empleados.ape_materno','jl_empleados.nombres',
			 'contratos.fecha_ingreso','jl_empleados.centro_costo','afps.nombre','jl_empleados.n_cuspp',
			 'dias_computables','contratos.sueldo','c0121','c0201', 
			 'c0118','c0916','c0915','enfermedad', 
			 'c0402','importe_hn','c0107','base_imponible',
			 'c0913','recargo_adicional','c0909','c0917', 
			 'c0902','c0403','incentivos','c0903', 'c0306', 
			 'total_ingresos','c0608','c0606','c0601', 
			 'afp','c0607','c0605','c0604', 
			 'c0706','prestamos','eps','c0703', 
			 'c0701','c0704','total_descuentos','neto_pagar', 'essalud', 'jl_empleados.fecha_cese')
			 ->get();
			 $planillaFinal=array();
			 $sueldo=0.00;
			 $c0121=0.00;
			 $c0201=0.00; 
    		 $c0118=0.00;
			 $c0916=0.00;
			 $c0915=0.00;
			 $enfermedad=0.00;
			 $c0402=0.00;
			 $importe_hn=0.00;
			 $c0107=0.00;
			 $base_imponible=0.00;
			 $c0913=0.00;
			 $recargo_adicional=0.00;
			 $c0909=0.00;
			 $c0917=0.00; 
			 $c0902=0.00;
			 $c0403=0.00;
			 $incentivos=0.00;
			 $c0903=0.00;
			 $c0306=0.00;
			 $total_ingresos=0.00;
			 $c0608=0.00;
			 $c0606=0.00;
			 $c0601=0.00;
			 $afp=0.00;
			 $c0607=0.00;
			 $c0605=0.00;
			 $c0604=0.00;
			 $c0706=0.00;
			 $prestamos=0.00;
			 $eps=0.00;
			 $c0703=0.00; 
			 $c0701=0.00;
			 $c0704=0.00;
			 $total_descuentos=0.00;
			 $netoPagar=0.00;
			 $essalud=0.00;
			if($centroCosto=="" && $regimenPen==""){
			    foreach ($planillas as &$planilla) {
    			    $planillaFinal[]=array($planilla->num_doc,$planilla->ape_paterno,$planilla->ape_materno,$planilla->nombres,
    							$planilla->fecha_ingreso,$planilla->centro_costo,$planilla->nombre,$planilla->n_cuspp,
    							$planilla->dias_computables,$planilla->sueldo, $planilla->c0121,$planilla->c0201, 
    							$planilla->c0118,$planilla->c0916,$planilla->c0915, $planilla->enfermedad, 
    							$planilla->c0402,$planilla->importe_hn,$planilla->c0107,$planilla->base_imponible,
    							$planilla->c0913,$planilla->recargo_adicional,$planilla->c0909,$planilla->c0917, 
    							$planilla->c0902, $planilla->c0403,$planilla->incentivos,$planilla->c0903, $planilla->c0306,
    							$planilla->total_ingresos,$planilla->c0608,$planilla->c0606,$planilla->c0601, 
    							$planilla->afp,$planilla->c0607,$planilla->c0605,$planilla->c0604, 
    							$planilla->c0706,$planilla->prestamos,$planilla->eps,$planilla->c0703, 
    							$planilla->c0701,$planilla->c0704,$planilla->total_descuentos,$planilla->neto_pagar,$planilla->essalud,$planilla->fecha_cese);
    							$sueldo=$sueldo+doubleval($planilla->sueldo);
    							$c0121=$c0121+doubleval($planilla->c0121);
    							$c0201=$c0201+doubleval($planilla->c0201);
    							$c0118=$c0118+doubleval($planilla->c0118);
    							$c0916=$c0916+doubleval($planilla->c0916);
    							$c0915=$c0915+doubleval($planilla->c0915);
    							$enfermedad=$enfermedad+doubleval($planilla->enfermedad);
    							$c0402=$c0402+doubleval($planilla->c0402);
    							$importe_hn=$importe_hn+doubleval($planilla->importe_hn);
    							$c0107=$c0107+doubleval($planilla->c0107);
    							$base_imponible=$base_imponible+doubleval($planilla->base_imponible);
    							$c0913=$c0913+doubleval($planilla->c0913);
    							$recargo_adicional=$recargo_adicional+doubleval($planilla->recargo_adicional);
    							$c0909=$c0909+doubleval($planilla->c0909);
    							$c0917=$c0917+doubleval($planilla->c0917);
    							$c0902=$c0902+doubleval($planilla->c0902);
    							$c0403=$c0403+doubleval($planilla->c0403);
    							$incentivos=$incentivos+doubleval($planilla->incentivos);
    							$c0903=$c0903+doubleval($planilla->c0903);
    							$c0306=$c0306+doubleval($planilla->c0306);
    							$total_ingresos=$total_ingresos+doubleval($planilla->total_ingresos);
    							$c0608=$c0608+doubleval($planilla->c0608);
    							$c0606=$c0606+doubleval($planilla->c0606);
    							$c0601=$c0601+doubleval($planilla->c0601);
    							$afp=$afp+doubleval($planilla->afp);
    							$c0607=$c0607+doubleval($planilla->c0607);
    							$c0605=$c0605+doubleval($planilla->c0605);
    							$c0604=$c0604+doubleval($planilla->c0604);
    							$c0706=$c0706+doubleval($planilla->c0706);
    							$prestamos=$prestamos+doubleval($planilla->prestamos);
    							$eps=$eps+doubleval($planilla->eps);
    							$c0703=$c0703+doubleval($planilla->c0703);
    							$c0701=$c0701+doubleval($planilla->c0701);
    							$c0704=$c0704+doubleval($planilla->c0704);
    							$total_descuentos=$total_descuentos+doubleval($planilla->total_descuentos);
    							$netoPagar=$netoPagar+doubleval($planilla->neto_pagar);
    							$essalud=$essalud+doubleval($planilla->essalud);
			    }
			}
			else if($centroCosto!="" && $regimenPen!=""){
				foreach ($planillas as &$planilla) {
					if($regimenPen=="1"){
						if($planilla->centro_costo==$centroCosto && ($planilla->nombre=="" || $planilla->nombre==null)){
							$planillaFinal[]=array($planilla->num_doc,$planilla->ape_paterno,$planilla->ape_materno,$planilla->nombres,
							$planilla->fecha_ingreso,$planilla->centro_costo,$planilla->nombre,$planilla->n_cuspp,
							$planilla->dias_computables,$planilla->sueldo, $planilla->c0121,$planilla->c0201, 
							$planilla->c0118,$planilla->c0916,$planilla->c0915, $planilla->enfermedad, 
							$planilla->c0402,$planilla->importe_hn,$planilla->c0107,$planilla->base_imponible,
							$planilla->c0913,$planilla->recargo_adicional,$planilla->c0909,$planilla->c0917, 
							$planilla->c0902, $planilla->c0403,$planilla->incentivos,$planilla->c0903, $planilla->c0306,
							$planilla->total_ingresos,$planilla->c0608,$planilla->c0606,$planilla->c0601, 
							$planilla->afp,$planilla->c0607,$planilla->c0605,$planilla->c0604, 
							$planilla->c0706,$planilla->prestamos,$planilla->eps,$planilla->c0703, 
							$planilla->c0701,$planilla->c0704,$planilla->total_descuentos,$planilla->neto_pagar,$planilla->essalud,$planilla->fecha_cese);
							$sueldo=$sueldo+doubleval($planilla->sueldo);
							$c0121=$c0121+doubleval($planilla->c0121);
							$c0201=$c0201+doubleval($planilla->c0201);
							$c0118=$c0118+doubleval($planilla->c0118);
							$c0916=$c0916+doubleval($planilla->c0916);
							$c0915=$c0915+doubleval($planilla->c0915);
							$enfermedad=$enfermedad+doubleval($planilla->enfermedad);
							$c0402=$c0402+doubleval($planilla->c0402);
							$importe_hn=$importe_hn+doubleval($planilla->importe_hn);
							$c0107=$c0107+doubleval($planilla->c0107);
							$base_imponible=$base_imponible+doubleval($planilla->base_imponible);
							$c0913=$c0913+doubleval($planilla->c0913);
							$recargo_adicional=$recargo_adicional+doubleval($planilla->recargo_adicional);
							$c0909=$c0909+doubleval($planilla->c0909);
							$c0917=$c0917+doubleval($planilla->c0917);
							$c0902=$c0902+doubleval($planilla->c0902);
							$c0403=$c0403+doubleval($planilla->c0403);
							$incentivos=$incentivos+doubleval($planilla->incentivos);
							$c0903=$c0903+doubleval($planilla->c0903);
							$c0306=$c0306+doubleval($planilla->c0306);
							$total_ingresos=$total_ingresos+doubleval($planilla->total_ingresos);
							$c0608=$c0608+doubleval($planilla->c0608);
							$c0606=$c0606+doubleval($planilla->c0606);
							$c0601=$c0601+doubleval($planilla->c0601);
							$afp=$afp+doubleval($planilla->afp);
							$c0607=$c0607+doubleval($planilla->c0607);
							$c0605=$c0605+doubleval($planilla->c0605);
							$c0604=$c0604+doubleval($planilla->c0604);
							$c0706=$c0706+doubleval($planilla->c0706);
							$prestamos=$prestamos+doubleval($planilla->prestamos);
							$eps=$eps+doubleval($planilla->eps);
							$c0703=$c0703+doubleval($planilla->c0703);
							$c0701=$c0701+doubleval($planilla->c0701);
							$c0704=$c0704+doubleval($planilla->c0704);
							$total_descuentos=$total_descuentos+doubleval($planilla->total_descuentos);
							$netoPagar=$netoPagar+doubleval($planilla->neto_pagar);
							$essalud=$essalud+doubleval($planilla->essalud);
						}
					}
					else{
						if($planilla->centro_costo==$centroCosto && ($planilla->nombre!="" || $planilla->nombre!=null)){
							$planillaFinal[]=array($planilla->num_doc,$planilla->ape_paterno,$planilla->ape_materno,$planilla->nombres,
							$planilla->fecha_ingreso,$planilla->centro_costo,$planilla->nombre,$planilla->n_cuspp,
							$planilla->dias_computables,$planilla->sueldo, $planilla->c0121,$planilla->c0201, 
							$planilla->c0118,$planilla->c0916,$planilla->c0915, $planilla->enfermedad, 
							$planilla->c0402,$planilla->importe_hn,$planilla->c0107,$planilla->base_imponible,
							$planilla->c0913,$planilla->recargo_adicional,$planilla->c0909,$planilla->c0917, 
							$planilla->c0902, $planilla->c0403,$planilla->incentivos,$planilla->c0903, $planilla->c0306,
							$planilla->total_ingresos,$planilla->c0608,$planilla->c0606,$planilla->c0601, 
							$planilla->afp,$planilla->c0607,$planilla->c0605,$planilla->c0604, 
							$planilla->c0706,$planilla->prestamos,$planilla->eps,$planilla->c0703, 
							$planilla->c0701,$planilla->c0704,$planilla->total_descuentos,$planilla->neto_pagar,$planilla->essalud,$planilla->fecha_cese);
							$sueldo=$sueldo+doubleval($planilla->sueldo);
							$c0121=$c0121+doubleval($planilla->c0121);
							$c0201=$c0201+doubleval($planilla->c0201);
							$c0118=$c0118+doubleval($planilla->c0118);
							$c0916=$c0916+doubleval($planilla->c0916);
							$c0915=$c0915+doubleval($planilla->c0915);
							$enfermedad=$enfermedad+doubleval($planilla->enfermedad);
							$c0402=$c0402+doubleval($planilla->c0402);
							$importe_hn=$importe_hn+doubleval($planilla->importe_hn);
							$c0107=$c0107+doubleval($planilla->c0107);
							$base_imponible=$base_imponible+doubleval($planilla->base_imponible);
							$c0913=$c0913+doubleval($planilla->c0913);
							$recargo_adicional=$recargo_adicional+doubleval($planilla->recargo_adicional);
							$c0909=$c0909+doubleval($planilla->c0909);
							$c0917=$c0917+doubleval($planilla->c0917);
							$c0902=$c0902+doubleval($planilla->c0902);
							$c0403=$c0403+doubleval($planilla->c0403);
							$incentivos=$incentivos+doubleval($planilla->incentivos);
							$c0903=$c0903+doubleval($planilla->c0903);
							$c0306=$c0306+doubleval($planilla->c0306);
							$total_ingresos=$total_ingresos+doubleval($planilla->total_ingresos);
							$c0608=$c0608+doubleval($planilla->c0608);
							$c0606=$c0606+doubleval($planilla->c0606);
							$c0601=$c0601+doubleval($planilla->c0601);
							$afp=$afp+doubleval($planilla->afp);
							$c0607=$c0607+doubleval($planilla->c0607);
							$c0605=$c0605+doubleval($planilla->c0605);
							$c0604=$c0604+doubleval($planilla->c0604);
							$c0706=$c0706+doubleval($planilla->c0706);
							$prestamos=$prestamos+doubleval($planilla->prestamos);
							$eps=$eps+doubleval($planilla->eps);
							$c0703=$c0703+doubleval($planilla->c0703);
							$c0701=$c0701+doubleval($planilla->c0701);
							$c0704=$c0704+doubleval($planilla->c0704);
							$total_descuentos=$total_descuentos+doubleval($planilla->total_descuentos);
							$netoPagar=$netoPagar+doubleval($planilla->neto_pagar);
							$essalud=$essalud+doubleval($planilla->essalud);
						}
					}
				}
			}
			else if($centroCosto!=""){
				foreach ($planillas as &$planilla) {
					if($planilla->centro_costo==$centroCosto){
							$planillaFinal[]=array($planilla->num_doc,$planilla->ape_paterno,$planilla->ape_materno,$planilla->nombres,
							$planilla->fecha_ingreso,$planilla->centro_costo,$planilla->nombre,$planilla->n_cuspp,
							$planilla->dias_computables,$planilla->sueldo, $planilla->c0121,$planilla->c0201, 
							$planilla->c0118,$planilla->c0916,$planilla->c0915, $planilla->enfermedad, 
							$planilla->c0402,$planilla->importe_hn,$planilla->c0107,$planilla->base_imponible,
							$planilla->c0913,$planilla->recargo_adicional,$planilla->c0909,$planilla->c0917, 
							$planilla->c0902, $planilla->c0403,$planilla->incentivos,$planilla->c0903, $planilla->c0306,
							$planilla->total_ingresos,$planilla->c0608,$planilla->c0606,$planilla->c0601, 
							$planilla->afp,$planilla->c0607,$planilla->c0605,$planilla->c0604, 
							$planilla->c0706,$planilla->prestamos,$planilla->eps,$planilla->c0703, 
							$planilla->c0701,$planilla->c0704,$planilla->total_descuentos,$planilla->neto_pagar,$planilla->essalud,$planilla->fecha_cese);
							$sueldo=$sueldo+doubleval($planilla->sueldo);
							$c0121=$c0121+doubleval($planilla->c0121);
							$c0201=$c0201+doubleval($planilla->c0201);
							$c0118=$c0118+doubleval($planilla->c0118);
							$c0916=$c0916+doubleval($planilla->c0916);
							$c0915=$c0915+doubleval($planilla->c0915);
							$enfermedad=$enfermedad+doubleval($planilla->enfermedad);
							$c0402=$c0402+doubleval($planilla->c0402);
							$importe_hn=$importe_hn+doubleval($planilla->importe_hn);
							$c0107=$c0107+doubleval($planilla->c0107);
							$base_imponible=$base_imponible+doubleval($planilla->base_imponible);
							$c0913=$c0913+doubleval($planilla->c0913);
							$recargo_adicional=$recargo_adicional+doubleval($planilla->recargo_adicional);
							$c0909=$c0909+doubleval($planilla->c0909);
							$c0917=$c0917+doubleval($planilla->c0917);
							$c0902=$c0902+doubleval($planilla->c0902);
							$c0403=$c0403+doubleval($planilla->c0403);
							$incentivos=$incentivos+doubleval($planilla->incentivos);
							$c0903=$c0903+doubleval($planilla->c0903);
							$c0306=$c0306+doubleval($planilla->c0306);
							$total_ingresos=$total_ingresos+doubleval($planilla->total_ingresos);
							$c0608=$c0608+doubleval($planilla->c0608);
							$c0606=$c0606+doubleval($planilla->c0606);
							$c0601=$c0601+doubleval($planilla->c0601);
							$afp=$afp+doubleval($planilla->afp);
							$c0607=$c0607+doubleval($planilla->c0607);
							$c0605=$c0605+doubleval($planilla->c0605);
							$c0604=$c0604+doubleval($planilla->c0604);
							$c0706=$c0706+doubleval($planilla->c0706);
							$prestamos=$prestamos+doubleval($planilla->prestamos);
							$eps=$eps+doubleval($planilla->eps);
							$c0703=$c0703+doubleval($planilla->c0703);
							$c0701=$c0701+doubleval($planilla->c0701);
							$c0704=$c0704+doubleval($planilla->c0704);
							$total_descuentos=$total_descuentos+doubleval($planilla->total_descuentos);
							$netoPagar=$netoPagar+doubleval($planilla->neto_pagar);
							$essalud=$essalud+doubleval($planilla->essalud);
					}
				}
			}
			else{
				foreach ($planillas as &$planilla) {
					if($regimenPen=="1"){				
						if($planilla->nombre=="" || $planilla->nombre==null){
							$planillaFinal[]=array($planilla->num_doc,$planilla->ape_paterno,$planilla->ape_materno,$planilla->nombres,
							$planilla->fecha_ingreso,$planilla->centro_costo,$planilla->nombre,$planilla->n_cuspp,
							$planilla->dias_computables,$planilla->sueldo, $planilla->c0121,$planilla->c0201, 
							$planilla->c0118,$planilla->c0916,$planilla->c0915, $planilla->enfermedad, 
							$planilla->c0402,$planilla->importe_hn,$planilla->c0107,$planilla->base_imponible,
							$planilla->c0913,$planilla->recargo_adicional,$planilla->c0909,$planilla->c0917, 
							$planilla->c0902, $planilla->c0403,$planilla->incentivos,$planilla->c0903, $planilla->c0306,
							$planilla->total_ingresos,$planilla->c0608,$planilla->c0606,$planilla->c0601, 
							$planilla->afp,$planilla->c0607,$planilla->c0605,$planilla->c0604, 
							$planilla->c0706,$planilla->prestamos,$planilla->eps,$planilla->c0703, 
							$planilla->c0701,$planilla->c0704,$planilla->total_descuentos,$planilla->neto_pagar,$planilla->essalud,$planilla->fecha_cese);
							$sueldo=$sueldo+doubleval($planilla->sueldo);
							$c0121=$c0121+doubleval($planilla->c0121);
							$c0201=$c0201+doubleval($planilla->c0201);
							$c0118=$c0118+doubleval($planilla->c0118);
							$c0916=$c0916+doubleval($planilla->c0916);
							$c0915=$c0915+doubleval($planilla->c0915);
							$enfermedad=$enfermedad+doubleval($planilla->enfermedad);
							$c0402=$c0402+doubleval($planilla->c0402);
							$importe_hn=$importe_hn+doubleval($planilla->importe_hn);
							$c0107=$c0107+doubleval($planilla->c0107);
							$base_imponible=$base_imponible+doubleval($planilla->base_imponible);
							$c0913=$c0913+doubleval($planilla->c0913);
							$recargo_adicional=$recargo_adicional+doubleval($planilla->recargo_adicional);
							$c0909=$c0909+doubleval($planilla->c0909);
							$c0917=$c0917+doubleval($planilla->c0917);
							$c0902=$c0902+doubleval($planilla->c0902);
							$c0403=$c0403+doubleval($planilla->c0403);
							$incentivos=$incentivos+doubleval($planilla->incentivos);
							$c0903=$c0903+doubleval($planilla->c0903);
							$c0306=$c0306+doubleval($planilla->c0306);
							$total_ingresos=$total_ingresos+doubleval($planilla->total_ingresos);
							$c0608=$c0608+doubleval($planilla->c0608);
							$c0606=$c0606+doubleval($planilla->c0606);
							$c0601=$c0601+doubleval($planilla->c0601);
							$afp=$afp+doubleval($planilla->afp);
							$c0607=$c0607+doubleval($planilla->c0607);
							$c0605=$c0605+doubleval($planilla->c0605);
							$c0604=$c0604+doubleval($planilla->c0604);
							$c0706=$c0706+doubleval($planilla->c0706);
							$prestamos=$prestamos+doubleval($planilla->prestamos);
							$eps=$eps+doubleval($planilla->eps);
							$c0703=$c0703+doubleval($planilla->c0703);
							$c0701=$c0701+doubleval($planilla->c0701);
							$c0704=$c0704+doubleval($planilla->c0704);
							$total_descuentos=$total_descuentos+doubleval($planilla->total_descuentos);
							$netoPagar=$netoPagar+doubleval($planilla->neto_pagar);
							$essalud=$essalud+doubleval($planilla->essalud);
						}
					}
					else{
						if($planilla->nombre!="" || $planilla->nombre!=null){
							$planillaFinal[]=array($planilla->num_doc,$planilla->ape_paterno,$planilla->ape_materno,$planilla->nombres,
							$planilla->fecha_ingreso,$planilla->centro_costo,$planilla->nombre,$planilla->n_cuspp,
							$planilla->dias_computables,$planilla->sueldo, $planilla->c0121,$planilla->c0201, 
							$planilla->c0118,$planilla->c0916,$planilla->c0915, $planilla->enfermedad, 
							$planilla->c0402,$planilla->importe_hn,$planilla->c0107,$planilla->base_imponible,
							$planilla->c0913,$planilla->recargo_adicional,$planilla->c0909,$planilla->c0917, 
							$planilla->c0902, $planilla->c0403,$planilla->incentivos,$planilla->c0903, $planilla->c0306, 
							$planilla->total_ingresos,$planilla->c0608,$planilla->c0606,$planilla->c0601, 
							$planilla->afp,$planilla->c0607,$planilla->c0605,$planilla->c0604, 
							$planilla->c0706,$planilla->prestamos,$planilla->eps,$planilla->c0703, 
							$planilla->c0701,$planilla->c0704,$planilla->total_descuentos,$planilla->neto_pagar,$planilla->essalud,$planilla->fecha_cese);
							$sueldo=$sueldo+doubleval($planilla->sueldo);
							$c0121=$c0121+doubleval($planilla->c0121);
							$c0201=$c0201+doubleval($planilla->c0201);
							$c0118=$c0118+doubleval($planilla->c0118);
							$c0916=$c0916+doubleval($planilla->c0916);
							$c0915=$c0915+doubleval($planilla->c0915);
							$enfermedad=$enfermedad+doubleval($planilla->enfermedad);
							$c0402=$c0402+doubleval($planilla->c0402);
							$importe_hn=$importe_hn+doubleval($planilla->importe_hn);
							$c0107=$c0107+doubleval($planilla->c0107);
							$base_imponible=$base_imponible+doubleval($planilla->base_imponible);
							$c0913=$c0913+doubleval($planilla->c0913);
							$recargo_adicional=$recargo_adicional+doubleval($planilla->recargo_adicional);
							$c0909=$c0909+doubleval($planilla->c0909);
							$c0917=$c0917+doubleval($planilla->c0917);
							$c0902=$c0902+doubleval($planilla->c0902);
							$c0403=$c0403+doubleval($planilla->c0403);
							$incentivos=$incentivos+doubleval($planilla->incentivos);
							$c0903=$c0903+doubleval($planilla->c0903);
							$c0306=$c0306+doubleval($planilla->c0306);
							$total_ingresos=$total_ingresos+doubleval($planilla->total_ingresos);
							$c0608=$c0608+doubleval($planilla->c0608);
							$c0606=$c0606+doubleval($planilla->c0606);
							$c0601=$c0601+doubleval($planilla->c0601);
							$afp=$afp+doubleval($planilla->afp);
							$c0607=$c0607+doubleval($planilla->c0607);
							$c0605=$c0605+doubleval($planilla->c0605);
							$c0604=$c0604+doubleval($planilla->c0604);
							$c0706=$c0706+doubleval($planilla->c0706);
							$prestamos=$prestamos+doubleval($planilla->prestamos);
							$eps=$eps+doubleval($planilla->eps);
							$c0703=$c0703+doubleval($planilla->c0703);
							$c0701=$c0701+doubleval($planilla->c0701);
							$c0704=$c0704+doubleval($planilla->c0704);
							$total_descuentos=$total_descuentos+doubleval($planilla->total_descuentos);
							$netoPagar=$netoPagar+doubleval($planilla->neto_pagar);
							$essalud=$essalud+doubleval($planilla->essalud);
						}
					}
				}
			}
			
			//return dd($planillaFinal);

            $planilla = new Planilla();
            $planillaFinal[]=array($planilla->num_doc,$planilla->ape_paterno,$planilla->ape_materno,$planilla->nombres,
							$planilla->fecha_ingreso,$planilla->centro_costo,$planilla->nombre,$planilla->n_cuspp,
							$planilla->dias_computables,$sueldo, $c0121,$c0201, 
							$c0118,$c0916,$c0915, $enfermedad, 
							$c0402,$importe_hn,$c0107,$base_imponible,
							$c0913,$recargo_adicional,$c0909,$c0917, 
							$c0902, $c0403,$incentivos,$c0903, $c0306,
							$total_ingresos,$c0608,$c0606,$c0601, 
							$afp,$c0607,$c0605,$c0604, 
							$c0706,$prestamos,$eps,$c0703, 
							$c0701,$c0704,$total_descuentos,$netoPagar,$essalud,$planilla->fecha_cese);
							
			$sheet->fromArray($planillaFinal);
			$sheet->row(1,['Documento','Ape.Paterno', 'Ap.Materno', 'Nombres','Fecha de Ingreso','C.Costo','AFP', 'CUSSP',
			'Dias.Compu', 'sueldo','Haber Basico', 'Asig.Famil', 'Rem.Vac', 'Impor.Desc.Medico', 'Impor.Mater', 'Import.Enferm', 'Grati.Ordinaria','Horas Noctu','Feriado',  
			'Base Imponible','Recargo Consumo','Recargo Adicional', 'Movilidad.Suped', 'Condic.Trabajo', 'Bono.Produc', 'Grati.Extraor', 'Incentivos', 'Canasta Navidad', 'Bon. Regulares',
			'Total Ingresos', 'AFP_Fon', 'AFP_Seg', 'AFP_Comp', 'AFP', 'ONP', '5ta Categoria','Essalud Vida', 'Otros Dsctos. no Deducibles','Prestamos', 'EPS', 'Ret. Jud.', 'Adelanto', 'Tardanzas',
			'Total Desc', 'Neto Pagar', 'ESSALUD', 'Fecha de Cese']);					
			$sheet->cell('A1:AS1', function($cell) {
				$cell->setFont(array('size' => '12', 'bold' => true));
				$cell->setBackground('#58ACFA');
				$cell->setFontColor('#ffffff');
				$cell->setAlignment('center');
				$cell->setValignment('center');
				$cell->setBorder(array('top'   => array('style' => 'solid')));
			});
			$sheet->setBorder('A1:AS1', 'thin');	
			$sheet->setHeight(1, 50);
			$sheet->setAutoFilter('A1:AS1');
			$sheet->setColumnFormat(array('J2:AR220' => '0.00'));
			$sheet->setColumnFormat(array('E2:E220' => 'dd/mm/yy'));	
			$sheet->setColumnFormat(array('AS2:AS220' => 'dd/mm/yy'));			
			});
			$excel->sheet('Incidencias', function($sheet) use($centroCosto, $regimenPen){	
				$suspensiones=Suspension::where('periodo_id','=',Session::get('periodo_id'))->get();
				$suspensionFinal=array();
				foreach ($suspensiones as &$suspension) {
					$empleado=Empleado::find($suspension->id_trabajador);
					$tipoSuspension=Tiposuspension::find($suspension->tipo_suspension_id);
					$suspensionFinal[]=array($empleado->num_doc,$empleado->ape_paterno,$empleado->ape_materno,$empleado->nombres,
					$tipoSuspension->descripcion,$suspension->fecha_inicio,$suspension->fecha_fin,$suspension->nro_dias
					);
				}
				$sheet->fromArray($suspensionFinal);
				$sheet->row(1,['Documento','Ape.Paterno','Ap.Materno','Nombres',
				'Tipo Suspension','Fecha inicio','Fecha fin','Nro. dias']);
			});
		})->export('xls');  
   }	

}