<?php namespace App\Http\Controllers;

use App\Http\Controllers\controller;
use App\Models\Planillageneracion;
use App\Models\Planilla;
use App\Models\Empresa;
use App\Models\Empleado;
use App\Models\Suspension;
use App\Models\Concepto;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect ; 
use Session;
use File;
use Response;
use DB;
use ZipArchive;
use Maatwebsite\Excel\Facades\Excel;


class ArchivosgeneracionController extends Controller {

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
		return view('archivosgeneracion.detail',$this->data);
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

    function generaPlame(){
		$filasToc="";
		$filasRem="";
		$filasSnl="";
		$filasJor="";
		$planillas=Planilla::where('periodo_id','=',Session::get('periodo_id'))->get();		
		$pathToc = public_path()."/0601".Session::get('anio').Session::get('mes_codigo').Session::get('oempresa')->ruc.".toc";
		$pathRem = public_path()."/0601".Session::get('anio').Session::get('mes_codigo').Session::get('oempresa')->ruc.".rem";
		$pathSnl = public_path()."/0601".Session::get('anio').Session::get('mes_codigo').Session::get('oempresa')->ruc.".snl";
		$pathJor = public_path()."/0601".Session::get('anio').Session::get('mes_codigo').Session::get('oempresa')->ruc.".jor";
		$pathZip = public_path()."/ArchivosPlame.zip";
		foreach ($planillas as $planilla) {	
		
		$empleado = Empleado::find($planilla->id_trabajador);
		$tipo_documento = DB::table('tipo_documento')->where('tipo_documento_id','=',$empleado->tipo_doc)->first();
		$suspensiones_trabajador = Suspension::where('id_trabajador','=',$planilla->id_trabajador)
		->where('periodo_id','=',Session::get('periodo_id'))->get();
		$totalFaltas=0;
		$totalVacaciones=0;
		$totalDescanso=0;
		$filaSnl="";
		if($suspensiones_trabajador!=null){
		foreach ($suspensiones_trabajador as $suspension_trabajador) {	
		if($suspension_trabajador->tipo_suspension_id==1){
			$totalFaltas=$totalFaltas+$suspension_trabajador->nro_dias;
		}
		if($suspension_trabajador->tipo_suspension_id==2){
			$totalVacaciones=$totalVacaciones+$suspension_trabajador->nro_dias;
		}
		if($suspension_trabajador->tipo_suspension_id==3){
			$totalDescanso=$totalDescanso+$suspension_trabajador->nro_dias;
		}
		}
		}
		
		    //toc		
			$filaToc = "".$tipo_documento->codigo."|".$empleado->num_doc."|0|0||1|\n";
			$filasToc = $filasToc.$filaToc;
			File::put($pathToc,$filasToc);
		    //rem		
			$filaRem = 
			"".$tipo_documento->codigo."|".$empleado->num_doc."|0121|".number_format($planilla->c0121, 2, '.', '')."|".number_format($planilla->c0121, 2, '.', '')."|\n".
			"".$tipo_documento->codigo."|".$empleado->num_doc."|0115|".number_format($planilla->c0115, 2, '.', '')."|".number_format($planilla->c0115, 2, '.', '')."|\n".
			"".$tipo_documento->codigo."|".$empleado->num_doc."|0118|".number_format($planilla->c0118, 2, '.', '')."|".number_format($planilla->c0118, 2, '.', '')."|\n".
			"".$tipo_documento->codigo."|".$empleado->num_doc."|0201|".number_format($planilla->c0201, 2, '.', '')."|".number_format($planilla->c0201, 2, '.', '')."|\n".
			"".$tipo_documento->codigo."|".$empleado->num_doc."|0402|".number_format($planilla->c0402, 2, '.', '')."|".number_format($planilla->c0402, 2, '.', '')."|\n".
			"".$tipo_documento->codigo."|".$empleado->num_doc."|0909|".number_format($planilla->c0909, 2, '.', '')."|".number_format($planilla->c0909, 2, '.', '')."|\n".
			"".$tipo_documento->codigo."|".$empleado->num_doc."|0907|".number_format($planilla->c0907, 2, '.', '')."|".number_format($planilla->c0907, 2, '.', '')."|\n".
			"".$tipo_documento->codigo."|".$empleado->num_doc."|0917|".number_format($planilla->c0917, 2, '.', '')."|".number_format($planilla->c0917, 2, '.', '')."|\n".
			"".$tipo_documento->codigo."|".$empleado->num_doc."|0916|".number_format($planilla->c0916, 2, '.', '')."|".number_format($planilla->c0916, 2, '.', '')."|\n".
			"".$tipo_documento->codigo."|".$empleado->num_doc."|0902|".number_format($planilla->c0902, 2, '.', '')."|".number_format($planilla->c0902, 2, '.', '')."|\n".
			"".$tipo_documento->codigo."|".$empleado->num_doc."|0903|".number_format($planilla->c0903, 2, '.', '')."|".number_format($planilla->c0903, 2, '.', '')."|\n".
			"".$tipo_documento->codigo."|".$empleado->num_doc."|1001|".number_format($planilla->c1001, 2, '.', '')."|".number_format($planilla->c1001, 2, '.', '')."|\n".
			"".$tipo_documento->codigo."|".$empleado->num_doc."|1005|".number_format($planilla->c1005, 2, '.', '')."|".number_format($planilla->c1005, 2, '.', '')."|\n".
			"".$tipo_documento->codigo."|".$empleado->num_doc."|1002|".number_format($planilla->c1002, 2, '.', '')."|".number_format($planilla->c1002, 2, '.', '')."|\n".
			"".$tipo_documento->codigo."|".$empleado->num_doc."|0608|".number_format($planilla->c0608, 2, '.', '')."|".number_format($planilla->c0608, 2, '.', '')."|\n".
			"".$tipo_documento->codigo."|".$empleado->num_doc."|0606|".number_format($planilla->c0606, 2, '.', '')."|".number_format($planilla->c0606, 2, '.', '')."|\n".
			"".$tipo_documento->codigo."|".$empleado->num_doc."|0601|".number_format($planilla->c0601, 2, '.', '')."|".number_format($planilla->c0601, 2, '.', '')."|\n".
			"".$tipo_documento->codigo."|".$empleado->num_doc."|0605|".number_format($planilla->c0605, 2, '.', '')."|".number_format($planilla->c0605, 2, '.', '')."|\n".
			"".$tipo_documento->codigo."|".$empleado->num_doc."|0701|".number_format($planilla->c0701, 2, '.', '')."|".number_format($planilla->c0701, 2, '.', '')."|\n".
			"".$tipo_documento->codigo."|".$empleado->num_doc."|0706|".number_format($planilla->c0706, 2, '.', '')."|".number_format($planilla->c0706, 2, '.', '')."|\n".
			"".$tipo_documento->codigo."|".$empleado->num_doc."|0705|".number_format($planilla->c0705, 2, '.', '')."|".number_format($planilla->c0705, 2, '.', '')."|\n";
			$filasRem = $filasRem.$filaRem;
			File::put($pathRem,$filasRem);
			//snl	
            if($totalFaltas!=0){
			$filaSnl1 = "".$tipo_documento->codigo."|".$empleado->num_doc."|07|".$totalFaltas."|\n";
            $filaSnl=$filaSnl.$filaSnl1;		
			}	
			if($totalVacaciones!=0){
			$filaSnl2 = "".$tipo_documento->codigo."|".$empleado->num_doc."|23|".$totalVacaciones."|\n";	
			$filaSnl=$filaSnl.$filaSnl2;
			}
			if($totalDescanso!=0){
			$filaSnl3 = "".$tipo_documento->codigo."|".$empleado->num_doc."|21|".$totalDescanso."|\n";
			$filaSnl=$filaSnl.$filaSnl3;			
			}
			$filasSnl = $filasSnl.$filaSnl;
			File::put($pathSnl,$filasSnl);
			//jor		
			$filaJor = "".$tipo_documento->codigo."|".$empleado->num_doc."|208||||\n";
			$filasJor = $filasJor.$filaJor;
			File::put($pathJor,$filasJor);
		}

            $zip = new ZipArchive;		
            if ($zip->open( $pathZip, ZipArchive::CREATE) === TRUE) {
                $zip->addFile($pathToc,"0601".Session::get('anio').Session::get('mes_codigo').Session::get('oempresa')->ruc.".toc");
				$zip->addFile($pathRem,"0601".Session::get('anio').Session::get('mes_codigo').Session::get('oempresa')->ruc.".rem");
				$zip->addFile($pathSnl,"0601".Session::get('anio').Session::get('mes_codigo').Session::get('oempresa')->ruc.".snl");
				$zip->addFile($pathJor,"0601".Session::get('anio').Session::get('mes_codigo').Session::get('oempresa')->ruc.".jor");    
                $zip->close();
            }
		
		
		
        return Response::download($pathZip);
	}
	
	    function generaAFP(){
			Excel::create('AFP', function($excel){
                 
		         
				 $excel->sheet('Hoja1', function($sheet)
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
								 ->select('jl_empleados.n_cuspp', 'jl_empleados.num_doc','jl_empleados.ape_paterno',
								 'jl_empleados.ape_materno','jl_empleados.nombres','neto_pagar')
								 ->where('jl_empleados.snp_afp_id','=',2)
								 ->get();
                    //return dd($planillas);
					$nro_secuencia=1;
					$tipo_doc="0";
					$relacion_laboral="S";
					$inicioRL="N";
					$ceseRL="N";
					$excAportar="";
					$aporteconfin="0";
					$aportesinfin="0";
					$aporte_empleador="0";
					$tipo_trabajo_rubro="N";
					$campo_afp="";
				    foreach ($planillas as $key => $value) {
						$afps[] = array('secuencia' => $nro_secuencia, 'cussp' => $value['n_cuspp'], 'tipo_doc' => $tipo_doc, 
						'num_doc' => $value['num_doc'],'ape_paterno' => $value['ape_paterno'],'ape_materno' => $value['ape_materno'],
						'nombres' => $value['nombres'],'relacion_laboral' => $relacion_laboral,'inicioRL' => $inicioRL,'ceseRL' => $ceseRL,
						'excAportar' => $excAportar,'neto_pagar' => $value['neto_pagar'],'aporteconfin' => $aporteconfin,'aportesinfin' => $aportesinfin,
						'aporte_empleador' => $aporte_empleador,'tipo_trabajo_rubro' => $tipo_trabajo_rubro,'campo_afp' => $campo_afp);
						$nro_secuencia=$nro_secuencia+1;
					}
					$sheet->fromArray($afps);
                    $sheet->row(1,['Número de secuencia','CUSSP','Tipo  de documento de identidad',
					'Número de documento de indentidad','Apellido paterno','Apellido materno',
					'Nombres','Relación Laboral','Inicio de RL','Cese de RL','Excepcion de Aportar',
					'Remuneración asegurable','Aporte voluntario del afiliado con fin previsional',
					'Aporte voluntario del afiliado sin fin previsional','Aporte voluntario del empleador',
					'Tipo de trabajo Rubro','AFP(Conviene dejar en blanco)']);					
					$sheet->cell('A1:Q1', function($cell) {
						$cell->setFont(array('size' => '12', 'bold' => true));
				        $cell->setBackground('#58ACFA');
						$cell->setFontColor('#ffffff');
						$cell->setAlignment('center');
						$cell->setValignment('center');
						$cell->setBorder(array('top'   => array('style' => 'solid')));
						});
					$sheet->setBorder('A1:Q1', 'thin');	
					$sheet->setHeight(1, 50);
					$sheet->setAutoFilter('A1:Q1');
                    $sheet->setColumnFormat(array('J2:Q220' => '0.00'));
                    				
					});

					 
					 })->export('xls');
	}

}