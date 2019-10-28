<?php namespace App\Http\Controllers;

use App\Http\Controllers\controller;
use App\Models\Configuracion;
use App\Models\Parametria;
use App\Models\Porcentajeafp;
use App\Models\Afp;
use App\Models\Mes;
use App\Models\Anio;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect ; 


class ConfiguracionController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'configuracion';
	static $per_page	= '10';

	public function __construct()
	{
		
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new Configuracion();
		$this->info = $this->model->makeInfo( $this->module);
		$this->access = $this->model->validAccess($this->info['id']);
	
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'configuracion',
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

		
		return view('configuracion.index2',$this->data);
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
				
		$this->data['access']		= $this->access;
		return view('configuracion.form',$this->data);
	}	

	public function getShow( $id = null)
	{
	
		if($this->access['is_detail'] ==0) 
			return Redirect::to('dashboard')
				->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');
					
		
		$this->data['access']		= $this->access;
		return view('configuracion.view',$this->data);	
	}	

	function postSave( Request $request)
	{
		
	
	}	

	public function postDelete( Request $request)
	{
		
		if($this->access['is_remove'] ==0) 
			return Redirect::to('dashboard')
				->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');
		
	}			

	function obtenerConfiguracion(){
		$parametria=Parametria::where('codigo','=','RMV')->first();	
        return response()->json($parametria);
	}

	function listarPorcentajes(){
		$lista="";
		$porcentajes=Porcentajeafp::orderBy('mes_id', 'desc')->orderBy('año_id', 'desc')->get();
		foreach( $porcentajes as $porcentaje ){
		    $afp=Afp::where('afp_id','=',$porcentaje->afp_id)->first();
			if($afp==null){
				$afp=new Afp();
			}
			$mes=Mes::where('mes_id','=',$porcentaje->mes_id)->first();
			if($mes==null){
				$mes=new Mes();
			}
			$anio=Anio::where('anio_id','=',$porcentaje->año_id)->first();
			if($anio==null){
				$anio=new Anio();
			}
			$lista[] = array('afp_porcentaje_id' => $porcentaje->afp_porcentaje_id, 'nombre' => $afp->nombre, 'mes' => $mes->mes, 'anio' => $anio->anio,
			'comision' => $porcentaje->comision, 'comision_mixta' => $porcentaje->comision_mixta, 'fondo' => $porcentaje->fondo, 'seguro' => $porcentaje->seguro,
			'tope' => $porcentaje->tope, 'importe_tope' => $porcentaje->importe_tope);
		}
        return response()->json($lista);
	}

	function grabar( Request $request){
	    $parametria=Parametria::where('codigo','=','RMV')->first();	
		if($parametria!=null){
		    $partes1=explode( ',', $request->rmv );
    		$rmv = implode("", $partes1);
			$parametria->valor=intval($rmv);
			$parametria->save();
		}		
        return response()->json($parametria);
	}

	function grabarPorcentaje( Request $request){
	    $porcentaje=Porcentajeafp::where('afp_id','=',intval($request->afp))->where('mes_id','=',intval($request->mes))->where('año_id','=',intval($request->anio))->first();
	    if($porcentaje==null){
    	    if($request->idPorcentaje!=""){
    	        $porcentaje=Porcentajeafp::find(intval($request->idPorcentaje));
    	    }
    	    else{
        	    $porcentaje=new Porcentajeafp();
    	    }
    		if($porcentaje!=null){
    		    $porcentaje->afp_id=intval($request->afp);
    			$porcentaje->mes_id=intval($request->mes);
    			$porcentaje->año_id=intval($request->anio);
    			$partes1=explode( ',', $request->comision );
        		$comision = implode("", $partes1);
    			$porcentaje->comision=doubleval($comision);
    			$partes2=explode( ',', $request->comisionMixta );
        		$comisionMixta = implode("", $partes2);
    			$porcentaje->comision_mixta=doubleval($comisionMixta);
    			$partes3=explode( ',', $request->fondo );
        		$fondo = implode("", $partes3);
    			$porcentaje->fondo=doubleval($fondo);
    			$partes4=explode( ',', $request->seguro );
        		$seguro = implode("", $partes4);			
    			$porcentaje->seguro=doubleval($seguro);
    			$partes5=explode( ',', $request->tope );
        		$tope = implode("", $partes5);			
    			$porcentaje->tope=doubleval($tope);
    			$partes6=explode( ',', $request->importeTope );
        		$importeTope = implode("", $partes6);			
    			$porcentaje->importe_tope=doubleval($importeTope);
    			$porcentaje->save();	 
    		}
    	    $afp=Afp::where('afp_id','=',$porcentaje->afp_id)->first();
    		if($afp==null){
    			$afp=new Afp();
    		}
    		$mes=Mes::where('mes_id','=',$porcentaje->mes_id)->first();
    		if($mes==null){
    			$mes=new Mes();
    		}
    		$anio=Anio::where('anio_id','=',$porcentaje->año_id)->first();
    		if($anio==null){
    			$anio=new Anio();
    		}
    		$array = array('afp_porcentaje_id' => $porcentaje->afp_porcentaje_id, 'nombre' => $afp->nombre, 'mes' => $mes->mes, 'anio' => $anio->anio,
    			'comision' => $porcentaje->comision, 'comision_mixta' => $porcentaje->comision_mixta, 'fondo' => $porcentaje->fondo, 'seguro' => $porcentaje->seguro,
    			'tope' => $porcentaje->tope, 'importe_tope' => $porcentaje->importe_tope);
            return response()->json($array);    
	    }
	    else{
	        return response()->json("PORCENTAJE_EXISTE");
	    }

	}

	function eliminarPorcentaje( Request $request){
		$porcentaje=Porcentajeafp::find(intval($request->afp_porcentaje_id));
		$porcentaje->delete();
		return response()->json($porcentaje);
	}

}