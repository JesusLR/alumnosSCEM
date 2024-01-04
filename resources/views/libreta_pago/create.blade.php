@extends('layouts.dashboard')

@section('template_title')
    Libreta de Pago
@endsection

@section('head')

@endsection

@section('breadcrumbs')
    <a href="" class="breadcrumb">Inicio</a>
    <label class="breadcrumb">Libreta de pago</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12">
        <div class="card ">
          <div class="card-content ">

            <div class="row">
              <div class="col s12 m12 l12">
                <span class="card-title">LIBRETA DE PAGO</span>

                  @if ($filtroTarjetaPago->curEstado == "R")

                      @if ($DEFINE_PRORRATEO_LIBRETA_PAGO)

                        {{--  se valida si trae registro  --}}
                        @if ($userAlumnoPlanPago != "")


                            @if ($userAlumnoPlanPago->ubicacion != "CME" || $userAlumnoPlanPago->depClave == "POS")
                                @if ($motrar_libreta == "I")
                                <p>Estimado alumno(a): A partir del 4 de Septiembre de 2023, estará a tu disposición la descarga de la libreta de pago de colegiaturas e inscripción
                                    para el ciclo escolar 2023-2024.
                                </p>
                                <hr>
                                @endif
                            @else
                                @if ($userAlumnoPlanPago->ubicacion == "CME" && $userAlumnoPlanPago->puedeCambiardePlan == "NO" && $motrar_libreta == "I")
                                    <p>Estimado alumno(a): A partir del 4 de Septiembre de 2023, estará a tu disposición la descarga de la libreta de pago de colegiaturas e inscripción
                                        para el ciclo escolar 2023-2024.
                                        <br>Tu plan de pago seleccionado:
                                        @if ($userAlumnoPlanPago->curPlanPago == "N")
                                            <span style="font-weight: bold; color:blue;"> Colegiatura Diez Meses, y la Inscripción de Enero a pagarse el monto total en el mes de Enero de 2024.</span>
                                        @endif
                                        @if ($userAlumnoPlanPago->curPlanPago == "A")
                                            <span style="font-weight: bold; color:blue;"> Pago prorrateado de Inscripción de Enero, se divide en 10 parcialidades y se suma a cada mensualidad.</span>
                                        @endif
                                        @if ($userAlumnoPlanPago->curPlanPago == "D")
                                            <span style="font-weight: bold; color:blue;"> Colegiatura Doce Meses.</span>
                                        @endif
                                        @if ($userAlumnoPlanPago->curPlanPago == "O")
                                            <span style="font-weight: bold; color:blue;"> Colegiatura Once Meses.</span>
                                        @endif
                                    </p>
                                    <hr>
                                @endif

                                @if ($userAlumnoPlanPago->ubicacion == "CME" && $userAlumnoPlanPago->puedeCambiardePlan == "SI")
                                    <p>Estimado alumno(a): A partir del 4 de Septiembre de 2023, estará a tu disposición la descarga de la libreta de pago de colegiaturas e inscripción
                                        para el ciclo escolar 2023-2024.
                                        <br>Debido a lo anterior, es necesario que verifiques en esta pantalla, cuál es tu plan de pago seleccionado.
                                    </p>
                                    <hr>
                                    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)', 'route' => 'libretapago.update', 'method' => 'POST']) !!}
                                    <div class="row">
                                        <div class="col s12 m6 l6">
                                            <p>Puedes ajustar el plan de pago de tu inscripción del siguiente semestre (hasta el viernes 1 de Septiembre de 2023).</p>
                                            <p>Los 2 tipos de planes de pago de tu inscripción son:</p>
                                            <p style="margin-left: 15px;">1 - Pago de contado del monto total de la inscripción, a pagarse en los primeros 20 días del mes de Enero de 2024 (sin prorrateo).</p>
                                            <p style="margin-left: 15px;">2 - Pago prorrateado dividido en 10 parcialidades y cada parcialidad se suma al monto total de la colegiatura mensual.</p>
                                            <p>A continuación te mostramos un ejemplo de cada uno de los planes de pago.</p>
                                            <img src="{{url('/images/ej_prerrorateo.jpg')}}" alt="">
                                            <p style="color:black;font-weight: bold;">¿Desea cambiar de plan de pago?</p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col s12 m6 l6">
                                            <select id="plan_pago" class="browser-default validate select2" required name="plan_pago" style="width: 100%;">
                                                <option value="N" {{$userAlumnoPlanPago->curPlanPago == "N" ? "selected": ""}}>1 - Pago de contado del monto total de la inscripción</option>
                                                <option value="A" {{$userAlumnoPlanPago->curPlanPago == "A" ? "selected": ""}}>2 - Pago prorrateado dividido en 10 parcialidades</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col s12 m6 l6">
                                            <p style="color:#f0084a;font-weight: bold;">Importante: Una vez actualizado el plan de pago, no podrá modificarse por esta vía online. Sólo se podrá modificar, comunicándose a la brevedad:
                                                <br>Coordinación administrativa | Tel.: 999 - 9301900 ext. 1151  o al celular 999 135 6225 | Email: coordinacion.administrativa@modelo.edu.mx</p>
                                            <br>
                                            {!! Form::button('Actualizar Plan de Pago', ['class' => 'btn-large waves-effect  darken-3 submit-button','type' => 'submit']) !!}
                                        </div>
                                    </div>
                                    {!! Form::close() !!}
                                @endif

                            @endif


                        @endif



                      @endif

                      {{--  aqui   --}}
                      @if (!$DEFINE_PRORRATEO_LIBRETA_PAGO || $filtroTarjetaPago->depClave == "MAT" || $filtroTarjetaPago->depClave == "PRE" || $filtroTarjetaPago->depClave == "PRI" || $filtroTarjetaPago->depClave == "SEC" || $filtroTarjetaPago->depClave == "BAC")
                          @if ($filtroTarjetaPago->depClave == "MAT" || $filtroTarjetaPago->depClave == "PRE" || $filtroTarjetaPago->depClave == "PRI"
                              || $filtroTarjetaPago->depClave == "SEC" || $filtroTarjetaPago->depClave == "BAC")
                              <p>
                                  <span style="font-weight: bold;">Estimado(a) padre/madre de familia: Aquí puedes descargar la libreta de pago de las colegiaturas.</span>
                              </p>

                              @if ($filtroTarjetaPago->ubicacion == "CME")
                                  <br><p><i>Cualquier duda ó aclaración, favor de comunicarse al área de contabilidad de la Escuela Modelo.</i></p>
                                  <br><p><i>Susana Valencia | Tel.: 999 - 9279833 ext. 118  o al 999 - 9279916 | Email: svalencia@modelo.edu.mx</i></p>
                              @endif

                              @if ($filtroTarjetaPago->ubicacion == "CVA")
                                  <br><p><i>Cualquier duda ó aclaración, favor de comunicarse a la oficina de Control Escolar de la Escuela Modelo.</i></p>
                                  <br><p><i>Mariana Tuz | Tel.: 985 - 8561572 | Email: mtuz@modelo.edu.mx</i></p>
                                  <br><p><i>María Carrillo | Tel.: 985 - 8561572 | Email: maria.carrillo@modelo.edu.mx</i></p>
                              @endif
                              {{-- --}}

                          @endif

                          @if ($filtroTarjetaPago->depClave == "SUP" || $filtroTarjetaPago->depClave == "POS")
                              <p>
                                  <span style="font-weight: bold;">Estimado(a) alumno(a): Aquí puedes descargar tu libreta de pago acorde a tu plan de pago previamente registrado:</span>
                                  @if ($filtroTarjetaPago->curPlanPago == "N")
                                      <span style="font-weight: bold; color:blue;"> Colegiatura Diez Meses, y la Inscripción de Enero a pagarse el monto total en el mes de Enero.</span>
                                  @endif
                                  @if ($filtroTarjetaPago->curPlanPago == "A")
                                      <span style="font-weight: bold; color:blue;"> Pago prorrateado de Inscripción de Enero, se divide en 10 parcialidades y se suma a cada mensualidad.</span>
                                  @endif
                                  @if ($filtroTarjetaPago->curPlanPago == "D")
                                      <span style="font-weight: bold; color:blue;"> Colegiatura Doce Meses.</span>
                                  @endif
                                  @if ($filtroTarjetaPago->curPlanPago == "O")
                                      <span style="font-weight: bold; color:blue;"> Colegiatura Once Meses.</span>
                                  @endif
                              </p>

                              @if ($filtroTarjetaPago->ubicacion == "CME")
                                  <br><p><i>Cualquier duda ó aclaración, favor de comunicarte a la Coordinación Administrativa de la Universidad Modelo.</i></p>
                                  <br><p><i>Coordinación administrativa | Tel.: 999 - 9301900 ext. 1151  o al celular 999 135 6225 | Email: coordinacion.administrativa@modelo.edu.mx</i></p>
                              @endif

                              @if ($filtroTarjetaPago->ubicacion == "CVA")
                                  <br><p><i>Cualquier duda ó aclaración, favor de comunicarse a la oficina de Control Escolar de la Universidad Modelo.</i></p>
                                  <br><p><i>Mariana Tuz | Tel.: 985 - 8561572 | Email: mtuz@modelo.edu.mx</i></p>
                                  <br><p><i>María Carrillo | Tel.: 985 - 8561572 | Email: maria.carrillo@modelo.edu.mx</i></p>
                              @endif

                              @if ($filtroTarjetaPago->ubicacion == "CCH")
                                  <br><p><i>Cualquier duda ó aclaración, favor de comunicarse al área de control de pagos y becas del departamento de control escolar de la Universidad Modelo.</i></p>
                                  <br><p><i>Área de control de pagos y becas | Tel.: 983 - 6882211 ext. 115  o al 983 - 6882216 ext. 115 | Email: pagoscch@modelo.edu.mx</i></p>
                              @endif

                          @endif


                      @else

                       {{--  COMIENZA DEFINE_PRORRATEO_LIBRETA_PAGO CUANDO ESTA ACTIVO PERO LA LIBRETA DE PAGO ESTA ACTIVO Y EL ALUMNO YA SELECCIONO SU MODO DE PAGO  --}}
                        @if ($filtroTarjetaPago->depClave == "SUP" || $filtroTarjetaPago->depClave == "POS")

                            {{--  para SUP   --}}
                            @if ($motrar_libreta == "A" && $userAlumnoPlanPago->puedeCambiardePlan == "NO" && $filtroTarjetaPago->ubicacion == "CME" && $filtroTarjetaPago->depClave == "SUP")
                                <p>
                                    <span style="font-weight: bold;">Estimado(a) alumno(a): Aquí puedes descargar tu libreta de pago acorde a tu plan de pago previamente registrado:</span>
                                    @if ($filtroTarjetaPago->curPlanPago == "N")
                                        <span style="font-weight: bold; color:blue;"> Colegiatura Diez Meses, y la Inscripción de Enero a pagarse el monto total en el mes de Enero.</span>
                                    @endif
                                    @if ($filtroTarjetaPago->curPlanPago == "A")
                                        <span style="font-weight: bold; color:blue;"> Pago prorrateado de Inscripción de Enero, se divide en 10 parcialidades y se suma a cada mensualidad.</span>
                                    @endif
                                    @if ($filtroTarjetaPago->curPlanPago == "D")
                                        <span style="font-weight: bold; color:blue;"> Colegiatura Doce Meses.</span>
                                    @endif
                                    @if ($filtroTarjetaPago->curPlanPago == "O")
                                        <span style="font-weight: bold; color:blue;"> Colegiatura Once Meses.</span>
                                    @endif
                                </p>
                            @endif

                            {{--  para POS   --}}
                            @if ($motrar_libreta == "A" && $filtroTarjetaPago->ubicacion == "CME" && $filtroTarjetaPago->depClave == "POS")
                                <p>
                                    <span style="font-weight: bold;">Estimado(a) alumno(a): Aquí puedes descargar tu libreta de pago acorde a tu plan de pago previamente registrado:</span>
                                    @if ($filtroTarjetaPago->curPlanPago == "N")
                                        <span style="font-weight: bold; color:blue;"> Colegiatura Diez Meses, y la Inscripción de Enero a pagarse el monto total en el mes de Enero.</span>
                                    @endif
                                    @if ($filtroTarjetaPago->curPlanPago == "A")
                                        <span style="font-weight: bold; color:blue;"> Pago prorrateado de Inscripción de Enero, se divide en 10 parcialidades y se suma a cada mensualidad.</span>
                                    @endif
                                    @if ($filtroTarjetaPago->curPlanPago == "D")
                                        <span style="font-weight: bold; color:blue;"> Colegiatura Doce Meses.</span>
                                    @endif
                                    @if ($filtroTarjetaPago->curPlanPago == "O")
                                        <span style="font-weight: bold; color:blue;"> Colegiatura Once Meses.</span>
                                    @endif
                                </p>
                            @endif

                            {{--  PARA CVA   --}}
                            @if ($filtroTarjetaPago->ubicacion == "CVA" && $motrar_libreta == "A")
                                <p>
                                    <span style="font-weight: bold;">Estimado(a) alumno(a): Aquí puedes descargar tu libreta de pago acorde a tu plan de pago previamente registrado:</span>
                                    @if ($filtroTarjetaPago->curPlanPago == "N")
                                        <span style="font-weight: bold; color:blue;"> Colegiatura Diez Meses, y la Inscripción de Enero a pagarse el monto total en el mes de Enero.</span>
                                    @endif
                                    @if ($filtroTarjetaPago->curPlanPago == "A")
                                        <span style="font-weight: bold; color:blue;"> Pago prorrateado de Inscripción de Enero, se divide en 10 parcialidades y se suma a cada mensualidad.</span>
                                    @endif
                                    @if ($filtroTarjetaPago->curPlanPago == "D")
                                        <span style="font-weight: bold; color:blue;"> Colegiatura Doce Meses.</span>
                                    @endif
                                    @if ($filtroTarjetaPago->curPlanPago == "O")
                                        <span style="font-weight: bold; color:blue;"> Colegiatura Once Meses.</span>
                                    @endif
                                </p>
                            @endif

                            {{--  PARA CCH   --}}
                            @if ($filtroTarjetaPago->ubicacion == "CCH" && $motrar_libreta == "A")
                                <p>
                                    <span style="font-weight: bold;">Estimado(a) alumno(a): Aquí puedes descargar tu libreta de pago acorde a tu plan de pago previamente registrado:</span>
                                    @if ($filtroTarjetaPago->curPlanPago == "N")
                                        <span style="font-weight: bold; color:blue;"> Colegiatura Diez Meses, y la Inscripción de Enero a pagarse el monto total en el mes de Enero.</span>
                                    @endif
                                    @if ($filtroTarjetaPago->curPlanPago == "A")
                                        <span style="font-weight: bold; color:blue;"> Pago prorrateado de Inscripción de Enero, se divide en 10 parcialidades y se suma a cada mensualidad.</span>
                                    @endif
                                    @if ($filtroTarjetaPago->curPlanPago == "D")
                                        <span style="font-weight: bold; color:blue;"> Colegiatura Doce Meses.</span>
                                    @endif
                                    @if ($filtroTarjetaPago->curPlanPago == "O")
                                        <span style="font-weight: bold; color:blue;"> Colegiatura Once Meses.</span>
                                    @endif
                                </p>
                            @endif


                            @if ($motrar_libreta == "A" && $filtroTarjetaPago->ubicacion == "CME")
                                <br><p><i>Cualquier duda ó aclaración, favor de comunicarte a la Coordinación Administrativa de la Universidad Modelo.</i></p>
                                <br><p><i>Coordinación administrativa | Tel.: 999 - 9301900 ext. 1151  o al celular 999 135 6225 | Email: coordinacion.administrativa@modelo.edu.mx</i></p>
                            @endif

                            @if ($motrar_libreta == "A" && $filtroTarjetaPago->ubicacion == "CVA")
                                <br><p><i>Cualquier duda ó aclaración, favor de comunicarse a la oficina de Control Escolar de la Universidad Modelo.</i></p>
                                <br><p><i>Mariana Tuz | Tel.: 985 - 8561572 | Email: mtuz@modelo.edu.mx</i></p>
                                <br><p><i>María Carrillo | Tel.: 985 - 8561572 | Email: maria.carrillo@modelo.edu.mx</i></p>
                            @endif

                            @if ($motrar_libreta == "A" && $filtroTarjetaPago->ubicacion == "CCH")
                                <br><p><i>Cualquier duda ó aclaración, favor de comunicarse al área de control de pagos y becas del departamento de control escolar de la Universidad Modelo.</i></p>
                                <br><p><i>Área de control de pagos y becas | Tel.: 983 - 6882211 ext. 115  o al 983 - 6882216 ext. 115 | Email: pagoscch@modelo.edu.mx</i></p>
                            @endif

                        @endif
                       {{--  FINALIZA  --}}
                      @endif

                  @endif



                  @if ($filtroTarjetaPago->curEstado == "P" )

                    {{--  aqui   --}}
                      @if (!$DEFINE_PRORRATEO_LIBRETA_PAGO || $filtroTarjetaPago->depClave == "MAT" || $filtroTarjetaPago->depClave == "PRE" || $filtroTarjetaPago->depClave == "PRI" || $filtroTarjetaPago->depClave == "SEC" || $filtroTarjetaPago->depClave == "BAC")
                          @if ($filtroTarjetaPago->depClave == "MAT" || $filtroTarjetaPago->depClave == "PRE"
                                || $filtroTarjetaPago->depClave == "PRI"
                              || $filtroTarjetaPago->depClave == "SEC"
                              || $filtroTarjetaPago->depClave == "BAC")
                              <p>
                                  <span style="font-weight: bold;">Estimado(a) padre/madre de familia: Actualmente no tenemos registrado el pago de su inscripción.</span>
                              </p>

                              @if ($filtroTarjetaPago->ubicacion == "CME")
                                  <br><p><i>Cualquier duda ó aclaración, favor de comunicarse al área de contabilidad de la Escuela Modelo.</i></p>
                                  <br><p><i>Susana Valencia | Tel.: 999 - 9279833 ext. 118  o al 999 - 9279916 | Email: svalencia@modelo.edu.mx</i></p>
                              @endif

                              @if ($filtroTarjetaPago->ubicacion == "CVA")
                                  <br><p><i>Cualquier duda ó aclaración, favor de comunicarse a la oficina de Control Escolar de la Escuela Modelo.</i></p>
                                  <br><p><i>Mariana Tuz | Tel.: 985 - 8561572 | Email: mtuz@modelo.edu.mx</i></p>
                                  <br><p><i>María Carrillo | Tel.: 985 - 8561572 | Email: maria.carrillo@modelo.edu.mx</i></p>
                              @endif
                              {{-- --}}

                          @endif

                          @if ($filtroTarjetaPago->depClave == "SUP" || $filtroTarjetaPago->depClave == "POS")

                                  @if ( $cursoEstadoRegularPerAnte == "NO" )

                                      <p>
                                          <span style="font-weight: bold;">Estimado(a) alumno(a): Actualmente no tenemos registrado el pago de su inscripción.</span>
                                      </p>

                                      @if ($filtroTarjetaPago->ubicacion == "CME")
                                          <br><p><i>Cualquier duda ó aclaración, favor de comunicarte a la Coordinación Administrativa de la Universidad Modelo.</i></p>
                                          <br><p><i>Coordinación administrativa | Tel.: 999 - 9301900 ext. 1151  o al celular 999 135 6225 | Email: coordinacion.administrativa@modelo.edu.mx</i></p>
                                      @endif

                                      @if ($filtroTarjetaPago->ubicacion == "CVA")
                                          <br><p><i>Cualquier duda ó aclaración, favor de comunicarse a la oficina de Control Escolar de la Universidad Modelo.</i></p>
                                          <br><p><i>Mariana Tuz | Tel.: 985 - 8561572 | Email: mtuz@modelo.edu.mx</i></p>
                                          <br><p><i>María Carrillo | Tel.: 985 - 8561572 | Email: maria.carrillo@modelo.edu.mx</i></p>
                                      @endif

                                      @if ($filtroTarjetaPago->ubicacion == "CCH")
                                          <br><p><i>Cualquier duda ó aclaración, favor de comunicarse al área de control de pagos y becas del departamento de control escolar de la Universidad Modelo.</i></p>
                                          <br><p><i>Área de control de pagos y becas | Tel.: 983 - 6882211 ext. 115  o al 983 - 6882216 ext. 115 | Email: pagoscch@modelo.edu.mx</i></p>
                                      @endif

                                  @else

                                      {{-- PARA ALUMNOS SUP O POS DEL PERIODO 1 QUE ESTAN REGULARES EN PERIODO 3 --}}

                                          @if ($filtroTarjetaPago->ubicacion == "CME" && $motrar_libreta == "A")
                                          <p>
                                            <span style="font-weight: bold;">Estimado(a) alumno(a): Aquí puedes descargar tu libreta de pago acorde a tu plan de pago previamente registrado:</span>
                                            @if ($filtroTarjetaPago->curPlanPago == "N")
                                                <span style="font-weight: bold; color:blue;"> Colegiatura Diez Meses, y la Inscripción de Enero a pagarse el monto total en el mes de Enero.</span>
                                            @endif
                                            @if ($filtroTarjetaPago->curPlanPago == "A")
                                                <span style="font-weight: bold; color:blue;"> Pago prorrateado de Inscripción de Enero, se divide en 10 parcialidades y se suma a cada mensualidad.</span>
                                            @endif
                                            @if ($filtroTarjetaPago->curPlanPago == "D")
                                                <span style="font-weight: bold; color:blue;"> Colegiatura Doce Meses.</span>
                                            @endif
                                            @if ($filtroTarjetaPago->curPlanPago == "O")
                                                <span style="font-weight: bold; color:blue;"> Colegiatura Once Meses.</span>
                                            @endif
                                        </p>

                                              <br><p><i>Cualquier duda ó aclaración, favor de comunicarte a la Coordinación Administrativa de la Universidad Modelo.</i></p>
                                              <br><p><i>Coordinación administrativa | Tel.: 999 - 9301900 ext. 1151  o al celular 999 135 6225 | Email: coordinacion.administrativa@modelo.edu.mx</i></p>
                                          @endif

                                          @if ($filtroTarjetaPago->ubicacion == "CVA" && $motrar_libreta == "A")
                                          <p>
                                            <span style="font-weight: bold;">Estimado(a) alumno(a): Aquí puedes descargar tu libreta de pago acorde a tu plan de pago previamente registrado:</span>
                                            @if ($filtroTarjetaPago->curPlanPago == "N")
                                                <span style="font-weight: bold; color:blue;"> Colegiatura Diez Meses, y la Inscripción de Enero a pagarse el monto total en el mes de Enero.</span>
                                            @endif
                                            @if ($filtroTarjetaPago->curPlanPago == "A")
                                                <span style="font-weight: bold; color:blue;"> Pago prorrateado de Inscripción de Enero, se divide en 10 parcialidades y se suma a cada mensualidad.</span>
                                            @endif
                                            @if ($filtroTarjetaPago->curPlanPago == "D")
                                                <span style="font-weight: bold; color:blue;"> Colegiatura Doce Meses.</span>
                                            @endif
                                            @if ($filtroTarjetaPago->curPlanPago == "O")
                                                <span style="font-weight: bold; color:blue;"> Colegiatura Once Meses.</span>
                                            @endif
                                        </p>

                                              <br><p><i>Cualquier duda ó aclaración, favor de comunicarse a la oficina de Control Escolar de la Universidad Modelo.</i></p>
                                              <br><p><i>Mariana Tuz | Tel.: 985 - 8561572 | Email: mtuz@modelo.edu.mx</i></p>
                                              <br><p><i>María Carrillo | Tel.: 985 - 8561572 | Email: maria.carrillo@modelo.edu.mx</i></p>
                                          @endif

                                          @if ($filtroTarjetaPago->ubicacion == "CCH" && $motrar_libreta == "A")
                                          <p>
                                            <span style="font-weight: bold;">Estimado(a) alumno(a): Aquí puedes descargar tu libreta de pago acorde a tu plan de pago previamente registrado:</span>
                                            @if ($filtroTarjetaPago->curPlanPago == "N")
                                                <span style="font-weight: bold; color:blue;"> Colegiatura Diez Meses, y la Inscripción de Enero a pagarse el monto total en el mes de Enero.</span>
                                            @endif
                                            @if ($filtroTarjetaPago->curPlanPago == "A")
                                                <span style="font-weight: bold; color:blue;"> Pago prorrateado de Inscripción de Enero, se divide en 10 parcialidades y se suma a cada mensualidad.</span>
                                            @endif
                                            @if ($filtroTarjetaPago->curPlanPago == "D")
                                                <span style="font-weight: bold; color:blue;"> Colegiatura Doce Meses.</span>
                                            @endif
                                            @if ($filtroTarjetaPago->curPlanPago == "O")
                                                <span style="font-weight: bold; color:blue;"> Colegiatura Once Meses.</span>
                                            @endif
                                        </p>
                                              <br><p><i>Cualquier duda ó aclaración, favor de comunicarse al área de control de pagos y becas del departamento de control escolar de la Universidad Modelo.</i></p>
                                              <br><p><i>Área de control de pagos y becas | Tel.: 983 - 6882211 ext. 115  o al 983 - 6882216 ext. 115 | Email: pagoscch@modelo.edu.mx</i></p>
                                          @endif


                                  @endif



                          @endif


                      @endif


                  @endif


              </div>
            </div>

            {{--  aqui   --}}
            @if ($filtroTarjetaPago->curEstado == "R")
                @if (!$DEFINE_PRORRATEO_LIBRETA_PAGO || $filtroTarjetaPago->depClave == "MAT" || $filtroTarjetaPago->depClave == "PRE" || $filtroTarjetaPago->depClave == "PRI" || $filtroTarjetaPago->depClave == "SEC" || $filtroTarjetaPago->depClave == "BAC")

                    <div class="row">
                      <div class="col s12 m12 l12" style="margin-bottom: 20px;">
                          <hr>
                          <span class="card-title">IMPORTANTE: Favor de descargar la libreta de su conveniencia:</span>
                          <p style="color:black;font-weight: bold; font-size: 14px"></p>
                          <p style="color:darkblue;font-weight: bold; font-size: 18px">* Banco BBVA (Pago en Sucursal BBVA, Cajero Automático BBVA ó SPEI).</p>
                          <p style="color:darkred;font-weight: bold; font-size: 18px">** Banco HSBC (transferencia electrónica SPEI).</p>
                      </div>
                      <div class="col s12 m12 l12">
                          {!! Form::open(['onKeypress' => 'return disableEnterKey(event)', 'route' => 'libretapago.imprimir', 'method' => 'POST', "target" => "_blank", "style" => "display:inline-block;"]) !!}
                          <input type="hidden" name="perNumero" value="{{$filtroTarjetaPago->perNumero}}">
                          <input type="hidden" name="perAnio" value="{{$filtroTarjetaPago->perAnio}}">
                          <input type="hidden" name="ubiClave" value="{{$filtroTarjetaPago->ubicacion}}">
                          <input type="hidden" name="depClave" value="{{$filtroTarjetaPago->depClave}}">
                          <input type="hidden" name="escClave" value="{{$filtroTarjetaPago->escuela}}">
                          <input type="hidden" name="progClave" value="{{$filtroTarjetaPago->carrera}}">
                          <input type="hidden" name="aluClave" value="{{$filtroTarjetaPago->clave_pago}}">
                          <input type="hidden" name="perActual" value="{{$filtroTarjetaPago->perActual}}">
                          <input type="hidden" name="perSig" value="{{$filtroTarjetaPago->perSig}}">
                          <input type="hidden" name="perAnte" value="{{$filtroTarjetaPago->perAnte}}">
                          <input type="hidden" name="periodo_id" value="{{$filtroTarjetaPago->periodo_id}}">
                          <input type="hidden" name="perAnioPago" value="{{$filtroTarjetaPago->perAnioPago}}">
                          <input type="hidden" name="banco" value="BBVA">
                          {!! Form::button('Libreta de pago: Banco BBVA', ['class' => 'btn-large waves-effect  darken-3 submit-button','type' => 'submit']) !!}
                          {!! Form::close() !!}


                          {!! Form::open(['onKeypress' => 'return disableEnterKey(event)', 'route' => 'libretapago.imprimir', 'method' => 'POST', "target" => "_blank",  "style" => "display:inline-block;"]) !!}
                          <input type="hidden" name="perNumero" value="{{$filtroTarjetaPago->perNumero}}">
                          <input type="hidden" name="perAnio" value="{{$filtroTarjetaPago->perAnio}}">
                          <input type="hidden" name="ubiClave" value="{{$filtroTarjetaPago->ubicacion}}">
                          <input type="hidden" name="depClave" value="{{$filtroTarjetaPago->depClave}}">
                          <input type="hidden" name="escClave" value="{{$filtroTarjetaPago->escuela}}">
                          <input type="hidden" name="progClave" value="{{$filtroTarjetaPago->carrera}}">
                          <input type="hidden" name="aluClave" value="{{$filtroTarjetaPago->clave_pago}}">
                          <input type="hidden" name="perActual" value="{{$filtroTarjetaPago->perActual}}">
                          <input type="hidden" name="perSig" value="{{$filtroTarjetaPago->perSig}}">
                          <input type="hidden" name="perAnte" value="{{$filtroTarjetaPago->perAnte}}">
                          <input type="hidden" name="periodo_id" value="{{$filtroTarjetaPago->periodo_id}}">
                          <input type="hidden" name="perAnioPago" value="{{$filtroTarjetaPago->perAnioPago}}">
                          <input type="hidden" name="banco" value="HSBC">


                          {!! Form::button('Libreta de pago: Banco HSBC', ['class' => 'btn-large waves-effect  darken-3 submit-button','type' => 'submit']) !!}
                          {!! Form::close() !!}

                      </div>
                    </div>


                @else
                    {{--  validamos si esta activo DEFINE_PRORRATEO_LIBRETA_PAGO de ser así comprobamos si esta activo la libreta de pago y si el alumno ya eligio su forma de pago  --}}

                    @if ($filtroTarjetaPago->ubicacion == "CME")

                        {{--  para SUP   --}}
                        @if ($motrar_libreta == "A" && $userAlumnoPlanPago->puedeCambiardePlan == "NO" && $userAlumnoPlanPago->depClave == "SUP")
                            <div class="row">
                                <div class="col s12 m12 l12" style="margin-bottom: 20px;">
                                    <hr>
                                    <span class="card-title">IMPORTANTE: Favor de descargar la libreta de su conveniencia:</span>
                                    <p style="color:black;font-weight: bold; font-size: 14px"></p>
                                    <p style="color:darkblue;font-weight: bold; font-size: 18px">* Banco BBVA (Pago en Sucursal BBVA, Cajero Automático BBVA ó SPEI).</p>
                                    <p style="color:darkred;font-weight: bold; font-size: 18px">** Banco HSBC (transferencia electrónica SPEI).</p>
                                </div>
                                <div class="col s12 m12 l12">
                                    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)', 'route' => 'libretapago.imprimir', 'method' => 'POST', "target" => "_blank", "style" => "display:inline-block;"]) !!}
                                    <input type="hidden" name="perNumero" value="{{$filtroTarjetaPago->perNumero}}">
                                    <input type="hidden" name="perAnio" value="{{$filtroTarjetaPago->perAnio}}">
                                    <input type="hidden" name="ubiClave" value="{{$filtroTarjetaPago->ubicacion}}">
                                    <input type="hidden" name="depClave" value="{{$filtroTarjetaPago->depClave}}">
                                    <input type="hidden" name="escClave" value="{{$filtroTarjetaPago->escuela}}">
                                    <input type="hidden" name="progClave" value="{{$filtroTarjetaPago->carrera}}">
                                    <input type="hidden" name="aluClave" value="{{$filtroTarjetaPago->clave_pago}}">
                                    <input type="hidden" name="perActual" value="{{$filtroTarjetaPago->perActual}}">
                                    <input type="hidden" name="perSig" value="{{$filtroTarjetaPago->perSig}}">
                                    <input type="hidden" name="perAnte" value="{{$filtroTarjetaPago->perAnte}}">
                                    <input type="hidden" name="periodo_id" value="{{$filtroTarjetaPago->periodo_id}}">
                                    <input type="hidden" name="perAnioPago" value="{{$filtroTarjetaPago->perAnioPago}}">
                                    <input type="hidden" name="banco" value="BBVA">
                                    {!! Form::button('Libreta de pago: Banco BBVA', ['class' => 'btn-large waves-effect  darken-3 submit-button','type' => 'submit']) !!}
                                    {!! Form::close() !!}


                                    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)', 'route' => 'libretapago.imprimir', 'method' => 'POST', "target" => "_blank",  "style" => "display:inline-block;"]) !!}
                                    <input type="hidden" name="perNumero" value="{{$filtroTarjetaPago->perNumero}}">
                                    <input type="hidden" name="perAnio" value="{{$filtroTarjetaPago->perAnio}}">
                                    <input type="hidden" name="ubiClave" value="{{$filtroTarjetaPago->ubicacion}}">
                                    <input type="hidden" name="depClave" value="{{$filtroTarjetaPago->depClave}}">
                                    <input type="hidden" name="escClave" value="{{$filtroTarjetaPago->escuela}}">
                                    <input type="hidden" name="progClave" value="{{$filtroTarjetaPago->carrera}}">
                                    <input type="hidden" name="aluClave" value="{{$filtroTarjetaPago->clave_pago}}">
                                    <input type="hidden" name="perActual" value="{{$filtroTarjetaPago->perActual}}">
                                    <input type="hidden" name="perSig" value="{{$filtroTarjetaPago->perSig}}">
                                    <input type="hidden" name="perAnte" value="{{$filtroTarjetaPago->perAnte}}">
                                    <input type="hidden" name="periodo_id" value="{{$filtroTarjetaPago->periodo_id}}">
                                    <input type="hidden" name="perAnioPago" value="{{$filtroTarjetaPago->perAnioPago}}">
                                    <input type="hidden" name="banco" value="HSBC">


                                    {!! Form::button('Libreta de pago: Banco HSBC', ['class' => 'btn-large waves-effect  darken-3 submit-button','type' => 'submit']) !!}
                                    {!! Form::close() !!}

                                </div>
                            </div>
                        @endif

                        {{--  para POS   --}}
                        @if ($motrar_libreta == "A" && $userAlumnoPlanPago->depClave == "POS")
                            <div class="row">
                                <div class="col s12 m12 l12" style="margin-bottom: 20px;">
                                    <hr>
                                    <span class="card-title">IMPORTANTE: Favor de descargar la libreta de su conveniencia:</span>
                                    <p style="color:black;font-weight: bold; font-size: 14px"></p>
                                    <p style="color:darkblue;font-weight: bold; font-size: 18px">* Banco BBVA (Pago en Sucursal BBVA, Cajero Automático BBVA ó SPEI).</p>
                                    <p style="color:darkred;font-weight: bold; font-size: 18px">** Banco HSBC (transferencia electrónica SPEI).</p>
                                </div>
                                <div class="col s12 m12 l12">
                                    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)', 'route' => 'libretapago.imprimir', 'method' => 'POST', "target" => "_blank", "style" => "display:inline-block;"]) !!}
                                    <input type="hidden" name="perNumero" value="{{$filtroTarjetaPago->perNumero}}">
                                    <input type="hidden" name="perAnio" value="{{$filtroTarjetaPago->perAnio}}">
                                    <input type="hidden" name="ubiClave" value="{{$filtroTarjetaPago->ubicacion}}">
                                    <input type="hidden" name="depClave" value="{{$filtroTarjetaPago->depClave}}">
                                    <input type="hidden" name="escClave" value="{{$filtroTarjetaPago->escuela}}">
                                    <input type="hidden" name="progClave" value="{{$filtroTarjetaPago->carrera}}">
                                    <input type="hidden" name="aluClave" value="{{$filtroTarjetaPago->clave_pago}}">
                                    <input type="hidden" name="perActual" value="{{$filtroTarjetaPago->perActual}}">
                                    <input type="hidden" name="perSig" value="{{$filtroTarjetaPago->perSig}}">
                                    <input type="hidden" name="perAnte" value="{{$filtroTarjetaPago->perAnte}}">
                                    <input type="hidden" name="periodo_id" value="{{$filtroTarjetaPago->periodo_id}}">
                                    <input type="hidden" name="perAnioPago" value="{{$filtroTarjetaPago->perAnioPago}}">
                                    <input type="hidden" name="banco" value="BBVA">
                                    {!! Form::button('Libreta de pago: Banco BBVA', ['class' => 'btn-large waves-effect  darken-3 submit-button','type' => 'submit']) !!}
                                    {!! Form::close() !!}


                                    {!! Form::open(['onKeypress' => 'return disableEnterKey(event)', 'route' => 'libretapago.imprimir', 'method' => 'POST', "target" => "_blank",  "style" => "display:inline-block;"]) !!}
                                    <input type="hidden" name="perNumero" value="{{$filtroTarjetaPago->perNumero}}">
                                    <input type="hidden" name="perAnio" value="{{$filtroTarjetaPago->perAnio}}">
                                    <input type="hidden" name="ubiClave" value="{{$filtroTarjetaPago->ubicacion}}">
                                    <input type="hidden" name="depClave" value="{{$filtroTarjetaPago->depClave}}">
                                    <input type="hidden" name="escClave" value="{{$filtroTarjetaPago->escuela}}">
                                    <input type="hidden" name="progClave" value="{{$filtroTarjetaPago->carrera}}">
                                    <input type="hidden" name="aluClave" value="{{$filtroTarjetaPago->clave_pago}}">
                                    <input type="hidden" name="perActual" value="{{$filtroTarjetaPago->perActual}}">
                                    <input type="hidden" name="perSig" value="{{$filtroTarjetaPago->perSig}}">
                                    <input type="hidden" name="perAnte" value="{{$filtroTarjetaPago->perAnte}}">
                                    <input type="hidden" name="periodo_id" value="{{$filtroTarjetaPago->periodo_id}}">
                                    <input type="hidden" name="perAnioPago" value="{{$filtroTarjetaPago->perAnioPago}}">
                                    <input type="hidden" name="banco" value="HSBC">


                                    {!! Form::button('Libreta de pago: Banco HSBC', ['class' => 'btn-large waves-effect  darken-3 submit-button','type' => 'submit']) !!}
                                    {!! Form::close() !!}

                                </div>
                            </div>
                        @endif

                    @endif

                    {{--  PARA CVA   --}}
                    @if ($filtroTarjetaPago->ubicacion == "CVA" && $motrar_libreta == "A")
                        <div class="row">
                            <div class="col s12 m12 l12" style="margin-bottom: 20px;">
                                <hr>
                                <span class="card-title">IMPORTANTE: Favor de descargar la libreta de su conveniencia:</span>
                                <p style="color:black;font-weight: bold; font-size: 14px"></p>
                                <p style="color:darkblue;font-weight: bold; font-size: 18px">* Banco BBVA (Pago en Sucursal BBVA, Cajero Automático BBVA ó SPEI).</p>
                                <p style="color:darkred;font-weight: bold; font-size: 18px">** Banco HSBC (transferencia electrónica SPEI).</p>
                            </div>
                            <div class="col s12 m12 l12">
                                {!! Form::open(['onKeypress' => 'return disableEnterKey(event)', 'route' => 'libretapago.imprimir', 'method' => 'POST', "target" => "_blank", "style" => "display:inline-block;"]) !!}
                                <input type="hidden" name="perNumero" value="{{$filtroTarjetaPago->perNumero}}">
                                <input type="hidden" name="perAnio" value="{{$filtroTarjetaPago->perAnio}}">
                                <input type="hidden" name="ubiClave" value="{{$filtroTarjetaPago->ubicacion}}">
                                <input type="hidden" name="depClave" value="{{$filtroTarjetaPago->depClave}}">
                                <input type="hidden" name="escClave" value="{{$filtroTarjetaPago->escuela}}">
                                <input type="hidden" name="progClave" value="{{$filtroTarjetaPago->carrera}}">
                                <input type="hidden" name="aluClave" value="{{$filtroTarjetaPago->clave_pago}}">
                                <input type="hidden" name="perActual" value="{{$filtroTarjetaPago->perActual}}">
                                <input type="hidden" name="perSig" value="{{$filtroTarjetaPago->perSig}}">
                                <input type="hidden" name="perAnte" value="{{$filtroTarjetaPago->perAnte}}">
                                <input type="hidden" name="periodo_id" value="{{$filtroTarjetaPago->periodo_id}}">
                                <input type="hidden" name="perAnioPago" value="{{$filtroTarjetaPago->perAnioPago}}">
                                <input type="hidden" name="banco" value="BBVA">
                                {!! Form::button('Libreta de pago: Banco BBVA', ['class' => 'btn-large waves-effect  darken-3 submit-button','type' => 'submit']) !!}
                                {!! Form::close() !!}


                                {!! Form::open(['onKeypress' => 'return disableEnterKey(event)', 'route' => 'libretapago.imprimir', 'method' => 'POST', "target" => "_blank",  "style" => "display:inline-block;"]) !!}
                                <input type="hidden" name="perNumero" value="{{$filtroTarjetaPago->perNumero}}">
                                <input type="hidden" name="perAnio" value="{{$filtroTarjetaPago->perAnio}}">
                                <input type="hidden" name="ubiClave" value="{{$filtroTarjetaPago->ubicacion}}">
                                <input type="hidden" name="depClave" value="{{$filtroTarjetaPago->depClave}}">
                                <input type="hidden" name="escClave" value="{{$filtroTarjetaPago->escuela}}">
                                <input type="hidden" name="progClave" value="{{$filtroTarjetaPago->carrera}}">
                                <input type="hidden" name="aluClave" value="{{$filtroTarjetaPago->clave_pago}}">
                                <input type="hidden" name="perActual" value="{{$filtroTarjetaPago->perActual}}">
                                <input type="hidden" name="perSig" value="{{$filtroTarjetaPago->perSig}}">
                                <input type="hidden" name="perAnte" value="{{$filtroTarjetaPago->perAnte}}">
                                <input type="hidden" name="periodo_id" value="{{$filtroTarjetaPago->periodo_id}}">
                                <input type="hidden" name="perAnioPago" value="{{$filtroTarjetaPago->perAnioPago}}">
                                <input type="hidden" name="banco" value="HSBC">


                                {!! Form::button('Libreta de pago: Banco HSBC', ['class' => 'btn-large waves-effect  darken-3 submit-button','type' => 'submit']) !!}
                                {!! Form::close() !!}

                            </div>
                        </div>
                    @endif

                    {{--  PARA CCH   --}}
                    @if ($filtroTarjetaPago->ubicacion == "CCH" && $motrar_libreta == "A")
                        <div class="row">
                            <div class="col s12 m12 l12" style="margin-bottom: 20px;">
                                <hr>
                                <span class="card-title">IMPORTANTE: Favor de descargar la libreta de su conveniencia:</span>
                                <p style="color:black;font-weight: bold; font-size: 14px"></p>
                                <p style="color:darkblue;font-weight: bold; font-size: 18px">* Banco BBVA (Pago en Sucursal BBVA, Cajero Automático BBVA ó SPEI).</p>
                                <p style="color:darkred;font-weight: bold; font-size: 18px">** Banco HSBC (transferencia electrónica SPEI).</p>
                            </div>
                            <div class="col s12 m12 l12">
                                {!! Form::open(['onKeypress' => 'return disableEnterKey(event)', 'route' => 'libretapago.imprimir', 'method' => 'POST', "target" => "_blank", "style" => "display:inline-block;"]) !!}
                                <input type="hidden" name="perNumero" value="{{$filtroTarjetaPago->perNumero}}">
                                <input type="hidden" name="perAnio" value="{{$filtroTarjetaPago->perAnio}}">
                                <input type="hidden" name="ubiClave" value="{{$filtroTarjetaPago->ubicacion}}">
                                <input type="hidden" name="depClave" value="{{$filtroTarjetaPago->depClave}}">
                                <input type="hidden" name="escClave" value="{{$filtroTarjetaPago->escuela}}">
                                <input type="hidden" name="progClave" value="{{$filtroTarjetaPago->carrera}}">
                                <input type="hidden" name="aluClave" value="{{$filtroTarjetaPago->clave_pago}}">
                                <input type="hidden" name="perActual" value="{{$filtroTarjetaPago->perActual}}">
                                <input type="hidden" name="perSig" value="{{$filtroTarjetaPago->perSig}}">
                                <input type="hidden" name="perAnte" value="{{$filtroTarjetaPago->perAnte}}">
                                <input type="hidden" name="periodo_id" value="{{$filtroTarjetaPago->periodo_id}}">
                                <input type="hidden" name="perAnioPago" value="{{$filtroTarjetaPago->perAnioPago}}">
                                <input type="hidden" name="banco" value="BBVA">
                                {!! Form::button('Libreta de pago: Banco BBVA', ['class' => 'btn-large waves-effect  darken-3 submit-button','type' => 'submit']) !!}
                                {!! Form::close() !!}


                                {!! Form::open(['onKeypress' => 'return disableEnterKey(event)', 'route' => 'libretapago.imprimir', 'method' => 'POST', "target" => "_blank",  "style" => "display:inline-block;"]) !!}
                                <input type="hidden" name="perNumero" value="{{$filtroTarjetaPago->perNumero}}">
                                <input type="hidden" name="perAnio" value="{{$filtroTarjetaPago->perAnio}}">
                                <input type="hidden" name="ubiClave" value="{{$filtroTarjetaPago->ubicacion}}">
                                <input type="hidden" name="depClave" value="{{$filtroTarjetaPago->depClave}}">
                                <input type="hidden" name="escClave" value="{{$filtroTarjetaPago->escuela}}">
                                <input type="hidden" name="progClave" value="{{$filtroTarjetaPago->carrera}}">
                                <input type="hidden" name="aluClave" value="{{$filtroTarjetaPago->clave_pago}}">
                                <input type="hidden" name="perActual" value="{{$filtroTarjetaPago->perActual}}">
                                <input type="hidden" name="perSig" value="{{$filtroTarjetaPago->perSig}}">
                                <input type="hidden" name="perAnte" value="{{$filtroTarjetaPago->perAnte}}">
                                <input type="hidden" name="periodo_id" value="{{$filtroTarjetaPago->periodo_id}}">
                                <input type="hidden" name="perAnioPago" value="{{$filtroTarjetaPago->perAnioPago}}">
                                <input type="hidden" name="banco" value="HSBC">


                                {!! Form::button('Libreta de pago: Banco HSBC', ['class' => 'btn-large waves-effect  darken-3 submit-button','type' => 'submit']) !!}
                                {!! Form::close() !!}

                            </div>
                        </div>
                    @endif

                @endif

            @endif

           {{-- PARA ALUMNOS SUP O POS DEL PERIODO 1 QUE ESTAN REGULARES EN PERIODO 3 --}}
           @if ( $filtroTarjetaPago->curEstado == "P"
                && $cursoEstadoRegularPerAnte == "SI"
                && ( $filtroTarjetaPago->depClave == "SUP"
                || $filtroTarjetaPago->depClave == "POS" )
                )

              @if (!$DEFINE_PRORRATEO_LIBRETA_PAGO)

                  <div class="row">
                      <div class="col s12 m12 l12" style="margin-bottom: 20px;">
                          <hr>
                          <span class="card-title">IMPORTANTE: Favor de descargar la libreta de su conveniencia:</span>
                          <p style="color:black;font-weight: bold; font-size: 14px"></p>
                          <p style="color:darkblue;font-weight: bold; font-size: 18px">* Banco BBVA (Pago en Sucursal BBVA, Cajero Automático BBVA ó SPEI).</p>
                          <p style="color:darkred;font-weight: bold; font-size: 18px">** Banco HSBC (transferencia electrónica SPEI).</p>
                      </div>
                      <div class="col s12 m12 l12">
                          {!! Form::open(['onKeypress' => 'return disableEnterKey(event)', 'route' => 'libretapago.imprimir', 'method' => 'POST', "target" => "_blank", "style" => "display:inline-block;"]) !!}
                          <input type="hidden" name="perNumero" value="{{$filtroTarjetaPago->perNumero}}">
                          <input type="hidden" name="perAnio" value="{{$filtroTarjetaPago->perAnio}}">
                          <input type="hidden" name="ubiClave" value="{{$filtroTarjetaPago->ubicacion}}">
                          <input type="hidden" name="depClave" value="{{$filtroTarjetaPago->depClave}}">
                          <input type="hidden" name="escClave" value="{{$filtroTarjetaPago->escuela}}">
                          <input type="hidden" name="progClave" value="{{$filtroTarjetaPago->carrera}}">
                          <input type="hidden" name="aluClave" value="{{$filtroTarjetaPago->clave_pago}}">
                          <input type="hidden" name="perActual" value="{{$filtroTarjetaPago->perActual}}">
                          <input type="hidden" name="perSig" value="{{$filtroTarjetaPago->perSig}}">
                          <input type="hidden" name="perAnte" value="{{$filtroTarjetaPago->perAnte}}">
                          <input type="hidden" name="periodo_id" value="{{$filtroTarjetaPago->periodo_id}}">
                          <input type="hidden" name="perAnioPago" value="{{$filtroTarjetaPago->perAnioPago}}">
                          <input type="hidden" name="banco" value="BBVA">
                          {!! Form::button('Libreta de pago: Banco BBVA', ['class' => 'btn-large waves-effect  darken-3 submit-button','type' => 'submit']) !!}
                          {!! Form::close() !!}


                          {!! Form::open(['onKeypress' => 'return disableEnterKey(event)', 'route' => 'libretapago.imprimir', 'method' => 'POST', "target" => "_blank",  "style" => "display:inline-block;"]) !!}
                          <input type="hidden" name="perNumero" value="{{$filtroTarjetaPago->perNumero}}">
                          <input type="hidden" name="perAnio" value="{{$filtroTarjetaPago->perAnio}}">
                          <input type="hidden" name="ubiClave" value="{{$filtroTarjetaPago->ubicacion}}">
                          <input type="hidden" name="depClave" value="{{$filtroTarjetaPago->depClave}}">
                          <input type="hidden" name="escClave" value="{{$filtroTarjetaPago->escuela}}">
                          <input type="hidden" name="progClave" value="{{$filtroTarjetaPago->carrera}}">
                          <input type="hidden" name="aluClave" value="{{$filtroTarjetaPago->clave_pago}}">
                          <input type="hidden" name="perActual" value="{{$filtroTarjetaPago->perActual}}">
                          <input type="hidden" name="perSig" value="{{$filtroTarjetaPago->perSig}}">
                          <input type="hidden" name="perAnte" value="{{$filtroTarjetaPago->perAnte}}">
                          <input type="hidden" name="periodo_id" value="{{$filtroTarjetaPago->periodo_id}}">
                          <input type="hidden" name="perAnioPago" value="{{$filtroTarjetaPago->perAnioPago}}">
                          <input type="hidden" name="banco" value="HSBC">


                          {!! Form::button('Libreta de pago: Banco HSBC', ['class' => 'btn-large waves-effect  darken-3 submit-button','type' => 'submit']) !!}
                          {!! Form::close() !!}

                      </div>
                  </div>

              @endif

           @endif


            {{-- NAVIGATION BAR--}}
            {{-- <nav class="nav-extended">
              <div class="nav-content">
                <ul class="tabs tabs-transparent">
                  <li class="tab"><a class="active" href="#general">General</a></li>
                </ul>
              </div>
            </nav> --}}

            {{-- GENERAL BAR--}}

          </div>

        </div>
    </div>
  </div>

@endsection



