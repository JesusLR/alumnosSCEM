<!DOCTYPE html>
<html>
	<head>
		<title></title>
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
        line-height: 1.15; /* 1 */
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
        font-size: 12px;
        margin-top: 40px;
        margin-left: 5px;
        margin-right: 5px;
      }
      .row {
        width:100%;
        display: block;
        position: relative;
        /* margin-left: -30px; */
        /* margin-right: -30px; */
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
      .float-right: {
        float: right;
      }
      .logo {
        width: 100%;
      }
      .box-solicitud {
        border: 1px solid "black";
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
        left: 0px;
        position: fixed;
        top: -30px;
        right: 0px;
        height: 3px;
        /** Extra personal styles **/

        margin-left: 5px;
        margin-right: 5px;
      }

      #watermark { position: fixed; top: 15%; left: 0;  width: 700px; height: 700px; opacity: .3; }
      .img-header{
        height: 80px;
      }
      .inicio-pagina{
        margin-top: 0;
        display: block;
      }
     @page {
        margin-left: 0.5cm;
        margin-right: 0.5cm;
        margin-top: 50px;
        margin-bottom: 70px;
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

      .table th {
        border-bottom: 1px solid #000;
      }

      .table td, .table  th {
        padding-top: 0px;
        padding-bottom: 0px;
        padding-right: 5px;
      }

      .page-number:before {
        content: "Pág " counter(page);
      }
    </style>
	</head>
  <body>

    <header>
      <div class="row">
        <div class="columns medium-6">
          <h5 style="margin-top:0px; margin-bottom: 10px;">UNIVERSIDAD MODELO</h5>
          <h5 style="margin-top:0px; margin-bottom: 10px;">RESUMEN DE CALIFICACIONES POR GRUPO</h5>
        </div>
        <div class="columns medium-6">
          <div style="text-align: right;">
            <p>
              {{\Carbon\Carbon::parse($fechaActual)->day
              .'/'. \Carbon\Carbon::parse($fechaActual)->formatLocalized('%b')
              .'/'. \Carbon\Carbon::parse($fechaActual)->year}}
            </p>
            <p>{{$horaActual}}</p>
            <p>{{$nombreArchivo}}</p>
          </div>
        </div>
      </div>
    </header>

    <footer id="footer">
      <div class="page-number"></div>
    </footer>

    @foreach ($cgts as $cgt)
      <div class="row">
        <div class="columns medium-12">
          <p>
            Período :
            {{\Carbon\Carbon::parse($cgt->periodo->perFechaInicial)->day
            .'/'. \Carbon\Carbon::parse($cgt->periodo->perFechaInicial)->formatLocalized('%b')
            .'/'. \Carbon\Carbon::parse($cgt->periodo->perFechaInicial)->year
            .'-'. \Carbon\Carbon::parse($cgt->periodo->perFechaFinal)->day
            .'/'. \Carbon\Carbon::parse($cgt->periodo->perFechaFinal)->formatLocalized('%b')
            .'/'. \Carbon\Carbon::parse($cgt->periodo->perFechaFinal)->year}}
          </p>
          <p>
            Niv/Carr: {{$cgt->plan->programa->progClave}}
            ({{$cgt->plan->planClave}})
            {{$cgt->plan->programa->progNombre}}
            <span style="margin-left: 20px;">Gdo/Sem: {{$cgt->cgtGradoSemestre}}</span>
            <span style="margin-left: 20px;">Grupo: {{$cgt->cgtGrupo}}</span>
          </p>
          <p>
            Ubicac. : {{$cgt->periodo->departamento->ubicacion->ubiClave}}
            {{$cgt->periodo->departamento->ubicacion->ubiNombre}}

            <span style="margin-left: 30px;">Calif.Min.Aprob: {{$cgt->plan->programa->escuela->departamento->depCalMinAprob}}</span>
          </p>
          <p>
            @if ($tipoCalificacion == "1P")
              Calificaciones del primer parcial
            @endif
            @if ($tipoCalificacion == "2P")
              Calificaciones del segundo parcial
            @endif
            @if ($tipoCalificacion == "3P")
              Calificaciones del tercer parcial
            @endif
            @if ($tipoCalificacion == "ORD")
              Calificaciones ordinario
            @endif
            @if ($tipoCalificacion == "FINAL")
              Calificacion final
            @endif
            Inscritos, preinscritos y condicionados
          </p>
        </div>
      </div>
      <div class="row">

        <div class="columns medium-12">
          <table class="table">
            <tr>
              <th align="center" style="font-weight: 400;">#</th>
              <th style="font-weight: 400; font-size: 10px;">Cve pago</th>
              <th style="font-weight: 400;" style="width: 120px;">Nombre del alumno</th>
              @foreach ($cgt->materias as $materia)
                <th style="font-weight: 400;">
                  {{$materia->matClave}}
                </th>
                @if ($incluyeFaltas && ($tipoCalificacion != "ORD" && $tipoCalificacion != "FINAL"))
                <th style="font-weight: 400;">
                  falt
                </th>
                @endif
              @endforeach
              <th style="font-weight: 400;">Prom</th>
              <th style="font-weight: 400;">Tot Fal</th>
              <th style="font-weight: 400;"></th>
            </tr>

            @php
              $promedioTotal = 0;
            @endphp
            @foreach ($cgt->inscritos as $inscrito)
              <tr>
                <td style="width: 5px; font-size: 10px;">{{$loop->iteration}}</td>
                <td style="width: 5px; font-size: 10px;">{{$inscrito->curso->alumno->aluClave}}</td>
                <td style="width: 120px; font-size: 10px;">
                  {{$inscrito->curso->alumno->persona->perApellido1}}
                  {{$inscrito->curso->alumno->persona->perApellido2}}
                  {{$inscrito->curso->alumno->persona->perNombre}}
                </td>
                @foreach ($cgt->materias as $materia)
                  @php
                    $calif = $cgt->grupoCalif->where("inscrito.curso.id", "=", $inscrito->curso->id)
                      ->where("inscrito.grupo.materia.id", "=", $materia->id)
                    ->first();
                  @endphp
                  <td style="">
                    @if ($tipoCalificacion == "1P" && $calif)
                      @if ($calif->inscCalificacionParcial1 < $cgt->plan->programa->escuela->departamento->depCalMinAprob)
                        <span>{{$calif->inscCalificacionParcial1}}</span>
                      @else
                        {{$calif->inscCalificacionParcial1}}
                      @endif
                    @endif

                    @if ($tipoCalificacion == "2P" && $calif)
                      @if ($calif->inscCalificacionParcial2 < $cgt->plan->programa->escuela->departamento->depCalMinAprob)
                        <span>{{$calif->inscCalificacionParcial2}}</span>
                      @else
                        {{$calif->inscCalificacionParcial2}}
                      @endif
                    @endif

                    @if ($tipoCalificacion == "3P" && $calif)
                      @if ($calif->inscCalificacionParcial3 < $cgt->plan->programa->escuela->departamento->depCalMinAprob)
                        <span>{{$calif->inscCalificacionParcial3}}</span>
                      @else
                        {{$calif->inscCalificacionParcial3}}
                      @endif
                    @endif

                    @if ($tipoCalificacion == "ORD" && $calif)
                      @if ($calif->inscCalificacionOrdinario < $cgt->plan->programa->escuela->departamento->depCalMinAprob)
                        <span>{{$calif->inscCalificacionOrdinario}}</span>
                      @else
                        {{$calif->inscCalificacionOrdinario}}
                      @endif
                    @endif

                    @if ($tipoCalificacion == "FINAL" && $calif)
                      @if ($calif->incsCalificacionFinal < $cgt->plan->programa->escuela->departamento->depCalMinAprob)
                        <span>{{$calif->incsCalificacionFinal}}</span>
                      @else
                        {{$calif->incsCalificacionFinal}}
                      @endif
                    @endif
                  </td>

                  @if ($incluyeFaltas && ($tipoCalificacion != "ORD" && $tipoCalificacion != "FINAL"))
                    <td style="">
                      @if ($calif)
                        @if ($tipoCalificacion == "1P" && $calif->inscFaltasParcial1 > 0)
                          {{$calif->inscFaltasParcial1}}
                        @endif
                        @if ($tipoCalificacion == "2P" && $calif->inscFaltasParcial2 > 0)
                          {{$calif->inscFaltasParcial2}}
                        @endif
                        @if ($tipoCalificacion == "3P" && $calif->inscFaltasParcial3 > 0)
                          {{$calif->inscFaltasParcial3}}
                        @endif
                      @endif
                    </td>
                  @endif
                @endforeach
                <td style="width: 5px;">
                  @php
                    $materiasInscrito = $cgt->grupoCalif->where("inscrito.curso.id", "=", $inscrito->curso->id);
                    $promedio = 0;
                    if ($tipoCalificacion == "1P"){
                      $promedio = round ($materiasInscrito->sum("inscCalificacionParcial1") / $materiasInscrito->count(), 3);
                    }
                    if ($tipoCalificacion == "2P"){
                      $promedio = round ($materiasInscrito->sum("inscCalificacionParcial2") / $materiasInscrito->count(), 3);
                    }
                    if ($tipoCalificacion == "3P") {
                      $promedio = round ($materiasInscrito->sum("inscCalificacionParcial3") / $materiasInscrito->count(), 3);
                    }
                    if ($tipoCalificacion == "ORD") {
                      $promedio = round ($materiasInscrito->sum("inscCalificacionOrdinario") / $materiasInscrito->count(), 3);
                    }
                    if ($tipoCalificacion == "FINAL") {
                      $promedio = round ($materiasInscrito->sum("incsCalificacionFinal") / $materiasInscrito->count(), 3);
                    }
                    $promedioTotal += $promedio;
                  @endphp

                  {{$promedio}}
                </td>
                <td style="width: 5px;">
                  <span>
                    @if ($tipoCalificacion == "1P" && $cgt->grupoCalif->where("inscrito.curso.id", "=", $inscrito->curso->id)->sum("inscFaltasParcial1") > 0)

                      {{$cgt->grupoCalif->where("inscrito.curso.id", "=", $inscrito->curso->id)->sum("inscFaltasParcial1")}}
                    @endif
                    @if ($tipoCalificacion == "2P" && $cgt->grupoCalif->where("inscrito.curso.id", "=", $inscrito->curso->id)->sum("inscFaltasParcial2") > 0)
                      {{$cgt->grupoCalif->where("inscrito.curso.id", "=", $inscrito->curso->id)->sum("inscFaltasParcial2")}}
                    @endif
                    @if ($tipoCalificacion == "3P" && $cgt->grupoCalif->where("inscrito.curso.id", "=", $inscrito->curso->id)->sum("inscFaltasParcial3") > 0)
                      {{$cgt->grupoCalif->where("inscrito.curso.id", "=", $inscrito->curso->id)->sum("inscFaltasParcial3")}}
                    @endif
                  </span>
                </td>
                <td>
                  {{$inscrito->curso->curEstado =="B" ? "Baj": ""}}
                  {{$inscrito->curso->curEstado =="A" || $inscrito->curso->curEstado =="C" ? "Con": ""}}
                  {{$inscrito->curso->curEstado =="P" ? "Pre": ""}}
                </td>
              </tr>

            @endforeach
            <tr>
              <td style="width: 5px; font-size: 10px;"></td>
              <td style="width: 5px; font-size: 10px;"></td>
              <td style="width: 120px; font-size: 12px;">
                Promedios del grupo
              </td>
              @foreach ($cgt->materias as $materia)
                @php
                  $totalCalifGrupo = $cgt->grupoCalif->where("inscrito.grupo.materia.id", "=", $materia->id);
                @endphp

                <td style="">
                  @if ($tipoCalificacion == "1P")
                    {{round ($totalCalifGrupo->sum("inscCalificacionParcial1")/$totalCalifGrupo->count(),3)}}
                  @endif
                  @if ($tipoCalificacion == "2P")
                    {{round($totalCalifGrupo->sum("inscCalificacionParcial2")/$totalCalifGrupo->count(),3)}}
                  @endif
                  @if ($tipoCalificacion == "3P")
                    {{round($totalCalifGrupo->sum("inscCalificacionParcial3")/$totalCalifGrupo->count(),3)}}
                  @endif
                  @if ($tipoCalificacion == "ORD")
                    {{round($totalCalifGrupo->sum("inscCalificacionOrdinario")/$totalCalifGrupo->count(),3)}}
                  @endif
                  @if ($tipoCalificacion == "FINAL")
                    {{round($totalCalifGrupo->sum("incsCalificacionFinal")/$totalCalifGrupo->count(),3)}}
                  @endif
                </td>
                @if ($incluyeFaltas && ($tipoCalificacion != "ORD" && $tipoCalificacion != "FINAL"))
                  <td style=""></td>
                @endif
              @endforeach
              <td style="width: 5px;">{{round($promedioTotal/$totalCalifGrupo->count(),3)}}</td>

            </tr>
          </table>
        </div>
      </div>
      @if(!$loop->last)
        <div class="page_break"></div>
      @endif
    @endforeach



    <footer id="footer">
      <div class="page-number"></div>
    </footer>
  </body>
</html>
