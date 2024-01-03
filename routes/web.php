<?php

use App\Models\User;
use App\Models\User_docente;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Authentication Routes
Auth::routes();

Route::get('/','AlumnoPagosController@index')->name('home');
// Home Route}
Route::get('/alumno_pagos/{alumno_id}','AlumnoPagosController@index')->name('home');

// Login Route
Route::get('login','LoginController@index')->name('login');
Route::post('auth','LoginController@auth')->name('auth');
Route::get('logout','LoginController@logout')->name('logout');


Route::get('notificar','NotificarController@index')->name('notificar');
Route::post('notificar','NotificarController@enviar')->name('notificar.enviar');


//Modulo Inscribirse a Extraordinarios
Route::resource('inscribirse_extraordinario', 'InscribirseExtraordinarioController')->only(['index','store']);
Route::get('api/inscribirse_extraordinario/{alumno_id}', 'InscribirseExtraordinarioController@list')->name('api/inscribirse_extraordinario/{alumno_id}');

//Módulo Fichas Extraordinarios.
Route::get('fichas_preinscritos_extraordinarios', 'FichaPreinscritoExtraordinarioController@vista');
Route::get('fichas_preinscritos_extraordinarios/list', 'FichaPreinscritoExtraordinarioController@list');
Route::get('fichas_preinscritos_extraordinarios/reimprime/{preinscrito_id}', 'FichaPreinscritoExtraordinarioController@reimprime');


Route::get('libreta_de_pago','LibretaPagoController@index')->name('libretapago');
Route::post('libreta_de_pago','LibretaPagoController@updatePago')->name('libretapago.update');
Route::post('imprimir_libreta', 'Reportes\TarjetasPagoAlumnosSPController@imprimir')->name('libretapago.imprimir');

Route::get('biblioteca','BibliotecaController@index');
Route::get('biblioteca_action','BibliotecaController@action');

Route::get('horario','HorarioController@index')->name('horario');
Route::get('api/horario', 'HorarioController@list')->name('api/horario');

Route::get('asignaturas','AsignaturasController@index')->name('asignaturas');
Route::get('api/asignaturas', 'AsignaturasController@list')->name('api/asignaturas');

Route::get('calificaciones','CalificacionesController@index')->name('calificaciones');
Route::get('api/calificaciones', 'CalificacionesController@list')->name('api/calificaciones');

Route::get('ordinarios','OrdinariosController@index')->name('ordinarios');
Route::get('api/ordinarios', 'OrdinariosController@list')->name('api/ordinarios');

Route::get('extraordinarios','ExtraordinariosController@index')->name('extraordinarios');
Route::get('api/extraordinarios', 'ExtraordinariosController@list')->name('api/extraordinarios');

Route::get('calificaciones_extraordinarios','CalifExtraordinarioController@index')->name('calificaciones_extraordinarios');
Route::get('api/calificaciones_extraordinarios', 'CalifExtraordinarioController@list')->name('api/calificaciones_extraordinarios');

Route::get('encuesta', 'EncuestaController@make');
Route::post('encuesta/verificar_codigo', 'EncuestaController@verificar_codigo');

Route::get('adeudadas','AsignaturasAdeudadasController@index')->name('adeudadas');
Route::get('api/adeudadas', 'AsignaturasAdeudadasController@list')->name('api/adeudadas');

Route::get('constancias','ConstanciaController@index')->name('constancias');
Route::post('constancias/solicitar','ConstanciaController@solicitar')->name('constancias.solicitar');

Route::get('micuenta','MiCuentaController@index')->name('micuenta.index');
Route::post('micuenta/cambiarPassword','MiCuentaController@cambiarPassword')->name('cambiarPassword.store');

Route::get('documentos','DocumentoController@index')->name('documentos.index');
Route::get('documentos/url','DocumentoController@url')->name('documentos.url');

// Route::get('cambiar_contraseña','CuentaController@cambiarPassword')->name('cambiar_contraseña');
// Route::post('cambiar_contraseña','CuentaController@passwordUpdate')->name('password.update');

require (__DIR__ . '/control_escolar.php');

// require (__DIR__ . '/catalogos.php');

// require (__DIR__ . '/reportes.php');

// require (__DIR__ . '/procesos.php');

require (__DIR__ . '/pagos.php');

require (__DIR__ . '/tutorias.php');

require (__DIR__ . '/primaria.php');

require (__DIR__ . '/preescolar.php');

require (__DIR__ . '/secundaria.php');

require (__DIR__ . '/bachiller.php');


// require (__DIR__ . '/archivos.php');

// require (__DIR__ . '/administracion.php');

// require (__DIR__ . '/prefecteo.php');

// require (__DIR__ . '/language.php');

// require (__DIR__ . '/educacion_continua.php');

