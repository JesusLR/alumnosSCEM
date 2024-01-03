<?php

Route::get('calificacion_alumno', 'Secundaria\SecundariaCalificacionesGruposAlumnoController@index')->name('secundaria.calificacion_alumno');
Route::get('calificacion_alumno/secundaria/list', 'Secundaria\SecundariaCalificacionesGruposAlumnoController@list');


Route::get('secundaria_boleta/{curso_id}', 'Secundaria\SecundariaReporteBoletaController@boleta');


Route::get('secundaria_faltas_alumno', 'Secundaria\SecundariaGruposFaltasController@index')->name('secundaria.secundaria_faltas_alumno');
Route::get('secundaria_faltas_alumno/secundaria/list', 'Secundaria\SecundariaGruposFaltasController@list');
