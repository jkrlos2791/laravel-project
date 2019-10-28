<?php namespace App\Http\Controllers;

use App\Http\Controllers\controller;
use App\Models\Liquidacion;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect ; 
use DB;
use Session;
use App\Models\Empleado;
use App\Models\Afp;
use App\Models\Contrato;
use App\Models\Suspension;
use App\Models\Periodo;
use App\Models\Planilla;
use DateTime;


class LiquidacionController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'liquidacion';
	static $per_page	= '10';

	public function __construct()
	{
		
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new Liquidacion();
		
		$this->info = $this->model->makeInfo( $this->module);
		$this->access = $this->model->validAccess($this->info['id']);
	
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'liquidacion',
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

		$sort = (!is_null($request->input('sort')) ? $request->input('sort') : 'liquidacion_id'); 
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
		$pagination->setPath('liquidacion');
		
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
		return view('liquidacion.index',$this->data);
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
			$this->data['row'] = $this->model->getColumnTable('liquidaciones'); 
		}
		$this->data['fields'] 		=  \SiteHelpers::fieldLang($this->info['config']['forms']);
		
		$this->data['id'] = $id;
		return view('liquidacion.form',$this->data);
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
			return view('liquidacion.view',$this->data);
		} else {
			return Redirect::to('liquidacion')->with('messagetext','Record Not Found !')->with('msgstatus','error');					
		}
	}	

	function postSave( Request $request)
	{
		
		$rules = $this->validateForm();
		$validator = Validator::make($request->all(), $rules);	
		if ($validator->passes()) {
			$data = $this->validatePost('tb_liquidacion');
				
			$id = $this->model->insertRow($data , $request->input('liquidacion_id'));
			
			if(!is_null($request->input('apply')))
			{
				$return = 'liquidacion/update/'.$id.'?return='.self::returnUrl();
			} else {
				$return = 'liquidacion?return='.self::returnUrl();
			}

			// Insert logs into database
			if($request->input('liquidacion_id') =='')
			{
				\SiteHelpers::auditTrail( $request , 'New Data with ID '.$id.' Has been Inserted !');
			} else {
				\SiteHelpers::auditTrail($request ,'Data with ID '.$id.' Has been Updated !');
			}

			return Redirect::to($return)->with('messagetext',\Lang::get('core.note_success'))->with('msgstatus','success');
			
		} else {

			return Redirect::to('liquidacion/update/'.$request->input('liquidacion_id'))->with('messagetext',\Lang::get('core.note_error'))->with('msgstatus','error')
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
			return Redirect::to('liquidacion?return='.self::returnUrl())
        		->with('messagetext', \Lang::get('core.note_success_delete'))->with('msgstatus','success'); 
	
		} else {
			return Redirect::to('liquidacion?return='.self::returnUrl())
        		->with('messagetext','No Item Deleted')->with('msgstatus','error');				
		}

	}	

	public static function display( )
	{
		$mode  = isset($_GET['view']) ? 'view' : 'default' ;
		$model  = new Liquidacion();
		$info = $model::makeInfo('liquidacion');

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
				return view('liquidacion.public.view',$data);
			} 

		} else {

			$page = isset($_GET['page']) ? $_GET['page'] : 1;
			$params = array(
				'page'		=> $page ,
				'limit'		=>  (isset($_GET['rows']) ? filter_var($_GET['rows'],FILTER_VALIDATE_INT) : 10 ) ,
				'sort'		=> 'liquidacion_id' ,
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
			return view('liquidacion.public.index',$data);			
		}


	}

	function postSavepublic( Request $request)
	{
		
		$rules = $this->validateForm();
		$validator = Validator::make($request->all(), $rules);	
		if ($validator->passes()) {
			$data = $this->validatePost('liquidaciones');		
			 $this->model->insertRow($data , $request->input('liquidacion_id'));
			return  Redirect::back()->with('messagetext','<p class="alert alert-success">'.\Lang::get('core.note_success').'</p>')->with('msgstatus','success');
		} else {

			return  Redirect::back()->with('messagetext','<p class="alert alert-danger">'.\Lang::get('core.note_error').'</p>')->with('msgstatus','error')
			->withErrors($validator)->withInput();

		}	
	
	}	

	function calculo (){
		   //Eliminar Liquidaciones		   		   
		   $liquidaciones = Liquidacion::where('periodo_id', '=', Session::get('periodo_id'))->get();
		   $empleados = Empleado::where('empresa_id', '=', Session::get('empresa_id'))->get();
		   foreach ($liquidaciones as $liquidacion) {
		   	  foreach ($empleados as $empleado) {
				if($liquidacion->id_trabajador == $empleado->id_trabajador){
				$liquidacion->delete();	
				}  
			  } 
		   }
		   //Calcular Liquidaciones
		   $empleados = Empleado::where('empresa_id', '=', Session::get('empresa_id'))->where('situacion_laboral', '=', '1')->get();
		   $periodo = Periodo::find(Session::get('periodo_id'));
		   foreach ($empleados as $empleado) {
           if(date("n", strtotime($empleado->fecha_cese))==$periodo->mes_id){			   
		   $liquidacion = new Liquidacion(); 
		   //Datos Generales
		   $liquidacion->id_trabajador = $empleado->id_trabajador;
		   $liquidacion->periodo_id = Session::get('periodo_id');
		   $ocupacion =  DB::table('ocupacion')->where('ocupacion_id','=', (int) $empleado->ocupacion)->first();
           if($ocupacion!=null){
			$liquidacion->cargo = $ocupacion->descripcion;
           }			   		   
		   $liquidacion->centro_costo = $empleado->centro_costo;
		   $contrato = Contrato::where('id_trabajador','=',$empleado->id_trabajador)->orderBy('contrato_id','asc')->first();
		   $liquidacion->fecha_ingreso = $contrato->fecha_ingreso;
		   $liquidacion->fecha_cese = $empleado->fecha_cese;
		   $condicion_trabajo=DB::table('condicion_trabajo')->where('condicion_trabajo_id','=',$contrato->condicion_trabajo_id)->first();
		   if($condicion_trabajo!=null){
		    $liquidacion->condicion_trabajo=$condicion_trabajo->descripcion;
		   }
		   $liquidacion->motivo_cese = "RENUNCIA VOLUNTARIA";
		   $liquidacion->sistema_pension = $empleado->afp_id;
		   $liquidacion->tipo_comision_afp = $empleado->comision_tipo_id;
		   $liquidacion->sueldo = $contrato->sueldo;
		   $date1 = new DateTime($contrato->fecha_ingreso);
           $date2 = new DateTime($empleado->fecha_cese);
		   $diff = $date1->diff($date2);
		   $liquidacion->tiempo_servicio = $diff->y." Año(s), ".$diff->m." Mes(es), ".$diff->d." Día(s)";
		   $suspensiones = Suspension::where('id_trabajador', '=', $empleado->id_trabajador)->get();
           $faltas = 0;
		   foreach ($suspensiones as $suspension){
			   if($suspension->tipo_suspension_id==1){
				   $faltas = $suspension->nro_dias + $faltas;	
			   }         		
		   }
		   $liquidacion->faltas = $faltas+" Día(s)";
		   $date3 = strtotime ( '-'.$faltas.' day' , strtotime ( $empleado->fecha_cese ) ) ;
		   $date3 = date ( 'Y-m-j' , $date3 );
		   $date3 = new DateTime($date3);
		   $diff2 = $date1->diff($date3);
		   $liquidacion->tiempo_computable = $diff2->y." Año(s), ".$diff2->m." Mes(es), ".$diff2->d." Día(s)";
		   //CTS
		   if( $empleado->carga_familiar == 1 ) { 
		   $liquidacion->asignacion_familiar = 85; 
		   }
		   $anio =  DB::table('anios')->where('anio_id','=',$periodo->anio_id)->first();
		   $fecha_cese = new DateTime($empleado->fecha_cese);		
		   $fecha_julio = new DateTime("".$anio->anio."-07-15");
           $fecha_diciembre = new DateTime("".$anio->anio."-12-15");
		   if($fecha_cese >= $fecha_diciembre){
		    $planilla = Planilla::where('periodo_id', '=', Session::get('periodo_id'))->
			                       where('id_trabajador', '=', $empleado->id_trabajador)->first();  
            $liquidacion->gratificacion = $planilla->c0401/6;							   
		   }
		   else if($fecha_cese >= $fecha_julio){
			$anio_julio =  DB::table('anios')->where('anio','=', strval(date("Y", strtotime($empleado->fecha_cese))))->first();
			$periodo_julio = Periodo::where('mes_id', '=', 7)->
			                           where('anio_id', '=', $anio_julio->anio_id)->
									    where('empresa_id', '=', $empleado->empresa_id)->first();
			$planilla = Planilla::where('periodo_id', '=', $periodo_julio->periodo_id)->
			                       where('id_trabajador', '=', $empleado->id_trabajador)->first();
			if($date1<$fecha_julio){
			$liquidacion->gratificacion = $planilla->c0401/6;	
			}            	
		   }
		   else{
			$anio_pasado =  DB::table('anios')->where('anio','=', strval(intval(date("Y", strtotime($empleado->fecha_cese)))-1))->first();
			$periodo_pasado = Periodo::where('mes_id', '=', 12)->
			                            where('anio_id', '=', $anio_pasado->anio_id)->
									     where('empresa_id', '=', $empleado->empresa_id)->first();
			if($periodo_pasado!=null){
    			$planilla = Planilla::where('periodo_id', '=', $periodo_pasado->periodo_id)->where('id_trabajador', '=', $empleado->id_trabajador)->first();
    			if($planilla!=null){
    			    $liquidacion->gratificacion = $planilla->c0401/6;        
    			}
    			else{
    			    $liquidacion->gratificacion =0.00;       
    			}
			}
			else{
			    $liquidacion->gratificacion =0.00;
			}
		   }
		   $liquidacion->total_computable_cts = $liquidacion->sueldo + $liquidacion->asignacion_familiar + $liquidacion->gratificacion + 
		                                        $liquidacion->promedio_hn_cts + $liquidacion->otros_conceptos_cts;
		   $fecha_mayo = new DateTime("".$anio->anio."-05-15");
           $fecha_noviembre = new DateTime("".$anio->anio."-11-15");
		   
		   if($fecha_cese >= $fecha_noviembre){
		   $diferenciaMes = $date1->diff(new DateTime("".($anio->anio)."-11-01"));
		   if($fecha_noviembre>=$date1 && $diferenciaMes->m!=0){
			$inicio_periodo_pendiente = new DateTime("".($anio->anio)."-11-01");	
			}
			else{
			$inicio_periodo_pendiente = $date1;
			}
			$diff_cts_trunco = $inicio_periodo_pendiente->diff($fecha_cese);
			if($diff->m!=0){
			$liquidacion->periodo_pendiente = "Del ".$inicio_periodo_pendiente->format('d-m-Y')." al ".$fecha_cese->format('d-m-Y');
            $liquidacion->meses_pen_cts = $diff_cts_trunco->m;	
			$liquidacion->dias_pen_cts = $diff_cts_trunco->d;
			}
		   }
		   else if($fecha_cese >= $fecha_mayo){
		   if($fecha_mayo>=$date1){
            $inicio_periodo_pendiente = new DateTime("".($anio->anio)."-05-01");
			}
			else{
			$inicio_periodo_pendiente = $date1;
			}
			$diff_cts_trunco = $inicio_periodo_pendiente->diff($fecha_cese);
			if($diff->m!=0){
			$liquidacion->periodo_pendiente = "Del ".$inicio_periodo_pendiente->format('d/m/Y')." al ".$fecha_cese->format('d/m/Y');
            $liquidacion->meses_pen_cts = $diff_cts_trunco->m;	
			$liquidacion->dias_pen_cts = $diff_cts_trunco->d;
			}
		   }
		   else{
            $inicio_periodo_pendiente = new DateTime("".($anio->anio-1)."-11-01");
			$diff_cts_trunco = $inicio_periodo_pendiente->diff($fecha_cese);
			if($diff->m!=0){
			$liquidacion->periodo_pendiente = "Del ".$inicio_periodo_pendiente->format('d/m/Y')." al ".$fecha_cese->format('d/m/Y');
            $liquidacion->meses_pen_cts = $diff_cts_trunco->m;	
			$liquidacion->dias_pen_cts = $diff_cts_trunco->d;
			}
			else{
    			$liquidacion->periodo_pendiente = "Del ".$inicio_periodo_pendiente->format('d/m/Y')." al ".$fecha_cese->format('d/m/Y');
                $liquidacion->meses_pen_cts =0;	
    			$liquidacion->dias_pen_cts = 0;    
			}
		   }
		   
		   $faltas_periodo_pdte = 0;
		   foreach ($suspensiones as $suspension){
			   if($suspension->tipo_suspension_id==1){
				   if(new DateTime($suspension->fecha_inicio)>=$inicio_periodo_pendiente && 
				   new DateTime($suspension->fecha_inicio)<=$fecha_cese){
					$faltas_periodo_pdte = $suspension->nro_dias + $faltas_periodo_pdte;	   
				   }
			   }         		
		   }
		   $liquidacion->dias_faltas_cts = $faltas_periodo_pdte;
		   $liquidacion->meses_cts= $liquidacion->meses_pen_cts;
		   $liquidacion->dias_cts= $liquidacion->dias_pen_cts-$liquidacion->dias_faltas_cts;
		   if($liquidacion->dias_cts<0){
		    $liquidacion->dias_cts=0;  
		   }
		   $liquidacion->cts_meses=$liquidacion->total_computable_cts/12*$liquidacion->meses_cts;
		   $liquidacion->cts_dias=$liquidacion->total_computable_cts/12/30*$liquidacion->dias_cts;
		   $liquidacion->total_cts=$liquidacion->cts_meses+$liquidacion->cts_dias;
		   //Vacaciones
		   $liquidacion->total_computable_vc=$liquidacion->sueldo + $liquidacion->asignacion_familiar + $liquidacion->otros_conceptos_cts;
		   $liquidacion->tiempo_servicio_vc = $liquidacion->tiempo_servicio;
		   $liquidacion->faltas_vc=$liquidacion->faltas;
		   $liquidacion->tiempo_computable_vc=$liquidacion->tiempo_computable;
		   $liquidacion->anios_vc=$diff2->y;
		   $liquidacion->meses_vc=$diff2->m;
		   $liquidacion->dias_vc=$diff2->d;
		   $liquidacion->anios_a_meses=$liquidacion->anios_vc*12;
		   $liquidacion->anios_a_dias=$liquidacion->anios_a_meses*2.5;
		   $liquidacion->meses_a_meses=$liquidacion->meses_vc*1;
		   $liquidacion->meses_a_dias=$liquidacion->meses_a_meses*2.5;
		   $liquidacion->dias_a_meses=($liquidacion->dias_vc/12)/2.5;
		   $liquidacion->dias_a_dias=$liquidacion->dias_a_meses*2.5;
		   $liquidacion->suma_dias=$liquidacion->anios_a_dias+$liquidacion->meses_a_dias+$liquidacion->dias_a_dias;
		   $liquidacion->suma_meses=$liquidacion->anios_a_meses+$liquidacion->meses_a_meses+$liquidacion->dias_a_meses;
		   $liquidacion->dias_vc_total=$liquidacion->suma_dias-$liquidacion->descanso_dias;		   
		   $liquidacion->meses_vc_total=$liquidacion->suma_meses-$liquidacion->descanso_meses;
		   if($liquidacion->meses_vc_total>=1){
		   $liquidacion->monto_meses_vc=$liquidacion->total_computable_vc/12*$liquidacion->meses_vc_total;
		   }
		   $liquidacion->total_vacaciones=$liquidacion->monto_meses_vc+$liquidacion->monto_dias_vc;
		   //Gratificaciones
		   $liquidacion->total_computable_gr = $liquidacion->sueldo + $liquidacion->asignacion_familiar  + 
		                                        $liquidacion->promedio_hn_cts + $liquidacion->otros_conceptos_cts;
												
		   $fecha_julio = new DateTime("".$anio->anio."-07-15");
           $fecha_diciembre = new DateTime("".$anio->anio."-12-15");
		   if($fecha_cese >= $fecha_diciembre){
		    if($fecha_diciembre>=$date1){
			$inicio_periodo_pendiente = new DateTime("".($anio->anio)."-12-01");
			}
			else{
			$inicio_periodo_pendiente = $date1;
			}
			$diff_gr_trunco = $inicio_periodo_pendiente->diff($fecha_cese);
			if($diff->m!=0){
			$liquidacion->periodo_pendiente_gr = "Del ".$inicio_periodo_pendiente->format('d-m-Y')." al ".$fecha_cese->format('d-m-Y');
            $liquidacion->meses_pdtes_gr = $diff_gr_trunco->m;	
			$liquidacion->dias_pdtes_gr = $diff_gr_trunco->d;
			}
		   }
		   else if($fecha_cese >= $fecha_julio){
		   if($fecha_julio>=$date1){
            $inicio_periodo_pendiente = new DateTime("".($anio->anio)."-07-01");
			}
			else{
			$inicio_periodo_pendiente = $date1;
			}
			$diff_gr_trunco = $inicio_periodo_pendiente->diff($fecha_cese);
			if($diff->m!=0){
			$liquidacion->periodo_pendiente_gr = "Del ".$inicio_periodo_pendiente->format('d/m/Y')." al ".$fecha_cese->format('d/m/Y');
            $liquidacion->meses_pdtes_gr = $diff_gr_trunco->m;	
			$liquidacion->dias_pdtes_gr = $diff_gr_trunco->d;
			}
		   }
		   else{
            $inicio_periodo_pendiente = new DateTime("".($anio->anio-1)."-12-01");
			$diff_gr_trunco = $inicio_periodo_pendiente->diff($fecha_cese);
			if($diff->m!=0){
    			$liquidacion->periodo_pendiente = "Del ".$inicio_periodo_pendiente->format('d/m/Y')." al ".$fecha_cese->format('d/m/Y');
                $liquidacion->meses_pdtes_gr = $diff_gr_trunco->m;	
    			$liquidacion->dias_pdtes_gr = $diff_gr_trunco->d;
			}
			else{
			    $liquidacion->periodo_pendiente = "Del ".$inicio_periodo_pendiente->format('d/m/Y')." al ".$fecha_cese->format('d/m/Y');
                $liquidacion->meses_pdtes_gr = 0;	
    			$liquidacion->dias_pdtes_gr = 0;
			}
		   }
		   $faltas_periodo_pdte_gr = 0;
		   foreach ($suspensiones as $suspension){
			   if($suspension->tipo_suspension_id==1){
				   if(new DateTime($suspension->fecha_inicio)>=$inicio_periodo_pendiente && 
				   new DateTime($suspension->fecha_inicio)<=$fecha_cese){
					$faltas_periodo_pdte_gr = $suspension->nro_dias + $faltas_periodo_pdte_gr;	   
				   }
			   }         		
		   }
		   $liquidacion->dias_falta_gr = $faltas_periodo_pdte_gr;
		   $liquidacion->meses_gr= $liquidacion->meses_pdtes_gr;
		   $liquidacion->dias_gr= $liquidacion->dias_pdtes_gr-$liquidacion->dias_falta_gr;
		   if($liquidacion->dias_gr<0){
		    $liquidacion->dias_gr=0;    
		   }
		   $liquidacion->monto_meses_gr=$liquidacion->total_computable_gr/6*$liquidacion->meses_gr;
		   $liquidacion->monto_dias_gr=$liquidacion->total_computable_gr/6/30*$liquidacion->dias_gr;
		   $liquidacion->boni_extra_gr=($liquidacion->monto_meses_gr+$liquidacion->monto_dias_gr)*0.09;
		   $liquidacion->total_gratificaciones=$liquidacion->monto_meses_gr+$liquidacion->monto_dias_gr+
		                                       $liquidacion->boni_extra_gr;
		   //Resumen						   
		   $liquidacion->total_remuneraciones=$liquidacion->total_cts+$liquidacion->total_vacaciones+
		                                       $liquidacion->total_gratificaciones;
		   //Descuentos								   
		   $liquidacion->total_descuentos	=0;
		   //Total Liquidacion
		   $liquidacion->total_liquidacion=$liquidacion->total_remuneraciones-$liquidacion->total_descuentos;
		   $liquidacion->save(); 	   
		   }
		   }
	       return response()->json("OK"); 	        
   }

	public function descargarLiquidacion(Request $request, $id = null) {     	  
	$liquidacion = \App\Models\Liquidacion::where('liquidacion_id','=',$id)
					             ->leftJoin('jl_empleados', 'jl_empleados.id_trabajador','=','liquidaciones.id_trabajador')
								 ->leftJoin('afps', 'afps.afp_id','=','jl_empleados.afp_id')
								 ->leftJoin('empresas', 'empresas.empresa_id','=','jl_empleados.empresa_id')
								 ->leftJoin('contratos', 'contratos.id_trabajador','=','jl_empleados.id_trabajador')
								 ->leftJoin('condicion_trabajo', 'condicion_trabajo.condicion_trabajo_id','=','contratos.condicion_trabajo_id')
								 ->select('jl_empleados.num_doc','jl_empleados.ape_paterno','jl_empleados.ape_materno','jl_empleados.fecha_nacimiento',
								 'jl_empleados.nombres','jl_empleados.centro_costo','afps.nombre','jl_empleados.n_cuspp',
								 'jl_empleados.fecha_nacimiento', 'empresas.razon_social', 'empresas.ruc', 'empresas.direccion', 'empresas.representante', 
								 'empresas.num_documento', 'contratos.fecha_ingreso', 'jl_empleados.fecha_cese', 'condicion_trabajo.descripcion',
								 'liquidaciones.sueldo', 'tiempo_servicio', 'faltas',
								 'tiempo_computable', 'asignacion_familiar', 'gratificacion', 'promedio_hn_cts', 
								 'otros_conceptos_cts', 'total_computable_cts', 'periodo_pendiente', 'meses_pen_cts', 'dias_pen_cts', 
								 'meses_faltas_cts', 'dias_faltas_cts', 'meses_cts', 'dias_cts', 'cts_meses', 
								 'cts_dias', 'total_cts', 'total_computable_vc', 'tiempo_servicio_vc', 'tiempo_computable_vc', 
								 'anios_vc', 'meses_vc', 'dias_vc', 'anios_a_dias', 'anios_a_meses', 
								 'meses_a_dias', 'meses_a_meses', 'dias_a_dias', 'dias_a_meses', 'suma_dias', 
								 'suma_meses', 'descanso_dias', 'descanso_meses', 'dias_vc_total', 'meses_vc_total', 
								 'monto_meses_vc', 'monto_dias_vc', 'total_vacaciones', 'faltas_vc','total_computable_gr','periodo_pendiente_gr'
								 ,'meses_pdtes_gr','dias_pdtes_gr','meses_falta_gr','dias_falta_gr'
								 ,'meses_gr','dias_gr','monto_meses_gr','monto_dias_gr'
								 ,'boni_extra_gr','total_gratificaciones','total_remuneraciones','total_descuentos','total_liquidacion')
								 ->first();
    $view =  \View::make('liquidacion.liquidacion_pdf', compact('liquidacion', 'id'))->render();
    $pdf = \App::make('snappy.pdf.wrapper');
    $pdf->loadHTML($view);
  
	return $pdf->stream('pdf'); 
		  
    }
    
	function listar( Request $request){
        $liquidaciones=Liquidacion::where('periodo_id','=',Session::get('periodo_id'))->get();
        foreach( $liquidaciones as $liquidacion ){
            $empleado=Empleado::where('id_trabajador','=',$liquidacion->id_trabajador)->first();
            if($empleado==null){
                $empleado=new Empleado();
            }
			$afp=Afp::where('afp_id','=',$empleado->afp_id)->first();
            if($afp==null){
                $afp=new Afp();
            }
            $lista[] = array('id' => $liquidacion->liquidacion_id, 'num_doc' => $empleado->num_doc, 'nombres' => $empleado->ape_paterno." ".$empleado->ape_materno.", ".$empleado->nombres, 
			'centro_costo' => $empleado->centro_costo,'afp' => $afp->nombre, 'cussp' => $empleado->n_cussp, 'fecha_ingreso' => $liquidacion->fecha_ingreso, 
			'fecha_cese' => $liquidacion->fecha_cese, 'tiempo_computable' => $liquidacion->tiempo_computable);
        }
        return response()->json($lista);
	}

}