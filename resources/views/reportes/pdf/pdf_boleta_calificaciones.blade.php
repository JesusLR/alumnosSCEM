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
        top: -60px;
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
        margin-top: 70px;
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

      .move-content{
        page-break-after: always;
      }
    </style>
	</head>
  <body>
    <header>
      <div class="row">
        <div class="columns medium-12" align="center">
            <h3 style="margin-top:0px; margin-bottom: 10px;">UNIVERSIDAD MODELO</h3>
        <h5 syle="margin-top:0px; margin-bottom: 10px;">{{$programaNombre->progNombre}}</h5>
        <h5 syle="margin-top:0px; margin-bottom: 10px;">PERIODO ESCOLAR:   {{$periodo}}</h5>
        </div>
      </div>

    </header>

    @php
    $TotalFaltas1 = 0;
    $TotalFaltas2 = 0;
    $TotalFaltas3 = 0;
    @endphp

    @foreach ($calif as $item)
    @php
    $primero = $item->first();
    @endphp

    <div class="row">
      <div class="columns medium-6">
      <p style="margin-top:0px; margin-bottom: 10px;">Clave: {{$primero['aluClave']}}</p>
      <p style="margin-top:0px; margin-bottom: 10px;">Alumno: {{$primero['nombreCompleto']}}</p>
      </div>
      <div class="columns medium-6">
          <div style="text-align: right;">
          <p>Ubicación: {{$primero['ubiClave']}}</p>
          <p>{{ \Carbon\Carbon::parse($fechaActual)->format('d/m/Y') }}</p>
          <p>{{$primero['gpoSemestre']}}  {{$primero['gpoClave']}}</p>
          </div>
      </div>
    </div>


      <div class="row">
        <div class="columns medium-12">
          <table class="table">
            <tr>
              <th></th>
              <th align="center" style=" width: 200px;">ASIGNATURAS</th>
              <th align="center">Parc. 1 <br>Cal. Fal.</th>
              <th align="center">Parc. 2 <br>Cal. Fal.</th>
              <th align="center">Parc. 3 <br>Cal. Fal.</th>
              <th align="center">Prom. Parc.</th>
              <th align="center">Calif Ordi.</th>
              <th align="center">Calif Final</th>
            </tr>

            @if ($loop->last)
              <hr>
            @endif

            @foreach ($item as $calificacion)
              @php
                $TotalFaltas1 += $calificacion['calificacion']['inscFaltasParcial1'];
                $TotalFaltas2 += $calificacion['calificacion']['inscFaltasParcial2'];
                $TotalFaltas3 += $calificacion['calificacion']['inscFaltasParcial3'];
              @endphp
              <tr>
                <td>{{$calificacion['matClave']}}</td>
                <td style="width: 200px;">{{$calificacion['matNombre']}}</td>
                <td align="center">
                  @if ($calificacion['calificacion']['inscCalificacionParcial1'] <= 59)
                    <strong>{{$calificacion['calificacion']['inscCalificacionParcial1']}}</strong>
                  @else
                    {{$calificacion['calificacion']['inscCalificacionParcial1']}}@endif  -
                  @if ($calificacion['calificacion']['inscFaltasParcial1'] == 0) 0
                  @else
                    {{$calificacion['calificacion']['inscFaltasParcial1']}}
                  @endif
                </td>
                <td align="center">
                  @if ($calificacion['calificacion']['inscCalificacionParcial2'] <= 59)
                  <strong>{{$calificacion['calificacion']['inscCalificacionParcial2']}}</strong>
                  @else
                    {{$calificacion['calificacion']['inscCalificacionParcial2']}}@endif  -
                  @if ($calificacion['calificacion']['inscFaltasParcial2'] == 0) 0
                  @else
                  {{$calificacion['calificacion']['inscFaltasParcial2']}}
                  @endif
                </td>
                <td align="center">
                  @if ($calificacion['calificacion']['inscCalificacionParcial3'] <= 59)
                    <strong>{{$calificacion['calificacion']['inscCalificacionParcial3']}}</strong>
                  @else
                    {{$calificacion['calificacion']['inscCalificacionParcial3']}}@endif  -
                  @if ($calificacion['calificacion']['inscFaltasParcial3'] == 0) 0
                  @else
                    {{$calificacion['calificacion']['inscFaltasParcial3']}}
                  @endif
                </td>
                <td align="center">
                  @if ($calificacion['calificacion']['inscPromedioParciales'] <= 59)
                    <strong>{{$calificacion['calificacion']['inscPromedioParciales']}}</strong>
                  @else
                  {{$calificacion['calificacion']['inscPromedioParciales']}}@endif
                </td>
                <td align="center">
                  @if ($calificacion['calificacion']['inscCalificacionOrdinario'] <= 59)
                    <strong>{{$calificacion['calificacion']['inscCalificacionOrdinario']}}</strong>
                  @else
                  {{$calificacion['calificacion']['inscCalificacionOrdinario']}}@endif
                </td>
                <td align="center">
                  @if ($calificacion['calificacion']['incsCalificacionFinal'] <= 59)
                    @php
                      $inscCalificacionFinal = $calificacion['calificacion']['incsCalificacionFinal'];
                      if ($calificacion["calificacion"]->inscrito->grupo->materia->matTipoAcreditacion == "A") {
                        if ($calificacion['calificacion']['incsCalificacionFinal'] == 0) {
                          $inscCalificacionFinal = "A";
                        }

                        if ($calificacion['calificacion']['incsCalificacionFinal'] == 1) {
                          $inscCalificacionFinal = "R";
                        }
                      }
                    @endphp
                    <strong>{{$inscCalificacionFinal}}</strong>
                  @else
                  {{$calificacion['calificacion']['incsCalificacionFinal']}}@endif
                </td>
              </tr>
              @if ($loop->last)
                <hr>
              @endif
            @endforeach

            <tr>
              <td></td>
              <td align="right" style="width: 200px;">Total de faltas del parcial:</td>
              <td align="center">{{$TotalFaltas1}}</td>
              <td align="center">{{$TotalFaltas2}}</td>
              <td align="center">{{$TotalFaltas3}}</td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
          </table>
        </div>
      </div>
      @php
      $TotalFaltas1 = 0;
      $TotalFaltas2 = 0;
      $TotalFaltas3 = 0;
      @endphp
      <div class="row move-content">
          <div class="columns medium-12">
            <table class="table">
              <tr>
                <th></th>
                <th align="center" style=" width: 200px;">ASIGNATURAS ADEUDADAS</th>
                <th align="center">Ordi.</th>
                <th align="center">Ext 1</th>
                <th align="center">Ext 2</th>
                <th align="center">Ext 3</th>
                <th align="center">Espec</th>
                <th align="center">Ult. Examen</th>
              </tr>
              @foreach ($item as $historico)
              <tr>
                  <td>{{$historico['matHis']['matClave']}}</td>
                  <td align="center" style="width: 200px;">{{$historico['matHis']['matNombre']}}</td>
                  <td align="center">
                  @if ($historico['historico']['histCalificacion'] <= 59)


                  @php
                    $califOrdinario = $historico['historico']['histCalificacion'];
                    if ($calificacion["calificacion"]->inscrito->grupo->materia->matTipoAcreditacion == "A") {
                      if ($historico['historico']['histCalificacion'] == 0) {
                        $califOrdinario = "A";
                      }

                      if ($historico['historico']['histCalificacion'] == 1) {
                        $califOrdinario = "R";
                      }
                    }
                  @endphp
                  <strong>{{$califOrdinario}}</strong>

                  @else
                    {{$historico['historico']['histCalificacion']}}@endif
                  </td>
                  <td align="center">
                  @if ($historico['historicoEX1']['histCalificacion'] <= 59)

                    @php
                      $extUno = $historico['historicoEX1']['histCalificacion'];
                      if ($calificacion["calificacion"]->inscrito->grupo->materia->matTipoAcreditacion == "A") {
                        if ($historico['historicoEX1']['histCalificacion'] == 0) {
                          $extUno = "A";
                        }

                        if ($historico['historicoEX1']['histCalificacion'] == 1) {
                          $extUno = "R";
                        }
                      }
                    @endphp
                    <strong>{{$extUno}}</strong>

                  @else
                  {{$historico['historicoEX1']['histCalificacion']}}@endif
                  </td>
                  <td align="center">
                  @if ($historico['historicoEX2']['histCalificacion'] <= 59)

                    @php
                      $extDos = $historico['historicoEX2']['histCalificacion'];
                      if ($calificacion["calificacion"]->inscrito->grupo->materia->matTipoAcreditacion == "A") {
                        if ($historico['historicoEX2']['histCalificacion'] == 0) {
                          $extDos = "A";
                        }

                        if ($historico['historicoEX2']['histCalificacion'] == 1) {
                          $extDos = "R";
                        }
                      }
                    @endphp
                    <strong>{{$extDos}}</strong>

                  @else
                  {{$historico['historicoEX2']['histCalificacion']}}@endif
                  </td>
                  <td align="center">
                  @if ($historico['historicoEX3']['histCalificacion'] <= 59)

                    @php
                      $extTres = $historico['historicoEX3']['histCalificacion'];
                      if ($calificacion["calificacion"]->inscrito->grupo->materia->matTipoAcreditacion == "A") {
                        if ($historico['historicoEX3']['histCalificacion'] == 0) {
                          $extTres = "A";
                        }

                        if ($historico['historicoEX3']['histCalificacion'] == 1) {
                          $extTres = "R";
                        }
                      }
                    @endphp
                    <strong>{{$extTres}}</strong>

                  @else
                  {{$historico['historicoEX3']['histCalificacion']}}@endif
                  </td>
                  <td align="center">
                  @if ($historico['historicoEP1']['histCalificacion'] <= 59)

                    @php
                      $califEspecial = $historico['historicoEP1']['histCalificacion'];
                      if ($calificacion["calificacion"]->inscrito->grupo->materia->matTipoAcreditacion == "A") {
                        if ($historico['historicoEP1']['histCalificacion'] == 0) {
                          $califEspecial = "A";
                        }

                        if ($historico['historicoEP1']['histCalificacion'] == 1) {
                          $califEspecial = "R";
                        }
                      }
                    @endphp
                    <strong>{{$califEspecial}}</strong>
                  @else
                  {{$historico['historicoEP1']['histCalificacion']}}@endif
                  </td>
                  <td align="center">
                    @if ($historico['historicoEX3'] != NULL)
                    {{$historico['historicoEX3']['histFechaExamen']}}
                    @elseif($historico['historicoEX2'] != NULL)
                    {{$historico['historicoEX2']['histFechaExamen']}}
                    @elseif($historico['historicoEX1'] != NULL)
                    {{$historico['historicoEX1']['histFechaExamen']}}
                    @elseif($historico['historico'] != NULL)
                    {{$historico['historico']['histFechaExamen']}}
                    @endif
                  </td>
                </tr>
              @endforeach
            </table>
          </div>
        </div>
      @endforeach

    <footer id="footer">
      <div class="page-number"></div>
    </footer>
  </body>
</html>
