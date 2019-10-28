<?php 

namespace App\Providers;

use Illuminate\Support\ServiceProvider;


class ComposerServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
     view()->composer('empleado/form', 'App\Http\ViewComposers\EmpleadoComposer');
	 view()->composer('empleado/formCreate', 'App\Http\ViewComposers\EmpleadoComposer');
	 view()->composer('editable/index', 'App\Http\ViewComposers\EditableComposer');
	 view()->composer('empresa/form', 'App\Http\ViewComposers\EmpresaComposer');
	 view()->composer('otrosconceptos/index', 'App\Http\ViewComposers\OtrosConceptosComposer');
     view()->composer('empleado/detail', 'App\Http\ViewComposers\EmpleadoDetailComposer');
	 view()->composer('empleado/index', 'App\Http\ViewComposers\EmpleadoDetailComposer');
	 view()->composer('rentaquinta/form', 'App\Http\ViewComposers\EmpleadoDetailComposer');
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}

}
