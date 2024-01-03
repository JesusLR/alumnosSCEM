@php
    $becaPorcentaje = null;
@endphp

<div class="row">
      {{-- septiembre, octubre, noviembre --}}
      @foreach (($pago->slice(0,3)) as $item)
      <div class="columns medium-4">
        <div style="height: 145px; width: 75%; position: relative; border: 1px solid #000; padding: 10px; margin: 0 auto;">
          <p style="text-align: center; font-weight: 700; margin-bottom: 10px;">{{$item->titulo}}</p>
          @if ($item->estado == "PAGADO")
            <p style="text-align:center;font-weight: 700; margin-bottom: 10px;">{{$item->estado}}</p>
            <p style="text-align:center;margin-bottom: 10px;">${{ number_format($item->importe1, 2, '.', ',')}}</p>
            <p style="text-align:center;margin-bottom: 10px;">{{$item->fecha1Formato}}</p>
          @endif
          @if ($item->estado == "NO APLICA" || $item->estado == "PENDIENTE POR EMITIR")
            <p style="text-align:center;font-weight: 700; margin-bottom: 10px;">{{ $item->estado }}</p>
          @endif
          @if ($item->estado == "DEBE")
            @if (!is_null($item->importe1))
              <p style="font-size: 14px;">Vence  {{$item->fecha1Formato}} ${{number_format($item->importe1, 2, '.', ',')}}</p>
              <p style="margin-bottom: 10px; font-size: 14px;"> <span style="font-weight:700;">{{$item->referenciaPago1}}</span></p>
            @endif
            @if (!is_null($item->importe2))
              <p style="font-size: 14px;">Vence  {{$item->fecha2Formato}} ${{number_format($item->importe2, 2, '.', ',')}}</p>
              <p style="margin-bottom: 10px; font-size: 14px;"> <span style="font-weight:700;">{{$item->referenciaPago2}}</span> </p>
            @endif
            @if (!is_null($item->importe3))
              <p style="font-size: 14px;">Vence  {{$item->fecha3Formato}} ${{number_format($item->importe3, 2, '.', ',')}}</p>
              <p style="font-size: 14px;"> <span style="font-weight:700;">{{$item->referenciaPago3}}</span> </p>
            @endif
          @endif
        </div>
      </div>
        @php
            $becaPorcentaje = $item->porcBeca;
        @endphp
      @endforeach
</div>


<div class="row" style="margin-top: 8px; margin-bottom: 8px;">
    {{--
      <p style="text-align: center; font-weight: 700;">* * *  NO REALIZAR COBRO SI NO ESTÁ PAGADO EL MES ANTERIOR * * *</p>
    --}}
    <p style="text-align: center; font-weight: 700;">* * *  UTILIZAR SIEMPRE LA REFERENCIA CORRESPONDIENTE AL MES * * *</p>
    @if ($becaPorcentaje != null)
            <p style="text-align: center; font-weight: 700;">* * * EL MONTO DE LA BECA ES VÁLIDO ÚNICAMENTE EN LOS PRIMEROS 15 DÍAS DE CADA MES * * *</p>
    @endif
</div>


<div class="row">
  {{-- diciembre, enero --}}
  @foreach (($pago->slice(3,2)) as $item)
  <div class="columns medium-4">
    <div style="height: 145px; width: 75%; position: relative; border: 1px solid #000; padding: 10px; margin: 0 auto;">
      <p style="text-align: center; font-weight: 700; margin-bottom: 10px;">{{$item->titulo}}</p>
      @if ($item->estado == "PAGADO")
        <p style="text-align:center;font-weight: 700; margin-bottom: 10px;">{{$item->estado}}</p>
        <p style="text-align:center;margin-bottom: 10px;">${{ number_format($item->importe1, 2, '.', ',')}}</p>
        <p style="text-align:center;margin-bottom: 10px;">{{$item->fecha1Formato}}</p>
      @endif
      @if ($item->estado == "NO APLICA"  || $item->estado == "PENDIENTE POR EMITIR")
        <p style="text-align:center;font-weight: 700; margin-bottom: 10px;">{{ $item->estado }}</p>
      @endif
      @if ($item->estado == "DEBE")
        @if (!is_null($item->importe1))
          <p style="font-size: 14px;">Vence  {{$item->fecha1Formato}} ${{number_format($item->importe1, 2, '.', ',')}}</p>
          <p style="margin-bottom: 10px; font-size: 14px;"> <span style="font-weight:700;">{{$item->referenciaPago1}}</span> </p>
        @endif
        @if (!is_null($item->importe2))
          <p style="font-size: 14px;">Vence  {{$item->fecha2Formato}} ${{number_format($item->importe2, 2, '.', ',')}}</p>
          <p style="margin-bottom: 10px; font-size: 14px;"> <span style="font-weight:700;">{{$item->referenciaPago2}}</span> </p>
        @endif
        @if (!is_null($item->importe3))
          <p style="font-size: 14px;">Vence  {{$item->fecha3Formato}} ${{number_format($item->importe3, 2, '.', ',')}}</p>
          <p style="font-size: 14px;"> <span style="font-weight:700;">{{$item->referenciaPago3}}</span> </p>
        @endif

      @endif
    </div>
  </div>
        @php
            $becaPorcentaje = $item->porcBeca;
        @endphp
  @endforeach

  @php
    $inscripcion = $pago->where("celda", "=", 6)->first();
  @endphp

  <div class="columns medium-4">
    <div style="height: 145px; width: 75%; position: relative; border: 1px solid #000; padding: 10px;  margin: 0 auto;">
      <p style="text-align: center; font-weight: 700; margin-bottom: 10px;">{{$inscripcion->titulo}}</p>

      @if ($inscripcion->estado == "NO APLICA"  || $inscripcion->estado == "PENDIENTE POR EMITIR")
        <p style="text-align:center;font-weight: 700; margin-bottom: 10px;">{{ $inscripcion->estado }}</p>
      @else
        @if ($inscripcion->planPago == "A" || $inscripcion->ubiClave == "CVA")
          <p style="text-align:center;font-weight: 700; margin-bottom: 10px;">NO APLICA</p>
        @endif
      @endif

      @if ($inscripcion->planPago == "N" && $inscripcion->ubiClave != "CVA")
        @if ($inscripcion->estado == "PAGADO")
          <p style="text-align:center;font-weight: 700; margin-bottom: 10px;">PAGADO</p>
          <p style="text-align:center;margin-bottom: 10px;">${{$inscripcion->importe1}}</p>
          <p style="text-align:center;margin-bottom: 10px;">
            @php
              $fecha = Carbon\Carbon::parse($inscripcion->fecha1);
              $fecha = sprintf('%02d', $fecha->day) . "/" . App\Http\Helpers\Utils::num_meses_corto_string($fecha->month) . "/" . $fecha->year;
            @endphp
            {{$fecha}}
          </p>
        @endif

        @if ($inscripcion->estado == "DEBE")
          @if (!is_null($inscripcion->importe1))
            <p style="font-size: 14px;">Vence  {{$inscripcion->fecha1Formato}} ${{number_format($inscripcion->importe1, 2, '.', ',')}}</p>
            <p style="margin-bottom: 10px; font-size: 14px;"> <span style="font-weight:700;">{{$inscripcion->referencia1}}</span> </p>
          @endif

          {{-- OCULTAMOS LAS OTRAS 2 REFERENCIAS DE INSCRIPCION DE ENERO --}}
              {{--
              @if (!is_null($inscripcion->importe2))
                <p style="font-size: 14px;">Vence  {{$inscripcion->fecha2Formato}} ${{number_format($inscripcion->importe2, 2, '.', ',')}}</p>
                <p style="margin-bottom: 10px; font-size: 14px;"> <span style="font-weight:700;">{{$inscripcion->referencia2}}</span> </p>
              @endif

              @if (!is_null($inscripcion->importe3))
                <p style="font-size: 14px;">Vence  {{$inscripcion->fecha3Formato}} ${{number_format($inscripcion->importe3, 2, '.', ',')}}</p>
                <p style="font-size: 14px;"> <span style="font-weight:700;">{{$inscripcion->referencia3}}</span> </p>
              @endif

              --}}
        @endif
      @endif
    </div>
  </div>
</div>


<div class="row" style="margin-top: 8px; margin-bottom: 8px;">
    {{--
      <p style="text-align: center; font-weight: 700;">* * *  NO REALIZAR COBRO SI NO ESTÁ PAGADO EL MES ANTERIOR * * *</p>
    --}}
    <p style="text-align: center; font-weight: 700;">* * *  UTILIZAR SIEMPRE LA REFERENCIA CORRESPONDIENTE AL MES * * *</p>
    @if ($becaPorcentaje != null)
            <p style="text-align: center; font-weight: 700;">* * * EL MONTO DE LA BECA ES VÁLIDO ÚNICAMENTE EN LOS PRIMEROS 15 DÍAS DE CADA MES * * *</p>
    @endif
</div>


{{-- febrero, marzo, abril --}}
<div class="row">
  @foreach (($pago->slice(6,3)) as $item)
  <div class="columns medium-4">
    <div style="height: 145px; width: 75%; position: relative; border: 1px solid #000; padding: 10px; margin: 0 auto;">
      <p style="text-align: center; font-weight: 700; margin-bottom: 10px;">{{$item->titulo}}</p>

        @if ($item->estado == "NO APLICA"  || $item->estado == "PENDIENTE POR EMITIR")
            <p style="text-align:center;font-weight: 700; margin-bottom: 10px;">{{ $item->estado }}</p>
        @endif

      @if ($item->estado == "PAGADO")
        <p style="text-align:center;font-weight: 700; margin-bottom: 10px;">{{$item->estado}}</p>
        <p style="text-align:center;margin-bottom: 10px;">${{ number_format($item->importe1, 2, '.', ',')}}</p>
        <p style="text-align:center;margin-bottom: 10px;">{{$item->fecha1Formato}}</p>
      @endif
      @if ($item->estado == "DEBE")
        {{--
        @if (!is_null($item->tipoBeca) && $item->porcBeca == 100)
          <p style="text-align:center;font-weight: 700; margin-bottom: 10px;">NO APLICA</p>
        @else
        --}}
          @if (!is_null($item->importe1))
            <p style="font-size: 14px;">Vence  {{$item->fecha1Formato}} ${{number_format($item->importe1, 2, '.', ',')}}</p>
            <p style="margin-bottom: 10px; font-size: 14px;"> <span style="font-weight:700;">{{$item->referenciaPago1}}</span> </p>
          @endif
          @if (!is_null($item->importe2))
            <p style="font-size: 14px;">Vence  {{$item->fecha2Formato}} ${{number_format($item->importe2, 2, '.', ',')}}</p>
            <p style="margin-bottom: 10px; font-size: 14px;"> <span style="font-weight:700;">{{$item->referenciaPago2}}</span> </p>
          @endif
          @if (!is_null($item->importe3))
            <p style="font-size: 14px;">Vence  {{$item->fecha3Formato}} ${{number_format($item->importe3, 2, '.', ',')}}</p>
            <p style="font-size: 14px;"> <span style="font-weight:700;">{{$item->referenciaPago3}}</span></p>
          @endif
          {{--
        @endif
        --}}
      @endif
    </div>
  </div>
        @php
            $becaPorcentaje = $item->porcBeca;
        @endphp
  @endforeach
</div>



<div class="row" style="margin-top: 8px; margin-bottom: 8px;">
    {{--
      <p style="text-align: center; font-weight: 700;">* * *  NO REALIZAR COBRO SI NO ESTÁ PAGADO EL MES ANTERIOR * * *</p>
    --}}
    <p style="text-align: center; font-weight: 700;">* * *  UTILIZAR SIEMPRE LA REFERENCIA CORRESPONDIENTE AL MES * * *</p>
    @if ($becaPorcentaje != null)
                <p style="text-align: center; font-weight: 700;">* * * EL MONTO DE LA BECA ES VÁLIDO ÚNICAMENTE EN LOS PRIMEROS 15 DÍAS DE CADA MES * * *</p>
    @endif
</div>



<div class="row">
  {{-- mayo, junio --}}
  @foreach (($pago->slice(9,2)) as $item)
  <div class="columns medium-4">
    <div style="height: 145px; width: 75%; position: relative; border: 1px solid #000; padding: 10px; margin: 0 auto;">
      <p style="text-align: center; font-weight: 700; margin-bottom: 10px;">{{$item->titulo}}</p>

        @if ($item->estado == "NO APLICA"  || $item->estado == "PENDIENTE POR EMITIR")
            <p style="text-align:center;font-weight: 700; margin-bottom: 10px;">{{ $item->estado }}</p>
        @endif

      @if ($item->estado == "PAGADO")
        <p style="text-align:center;font-weight: 700; margin-bottom: 10px;">{{$item->estado}}</p>
        <p style="text-align:center;margin-bottom: 10px;">${{ number_format($item->importe1, 2, '.', ',')}}</p>
        <p style="text-align:center;margin-bottom: 10px;">{{$item->fecha1Formato}}</p>
      @endif
      @if ($item->estado == "DEBE")
            {{--
          @if (!is_null($item->tipoBeca) && $item->porcBeca == 100)
            <p style="text-align:center;font-weight: 700; margin-bottom: 10px;">NO APLICA</p>
          @else
          --}}
            @if (!is_null($item->importe1))
              <p style="font-size: 14px;">Vence  {{$item->fecha1Formato}} ${{number_format($item->importe1, 2, '.', ',')}}</p>
              <p style="margin-bottom: 10px; font-size: 14px;"> <span style="font-weight:700;">{{$item->referenciaPago1}}</span> </p>
            @endif
            @if (!is_null($item->importe2))
              <p style="font-size: 14px;">Vence  {{$item->fecha2Formato}} ${{number_format($item->importe2, 2, '.', ',')}}</p>
              <p style="margin-bottom: 10px; font-size: 14px;"> <span style="font-weight:700;">{{$item->referenciaPago2}}</span> </p>
            @endif
            @if (!is_null($item->importe3))
              <p style="font-size: 14px;">Vence  {{$item->fecha3Formato}} ${{number_format($item->importe3, 2, '.', ',')}}</p>
              <p style="font-size: 14px;"> <span style="font-weight:700;">{{$item->referenciaPago3}}</span> </p>
            @endif
            {{--
          @endif
          --}}
        @endif
      </div>
    </div>
        @php
            $becaPorcentaje = $item->porcBeca;
        @endphp
    @endforeach

    @php
      $convenio = $pago->where("celda", "=", 12)->first();
    @endphp

    <div class="columns medium-4">
      <div style="height: 145px; width: 75%; position: relative; border: 1px solid #000; padding: 10px; margin: 0 auto;">
          <p style="text-align: center;margin-bottom: 10px; font-weight: 900;">DE BBVA A BBVA</p>
          <p style="text-align: center;margin-bottom: 30px; font-weight: 900;">CONVENIO 1852132</p>
          <p style="text-align: center;margin-bottom: 10px; font-weight: 900;">DE OTRO BANCO A BBVA</p>
          <p style="text-align: center;margin-bottom: 10px; font-weight: 900;">CLABE INTERBANCARIA</p>
          <p style="text-align: center; font-weight: 900;">012914002018521323</p>
      </div>
    </div>
  </div>


  <div class="row" style="margin-top: 8px; margin-bottom: 8px;">
    <div class="columns medium-12">
      {{--
          <p style="text-align: center; font-weight: 700;">* * *  NO REALIZAR COBRO SI NO ESTÁ PAGADO EL MES ANTERIOR * * *</p>
      --}}
        <p style="text-align: center; font-size: 14px; font-weight: 700;">
          Razón Social: ESCUELA MODELO
        </p>
        <p style="text-align: center; font-size: 14px; font-weight: 700;">
          RFC: EMO100510EW5
        </p>
        {{--
        <p style="text-align: center; font-weight: 700;">* * *  UTILIZAR SIEMPRE LA REFERENCIA CORRESPONDIENTE AL MES * * *</p>
        --}}
        @if ($becaPorcentaje != null)
        {{--<p style="text-align: center; font-weight: 700;">* * * EL MONTO DE LA BECA ES VÁLIDO ÚNICAMENTE EN LOS PRIMEROS 15 DÍAS DE CADA MES * * *</p>--}}
        @endif
    </div>
</div>


@php
  $datosGenerales = $pago->first();
@endphp


<div class="row" style="margin-top: 8px; margin-bottom: 8px;">
  <div class="columns medium-12">
  <p style="text-align: center; font-weight: 700;">CURSO ESCOLAR {{$datosGenerales->anioCuota}} - {{$datosGenerales->anioCuota + 1}}</p>
  </div>
</div>

<div class="row" style="margin-top: 8px; margin-bottom: 8px; margin-left: 0px; margin-right: 0px;">
  <div class="columns medium-6">
    <p><span style="font-weight: 700;">Programa:</span> {{$datosGenerales->progNombre}}</p>
    <p><span style="font-weight: 700;" for="">Alumno:</span>
      {{$datosGenerales->clavePago}} {{$datosGenerales->nombre}}
    </p>
    <p>
      <span style="font-weight: 700;" for="">Grado:</span> {{$datosGenerales->grado}}° {{$datosGenerales->grupo}}
      <span style="font-weight: 700;" for="">Ubic.</span>
      {{$datosGenerales->ubiClave}}
      {{$datosGenerales->ubiNombre}}
    </p>
  </div>


  @if ($datosGenerales->planPago == "N")
    <div class="columns medium-6">
      <div style="float:right;">
        <p>
          Plan de 10 pagos.
          @if (!is_null($datosGenerales->curAnioCuotas))
            Gen: {{$datosGenerales->curAnioCuotas}}
          @endif
        </p>
        <p>
          {{$fechaActualFormatoTarjeta}} {{$horaActual}} v19
          @if ($datosGenerales->tipoBeca && $datosGenerales->porcBeca)
            <span style="font-weight: 700;">{{$datosGenerales->tipoBeca}}{{$datosGenerales->porcBeca}}</span>
          @endif
        </p>
      </div>
    </div>
  @endif

  @if ($datosGenerales->planPago == "A")
    <div class="columns medium-6">
      <div style="float:right;">
        <p>
          Aplica Ant/Cred:
          @php
            // $inscripcionAnticipoCredito = (Double) $inscripcion->importeInscripcion / 10;
            // $inscripcionAnticipoCredito = (string) number_format($inscripcionAnticipoCredito, 2, ".", "");
          @endphp
          ${{(string) number_format($datosGenerales->prorrateo, 2, ".", "")}}
          @if (!is_null($datosGenerales->curAnioCuotas))
          Gen: {{$datosGenerales->curAnioCuotas}}
          @endif
        </p>
        <p>
          {{$fechaActualFormatoTarjeta}} {{$horaActual}} v19
          @if ($datosGenerales->tipoBeca && $datosGenerales->porcBeca)
            <span style="font-weight: 700;">{{$datosGenerales->tipoBeca}}{{$datosGenerales->porcBeca}}</span>
          @endif
        </p>
      </div>
    </div>
  @endif
</div>

<div class="row" style="margin-top: 8px; margin-bottom: 8px;">
    <p style="text-align: left; font-weight: 700;font-size: 1em;text-decoration: underline;">INSTRUCCIONES DE PAGO.</p>
    <p style="text-align: left; font-weight: 700;">I. PAGO DIRECTO EN SUCURSAL BANCARIA BBVA:</p>
    <p style="text-align: left; font-weight: 400;">1-SI PAGA EN VENTANILLA DE SUCURSAL BANCARIA BBVA, UTILICE EL CONVENIO 1852132</p>
    <p style="text-align: left; font-weight: 400;">2-SI PAGA EN CAJERO AUTOMÁTICO BBVA, SELECCIONE PAGO DE SERVICIO CON EL CONVENIO 1852132</p>
    <p style="text-align: left; font-weight: 700;">II. PAGO EN LÍNEA (APLICACIÓN ó PORTAL WEB BANCARIO):</p>
    <p style="text-align: left; font-weight: 400;">A) SI PAGA DE BBVA A BBVA (DESDE SU PORTAL BANCARIO BBVA), UTILICE PAGO DE SERVICIO CON EL CONVENIO 1852132</p>
    <p style="text-align: left; font-weight: 400;">B) DESDE OTRO BANCO A BBVA (SPEI), USAR LA CLABE INTERBANCARIA 012914002018521323</p>
</div>

