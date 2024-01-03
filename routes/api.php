<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


//Agregamos nuestra ruta al controller de APIS
Route::resource('getasig', 'Api\AsignaturasController');

Route::resource('postLogin', 'Api\LoginController');

Route::resource('getord', 'Api\OrdinariosController');

Route::resource('getcalifExtra', 'Api\CalifExtrasController');

Route::resource('getcalif', 'Api\CalificacionesController');

Route::resource('getext', 'Api\ExtraordinariosController');

Route::resource('gethorario', 'Api\HorariosController');

Route::resource('getpagos', 'Api\PagosController');

Route::resource('getcves4avisos', 'Api\CveAlumnosController');

Route::resource('getcarrer1t4s', 'Api\ProgramasController');

Route::resource('getalus4tutorias', 'Api\TutoriasAlumnosController');

//URL::forceScheme('https');