<?php

/*
|--------------------------------------------------------------------------
| RUTAS DE REPORTES
|--------------------------------------------------------------------------
|
*/


use App\Http\Middleware\VerificarNull;
//Inscritos y Preinscritos
Route::get('reporte/inscrito_preinscrito', 'Reportes\InscritoPreinscritoController@reporte');
Route::post('reporte/inscrito_preinscrito/imprimir', 'Reportes\InscritoPreinscritoController@imprimir');


//Primer Ingreso
Route::get('reporte/primer_ingreso', 'Reportes\PrimerIngresoController@reporte');
Route::post('reporte/primer_ingreso/imprimir', 'Reportes\PrimerIngresoController@imprimir');


//Listas de Asistencia por Grupo
Route::get('reporte/asistencia_grupo', 'Reportes\AsistenciaGrupoController@reporte');
Route::post('reporte/asistencia_grupo/imprimir', 'Reportes\AsistenciaGrupoController@imprimir');

//Constancia de Inscripción
Route::get('reporte/constancia_inscripcion', 'Reportes\ConstanciaInscripcionController@reporte');
Route::post('reporte/constancia_inscripcion/imprimir', 'Reportes\ConstanciaInscripcionController@imprimir');

//Tarjeta de Pago
Route::get('reporte/tarjeta_pago', 'Reportes\TarjetaPagoController@reporte');
Route::post('reporte/tarjeta_pago/imprimir', 'Reportes\TarjetaPagoController@imprimir');

//Grupos por Materia
Route::get('reporte/grupo_materia', 'Reportes\GrupoMateriaController@reporte');
Route::post('reporte/grupo_materia/imprimir', 'Reportes\GrupoMateriaController@imprimir');

//Actas Pendientes
Route::get('reporte/actas_pendientes', 'Reportes\ActasPendientesController@reporte');
Route::post('reporte/actas_pendientes/imprimir', 'Reportes\ActasPendientesController@imprimir');

//Grupos por Semestre
Route::get('reporte/grupo_semestre', 'Reportes\GrupoSemestreController@reporte');
Route::post('reporte/grupo_semestre/imprimir', 'Reportes\GrupoSemestreController@imprimir');

//Alumnos becados
Route::get('reporte/alumnos_becados', 'Reportes\AlumnosBecadosController@reporte');
Route::post('reporte/alumnos_becados/imprimir', 'Reportes\AlumnosBecadosController@imprimir');


//Relacion de planes de estudio
Route::get('reporte/planes_estudio', 'Reportes\PlanesEstudioController@reporte');
Route::post('reporte/planes_estudio/imprimir', 'Reportes\PlanesEstudioController@imprimir');


//Plantilla de profesores
Route::get('reporte/plantilla_profesores', 'Reportes\PlantillaProfesoresController@reporte');
Route::post('reporte/plantilla_profesores/imprimir', 'Reportes\PlantillaProfesoresController@imprimir');


//Resumen grupos por alumno
Route::get('reporte/resumen_grupos_alumno', 'Reportes\ResumenGruposAlumnoController@reporte');
Route::post('reporte/resumen_grupos_alumno/imprimir', 'Reportes\ResumenGruposAlumnoController@imprimir');
Route::get('api/resumen_grupos_alumno/getGrados/{periodo_id}', 'Reportes\ResumenGruposAlumnoController@getGrados')->name('api/resumen_grupos_alumno/getGrados/{periodo_id}');


//Relación Maestros Escuela
Route::get('reporte/relacion_maestros_escuela', 'Reportes\RelacionMaestrosEscuelaController@reporte');
Route::post('reporte/relacion_maestros_escuela/imprimir', 'Reportes\RelacionMaestrosEscuelaController@imprimir');


//Calendario examenes ordinarios
Route::get('reporte/calendario_examenes_ordinarios', 'Reportes\CalendarioExamenesOrdinariosController@reporte');
Route::post('reporte/calendario_examenes_ordinarios/imprimir', 'Reportes\CalendarioExamenesOrdinariosController@imprimir');


//Relacion de alumnos con matriculas
Route::get('reporte/rel_alumnos_matriculas', 'Reportes\RelAlumnosMatriculasController@reporte');
Route::post('reporte/rel_alumnos_matriculas/imprimir', 'Reportes\RelAlumnosMatriculasController@imprimir');


// listas para evaluacion parcial
Route::get('reporte/listas_evaluacion_parcial', 'Reportes\ListasEvaluacionParcialController@reporte');
Route::post('reporte/listas_evaluacion_parcial/imprimir', 'Reportes\ListasEvaluacionParcialController@imprimir');


// listas para evaluacion ordinaria
Route::get('reporte/listas_evaluacion_ordinaria', 'Reportes\ListasEvaluacionOrdinariaController@reporte');
Route::post('reporte/listas_evaluacion_ordinaria/imprimir', 'Reportes\ListasEvaluacionOrdinariaController@imprimir');


// horario personal de maestros
Route::get('reporte/horario_personal_maestros', 'Reportes\HorarioPersonalMaestrosController@reporte');
Route::post('reporte/horario_personal_maestros/imprimir', 'Reportes\HorarioPersonalMaestrosController@imprimir');


// relacion de grupos
Route::get('reporte/relacion_grupos', 'Reportes\RelacionGruposController@reporte');
Route::post('reporte/relacion_grupos/imprimir', 'Reportes\RelacionGruposController@imprimir');


// carga grupos maestro
Route::get('reporte/carga_grupos_maestro', 'Reportes\CargaGruposMaestroController@reporte');
Route::post('reporte/carga_grupos_maestro/imprimir', 'Reportes\CargaGruposMaestroController@imprimir');



// materias adeudadas por alumnos
Route::get('reporte/materias_adeudadas_alumnos', 'Reportes\MateriasAdeudadasAlumnoController@reporte');
Route::post('reporte/materias_adeudadas_alumnos/imprimir', 'Reportes\MateriasAdeudadasAlumnoController@imprimir');


// tarjetas pago alumnos
Route::get('reporte/tarjetas_pago_alumnos', 'Reportes\TarjetasPagoAlumnosController@reporte');
Route::post('reporte/tarjetas_pago_alumnos/imprimir', 'Reportes\TarjetasPagoAlumnosController@imprimir');



// segey - registro de alumnos
Route::get('reporte/segey/registro_alumnos', 'Reportes\Segey\RegistroAlumnosController@reporte');
Route::post('reporte/segey/registro_alumnos/imprimir', 'Reportes\Segey\RegistroAlumnosController@imprimir');


// becas por campus, carrera, escuela
Route::get('reporte/becas_campus_carrera_escuela', 'Reportes\BecasController@reporte');
Route::post('reporte/becas_campus_carrera_escuela/imprimir', 'Reportes\BecasController@imprimir');

// boleta de calificaciones
Route::get('reporte/boleta_calificaciones', 'Reportes\BoletaCalificacionesController@reporte');
Route::post('reporte/boleta_calificaciones/imprimir', 'Reportes\BoletaCalificacionesController@imprimir');

// materias por plan
Route::get('reporte/materias_plan', 'Reportes\MateriasPlanController@reporte');
Route::post('reporte/materias_plan/imprimir', 'Reportes\MateriasPlanController@imprimir');

// historial academico de alumnos
Route::get('reporte/historial_alumno', 'Reportes\HistorialAlumnoController@reporte');
Route::post('reporte/historial_alumno/imprimir', 'Reportes\HistorialAlumnoController@imprimir');
Route::get('historial_alumno/obtenerProgramasClave/{aluClave}', 'Reportes\HistorialAlumnoController@obtenerProgramasClave');
Route::get('historial_alumno/obtenerProgramasMatricula/{aluMatricula}', 'Reportes\HistorialAlumnoController@obtenerProgramasMatricula');

//Relación de Datos personales.
Route::get('reporte/rel_datos_generales','Reportes\DatosGeneralesController@reporte');
Route::post('reporte/rel_datos_generales/imprimir','Reportes\DatosGeneralesController@imprimir');

//Relación de posibles bajas por reprobación.
Route::get('reporte/rel_pos_bajas','Reportes\PosiblesBajasController@reporte');
Route::post('reporte/rel_pos_bajas/imprimir','Reportes\PosiblesBajasController@imprimir');


//Cumpleaños de empleados
Route::get('reporte/cumple_empleados','Reportes\CumpleEmpleadosController@reporte');
Route::post('reporte/cumple_empleados/imprimir','Reportes\CumpleEmpleadosController@imprimir');

//Alumnos Servicio social
Route::get('reporte/servicio_social', 'Reportes\ServicioSocialController@reporte');
Route::post('reporte/servicio_social/imprimir','Reportes\ServicioSocialController@imprimir');

//Aulas por escuela
Route::get('reporte/aulas_escuela', 'Reportes\AulasEscuelaController@reporte');
Route::post('reporte/aulas_escuela/imprimir', 'Reportes\AulasEscuelaController@imprimir');


//Relación de posibles egresados
Route::get('reporte/rel_pos_egresados','Reportes\PosiblesEgresadosController@reporte');
Route::post('reporte/rel_pos_egresados/imprimir','Reportes\PosiblesEgresadosController@imprimir');

// Aulas ocupadas por escuela
Route::get('reporte/aulas_ocupadas_escuela', 'Reportes\AulasOcupadasEscuelaController@reporte');
Route::post('reporte/aulas_ocupadas_escuela/imprimir', 'Reportes\AulasOcupadasEscuelaController@imprimir');

// Relación de alumnos foráneos
Route::get('reporte/alumnos_foraneos', 'Reportes\AlumnosForaneosController@reporte');
Route::post('reporte/alumnos_foraneos/imprimir', 'Reportes\AlumnosForaneosController@imprimir');

// Relacion de optativas del periodo
Route::get('reporte/optativas_periodo', 'Reportes\OptativasPeriodoController@reporte');
Route::post('reporte/optativas_periodo/imprimir', 'Reportes\OptativasPeriodoController@imprimir');

// Relacion de CGTs
Route::get('reporte/relacion_cgt', 'Reportes\RelacionCgtController@reporte');
Route::post('reporte/relacion_cgt/imprimir', 'Reportes\RelacionCgtController@imprimir');

//Relación de Egresados.
Route::get('reporte/rel_egresados','Reportes\RelEgresadosController@reporte');
Route::post('reporte/rel_egresados/imprimir','Reportes\RelEgresadosController@imprimir');

//Resumen de Egresados.
Route::get('reporte/res_egresados','Reportes\ResEgresadosController@reporte');
Route::post('reporte/res_egresados/imprimir','Reportes\ResEgresadosController@imprimir');

//Porcentaje de aprobación
Route::get('reporte/porcentaje_aprobacion', 'Reportes\PorcentajeAprobacionController@reporte');
Route::post('reporte/porcentaje_aprobacion/imprimir', 'Reportes\PorcentajeAprobacionController@imprimir');

//Resumen de calificación por grupo
//Route::get('reporte/calificacion_grupo', 'Reportes\CalificacionGrupoController@reporte');
//Route::post('reporte/calificacion_grupo/imprimir', 'Reportes\CalificacionGrupoController@imprimir');

//Constancia de buena conducta
Route::get('reporte/buena_conducta', 'Reportes\BuenaConductaController@reporte');
Route::post('reporte/buena_conducta/imprimir', 'Reportes\BuenaConductaController@imprimir');

//Relación de Cambios de Carrera (Programa).
Route::get('reporte/rel_cambios_carrera','Reportes\RelCambiosCarreraController@reporte');
Route::post('reporte/rel_cambios_carrera/imprimir','Reportes\RelCambiosCarreraController@imprimir');

//Programación de examenes extraordinarios
Route::get('reporte/programacion_examenes', 'Reportes\ProgramacionExamenesController@reporte');
Route::post('reporte/programacion_examenes/imprimir', 'Reportes\ProgramacionExamenesController@imprimir');

// Resumen de pagos de colegiaturas (alias el economico)
Route::get('reporte/colegiaturas', 'Reportes\ColegiaturasController@reporte');
Route::post('reporte/colegiaturas/imprimir', 'Reportes\ColegiaturasController@imprimir');

// Resumen de mejores promedios
Route::get('reporte/mejores_promedios', 'Reportes\MejoresPromediosController@reporte');
Route::post('reporte/mejores_promedios/imprimir', 'Reportes\MejoresPromediosController@imprimir');

// Relacion de deudores
Route::get('reporte/relacion_deudores', 'Reportes\RelDeudoresController@reporte');
Route::post('reporte/relacion_deudores/imprimir', 'Reportes\RelDeudoresController@imprimir');

// Relacion de deuda individual de un alumno
Route::get('reporte/relacion_deudas', 'Reportes\RelDeudasController@reporte');
Route::post('reporte/relacion_deudas/imprimir', 'Reportes\RelDeudasController@imprimir');

// acta de examen extraordinario
Route::get('reporte/acta_extraordinario', 'Reportes\ActaExtraordinarioController@reporte');
Route::post('reporte/acta_extraordinario/imprimir', 'Reportes\ActaExtraordinarioController@imprimir');


// Relacion de deudores lagunas
Route::get('reporte/relacion_deudores_lagunas', 'Reportes\RelDeudoresLagunasController@reporte');
Route::post('reporte/relacion_deudores_lagunas/imprimir', 'Reportes\RelDeudoresLagunasController@imprimir');

// Relacion de deudores historico
Route::get('reporte/relacion_deudores_historico', 'Reportes\RelDeudoresHistoricoController@reporte');
Route::post('reporte/relacion_deudores_historico/imprimir', 'Reportes\RelDeudoresHistoricoController@imprimir');

//Constancia de Solicitud de Beca.
Route::get('reporte/solicitud_beca','Reportes\SolicitudBecaController@reporte');
Route::post('reporte/solicitud_beca/imprimir','Reportes\SolicitudBecaController@imprimir');
Route::post('reporte/buscar/{ubicacion_id}','Reportes\SolicitudBecaController@getFirmantes')->name('reporte/buscar/{ubicacion_id}');


//Certificado completo
Route::get('reporte/certificado_completo','Reportes\CertificadoCompletoController@reporte');
Route::post('reporte/certificado_completo/imprimir','Reportes\CertificadoCompletoController@imprimir');

//Constancia de calificaciones finales
Route::get('reporte/calificacion_final','Reportes\CalificacionFinalController@reporte');
Route::post('reporte/calificacion_final/imprimir','Reportes\CalificacionFinalController@imprimir');
Route::post('reporte/calificacion_final/cambiarFirmante/{ubicacion_id}','Reportes\CalificacionFinalController@cambiarFirmante')->name('reporte/calificacion_final/cambiarFirmante/{ubicacion_id}');

//Constancia de calificaciones finales (de toda la carrera)
Route::get('reporte/calificacion_carrera','Reportes\CalificacionCarreraController@reporte');
Route::post('reporte/calificacion_carrera/imprimir','Reportes\CalificacionCarreraController@imprimir');
Route::post('reporte/calificacion_carrera/cambiarFirmante/{ubicacion_id}','Reportes\CalificacionCarreraController@cambiarFirmante')->name('reporte/calificacion_carrera/cambiarFirmante/{ubicacion_id}');

//Constancia de calificaciones parciales
Route::get('reporte/calificacion_parcial','Reportes\CalificacionParcialController@reporte');
Route::post('reporte/calificacion_parcial/imprimir','Reportes\CalificacionParcialController@imprimir');
Route::post('reporte/calificacion_parcial/cambiarFirmante/{ubicacion_id}','Reportes\CalificacionParcialController@cambiarFirmante')->name('reporte/calificacion_parcial/cambiarFirmante/{ubicacion_id}');

// Relacion de deudores pagos recibidos o con montos desconocidos
Route::get('reporte/relacion_deudores_pagos_anuales', 'Reportes\RelDeudoresPagosAnualesController@reporte');
Route::post('reporte/relacion_deudores_pagos_anuales/imprimir', 'Reportes\RelDeudoresPagosAnualesController@imprimir');

//Resumen de Titulados.
Route::get('reporte/resumen_titulados','Reportes\ResumenTituladosController@reporte');
Route::post('reporte/resumen_titulados/imprimir','Reportes\ResumenTituladosController@imprimir');

//Resumen calificacion por grupo
Route::get('reporte/resumen_cal_grupos','Reportes\ResumenCalificacionPorGrupo@reporte');
Route::post('reporte/resumen_cal_grupos/imprimir','Reportes\ResumenCalificacionPorGrupo@imprimir');

//Relación de materias faltantes
Route::get('reporte/indice_reprobacion','Reportes\IndiceReprobacionController@reporte');
Route::post('reporte/indice_reprobacion/imprimir','Reportes\IndiceReprobacionController@imprimir')->middleware(VerificarNull::class);

//Relación de titulados y pasantes
Route::get('reporte/titulados_pasantes','Reportes\RelTituladosPasantesController@reporte');
Route::post('reporte/titulados_pasantes/imprimir','Reportes\RelTituladosPasantesController@imprimir');

//Relación de asistentes (oyentes)
Route::get('reporte/alumnos_asistentes','Reportes\RelAlumnosAsistentesController@reporte');
Route::post('reporte/alumnos_asistentes/imprimir','Reportes\RelAlumnosAsistentesController@imprimir');

//Total de egresados y titulados por año escolar
Route::get('reporte/total_egresados_tit','Reportes\TotalEgresadosTituladosController@reporte');
Route::post('reporte/total_egresados_tit/imprimir','Reportes\TotalEgresadosTituladosController@imprimir');

//Resumen de inscritos por sexo
Route::get('reporte/inscritos_sexo','Reportes\ResumenInscritosSexoController@reporte');
Route::post('reporte/inscritos_sexo/imprimir','Reportes\ResumenInscritosSexoController@imprimir');
// Relación posibles hermanos.
Route::get('reporte/posibles_hermanos', 'Reportes\PosiblesHermanosController@reporte');
Route::post('reporte/posibles_hermanos/imprimir', 'Reportes\PosiblesHermanosController@imprimir');

// Relación cumpleaños de alumnos
Route::get('reporte/rel_cumple_alumnos', 'Reportes\RelCumpleAlumnosController@reporte');
Route::post('reporte/rel_cumple_alumnos/imprimir', 'Reportes\RelCumpleAlumnosController@imprimir');

// Número de exámenes ordinarios y extraordinarios
Route::get('reporte/numero_examenes', 'Reportes\NumeroExamenesController@reporte');
Route::post('reporte/numero_examenes/imprimir', 'Reportes\NumeroExamenesController@imprimir');
//Validación de fechas de examen Ordinario.
Route::get('reporte/validar_fechas_ordinarios','Reportes\ValidarFechasOrdinariosController@reporte');
Route::post('reporte/validar_fechas_ordinarios/imprimir','Reportes\ValidarFechasOrdinariosController@imprimir');

//Validación de fechas de examen Ordinario.
Route::get('reporte/rel_grupos_equivalentes','Reportes\RelGruposEquivalentesController@reporte');
Route::post('reporte/rel_grupos_equivalentes/imprimir','Reportes\RelGruposEquivalentesController@imprimir');

//Resumen de antiguedad de preinscritos
Route::get('reporte/res_antiguedad_preinscritos','Reportes\ResAntiguedadPreinscritosController@reporte');
Route::post('reporte/res_antiguedad_preinscritos/imprimir','Reportes\ResAntiguedadPreinscritosController@imprimir');
Route::get('obtenerDepartamento/{id}','Reportes\ResAntiguedadPreinscritosController@obtenerDepartamento');
Route::get('obtenerPeriodos/{id}','Reportes\ResAntiguedadPreinscritosController@obtenerPeriodos');
Route::get('obtenerFechas/{id}','Reportes\ResAntiguedadPreinscritosController@obtenerFechas');

// Relacion de nuevo ingreso validando exani y pago de inscripcion
Route::get('reporte/relacion_nuevo_ingreso_exani', 'Reportes\RelNvoIngresoExaniController@reporte');
Route::post('reporte/relacion_nuevo_ingreso_exani/imprimir', 'Reportes\RelNvoIngresoExaniController@imprimir');

// Resumen de inscritos
Route::get('reporte/resumen_inscritos', 'Reportes\ResumenInscritosController@reporte');
Route::post('reporte/resumen_inscritos/imprimir', 'Reportes\ResumenInscritosController@imprimir');
Route::get('reporte/resumen_inscritos/exportarExcel', 'Reportes\ResumenInscritosController@exportarExcel');

//Obtener datos via ajax
Route::get('obtenerFirmantes/{ubicacion_id}','Procesos\ObtenerDatosController@obtenerFirmantes');

//Obtener datos via ajax a traves de claves
Route::get('datos/obtenerDepartamento/{ubiClave}','Procesos\ObtenerDatosController@obtenerDepartamento');
Route::get('datos/obtenerEscuelas/{ubiClave}/{depClave}','Procesos\ObtenerDatosController@obtenerEscuelas');
Route::get('datos/obtenerProgramas/{ubiClave}/{depClave}/{escClave}','Procesos\ObtenerDatosController@obtenerProgramas');
Route::get('datos/obtenerPlanes/{ubiClave}/{depClave}/{escClave}/{progClave}','Procesos\ObtenerDatosController@obtenerPlanes');
Route::get('datos/obtenerMaterias/{ubiClave}/{depClave}/{escClave}/{progClave}/{planClave}','Procesos\ObtenerDatosController@obtenerMaterias');
Route::get('datos/obtenerPeriodos/{depClave}','Procesos\ObtenerDatosController@obtenerPeriodos');

Route::get('datos/obtenerFechas/{id}','Procesos\ObtenerDatosController@obtenerFechas');


//horario de clases
Route::get('reporte/horario_por_grupo','Reportes\HorarioPorGrupoController@reporte');
Route::post('reporte/horario_por_grupo/imprimir','Reportes\HorarioPorGrupoController@imprimir');


// Actas de examen Ordinario.
Route::get('reporte/acta_examen_ordinario', 'Reportes\ActaExamenOrdinarioController@reporte');
Route::post('reporte/acta_examen_ordinario/imprimir', 'Reportes\ActaExamenOrdinarioController@imprimir');
//resumen de promedios
Route::get('reporte/resumen_promedios','Reportes\ResumenPromediosController@reporte');
Route::post('reporte/resumen_promedios/imprimir','Reportes\ResumenPromediosController@imprimir');
Route::get('resumen_promedios/obtenerProgramas/{ubiClave}','Reportes\ResumenPromediosController@obtenerProgramas');
Route::get('resumen_promedios/obtenerPlanes/{programa_id}','Reportes\ResumenPromediosController@obtenerPlanes');

//acreditaciones (excel)
Route::get('reporte/acreditaciones','Reportes\AcreditacionesController@reporte');
Route::post('reporte/acreditaciones/exportarExcel','Reportes\AcreditacionesController@exportarExcel');

//resumen de alumnos no inscritos
Route::get('reporte/res_alumnos_no_inscritos','Reportes\ResAlumnosNoInscritosController@reporte');
Route::post('reporte/res_alumnos_no_inscritos/imprimir','Reportes\ResAlumnosNoInscritosController@imprimir');
Route::get('res_alumnos_no_inscritos/obtenerProgramas/{ubiClave}','Reportes\ResAlumnosNoInscritosController@obtenerProgramas');
Route::get('res_alumnos_no_inscritos/obtenerEscuelas/{ubiClave}','Reportes\ResAlumnosNoInscritosController@obtenerEscuelas');

//Obtener datos via ajax a traves de ids
Route::get('datosId/obtenerDepartamento/{ubicacion_id}','Procesos\ObtenerDatosController@obtenerDepartamentoId');
Route::get('datosId/obtenerEscuelas/{departamento_id}','Procesos\ObtenerDatosController@obtenerEscuelasId');
Route::get('datosId/obtenerProgramas/{escuela_id}','Procesos\ObtenerDatosController@obtenerProgramasId');
Route::get('datosId/obtenerPlanes/{programa_id}','Procesos\ObtenerDatosController@obtenerPlanesId');
Route::get('datosId/obtenerMaterias/{plan_id}','Procesos\ObtenerDatosController@obtenerMateriasId');
Route::get('datosId/obtenerPeriodos/{departamento_id}','Procesos\ObtenerDatosController@obtenerPeriodosId');
Route::get('datosId/obtenerCgts/{plan_id}/{periodo_id}','Procesos\ObtenerDatosController@obtenerCgtsId');

//Relación de bajas por periodo.
Route::get('reporte/relacion_bajas_periodo','Reportes\RelacionBajasPeriodoController@reporte');
Route::post('reporte/relacion_bajas_periodo/imprimir', 'Reportes\RelacionBajasPeriodoController@imprimir');

//Relación de alumnos reprobados.
Route::get('reporte/rel_alumnos_reprobados','Reportes\RelAlumnosReprobadosController@reporte');
Route::post('reporte/rel_alumnos_reprobados/imprimir', 'Reportes\RelAlumnosReprobadosController@imprimir');

//Estado de cuenta.
Route::get('reporte/estado_cuenta', 'Reportes\EstadoDeCuentaController@reporte');
Route::post('reporte/estado_cuenta/imprimir','Reportes\EstadoDeCuentaController@imprimir');

//Relación de condicionados.
Route::get('reporte/relacion_condicionados', 'Reportes\RelCondicionadosController@reporte');
Route::post('reporte/relacion_condicionados/imprimir', 'Reportes\RelCondicionadosController@imprimir');

//Relación de pagos capturados por usuario.
Route::get('reporte/rel_pagos_capturados_usuario', 'Reportes\RelPagosCapturadosUsuarioController@reporte');
Route::post('reporte/rel_pagos_capturados_usuario/imprimir', 'Reportes\RelPagosCapturadosUsuarioController@imprimir');

Route::get('reporte/pagos_duplicados', 'Reportes\PagosDuplicadosController@reporte');
Route::post('reporte/pagos_duplicados/imprimir', 'Reportes\PagosDuplicadosController@imprimir');


//Relación de candidatos
Route::get('reporte/relacion_candidatos', 'Reportes\RelacionCandidatosController@reporte');
Route::post('reporte/relacion_candidatos/imprimir', 'Reportes\RelacionCandidatosController@imprimir');
