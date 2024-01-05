<!DOCTYPE html>
<html>

<head>
  <title>Horario de clases</title>
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
      line-height: 1.6;
      /* 1 */
      -webkit-text-size-adjust: 100%;
      /* 2 */
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
      box-sizing: content-box;
      /* 1 */
      height: 0;
      /* 1 */
      overflow: visible;
      /* 2 */
    }

    /**
      * 1. Correct the inheritance and scaling of font size in all browsers.
      * 2. Correct the odd `em` font sizing in all browsers.
      */
    pre {
      font-family: monospace, monospace;
      /* 1 */
      font-size: 1em;
      /* 2 */
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
      border-bottom: none;
      /* 1 */
      text-decoration: underline;
      /* 2 */
      text-decoration: underline dotted;
      /* 2 */
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
      font-family: monospace, monospace;
      /* 1 */
      font-size: 1em;
      /* 2 */
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
      font-family: inherit;
      /* 1 */
      font-size: 100%;
      /* 1 */
      line-height: 1.15;
      /* 1 */
      margin: 0;
      /* 2 */
    }

    /**
      * Show the overflow in IE.
      * 1. Show the overflow in Edge.
      */
    button,
    input {
      /* 1 */
      overflow: visible;
    }

    /**
      * Remove the inheritance of text transform in Edge, Firefox, and IE.
      * 1. Remove the inheritance of text transform in Firefox.
      */
    button,
    select {
      /* 1 */
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
      box-sizing: border-box;
      /* 1 */
      color: inherit;
      /* 2 */
      display: table;
      /* 1 */
      max-width: 100%;
      /* 1 */
      padding: 0;
      /* 3 */
      white-space: normal;
      /* 1 */
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
      box-sizing: border-box;
      /* 1 */
      padding: 0;
      /* 2 */
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
      -webkit-appearance: textfield;
      /* 1 */
      outline-offset: -2px;
      /* 2 */
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
      -webkit-appearance: button;
      /* 1 */
      font: inherit;
      /* 2 */
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

    body {
      font-family: 'times sans-serif';
      font-size: 11px;
      margin-top: 40px;
      /* ALTURA HEADER */
      margin-left: -20px;
      margin-right: -20px;
    }

    .row {
      width: 100%;
      display: block;
      position: relative;
      /* margin-left: -30px;
      margin-right: -30px; */
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
      box-sizing: border-box !important;
    }

    .medium-1 {
      width: 8.33333333333%;
    }

    .medium-1-2 {
      width: 16.999%;
    }

    .medium-4 {
      width: 16.6666666667%;
    }

    .medium-2 {
      width: 21%;
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

    span {
      font-weight: bold;
    }

    p {
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

    .estilos-tabla tr th {
      font-size: 12px;
      background-color: #000;
      color: #fff;
      height: 30px;
      padding-left: 5px;
      padding-right: 5px;
      box-sizing: border-box;
      text-align: center;
    }

    .estilos-tabla tr td {
      font-size: 12px;
      padding-left: 2px;
      padding-right: 2px;
      box-sizing: border-box;
      color: #000;
    }

    .page_break {
      page-break-before: always;
    }

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
      left: 0px;
      top: -50px;
      right: 0px;
      height: 3px;
      /** Extra personal styles **/

      margin-left: 5px;
      margin-right: 5px;
    }

    #watermark {
      position: fixed;
      top: 15%;
      left: 0;
      width: 700px;
      height: 700px;
      opacity: .3;
    }

    .img-header {
      height: 80px;
      float: left;
    }

    .img-foto {
      height: 80px;
      float: right;
      margin-top: -100px;

      padding: 2px;
      background-color: #f5f5f5;
      border: 1px solid #999999;


    }

    .inicio-pagina {
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
      margin-left: 0px !important;
      padding-left: 0 !important;
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



    .table td,
    .table th {
      padding-top: 0px;
      padding-bottom: 0px;
      padding-right: 5px;
      //border: 1px solid #000;
    }

    .page-number:before {
      content: "Pág "counter(page);
    }

    .page-break {
      page-break-after: always;
    }


    .punteado{
      border-top: 1px dotted;
      border-right: 1px dotted;
      border-bottom: 1px dotted;
      border-left: 1px dotted;
       //border-color: 660033;
      //background-color: cc3366;
    }

    .punteado2{
      border-top: 1px dotted;
      border-right: 0px dotted;
      border-bottom: 1px dotted;
      border-left: 0px;
       //border-color: 660033;
      //background-color: cc3366;
    }
  </style>
</head>

<body>

  <header>
    <div class="row" style="margin-top: 0px;">
      <div class="columns medium-12">

        {{--  <img class="img-header" src="{{base_path('resources/assets/img/logo.jpg')}}" alt="">  --}}
        <h1 style="margin-top:0px; margin-bottom: 0px; text-align: center;">Preparatoria "ESCUELA MODELO"</h1>
        <h4 style="margin-top:0px; margin-bottom: 0px; text-align: center;">HORARIO DE CLASES POR MATERIA</h4>
        <h4 style="margin-top:0px; margin-bottom: 0px; text-align: center;">PERIODO ESCOLAR: {{$cicloEscolar}}</h4>

      </div>
    </div>
  </header>

  <div class="row">
    <div class="columns medium-3">
      <p><b>Clave:</b> {{$alumno[0]->aluClave}}</p>
      <p><b>Alumno:</b> {{$alumno[0]->nombre_completo_alumno}}</p>
    </div>
    <div class="columns medium-2">

    </div>
    <div class="columns medium-3">
      <p><b>Clav.Plan:</b> {{$alumno[0]->planClave}}</p>
      <p><b>Ubicación:</b> {{$alumno[0]->ubiClave}}</p>
    </div>
    <div class="columns medium-1-2">

    </div>
    <div class="columns medium-3">
      <p><b>Fecha:</b> {{$fechaActual}}</p>
      <p><b>Grupo:</b> {{$alumno[0]->semestre.' '.$alumno[0]->grupo}}</p>
    </div>
  </div>

  @php
      $lunes = 0;
      $martes = 0;
      $miercoles = 0;
      $jueves = 0;
      $viernes = 0;
  @endphp
  <br>
  <div class="row">
    <div class="columns medium-12">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th style="width: 60px;" class="punteado" align="center">HORA</th>
            {{--  <th class="punteado" align="center">MATERIA COMPLEMENTARIA</th>  --}}
            <th class="punteado" align="center">LUNES</th>
            <th class="punteado" align="center">MARTES</th>
            <th class="punteado" align="center">MIERCOLES</th>
            <th class="punteado" align="center">JUEVES</th>
            <th class="punteado" align="center">VIERNES</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="punteado" align="center">07:00-08:00</td>

            {{--  lunes   --}}
            <td class="punteado" align="center">
              @foreach ($alumno as $itemL)
                @if ($itemL->lunes == '7:00 a 8:00' || $itemL->lunes == '7:00 a 9:00')
                  @if ($itemL->materia_acd != "")
                    {{$itemL->materia_acd}}
                  @else
                    {{$itemL->materia}}
                  @endif
                @else

                @endif
              @endforeach
            </td>

            {{--  martes   --}}
            <td class="punteado" align="center">
              @foreach ($alumno as $itemMartes)
                @if ($itemMartes->martes == '7:00 a 8:00' || $itemMartes->martes == '7:00 a 9:00')
                  @if ($itemMartes->materia_acd != "")
                    {{$itemMartes->materia_acd}}
                  @else
                    {{$itemMartes->materia}}
                  @endif
                @else

                @endif
              @endforeach
            </td>

            {{--  Miercoles   --}}
            <td class="punteado" align="center">
              @foreach ($alumno as $itemMiercoles)
                @if ($itemMiercoles->miercoles == '7:00 a 8:00' || $itemMiercoles->miercoles == '7:00 a 9:00')
                  @if ($itemMiercoles->materia_acd != "")
                    {{$itemMiercoles->materia_acd}}
                  @else
                    {{$itemMiercoles->materia}}
                  @endif
                @else

                @endif
              @endforeach
            </td>

            {{--  Jueves   --}}
            <td class="punteado" align="center">
              @foreach ($alumno as $itemJue)
                @if ($itemJue->jueves == '7:00 a 8:00' || $itemJue->jueves == '7:00 a 9:00')
                  @if ($itemJue->materia_acd != "")
                    {{$itemJue->materia_acd}}
                  @else
                    {{$itemJue->materia}}
                  @endif
                @else

                @endif
              @endforeach
            </td>

            {{--  viernes   --}}
            <td class="punteado" align="center">
              @foreach ($alumno as $itemVier)
                @if ($itemVier->viernes == '7:00 a 8:00')
                  @if ($itemVier->materia_acd != "")
                    {{$itemVier->materia_acd}}
                  @else
                    {{$itemVier->materia}}
                  @endif
                @else

                @endif
              @endforeach
            </td>
          </tr>
        </tbody>

        {{--  8:00 a 9:00   --}}
        <tbody>
          <tr>
            <td class="punteado" align="center">08:00-09:00</td>

            {{--  lunes   --}}
            <td class="punteado" align="center">
              @foreach ($alumno as $itemL)
                @if ($itemL->lunes == '8:00 a 9:00' || $itemL->lunes == '7:00 a 9:00')
                  @if ($itemL->materia_acd != "")
                    {{$itemL->materia_acd}}
                  @else
                    {{$itemL->materia}}
                  @endif
                @else

                @endif
              @endforeach
            </td>

            {{--  martes   --}}
            <td class="punteado" align="center">
              @foreach ($alumno as $itemMartes)
                @if ($itemMartes->martes == '8:00 a 9:00' || $itemMartes->martes == '7:00 a 9:00')
                  @if ($itemMartes->materia_acd != "")
                    {{$itemMartes->materia_acd}}
                  @else
                    {{$itemMartes->materia}}
                  @endif
                @else

                @endif
              @endforeach
            </td>

            {{--  Miercoles   --}}
            <td class="punteado" align="center">
              @foreach ($alumno as $itemMiercoles)
                @if ($itemMiercoles->miercoles == '8:00 a 9:00' || $itemMiercoles->miercoles == '7:00 a 9:00')
                  @if ($itemMiercoles->materia_acd != "")
                    {{$itemMiercoles->materia_acd}}
                  @else
                    {{$itemMiercoles->materia}}
                  @endif
                @else

                @endif
              @endforeach
            </td>

            {{--  Jueves   --}}
            <td class="punteado" align="center">
              @foreach ($alumno as $itemJue)
                @if ($itemJue->jueves == '8:00 a 9:00' || $itemJue->jueves == '7:00 a 9:00' || $itemJue->jueves == '8:00 a 10:00')
                  @if ($itemJue->materia_acd != "")
                    {{$itemJue->materia_acd}}
                  @else
                    {{$itemJue->materia}}
                  @endif
                @else

                @endif
              @endforeach
            </td>

            {{--  viernes   --}}
            <td class="punteado" align="center">
              @foreach ($alumno as $itemVier)
                @if ($itemVier->viernes == '8:00 a 9:00' || $itemVier->viernes == '8:00 a 10:00')
                  @if ($itemVier->materia_acd != "")
                    {{$itemVier->materia_acd}}
                  @else
                    {{$itemVier->materia}}
                  @endif
                @else

                @endif
              @endforeach
            </td>
          </tr>

        </tbody>

        {{--  9:00 a 10:00   --}}
        <tbody>
          <tr>
            <td class="punteado" align="center">09:00-10:00</td>

            {{--  lunes   --}}
            <td class="punteado" align="center">
              @foreach ($alumno as $itemL)
                @if ($itemL->lunes == '9:00 a 10:00' || $itemL->lunes == '9:00 a 11:00')
                  @if ($itemL->materia_acd != "")
                    {{$itemL->materia_acd}}
                  @else
                    {{$itemL->materia}}
                  @endif
                @else

                @endif
              @endforeach
            </td>

            {{--  martes   --}}
            <td class="punteado" align="center">
              @foreach ($alumno as $itemMartes)
                @if ($itemMartes->martes == '9:00 a 10:00' || $itemMartes->martes == '9:00 a 11:00')
                  @if ($itemMartes->materia_acd != "")
                    {{$itemMartes->materia_acd}}
                  @else
                    {{$itemMartes->materia}}
                  @endif
                @else

                @endif
              @endforeach
            </td>

            {{--  Miercoles   --}}
            <td class="punteado" align="center">
              @foreach ($alumno as $itemMiercoles)
                @if ($itemMiercoles->miercoles == '9:00 a 10:00')
                  @if ($itemMiercoles->materia_acd != "")
                    {{$itemMiercoles->materia_acd}}
                  @else
                    {{$itemMiercoles->materia}}
                  @endif
                @else

                @endif
              @endforeach
            </td>

            {{--  Jueves   --}}
            <td class="punteado" align="center">
              @foreach ($alumno as $itemJue)
                @if ($itemJue->jueves == '9:00 a 10:00' || $itemJue->jueves == '8:00 a 10:00')
                  @if ($itemJue->materia_acd != "")
                    {{$itemJue->materia_acd}}
                  @else
                    {{$itemJue->materia}}
                  @endif
                @else

                @endif
              @endforeach
            </td>

            {{--  viernes   --}}
            <td class="punteado" align="center">
              @foreach ($alumno as $itemVier)
                @if ($itemVier->viernes == '9:00 a 10:00' || $itemVier->viernes == '8:00 a 10:00' || $itemVier->viernes == '9:00 a 11:00')
                  @if ($itemVier->materia_acd != "")
                    {{$itemVier->materia_acd}}
                  @else
                    {{$itemVier->materia}}
                  @endif
                @else

                @endif
              @endforeach
            </td>
          </tr>

        </tbody>

        {{--  10:00 a 11:00   --}}
        <tbody>
          <tr>
            <td class="punteado" align="center">10:00-11:00</td>

            {{--  lunes   --}}
            <td class="punteado" align="center">
              @foreach ($alumno as $itemL)
                @if ($itemL->lunes == '10:00 a 11:00' || $itemL->lunes == '10:00 a 12:30' || $itemL->lunes == '9:00 a 11:00')
                  @if ($itemL->materia_acd != "")
                    {{$itemL->materia_acd}}
                  @else
                    {{$itemL->materia}}
                  @endif
                @else

                @endif
              @endforeach
            </td>

            {{--  martes   --}}
            <td class="punteado" align="center">
              @foreach ($alumno as $itemMartes)
                @if ($itemMartes->martes == '10:00 a 11:00' || $itemMartes->martes == '9:00 a 11:00')
                  @if ($itemMartes->materia_acd != "")
                    {{$itemMartes->materia_acd}}
                  @else
                    {{$itemMartes->materia}}
                  @endif
                @else

                @endif
              @endforeach
            </td>

            {{--  Miercoles   --}}
            <td class="punteado" align="center">
              @foreach ($alumno as $itemMiercoles)
                @if ($itemMiercoles->miercoles == '10:00 a 11:00')
                  @if ($itemMiercoles->materia_acd != "")
                    {{$itemMiercoles->materia_acd}}
                  @else
                    {{$itemMiercoles->materia}}
                  @endif
                @else

                @endif
              @endforeach
            </td>

            {{--  Jueves   --}}
            <td class="punteado" align="center">
              @foreach ($alumno as $itemJue)
                @if ($itemJue->jueves == '10:00 a 11:00' || $itemJue->jueves == '10:00 a 12:30')
                  @if ($itemJue->materia_acd != "")
                    {{$itemJue->materia_acd}}
                  @else
                    {{$itemJue->materia}}
                  @endif
                @else

                @endif
              @endforeach
            </td>

            {{--  viernes   --}}
            <td class="punteado" align="center">
              @foreach ($alumno as $itemVier1011)
                @if ($itemVier1011->viernes == '10:00 a 11:00' || $itemVier1011->viernes == '9:00 a 11:00' || $itemVier1011->viernes == '10:00 a 12:30')
                  @if ($itemVier1011->materia_acd != "")
                    {{$itemVier1011->materia_acd}}
                  @else
                    {{$itemVier1011->materia}}
                  @endif
                @else

                @endif
              @endforeach
            </td>
          </tr>

        </tbody>

        {{--  11:00 a 11:30   --}}
        {{--  receso   --}}
        <tbody>
          <tr>
            <td style="height: 35px;" class="punteado" align="center">11:00-11:30</td>

            {{--  lunes   --}}
            <td class="punteado" align="center" colspan="5">
              <b>RECESO</b>
            </td>

          </tr>

        </tbody>

        {{--  11:30 a 12:30   --}}
        <tbody>
          <tr>
            <td class="punteado" align="center">11:30-12:30</td>

            {{--  lunes   --}}
            <td class="punteado" align="center">
              @foreach ($alumno as $itemL)
                @if ($itemL->lunes == '11:30 a 12:30' || $itemL->lunes == '10:00 a 12:30')
                  @if ($itemL->materia_acd != "")
                    {{$itemL->materia_acd}}
                  @else
                    {{$itemL->materia}}
                  @endif
                @else

                @endif
              @endforeach
            </td>

            {{--  martes   --}}
            <td class="punteado" align="center">
              @foreach ($alumno as $itemMartes)
                @if ($itemMartes->martes == '11:30 a 12:30')
                  @if ($itemMartes->materia_acd != "")
                    {{$itemMartes->materia_acd}}
                  @else
                    {{$itemMartes->materia}}
                  @endif
                @else

                @endif
              @endforeach
            </td>

            {{--  Miercoles   --}}
            <td class="punteado" align="center">
              @foreach ($alumno as $itemMiercoles)
                @if ($itemMiercoles->miercoles == '11:30 a 12:30' || $itemMiercoles->miercoles == '11:30 a 13:30')
                  @if ($itemMiercoles->materia_acd != "")
                    {{$itemMiercoles->materia_acd}}
                  @else
                    {{$itemMiercoles->materia}}
                  @endif
                @else

                @endif
              @endforeach
            </td>

            {{--  Jueves   --}}
            <td class="punteado" align="center">
              @foreach ($alumno as $itemJue)
                @if ($itemJue->jueves == '11:30 a 12:30' || $itemJue->jueves == '10:00 a 12:30')
                  @if ($itemJue->materia_acd != "")
                    {{$itemJue->materia_acd}}
                  @else
                    {{$itemJue->materia}}
                  @endif
                @else

                @endif
              @endforeach
            </td>

            {{--  viernes   --}}
            <td class="punteado" align="center">
              @foreach ($alumno as $itemVier)
                @if ($itemVier->viernes == '11:30 a 12:30' || $itemVier->viernes == '10:00 a 12:30' || $itemVier->viernes == '11:30 a 13:30')
                  @if ($itemVier->materia_acd != "")
                    {{$itemVier->materia_acd}}
                  @else
                    {{$itemVier->materia}}
                  @endif
                @else

                @endif
              @endforeach
            </td>
          </tr>

        </tbody>

        {{--  12:30 a 13:30   --}}
        <tbody>
          <tr>
            <td class="punteado" align="center">12:30-13:30</td>

            {{--  lunes   --}}
            <td class="punteado" align="center">
              @foreach ($alumno as $itemL)
                @if ($itemL->lunes == '12:30 a 13:30' || $itemL->lunes == '12:30 a 14:30')
                  @if ($itemL->materia_acd != "")
                    {{$itemL->materia_acd}}
                  @else
                    {{$itemL->materia}}
                  @endif
                @else

                @endif
              @endforeach
            </td>

            {{--  martes   --}}
            <td class="punteado" align="center">
              @foreach ($alumno as $itemMartes)
                @if ($itemMartes->martes == '12:30 a 13:30' || $itemMartes->martes == '12:30 a 14:30')
                  @if ($itemMartes->materia_acd != "")
                    {{$itemMartes->materia_acd}}
                  @else
                    {{$itemMartes->materia}}
                  @endif
                @else

                @endif
              @endforeach
            </td>

            {{--  Miercoles   --}}
            <td class="punteado" align="center">
              @foreach ($alumno as $itemMiercoles)
                @if ($itemMiercoles->miercoles == '12:30 a 13:30' || $itemMiercoles->miercoles == '12:30 a 14:30' || $itemMiercoles->miercoles == '11:30 a 13:30')
                  @if ($itemMiercoles->materia_acd != "")
                    {{$itemMiercoles->materia_acd}}
                  @else
                    {{$itemMiercoles->materia}}
                  @endif
                @else

                @endif
              @endforeach
            </td>

            {{--  Jueves   --}}
            <td class="punteado" align="center">
              @foreach ($alumno as $itemJue)
                @if ($itemJue->jueves == '12:30 a 13:30' || $itemJue->jueves == '12:30 a 14:30')
                  @if ($itemJue->materia_acd != "")
                    {{$itemJue->materia_acd}}
                  @else
                    {{$itemJue->materia}}
                  @endif
                @else

                @endif
              @endforeach
            </td>

            {{--  viernes   --}}
            <td class="punteado" align="center">
              @foreach ($alumno as $itemVier)
                @if ($itemVier->viernes == '12:30 a 13:30' || $itemVier->viernes == '11:30 a 13:30' || $itemVier->viernes == '12:30 a 14:30')
                  @if ($itemVier->materia_acd != "")
                    {{$itemVier->materia_acd}}
                  @else
                    {{$itemVier->materia}}
                  @endif
                @else

                @endif
              @endforeach
            </td>
          </tr>

        </tbody>

        {{--  13:30 a 14:30   --}}
        <tbody>
          <tr>
            <td class="punteado" align="center">13:30-14:30</td>

            {{--  lunes   --}}
            <td class="punteado" align="center">
              @foreach ($alumno as $itemL)
                @if ($itemL->lunes == '13:30 a 14:30' || $itemL->lunes == '12:30 a 14:30')
                  @if ($itemL->materia_acd != "")
                    {{$itemL->materia_acd}}
                  @else
                    {{$itemL->materia}}
                  @endif
                @else

                @endif
              @endforeach
            </td>

            {{--  martes   --}}
            <td class="punteado" align="center">
              @foreach ($alumno as $itemMartes)
                @if ($itemMartes->martes == '13:30 a 14:30' || $itemMartes->martes == '12:30 a 14:30')
                  @if ($itemMartes->materia_acd != "")
                    {{$itemMartes->materia_acd}}
                  @else
                    {{$itemMartes->materia}}
                  @endif
                @else

                @endif
              @endforeach
            </td>

            {{--  Miercoles   --}}
            <td class="punteado" align="center">
              @foreach ($alumno as $itemMiercoles)
                @if ($itemMiercoles->miercoles == '13:30 a 14:30' ||$itemMiercoles->miercoles == '12:30 a 14:30')
                  @if ($itemMiercoles->materia_acd != "")
                    {{$itemMiercoles->materia_acd}}
                  @else
                    {{$itemMiercoles->materia}}
                  @endif
                @else

                @endif
              @endforeach
            </td>

            {{--  Jueves   --}}
            <td class="punteado" align="center">
              @foreach ($alumno as $itemJue)
                @if ($itemJue->jueves == '13:30 a 14:30' || $itemJue->jueves == '12:30 a 14:30')
                  @if ($itemJue->materia_acd != "")
                    {{$itemJue->materia_acd}}
                  @else
                    {{$itemJue->materia}}
                  @endif
                @else

                @endif
              @endforeach
            </td>

            {{--  viernes   --}}
            <td class="punteado" align="center">
              @foreach ($alumno as $itemVier)
                @if ($itemVier->viernes == '13:30 a 14:30' || $itemVier->viernes == '12:30 a 14:30')
                  @if ($itemVier->materia_acd != "")
                    {{$itemVier->materia_acd}}
                  @else
                    {{$itemVier->materia}}
                  @endif
                @else

                @endif
              @endforeach
            </td>
          </tr>

        </tbody>

      </table>

    </div>
  </div>


</body>

</html>
