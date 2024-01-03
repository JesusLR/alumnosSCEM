<!DOCTYPE html>
<html>
	<head>
		<title>Boleta de Calificaciones</title>
		<!-- <link rel="stylesheet" href="sass/main.css" media="screen" charset="utf-8"/> -->
		<meta content="width=device-width, initial-scale=1.0" name="viewport">
		<meta http-equiv="content-type" content="text-html; charset=utf-8">
		<style type="text/css">
      /*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */
      /* Document
        ========================================================================== */
      /**
      * 1. Correct the line height in all browsers.
      * 2. Prevent adjustments of font size after orientation changes in iOS.
      */
      html {
        line-height: 1.6; /* 1 */
        -webkit-text-size-adjust: 100%; /* 2 */
      }
      /* Sections
        ========================================================================== */
      /**
      * Remove the margin in all browsers.
      */
      body {
        margin: 0;
      }
      /**
      * Render the `main` element consistently in IE.
      */
      main {
        display: block;
      }
      /**
      * Correct the font size and margin on `h1` elements within `section` and
      * `article` contexts in Chrome, Firefox, and Safari.
      */
      h1 {
        font-size: 2em;
        margin: 0.67em 0;
      }
      /* Grouping content
        ========================================================================== */
      /**
      * 1. Add the correct box sizing in Firefox.
      * 2. Show the overflow in Edge and IE.
      */
      hr {
        box-sizing: content-box; /* 1 */
        height: 0; /* 1 */
        overflow: visible; /* 2 */
      }
      /**
      * 1. Correct the inheritance and scaling of font size in all browsers.
      * 2. Correct the odd `em` font sizing in all browsers.
      */
      pre {
        font-family: monospace, monospace; /* 1 */
        font-size: 1em; /* 2 */
      }
      /* Text-level semantics
        ========================================================================== */
      /**
      * Remove the gray background on active links in IE 10.
      */
      a {
        background-color: transparent;
      }
      /**
      * 1. Remove the bottom border in Chrome 57-
      * 2. Add the correct text decoration in Chrome, Edge, IE, Opera, and Safari.
      */
      abbr[title] {
        border-bottom: none; /* 1 */
        text-decoration: underline; /* 2 */
        text-decoration: underline dotted; /* 2 */
      }
      /**
      * Add the correct font weight in Chrome, Edge, and Safari.
      */
      b,
      strong {
        font-weight: bolder;
      }
      /**
      * 1. Correct the inheritance and scaling of font size in all browsers.
      * 2. Correct the odd `em` font sizing in all browsers.
      */
      code,
      kbd,
      samp {
        font-family: monospace, monospace; /* 1 */
        font-size: 1em; /* 2 */
      }
      /**
      * Add the correct font size in all browsers.
      */
      small {
        font-size: 80%;
      }
      /**
      * Prevent `sub` and `sup` elements from affecting the line height in
      * all browsers.
      */
      sub,
      sup {
        font-size: 75%;
        line-height: 0;
        position: relative;
        vertical-align: baseline;
      }
      sub {
        bottom: -0.25em;
      }
      sup {
        top: -0.5em;
      }
      /* Embedded content
        ========================================================================== */
      /**
      * Remove the border on images inside links in IE 10.
      */
      img {
        border-style: none;
      }
      /* Forms
        ========================================================================== */
      /**
      * 1. Change the font styles in all browsers.
      * 2. Remove the margin in Firefox and Safari.
      */
      button,
      input,
      optgroup,
      select,
      textarea {
        font-family: inherit; /* 1 */
        font-size: 100%; /* 1 */
        line-height: 1.15; /* 1 */
        margin: 0; /* 2 */
      }
      /**
      * Show the overflow in IE.
      * 1. Show the overflow in Edge.
      */
      button,
      input { /* 1 */
        overflow: visible;
      }
      /**
      * Remove the inheritance of text transform in Edge, Firefox, and IE.
      * 1. Remove the inheritance of text transform in Firefox.
      */
      button,
      select { /* 1 */
        text-transform: none;
      }
      /**
      * Correct the inability to style clickable types in iOS and Safari.
      */
      button,
      [type="button"],
      [type="reset"],
      [type="submit"] {
        -webkit-appearance: button;
      }
      /**
      * Remove the inner border and padding in Firefox.
      */
      button::-moz-focus-inner,
      [type="button"]::-moz-focus-inner,
      [type="reset"]::-moz-focus-inner,
      [type="submit"]::-moz-focus-inner {
        border-style: none;
        padding: 0;
      }
      /**
      * Restore the focus styles unset by the previous rule.
      */
      button:-moz-focusring,
      [type="button"]:-moz-focusring,
      [type="reset"]:-moz-focusring,
      [type="submit"]:-moz-focusring {
        outline: 1px dotted ButtonText;
      }
      /**
      * Correct the padding in Firefox.
      */
      fieldset {
        padding: 0.35em 0.75em 0.625em;
      }
      /**
      * 1. Correct the text wrapping in Edge and IE.
      * 2. Correct the color inheritance from `fieldset` elements in IE.
      * 3. Remove the padding so developers are not caught out when they zero out
      *    `fieldset` elements in all browsers.
      */
      legend {
        box-sizing: border-box; /* 1 */
        color: inherit; /* 2 */
        display: table; /* 1 */
        max-width: 100%; /* 1 */
        padding: 0; /* 3 */
        white-space: normal; /* 1 */
      }
      /**
      * Add the correct vertical alignment in Chrome, Firefox, and Opera.
      */
      progress {
        vertical-align: baseline;
      }
      /**
      * Remove the default vertical scrollbar in IE 10+.
      */
      textarea {
        overflow: auto;
      }
      /**
      * 1. Add the correct box sizing in IE 10.
      * 2. Remove the padding in IE 10.
      */
      [type="checkbox"],
      [type="radio"] {
        box-sizing: border-box; /* 1 */
        padding: 0; /* 2 */
      }
      /**
      * Correct the cursor style of increment and decrement buttons in Chrome.
      */
      [type="number"]::-webkit-inner-spin-button,
      [type="number"]::-webkit-outer-spin-button {
        height: auto;
      }
      /**
      * 1. Correct the odd appearance in Chrome and Safari.
      * 2. Correct the outline style in Safari.
      */
      [type="search"] {
        -webkit-appearance: textfield; /* 1 */
        outline-offset: -2px; /* 2 */
      }
      /**
      * Remove the inner padding in Chrome and Safari on macOS.
      */
      [type="search"]::-webkit-search-decoration {
        -webkit-appearance: none;
      }
      /**
      * 1. Correct the inability to style clickable types in iOS and Safari.
      * 2. Change font properties to `inherit` in Safari.
      */
      ::-webkit-file-upload-button {
        -webkit-appearance: button; /* 1 */
        font: inherit; /* 2 */
      }
      /* Interactive
        ========================================================================== */
      /*
      * Add the correct display in Edge, IE 10+, and Firefox.
      */
      details {
        display: block;
      }
      /*
      * Add the correct display in all browsers.
      */
      summary {
        display: list-item;
      }
      /* Misc
        ========================================================================== */
      /**
      * Add the correct display in IE 10+.
      */
      template {
        display: none;
      }
      /**
      * Add the correct display in IE 10.
      */
      [hidden] {
        display: none;
      }
      body{
        font-family: 'times sans-serif';
        font-size: 10px;
        margin-top: 40px;  /* ALTURA HEADER */
        margin-left: 5px;
        margin-right: 5px;
      }
      .row {
        width:100%;
        display: block;
        position: relative;
        margin-left: -30px;
        margin-right: -30px;
      }
      .row::after {
          content: "";
        clear: both;
        display: table;
      }
      .column,
      .columns {
        width: 100%;
        float: left;
        box-sizing: border-box!important;
      }
      .medium-1 {
        width: 8.33333333333%;
      }
      .medium-4 {
        width: 16.6666666667%;
      }
      .medium-3 {
        width: 25%;
      }
      .medium-4 {
        width: 33.3333333333%;
      }
      .medium-5 {
        width: 41.6666666667%;
      }
      .medium-6 {
        width: 50%;
      }
      .medium-7 {
        width: 58.3333333333%;
      }
      .medium-8 {
        width: 66.6666666667%;
      }
      .medium-9 {
        width: 75%;
      }
      .medium-10 {
        width: 83.3333333333%;
      }
      .medium-11 {
        width: 91.6666666667%;
      }
      .medium-12 {
        width: 100%;
      }
      .clearfix::after {
        content: "";
        clear: both;
        display: table;
      }
      span{
        font-weight: bold;
      }
      p{
        margin: 0;
      }
      .left {
        float: left;
      }
      .float-right {
        float: right;
      }
      .logo {
        width: 100%;
      }
      .box-solicitud {
        border: 1px solid #000;
        padding: 5px;
        border-radius: 2px;
      }

      .estilos-tabla {
        width: 100%;
      }
      .estilos-tabla tr th{
        font-size: 12px;
        background-color: #000;
        color: #fff;
        height: 30px;
        padding-left:5px;
        padding-right:5px;
        box-sizing: border-box;
        text-align: center;
      }
      .estilos-tabla tr td{
        font-size: 12px;
        padding-left:2px;
        padding-right:2px;
        box-sizing: border-box;
        color: #000;
      }
      .page_break { page-break-before: always; }
      /** Define the footer rules **/
      footer {
        position: fixed;
        bottom: 0px;
        left: 0cm;
        right: 0cm;
        /** Extra personal styles **/
        color: #000;
        text-align: center;
      }
      header {
        position: fixed;
        top: -50px;
        right: 0px;
        height: 3px;
        /** Extra personal styles **/

        margin-left: 5px;
        margin-right: 5px;
      }

      #watermark { position: fixed; top: 15%; left: 0;  width: 700px; height: 700px; opacity: .3; }
      .img-header{
        height: 80px;
        float: left;
      }

      .img-foto{
        height: 80px;
        float: right;
        margin-top: -100px;
      
        padding:2px;
        background-color: #f5f5f5;
        border: 1px solid #999999;


      }
      .inicio-pagina{
        margin-top: 0;
        display: block;
      }
      @page {
        margin-top: 80px;
        margin-bottom: 40px;
      }

      .listas-info {
        margin-top: 0px;
        margin-bottom: 0px;
      }
      .listas-info li {
        display: inline;
        list-style-type: none;
        margin-left: 40px;

      }
      .listas-info li:first-child {
        margin-left: 0px;
      }

      .listas-asistencia {
        margin-top: 0px;
        margin-bottom: 0px;
        margin-left: 0px!important;
        padding-left: 0!important;
      }
      .listas-asistencia li {
        display: inline;
        list-style-type: none;
      }

      .table {
        width: 100%;
      }

      .table {
        border-collapse: collapse;
      }

      

      .table td, .table  th {
        padding-top: 0px;
        padding-bottom: 0px;
        padding-right: 5px;
        border: 1px solid #000;
      }

      .page-number:before {
        content: "Pág " counter(page);
      }

      .page-break {
          page-break-after: always;
      }

    </style>
	</head>
  <body>

    @php
        $pos0 = 1;
    @endphp
  <header>
      <div class="row" style="margin-top: 0px;">
          <div class="columns medium-12">

            <img class="img-header"  src="{{base_path('resources/assets/img/logo.jpg')}}" alt="">
              @if ($secundaria_porcentajes->departamento_id == "15")
              <h4 style="margin-top:0px; margin-bottom: 0px; text-align: center;">SECUNDARIA ESCUELA MODELO</h4>
              @endif
              @if ($secundaria_porcentajes->departamento_id == "19")
              <h4 style="margin-top:0px; margin-bottom: 0px; text-align: center;">SECUNDARIA ESCUELA MODELO VALLADOLID</h4>
              @endif
              <h4 style="margin-top:0px; margin-bottom: 0px; text-align: center;">
                @if ($secundaria_porcentajes->departamento_id == "15")
                31PES0012T 
                @endif

                @if ($secundaria_porcentajes->departamento_id == "19")
                31PES0143L 
                @endif
                
              </h4>
              <h4 style="margin-top:0px; margin-bottom: 0px; text-align: center;">BOLETA DE CALIFICACIONES</h4>
              <h4 style="margin-top:0px; margin-bottom: 0px; text-align: center;">CURSO ESCOLAR: {{$cicloEscolar}}</h4>
              @foreach ($calificaciones as $inscrito)
                @if ($pos0++ == 1)
                  <h4 style="margin-top:0px; margin-bottom: 0px; text-align: center;">Grado: {{$inscrito->gpoGrado}} Grupo:{{$inscrito->gpoClave}}</h4>
                @endif
              @endforeach

          </div>
      </div>
  </header>

  @php
  $pos0 = 1;
  $key = 0;
  $keyMatFA = 0.0;
  $keyMatDESA = 0.0;
  $keyMatPROY = 0.0;
  $keyMatOPTA = 0.0;
  $keyPromedioGeneral = 0;
  $acd = 0;
  $Keynasistencias = 0;

  #Varibles indispensables para la categoria formación academica
  $keyPromedioGeneralFormacionAcademica = 0;
  $promedioGenFormacionAcadeSep = 0.0;
  $promedioGenFormacionAcadeOct = 0.0;
  $promedioGenFormacionAcadeNov = 0.0;
  $promedioGenFormacionAcadePeriodo1 = 0.0;
  $promedioGenFormacionAcadeEne = 0.0;
  $promedioGenFormacionAcadeFeb = 0.0;
  $promedioGenFormacionAcadeMar = 0.0;
  $promedioGenFormacionAcadePeriodo2 = 0.0;
  $promedioGenFormacionAcadeAbr = 0.0;
  $promedioGenFormacionAcadeMay = 0.0;
  $promedioGenFormacionAcadeJun = 0.0;
  $promedioGenFormacionAcadePeriodo3 = 0.0;



  
  //hay que declarar mas variables, una por columna diferente y categoria
  //iniciarlas en 0.0 
  $promSEPFA = 0.0;
  $promOCTFA = 0.0;
  $promNOVFA = 0.0;
  $promedioGen1FA = 0.0;
  $promedioGen1SEPFA = 0.0;
  $promDicEneFA = 0.0;
  $promFEBFA = 0.0;
  $promMARFA = 0.0;
  $promedioGen2FA = 0.0;
  $promedioGen2SEPFA = 0.0;
  $promABRFA = 0.0;
  $promMAYFA = 0.0;
  $promJUNFA = 0.0;
  $promedioGen3FA = 0.0;
  $promedioGen3SEPFA = 0.0;
  $promedioFinalFA = 0.0;
  $promedioFinalSEPFA = 0.0;
  
  $promSEPDESA = 0.0;
  $promOCTDESA = 0.0;
  $promNOVDESA = 0.0;
  $PromedioDesaPerido1 = 0.0;
  $PromedioGen1SEPDESA = 0.0;
  $promDICENEDESA = 0.0;
  $promFEBDESA = 0.0;
  $promMARDESA = 0.0;
  $PromedioDesaPerido2 = 0.0;
  $PromedioGen2SEPDESA = 0.0;
  $promABRDESA = 0.0;
  $promMAYDESA = 0.0;
  $promJUNDESA = 0.0;
  $PromedioDesaPerido3 = 0.0;
  $PromedioGen3SEPDESA = 0.0;
  $promedioFinalDESA = 0.0;
  $promedioFinalSEPDESA = 0.0;

  $sepArtis = 0.0;
  $octArtis = 0.0;
  $novArtis = 0.0;
  $genArtis1 = 0.0;
  $diceneArtis = 0.0;
  $febArtis = 0.0;
  $marArtis = 0.0;
  $genArtis2 = 0.0;
  $abrArtis = 0.0;
  $mayArtis = 0.0;
  $junArtis = 0.0;
  $genArtis3 = 0.0;
  $genFinalArtis = 0.0;


  $posicion1 = 1;
  $posicion2 = 1;
  $posicion9 = 1;
  $posicion10 = 1;
  $posicion3 = 1;
  $posicionFA = 0;
  $posicion3Fisi = 0;
  $posicion3ArtTut = 0;
  $posicionTec = 0;

  $keyMatOptativas = 0.0;
  $promSepOpta = 0.0;
  $promOctOpta = 0.0;
  $promNovOpta = 0.0;
  $PromedioOptaPerido1 = 0.0;
  $promDicEneOpta = 0.0;
  $promFebOpta = 0.0;
  $promMarOpta = 0.0;
  $PromedioOptaPerido2 = 0.0;
  $promAbrOpta = 0.0;
  $promMayOpta = 0.0;
  $promJunOpta = 0.0;
  $PromedioOptaPerido3 = 0.0;
  $promedioFinalOpta = 0.0;


  #parametros de promedio general 
  $promedioGeneralPer1FA = 0;
  $promedioGenralPer1ArTu = 0;
  $promedioGeneralFinalPer1 = 0;
  $totalEnDividir = 0;
  $resultadoPeriodo1 = 0;

  $promedioGeneralPer2FA = 0;
  $promedioGenralPer2ArTu = 0;
  $promedioGeneralFinalPer2 = 0;
  $resultadoPeriodo2 = 0;

  $promedioGeneralPer3FA = 0;
  $promedioGenralPer3ArTu = 0;
  $promedioGeneralFinalPer3 = 0;
  $resultadoPeriodo3 = 0;


  $promedioGeneralTrimestreFA = 0.0;
  $promedioGenralTrimestreArTu = 0.0;
  $promedioGeneralFinalTrimestre = 0.0;
  $resultadoTrimestreFin = 0.0;


  $faltasSep = 0;
  $faltasOct = 0;
  $faltasNov = 0;
  $faltasEne = 0;
  $faltasFeb = 0;
  $faltasMar = 0;
  $faltasAbr = 0;
  $faltasMay = 0;
  $faltasJun = 0;

@endphp

@foreach ($alumnoAgrupado as $clave_pago => $valores)
    @foreach ($calificaciones as $inscrito)
        @if ($inscrito->clave_pago == $clave_pago)


        {{--  llave del 1 hasta donde llege y se sepite el ciclo  --}}
        @php
            $key++;            
        @endphp
            @if ($key == 1)

            {{--  Cargar la foto del alumno   --}}
            @if ($inscrito->cursecundariaFoto != "")
            <img class="img-foto" src="{{base_path('storage/app/public/secundaria/cursos/fotos/' . $inscrito->perAnioPago . '/' . $inscrito->cursecundariaFoto) }}" alt="">
    
            @else
            <img class="img-foto"  src="" alt="">    
            @endif
            {{--  fin foto   --}}
            <div class="row">
              <div class="columns medium-4">
                  <div style="text-align: left;">
                        <p><b> Clave: {{$clave_pago}}</b></p>
                        <p><b> Alumno: {{$inscrito->ape_paterno}} {{$inscrito->ape_materno}} {{$inscrito->nombres}}</b></p>
                  </div>
              </div>
              {{-- <div class="columns medium-4">
                  <div style="text-align: center;">
                      <p >Grupo:<b> {{$inscrito->gpoGrado}}{{$inscrito->gpoClave}}</b></p>
                      <p >Curp:<b> {{$inscrito->curp}}</b></p>
                  </div>
              </div> --}}
              <div class="columns medium-3"></div>
              <div class="columns medium-3"></div>

              <div class="columns medium-4">
                  <div style="">
                      <p ><b>Fecha: {{$fechaActual}}</b></p>
                      {{-- <p >Hora: {{ $horaActual}}</p> --}}
                      <p><b>Curp: {{$inscrito->curp}}</b></p>
                  </div>
              </div>
            </div>

               
            <br>
        <div class="row">
          <div class="columns medium-12">
              <table class="table table-bordered">
                  <thead>
                      <tr>
                        <th align="center" style="width: 227px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></th>
                        <th align="center">Máx {{$secundaria_porcentajes->porc_septiembre/10}}</th>
                        <th align="center">Máx {{$secundaria_porcentajes->porc_octubre/10}}</th>
                        <th align="center">Máx {{$secundaria_porcentajes->porc_noviembre/10}}</th>
                        <th align="center" style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></th>
                        <th align="center">Máx {{$secundaria_porcentajes->porc_enero/10}}</th>
                        <th align="center">Máx {{$secundaria_porcentajes->porc_febrero/10}}</th>
                        <th align="center">Máx {{$secundaria_porcentajes->porc_marzo/10}}</th>
                        <th align="center" style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></th>
                        <th align="center">Máx {{$secundaria_porcentajes->porc_abril/10}}</th>
                        <th align="center">Máx {{$secundaria_porcentajes->porc_mayo/10}}</th>
                        <th align="center">Máx {{$secundaria_porcentajes->porc_junio/10}}</th>
                        <th align="center" style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></th>

                      </tr>
                      <tr>
                          <th align="center" style="width: 227px; border-top: 1px solid; border-right: 0px; border-bottom: 0px; border-left: 1px solid;">Asignaturas</th>
                          <th align="center">Sep</th>
                          <th align="center">Oct</th>
                          <th align="center">Nov</th>
                          <th align="center">Per1</th>
                          <th align="center">Ene</th>
                          <th align="center">Feb</th>
                          <th align="center">Mar</th>
                          <th align="center">Per2</th>
                          <th align="center">Abr</th>
                          <th align="center">May</th>
                          <th align="center">Jun</th>
                          <th align="center">Per3</th>
                          <th align="center">Prom</th>
                      </tr>

                      <tr>
                        <th style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                      </tr>
                      
                  </thead>
                  <tbody>
                    @foreach($calificaciones as $key => $item)
                      @if ($item->clave_pago == $clave_pago)
                        @if ($item->matNombreEspecialidad == "FORMACIÓN ACADÉMICA")
                        @if ($posicion1++ == 1)
                        <tr>
                          <td style="width: 227px; border-top: 1px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><b>FORMACIÓN ACADÉMICA</b></td>
                        </tr>
                        @endif
                        @php
                            $inscTrimestre1 = 0.0;
                            $inscTrimestre2 = 0.0;
                            $inscTrimestre3 = 0.0;

                        @endphp
                        @if ($item->inscTrimestre1 == null)
                          $inscTrimestre1 = 0.0;
                        @else
                          $inscTrimestre1 = $item->inscTrimestre1;
                        @endif

                        @if ($item->inscTrimestre2 == null)
                          $inscTrimestre2 = 0.0;
                        @else
                          $inscTrimestre2 = $item->inscTrimestre2;
                        @endif

                        @if ($item->inscTrimestre3 == null)
                          $inscTrimestre3 = 0.0;
                        @else
                          $inscTrimestre3 = $item->inscTrimestre3;
                        @endif
                        @php 

                            $promedioGenFormacionAcadePeriodo1 = $promedioGeneralPer1FA + $inscTrimestre1;
                            $promedioGenFormacionAcadePeriodo2 = $promedioGeneralPer2FA + $inscTrimestre2;
                            $promedioGenFormacionAcadePeriodo3 = $promedioGeneralPer3FA + $inscTrimestre3;
                            $promedioGeneralTrimestreFA = $promedioGeneralTrimestreFA + $item->Telnet_inscPromedioTrimCALCULADO;

                            # sacar promedios
                            $posicionFA++;
                            $promedioGenFormacionAcadeSep = $promedioGenFormacionAcadeSep + $item->Telnet_inscCalificacionPorcentajeSep;
                            $promedioGenFormacionAcadeOct = $promedioGenFormacionAcadeOct + $item->Telnet_inscCalificacionPorcentajeOct;
                            $promedioGenFormacionAcadeNov = $promedioGenFormacionAcadeNov + $item->Telnet_inscCalificacionPorcentajeNov;
                            $promedioGenFormacionAcadeEne = $promedioGenFormacionAcadeEne + $item->Telnet_inscCalificacionPorcentajeEne;
                            $promedioGenFormacionAcadeFeb = $promedioGenFormacionAcadeFeb + $item->Telnet_inscCalificacionPorcentajeFeb;
                            $promedioGenFormacionAcadeMar = $promedioGenFormacionAcadeMar + $item->Telnet_inscCalificacionPorcentajeMar;
                            $promedioGenFormacionAcadeAbr = $promedioGenFormacionAcadeAbr + $item->Telnet_inscCalificacionPorcentajeAbr;
                            $promedioGenFormacionAcadeMay = $promedioGenFormacionAcadeMay + $item->Telnet_inscCalificacionPorcentajeMay;
                            $promedioGenFormacionAcadeJun = $promedioGenFormacionAcadeJun + $item->Telnet_inscCalificacionPorcentajeJun;

                            #Sacando resultado del promedio
                            $PromedioSepForAcademi = $promedioGenFormacionAcadeSep/$posicionFA;
                            $PromedioOctForAcademi = $promedioGenFormacionAcadeOct/$posicionFA;
                            $PromedioNovForAcademi = $promedioGenFormacionAcadeNov/$posicionFA;
                            $PromForAcademiPeriodo1 = $promedioGenFormacionAcadePeriodo1/$posicionFA;
                            $PromedioEneForAcademi = $promedioGenFormacionAcadeEne/$posicionFA;
                            $PromedioFebForAcademi = $promedioGenFormacionAcadeFeb/$posicionFA;
                            $PromedioMarForAcademi = $promedioGenFormacionAcadeMar/$posicionFA;
                            $PromForAcademiPeriodo2 = $promedioGenFormacionAcadePeriodo2/$posicionFA;
                            $PromedioAbrForAcademi = $promedioGenFormacionAcadeAbr/$posicionFA;
                            $PromedioMayForAcademi = $promedioGenFormacionAcadeMay/$posicionFA;
                            $PromedioJunForAcademi = $promedioGenFormacionAcadeJun/$posicionFA;
                            $PromForAcademiPeriodo3 = $promedioGenFormacionAcadePeriodo3/$posicionFA;
                            $PromForAcademiGeneral = $promedioGeneralTrimestreFA/$posicionFA;


                        @endphp
                        <tr>
                  
                          <td style="width: 200px;">{{$item->matNombreOficial}}</td>

                          <td align="center">
                            {{$item->Telnet_inscCalificacionPorcentajeSep}}
                          </td>

                          <td align="center">
                            {{$item->Telnet_inscCalificacionPorcentajeOct}}
                          </td>

                          <td align="center">
                            {{$item->Telnet_inscCalificacionPorcentajeNov}}
                          </td>

                          <td align="center">
                            <b>{{$item->inscTrimestre1}}</b>
                          </td>


                          <td align="center">
                            {{$item->Telnet_inscCalificacionPorcentajeEne}}
                          </td>

                          <td align="center">
                            {{$item->Telnet_inscCalificacionPorcentajeFeb}}
                          </td>

                          <td align="center">
                            {{$item->Telnet_inscCalificacionPorcentajeMar}}
                          </td>

                          <td align="center">
                            <b>{{$item->inscTrimestre2}}</b>
                          </td>


                          <td align="center">{{$item->Telnet_inscCalificacionPorcentajeAbr}}</td>
                          <td align="center">{{$item->Telnet_inscCalificacionPorcentajeMay}}</td>
                          <td align="center">{{$item->Telnet_inscCalificacionPorcentajeJun}}</td>

                      
                          <td align="center">
                            <b>{{$item->inscTrimestre3}}</b>
                          </td>


                          {{--  promedio final   --}}
                          <td align="center">
                            <b>{{$item->Telnet_inscPromedioTrimCALCULADO}}</b>                            
                          </td>

                          
                        </tr>
                        @endif                           
                      @endif                          
                    @endforeach
                    
                
                       
              </tbody>
              </table>
              <table class="table table-bordered">
                <thead>                
                </thead>
                <tbody>
                  @foreach($calificaciones as $key => $item)
                    @if ($item->clave_pago == $clave_pago)
                     @php
                         $keyPromedioGeneralFormacionAcademica++;
                     @endphp
                     @if ($keyPromedioGeneralFormacionAcademica == 1)
                      <tr>                      
                        <td style="width: 226px; border-top: 0px solid; border-right: 1px solid; border-bottom: 1px solid; border-left: 1px solid;"><b>PROM. FORMACIÓN ACADÉMICA</b></td>                 
                        

                        <td align="center" style="width: 53px; border-top: 0px solid; border-right: 1px solid; border-bottom: 1px solid; border-left: 1px solid;">
                          <b>{{number_format((float)$PromedioSepForAcademi, 1, '.', '')}}</b>
                        </td>                  

                        
                        <td align="center" style="width: 53px; border-top: 0px solid; border-right: 1px solid; border-bottom: 1px solid; border-left: 1px solid;">                          
                          @if ($item->Telnet_inscCalificacionPorcentajeOct != "")
                          <b>{{number_format((float)$PromedioOctForAcademi, 1, '.', '')}}</b>  
                          @else
                          @endif
                        </td>                        
                  
                        <td align="center" style="width: 52px; border-top: 0px solid; border-right: 1px solid; border-bottom: 1px solid; border-left: 1px solid;">
                          @if ($item->Telnet_inscCalificacionPorcentajeNov != "")
                          <b>{{number_format((float)$PromedioNovForAcademi, 1, '.', '')}}</b>
                          @else
                          @endif
                        </td>

                        
                  
                        {{--  promedio trimestree 1  --}}
                        @if ($item->inscTrimestre1 != "")
                        <td align="center" style="width: 54px; border-top: 0px solid; border-right: 1px solid; border-bottom: 1px solid; border-left: 1px solid;">
                          <b>{{number_format((float)$PromForAcademiPeriodo1, 1, '.', '')}}</b>
                        </td>
                        @else
                        <td align="center" style="width: 54px; border-top: 0px solid; border-right: 1px solid; border-bottom: 1px solid; border-left: 1px solid;"><label style="opacity: .01;">0</label></td>
                        @endif

                      
                  
                        <td align="center" style="width: 52px; border-top: 0px solid; border-right: 1px solid; border-bottom: 1px solid; border-left: 1px solid;">
                          @if ($item->Telnet_inscCalificacionPorcentajeEne != "")
                          <b>{{number_format((float)$PromedioEneForAcademi, 1, '.', '')}}</b>  
                          @else
                          @endif
                        </td>

                        <td align="center" style="width: 53px; border-top: 0px solid; border-right: 1px solid; border-bottom: 1px solid; border-left: 1px solid;">
                          @if ($item->Telnet_inscCalificacionPorcentajeFeb != "")
                          <b>{{number_format((float)$PromedioFebForAcademi, 1, '.', '')}}</b>  
                          @else
                          
                          @endif
                        </td>
                        
                        <td align="center" style="width: 53px; border-top: 0px solid; border-right: 1px solid; border-bottom: 1px solid; border-left: 1px solid;">
                          @if ($item->Telnet_inscCalificacionPorcentajeMar != "")
                          <b>{{number_format((float)$PromedioMarForAcademi, 1, '.', '')}}</b>  
                          @else
                          
                          @endif
                        </td>

                        
                  
                        {{--  promedio trimestre 2   --}}
                        @if ($item->inscTrimestre2 != "")
                        <td align="center" style="width: 53px; border-top: 0px solid; border-right: 1px solid; border-bottom: 1px solid; border-left: 1px solid;">
                          <b>{{number_format((float)$PromForAcademiPeriodo2, 1, '.', '')}}</b>                     
                        </td>
                        @else
                        <td align="center" style="width: 53px; border-top: 0px solid; border-right: 1px solid; border-bottom: 1px solid; border-left: 1px solid;"><label style="opacity: .01;">0</label></td>
                        @endif

                        <td align="center" style="width: 53px; border-top: 0px solid; border-right: 1px solid; border-bottom: 1px solid; border-left: 1px solid;">
                          @if ($item->Telnet_inscCalificacionPorcentajeAbr != "")
                          <b>{{number_format((float)$PromedioAbrForAcademi, 1, '.', '')}}</b>  
                          @else
                          
                          @endif
                        </td>

                        <td align="center" style="width: 52px; border-top: 0px solid; border-right: 1px solid; border-bottom: 1px solid; border-left: 1px solid;">
                          @if ($item->Telnet_inscCalificacionPorcentajeMay != "")
                          <b>{{number_format((float)$PromedioMayForAcademi, 1, '.', '')}}</b>  
                          @else
                          
                          @endif
                        </td>

                        <td align="center" style="width: 53px; border-top: 0px solid; border-right: 1px solid; border-bottom: 1px solid; border-left: 1px solid;">
                          @if ($item->Telnet_inscCalificacionPorcentajeJun != "")
                          <b>{{number_format((float)$PromedioJunForAcademi, 1, '.', '')}}</b>  
                          @else
                          
                          @endif
                        </td>

                        
                  
                        {{--  promedio trimestre 3   --}}
                        @if ($item->inscTrimestre3 != "")
                        <td align="center" style="width: 53px; border-top: 0px solid; border-right: 1px solid; border-bottom: 1px solid; border-left: 1px solid;">
                          <b>{{number_format((float)$PromForAcademiPeriodo3, 1, '.', '')}}</b>                     
                        </td>
                        @else
                        <td align="center" style="width: 53px; border-top: 0px solid; border-right: 1px solid; border-bottom: 1px solid; border-left: 1px solid;"><label style="opacity: .01;">0</label></td>
                        @endif
                                                                  
                  
                        <td align="center" style="width: 57px; border-top: 0px solid; border-right: 1px solid; border-bottom: 1px solid; border-left: 1px solid;">
                          @if ($PromForAcademiGeneral != "")
                          <b>{{number_format((float)$PromForAcademiGeneral, 1, '.', '')}}</b>
                          @else
                              
                          @endif
                                                 
                        </td>
                      </tr>                    
                     @endif
                    @endif
                  @endforeach
              
                </tbody>
              </table>


              
              {{--  DESARROLLO PERSONAL Y SOCIAL EDUCACION FISICA --}}
              <br>
              <table class="table table-bordered">
                <thead>
                 
                </thead>
                <tbody>
                  @foreach($calificaciones as $key => $item)
                    @if ($item->clave_pago == $clave_pago)

                    @if ($posicion2++ == 1)
                        <tr>
                          <td style="width: 227px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><b>DESARROLLO PERSONAL Y SOCIAL</b></td>
                          <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                          <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                          <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                          <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                          <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                          <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                          <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                          <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                          <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                          <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                          <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                          <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                          <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                        </tr>
                        @endif

                      @if ($item->matNombreEspecialidad == "DESARROLLO PERSONAL Y SOCIAL" && $item->matNombre == "ARTES")
                        <tr>
                                               
                          <td style="width: 227%;">
                            @if ($item->gpoMatComplementaria != "")
                            {{$item->matNombreOficial}} ({{$item->gpoMatComplementaria}})
                            @else     
                            {{$item->matNombreOficial}}                           
                            @endif                            
                          </td>                 
                          

                          @if ($item->Telnet_inscCalificacionPorcentajeSep != "")
                            <td align="center" style="width: 52px;">
                              {{$item->Telnet_inscCalificacionPorcentajeSep}}
                            </td>                        
                          @else
                            <td align="center" style="width: 52px;"><label style="opacity: .01;">0</label></td>
                          @endif
                    

                          @if ($item->Telnet_inscCalificacionPorcentajeOct != "")
                            <td align="center" style="width: 50px;">
                              {{$item->Telnet_inscCalificacionPorcentajeOct}}
                            </td>
                          @else
                            <td align="center" style="width: 50px;"><label style="opacity: .01;">0</label></td>
                          @endif
                          
                    
                          @if ($item->Telnet_inscCalificacionPorcentajeNov != "")
                            <td align="center" style="width: 52px;">
                              {{$item->Telnet_inscCalificacionPorcentajeNov}}
                            </td>
                          @else
                            <td align="center" style="width: 52px;"><label style="opacity: .01;">0</label></td>
                          @endif
                          
                    
                          {{--  promedio trimestree 1  --}}
                          @if ($item->inscTrimestre1 != "")
                          <td align="center" style="width: 55px; border-top: 1px solid; border-right: 1px solid; border-bottom: 1px; border-left: 0px solid;">
                            <b>{{$item->inscTrimestre1}}</b>
                          </td>
                          @else
                          <td align="center" style="width: 55px; border-top: 1px solid; border-right: 1px solid; border-bottom: 1px solid; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>
                          @endif

                        
                    
                          @if ($item->Telnet_inscCalificacionPorcentajeEne != "")
                          <td align="center" style="width: 52px;">
                            {{$item->Telnet_inscCalificacionPorcentajeEne}}
                          </td>
                          @else
                          <td align="center" style="width: 52px;"><label style="opacity: .01;">0</label></td>
                          @endif
                          
                    
                          @if ($item->Telnet_inscCalificacionPorcentajeFeb != "")
                          <td align="center" style="width: 51px;">
                            {{$item->Telnet_inscCalificacionPorcentajeFeb}}
                          </td>
                          @else
                          <td align="center" style="width: 51px;"><label style="opacity: .01;">0</label></td>
                          @endif
                          
                    
                          @if ($item->Telnet_inscCalificacionPorcentajeMar != "")
                          <td align="center" style="width: 54px;">
                            {{$item->Telnet_inscCalificacionPorcentajeMar}}
                          </td>
                          @else
                          <td align="center" style="width: 54px;"><label style="opacity: .01;">0</label></td>
                          @endif
                          
                    
                          {{--  promedio trimestre 2   --}}
                          @if ($item->inscTrimestre2 != "")
                          <td align="center" style="width: 55px; border-top: 1px solid; border-right: 1px solid; border-bottom: 1px solid; border-left: 0px solid;">
                            <b>{{$item->inscTrimestre2}}</b>
                          </td>
                          @else
                          <td align="center" style="width: 55px; border-top: 1px solid; border-right: 1px solid; border-bottom: 1px solid; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>
                          @endif

                      
                          @if ($item->Telnet_inscCalificacionPorcentajeAbr != "")
                          <td align="center" style="width: 52px;">{{$item->Telnet_inscCalificacionPorcentajeAbr}}</td>
                          @else
                          <td align="center" style="width: 52px;"><label style="opacity: .01;">0</label></td>
                          @endif

                          @if ($item->Telnet_inscCalificacionPorcentajeMay != "")
                          <td align="center" style="width: 54px;">{{$item->Telnet_inscCalificacionPorcentajeMay}}</td>
                          @else
                          <td align="center" style="width: 54px;"><label style="opacity: .01;">0</label></td>
                          @endif
                          

                          @if ($item->Telnet_inscCalificacionPorcentajeJun != "")
                          <td align="center" style="width: 52px;">{{$item->Telnet_inscCalificacionPorcentajeJun}}</td>
                          @else
                          <td align="center" style="width: 52px;"><label style="opacity: .01;">0</label></td>
                          @endif
                          
                    
                          {{--  promedio trimestre 3   --}}
                          @if ($item->inscTrimestre3 != "")
                          <td align="center" style="width: 54px; border-top: 1px solid; border-right: 1px solid; border-bottom: 1px solid; border-left: 0px solid;">
                            <b>{{$item->inscTrimestre3}}</b>
                          </td>
                          @else
                          <td align="center" style="width: 54px; border-top: 1px solid; border-right: 1px solid; border-bottom: 1px solid; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>
                          @endif
                                                                    
                    
                          <td align="center" style="width: 60px;"><label style="opacity: .01;">0</label></td>

                        </tr>
                      @endif

                      @if ($item->matNombreEspecialidad == "DESARROLLO PERSONAL Y SOCIAL" && $item->matNombre == "TUTORIA Y EDUCACION SOCIOEMOCIONAL")
                      <tr>
                                           
                        <td style="width: 227%;">{{$item->matNombreOficial}}</td>                 
                        

                        @if ($item->Telnet_inscCalificacionPorcentajeSep != "")
                          <td align="center" style="width: 52px;">
                            {{$item->Telnet_inscCalificacionPorcentajeSep}}
                          </td>                        
                        @else
                          <td align="center" style="width: 52px;"><label style="opacity: .01;">0</label></td>
                        @endif
                  

                        @if ($item->Telnet_inscCalificacionPorcentajeOct != "")
                          <td align="center" style="width: 50px;">
                            {{$item->Telnet_inscCalificacionPorcentajeOct}}
                          </td>
                        @else
                          <td align="center" style="width: 50px;"><label style="opacity: .01;">0</label></td>
                        @endif
                        
                  
                        @if ($item->Telnet_inscCalificacionPorcentajeNov != "")
                          <td align="center" style="width: 52px;">
                            {{$item->Telnet_inscCalificacionPorcentajeNov}}
                          </td>
                        @else
                          <td align="center" style="width: 52px;"><label style="opacity: .01;">0</label></td>
                        @endif
                        
                  
                        {{--  promedio trimestree 1  --}}
                        @if ($item->inscTrimestre1 != "")
                        <td align="center" style="width: 55px; border-top: 1px solid; border-right: 1px solid; border-bottom: 1px solid; border-left: 0px solid;">
                          <b>{{$item->inscTrimestre1}}</b>
                        </td>
                        @else
                        <td align="center" style="width: 55px; border-top: 1px solid; border-right: 1px solid; border-bottom: 1px solid; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>
                        @endif

                      
                  
                        @if ($item->Telnet_inscCalificacionPorcentajeEne != "")
                        <td align="center" style="width: 52px;">
                          {{$item->Telnet_inscCalificacionPorcentajeEne}}
                        </td>
                        @else
                        <td align="center" style="width: 52px;"><label style="opacity: .01;">0</label></td>
                        @endif
                        
                  
                        @if ($item->Telnet_inscCalificacionPorcentajeFeb != "")
                        <td align="center" style="width: 51px;">
                          {{$item->Telnet_inscCalificacionPorcentajeFeb}}
                        </td>
                        @else
                        <td align="center" style="width: 51px;"><label style="opacity: .01;">0</label></td>
                        @endif
                        
                  
                        @if ($item->Telnet_inscCalificacionPorcentajeMar != "")
                        <td align="center" style="width: 54px;">
                          {{$item->Telnet_inscCalificacionPorcentajeMar}}
                        </td>
                        @else
                        <td align="center" style="width: 54px;"><label style="opacity: .01;">0</label></td>
                        @endif
                        
                  
                        {{--  promedio trimestre 2   --}}
                        @if ($item->inscTrimestre2 != "")
                        <td align="center" style="width: 55px; border-top: 1px solid; border-right: 1px solid; border-bottom: 1px solid; border-left: 0px solid;">
                          <b>{{$item->inscTrimestre2}}</b>
                        </td>
                        @else
                        <td align="center" style="width: 55px; border-top: 1px solid; border-right: 1px solid; border-bottom: 1px solid; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>
                        @endif

                    
                        @if ($item->Telnet_inscCalificacionPorcentajeAbr != "")
                        <td align="center" style="width: 52px;">{{$item->Telnet_inscCalificacionPorcentajeAbr}}</td>
                        @else
                        <td align="center" style="width: 52px;"><label style="opacity: .01;">0</label></td>
                        @endif

                        @if ($item->Telnet_inscCalificacionPorcentajeMay != "")
                        <td align="center" style="width: 54px;">{{$item->Telnet_inscCalificacionPorcentajeMay}}</td>
                        @else
                        <td align="center" style="width: 54px;"><label style="opacity: .01;">0</label></td>
                        @endif
                        

                        @if ($item->Telnet_inscCalificacionPorcentajeJun != "")
                        <td align="center" style="width: 52px;">{{$item->Telnet_inscCalificacionPorcentajeJun}}</td>
                        @else
                        <td align="center" style="width: 52px;"><label style="opacity: .01;">0</label></td>
                        @endif
                        
                  
                        {{--  promedio trimestre 3   --}}
                        @if ($item->inscTrimestre3 != "")
                        <td align="center" style="width: 54px; border-top: 1px solid; border-right: 1px solid; border-bottom: 1px solid; border-left: 0px solid;">
                          <b>{{$item->inscTrimestre3}}</b>
                        </td>
                        @else
                        <td align="center" style="width: 54px; border-top: 1px solid; border-right: 1px solid; border-bottom: 1px solid; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>
                        @endif
                                                                  
                  
                        <td align="center" style="width: 60px;"><label style="opacity: .01;">0</label></td>

                      </tr>
                      @endif

                                         
                    @endif
                  @endforeach            

              
                </tbody>
              </table>

              <br> 
              {{--  educacion fisica   --}}
              <table class="table table-bordered">
                <thead>
                 
                </thead>
                <tbody>
                  @foreach($calificaciones as $key => $item)
                    @if ($item->clave_pago == $clave_pago)

                    @if ($posicion10++ == 1)
                        <tr>
                          <td style="width: 227px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><b></b></td>
                          <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                          <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                          <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                          <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                          <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                          <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                          <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                          <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                          <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                          <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                          <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                          <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                          <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                        </tr>
                        @endif

                     

                      {{--  @if ($item->matNombreEspecialidad == "DESARROLLO PERSONAL Y SOCIAL" && $item->matNombre == "EDUCACION FISICA" || $item->matNombre == "EDUCACION FISICA VESP")   --}}
                      @if ($item->matNombreEspecialidad == "DESARROLLO PERSONAL Y SOCIAL" && $item->matNombre == "EDUCACION FISICA")                      
                     
                      @php
                      $keyMatDESA++;
                      $promSEPDESA = $promSEPDESA + $item->Telnet_inscCalificacionPorcentajeSep; 
                      $promOCTDESA = $promOCTDESA + $item->Telnet_inscCalificacionPorcentajeOct;
                      $promNOVDESA = $promNOVDESA + $item->Telnet_inscCalificacionPorcentajeNov;
                      $PromedioDesaPerido1 = $PromedioDesaPerido1 + $item->inscTrimestre1;
                      $promDICENEDESA = $promDICENEDESA + $item->Telnet_inscCalificacionPorcentajeEne; 
                      $promFEBDESA = $promFEBDESA + $item->Telnet_inscCalificacionPorcentajeFeb;
                      $promMARDESA = $promMARDESA + $item->Telnet_inscCalificacionPorcentajeMar;
                      $PromedioDesaPerido2 = $PromedioDesaPerido2 + $item->inscTrimestre2;
                      $promABRDESA = $promABRDESA + $item->Telnet_inscCalificacionPorcentajeAbr; 
                      $promMAYDESA = $promMAYDESA + $item->Telnet_inscCalificacionPorcentajeMay; 
                      $promJUNDESA = $promJUNDESA + $item->Telnet_inscCalificacionPorcentajeJun; 
                      $PromedioDesaPerido3 = $PromedioDesaPerido3 + $item->inscTrimestre3;
                      $promedioFinalDESA = $promedioFinalDESA + $item->Telnet_inscPromedioTrimCALCULADO; 

                      $posicion3Fisi++;

                      $promedioFisDivOct = $promOCTDESA/$posicion3Fisi;
                      $promedioFisDivNov = $promNOVDESA/$posicion3Fisi;
                      $promedioFisDivPeri1 = $PromedioDesaPerido1/$posicion3Fisi;
                      $promedioFisDivEne = $promDICENEDESA/$posicion3Fisi;
                      $promedioFisDivFeb = $promFEBDESA/$posicion3Fisi;
                      $promedioFisDivMar = $promMARDESA/$posicion3Fisi;
                      $promedioFisDivPeri2 = $PromedioDesaPerido2/$posicion3Fisi;
                      $promedioFisDivAbr = $promABRDESA/$posicion3Fisi;
                      $promedioFisDivMay = $promMAYDESA/$posicion3Fisi;
                      $promedioFisDivJun = $promJUNDESA/$posicion3Fisi;
                      $promedioFisDivPeri3 = $PromedioDesaPerido3/$posicion3Fisi;
                      $promedioFisDivFinal = $promedioFinalDESA/$posicion3Fisi;



                    @endphp
                       
                        <tr>
                      
                        
                          <td style="width: 227%;">{{$item->matNombreOficial}}</td>                 
                          

                          @if ($item->Telnet_inscCalificacionPorcentajeSep != "")
                            <td align="center" style="width: 52px;">
                              {{$item->Telnet_inscCalificacionPorcentajeSep}}
                            </td>                        
                          @else
                            <td align="center" style="width: 52px;"><label style="opacity: .01;">0</label></td>
                          @endif
                    

                          @if ($item->Telnet_inscCalificacionPorcentajeOct != "")
                            <td align="center" style="width: 50px;">
                              {{$item->Telnet_inscCalificacionPorcentajeOct}}
                            </td>
                          @else
                            <td align="center" style="width: 50px;"><label style="opacity: .01;">0</label></td>
                          @endif
                          
                    
                          @if ($item->Telnet_inscCalificacionPorcentajeNov != "")
                            <td align="center" style="width: 52px;">
                              {{$item->Telnet_inscCalificacionPorcentajeNov}}
                            </td>
                          @else
                            <td align="center" style="width: 52px;"><label style="opacity: .01;">0</label></td>
                          @endif
                          
                    
                          {{--  promedio trimestree 1  --}}
                          @if ($item->inscTrimestre1 != "")
                          <td align="center" style="width: 55px; border-top: 1px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;">
                            {{$PromedioDesaPerido1}}
                          </td>
                          @else
                          <td align="center" style="width: 55px; border-top: 1px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>
                          @endif

                        
                    
                          @if ($item->Telnet_inscCalificacionPorcentajeEne != "")
                          <td align="center" style="width: 52px;">
                            {{$item->Telnet_inscCalificacionPorcentajeEne}}
                          </td>
                          @else
                          <td align="center" style="width: 52px;"><label style="opacity: .01;">0</label></td>
                          @endif
                          
                    
                          @if ($item->Telnet_inscCalificacionPorcentajeFeb != "")
                          <td align="center" style="width: 51px;">
                            {{$item->Telnet_inscCalificacionPorcentajeFeb}}
                          </td>
                          @else
                          <td align="center" style="width: 51px;"><label style="opacity: .01;">0</label></td>
                          @endif
                          
                    
                          @if ($item->Telnet_inscCalificacionPorcentajeMar != "")
                          <td align="center" style="width: 54px;">
                            {{$item->Telnet_inscCalificacionPorcentajeMar}}
                          </td>
                          @else
                          <td align="center" style="width: 54px;"><label style="opacity: .01;">0</label></td>
                          @endif
                          
                    
                          {{--  promedio trimestre 2   --}}
                          @if ($item->inscTrimestre2 != "")
                          <td align="center" style="width: 55px; border-top: 1px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;">
                            {{$PromedioDesaPerido2}}
                          </td>
                          @else
                          <td align="center" style="width: 55px; border-top: 1px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>
                          @endif

                      
                          @if ($item->Telnet_inscCalificacionPorcentajeAbr != "")
                          <td align="center" style="width: 52px;">{{$item->Telnet_inscCalificacionPorcentajeAbr}}</td>
                          @else
                          <td align="center" style="width: 52px;"><label style="opacity: .01;">0</label></td>
                          @endif

                          @if ($item->Telnet_inscCalificacionPorcentajeMay != "")
                          <td align="center" style="width: 54px;">{{$item->Telnet_inscCalificacionPorcentajeMay}}</td>
                          @else
                          <td align="center" style="width: 54px;"><label style="opacity: .01;">0</label></td>
                          @endif
                          

                          @if ($item->Telnet_inscCalificacionPorcentajeJun != "")
                          <td align="center" style="width: 52px;">{{$item->Telnet_inscCalificacionPorcentajeJun}}</td>
                          @else
                          <td align="center" style="width: 52px;"><label style="opacity: .01;">0</label></td>
                          @endif
                          
                    
                          {{--  promedio trimestre 3   --}}
                          @if ($item->inscTrimestre3 != "")
                          <td align="center" style="width: 54px; border-top: 1px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;">
                            {{$PromedioDesaPerido3}}
                          </td>
                          @else
                          <td align="center" style="width: 54px; border-top: 1px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>
                          @endif
                                                                    
                    
                          <td align="center" style="width: 60px;"><label style="opacity: .01;">0</label></td>

                        </tr>
                      @endif                      
                    @endif

                    
                  @endforeach      
                  
                    {{--  Solo para mostrar fila ves y para merida  --}}
                    @if ($secundaria_porcentajes->departamento_id == "15")

                    <tr>
                        
                        
                      <td style="width: 227%;">EDUCACION FISICA VESP</td>                 
                      
  
                      <td align="center" style="width: 52px;"><label style="opacity: .01;">0</label></td>
                
  
                      <td align="center" style="width: 50px;"><label style="opacity: .01;">0</label></td>
                      
                
                      <td align="center" style="width: 52px;"><label style="opacity: .01;">0</label></td>
                      
                
                      {{--  promedio trimestree 1  --}}
                      <td align="center" style="width: 55px; border-top: 1px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>
  
  
                    
                
                      <td align="center" style="width: 52px;"><label style="opacity: .01;">0</label></td>
  
                      <td align="center" style="width: 51px;"><label style="opacity: .01;">0</label></td>
  
                      <td align="center" style="width: 54px;"><label style="opacity: .01;">0</label></td>
  
                
                      {{--  promedio trimestre 2   --}}
                      <td align="center" style="width: 55px; border-top: 1px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>
  
  
                      <td align="center" style="width: 52px;"><label style="opacity: .01;">0</label></td>
  
                      <td align="center" style="width: 54px;"><label style="opacity: .01;">0</label></td>
  
                      <td align="center" style="width: 52px;"><label style="opacity: .01;">0</label></td>
  
                      
                
                      {{--  promedio trimestre 3   --}}
                      <td align="center" style="width: 54px; border-top: 1px solid; border-right: 1px solid; border-bottom: 1px solid; border-left: 1px solid;"><label style="opacity: .01;">0</label></td>
  
                                                                
                
                      <td align="center" style="width: 60px; border-top: 1px solid; border-right: 1px solid; border-bottom: 1px solid; border-left: 1px solid;"><label style="opacity: .01;">0</label></td>
  
                      
                    </tr>
                    
                    @endif
                  

                  <tr>
                    <td><b>PROMEDIO EDUCACIÓN FÍSICA</b></td> 
                    {{--  promedio septiembree  --}}
                    @if ($promSEPDESA != "")
                      <td align="center">{{$promSEPDESA}}</td>
                    @else
                      <td align="center"><label style="opacity: .01;">0</label></td>
                    @endif

                    {{--  promedio octubre   --}}
                    @if ($promOCTDESA != "")
                      <td align="center">{{$promOCTDESA}}</td>
                    @else
                    @endif
                    


                    {{--  promedio noviembre   --}}
                    @if ($promNOVDESA != "")
                      <td align="center">{{$promNOVDESA}}</td>
                    @else
                      <td align="center"><label style="opacity: .01;">0</label></td>
                    @endif
                    

                    {{--  promedio general primer periodo   --}}
                    <td align="center">
                      @if ($PromedioDesaPerido1 != "")
                      <b>{{number_format((float)$PromedioDesaPerido1, 1, '.', '')}}</b>
                      @else
                          
                      @endif
                                     
                    </td>
                 
                    {{--  segundo periodo  --}}
                    {{--  promedio dic enero  --}}
                    <td align="center">
                      @if ($promDICENEDESA != "")
                        {{$promDICENEDESA}}
                      @else
                          
                      @endif
                      
                    </td>

                    {{--  promedio febrero  --}}
                    <td align="center">
                      @if ($promFEBDESA != "")
                      {{$promFEBDESA}}
                      @else
                          
                      @endif
                      
                    </td>

                    {{--  promedio marzo  --}}
                    <td align="center">
                      @if ($promMARDESA != "")
                      {{$promMARDESA}}
                      @else
                          
                      @endif
                     
                    </td>

                    {{--  promedio general segundo periodo   --}}
                    <td align="center">
                      @if ($PromedioDesaPerido2 != "")
                      <b>{{number_format((float)$PromedioDesaPerido2, 1, '.', '')}}</b>
                      @else
                      @endif
                      
                    </td>
                


                    {{--  tercer periodo   --}}
                    {{--  promedio abril  --}}
                    <td align="center">
                      @if ($promABRDESA == "")
                          <b></b>
                      @else
                        {{$promABRDESA}}
                      @endif                      
                    </td>

                    {{--  promedio mayo  --}}
                    <td align="center">
                      @if ($promMAYDESA == "")
                          <b></b>
                      @else
                        {{$promMAYDESA}}
                      @endif
                      
                    </td>

                    {{--  promedio junio  --}}
                    <td align="center">
                      @if ($promJUNDESA == "")
                          <b></b>
                      @else
                        {{$promJUNDESA}}
                      @endif                      
                    </td>

                    {{--  promedio general tercer periodo   --}}
                    <td align="center">
                      @if ($PromedioDesaPerido3 != "")
                        <b>{{number_format((float)$PromedioDesaPerido3, 1, '.', '')}}</b>
                      @else
                      {{-- <b>{{bcdiv($PromedioDesaPerido3, '1')}}</b> --}}
                      @endif                      
                    </td>
                  
                    <td align="center" style="border-top: 1px solid; border-right: 1px solid; border-bottom: 1px solid; border-left: 1px solid;">
                      @if ($promedioFinalDESA == "")
                          <b></b>
                      @else
                        <b>{{$promedioFinalDESA}}</b>
                      @endif                      
                    </td>

                    {{--  <td align="center" style="border-top: 1px solid; border-right: 1px solid; border-bottom: 1px solid; border-left: 1px solid;">
                                           
                    </td>  --}}

                  </tr> 
              
                </tbody>
              </table>

                         
               {{--  OPTATIVAS  --}}
               <br>

               <table class="table table-bordered">
                 <thead>
                   
                 </thead>
                 <tbody>
                   @foreach($calificaciones as $key => $item)
                     @if ($item->clave_pago == $clave_pago)
                       @if ($item->matNombreEspecialidad == "AUTONOMIA CURRICULAR (TECNOLOGICAS)")   
                       @if ($posicion3++ == 1)
                       <tr>
                         <td style="width: 227px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><b>AUTONOMIA CURRICULAR (TECNOLÓGICAS)</b></td>
                         <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                         <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                         <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                         <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                         <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                         <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                         <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                         <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                         <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                         <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                         <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                         <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                         <td style="border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"></td>
                       </tr>
                       @endif                  
                       
                       <tr>
                         @php
                        
 
                           $keyMatOptativas++;
                           $promSepOpta = $promSepOpta + $item->Telnet_inscCalificacionPorcentajeSep;
                           $promOctOpta = $promOctOpta + $item->Telnet_inscCalificacionPorcentajeOct;
                           $promNovOpta = $promNovOpta + $item->Telnet_inscCalificacionPorcentajeNov;
                           $PromedioOptaPerido1 = $PromedioOptaPerido1 + $item->inscTrimestre1;
                           $promDicEneOpta = $promDicEneOpta + $item->Telnet_inscCalificacionPorcentajeEne; 
                           $promFebOpta =  $promFebOpta + $item->Telnet_inscCalificacionPorcentajeFeb;
                           $promMarOpta = $promMarOpta + $item->Telnet_inscCalificacionPorcentajeMar;
                           $PromedioOptaPerido2 = $PromedioOptaPerido2 + $item->inscTrimestre2;
                           $promAbrOpta = $promAbrOpta + $item->Telnet_inscCalificacionPorcentajeAbr; 
                           $promMayOpta = $promMayOpta + $item->Telnet_inscCalificacionPorcentajeMay;
                           $promJunOpta = $promJunOpta + $item->Telnet_inscCalificacionPorcentajeJun; 
                           $PromedioOptaPerido3 = $PromedioOptaPerido3 + $item->inscTrimestre3;
                           $promedioFinalOpta = $promedioFinalOpta + $item->Telnet_inscPromedioTrimCALCULADO;
 
                           
                           
                         @endphp
                        
                         <td style="width: 227px;">
                           @if ($item->gpoMatComplementaria != "")
                           {{$item->matNombreOficial}} ({{$item->gpoMatComplementaria}})
                           @else
                           {{$item->matNombreOficial}}
                           @endif
                          </td>                 
                         
 
                         @if ($item->Telnet_inscCalificacionPorcentajeSep != "")
                           <td align="center" style="width: 52px;">
                             {{$item->Telnet_inscCalificacionPorcentajeSep}}
                           </td>                        
                         @else
                           <td align="center" style="width: 52px;"><label style="opacity: .01;">0</label></td>
                         @endif
                   
 
                         @if ($item->Telnet_inscCalificacionPorcentajeOct != "")
                           <td align="center" style="width: 50px;">
                             {{$item->Telnet_inscCalificacionPorcentajeOct}}
                           </td>
                         @else
                           <td align="center" style="width: 50px;"><label style="opacity: .01;">0</label></td>
                         @endif
                         
                   
                         @if ($item->Telnet_inscCalificacionPorcentajeNov != "")
                           <td align="center" style="width: 52px;">
                             {{$item->Telnet_inscCalificacionPorcentajeNov}}
                           </td>
                         @else
                           <td align="center" style="width: 52px;"><label style="opacity: .01;">0</label></td>
                         @endif
                         
                   
                         {{--  promedio trimestree 1  --}}
                         <td align="center" style="width: 55px; border-top: 1px solid; border-right: 0px; border-bottom: 1px solid; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>
 
                       
                   
                         @if ($item->Telnet_inscCalificacionPorcentajeEne != "")
                         <td align="center" style="width: 52px;">
                           {{$item->Telnet_inscCalificacionPorcentajeEne}}
                         </td>
                         @else
                         <td align="center" style="width: 52px;"><label style="opacity: .01;">0</label></td>
                         @endif
                         
                   
                         @if ($item->Telnet_inscCalificacionPorcentajeFeb != "")
                         <td align="center" style="width: 51px;">
                           {{$item->Telnet_inscCalificacionPorcentajeFeb}}
                         </td>
                         @else
                         <td align="center" style="width: 51px;"><label style="opacity: .01;">0</label></td>
                         @endif
                         
                   
                         @if ($item->Telnet_inscCalificacionPorcentajeMar != "")
                         <td align="center" style="width: 54px;">
                           {{$item->Telnet_inscCalificacionPorcentajeMar}}
                         </td>
                         @else
                         <td align="center" style="width: 54px;"><label style="opacity: .01;">0</label></td>
                         @endif
                         
                   
                         {{--  promedio trimestre 2   --}}
                         <td align="center" style="width: 55px; border-top: 1px solid; border-right: 0px; border-bottom: 1px solid; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>
 
                     
                         @if ($item->Telnet_inscCalificacionPorcentajeAbr != "")
                         <td align="center" style="width: 52px;">{{$item->Telnet_inscCalificacionPorcentajeAbr}}</td>
                         @else
                         <td align="center" style="width: 52px;"><label style="opacity: .01;">0</label></td>
                         @endif
 
                         @if ($item->Telnet_inscCalificacionPorcentajeMay != "")
                         <td align="center" style="width: 54px;">{{$item->Telnet_inscCalificacionPorcentajeMay}}</td>
                         @else
                         <td align="center" style="width: 54px;"><label style="opacity: .01;">0</label></td>
                         @endif
                         
 
                         @if ($item->Telnet_inscCalificacionPorcentajeJun != "")
                         <td align="center" style="width: 52px;">{{$item->Telnet_inscCalificacionPorcentajeJun}}</td>
                         @else
                         <td align="center" style="width: 52px;"><label style="opacity: .01;">0</label></td>
                         @endif
                         
                   
                         {{--  promedio trimestre 3   --}}
                         <td align="center" style="width: 54px; border-top: 1px solid; border-right: 0px; border-bottom: 1px solid; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>
                                                                   
                         <td align="center" style="width: 60px;"><label style="opacity: .01;">0</label></td>
 
                       </tr>
                       @endif
                     @endif
                   @endforeach
 
               
                 </tbody>              
               </table>
 
               {{--  PROMEDIO GENERAL   --}}
              <br>
              <table class="table table-bordered">
                <thead>
                
                </thead>
                <tbody>
                  @php

                  #para periodo 1
                  $promedioGeneralFinalPer1 = $promedioGeneralPer1FA + $PromedioDesaPerido1 + $promedioGenralPer1ArTu + $PromedioOptaPerido1;
                  $totalEnDividir = $posicionFA + $posicion3Fisi + $posicion3ArtTut + $posicionTec;
                  $resultadoPeriodo1 = $promedioGeneralFinalPer1 / $totalEnDividir;

                  #para periodo 2
                  $promedioGeneralFinalPer2 = $promedioGeneralPer2FA + $PromedioDesaPerido2 + $promedioGenralPer2ArTu + $PromedioOptaPerido2;
                  $resultadoPeriodo2 = $promedioGeneralFinalPer2 / $totalEnDividir;

                  #para periodo 3
                  $promedioGeneralFinalPer3 = $promedioGeneralPer3FA + $PromedioDesaPerido3 + $promedioGenralPer3ArTu + $PromedioOptaPerido3;
                  $resultadoPeriodo3 = $promedioGeneralFinalPer3 / $totalEnDividir;


                  $promedioGeneralFinalTrimestre = $promedioGeneralTrimestreFA + $promedioGenralTrimestreArTu + $promedioFinalOpta;
                  $resultadoTrimestreFin = $promedioGeneralFinalTrimestre; 

                   @endphp

                  @foreach($calificaciones as $key => $item)
                    @if ($item->clave_pago == $clave_pago)
                     @php
                         $keyPromedioGeneral++;
                     @endphp
                     @if ($keyPromedioGeneral == 1)
                      <tr>                      
                        <td style="width: 227px;"><b>PROMEDIO GENERAL</b></td>                 
                        

                        <td align="center" style="width: 52px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>                  

                        <td align="center" style="width: 50px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>                        
                  
                        <td align="center" style="width: 55px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>

                        
                  
                        {{--  promedio trimestree 1  --}}
                        @if ($resultadoPeriodo1 != "")
                        <td align="center" style="width: 55px;">
                          @if ($resultadoPeriodo1 < 6)
                          <b>5</b>
                          @else
                          {{number_format((float)$resultadoPeriodo1, 0, '.', '')}}
                          @endif                          
                        </td>
                        @else
                        <td align="center" style="width: 55px;"><label style="opacity: .01;">0</label></td>
                        @endif

                      
                  
                        <td align="center" style="width: 52px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>

                        <td align="center" style="width: 52px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>
                        
                        <td align="center" style="width: 55px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>

                        
                  
                        {{--  promedio trimestre 2   --}}
                        @if ($resultadoPeriodo2 != "")
                        <td align="center" style="width: 58px;">
                          @if ($resultadoPeriodo2 < 6)
                          <b>5</b>
                          @else
                          {{number_format((float)$resultadoPeriodo2, 0, '.', '')}}
                          @endif                          
                        </td>
                        @else
                        <td align="center" style="width: 55px;"><label style="opacity: .01;">0</label></td>
                        @endif

                        <td align="center" style="width: 52px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>

                        <td align="center" style="width: 52px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>

                        <td align="center" style="width: 52px; border-top: 0px solid; border-right: 0px; border-bottom: 0px; border-left: 0px solid;"><label style="opacity: .01;">0</label></td>

                        
                  
                        {{--  promedio trimestre 3   --}}
                        @if ($resultadoPeriodo3 != "")
                        <td align="center" style="width: 55px;">
                          @if ($resultadoPeriodo3 < 6)
                          <b>5</b>
                          @else
                          {{number_format((float)$resultadoPeriodo3, 0, '.', '')}}
                          @endif                          
                        </td>
                        @else
                        <td align="center" style="width: 55px;"><label style="opacity: .01;">0</label></td>
                        @endif
                                                                  
                  
                        <td align="center" style="width: 60px;"><label style="opacity: .01;">0</label></td>
                      </tr>                    
                     @endif
                    @endif
                  @endforeach
              
                </tbody>
              </table>

              {{--  INASISTENCIAS  --}}
              @foreach($calificaciones as $key => $inasistencia)
                    @if ($inasistencia->clave_pago == $clave_pago)
                      @php
                          $Keynasistencias++;

                          if($inasistencia->matNombre != "EDUCACION FISICA VESP"){
                            $faltasSep = $faltasSep + $inasistencia->inscFaltasInjSep;
                            $faltasOct = $faltasOct + $inasistencia->inscFaltasInjOct;
                            $faltasNov = $faltasNov + $inasistencia->inscFaltasInjNov;
                            $faltasEne = $faltasEne + $inasistencia->inscFaltasInjEne;
                            $faltasFeb = $faltasFeb + $inasistencia->inscFaltasInjFeb;
                            $faltasMar = $faltasMar + $inasistencia->inscFaltasInjMar;
                            $faltasAbr = $faltasAbr + $inasistencia->inscFaltasInjAbr;
                            $faltasMay = $faltasMay + $inasistencia->inscFaltasInjMay;
                            $faltasJun = $faltasJun + $inasistencia->inscFaltasInjJun;
                          }
                          

                      @endphp                      
                    @endif
              @endforeach

              <br>
              <table class="table table-bordered">
                <thead>
                
                </thead>
                <tbody>
                  <tr>                      
                    <td style="width: 227px;"><b>INASISTENCIAS</b></td>
                      

                      @if ($faltasSep != "")
                        <td align="center" style="width: 52px;">
                          {{$faltasSep}}
                        </td>                        
                      @else
                        <td align="center" style="width: 52px;"><label style="opacity: .01;">0</label></td>
                      @endif
                

                      @if ($faltasOct != "")
                        <td align="center" style="width: 50px;">
                          {{$faltasOct}}
                        </td>
                      @else
                        <td align="center" style="width: 50px;"><label style="opacity: .01;">0</label></td>
                      @endif
                      
                
                      @if ($faltasNov != "")
                        <td align="center" style="width: 52px;">
                          {{$faltasNov}}
                        </td>
                      @else
                        <td align="center" style="width: 52px;"><label style="opacity: .01;">0</label></td>
                      @endif
                      
                
                      {{--  promedio trimestree 1  --}}
                      <td align="center" style="width: 55px;"><label style="opacity: .01;">0</label></td>

                    
                
                      @if ($faltasEne != "")
                      <td align="center" style="width: 52px;">
                        {{$faltasEne}}
                      </td>
                      @else
                      <td align="center" style="width: 52px;"><label style="opacity: .01;">0</label></td>
                      @endif
                      
                
                      @if ($faltasFeb != "")
                      <td align="center" style="width: 51px;">
                        {{$faltasFeb}}
                      </td>
                      @else
                      <td align="center" style="width: 51px;"><label style="opacity: .01;">0</label></td>
                      @endif
                      
                
                      @if ($faltasMar != "")
                      <td align="center" style="width: 54px;">
                        {{$faltasMar}}
                      </td>
                      @else
                      <td align="center" style="width: 54px;"><label style="opacity: .01;">0</label></td>
                      @endif
                      
                
                      {{--  promedio trimestre 2   --}}                        
                      <td align="center" style="width: 55px;"><label style="opacity: .01;">0</label></td>

                  
                      @if ($faltasAbr != "")
                      <td align="center" style="width: 52px;">{{$faltasAbr}}</td>
                      @else
                      <td align="center" style="width: 52px;"><label style="opacity: .01;">0</label></td>
                      @endif

                      @if ($faltasMay != "")
                      <td align="center" style="width: 54px;">{{$faltasMay}}</td>
                      @else
                      <td align="center" style="width: 54px;"><label style="opacity: .01;">0</label></td>
                      @endif
                      

                      @if ($faltasJun != "")
                      <td align="center" style="width: 52px;">{{$faltasJun}}</td>
                      @else
                      <td align="center" style="width: 52px;"><label style="opacity: .01;">0</label></td>
                      @endif
                      
                
                      {{--  promedio trimestre 3   --}}                       
                      <td align="center" style="width: 54px;"><label style="opacity: .01;">0</label></td>
                      
                      <td align="center" style="width: 60px;"><label style="opacity: .01;">0</label></td>
                  </tr>                
                </tbody>
              </table>

             
          </div>
        </div>

        <br>
        <div class="row">
          <div class="columns medium-12">
       
          </div>
        </div>
            @endif
        @endif
    @endforeach

    @if ($loop->first)
    <footer id="footer">
      <div class="page-number"></div>
    </footer>
    @endif

    @if (!$loop->last)
      <div class="page_break"></div>
    @endif
    @php
        $key = 0;
        $keyMatFA = 0.0;
        $keyMatDESA = 0.0;
        $keyMatPROY = 0.0;
        $keyMatOPTA = 0.0;
        $keyPromedioGeneral = 0;
        $acd = 0;
        $Keynasistencias = 0;
        $keyMatOptativas = 0.0;
  
        #Varibles indispensables para la categoria formación academica
        $keyPromedioGeneralFormacionAcademica = 0;
        $promedioGenFormacionAcadeSep = 0.0;
        $promedioGenFormacionAcadeOct = 0.0;
        $promedioGenFormacionAcadeNov = 0.0;
        $promedioGenFormacionAcadePeriodo1 = 0.0;
        $promedioGenFormacionAcadeEne = 0.0;
        $promedioGenFormacionAcadeFeb = 0.0;
        $promedioGenFormacionAcadeMar = 0.0;
        $promedioGenFormacionAcadePeriodo2 = 0.0;
        $promedioGenFormacionAcadeAbr = 0.0;
        $promedioGenFormacionAcadeMay = 0.0;
        $promedioGenFormacionAcadeJun = 0.0;
        $promedioGenFormacionAcadePeriodo3 = 0.0;

        //hay que declarar mas variables, una por columna diferente y categoria
        //iniciarlas en 0.0 

        $promSEPFA = 0.0;
        $promOCTFA = 0.0;
        $promNOVFA = 0.0;
        $promedioGen1FA = 0.0;
        $promedioGen1SEPFA = 0.0;
        $promDicEneFA = 0.0;
        $promFEBFA = 0.0;
        $promMARFA = 0.0;
        $promedioGen2FA = 0.0;
        $promedioGen2SEPFA = 0.0;
        $promABRFA = 0.0;
        $promMAYFA = 0.0;
        $promJUNFA = 0.0;
        $promedioGen3FA = 0.0;
        $promedioGen3SEPFA = 0.0;
        $promedioFinalFA = 0.0;
        $promedioFinalSEPFA = 0.0;

        $promSEPDESA = 0.0;
        $promOCTDESA = 0.0;
        $promNOVDESA = 0.0;
        $PromedioDesaPerido1 = 0.0;
        $PromedioGen1SEPDESA = 0.0;
        $promDICENEDESA = 0.0;
        $promFEBDESA = 0.0;
        $promMARDESA = 0.0;
        $PromedioDesaPerido2 = 0.0;
        $PromedioGen2SEPDESA = 0.0;
        $promABRDESA = 0.0;
        $promMAYDESA = 0.0;
        $promJUNDESA = 0.0;
        $PromedioDesaPerido3 = 0.0;
        $PromedioGen3SEPDESA = 0.0;
        $promedioFinalDESA = 0.0;
        $promedioFinalSEPDESA = 0.0;

       



        $posicion1 = 1;
        $posicion2 = 1;
        $posicion9 = 1;
        $posicion10 = 1;
        $posicion3 = 1;
        $posicionFA = 0;
        $posicion3Fisi = 0;
        $posicion3ArtTut = 0;
        $posicionTec = 0;


        $promSepOpta = 0.0;
        $promOctOpta = 0.0;
        $promNovOpta = 0.0;
        $PromedioOptaPerido1 = 0.0;
        $promDicEneOpta = 0.0;
        $promFebOpta = 0.0;
        $promMarOpta = 0.0;
        $PromedioOptaPerido2 = 0.0;
        $promAbrOpta = 0.0;
        $promMayOpta = 0.0;
        $promJunOpta = 0.0;
        $PromedioOptaPerido3 = 0.0;
        $promedioFinalOpta = 0.0;

        $promedioGeneralPer1FA = 0;
        $promedioGenralPer1ArTu = 0;
        $promedioGeneralFinalPer1 = 0;
        $totalEnDividir = 0;
        $resultadoPeriodo1 = 0;


        $promedioGeneralPer2FA = 0;
        $promedioGenralPer2ArTu = 0;
        $promedioGeneralFinalPer2 = 0;
        $resultadoPeriodo2 = 0;

        $promedioGeneralPer3FA = 0;
        $promedioGenralPer3ArTu = 0;
        $promedioGeneralFinalPer3 = 0;
        $resultadoPeriodo3 = 0;


        $promedioGeneralTrimestreFA = 0.0;
        $promedioGenralTrimestreArTu = 0.0;
        $promedioGeneralFinalTrimestre = 0.0;
        $resultadoTrimestreFin = 0.0;

        $faltasSep = 0;
        $faltasOct = 0;
        $faltasNov = 0;
        $faltasEne = 0;
        $faltasFeb = 0;
        $faltasMar = 0;
        $faltasAbr = 0;
        $faltasMay = 0;
        $faltasJun = 0;
    @endphp
@endforeach



  </body>
</html>
