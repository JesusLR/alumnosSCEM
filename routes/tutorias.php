<?php

Route::get('tutorias_encuestas/encuestas_disponibles/{AlumnoID}/{CursoID}',
    'Tutorias\TutoriasEncuestasController@encuestas_disponibles')->name('tutorias_encuestas.encuestas');
Route::get('tutorias_encuestas/encuesta/{FormularioID}/{AlumnoID}', 'Tutorias\TutoriasEncuestasController@encuesta')->name('tutorias_encuestas.encuesta');
Route::get('/tutorias_encuestas/encuesta_covid/{FormularioID}/{AlumnoID}', 'Tutorias\TutoriasEncuestasController@encuesta_covid')->name('tutorias_encuestas.Covid');
Route::post('tutorias_encuestas/', 'Tutorias\TutoriasEncuestasController@store')->name('tutorias_encuestas.store');
Route::post('/tutorias_encuestas/covid', 'Tutorias\TutoriasEncuestasController@storeCovid')->name('tutorias_encuestas.storeCovid');
