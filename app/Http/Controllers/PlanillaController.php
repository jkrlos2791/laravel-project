<?php namespace App\Http\Controllers;

use App\Http\Controllers\controller;
use App\Models\Planilla;
use App\Models\Concepto;
use App\Models\Periodo;
use App\Models\Empleado;
use App\Models\Contrato;
use App\Models\Suspension;
use App\Models\Porcentajeafp;
use App\Models\Horasextras;
use App\Models\Parametria;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect ;
use DB;
use Session;
use Maatwebsite\Excel\Facades\Excel;
use DateTime;


class PlanillaController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'planilla';
	static $per_page	= '10';

	public function __construct()
	{
		
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new Planilla();
		
		$this->info = $this->model->makeInfo( $this->module);
		$this->access = $this->model->validAccess($this->info['id']);
	
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'planilla',
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

		$sort = (!is_null($request->input('sort')) ? $request->input('sort') : 'planilla_id'); 
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
		$pagination->setPath('planilla');
		
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
		return view('planilla.detail',$this->data);
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
		return view('planilla.form',$this->data);
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
			return view('planilla.view',$this->data);
		} else {
			return Redirect::to('planilla')->with('messagetext','Record Not Found !')->with('msgstatus','error');					
		}
	}	

	function postSave( Request $request)
	{
		
		$rules = $this->validateForm();
		$validator = Validator::make($request->all(), $rules);	
		if ($validator->passes()) {
			$data = $this->validatePost('tb_planilla');
			
			$id = $this->model->insertRow($data , $request->input('planilla_id'));
			
			if(!is_null($request->input('apply')))
			{
				$return = 'planilla/update/'.$id.'?return='.self::returnUrl();
			} else {
				$return = 'planilla?return='.self::returnUrl();
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

			return Redirect::to('planilla/update/'.$request->input('planilla_id'))->with('messagetext',\Lang::get('core.note_error'))->with('msgstatus','error')
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
			return Redirect::to('planilla?return='.self::returnUrl())
        		->with('messagetext', \Lang::get('core.note_success_delete'))->with('msgstatus','success'); 
	
		} else {
			return Redirect::to('planilla?return='.self::returnUrl())
        		->with('messagetext','No Item Deleted')->with('msgstatus','error');				
		}

	}	

	public static function display( )
	{
		$mode  = isset($_GET['view']) ? 'view' : 'default' ;
		$model  = new Planilla();
		$info = $model::makeInfo('planilla');

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
				return view('planilla.public.view',$data);
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
			return view('planilla.public.detail',$data);			
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
	
    function ingresar (){
		return view('planilla.generacion');
	}

     function calculoPlanilla (Request $request){
		   $parametria=Parametria::where('codigo','=','RMV')->first();
	  	   $planillas = Planilla::where('periodo_id', '=', Session::get('periodo_id'))->get();
		   foreach ($planillas as $planilla) {
               
            $empleado = Empleado::find($planilla->id_trabajador);
            
            if($empleado!=null){
            
            if($empleado->categoria_ocupacional != '3'){
           /* CALCULO DE PLANILLA PARA EMPLEADOS */
           $suspensiones = Suspension::where('id_trabajador', '=', $planilla->id_trabajador)->where('periodo_id', '=', Session::get('periodo_id'))->get();
           $dias_suspendidos = 0;
		   foreach ($suspensiones as $suspension) 
           {
			
            $dias_suspendidos = $suspension->nro_dias + $dias_suspendidos;
			
		   }
		   $contrato = Contrato::where('id_trabajador','=',$planilla->id_trabajador)->orderBy('contrato_id','asc')->first();
		   if($contrato==null){
		   return dd("falta contrato para: ");	   
		   }		   
		   $periodo = Periodo::find(Session::get('periodo_id'));
		   switch ($periodo->mes_id) {
               case 1: $mes = '01'; $diasMes = 31; break;
               case 2: $mes = '02'; $diasMes = 30; break;
    	       case 3: $mes = '03'; $diasMes = 31; break;
    		   case 4: $mes = '04'; $diasMes = 30; break;
    		   case 5: $mes = '05'; $diasMes = 31; break;
    		   case 6: $mes = '06'; $diasMes = 30; break;
    		   case 7: $mes = '07'; $diasMes = 31; break;
    		   case 8: $mes = '08'; $diasMes = 31; break;
    	       case 9: $mes = '09'; $diasMes = 30; break;
    		   case 10: $mes = '10'; $diasMes = 31; break;
    		   case 11: $mes = '11'; $diasMes = 30; break;
    		   case 12: $mes = '12'; $diasMes = 31; break;
           }			   
		   $anio =  DB::table('anios')->where('anio_id','=',$periodo->anio_id)->first();
		   
		   $fecha_ingreso = new DateTime($contrato->fecha_ingreso);
		   $primer_dia_mes = new DateTime("".$anio->anio."-".$mes."-01");

		   if($primer_dia_mes >= $fecha_ingreso){
		   $planilla->dias_considerados = 30;
		   }else{
		   $nro_dia_iniciado = date("j", strtotime($contrato->fecha_ingreso));
		   $planilla->dias_considerados = $diasMes-$nro_dia_iniciado+1;
		   }
		   $planilla->dias_computables = $planilla->dias_considerados - $dias_suspendidos;
		   if($planilla->dias_computables<0){
		    $planilla->dias_computables=0;
		   }
		   if($contrato->sueldo<$parametria->valor && $contrato->tipo_contrato_id!=2){
		    $contrato->sueldo=$parametria->valor;    
		   }
		   $planilla->c0121 = $contrato->sueldo / 30 * ($planilla->dias_computables);	   

		   if( $empleado->carga_familiar == 1 ) { 
		    $planilla->c0201 = doubleval($parametria->valor)*0.10; 
		   }
		   else{
	        $planilla->c0201 = 0.00;   
		   }
		   $nro_remuneracion_vacacional = 0;
		   $nro_descanso_medico = 0;
		   $nro_con_goce = 0;
		   $nro_paternidad = 0;
		   $nro_enfermedad = 0;
		   $nro_maternidad = 0;
		   //1:faltas,2:rem vac.,3:descanso,4:horas noct.,5:lic. con goce,6:lic sin goce,7:pater,8:enfer,9:matern,10:feriados
		   foreach ($suspensiones as $suspension){
                if( $suspension->tipo_suspension_id == 2 ){
                    $nro_remuneracion_vacacional = $suspension->nro_dias + $nro_remuneracion_vacacional; 
                } 
                if( $suspension->tipo_suspension_id == 3 ){
                    $nro_descanso_medico = $suspension->nro_dias + $nro_descanso_medico;
                }
                if( $suspension->tipo_suspension_id == 5 ){
                    $nro_con_goce = $suspension->nro_dias + $nro_con_goce;
                }
                if( $suspension->tipo_suspension_id == 8 ){
                    $nro_enfermedad = $suspension->nro_dias + $nro_enfermedad;
                }
                if( $suspension->tipo_suspension_id == 9 ){
                    $nro_maternidad = $suspension->nro_dias + $nro_maternidad;
                }
           }
		   $planilla->c0118 = $contrato->sueldo / 30 * $nro_remuneracion_vacacional; 
		   $planilla->c0916 = $contrato->sueldo / 30 * $nro_descanso_medico;
		   $planilla->c0907 = $contrato->sueldo / 30 * $nro_con_goce;
		   $planilla->enfermedad = $contrato->sueldo / 30 * $nro_enfermedad;
		   $planilla->c0915 = $contrato->sueldo / 30 * $nro_maternidad;
		   if($planilla->feriado == NULL){
		   $planilla->c0107 = 0;
		   }else{
		   $planilla->c0107 = (($contrato->sueldo + $planilla->c0201) / 30)*2;
		   }
		   $base_imponible_hn = $contrato->sueldo + $planilla->c0201;
		   $hora_base = ($base_imponible_hn / 30 / 8);
		   $recarga = $hora_base * 0.35;
		   $planilla->importe_hn = $recarga * $planilla->hn;
		   
		   //Logica Horas Extras
		   $sumaTotalHoras=0;
		   $rc=$contrato->sueldo + $planilla->c0201;
		   $vh=$rc/30/8;
		   $porcentaje25=$vh*0.25;
		   $porcentaje35=$vh*0.35;		   
		   $horasExtras = Horasextras::where('id_trabajador', '=', $empleado->id_trabajador)->where('periodo_id', '=', Session::get('periodo_id'))->get();
		   foreach ($horasExtras as $hora){				
				if($hora->nro_horas<2){
					$horas25=intval($hora->nro_horas);
					$horas35=0;
				}
				else{
					$horas25=2;
					$horas35=intval($hora->nro_horas)-2;
				}
				if($hora->feriado=="1"){
					$total25=($vh+$porcentaje25)*$horas25*2;
					$total35=($vh+$porcentaje35)*$horas35*2;
				}
				else{
					$total25=($vh+$porcentaje25)*$horas25;
					$total35=($vh+$porcentaje35)*$horas35;
				}
				if($hora->feriado=="1"){
					$totalHoras=($total25+$total35)+2*($rc/30);
				}
				else{
					$totalHoras=$total25+$total35;
				}
				$sumaTotalHoras=$sumaTotalHoras+$totalHoras;
           }		   
		   
		   $planilla->base_imponible = $planilla->c0121 + $planilla->c0201 + $planilla->c0118 + $planilla->c0916 + 
		   $planilla->c0907 + $planilla->c0915 + $planilla->enfermedad + $planilla->c0107 + $planilla->importe_hn + $planilla->c0402 + 
		   $planilla->c0902 + $sumaTotalHoras;
		   $planilla->total_ingresos = $planilla->base_imponible + $planilla->c0909 + $planilla->c0917 + $planilla->c0403 + 
		   $planilla->incentivos + $planilla->c0903 + $planilla->bono + $planilla->c0913 + $planilla->reg_recargo + 
		   $planilla->recargo_adicional + $planilla->c0306;
		   if( $empleado->snp_afp_id == 1 ) {
			   if($planilla->c0915 != NULL OR $planilla->enfermedad != NULL ){
			   $planilla->c0607 = ($planilla->base_imponible - ($planilla->c0915 + $planilla->enfermedad )) * 0.13;
			   }else{
			   $planilla->c0607 = $planilla->base_imponible * 0.13;
			   }
		   }
           if( $empleado->snp_afp_id == 2 ) 
           { 
	        $mes =  DB::table('meses')->where('mes_id','=',$periodo->mes_id)->first();
			$anio =  DB::table('anios')->where('anio_id','=',$periodo->anio_id)->first();
		    $afp_porcentaje = Porcentajeafp::where('afp_id', '=', $empleado->afp_id)->where('mes_id', '=',$mes->mes_id)->where('año_id', '=', $anio->anio_id)->first();
            if($afp_porcentaje==null){
		    return dd("falta ingresar porcentajes de la AFP para el periodo");	   
		    }	 
			if( $empleado->comision_tipo_id == 2 ){ 
			$planilla->c0601 = $planilla->base_imponible * $afp_porcentaje->comision_mixta / 100; 
			}
            else { 
			$planilla->c0601 = $planilla->base_imponible * $afp_porcentaje->comision / 100;	
			}
		    $planilla->c0608 = $planilla->base_imponible * $afp_porcentaje->fondo / 100;
			if ($planilla->base_imponible <= $afp_porcentaje->tope){
		    $planilla->c0606 = $planilla->base_imponible * $afp_porcentaje->seguro / 100;
			}else{
			$planilla->c0606 = $afp_porcentaje->importe_tope; 
			}
		    $planilla->afp = $planilla->c0601 + $planilla->c0608 + $planilla->c0606;
		   }
		
	       if($request->input('pagoBonoIncen')=="si"){
		   $planilla->c0706 = $planilla->incentivos + $planilla->bono + $planilla->vacaciones;
		   }
		   $planilla->total_descuentos = $planilla->afp + $planilla->c0605 + $planilla->c0706 + $planilla->c0607 + $planilla->eps + $planilla->c0701 + $planilla->c0704
		   + $planilla->prestamos + $planilla->c0903 + $planilla->c0604 + $planilla->c0703;
		   $planilla->neto_pagar = $planilla->total_ingresos - $planilla->total_descuentos;
		   
		   if(doubleval($parametria->valor)>$planilla->base_imponible){
		   $planilla->essalud = doubleval($parametria->valor)*0.09;
		   }
		   else{
		   if($planilla->c0915 != NULL OR $planilla->enfermedad != NULL ){
			$planilla->essalud = ($planilla->base_imponible - ($planilla->c0915 + $planilla->enfermedad )) * 0.09; 
		   }else{
		   $planilla->essalud = $planilla->base_imponible * 0.09;
		   }
		   }
		   $planilla->save();
                
            }
            /*
               else{
        
           // CALCULO DE PLANILLA PARA OBREROS 
		   $planilla->c0121 = $planilla->jornal + $planilla->destajo;
		   $planilla->c0904 = round(($planilla->c0121 * 0.0833) *  100) / 100;
		   if( $empleado->carga_familiar == 1 ) { 
		   $planilla->c0201 = 85; 
		   }
		   $planilla->c0118 = round(($planilla->c0121 * 0.0833) *  100) / 100;
		   $planilla->c0406 = round(($planilla->c0121 * 0.1666) *  100) / 100;
		   $planilla->c0312 = $planilla->c0406 * 0.09;
		   $planilla->base_imponible = $planilla->c0121 + $planilla->c0201 + $planilla->c0118;
		   $planilla->total_ingresos = $planilla->c0121 + $planilla->c0904 + $planilla->c0201 + $planilla->c0118 + $planilla->c0406 + $planilla->c0312 + $planilla->c0903 + $planilla->c0909 + $planilla->refrigerio;		  	   
		   if( $empleado->snp_afp_id == 1 ) {
			   if($planilla->c0915 != NULL OR $planilla->enfermedad != NULL ){
			   $planilla->c0607 = ($planilla->base_imponible - ($planilla->c0915 + $planilla->enfermedad )) * 0.13;
			   }else{
			   $planilla->c0607 = $planilla->base_imponible * 0.13;
			   }
		   }
           if( $empleado->snp_afp_id == 2 ) 
           { 
		    $afp_porcentaje = Porcentajeafp::where('afp_id', '=', $empleado->afp_id)->where('mes_id', '=', Session::get('mes'))->where('año_id', '=', Session::get('anio'))->first();
			if( $empleado->comision_tipo_id == 2 ){ 
			$planilla->c0601 = $planilla->base_imponible * $afp_porcentaje->comision_mixta / 100; 
			}
            else { 
			$planilla->c0601 = $planilla->base_imponible * $afp_porcentaje->comision / 100; 		
			}
		    $planilla->c0608 = $planilla->base_imponible * $afp_porcentaje->fondo / 100;
			if ($planilla->base_imponible <= $afp_porcentaje->tope){
		    $planilla->c0606 = $planilla->base_imponible * $afp_porcentaje->seguro / 100;
			}else{
			$planilla->c0606 = $afp_porcentaje->importe_tope; 
			}
		    $planilla->afp = $planilla->c0601 + $planilla->c0608 + $planilla->c0606;
		   }			   
		   $planilla->total_descuentos = $planilla->c0604 + $planilla->c0607 + $planilla->afp + $planilla->c0605 + $planilla->c0706 + $planilla->c0701 + $planilla->c0903;
		   $planilla->neto_pagar = $planilla->total_ingresos - $planilla->total_descuentos;
		   if($planilla->c0915 != NULL OR $planilla->enfermedad != NULL ){
			$planilla->c0804 = ($planilla->base_imponible - ($planilla->c0915 + $planilla->enfermedad )) * 0.09; 
		   }else{
		   $planilla->c0804 = $planilla->base_imponible * 0.09;
		   }
		   $planilla->save(); 
                   
               }
               */
            
		   }
		   else{
		     $planilla->delete();   
		   }
            
		   } 
		  return response()->json("OK");
   }
	
 function exportar (){
	   
	   Excel::create('PLANILLA', function($excel){
                 
		         
				 $excel->sheet('Planilla', function($sheet)
					{
				    
			     $campos = DB::getSchemaBuilder()->getColumnListing('planillas');
				 for ($i = 3; $i <= count($campos)-15; $i++) {  
                 $nombrecampos = Concepto::where('codigo','=',$campos[$i])->first();				 
                 }

										$planillas = Planilla::where('periodo_id','=',Session::get('periodo_id'))
					             ->leftJoin('jl_empleados', 'jl_empleados.id_trabajador','=','planillas.id_trabajador')
								 ->leftJoin('afps', 'afps.afp_id','=','jl_empleados.afp_id')
								 //->leftJoin('snp_afps', 'snp_afps.snp_afp_id','=','jl_empleados.snp_afp_id')
								 ->leftJoin('contratos', 'contratos.id_trabajador','=','jl_empleados.id_trabajador')
								 ->select('jl_empleados.num_doc','jl_empleados.ape_paterno','jl_empleados.ape_materno',
								 'jl_empleados.nombres','contratos.fecha_ingreso','contratos.fin_contrato','jl_empleados.fecha_nacimiento','jl_empleados.centro_costo','jl_empleados.cargo_empresa','afps.nombre','jl_empleados.n_cuspp','dias_computables', 'contratos.sueldo',  'c0121', 'c0201', 
								 'c0118', 'c0916', 'c0915', 'enfermedad', 'c0402','importe_hn', 'c0107',
							     'base_imponible','c0913','recargo_adicional', 'c0909', 'c0917', 'c0902', 'c0403', 
								 'incentivos', 'c0903', 'total_ingresos', 'c0608','c0606', 'c0601', 
								  'afp', 'c0607', 'c0605','c0604', 'c0706', 'prestamos', 'eps', 'c0703', 
								 'c0701', 'total_descuentos', 
								 'neto_pagar', 'essalud')
								 ->get();
                    //return dd($planillas);
					$sheet->fromArray($planillas);
                    $sheet->row(1,['Documento','Ape.Paterno', 'Ap.Materno', 'Nombres','Fecha de Ingreso','Vto.Contrato','Fecha Nacim','C.Costo','Cargo','AFP', 'CUSSP',
					'Dias.Compu', 'sueldo','Haber Basico', 'Asig.Famil', 'Rem.Vac', 'Impor.Desc.Medico', 'Impor.Mater', 'Import.Enferm', 'Grati.Ordinaria','Horas Noctu','Feriado',  
					'Base Imponible','Recargo Consumo','Recargo Adicional', 'Movilidad.Suped', 'Condic.Trabajo', 'Bono.Produc', 'Grati.Extraor', 'Incentivos', 'Canasta Navidad',
					'Total Ingresos', 'AFP_Fon', 'AFP_Seg', 'AFP_Comp', 'AFP', 'ONP', '5ta Categoria','Essalud Vida', 'Otros Dsctos. no Deducibles','Prestamos', 'EPS', 'Ret. Jud.', 'Adelanto',
					'Total Desc', 'Neto Pagar', 'ESSALUD']);					
					$sheet->cell('A1:AU1', function($cell) {
						$cell->setFont(array('size' => '12', 'bold' => true));
				        $cell->setBackground('#58ACFA');
						$cell->setFontColor('#ffffff');
						$cell->setAlignment('center');
						$cell->setValignment('center');
						$cell->setBorder(array('top'   => array('style' => 'solid')));
						});
					$sheet->setBorder('A1:AU1', 'thin');	
					$sheet->setHeight(1, 50);
					$sheet->setAutoFilter('A1:AU1');
                    $sheet->setColumnFormat(array('J2:AU220' => '0.00'));
                    $sheet->setColumnFormat(array('H2:H220' => 'dd/mm/yy'));
                    				
					});

					 
					 })->export('xls');
   
   }


}