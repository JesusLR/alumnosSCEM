<?php

Route::resource('grupo','Preescolar\PreescolarGrupoController');
Route::get('preescolar/grupo','Preescolar\PreescolarGrupoController@index')->name('preescolar/grupo');
Route::get('api/grupo','Preescolar\PreescolarGrupoController@list')->name('api/grupo');
Route::get('preescolar/calificaciones/primerreporte/{inscrito_id}/{persona_id}/{grado}/{grupo}', 'Preescolar\PreescolarCalificacionesController@reportePrimerTrimestre');
Route::get('preescolar/calificaciones/segundoreporte/{inscrito_id}/{persona_id}/{grado}/{grupo}', 'Preescolar\PreescolarCalificacionesController@reporteSegundoTrimestre');
Route::get('preescolar/calificaciones/tercerreporte/{inscrito_id}/{persona_id}/{grado}/{grupo}', 'Preescolar\PreescolarCalificacionesController@reporteTercerTrimestre');