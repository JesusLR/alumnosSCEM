<?php

Route::get('bachiller_solicitudes_recuperativos','Bachiller\BachillerExtraordinarioController@solicitudes');
Route::get('api/solicitud/bachiller_recuperativos','Bachiller\BachillerExtraordinarioController@list_solicitudes')->name('api.solicitud.bachiller_recuperativos');
Route::get('bachiller_solicitud/pagos/ficha_general','Bachiller\BachillerExtraordinarioController@fecha_general_index')->name('bachiller.bachiller_recuperativos.fecha_general_index');

// Horarios
Route::get('bachiller_horario_alumno','Bachiller\BachillerHorarioYucatanController@index')->name('bachiller_horario_alumno');
Route::get('api/bachiller_horario_alumno', 'Bachiller\BachillerHorarioYucatanController@list')->name('api/bachiller_horario_alumno');
Route::get('reporte/bachiller_horario_clases_alumno/imprimir/{aluClave}', 'Bachiller\BachillerHorarioYucatanController@imprimir')->name('bachiller.bachiller_horario_clases_alumno.imprimir');



Route::get('bachiller_calificacion_alumno','Bachiller\BachillerCalificacionesYucatan@index')->name('bachiller_calificacion_alumno');
Route::get('bachiller_calificacion_alumno/list','Bachiller\BachillerCalificacionesYucatan@list');





Route::get('bachiller_puntos_evidencia_materia_complementaria/{periodo_id}/{materia_id}/{materia_acd_id}','Bachiller\BachillerPuntosEvidenciasController@index')->name('bachiller.bachiller_puntos_evidencia_materia_complementaria');
Route::get('bachiller_puntos_evidencia_materia/{periodo_id}/{materia_id}','Bachiller\BachillerPuntosEvidenciasController@index')->name('bachiller.bachiller_puntos_evidencia_materia');

Route::get('bachiller_puntos_evidencia_alumno/list/{materia_id}/{materia_acd_id}','Bachiller\BachillerPuntosEvidenciasController@list')->name('bachiller_puntos_evidencia_alumno.list');

Route::get('bachiller_adeudadas','Bachiller\BachillerAsignaturasAdeudadasController@index')->name('bachiller_adeudadas');
Route::get('api/bachiller_adeudadas', 'Bachiller\BachillerAsignaturasAdeudadasController@list')->name('api/bachiller_adeudadas');

Route::get('bachiller_recuperativos','Bachiller\BachillerRecuperativosController@index');
Route::get('bachiller_recuperativos/{id}','Bachiller\BachillerRecuperativosController@show');
Route::get('api/bachiller_recuperativos','Bachiller\BachillerRecuperativosController@list')->name('api/bachiller_recuperativos');
Route::post('api/bachiller_recuperativos/solicitar/{extraordinario_id}/{periodo_id}/{bachiller_materia_id}','Bachiller\BachillerRecuperativosController@solicitar');
Route::get('api/bachiller_recuperativos/generar/{extraordinario_id}','Bachiller\BachillerRecuperativosController@generarRecuprativoPDF');

// Relacion de extraordinarios
Route::get('bachiller_boleta_final', 'Bachiller\BachillerBoletaFinalController@reporte')->name('bachiller.bachiller_boleta_final.reporte');
Route::get('bachiller_boleta_final/imprimir', 'Bachiller\BachillerBoletaFinalController@imprimir')->name('bachiller.bachiller_boleta_final.imprimir');
Route::get('bachiller_boleta_final/adeudo', 'Bachiller\BachillerBoletaFinalController@adeudo')->name('bachiller.bachiller_boleta_final.adeudo');


// Historial academico
Route::get('bachiller_historial_academico', 'Bachiller\BachillerHistoricoAlumnoController@index')->name('bachiller.bachiller_historial_academico.index');
Route::get('bachiller_historial_academico/list', 'Bachiller\BachillerHistoricoAlumnoController@list');


Route::get('bachiller_reglamento', 'Bachiller\BachillerReglamentoController@index')->name('bachiller.bachiller_reglamento.index');

Route::get('bachiller_curso_images/{filename}/{folder}/{folderCampus}', function ($filename, $folder, $folderCampus)
{
    //$path = app_path('upload') . '/' . $filename;

    $path = storage_path(env("Bachiller_IMAGEN_CURSO_PATH") . $folder ."/".$folderCampus."/".$filename);

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});
