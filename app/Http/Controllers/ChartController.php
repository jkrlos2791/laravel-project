<?php namespace App\Http\Controllers;

use App\Http\Controllers\controller;
use App\Models\Chart;
use App\Models\Dato;
use App\Models\Niveleducativo;
use App\Models\Tipodocumento;
use App\Models\Estadoempleado;
use App\Models\Centrocosto;
use App\Models\Categoria;
use App\Models\Tipotrabajador;
use App\Models\Nacionalidad;
use App\Models\Situacionespecial;
use App\Models\Tipopago;
use App\Models\Categoriaocupacional;
use App\Models\Ocupacion;
use App\Models\Periocidad;
use App\Models\Planilla;
use App\Models\Situacionlaboral;
use App\Models\Comisiontipos;
use App\Models\Serviciopropio;
use App\Models\Snpafp;
use App\Models\Afp;
use App\Models\Empleado;
use App\Models\Contrato;
use App\Models\Tipocontrato;
use App\Models\Suspension;
use App\Models\Tiposuspension;
use App\Models\Horasextras;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect ; 
use Session;


class ChartController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'dato';
	static $per_page	= '10';

	public function __construct(){
	}
	
	function obtenerChart(){
        $lista=Chart::get();
        return response()->json($lista);
	}

    public function prueba( Request $request ){
		return view('chart.index2');
	}	

	public function getIndex( Request $request )
	{
		/*
		if($this->access['is_view'] ==0) 
			return Redirect::to('dashboard')
				->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');

		$sort = (!is_null($request->input('sort')) ? $request->input('sort') : 'id_trabajador'); 
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
		$pagination->setPath('dato');
		
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
		return view('dato.index2',$this->data);
		*/
		return view('dato.index2');
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
			$this->data['row'] = $this->model->getColumnTable('jl_empleados'); 
		}
		$this->data['fields'] 		=  \SiteHelpers::fieldLang($this->info['config']['forms']);
		
		$this->data['id'] = $id;
		return view('dato.form',$this->data);
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
			return view('dato.view',$this->data);
		} else {
			return Redirect::to('dato')->with('messagetext','Record Not Found !')->with('msgstatus','error');					
		}
	}	

	function postSave( Request $request)
	{
		
		$rules = $this->validateForm();
		$validator = Validator::make($request->all(), $rules);	
		if ($validator->passes()) {
			$data = $this->validatePost('tb_dato');
				
			$id = $this->model->insertRow($data , $request->input('id_trabajador'));
			
			if(!is_null($request->input('apply')))
			{
				$return = 'dato/update/'.$id.'?return='.self::returnUrl();
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

			return Redirect::to('dato/update/'.$request->input('id_trabajador'))->with('messagetext',\Lang::get('core.note_error'))->with('msgstatus','error')
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
			return Redirect::to('dato?return='.self::returnUrl())
        		->with('messagetext', \Lang::get('core.note_success_delete'))->with('msgstatus','success'); 
	
		} else {
			return Redirect::to('dato?return='.self::returnUrl())
        		->with('messagetext','No Item Deleted')->with('msgstatus','error');				
		}

	}	

	public static function display( )
	{
		$mode  = isset($_GET['view']) ? 'view' : 'default' ;
		$model  = new Dato();
		$info = $model::makeInfo('dato');

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
				return view('dato.public.view',$data);
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
			return view('dato.public.index',$data);			
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

	function cargarComboEducativos(){
	    $lista="";
        $educativos=Niveleducativo::orderBy('nivel_educativo_id', 'ASC')->get();
		foreach( $educativos as $educativo ){
			$lista[] = $educativo->nombre;
		}
		return response()->json($lista);
	}

	function cargarComboDocumentos(){
        $lista=Tipodocumento::orderBy('tipo_documento_id', 'ASC')->get();
		return response()->json($lista);
	}
	
	function cargarComboEstadoEmpleados(){
        $lista=Estadoempleado::orderBy('estado_empleado_id', 'ASC')->get();
        return response()->json($lista);
	}
	
	function cargarComboCentroCostos(){
        $lista=Centrocosto::where('empresa_id','=',Session::get('empresa_id'))->orderBy('centro_costo_id', 'ASC')->get();
        return response()->json($lista);
	}
	
	function cargarComboCategorias(){
        $lista=Categoria::orderBy('categoria_id', 'ASC')->get();
        return response()->json($lista);
	}

	function cargarComboTipoTrabajadores(){
        $lista=Tipotrabajador::orderBy('tipo_trabajador_id', 'ASC')->get();
        return response()->json($lista);
	}
	
	function cargarComboNacionalidad(){
	    $lista="";
        $paises=Nacionalidad::orderBy('nacionalidad_id', 'ASC')->get();
		foreach( $paises as $pais ){
			$lista[] = $pais->descripcion;
		}
        return response()->json($lista);
	}

	function cargarComboSituacionEspecial(){
        $lista=Situacionespecial::orderBy('situacion_especial_id', 'ASC')->get();
        return response()->json($lista);
	}

	function cargarComboTipoPago(){
        $lista=Tipopago::orderBy('tipo_pago_id', 'ASC')->get();
        return response()->json($lista);
	}
	
	function cargarComboOcupacional(){
        $lista=Categoriaocupacional::orderBy('cat_ocupacional_id', 'ASC')->get();
        return response()->json($lista);
	}	
	
	function cargarComboOcupacion(){
	    $lista="";
        $ocupaciones=Ocupacion::orderBy('ocupacion_id', 'ASC')->get();
		foreach( $ocupaciones as $ocupacion ){
			$lista[] = $ocupacion->descripcion;
		}
        return response()->json($lista);
	}
	
	function cargarComboPeriocidad(){
        $lista=Periocidad::orderBy('periodo_id', 'ASC')->get();
        return response()->json($lista);
	}
	
	function cargarComboSituacionLaboral(){
        $lista=Situacionlaboral::orderBy('laboral_id', 'ASC')->get();
        return response()->json($lista);
	}
	
	function cargarComboComisionTipos(){
        $lista=Comisiontipos::orderBy('comision_tipo_id', 'ASC')->get();
        return response()->json($lista);
	}
	
	function cargarComboServicioPropio(){
        $lista=Serviciopropio::orderBy('servicios_id', 'ASC')->get();
        return response()->json($lista);
	}
	
	function cargarComboSnpAfp(){
        $lista=Snpafp::orderBy('snp_afp_id', 'ASC')->get();
        return response()->json($lista);
	}
	
	function cargarComboAfp(){
        $lista=Afp::orderBy('afp_id', 'ASC')->get();
        return response()->json($lista);
	}

	function cargarComboEmpleados(){
        $lista=Empleado::where('empresa_id','=',Session::get('empresa_id'))->orderBy('ape_paterno', 'ASC')->get();
        return response()->json($lista);
	}
	
	function cargarComboTipoContratos(){
        $lista=Tipocontrato::orderBy('tipo_contrato_id', 'ASC')->get();
        return response()->json($lista);
	}

	function cargarComboTipoSubsidios(){
        $lista=Tiposuspension::orderBy('tipo_suspension_id', 'ASC')->get();
        return response()->json($lista);
	}
	
	function capturarIdEmpleado(Request $request){
        Session::put('trabajador_id', $request->empleado);
		$id=Session::get('trabajador_id');
        return response()->json($id);
	}
	
	function obtenerEmpleado(){
		if(Session::get('trabajador_id')!=null){
			$empleado=Empleado::find(Session::get('trabajador_id'));	
		}
		else{
			$empleado="";	
		}		
        return response()->json($empleado);
	}

	function listarContratos(){
		$lista="";
		if(Session::get('trabajador_id')!=null && Session::get('trabajador_id')!=""){
			$contratos=Contrato::where('id_trabajador','=',Session::get('trabajador_id'))->get();
			foreach( $contratos as $contrato ){
				$tipoContrato=Tipocontrato::where('tipo_contrato_id','=',$contrato->tipo_contrato_id)->first();
				if($tipoContrato==null){
					$tipoContrato=new Tipocontrato();
				}
				$lista[] = array('contrato_id' => $contrato->contrato_id, 'descripcion' => $tipoContrato->descripcion, 'sueldo' => $contrato->sueldo,
				'fecha_ingreso' => $contrato->fecha_ingreso, 'inicio_contrato' => $contrato->inicio_contrato, 'fin_contrato' => $contrato->fin_contrato);
			}
		}
        return response()->json($lista);
	}

	function grabar( Request $request){
	    if($request->idEmpleado!=""){
	        $empleado=Empleado::find(intval($request->idEmpleado));
	    }
	    else{
    	    $empleado=new Empleado();
    	    $empleado->empresa_id=intval(Session::get('empresa_id'));
	    }
		if($empleado!=null){
			$empleado->ape_paterno=$request->paterno;
			$empleado->ape_materno=$request->materno;
			$empleado->nombres=$request->nombres;
			$empleado->tipo_doc=$request->tipoDoc;
			$empleado->num_doc=$request->numDoc;
			if($request->nacimiento!=""){
      			$partesFecha1=explode( '/', $request->nacimiento );
    			$fecha1=$partesFecha1[1]."/".$partesFecha1[0]."/".$partesFecha1[2];
    			$empleado->fecha_nacimiento=date('Y-m-d', strtotime($fecha1));  
			}
			$empleado->estado_civil=$request->estadoCivil;
			$empleado->sexo=$request->sexo;
			$empleado->centro_costo=$request->centroCosto;
			$empleado->email=$request->email;
			$empleado->celular=intval($request->celular);
			$empleado->estado_empleado_id=intval($request->estado);
			$empleado->categoria=$request->categoria;
			$empleado->tipo_trabajador=$request->tipoTrabajador;
			$empleado->nacionalidad=$request->nacionalidad;
			$empleado->situacion_especial=$request->situacionEspecial;
			$empleado->tipo_pago=$request->tipoPago;
			$empleado->categoria_ocupacional=$request->categoriaOcupacional;
			$empleado->ocupacion=$request->ocupacion;
			$empleado->periocidad=$request->periocidadRem;
			$empleado->discapacidad=intval($request->discapacidad);
			$empleado->horario_nocturno=intval($request->horarioNocturno);
			$empleado->carga_familiar=intval($request->cargaFamiliar);
			$empleado->nivel_educativo=$request->nivelEducativo;
			$empleado->n_cuspp=$request->cuspp;
			$empleado->servicios_propios=$request->eps;
			if($request->fechaInscripcion!=""){
    			$partesFecha2=explode( '/', $request->fechaInscripcion );
    			$fecha2=$partesFecha2[1]."/".$partesFecha2[0]."/".$partesFecha2[2];
    			$empleado->fecha_inscripcion=date('Y-m-d', strtotime($fecha2));
			}
			$empleado->snp_afp_id=intval($request->regimenPen);
			$empleado->afp_id=intval($request->afp);
			$empleado->comision_tipo_id=intval($request->tipoComision);
			$empleado->situacion_laboral=$request->situacionLaboral;
			if($request->fechaCese!=""){
    			$partesFecha3=explode( '/', $request->fechaCese );
    			$fecha3=$partesFecha3[1]."/".$partesFecha3[0]."/".$partesFecha3[2];
    			$empleado->fecha_cese=date('Y-m-d', strtotime($fecha3));
			}
			$empleado->save();

			$planilla=Planilla::where('periodo_id', '=', Session::get('periodo_id'))->where('id_trabajador','=',$empleado->id_trabajador)->first();
            if($planilla==null && $empleado->estado_empleado_id==1){
				$nueva_planilla = new Planilla();
				$nueva_planilla->id_trabajador = $empleado->id_trabajador;
				$nueva_planilla->periodo_id = Session::get('periodo_id');
				$nueva_planilla->save();
			}
			
		}		
        return response()->json($empleado);
	}

	function listarSubsidios(){
		$lista="";
		if(Session::get('trabajador_id')!=null && Session::get('trabajador_id')!=""){
			$suspensiones=Suspension::where('periodo_id', '=', Session::get('periodo_id'))->where('id_trabajador','=',Session::get('trabajador_id'))->get();
			foreach( $suspensiones as $suspension ){
				$tipoSuspension=Tiposuspension::where('tipo_suspension_id','=',$suspension->tipo_suspension_id)->first();
				if($tipoSuspension==null){
					$tipoSuspension=new Tiposuspension();
				}
				$lista[] = array('suspension_id' => $suspension->suspension_id, 'descripcion' => $tipoSuspension->descripcion, 'fecha_inicio' => $suspension->fecha_inicio,
				'fecha_fin' => $suspension->fecha_fin, 'nro_dias' => $suspension->nro_dias);
			}
		}
        return response()->json($lista);
	}

	function listarHoras(){
		$lista="";
		if(Session::get('trabajador_id')!=null && Session::get('trabajador_id')!=""){
			$lista=Horasextras::where('periodo_id', '=', Session::get('periodo_id'))->where('id_trabajador','=',Session::get('trabajador_id'))->get();
		}
        return response()->json($lista);
	}	
	
	function grabarContrato( Request $request){
	    if($request->idContrato!=""){
	        $contrato=Contrato::find(intval($request->idContrato));
	    }
	    else{
    	    $contrato=new Contrato();
			$contrato->id_trabajador=intval(Session::get('trabajador_id'));
	    }
		if($contrato!=null){
			$contrato->tipo_contrato_id=intval($request->tipo);
			$partesSueldo=explode( ',', $request->sueldo );
			$sueldo = implode("", $partesSueldo);
			$contrato->sueldo=floatval($sueldo);
			$partesFecha1=explode( '/', $request->ingreso );
			$fecha1=$partesFecha1[1]."/".$partesFecha1[0]."/".$partesFecha1[2];
			$contrato->fecha_ingreso=date('Y-m-d', strtotime($fecha1));
			$partesFecha2=explode( '/', $request->inicio );
			$fecha2=$partesFecha2[1]."/".$partesFecha2[0]."/".$partesFecha2[2];
			$contrato->inicio_contrato=date('Y-m-d', strtotime($fecha2));
			if($request->fin!=""){
    			$partesFecha3=explode( '/', $request->fin );
    			$fecha3=$partesFecha3[1]."/".$partesFecha3[0]."/".$partesFecha3[2];
    			$contrato->fin_contrato=date('Y-m-d', strtotime($fecha3));	
			}
			$contrato->save();	 
		}
		$tipoContrato=Tipocontrato::where('tipo_contrato_id','=',$contrato->tipo_contrato_id)->first();
		if($tipoContrato==null){
			$tipoContrato=new Tipocontrato();
		}
		$array = array('contrato_id' => $contrato->contrato_id, 'descripcion' => $tipoContrato->descripcion, 'sueldo' => $contrato->sueldo,
		'fecha_ingreso' => $contrato->fecha_ingreso, 'inicio_contrato' => $contrato->inicio_contrato, 'fin_contrato' => $contrato->fin_contrato);		
        return response()->json($array);
	}

	function obtenerContrato( Request $request){
        $contrato=Contrato::find(intval($request->id));
        return response()->json($contrato);
	}
	
	function eliminarContrato( Request $request){
		$contrato=Contrato::find(intval($request->contrato_id));
		$contrato->delete();
		return response()->json($contrato);
	}
	
	function grabarSubsidio( Request $request){
	    if($request->idSubsidio!=""){
	        $suspension=Suspension::find(intval($request->idSubsidio));
	    }
	    else{
    	    $suspension=new Suspension();
			$suspension->id_trabajador=intval(Session::get('trabajador_id'));
			$suspension->periodo_id=intval(Session::get('periodo_id'));
	    }
		if($suspension!=null){
			$suspension->tipo_suspension_id=intval($request->tipoSubsidio);
			$partesFecha1=explode( '/', $request->inicioSubsidio );
			$fecha1=$partesFecha1[1]."/".$partesFecha1[0]."/".$partesFecha1[2];
			$suspension->fecha_inicio=date('Y-m-d', strtotime($fecha1));
			$partesFecha2=explode( '/', $request->finSubsidio );
			$fecha2=$partesFecha2[1]."/".$partesFecha2[0]."/".$partesFecha2[2];
			$suspension->fecha_fin=date('Y-m-d', strtotime($fecha2));				
			$nro_dias = (strtotime($fecha2)-strtotime($fecha1))/86400;
			$nro_dias = abs($nro_dias); 
			$nro_dias = floor($nro_dias) + 1;
			$suspension->nro_dias = $nro_dias;	
			$suspension->nro_suspension = $request->nroSubsidio;
			$suspension->save();	 
		}
		$tiposuspension=Tiposuspension::where('tipo_suspension_id','=',$suspension->tipo_suspension_id)->first();
		if($tiposuspension==null){
			$tiposuspension=new Tiposuspension();
		}
		$array = array('suspension_id' => $suspension->suspension_id, 'descripcion' => $tiposuspension->descripcion, 
		'fecha_inicio' => $suspension->fecha_inicio, 'fecha_fin' => $suspension->fecha_fin, 'nro_dias' => $suspension->nro_dias);		
        return response()->json($array);
	}

	function obtenerSubsidio( Request $request){
        $suspension=Suspension::find(intval($request->id));
        return response()->json($suspension);
	}
	
	function eliminarSubsidio( Request $request){
		$suspension=Suspension::find(intval($request->suspension_id));
		$suspension->delete();
		return response()->json($suspension);
	}

	function grabarHora( Request $request){
	    if($request->idHora!=""){
	        $hora=Horasextras::find(intval($request->idHora));
	    }
	    else{
    	    $hora=new Horasextras();
			$hora->id_trabajador=intval(Session::get('trabajador_id'));
			$hora->periodo_id=intval(Session::get('periodo_id'));
	    }
		if($hora!=null){
			$partesFecha1=explode( '/', $request->fechaHora );
			$fecha1=$partesFecha1[1]."/".$partesFecha1[0]."/".$partesFecha1[2];
			$hora->fecha=date('Y-m-d', strtotime($fecha1));		
			$hora->nro_horas = $request->nroHora;
			$hora->feriado= $request->feriadoHora;							
			$hora->save();	 
		}	
        return response()->json($hora);
	}

	function obtenerHora( Request $request){
        $hora=Horasextras::find(intval($request->id));
        return response()->json($hora);
	}
	
	function eliminarHora( Request $request){
		$hora=Horasextras::find(intval($request->hora_id));
		$hora->delete();
		return response()->json($hora);
	}
	
}