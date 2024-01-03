<?php

/*
|--------------------------------------------------------------------------
| RUTAS DE CONTROL ESCOLAR
|--------------------------------------------------------------------------
|
*/

// // Empleado Route
// Route::resource('empleado','EmpleadoController');
// Route::get('api/empleado','EmpleadoController@list')->name('api/empleado');
// Route::post('empleado/darBaja/{empleado_id}', 'EmpleadoController@darDeBaja')->name('empleado/darBaja/{empleado_id}');
// Route::get('empleado/verificar_delete/{empleado_id}', 'EmpleadoController@puedeSerEliminado')->name('empleado/verificar_delete/{empleado_id}');
// Route::get('api/empleado/verificar_persona', 'EmpleadoController@verificarExistenciaPersona')->name('api/empleado/verificar_persona');
// Route::post('api/empleado/reactivar_empleado/{empleado_id}','EmpleadoController@reactivarEmpleado')->name('api/empleado/reactivar_empleado/{empleado_id}');
// Route::post('api/empleado/registrar_alumno/{alumno_id}', 'EmpleadoController@alumno_crearEmpleado')->name('api/empleado/registrar_alumno/{alumno_id}');

// // Alumno Route
// Route::resource('alumno','AlumnoController');
// Route::get('alumno/cambiar_matricula/{alumnoId}','AlumnoController@cambiarMatricula')->name("cambiarMatricula");
// Route::post('alumno/cambiar_matricula/edit','AlumnoController@postCambiarMatricula')->name("cambiarMatricula");
// Route::get('api/alumno','AlumnoController@list')->name('api/alumno');
// Route::get('api/alumnos','AlumnoController@getAlumnos');
// Route::get('api/alumnoById/{alumnoId}','AlumnoController@getAlumnoById');
// Route::get('api/getAlumnosByFilter/{nombreAlumno}','AlumnoController@getAlumnosByFilter');
// Route::post('api/getMultipleAlumnosByFilter','AlumnoController@getMultipleAlumnosByFilter');
// Route::get('api/alumno/ultimo_curso/{alumno_id}', 'AlumnoController@ultimoCurso')->name('api/alumno/ultimo_curso/{alumno_id}');
// Route::get('api/alumno/conceptosBaja','AlumnoController@conceptosBaja')->name('api/alumno/conceptosBaja');



// Route::post('api/alumno/cambiarEstatusAlumno','AlumnoController@cambiarEstatusAlumno')->name("api/alumno/cambiarEstatusAlumno");
// Route::get('api/alumno/listHistorialPagosAluclave/{aluClave}','AlumnoController@listHistorialPagosAluclave')->name('api/listHistorialPagosAluclave');
// Route::post('alumno/buena_conducta/{alumnoId}','AlumnoController@buenaConducta')->name("buenaConducta");
// Route::get('api/preparatoriaProcedencia/{municipio_id}','AlumnoController@preparatoriaProcedencia')->name('api/preparatoriaProcedencia');
// Route::get('api/alumno/tutores/buscar_tutor/{tutNombre}/{tutTelefono}', 'AlumnoController@buscarTutor')->name('api/alumno/tutores/buscar_tutor/{tutNombre}/{tutTelefono}');
// Route::post('alumno/tutores/nuevo_tutor','AlumnoController@crearTutor')->name('alumno/tutores/nuevo_tutor');
// Route::get('api/alumno/tutores/{alumno_id}', 'AlumnoController@tutores_alumno')->name('api/alumno/tutores/{alumno_id}');
// Route::get('api/alumno/verificar_persona', 'AlumnoController@verificarExistenciaPersona')->name('api/alumno/verificar_persona');
// Route::post('api/alumno/rehabilitar_alumno/{alumno_id}','AlumnoController@rehabilitarAlumno')->name('api/alumno/rehabilitar_alumno/{alumno_id}');
// Route::post('api/alumno/registrar_empleado/{empleado_id}', 'AlumnoController@empleado_crearAlumno')->name('api/alumno/registrar_empleado/{empleado_id}');
Route::get('alumno_pagos/{alumno_id}', 'AlumnoPagosController@index');
Route::get('api/alumno_pagos/{alumno_id}', 'AlumnoPagosController@list')->name('api/alumno_pagos/{alumno_id}');



// // Cgt Route
// Route::resource('cgt','CgtController');
// Route::get('api/cgt','CgtController@list')->name('api/cgt');
// Route::get('api/cgts/{plan_id}/{periodo_id}','CgtController@getCgts');
// Route::get('api/cgts/{plan_id}/{periodo_id}/{semestre}','CgtController@getCgtsSemestre');

// // Grupo Route
// Route::resource('grupo','GrupoController');
// Route::get('api/grupo','GrupoController@list')->name('api/grupo');

// Route::get('api/grupoEquivalente/{periodo_id}','GrupoController@listEquivalente')->name('api/grupoEquivalente');

// Route::get('api/grupo/{id}','GrupoController@getGrupo');
// Route::get('api/grupos/{curso_id}','GrupoController@getGrupos');

// Route::get('api/grupo/infoEstado/{grupo_id}','GrupoController@infoEstado')->name('api/infoEstado');
// Route::post('grupo/estadoGrupo','GrupoController@estadoGrupo')->name('estadoGrupo');
// Route::get('grupo/horario/{id}','GrupoController@horario')->name('grupo.horario');
// Route::post('grupo/agregarHorario','GrupoController@agregarHorario')->name('grupo/agregarHorario');
// Route::get('grupo/eliminarHorario/{id}/{idGrupo}','GrupoController@eliminarHorario');
// Route::get('api/grupo/horario/{id}','GrupoController@listHorario');
// Route::post('grupo/verificarHorasRepetidas','GrupoController@verificarHorasRepetidas');
// Route::get('api/grupo/horario_admin/{empleado_id}/{periodo_id}','GrupoController@listHorarioAdmin');
// Route::get('grupo/cambiarEstado/{id}/{estado_act}','GrupoController@cambiarEstado');

// Route::get('/grupo/reporte/listas_evaluacion_parcial/{grupo_id}','Reportes\ListasEvaluacionParcialController@imprimir')->name('home');
// Route::get('/grupo/reporte/listas_evaluacion_ordinaria/{grupo_id}', 'Reportes\ListasEvaluacionOrdinariaController@imprimir');



// // Calificación Route
// //Grupos
// Route::resource('calificacion','CalificacionController');
// Route::get('calificacion/agregar/{nivel}/{grupo_id}','CalificacionController@agregar');
// //Extraordinarios
// Route::post('extraordinario/store','CalificacionController@extraStore');
// Route::get('calificacion/agregarextra/{extraordinario_id}','CalificacionController@agregarExtra');
// //Matrículas
// Route::post('matricula/store','CalificacionController@storeMatricula');
// Route::get('calificacion/matricula/{grupo_id}','CalificacionController@agregarMatricula');

// // Paquete Route
// Route::resource('paquete','PaqueteController');
// Route::get('api/paquete','PaqueteController@list')->name('api/paquete');
// Route::get('api/paquetes/{curso_id}','PaqueteController@getPaquetes');
// Route::get('api/paquete/detalle/{paquete_id}','PaqueteController@getPaqueteDetalle');

// // Curso Route
// Route::resource('curso','CursoController');
// Route::get('curso/{curso_id}/constancia_beca/','CursoController@constanciaBeca')->name('constanciaBeca');


// Route::get('curso/{curso_id}/historial_calificaciones_alumno/','CursoController@historialCalificacionesAlumno')->name('historialCalificacionesAlumno');
// Route::get('api/curso/{curso_id}/listHistorialCalifAlumnos/','CursoController@listHistorialCalifAlumnos')->name('listHistorialCalifAlumnos');

// //Materias Faltantes
// Route::get('curso/materiasFaltantes/{curso_id}','CursoController@materiasFaltantes')->name('materiasFaltantes');
// Route::get('api/curso/listMateriasFaltantes/{curso_id}/','CursoController@listMateriasFaltantes')->name('listMateriasFaltantes');

// Route::post('curso/bajaCurso','CursoController@bajaCurso')->name('bajaCurso');
// Route::post('curso/altaCurso','CursoController@altaCurso')->name('altaCurso');
// Route::get('api/curso/conceptosBaja','CursoController@conceptosBaja')->name('api/conceptosBaja');
// Route::get('api/curso/infoBaja/{curso_id}','CursoController@infoBaja')->name('api/infoBaja');

// Route::get('api/curso','CursoController@list')->name('api/curso');
// Route::get('api/curso/{curso_id}','CursoController@listPreinscritoDetalle')->name('api/listPreinscritoDetalle');
// Route::get('api/curso/listHistorialPagos/{curso_id}','CursoController@listHistorialPagos')->name('api/listHistorialPagos');
// Route::get('api/curso/listPosiblesHermanos/{curso_id}','CursoController@listPosiblesHermanos')->name('api/listPosiblesHermanos');





// Route::get('api/cursos/{cgt_id}','CursoController@getCursos');
// Route::get('referencia/{cgt_id}','CursoController@referencia');
// Route::get('crearReferencia/{curso_id}/{tienePagoCeneval}','CursoController@crearReferencia')->name('crearReferencia');
// Route::get('tarjetaPagoAlumno/{curso_id}','Reportes\TarjetaPagoController@tarjetaPagoAlumno')->name('tarjetaPagoAlumno');
// Route::get('api/curso/alumno/{aluClave}/{cuoAnio}','CursoController@getCursoAlumno');

// // Inscrito Route
// Route::resource('inscrito','InscritoController');
// Route::get('create/paquete','InscritoController@paquete')->name('create/paquete');
// Route::post('storePaquete','InscritoController@storePaquete')->name('storePaquete');
// Route::get('create/grupo','InscritoController@grupo')->name('create/grupo');
// Route::post('storeGrupo','InscritoController@storeGrupo')->name('storeGrupo');
// Route::get('create/grupoCompleto','InscritoController@grupoCompleto')->name('create/grupoCompleto');
// Route::post('storeGrupoCompleto','InscritoController@storeGrupoCompleto')->name('storeGrupoCompleto');

// Route::get('desinscribirReprobados','InscritoController@desinscribirReprobados')->name('desinscribirReprobados');
// Route::post('postDesinscribirReprobados','InscritoController@postDesinscribirReprobados')->name('postDesinscribirReprobados');

// Route::get('api/inscrito','InscritoController@list')->name('api/inscrito');


// Route::get('inscrito/cambiar_grupo/{inscritoId}', 'InscritoController@cambiarGrupo')->name('inscrito/cambiar_grupo');
// Route::post('inscrito/postCambiarGrupo', 'InscritoController@postCambiarGrupo')->name('inscrito/postCambiarGrupo');

// // Extraordinario Route
// Route::resource('extraordinario','ExtraordinarioController');
// Route::get('api/extraordinario','ExtraordinarioController@list')->name('api/extraordinario');
// Route::get('api/extraordinario/{extraordinario_id}','ExtraordinarioController@getExtraordinario');
// Route::get('api/solicitud/extraordinario','ExtraordinarioController@list_solicitudes')->name('api/solicitud/extraordinario');

// Route::get('api/extraordinario/getAlumnosByFolioExtraordinario/{folioExt}',
//   'ExtraordinarioController@getAlumnosByFolioExtraordinario')->name('api/extraordinario/getAlumnosByFolioExtraordinario');

// Route::get('api/extraordinario/validarAlumnoPresentaExtra/{folioExt}/{alumno}',
//   'ExtraordinarioController@validarAlumnoPresentaExtra')->name('api/extraordinario/validarAlumnoPresentaExtra');


// Route::get('solicitudes/extraordinario','ExtraordinarioController@solicitudes');
// Route::get('create/solicitud','ExtraordinarioController@solicitudCreate');
// Route::post('store/solicitud','ExtraordinarioController@solicitudStore')->name('store.solicitud');
// Route::get('edit/solicitud/{id}','ExtraordinarioController@solicitudEdit')->name('edit.solicitud');
// Route::put('update/solicitud/{id}','ExtraordinarioController@solicitudUpdate')->name('update.solicitud');
// Route::get('show/solicitud/{id}','ExtraordinarioController@solicitudShow')->name('show.solicitud');
// Route::get('cancelar/solicitud/{id}','ExtraordinarioController@solicitudCancelar')->name('cancelar.solicitud');
// Route::post('extraordinario/actaexamen/{extraordinario_id}','ExtraordinarioController@actaExamen');
// Route::get('api/extraordinario/validarAlumno/{aluClave}','ExtraordinarioController@validarAlumno')->name('api/extraordinario/validarAlumno');

// //Ruta para imprimir acta de examen extraordinario en el datatable
// Route::post('extraordinario/actaexamen/{extraordinario_id}','ExtraordinarioController@actaExamen');


// // Escolaridad
// Route::resource('escolaridad','EscolaridadController');
// Route::get('api/escolaridad','EscolaridadController@list')->name('api/escolaridad');

// // Matricula Anteriores
// Route::resource('matricula_anterior','MatriculaAnteriorController');
// Route::get('api/matricula_anterior','MatriculaAnteriorController@list')->name('api/matricula_anterior');


// // Horarios administrativos
// Route::get('horarios_administrativos','HorariosAdministrativosController@index')->name('horarios_administrativos');
// Route::get('api/horarios_administrativos','HorariosAdministrativosController@list')->name('api/horarios_administrativos');


// Route::get('horarios_administrativos/{claveMaestro}/{periodoId}/calendario','HorariosAdministrativosController@horariosAdministrativos');
// Route::post('horarios_administrativos/agregarHorarios','HorariosAdministrativosController@agregarHorarios');

// Route::get('api/horarios_administrativos/horario/{claveMaestro}/{periodoId}','HorariosAdministrativosController@listHorario');
// Route::get('api/horarios_administrativos/horario_gpo/{claveMaestro}/{periodoId}','HorariosAdministrativosController@listHorarioGpo');

// Route::get('horarios_administrativos/eliminarHorario/{id}','HorariosAdministrativosController@eliminarHorario');




// // // Clave SEGEY
// // Route::resource('clave_profesor','ClaveProfesorController');
// // Route::get('api/clave_profesor','ClaveProfesorController@list')->name('api/clave_profesor');




// // // Historico
// // Route::resource('historico','HistoricoController');
// // Route::get('api/historico','HistoricoController@list')->name('api/historico');




// // //Preinscripción Automática.
// // Route::get('preinscripcion_auto','PreinscripcionAutoController@create');
// // Route::post('preinscripcion_auto/preinscribir','PreinscripcionAutoController@preinscribir');

// // //Modulo del CRUD de Servicio Social
// // Route::resource('serviciosocial','ServicioSocialController');
// // Route::get('api/serviciosocial','ServicioSocialController@list')->name('api/serviciosocial');


// // //Cierre de actas.
// // Route::get('cierre_actas','CierreActasController@filtro');
// // Route::post('cierre_actas/realizar','CierreActasController@cierreActas');


// // //Solicitud de ExtraOrdinarios
// // Route::get('recibo/solicitud/{id}','ExtraordinarioController@solicitudRecibo')->name('recibo.solicitud');

// // //Cierre de actas(extraordinarios).
// // Route::get('cierre_extras','CierreExtrasController@filtro');
// // Route::post('cierre_extras/realizar','CierreExtrasController@cierreExtras');

// // // Registro de Egresados / Titulados.
// // Route::get('registro_egresados','EgresadoController@filtro');
// // Route::post('registro_egresados/procesar','EgresadoController@procesar');
// // Route::post('registro_egresados/buscar/{aluClave}','EgresadoController@getAlumnoByClave')
// // 		->name('registro_egresados/buscar/{aluClave}');

// // // Egresados CRUD.
// // Route::resource('egresados','EgresadoController');
// // Route::get('api/egresados','EgresadoController@list')->name('api/egresados');
// // Route::post('departamento/periodos/{ubiClave}/{depClave}','EgresadoController@obtenerPeriodos')
// // 	->name('departamento/periodos/{ubiClave}/{depClave}');
// // Route::post('egresados/buscar_alumno/{aluClave}','EgresadoController@buscarAlumno')
// // 	->name('egresados/buscar_alumno/{aluClave}');

// // // Tutores CRUD.
// // Route::resource('tutores','TutorController');
// // Route::get('api/tutores','TutorController@list')->name('api/tutores');
// // Route::get('api/tutores/alumnos/{tutor_id}','TutorController@alumnos_tutor')->name('api/tutores/alumnos/{tutor_id}');
// // Route::get('api/tutores/buscarAlumno/{aluClave}','TutorController@buscarAlumno')->name('api/tutores/buscarAlumno/{aluClave}');


// // // Calendario de Exámenes.
// // Route::resource('calendarioexamen', 'CalendarioExamenController');
// // Route::get('api/calendarioexamen', 'CalendarioExamenController@list')->name('api/calendarioexamen');


// // Route::get('tarjetaPagoAlumnoScript','Reportes\TarjetaPagoAlumnosScriptController@tarjetaPagoAlumno')->name('tarjetaPagoAlumnoScript');



// // //Copiar grupo
// // Route::get('copiar_grupo','CopiarGrupoController@index')->name('copiarGrupo');
// // Route::post('copiar_grupo','CopiarGrupoController@copiarGrupoAlumnos')->name('postcopiarGrupo');
// // Route::post('api/list_grupos_copiar','CopiarGrupoController@listGruposCopiar');
// // Route::get('api/list_grupos_copia/{grupoId}','CopiarGrupoController@listGruposCopia');




// // // Candidatos Route
// // Route::resource('candidatos_primer_ingreso','CandidatosPrimerIngresoController');
// // Route::get('api/candidatos_primer_ingreso','CandidatosPrimerIngresoController@list')->name('api/candidatosPrimerIngreso');
// // Route::get('candidatos_primer_ingreso/preregistro/{candidatoId}',
// // 	'CandidatosPrimerIngresoController@preregistro')->name('candidatos_primer_ingreso/preregistro');


// // Route::get('api/preparatoriaProcedenciaCandidatos/{municipio_id}',
// // 'CandidatosPrimerIngresoController@preparatoriaProcedenciaCandidatos')->name('api/preparatoriaProcedenciaCandidatos');


// // Route::get('api/programaByCampus/{ubicacion_id}','CandidatosPrimerIngresoController@getProgramasByCampus');

// // //CRUD Alumnos Restringidos.
// // Route::resource('alumno_restringido', 'AlumnoRestringidoController');
// // Route::get('api/alumno_restringido', 'AlumnoRestringidoController@list')->name('api/alumno_restringido');
// // Route::get('api/alumno_restringido/buscar/{aluClave}', 'AlumnoRestringidoController@getAlumnoByClave')->name('api/alumno_restringido/buscar/{aluClave}');


// //EXANI FILES
// Route::get('exani_images/{filename}', function ($filename)
// {
//     //$path = app_path('upload') . '/' . $filename;

//     $path = env("PROJECT_PATH") . $filename;

//     $file = File::get($path);
//     $type = File::mimeType($path);

//     $response = Response::make($file, 200);
//     $response->header("Content-Type", $type);

//     return $response;
// });

// //Módulo Cambiar contraseña.
// Route::resource('cambiar_contrasena', 'CambiarContrasenaController')
// 	->except(['create', 'store', 'destroy']);
// Route::get('api/cambiar_contrasena', 'CambiarContrasenaController@list')->name('api/cambiar_contrasena');
