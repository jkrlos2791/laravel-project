<?php 

namespace App\Http\ViewComposers;
use Illuminate\Contracts\View\View;
use Illuminate\Users\Repository as UserRepository;
use Request;
use DB;
use Session;

class OtrosConceptosComposer  {
    
  public function compose(View $view){
    
   $habilitado = \App\Models\Concepto::select('itd_id', DB::raw('descripcion'))->where('empresa_id', '=', 0)->where('tipo_concepto', '=', 1)->orderBy('descripcion', 'ASC')->lists('descripcion', 'itd_id');
  
  $habilitado = ['' => ''] + $habilitado->toArray();
      
  $view->with(compact('habilitado'));
            
  }
    
}
