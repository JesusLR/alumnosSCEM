<?php

/*
|--------------------------------------------------------------------------
| RUTAS DE EDUCACION CONTINUA
|--------------------------------------------------------------------------
|
*/



// edu continua Route
Route::resource('progEduContinua','EducacionContinua\ProgEduContinuaController');
Route::get('api/progEduContinua','EducacionContinua\ProgEduContinuaController@list')->name('api/tiposProgEduContinua');

Route::resource('tiposProgEduContinua','EducacionContinua\TiposProgEduContinuaController');
Route::get('api/tiposProgEduContinua','EducacionContinua\TiposProgEduContinuaController@list')->name('api/tiposProgEduContinua');


Route::resource('inscritosEduContinua','EducacionContinua\InscritosEduContinuaController');
Route::get('api/inscritosEduContinua','EducacionContinua\InscritosEduContinuaController@list')->name('api/inscritosEduContinua');
Route::get('api/eduContPagosList/{id}', 'EducacionContinua\InscritosEduContinuaController@eduContPagosList')->name("api/eduContPagosList");


Route::get('fichaPagoEduContinua/{inscrito_id}/{concepto}','EducacionContinua\InscritosEduContinuaController@fichaPago')->name('fichaPago');



Route::get('reporte/relacion_educontinua','EducacionContinua\Reportes\RelEduconController@reporte');
Route::post('reporte/relacion_educontinua/imprimir','EducacionContinua\Reportes\RelEduconController@imprimir');


Route::get('reporte/rel_pagos_educontinua','EducacionContinua\Reportes\RelPagosEduconController@reporte');
Route::post('reporte/rel_pagos_educontinua/imprimir','EducacionContinua\Reportes\RelPagosEduconController@imprimir');


Route::get('reporte/rel_aluprog_educontinua','EducacionContinua\Reportes\RelAluProgEduconController@reporte');
Route::post('reporte/rel_aluprog_educontinua/imprimir','EducacionContinua\Reportes\RelAluProgEduconController@imprimir');
