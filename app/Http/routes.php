<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application. 
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

$active_multilang = defined('CNF_MULTILANG') ? CNF_LANG : 'es'; 
 \App::setLocale($active_multilang);
 if (defined('CNF_MULTILANG') && CNF_MULTILANG == '1') {

    $lang = (\Session::get('lang') != "" ? \Session::get('lang') : CNF_LANG);
    \App::setLocale($lang);
}   

Route::get('/', 'DashboardController@getIndex');
Route::controller('home', 'HomeController');

Route::controller('/user', 'UserController');
include('pageroutes.php');
include('moduleroutes.php');

Route::get('/restric',function(){

	return view('errors.blocked');

});

Route::resource('sximoapi', 'SximoapiController'); 
Route::group(['middleware' => 'auth'], function()
{

	Route::get('core/elfinder', 'Core\ElfinderController@getIndex');
	Route::post('core/elfinder', 'Core\ElfinderController@getIndex'); 
	Route::controller('/dashboard', 'DashboardController');
	Route::controllers([
		'core/users'		=> 'Core\UsersController',
		'notification'		=> 'NotificationController',
		'post'				=> 'PostController',
		'core/logs'			=> 'Core\LogsController',
		'core/pages' 		=> 'Core\PagesController',
		'core/groups' 		=> 'Core\GroupsController',
		'core/template' 	=> 'Core\TemplateController',
		'core/posts'		=> 'Core\PostsController',
		'core/forms'		=> 'Core\FormsController'
	]);

});	

Route::group(['middleware' => 'auth' , 'middleware'=>'sximoauth'], function()
{

	Route::controllers([
		'sximo/menu'		=> 'Sximo\MenuController',
		'sximo/config' 		=> 'Sximo\ConfigController',
		'sximo/module' 		=> 'Sximo\ModuleController',
		'sximo/tables'		=> 'Sximo\TablesController',
		'sximo/code'		=> 'Sximo\CodeController'
	]);			



});

Route::get('detail', 'EmpleadoController@getDetail');
Route::get('empresa_ingresar/{id}', ['as' => 'empresa.ingresar', 'uses' =>  'EmpresaController@ingresar']);
Route::get('periodo_ingresar/{id}', ['as' => 'periodo.ingresar', 'uses' =>  'PeriodoController@ingresar']);
Route::post('save_habilitado', 'ConceptoController@actualizarHabilitado');
Route::patch('habilitado_cita', [
    'as' => 'itd.habilitado',
    'uses' => 'ConceptoController@actHabilitado',
                ]); 
Route::post('save_habilitado2', 'AfectacionController@actualizarHabilitado');
Route::patch('estado_cita2', [
    'as' => 'itd.estado',
    'uses' => 'AfectacionController@actEstado',
                ]); 

Route::post('captura_centro_costo', ['as' => 'captura.centro', 'uses' => 'EmpresaController@ingresar']);
Route::post('captura_centro_costo2', ['as' => 'captura.centro2', 'uses' => 'EmpresaController@ingresar']);
Route::post('captura_habilitado', ['as' => 'captura.habilitado', 'uses' => 'EditableController@mostrar']); 
Route::post('captura_habilitado2', ['as' => 'captura.habilitado2', 'uses' => 'OtrosconceptosController@mostrar']); 
Route::get('captura_afp/{id}', 'PorcentajeafpController@capturar');
Route::post('calculo_planilla', 'PlanillaController@calculoPlanilla');
Route::get('generacion', 'PlanillaController@ingresar');
Route::post('mostrar_planilla', ['as' => 'mostrar.planilla', 'uses' => 'PlanillageneracionController@mostrar']); 
Route::get('descargar', 'PlanillaController@exportar');
Route::get('listar_empleados', 'PlanillageneracionController@mostrar');
Route::get('listar_obreros', 'PlanillageneracionController@mostrarObreros');
Route::get('descargar_boletas', 'BoletaController@descargarBoletas');
Route::post('empresa_ingresar', ['as' => 'empresa.ingresar', 'uses' =>  'EmpresaController@ingresar']);
Route::post('empleado_buscar', ['as' => 'empleado.buscar', 'uses' =>  'EmpleadoController@buscar']);
Route::get('calculo_gratificacion', 'GratificacionController@calculo');
Route::get('importacion_datos', ['as' => 'importacion.mostrar', 'uses' =>  'ImportacionController@mostrar']);
Route::post('importar_empleados', ['as' => 'empleados.importar', 'uses' =>  'ImportacionController@importarEmpleados']);
Route::post('importar_subsidios', ['as' => 'subsidios.importar', 'uses' =>  'ImportacionController@importarSubsidios']);
Route::post('importar_conceptos', ['as' => 'conceptos.importar', 'uses' =>  'ImportacionController@importarConceptos']);
Route::post('renta_ingresar', ['as' => 'renta.ingresar', 'uses' =>  'RentaquintaController@ingresar']);
Route::get('calculo_rentaquinta', 'RentaquintaController@calculo');
Route::post('empresa_eliminar', ['as' => 'empresa.eliminar', 'uses' =>  'EmpresaController@eliminar']);
Route::get('calculo_liquidacion', 'LiquidacionController@calculo');
Route::get('descargar_liquidacion/{id}', 'LiquidacionController@descargarLiquidacion');
Route::get('archivos_generacion', 'ArchivosgeneracionController@getIndex');
Route::get('generacion_plame', 'ArchivosgeneracionController@generaPlame');
Route::get('generacion_afp', 'ArchivosgeneracionController@generaAFP');
Route::get('listarPlanillas', 'PlanillageneracionController@listar');
Route::get('listarLiquidaciones', 'LiquidacionController@listar');
Route::get('comboConceptos', 'EditableController@cargarComboConceptos');
Route::post('listarPorConcepto', 'EditableController@listar');
Route::post('obtenerConceptoEditable', 'EditableController@obtener');
Route::get('comboEducativos', 'DatoController@cargarComboEducativos');
Route::get('comboDocumentos', 'DatoController@cargarComboDocumentos');
Route::get('comboEstadoEmpleados', 'DatoController@cargarComboEstadoEmpleados');
Route::get('comboCentroCostos', 'DatoController@cargarComboCentroCostos');
Route::get('comboCategorias', 'DatoController@cargarComboCategorias');
Route::get('comboTipoTrabajadores', 'DatoController@cargarComboTipoTrabajadores');
Route::get('comboNacionalidad', 'DatoController@cargarComboNacionalidad');
Route::get('comboSituacionEspecial', 'DatoController@cargarComboSituacionEspecial');
Route::get('comboTipoPago', 'DatoController@cargarComboTipoPago');
Route::get('comboOcupacional', 'DatoController@cargarComboOcupacional');
Route::get('comboOcupacion', 'DatoController@cargarComboOcupacion');
Route::get('comboPeriocidad', 'DatoController@cargarComboPeriocidad');
Route::get('comboSituacionLaboral', 'DatoController@cargarComboSituacionLaboral');
Route::get('comboComisionTipos', 'DatoController@cargarComboComisionTipos');
Route::get('comboServicioPropio', 'DatoController@cargarComboServicioPropio');
Route::get('comboSnpAfp', 'DatoController@cargarComboSnpAfp');
Route::get('comboAfp', 'DatoController@cargarComboAfp');
Route::get('comboEmpleados', 'DatoController@cargarComboEmpleados');
Route::get('comboTipoContratos', 'DatoController@cargarComboTipoContratos');
Route::get('comboTipoSubsidios', 'DatoController@cargarComboTipoSubsidios');
Route::post('capturarIdEmpleado', 'DatoController@capturarIdEmpleado');
Route::get('obtenerEmpleado', 'DatoController@obtenerEmpleado');
Route::post('exportarPlanilla', 'PlanillageneracionController@exportar');
Route::post('obtenerEditable', 'EditableController@obtener');
Route::post('grabarEditable', 'EditableController@grabar');
Route::get('listarContratos', 'DatoController@listarContratos');
Route::post('grabarDato', 'DatoController@grabar');
Route::get('listarSubsidios', 'DatoController@listarSubsidios');
Route::get('listarHoras', 'DatoController@listarHoras');
Route::post('grabarContrato', 'DatoController@grabarContrato');
Route::post('obtenerContrato', 'DatoController@obtenerContrato');
Route::post('eliminarContrato', 'DatoController@eliminarContrato');
Route::post('grabarSubsidio', 'DatoController@grabarSubsidio');
Route::post('obtenerSubsidio', 'DatoController@obtenerSubsidio');
Route::post('eliminarSubsidio', 'DatoController@eliminarSubsidio');
Route::post('grabarHora', 'DatoController@grabarHora');
Route::post('obtenerHora', 'DatoController@obtenerHora');
Route::post('eliminarHora', 'DatoController@eliminarHora');
Route::get('comboEmpresas', 'EmpresaController@cargarComboEmpresas');
Route::post('capturarIdEmpresa', 'EmpresaController@capturarIdEmpresa');
Route::get('comboSectores', 'EmpresaController@cargarComboSectores');
Route::get('comboDocumentos', 'EmpresaController@cargarComboDocumentos');
Route::get('comboMeses', 'EmpresaController@cargarComboMeses');
Route::get('comboAnios', 'EmpresaController@cargarComboAnios');
Route::get('obtenerEmpresa', 'EmpresaController@obtenerEmpresa');
Route::get('listarPeriodos', 'EmpresaController@listarPeriodos');
Route::get('listarCentroCostos', 'EmpresaController@listarCentroCostos');
Route::post('grabarEmpresa', 'EmpresaController@grabar');
Route::post('grabarPeriodo', 'EmpresaController@grabarPeriodo');
Route::post('eliminarPeriodo', 'EmpresaController@eliminarPeriodo');
Route::post('grabarCentroCosto', 'EmpresaController@grabarCentroCosto');
Route::post('eliminarCentroCosto', 'EmpresaController@eliminarCentroCosto');
Route::post('ingresarEmpresa', 'EmpresaController@ingresarEmpresa');
Route::post('ingresarPeriodo', 'EmpresaController@ingresarPeriodo');
Route::get('obtenerConfiguracion', 'ConfiguracionController@obtenerConfiguracion');
Route::get('listarPorcentajes', 'ConfiguracionController@listarPorcentajes');
Route::post('grabarConfiguracion', 'ConfiguracionController@grabar');
Route::post('grabarPorcentaje', 'ConfiguracionController@grabarPorcentaje');
Route::post('eliminarPorcentaje', 'ConfiguracionController@eliminarPorcentaje');
Route::get('limpiarBD', 'MantenimientoController@limpiarBD');
Route::post('comboPeriodos', 'EmpresaController@cargarComboPeriodos');
Route::post('cargarLogo', ['as' => 'empresa.cargarLogo', 'uses' =>  'EmpresaController@cargarLogo']);
Route::group(['middleware'=>'cors'], function(){
	Route::get('getUsers', 'UserController@getUsers');
	Route::get('getUser/{username}', 'UserController@getUser');
});
//
Route::post('obtenerEmpresaPorNroDoc', 'ServiciosShangelController@obtenerEmpresa');
//chart
Route::get('chart', 'ChartController@prueba');
Route::get('obtenerChart', 'ChartController@obtenerChart');
//cerebro
Route::get('mostrarCerebro', 'CerebroController@mostrar');
Route::post('crearModulo', 'CerebroController@crearModulo');
Route::get('listarModulos', 'CerebroController@listarModulos');
Route::post('eliminarModulo', 'CerebroController@eliminarModulo');
//others
Route::get('modulo', 'moduloController@index');
Route::get('rasen', 'rasenController@index');
Route::get('rasenListar', 'rasenController@listar');
Route::get('rasenCabecera', 'rasenController@cabecera');
Route::get('rasenGraficar', 'rasenController@graficar');

Route::get('rasen', 'rasenController@index');
Route::get('rasenListar', 'rasenController@listar');
Route::get('rasenCabecera', 'rasenController@cabecera');
Route::post('rasenGraficar', 'rasenController@graficar');
Route::get('rasen', 'rasenController@index');
Route::get('rasenListar', 'rasenController@listar');
Route::get('rasenCabecera', 'rasenController@cabecera');
Route::post('rasenGraficar', 'rasenController@graficar');
Route::get('rasen', 'rasenController@index');
Route::get('rasenListar', 'rasenController@listar');
Route::get('rasenCabecera', 'rasenController@cabecera');
Route::post('rasenGraficar', 'rasenController@graficar');
Route::get('rasen', 'rasenController@index');
Route::get('rasenListar', 'rasenController@listar');
Route::get('rasenCabecera', 'rasenController@cabecera');
Route::post('rasenGraficar', 'rasenController@graficar');
Route::get('rasen', 'rasenController@index');
Route::get('rasenListar', 'rasenController@listar');
Route::get('rasenCabecera', 'rasenController@cabecera');
Route::post('rasenGraficar', 'rasenController@graficar');
Route::get('rasen', 'rasenController@index');
Route::get('rasenListar', 'rasenController@listar');
Route::get('rasenCabecera', 'rasenController@cabecera');
Route::post('rasenGraficar', 'rasenController@graficar');
Route::get('rasen', 'rasenController@index');
Route::get('rasenListar', 'rasenController@listar');
Route::get('rasenCabecera', 'rasenController@cabecera');
Route::post('rasenGraficar', 'rasenController@graficar');
Route::get('rasen', 'rasenController@index');
Route::get('rasenListar', 'rasenController@listar');
Route::get('rasenCabecera', 'rasenController@cabecera');
Route::post('rasenGraficar', 'rasenController@graficar');
Route::get('rasen', 'rasenController@index');
Route::get('rasenListar', 'rasenController@listar');
Route::get('rasenCabecera', 'rasenController@cabecera');
Route::post('rasenGraficar', 'rasenController@graficar');
Route::get('rasen', 'rasenController@index');
Route::get('rasenListar', 'rasenController@listar');
Route::get('rasenCabecera', 'rasenController@cabecera');
Route::post('rasenGraficar', 'rasenController@graficar');