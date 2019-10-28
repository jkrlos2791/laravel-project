<?php namespace App\Http\Controllers;

use App\Http\Controllers\controller;
use App\Models\Rentaquinta;
use App\Models\Empleado; 
use App\Models\Contrato; 
use App\Models\Periodo; 
use App\Models\Planilla;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect ; 
use Session;


class RentaquintaController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'rentaquinta';
	static $per_page	= '10';

	public function __construct()
	{
		
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new Rentaquinta();
		$this->info = $this->model->makeInfo( $this->module);
		$this->access = $this->model->validAccess($this->info['id']);
	
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'rentaquinta',
			'return'	=> self::returnUrl()
			
		);
		\App::setLocale(CNF_LANG);
		if (defined('CNF_MULTILANG') && CNF_MULTILANG == '1') {

		$lang = (\Session::get('lang') != "" ? \Session::get('lang') : CNF_LANG);
		\App::setLocale($lang);
		}  

		
	}

	public function getIndex( Request $request)
	{
		$sort = (!is_null($request->input('sort')) ? $request->input('sort') : 'quinta_id'); 
		$order = (!is_null($request->input('order')) ? $request->input('order') : 'asc');
		// End Filter sort and order for query 
		// Filter Search for query		
		$filter = (!is_null($request->input('search')) ? '': '');

		
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
		$pagination->setPath('rentaquinta');
		
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
		$this->data['colspan'] 		= \SiteHelpers::viewColSpan($this->info['config']['grid']);		
		// Group users permission
		$this->data['access']		= $this->access;
		// Detail from master if any
		
		// Master detail link if any 
		$this->data['subgrid']	= (isset($this->info['config']['subgrid']) ? $this->info['config']['subgrid'] : array()); 
		// Render into template
		
		return view('rentaquinta.form',$this->data);
	}

    function getUpdate(Request $request, $id = null)
	{
	
	    if(Session::get('empresa_id') == null){
        return Redirect::to('dashboard');	
		}
	
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
		
		if($id!=null)
		{
			$this->data['row'] = $this->model->where('id_trabajador','=',$id)->where('periodo_id','=',Session::get('periodo_id'))->first();
			//return dd($this->data['row']);
		} else {
			$this->data['row'] = $this->model->getColumnTable('quinta_retenciones'); 
		}
		$this->data['fields'] 		=  \SiteHelpers::fieldLang($this->info['config']['forms']);
		
		$this->data['id'] = $id;
		return view('rentaquinta.form',$this->data);
	}		

	 public function ingresar(Request $request)
	{
            $id = $request->input('empleado');
			return Redirect::to('rentaquinta/update/'.$id);
	}
	
	     function calculo (){
		   //Eliminar Retenciones		   		   
		   $retenciones = Rentaquinta::get();		   
		   $empleados = Empleado::where('empresa_id', '=', Session::get('empresa_id'))->get();
		   foreach ($retenciones as $retencion) {
		   	  foreach ($empleados as $empleado) {
				if($retencion->id_trabajador == $empleado->id_trabajador){
				$retencion->delete();	
				}  
			  } 
		   }
		   //Calcular Retenciones
		   $empleados = Empleado::where('empresa_id', '=', Session::get('empresa_id'))->get();
		   $periodo = Periodo::find(Session::get('periodo_id'));
		   foreach ($empleados as $empleado) {
		   $planilla = Planilla::where('periodo_id', '=', Session::get('periodo_id'))->where('id_trabajador','=',$empleado->id_trabajador)
		   ->first();
		   $retencion = new Rentaquinta(); 
           for ($x = 1; $x <= $periodo->mes_id; $x++) {		   
		   $retencion->id_trabajador = $empleado->id_trabajador;
		   $retencion->periodo_id = Session::get('periodo_id');
		   $contrato = Contrato::where('id_trabajador','=',$retencion->id_trabajador)->orderBy('contrato_id','asc')->first();
		   if( $empleado->carga_familiar == 1 ) { 
		   $asignacion = 85; 
		   }
		   else{
		   $asignacion = 0;
		   }
		   if($contrato!=null){
           $retencion->rem1 = $contrato->sueldo+$asignacion+$planilla->c0913;
		   $retencion->rem2 = $contrato->sueldo+$asignacion+$planilla->c0913;
		   $retencion->rem3 = $contrato->sueldo+$asignacion+$planilla->c0913;
		   $retencion->rem4 = $contrato->sueldo+$asignacion+$planilla->c0913;
		   $retencion->rem5 = $contrato->sueldo+$asignacion+$planilla->c0913;
		   $retencion->rem6 = $contrato->sueldo+$asignacion+$planilla->c0913;
		   $retencion->rem7 = $contrato->sueldo+$asignacion+$planilla->c0913;
		   $retencion->rem8 = $contrato->sueldo+$asignacion+$planilla->c0913;
		   $retencion->rem9 = $contrato->sueldo+$asignacion+$planilla->c0913;
		   $retencion->rem10 = $contrato->sueldo+$asignacion+$planilla->c0913;
		   $retencion->rem11 = $contrato->sueldo+$asignacion+$planilla->c0913;
		   $retencion->rem12 = $contrato->sueldo+$asignacion+$planilla->c0913;
		   }
		   $retencion->rem_subtotal = $retencion->rem1+$retencion->rem2+$retencion->rem3+$retencion->rem4+$retencion->rem5+$retencion->rem6+
		   $retencion->rem7+$retencion->rem8+$retencion->rem9+$retencion->rem10+$retencion->rem11+$retencion->rem12;
		   $retencion->grati1 = $contrato->sueldo+$asignacion;
		   if( $empleado->servicios_propios != null && $empleado->servicios_propios != 0) { 
		   $porcentaje_boni = 0.0675; 
		   }
		   else{
		   $porcentaje_boni = 0.09; 
		   }
		   $retencion->boni1 = $retencion->grati1*$porcentaje_boni;
		   $retencion->grati2 = $contrato->sueldo+$asignacion;
		   $retencion->boni2 = $retencion->grati2*$porcentaje_boni;
		   $retencion->total_ingresos = $retencion->rem_subtotal+$retencion->grati1+$retencion->boni1+$retencion->grati2+$retencion->boni2;
		   $retencion->deduccion = 28350.00;
		   $retencion->base_imponible = $retencion->total_ingresos-$retencion->deduccion;
		   if($retencion->base_imponible>20250.00){
		   $afecta1 = 20250.00;
		   }
		   else{
		   $afecta1 = $retencion->base_imponible;
		   }
		   $retencion->tasa1 = $afecta1*0.08;
		   
		   if($retencion->base_imponible-20250.00>1){
		   if($retencion->base_imponible-20250.00>60750.00){
		   $afecta2 = 60750.00;   
		   }
		   else{
		   $afecta2 = $retencion->base_imponible-20250.00;  
		   }
		   }
		   else{
		   $afecta2 = 0.00;
		   }
		   $retencion->tasa2 = $afecta2*0.14;
		    
		   if($retencion->base_imponible-81000.00>1){
		   if($retencion->base_imponible-81000.00>60750.00){
		   $afecta3 = 60750.00;   
		   }
		   else{
		   $afecta3 = $retencion->base_imponible-81000.00;  
		   }
		   }
		   else{
		   $afecta3 = 0.00;
		   }
		   $retencion->tasa3 = $afecta3*0.17;
		   
		   if($retencion->base_imponible-141750.00>1){
		   if($retencion->base_imponible-141750.00>40500.00){
		   $afecta4 = 40500.00;   
		   }
		   else{
		   $afecta4 = $retencion->base_imponible-141750.00;  
		   }
		   }
		   else{
		   $afecta4 = 0.00;
		   }
		   $retencion->tasa4 = $afecta4*0.20;
		   
		   if($retencion->base_imponible-182250.00>1){
		   $afecta5 = $retencion->base_imponible-182250.00;  
		   }
		   else{
		   $afecta5 = 0.00;
		   }
		   $retencion->tasa5 = $afecta5*0.30;		   
		   $retencion->impuesto_anual = $retencion->tasa1+$retencion->tasa2+$retencion->tasa3+$retencion->tasa4+$retencion->tasa5;
		   if($x == 2){   
		   $retencion->ret1 = $retencion->ret_final;
		   }
		   if($x == 3){
		   $retencion->ret2 = $retencion->ret_final;
		   }
		   if($x == 4){
		   $retencion->ret3 = $retencion->ret_final;
		   }
		   if($x == 5){
		   $retencion->ret4 = $retencion->ret_final;
		   }
		   if($x == 6){
		   $retencion->ret5 = $retencion->ret_final;
		   }
		   if($x == 7){
		   $retencion->ret6 = $retencion->ret_final;
		   }
		   if($x == 8){
		   $retencion->ret7 = $retencion->ret_final;
		   }
		   if($x == 9){
		   $retencion->ret8 = $retencion->ret_final;
		   }
		   if($x == 10){
		   $retencion->ret9 = $retencion->ret_final;
		   }
		   if($x == 11){
		   $retencion->ret10 = $retencion->ret_final;
		   }
		   if($x == 12){
		   $retencion->ret11 = $retencion->ret_final;
		   }
		   $retencion->total_retenciones = $retencion->ret1+$retencion->ret2+$retencion->ret3+$retencion->ret4+$retencion->ret5+$retencion->ret6+
		   $retencion->ret7+$retencion->ret8+$retencion->ret9+$retencion->ret10+$retencion->ret11+$retencion->ret12;	   
		   $retencion->saldo_impuesto_anual = $retencion->impuesto_anual-$retencion->total_retenciones;		   
		   $retencion->ret_ord = $retencion->saldo_impuesto_anual/(12-$x+1);
		   $planillas = Planilla::where('periodo_id', '=', Session::get('periodo_id'))->where('id_trabajador','=',$retencion->id_trabajador)
		   ->get();
		   foreach ($planillas as $planilla) {
		   if($x == $periodo->mes_id){
		   $retencion->ret_ext = ($planilla->c1001+ $planilla->recargo_adicional)* 0.08;
		   }		   
		   }
		   $retencion->ret_final = $retencion->ret_ord+$retencion->ret_ext;	
           }
           //fin for()		   
		   $retencion->save(); 
	   
	       $planilla = Planilla::where('periodo_id', '=', Session::get('periodo_id'))->where('id_trabajador','=',$empleado->id_trabajador)
		   ->first();
		   if($retencion->ret_final > 0){
		   $planilla->c0605=$retencion->ret_final;   
		   }
		   else{
		   $planilla->c0605=0;   
		   }
		   $planilla->save();
		   }
	       return Redirect::to('rentaquinta/update')->with('message', 'El cálculo se realizó con éxito.');   	        
   }
	
}