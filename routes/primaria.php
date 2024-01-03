<?php

Route::get('calificacion_alumno_primaria', 'Primaria\PrimariaCalificacionesGruposAlumnoController@index')->name('Primaria.calificacion_alumno_primaria');
Route::get('calificacion_alumno_primaria/primaria/list', 'Primaria\PrimariaCalificacionesGruposAlumnoController@list');


Route::get('primaria_boleta/{curso_id}', 'Primaria\PrimariaReporteBoletaController@boleta');


Route::get('primaria_faltas_alumno', 'Primaria\PrimariaGruposFaltasController@index')->name('Primaria.Primaria_faltas_alumno');
Route::get('primaria_faltas_alumno/primaria/list', 'Primaria\PrimariaGruposFaltasController@list');
