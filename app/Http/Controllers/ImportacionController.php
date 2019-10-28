<?php namespace App\Http\Controllers;

use App\Http\Controllers\controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect ; 
use DB;
use Session;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Planilla;
use App\Models\Empleado; 
use App\Models\Contrato;
use App\Models\Suspension;

class ImportacionController extends Controller {
	
	public function importarEmpleados(){
            if(Input::hasFile('import_file')){
            $id_trabajador = 1 + DB::table('jl_empleados')->max('id_trabajador');
            $path = Input::file('import_file')->getRealPath();
			$data = Excel::load($path, function($reader) {
			})->get();
			if(!empty($data) && $data->count()){
				foreach ($data as $key => $value) {									
			if($value->num_doc!=null){	
            $empleado = Empleado::where('num_doc','=',$value->num_doc)->where('empresa_id','=',Session::get('empresa_id'))->first();
			if($empleado == null){
			//importar												
					$insert[] = [
                        'id_trabajador' => $id_trabajador,
                        'empresa_id' => Session::get('empresa_id'),
                        'codigo_trabajador' => $value->codigo_trabajador,
                        'ape_paterno' => $value->ape_paterno,
                        'ape_materno' => $value->ape_materno,
                        'nombres' => $value->nombres,
                        'tipo_doc' => $value->tipo_doc,
                        'num_doc' => $value->num_doc,
                        'dpto_nacimiento' => $value->dpto_nacimiento,
                        'prov_nacimiento' => $value->prov_nacimiento,
                        'dist_nacimiento' => $value->dist_nacimiento,
                        'fecha_nacimiento' => $value->fecha_nacimiento,
                        'nacionalidad' => $value->nacionalidad,
                        'sexo' => $value->sexo,
                        'estado_civil' => $value->estado_civil,
                        'carga_familiar' => $value->carga_familiar,
                        'categoria' => $value->categoria,
                        'telefono' => $value->telefono,
                        'celular' => $value->celular,
                        'email' => $value->email,
                        'tipo_via' => $value->tipo_via,
                        'via' => $value->via,
                        'numero_direccion' => $value->numero_direccion,
                        'dpto' => $value->dpto,
                        'interior' => $value->interior,
                        'block' => $value->block,
                        'mz' => $value->mz,
                        'lote' => $value->lote,
                        'km' => $value->km,
                        'etapa' => $value->etapa,
                        'referencia' => $value->referencia,
                        'tipo_zona' => $value->tipo_zona,
                        'zona' => $value->zona,
                        'dpto_ubigeo' => $value->dpto_ubigeo,
                        'prov_ubigeo' =>$value->prov_ubigeo,   
                        'dist_ubigeo' =>$value->dist_ubigeo,
                        'recibir_cts' =>$value->recibir_cts,
                        'flag_validar' =>$value->flag_validar,
                        'tipo_trabajador' =>$value->tipo_trabajador,
                        'categoria_ocupacional' =>$value->categoria_ocupacional,
                        'nivel_educativo' =>$value->nivel_educativo,
                        'ocupacion' => $value->ocupacion,
                        'estado_empleado_id' => $value->estado_empleado_id,
                        'cargo_empresa' => $value->cargo_empresa,
                        'unidad' => $value->unidad,  
                        'centro_costo' => $value->centro_costo,          
                        'centro_costo2' => $value->centro_costo2,                  
                        'horario_nocturno' => $value->horario_nocturno,
                        'discapacidad' => $value->discapacidad,    
                        'fecha_inscripcion' => $value->fecha_inscripcion,
                        'n_essalud' => $value->n_essalud,
                        'afp_id' => $value->afp_id,
                        'snp_afp_id' =>$value->snp_afp_id,
                        'comision_tipo_id' =>$value->comision_tipo_id,
						'n_cuspp' =>$value->n_cuspp,
						'centro_riesgo' =>$value->centro_riesgo,
						'tasa' =>$value->tasa,
						'tipo_riesgo' =>$value->tipo_riesgo,
						'tipo_contrato' =>$value->tipo_contrato,
						'fecha_inicio_contrato' =>$value->fecha_inicio_contrato,
						'fecha_fin_contrato' =>$value->fecha_fin_contrato,
                        'reg_alternativo' =>$value->reg_alternativo,
						'servicios_propios' =>$value->servicios_propios,
						'situacion_laboral' =>$value->situacion_laboral,
						'periocidad' =>$value->periocidad,
						'situacion_especial' =>$value->situacion_especial,
						'tipo_pago' =>$value->tipo_pago,
						'motivo_fin_periodo' =>$value->motivo_fin_periodo,
						'banco' =>$value->banco,
                        'tipo_cuenta' =>$value->tipo_cuenta,
						'num_cuenta' =>$value->num_cuenta,
						'moneda' =>$value->moneda,
						'banco_cts' =>$value->banco_cts,
						'num_cuenta_cts' =>$value->num_cuenta_cts,
						'moneda_cts' =>$value->moneda_cts,
						'tipo_boletas' =>$value->tipo_boletas,
						'complementario' =>$value->complementario,
                        'regimen_complementario' =>$value->regimen_complementario,
						'sctr_salud' =>$value->sctr_salud,
						'sctr_pension' =>$value->sctr_pension,
						'superior_inmediato' =>$value->superior_inmediato,
						'eps_ruc' =>$value->eps_ruc,
						'sujeto_a' =>$value->sujeto_a,
						'quinta_categoria' =>$value->quinta_categoria						
     			];
            $contrato=Contrato::where('id_trabajador','=',$id_trabajador)->first();		
			if($contrato==null){
			$nuevo_contrato = new Contrato();
			$nuevo_contrato->id_trabajador = $id_trabajador;
			$nuevo_contrato->fecha_ingreso = $value->fecha_ingreso;
			$nuevo_contrato->sueldo = $value->sueldo;
			$nuevo_contrato->save();
			}
            else{
            $contrato->fecha_ingreso = $value->fecha_ingreso;
			$contrato->sueldo = $value->sueldo;
			$contrato->save();
			}

			if($value->estado_empleado_id==1){
			$planilla=Planilla::where('periodo_id', '=', Session::get('periodo_id'))->where('id_trabajador','=',$id_trabajador)->first();
            if($planilla==null){
			$nueva_planilla = new Planilla();
			$nueva_planilla->id_trabajador = $id_trabajador;
			$nueva_planilla->periodo_id = Session::get('periodo_id');			
			$nueva_planilla->save();
			}
			}
			else{
			$planilla=Planilla::where('periodo_id', '=', Session::get('periodo_id'))->where('id_trabajador','=',$id_trabajador)->first();
            if($planilla!=null){			
			$planilla->delete();
			}	
			}
			
			            $id_trabajador = $id_trabajador + 1;
				}
            else{
			$empleado->ape_paterno = $value->ape_paterno;
			$empleado->ape_materno = $value->ape_materno;
			$empleado->nombres = $value->nombres;
			$empleado->tipo_doc = $value->tipo_doc;
			$empleado->dpto_nacimiento = $value->dpto_nacimiento;
			$empleado->prov_nacimiento = $value->prov_nacimiento;
			$empleado->dist_nacimiento = $value->dist_nacimiento;
			$empleado->fecha_nacimiento = $value->fecha_nacimiento;
			$empleado->nacionalidad = $value->nacionalidad;
			$empleado->sexo = $value->sexo;
			$empleado->estado_civil = $value->estado_civil;
			$empleado->carga_familiar = $value->carga_familiar;
			$empleado->categoria = $value->categoria;
			$empleado->telefono = $value->telefono;
			$empleado->celular = $value->celular;
			$empleado->email = $value->email;
			$empleado->tipo_via = $value->tipo_via;
			$empleado->via = $value->via;
			$empleado->numero_direccion = $value->numero_direccion;
			$empleado->dpto = $value->dpto;
			$empleado->interior = $value->interior;
			$empleado->block = $value->block;
			$empleado->mz = $value->mz;
			$empleado->lote = $value->lote;
			$empleado->km = $value->km;
			$empleado->etapa = $value->etapa;
			$empleado->referencia = $value->referencia;
			$empleado->tipo_zona = $value->tipo_zona;
			$empleado->zona = $value->zona;
			$empleado->dpto_ubigeo = $value->dpto_ubigeo;
			$empleado->prov_ubigeo =$value->prov_ubigeo;  
			$empleado->dist_ubigeo =$value->dist_ubigeo;
			$empleado->recibir_cts =$value->recibir_cts;
			$empleado->flag_validar =$value->flag_validar;
			$empleado->tipo_trabajador =$value->tipo_trabajador;
			$empleado->categoria_ocupacional =$value->categoria_ocupacional;
			$empleado->nivel_educativo =$value->nivel_educativo;
			$empleado->ocupacion = $value->ocupacion;
			$empleado->estado_empleado_id = $value->estado_empleado_id;
			$empleado->cargo_empresa = $value->cargo_empresa;
			$empleado->unidad = $value->unidad;  
			$empleado->centro_costo = $value->centro_costo;                            
			$empleado->horario_nocturno = $value->horario_nocturno;
			$empleado->discapacidad = $value->discapacidad;    
			$empleado->fecha_inscripcion = $value->fecha_inscripcion;
			$empleado->n_essalud =$value->n_essalud;
			$empleado->afp_id = $value->afp_id;
			$empleado->snp_afp_id =$value->snp_afp_id;
			$empleado->comision_tipo_id =$value->comision_tipo_id;
			$empleado->n_cuspp =$value->n_cuspp;
			$empleado->centro_riesgo =$value->centro_riesgo;
			$empleado->tasa =$value->tasa;
			$empleado->tipo_riesgo =$value->tipo_riesgo;
			$empleado->tipo_contrato =$value->tipo_contrato;
			$empleado->fecha_inicio_contrato =$value->fecha_inicio_contrato;
			$empleado->fecha_fin_contrato =$value->fecha_fin_contrato;
			$empleado->reg_alternativo =$value->reg_alternativo;
			$empleado->servicios_propios =$value->servicios_propios;
			$empleado->situacion_laboral =$value->situacion_laboral;
			$empleado->periocidad =$value->periocidad;
			$empleado->situacion_especial =$value->situacion_especial;
			$empleado->tipo_pago =$value->tipo_pago;
			$empleado->motivo_fin_periodo =$value->motivo_fin_periodo;
			$empleado->banco =$value->banco;
			$empleado->tipo_cuenta =$value->tipo_cuenta;
			$empleado->num_cuenta =$value->num_cuenta;
			$empleado->moneda =$value->moneda;
			$empleado->banco_cts =$value->banco_cts;
			$empleado->num_cuenta_cts =$value->num_cuenta_cts;
			$empleado->moneda_cts =$value->moneda_cts;
			$empleado->tipo_boletas =$value->tipo_boletas;
			$empleado->complementario =$value->complementario;
			$empleado->regimen_complementario =$value->regimen_complementario;
			$empleado->sctr_salud =$value->sctr_salud;
			$empleado->sctr_pension =$value->sctr_pension;
			$empleado->superior_inmediato =$value->superior_inmediato;
			$empleado->eps_ruc =$value->eps_ruc;
			$empleado->sujeto_a = $value->sujeto_a;
			$empleado->quinta_categoria = $value->quinta_categoria;		
            $empleado->save();			
			
			$contrato=Contrato::where('id_trabajador','=',$empleado->id_trabajador)->first();		
			if($contrato==null){
			$nuevo_contrato = new Contrato();
			$nuevo_contrato->id_trabajador = $empleado->id_trabajador;
			$nuevo_contrato->fecha_ingreso = $value->fecha_ingreso;
			$nuevo_contrato->sueldo = $value->sueldo;
			$nuevo_contrato->save();
			}
            else{
            $contrato->fecha_ingreso = $value->fecha_ingreso;
			$contrato->sueldo = $value->sueldo;
			$contrato->save();
			}

			if($value->estado_empleado_id==1){
			$planilla=Planilla::where('periodo_id', '=', Session::get('periodo_id'))->where('id_trabajador','=',$empleado->id_trabajador)->first();
            if($planilla==null){
			$nueva_planilla = new Planilla();
			$nueva_planilla->id_trabajador = $empleado->id_trabajador;
			$nueva_planilla->periodo_id = Session::get('periodo_id');			
			$nueva_planilla->save();
			}
			}
			else{
			$planilla=Planilla::where('periodo_id', '=', Session::get('periodo_id'))->where('id_trabajador','=',$empleado->id_trabajador)->first();
            if($planilla!=null){			
			$planilla->delete();
			}	
			}
			
			}

				}
			
				}        
				if(!empty($insert)){
					DB::table('jl_empleados')->insert($insert);
				}
			}
            return redirect::to('configuracion')->with('message', 'La importación se realizó con éxito.');
            }
        else{
		    return redirect::to('configuracion')->with('message', 'La importación no se pudo realizar.');
        }
    }
	
	public function importarSubsidios(){
	if(Input::hasFile('import_file')){
            $suspension_id = 1 + DB::table('suspensiones')->max('suspension_id');
            $path = Input::file('import_file')->getRealPath();
			$data = Excel::load($path, function($reader) {
			})->get();
			if(!empty($data) && $data->count()){
				
			   $suspensiones = Suspension::where('periodo_id', '=', Session::get('periodo_id'))->get();
			   $empleados = Empleado::where('empresa_id', '=', Session::get('empresa_id'))->get();
			   foreach ($suspensiones as $suspension) {
				  foreach ($empleados as $empleado) {
					if($suspension->id_trabajador == $empleado->id_trabajador){
					$suspension->delete();	
					}  
				  } 
			   }			
			
			foreach ($data as $key => $value) {					
				
			if($value->tipo_suspension_id!=null){	
				
            $empleado = Empleado::where('num_doc','=',$value->num_doc)->first();
			if($empleado != null){
			$nro_dias = (strtotime($value->fecha_fin)-strtotime($value->fecha_inicio))/86400;
			$nro_dias = abs($nro_dias); 
			$nro_dias = floor($nro_dias) + 1;
			//importar												
					$insert[] = [
                        'suspension_id' => $suspension_id,
                        'id_trabajador' => $empleado->id_trabajador,
                        'tipo_suspension_id' => $value->tipo_suspension_id,
                        'fecha_inicio' => $value->fecha_inicio,
                        'fecha_fin' => $value->fecha_fin,
						'nro_dias' => $nro_dias,
						'periodo_id' => Session::get('periodo_id')
			
     			];			
			            $suspension_id = $suspension_id + 1;
				}
				}
			
			
				}        
				if(!empty($insert)){
					DB::table('suspensiones')->insert($insert);
				}
			}
            return redirect::to('configuracion')->with('message', 'La importación se realizó con éxito.');
            }
        else{
		    return redirect::to('configuracion')->with('message', 'La importación no se pudo realizar.');
        }
	}
	
	public function importarConceptos(){
		if(Input::hasFile('import_file')){

            $path = Input::file('import_file')->getRealPath();
			$data = Excel::load($path, function($reader) {
			})->get();
			if(!empty($data) && $data->count()){
			
			foreach ($data as $key => $value) {					
				
            $empleado = Empleado::where('num_doc','=',$value->num_doc)->where('empresa_id','=',Session::get('empresa_id'))->first();
			if($empleado != null){
			//importar														    
            $planilla=Planilla::where('periodo_id', '=', Session::get('periodo_id'))->where('id_trabajador','=',$empleado->id_trabajador)->first();
            if($planilla!=null){
			$planilla->hn = $value->hn;
			$planilla->c0403 = $value->c0403;
			$planilla->c0909 = $value->c0909;
			$planilla->c0917 = $value->c0917;
			$planilla->c0903 = $value->c0903;
			$planilla->incentivos = $value->incentivos;
			$planilla->bono = $value->bono;
			$planilla->c0913 = $value->c0913;
			$planilla->reg_recargo = $value->reg_recargo;
			$planilla->recargo_adicional = $value->recargo_adicional;
			$planilla->c1001 = $value->c1001;
			$planilla->eps = $value->eps;
			$planilla->c0701 = $value->c0701;
			$planilla->prestamos = $value->prestamos;
			$planilla->c0604 = $value->c0604;
			$planilla->c0703 = $value->c0703;
			$planilla->c0107 = $value->c0107;
			$planilla->c0605 = $value->renta;
			$planilla->save();
			}
				}
			
				}        

			}
            return redirect::to('configuracion')->with('message', 'La importación se realizó con éxito.');
            }
        else{
		    return redirect::to('configuracion')->with('message', 'La importación no se pudo realizar.');
        }
	}
	
	public function mostrar(){
	return view('importacion.index');
	}	




}