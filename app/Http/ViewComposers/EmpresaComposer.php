<?php 

namespace App\Http\ViewComposers;
use Illuminate\Contracts\View\View;
use Illuminate\Users\Repository as UserRepository;
use Request;
use DB;
use Session;

class EmpresaComposer  {
    
  public function compose(View $view){
    
   $empresa = \App\Models\Empresa::select('empresa_id', DB::raw('razon_social'))->orderBy('razon_social', 'ASC')->lists('razon_social', 'empresa_id');
      
  $view->with(compact('empresa'));
            
  }
    
}
