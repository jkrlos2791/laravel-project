<?php 

namespace App\Http\ViewComposers;
use Illuminate\Contracts\View\View;
use Illuminate\Users\Repository as UserRepository;
use Request;
use DB;
use Session;

class EmpleadoDetailComposer  {
    
  public function compose(View $view){
    
   $empleado = \App\Models\Empleado::select('id_trabajador', DB::raw('CONCAT(LTRIM(RTRIM(ape_paterno)), " ", LTRIM(RTRIM(ape_materno)), " ", LTRIM(RTRIM(nombres)), " (", num_doc, ")") AS nombres_completos'))->where('empresa_id', '=', Session::get('empresa_id'))->orderBy('ape_paterno', 'ASC')->lists('nombres_completos', 'id_trabajador');
      
  $view->with(compact('empleado'));
            
  }
    
}
