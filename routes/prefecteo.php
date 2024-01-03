<?php 

/*
* --------------------------------------------------------------------------
* RUTAS DE PREFECTEO.
* --------------------------------------------------------------------------
*/

//Aulas Ocupadas por Escuelas.
Route::get('aulas/ocupadas','AulasOcupadasController@reporte');
Route::post('aulas/ocupadas/imprimir','AulasOcupadasController@imprimir');