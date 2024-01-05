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
        top: -110px;
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
        margin-top:120px;
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
        <div class="columns medium-12">
          <h4 style="margin-top:0px; margin-bottom: 10px; font-weight: 400; text-align:center;">ESCUELA MODELO, S.C.P.</h4>
          <h4 style="margin-top:0px; margin-bottom: 10px; font-weight: 400; text-align:center;">RELACION DE GRUPOS</h4>
          <h4 style="margin-top:0px; margin-bottom: 10px; font-weight: 400; text-align:center;">CAMPUS MERIDA O PASEO MONTEJO</h4>
          <p style="margin-top:0px; margin-bottom: 10px; font-weight: 400; text-align:center;">
            Nota: La columna TOT incluye Oyentes porque el estado (INSC,PRE,COND,COND2)<br>
            es una condición diferente a su estado academico (PI,RI,EQ,OY)
          </p>
        </div>
      </div>


      <div class="row" style="margin-top: -110px">
        <div class="columns medium-12">
          <p style="text-align:right;">{{ \Carbon\Carbon::parse($fechaActual)->format('d/m/Y') }}</p>
          <p style="text-align:right;">{{$horaActual}}</p>
          <p style="text-align:right;">{{$nombreArchivo}}</p>
        </div>
      </div>
    </header>


    <footer id="footer">
      <div class="page-number"></div>
    </footer>
    @php
      $maternal = $programas->where("programa.programa.escuela.departamento.depClave", "MAT")->first();
      $preprimaria = $programas->where("programa.programa.escuela.departamento.depClave", "PRE")->first();
      $primaria = $programas->where("programa.programa.escuela.departamento.depClave", "PRI")->first();
      $secundaria = $programas->where("programa.programa.escuela.departamento.depClave", "SEC")->first();
      $bachillerato = $programas->where("programa.programa.escuela.departamento.depClave", "BAC")->first();

      $superior = $programas->where("programa.programa.escuela.departamento.depClave", "SUP")->filter(function ($item, $key) {
        $res = ($item->cantInscritos + $item->cantPreinscritos
        + $item->cantCond + $item->cantCondDos + $item->total
        + $item->cantOyentes + $item->cantGruposCgt
        + $item->aluInscritosEntreGrupo + $item->horasDocentes);
        return $res > 0;
      });


      $posgrado = $programas->where("programa.programa.escuela.departamento.depClave", "POS")->filter(function ($item, $key) {
        $res = ($item->cantInscritos + $item->cantPreinscritos
        + $item->cantCond + $item->cantCondDos + $item->total
        + $item->cantOyentes + $item->cantGruposCgt
        + $item->aluInscritosEntreGrupo + $item->horasDocentes);
        return $res > 0;
      });

      // $totalBasicoCantInscritos = $maternal->cantInscritos + $preprimaria->cantInscritos +
      //   $primaria->cantInscritos + $secundaria->cantInscritos + $bachillerato->cantInscritos;
      $totalBasicoCantInscritos = 0;

      // $totalBasicoCantPreinscritos = $maternal->cantPreinscritos + $preprimaria->cantPreinscritos +
      //   $primaria->cantPreinscritos + $secundaria->cantPreinscritos + $bachillerato->cantPreinscritos;

      $totalBasicoCantPreinscritos = 0;

      // $totalBasicoCantCond = $maternal->cantCond + $preprimaria->cantCond +
      //   $primaria->cantCond + $secundaria->cantCond + $bachillerato->cantCond;
      $totalBasicoCantCond = 0;

      // $totalBasicoCantCondDos = $maternal->cantCondDos + $preprimaria->cantCondDos +
      //   $primaria->cantCondDos + $secundaria->cantCondDos + $bachillerato->cantCondDos;
      $totalBasicoCantCondDos = 0;

      // $totalBasicoTotal = $maternal->aluInscritosEntreGrupo + $preprimaria->aluInscritosEntreGrupo +
      //   $primaria->aluInscritosEntreGrupo + $secundaria->aluInscritosEntreGrupo + $bachillerato->aluInscritosEntreGrupo;
      $totalBasicoTotal = 0;

      // $totalBasicoCantOyentes = $maternal->cantOyentes + $preprimaria->cantOyentes +
      //   $primaria->cantOyentes + $secundaria->cantOyentes + $bachillerato->cantOyentes;
      $totalBasicoCantOyentes = 0;

      // $totalBasicoCantGruposCgt = $maternal->cantGruposCgt + $preprimaria->cantGruposCgt +
      //   $primaria->cantGruposCgt + $secundaria->cantGruposCgt + $bachillerato->cantGruposCgt;
      $totalBasicoCantGruposCgt = 0;

      // $totalBasicoAluInscritosEntreGrupo = $maternal->aluInscritosEntreGrupo + $preprimaria->aluInscritosEntreGrupo +
      //   $primaria->aluInscritosEntreGrupo + $secundaria->aluInscritosEntreGrupo + $bachillerato->aluInscritosEntreGrupo;
      $totalBasicoAluInscritosEntreGrupo = 0;

      // $totalBasicoHorasDocentes = $maternal->horasDocentes + $preprimaria->horasDocentes +
      //   $primaria->horasDocentes + $secundaria->horasDocentes + $bachillerato->horasDocentes;
      $totalBasicoHorasDocentes = 0;

      $totalPosCantInscritos    = $posgrado->sum("cantInscritos");
      $totalPosCantPreinscritos = $posgrado->sum("cantPreinscritos");
      $totalPosCantCond         = $posgrado->sum("cantCond");
      $totalPosCantCondDos      = $posgrado->sum("cantCondDos");
      $totalPosTotal            = $posgrado->sum("total");
      $totalPosCantOyentes      = $posgrado->sum("cantOyentes");
      $totalPosCantGruposCgt    = $posgrado->sum("cantGruposCgt");
      $totalPosAluInscritosEntreGrupo = (int) round($totalPosCantInscritos / $totalPosCantGruposCgt);
      $totalPosHorasDocentes    = $posgrado->sum("horasDocentes");

      $totalSupCantInscritos    = $superior->sum("cantInscritos");
      $totalSupCantPreinscritos = $superior->sum("cantPreinscritos");
      $totalSupCantCond         = $superior->sum("cantCond");
      $totalSupCantCondDos      = $superior->sum("cantCondDos");
      $totalSupTotal            = $superior->sum("total");
      $totalSupCantOyentes      = $superior->sum("cantOyentes");
      $totalSupCantGruposCgt    = $superior->sum("cantGruposCgt");
      $totalSupAluInscritosEntreGrupo = (int) round($totalSupCantInscritos / $totalSupCantGruposCgt);
      $totalSupHorasDocentes    = $superior->sum("horasDocentes");
    @endphp


    <!--<div class="row">
      <div class="columns medium-12">
        <table class="table">
          <tr>
            <th style="font-weight: 400;">NIVEL</th>
            <th align="center" style="font-weight: 400;">INSC</th>
            <th align="center" style="font-weight: 400;">PRE</th>
            <th align="center" style="font-weight: 400;">COND</th>
            <th align="center" style="font-weight: 400;">COND2</th>
            <th align="center" style="font-weight: 400;">TOT</th>
            <th align="center" style="font-weight: 400;">OYE</th>
            <th align="center" style="font-weight: 400;">GRP</th>
            <th align="center" style="font-weight: 400;">AI/GRP</th>
            <th align="center" style="font-weight: 400;">HDOC</th>
          </tr>

          <tr>
            <td style="width: 400px;">MATERNAL</td>
            <td align="center">{{--$maternal->cantInscritos--}} 0</td>
            <td align="center">{{--$maternal->cantPreinscritos--}} 0</td>
            <td align="center">{{--$maternal->cantCond--}} 0</td>
            <td align="center">{{--$maternal->cantCondDos--}} 0</td>
            <td align="center">{{--$maternal->total--}} 0</td>
            <td align="center">{{--$maternal->cantOyentes--}} 0</td>
            <td align="center">{{--$maternal->cantGruposCgt--}} 0</td>
            <td align="center">{{--$maternal->aluInscritosEntreGrupo--}} 0</td>
            <td align="center">{{--$maternal->horasDocentes--}} 0</td>
          </tr>
          <tr>
            <td style="width: 400px;">PREPRIMARIA</td>
            <td align="center">{{--$preprimaria->cantInscritos--}} 0</td>
            <td align="center">{{--$preprimaria->cantPreinscritos--}} 0</td>
            <td align="center">{{--$preprimaria->cantCond--}} 0</td>
            <td align="center">{{--$preprimaria->cantCondDos--}} 0</td>
            <td align="center">{{--$preprimaria->total--}} 0</td>
            <td align="center">{{--$preprimaria->cantOyentes--}} 0</td>
            <td align="center">{{--$preprimaria->cantGruposCgt--}} 0</td>
            <td align="center">{{--$preprimaria->aluInscritosEntreGrupo--}} 0</td>
            <td align="center">{{--$preprimaria->horasDocentes--}} 0</td>
          </tr>
          <tr>
            <td style="width: 400px;">PRIMARIA</td>
            <td align="center">{{--$primaria->cantInscritos--}} 0</td>
            <td align="center">{{--$primaria->cantPreinscritos--}} 0</td>
            <td align="center">{{--$primaria->cantCond--}} 0</td>
            <td align="center">{{--$primaria->cantCondDos--}} 0</td>
            <td align="center">{{--$primaria->total--}} 0</td>
            <td align="center">{{--$primaria->cantOyentes--}} 0</td>
            <td align="center">{{--$primaria->cantGruposCgt--}} 0</td>
            <td align="center">{{--$primaria->aluInscritosEntreGrupo--}} 0</td>
            <td align="center">{{--$primaria->horasDocentes--}} 0</td>
          </tr>
          <tr>
            <td style="width: 400px;">SECUNDARIA</td>
            <td align="center">{{--$secundaria->cantInscritos--}} 0</td>
            <td align="center">{{--$secundaria->cantPreinscritos--}} 0</td>
            <td align="center">{{--$secundaria->cantCond--}} 0</td>
            <td align="center">{{--$secundaria->cantCondDos--}} 0</td>
            <td align="center">{{--$secundaria->total--}} 0</td>
            <td align="center">{{--$secundaria->cantOyentes--}} 0</td>
            <td align="center">{{--$secundaria->cantGruposCgt--}} 0</td>
            <td align="center">{{--$secundaria->aluInscritosEntreGrupo--}} 0</td>
            <td align="center">{{--$secundaria->horasDocentes--}} 0</td>
          </tr>
          <tr>
            <td style="width: 400px;">BACHILLERATO</td>
            <td align="center">{{--$bachillerato->cantInscritos--}} 0</td>
            <td align="center">{{--$bachillerato->cantPreinscritos--}} 0</td>
            <td align="center">{{--$bachillerato->cantCond--}} 0</td>
            <td align="center">{{--$bachillerato->cantCondDos--}} 0</td>
            <td align="center">{{--$bachillerato->total--}} 0</td>
            <td align="center">{{--$bachillerato->cantOyentes--}} 0</td>
            <td align="center">{{--$bachillerato->cantGruposCgt--}} 0</td>
            <td align="center">{{--$bachillerato->aluInscritosEntreGrupo--}} 0</td>
            <td align="center">{{--$bachillerato->horasDocentes--}} 0</td>
          </tr>
          <tr>
            <td style="width: 400px; font-weight: 700;">TOTAL</td>
            <td align="center">{{--$totalBasicoCantInscritos--}} 0</td>
            <td align="center">{{--$totalBasicoCantPreinscritos--}} 0</td>
            <td align="center">{{--$totalBasicoCantCond--}} 0</td>
            <td align="center">{{--$totalBasicoCantCondDos--}} 0</td>
            <td align="center">{{--$totalBasicoTotal--}} 0</td>
            <td align="center">{{--$totalBasicoCantOyentes--}} 0</td>
            <td align="center">{{--$totalBasicoCantGruposCgt--}} 0</td>
            <td align="center">{{--$totalBasicoAluInscritosEntreGrupo--}} 0</td>
            <td align="center">{{--$totalBasicoHorasDocentes--}} 0</td>
          </tr>
        </table>
      </div>
    </div>-->

    <div class="row" style="margin-top: 20px;">
      <div class="columns medium-12">
        <table class="table">
          <tr>
            <th style="font-weight: 400;">SUPERIOR</th>
            <th align="center" style="font-weight: 400;">INSC</th>
            <th align="center" style="font-weight: 400;">PRE</th>
            <th align="center" style="font-weight: 400;">COND</th>
            <th align="center" style="font-weight: 400;">COND2</th>
            <th align="center" style="font-weight: 400;">TOT</th>
            <th align="center" style="font-weight: 400;">OYE</th>
            <th align="center" style="font-weight: 400;">GRP</th>
            <th align="center" style="font-weight: 400;">AI/GRP</th>
            <th align="center" style="font-weight: 400;">HDOC</th>
          </tr>
          @foreach ($superior as $sup)
            <tr>
              <td style="width: 400px;">{{$sup->programa->programa->progNombre}}</td>
              <td align="center"></td>
              <td align="center"></td>
              <td align="center"></td>
              <td align="center"></td>
              <td align="center"></td>
              <td align="center"></td>
              <td align="center"></td>
              <td align="center"></td>
              <td align="center"></td>
            </tr>
            @foreach($sup->cgt as $cgt)
              @php
                $inscritos = $cgt->where("curEstado", "R")->count();
                $preinscritos = $cgt->where("curEstado", "P")->count();
                $cond = $cgt->where("curEstado", "C")->count();
                $condDos = $cgt->where("curEstado", "A")->count();
                $total = $inscritos + $preinscritos + $cond + $condDos;
                $oyentes = $cgt->where("curTipoIngreso", "OY")->count();
              @endphp
              <tr>
                <td style="width: 400px;">{{$cgt->first()->cgt->cgtGradoSemestre}}{{$cgt->first()->cgt->cgtGrupo}}</td>
                <td align="center">{{$inscritos}}</td>
                <td align="center">{{$preinscritos}}</td>
                <td align="center">{{$cond}}</td>
                <td align="center">{{$condDos}}</td>
                <td align="center">{{$total}}</td>
                <td align="center">{{$oyentes}}</td>
                <td align="center"></td>
                <td align="center"></td>
                <td align="center"></td>
              </tr>
            @endforeach
            <tr>
              <td style="width: 400px;">TOTAL {{$sup->programa->programa->progNombre}}</td>
              <td align="center" >{{$sup->cantInscritos}}</td>
              <td align="center" >{{$sup->cantPreinscritos}}</td>
              <td align="center">{{$sup->cantCond}}</td>
              <td align="center">{{$sup->cantCondDos}}</td>
              <td align="center">{{$sup->total}}</td>
              <td align="center">{{$sup->cantOyentes}}</td>
              <td align="center">{{$sup->cantGruposCgt}}</td>
              <td align="center">{{$sup->aluInscritosEntreGrupo}}</td>
              <td align="center">{{$sup->horasDocentes}}</td>
            </tr>
            <tr>
              <td style="width: 400px;"></td>
              <td align="center" ><br></td>
              <td align="center" ></td>
              <td align="center"></td>
              <td align="center"></td>
              <td align="center"></td>
              <td align="center"></td>
              <td align="center"></td>
              <td align="center"></td>
              <td align="center"></td>
            </tr>
          @endforeach
          <tr>
            <td style="width: 400px; font-weight: 700;">TOTAL</td>
            <td align="center" >{{$totalSupCantInscritos}}</td>
            <td align="center" >{{$totalSupCantPreinscritos}}</td>
            <td align="center">{{$totalSupCantCond}}</td>
            <td align="center">{{$totalSupCantCondDos}}</td>
            <td align="center">{{$totalSupTotal}}</td>
            <td align="center">{{$totalSupCantOyentes}}</td>
            <td align="center">{{$totalSupCantGruposCgt}}</td>
            <td align="center">{{$totalSupAluInscritosEntreGrupo}}</td>
            <td align="center">{{$totalSupHorasDocentes}}</td>
          </tr>
        </table>
      </div>
    </div>






    <div class="row" style="margin-top: 20px;">
      <div class="columns medium-12">
        <table class="table">
          <tr>
            <th style="font-weight: 400;">POSGRADO</th>
            <th align="center" style="font-weight: 400;">INSC</th>
            <th align="center" style="font-weight: 400;">PRE</th>
            <th align="center" style="font-weight: 400;">COND</th>
            <th align="center" style="font-weight: 400;">COND2</th>
            <th align="center" style="font-weight: 400;">TOT</th>
            <th align="center" style="font-weight: 400;">OYE</th>
            <th align="center" style="font-weight: 400;">GRP</th>
            <th align="center" style="font-weight: 400;">AI/GRP</th>
            <th align="center" style="font-weight: 400;">HDOC</th>
          </tr>

          @foreach ($posgrado as $pos)
            <tr>
              <td style="width: 400px;">{{$pos->programa->programa->progNombre}}</td>
              <td align="center" ></td>
              <td align="center" ></td>
              <td align="center"></td>
              <td align="center"></td>
              <td align="center"></td>
              <td align="center"></td>
              <td align="center"></td>
              <td align="center"></td>
              <td align="center"></td>
            </tr>
            @foreach($pos->cgt as $cgt)
              @php
                $inscritos = $cgt->where("curEstado", "R")->count();
                $preinscritos = $cgt->where("curEstado", "P")->count();
                $cond = $cgt->where("curEstado", "C")->count();
                $condDos = $cgt->where("curEstado", "A")->count();
                $total = $inscritos + $preinscritos + $cond + $condDos;
                $oyentes = $cgt->where("curTipoIngreso", "OY")->count();
              @endphp
              <tr>
                <td style="width: 400px;">{{$cgt->first()->cgt->cgtGradoSemestre}}{{$cgt->first()->cgt->cgtGrupo}}</td>
                <td align="center">{{$inscritos}}</td>
                <td align="center">{{$preinscritos}}</td>
                <td align="center">{{$cond}}</td>
                <td align="center">{{$condDos}}</td>
                <td align="center">{{$total}}</td>
                <td align="center">{{$oyentes}}</td>
                <td align="center"></td>
                <td align="center"></td>
                <td align="center"></td>
              </tr>
            @endforeach
            <tr>
              <td style="width: 400px;">TOTAL {{$pos->programa->programa->progNombre}}</td>
              <td align="center" >{{$pos->cantInscritos}}</td>
              <td align="center" >{{$pos->cantPreinscritos}}</td>
              <td align="center">{{$pos->cantCond}}</td>
              <td align="center">{{$pos->cantCondDos}}</td>
              <td align="center">{{$pos->total}}</td>
              <td align="center">{{$pos->cantOyentes}}</td>
              <td align="center">{{$pos->cantGruposCgt}}</td>
              <td align="center">{{$pos->aluInscritosEntreGrupo}}</td>
              <td align="center">{{$pos->horasDocentes}}</td>
            </tr>
            <tr>
              <td style="width: 400px;"></td>
              <td align="center" ><br></td>
              <td align="center" ></td>
              <td align="center"></td>
              <td align="center"></td>
              <td align="center"></td>
              <td align="center"></td>
              <td align="center"></td>
              <td align="center"></td>
              <td align="center"></td>
            </tr>
          @endforeach
          <tr>
            <td style="width: 400px; font-weight: 700;">TOTAL</td>
            <td align="center" >{{$totalPosCantInscritos}}</td>
            <td align="center" >{{$totalPosCantPreinscritos}}</td>
            <td align="center">{{$totalPosCantCond}}</td>
            <td align="center">{{$totalPosCantCondDos}}</td>
            <td align="center">{{$totalPosTotal}}</td>
            <td align="center">{{$totalPosCantOyentes}}</td>
            <td align="center">{{$totalPosCantGruposCgt}}</td>
            <td align="center">{{$totalPosAluInscritosEntreGrupo}}</td>
            <td align="center">{{$totalPosHorasDocentes}}</td>
          </tr>
        </table>
      </div>
    </div>


    <div class="row" style="margin-top: 20px;">
      <div class="columns medium-12">
        <table class="table">
          <tr>
            <th style="font-weight: 400;"></th>
            <th align="center" style="font-weight: 400;">INSC</th>
            <th align="center" style="font-weight: 400;">PRE</th>
            <th align="center" style="font-weight: 400;">COND</th>
            <th align="center" style="font-weight: 400;">COND2</th>
            <th align="center" style="font-weight: 400;">TOT</th>
            <th align="center" style="font-weight: 400;">OYE</th>
            <th align="center" style="font-weight: 400;">GRP</th>
            <th align="center" style="font-weight: 400;">AI/GRP</th>
            <th align="center" style="font-weight: 400;">HDOC</th>
          </tr>
          <tr>
            <td style="font-weight: 700; width: 400px;">GRAN TOTAL</td>
            <td align="center" style="font-weight: 400;">{{$totalBasicoCantInscritos + $totalPosCantInscritos + $totalSupCantInscritos}}</td>
            <td align="center" style="font-weight: 400;">{{$totalBasicoCantPreinscritos + $totalPosCantPreinscritos + $totalSupCantPreinscritos}}</td>
            <td align="center" style="font-weight: 400;">{{$totalBasicoCantCond + $totalPosCantCond + $totalSupCantCond}}</td>
            <td align="center" style="font-weight: 400;">{{$totalBasicoCantCondDos + $totalPosCantCondDos + $totalSupCantCondDos}}</td>
            <td align="center" style="font-weight: 400;">{{$totalBasicoTotal + $totalPosTotal + $totalSupTotal}}</td>
            <td align="center" style="font-weight: 400;">{{$totalBasicoCantOyentes + $totalPosCantOyentes + $totalSupCantOyentes}}</td>
            <td align="center" style="font-weight: 400;">{{$totalBasicoCantGruposCgt + $totalPosCantGruposCgt + $totalSupCantGruposCgt}}</td>
            <td align="center" style="font-weight: 400;">{{$totalBasicoAluInscritosEntreGrupo + $totalPosAluInscritosEntreGrupo + $totalSupAluInscritosEntreGrupo}}</td>
            <td align="center" style="font-weight: 400;">{{$totalBasicoHorasDocentes + $totalPosHorasDocentes + $totalSupHorasDocentes}}</td>
          </tr>
        </table>
      </div>
    </div>

    <footer id="footer">
      <div class="page-number"></div>
    </footer>
  </body>
</html>
