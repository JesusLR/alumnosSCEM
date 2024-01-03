@extends('layouts.dashboard')

@section('template_title')
    Bachiller recuperativo
@endsection

@section('head')
    {!! HTML::style(asset('vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
@endsection

@section('breadcrumbs')
    <a href="{{url('/')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('bachiller_recuperativos')}}" class="breadcrumb">Lista de recuperativo</a>
    <label class="breadcrumb">Editar recuperativo</label>
@endsection

@section('content')


<div class="row">
    <div class="col s12 ">
        {{ Form::open(array('method'=>'PUT','route' => ['bachiller_recuperativos.update', $extraordinario->id])) }}
        <div class="card ">
          <div class="card-content ">
            <span class="card-title">EDITAR RECUPERATIVO #{{$extraordinario->id}}</span>

            {{-- NAVIGATION BAR--}}
            <nav class="nav-extended">
              <div class="nav-content">
                <ul class="tabs tabs-transparent">
                  <li class="tab"><a class="active" href="#general">General</a></li>
                </ul>
              </div>
            </nav>

            {{-- GENERAL BAR--}}
            <div id="general">

                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('ubicacion_id', 'Ubicación *', array('class' => '')); !!}
                        <select id="ubicacion_id" class="browser-default validate select2" required name="ubicacion_id" style="width: 100%;">
                             <option value="{{$extraordinario->ubicacion_id}}">{{$extraordinario->ubiNombre}}</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('departamento_id', 'Departamento *', array('class' => '')); !!}
                        <select id="departamento_id" class="browser-default validate select2" required name="departamento_id" style="width: 100%;">
                            <option value="{{$extraordinario->departamento_id}}">
                                {{$extraordinario->depClave}}
                                {{"-"}}
                                {{$extraordinario->depNombre}}
                            </option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('escuela_id', 'Escuela *', array('class' => '')); !!}
                        <select id="escuela_id" class="browser-default validate select2" required name="escuela_id" style="width: 100%;">
                            <option value="{{$extraordinario->escuela_id}}">{{$extraordinario->escNombre}}</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                        <div class="col s12 m6 l4">
                            {!! Form::label('periodo_id', 'Periodo *', array('class' => '')); !!}
                            <select id="periodo_id" class="browser-default validate select2" required name="periodo_id" style="width: 100%;">
                                <option value="{{$extraordinario->periodo_id}}">{{$extraordinario->perNumero}}-{{$extraordinario->perAnio}}</option>
                            </select>
                        </div>
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                            {!! Form::text('perFechaInicial', $extraordinario->perFechaInicial, array('id' => 'perFechaInicial', 'class' => 'validate','readonly')) !!}
                            {!! Form::label('perFechaInicial', 'Fecha Inicio', ['class' => '']); !!}
                            </div>
                        </div>
                        <div class="col s12 m6 l4">
                            <div class="input-field">
                            {!! Form::text('perFechaFinal', $extraordinario->perFechaFinal, array('id' => 'perFechaFinal', 'class' => 'validate','readonly')) !!}
                            {!! Form::label('perFechaFinal', 'Fecha Final', ['class' => '']); !!}
                            </div>
                        </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('programa_id', 'Programa *', array('class' => '')); !!}
                        <select id="programa_id" class="browser-default validate select2" required name="programa_id" style="width: 100%;">
                            <option value="{{$extraordinario->programa_id}}">{{$extraordinario->progNombre}}</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('plan_id', 'Plan *', array('class' => '')); !!}
                        <select id="plan_id" class="browser-default validate select2" required name="plan_id" style="width: 100%;">
                            <option value="{{$extraordinario->plan_id}}">{{$extraordinario->planClave}}</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('gpoSemestre', 'Semestre *', array('class' => '')); !!}
                        <select id="gpoSemestre" class="browser-default validate select2" required name="gpoSemestre" style="width: 100%;">
                            <option value="{{$extraordinario->matSemestre}}">{{$extraordinario->matSemestre}}</option>
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::text('extGrupo', $extraordinario->extGrupo, array('id' => 'extGrupo', 'class' => 'validate','maxlength' => '3')) !!}
                        {!! Form::label('extGrupo', 'Clave grupo', ['class' => '']); !!}
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col s12 m6">
                        {!! Form::label('materia_id', 'Materia *', array('class' => '')); !!}
                        <select id="materia_id" class="browser-default validate select2" required name="materia_id" style="width: 100%;">
                            <option value="{{$extraordinario->bachiller_materia_id}}">{{$extraordinario->matClave}}-{{$extraordinario->matNombre}}</option>
                        </select>
                    </div>
                    {{--  <div class="col s12 m6">
                            {!! Form::label('aula_id', 'Aula', array('class' => '')); !!}
                            <select id="aula_id" class="browser-default validate select2" name="aula_id" style="width: 100%;">
                                <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                                @foreach($aulas as $aula)
                                    <option value="{{$aula->id}}" @if($extraordinario->aula_id == $aula->id) {{ 'selected' }} @endif>{{$aula->aulaClave}}</option>
                                @endforeach
                            </select>
                        </div>  --}}
                </div>
                {{--  <div id="seccion_optativa" class="row">
                    <div class="col s12 ">
                        {!! Form::label('optativa_id', 'Optativa', array('class' => '')); !!}
                        <select id="optativa_id" class="browser-default validate select2" name="optativa_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            @if($extraordinario->optativa)
                                <option value="{{$extraordinario->optativa->id}}" selected>{{$extraordinario->optativa->optNombre}}</option>
                            @endif
                        </select>
                    </div>
                </div>  --}}
                <br>
                <div class="row">
                    <div class="col s12 m6 l4">
                        {!! Form::label('extFecha', 'Fecha examen', array('class' => '')); !!}
                        {!! Form::date('extFecha', $extraordinario->extFecha, array('id' => 'extFecha', 'class' => 'validate')) !!}
                    </div>
                    <div class="col s12 m6 l4">
                        {!! Form::label('extHora', 'Hora examen', array('class' => '')); !!}
                        {!! Form::time('extHora', $extraordinario->extHora, array('id' => 'extHora', 'class' => 'validate')) !!}
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::number('extPago', $extraordinario->extPago, array('id' => 'extPago', 'class' => 'validate','min'=>'0','max'=>'99999999','onKeyPress="if(this.value.length==8) return false;"')) !!}
                        {!! Form::label('extPago', 'Costo Examen', array('class' => '')); !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::number('extNumeroFolio', $extraordinario->extNumeroFolio, array('id' => 'extNumeroFolio', 'class' => 'validate','min'=>'0','max'=>'99999999','onKeyPress="if(this.value.length==6) return false;"')) !!}
                        {!! Form::label('extNumeroFolio', 'Número de folio *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::number('extNumeroActa', $extraordinario->extNumeroActa, array('id' => 'extNumeroActa', 'class' => 'validate','min'=>'0','max'=>'99999999','onKeyPress="if(this.value.length==6) return false;"')) !!}
                        {!! Form::label('extNumeroActa', 'Número de acta *', array('class' => '')); !!}
                        </div>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::number('extNumeroLibro', $extraordinario->extNumeroLibro, array('id' => 'extNumeroLibro', 'class' => 'validate','min'=>'0','max'=>'99999999','onKeyPress="if(this.value.length==6) return false;"')) !!}
                        {!! Form::label('extNumeroLibro', 'Número de libro *', array('class' => '')); !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                        {!! Form::number('extAlumnosInscritos', $extraordinario->extAlumnosInscritos, array('id' => 'extAlumnosInscritos', 'class' => 'validate','min'=>'0','max'=>'99999999','onKeyPress="if(this.value.length==6) return false;"')) !!}
                        {!! Form::label('extAlumnosInscritos', 'Alumnos inscritos *', array('class' => '')); !!}
                        </div>
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Lunes</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioLunes', 'Hora de inicio *', array('class' => '')); !!}
                        <select id="extHoraInicioLunes" class="browser-default validate select2" name="extHoraInicioLunes" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ $extraordinario->extHoraInicioLunes == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ $extraordinario->extHoraInicioLunes == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ $extraordinario->extHoraInicioLunes == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ $extraordinario->extHoraInicioLunes == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ $extraordinario->extHoraInicioLunes == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ $extraordinario->extHoraInicioLunes == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ $extraordinario->extHoraInicioLunes == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ $extraordinario->extHoraInicioLunes == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ $extraordinario->extHoraInicioLunes == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ $extraordinario->extHoraInicioLunes == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ $extraordinario->extHoraInicioLunes == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ $extraordinario->extHoraInicioLunes == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ $extraordinario->extHoraInicioLunes == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ $extraordinario->extHoraInicioLunes == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ $extraordinario->extHoraInicioLunes == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ $extraordinario->extHoraInicioLunes == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ $extraordinario->extHoraInicioLunes == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ $extraordinario->extHoraInicioLunes == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ $extraordinario->extHoraInicioLunes == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ $extraordinario->extHoraInicioLunes == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ $extraordinario->extHoraInicioLunes == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ $extraordinario->extHoraInicioLunes == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ $extraordinario->extHoraInicioLunes == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ $extraordinario->extHoraInicioLunes == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraFinLunes', 'Hora de fin *', array('class' => '')); !!}
                        <select id="extHoraFinLunes" class="browser-default validate select2" name="extHoraFinLunes" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ $extraordinario->extHoraFinLunes == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ $extraordinario->extHoraFinLunes == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ $extraordinario->extHoraFinLunes == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ $extraordinario->extHoraFinLunes == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ $extraordinario->extHoraFinLunes == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ $extraordinario->extHoraFinLunes == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ $extraordinario->extHoraFinLunes == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ $extraordinario->extHoraFinLunes == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ $extraordinario->extHoraFinLunes == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ $extraordinario->extHoraFinLunes == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ $extraordinario->extHoraFinLunes == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ $extraordinario->extHoraFinLunes == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ $extraordinario->extHoraFinLunes == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ $extraordinario->extHoraFinLunes == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ $extraordinario->extHoraFinLunes == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ $extraordinario->extHoraFinLunes == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ $extraordinario->extHoraFinLunes == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ $extraordinario->extHoraFinLunes == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ $extraordinario->extHoraFinLunes == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ $extraordinario->extHoraFinLunes == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ $extraordinario->extHoraFinLunes == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ $extraordinario->extHoraFinLunes == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ $extraordinario->extHoraFinLunes == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ $extraordinario->extHoraFinLunes == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            <label for="extAulaLunes">Aula *</label>
                            <input type="text" name="extAulaLunes" id="extAulaLunes" maxlength="3" value="{{$extraordinario->extAulaLunes}}">
                        </div>
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Martes</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioMartes', 'Hora de inicio *', array('class' => '')); !!}
                        <select id="extHoraInicioMartes" class="browser-default validate select2" name="extHoraInicioMartes" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ $extraordinario->extHoraInicioMartes == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ $extraordinario->extHoraInicioMartes == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ $extraordinario->extHoraInicioMartes == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ $extraordinario->extHoraInicioMartes == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ $extraordinario->extHoraInicioMartes == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ $extraordinario->extHoraInicioMartes == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ $extraordinario->extHoraInicioMartes == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ $extraordinario->extHoraInicioMartes == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ $extraordinario->extHoraInicioMartes == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ $extraordinario->extHoraInicioMartes == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ $extraordinario->extHoraInicioMartes == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ $extraordinario->extHoraInicioMartes == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ $extraordinario->extHoraInicioMartes == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ $extraordinario->extHoraInicioMartes == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ $extraordinario->extHoraInicioMartes == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ $extraordinario->extHoraInicioMartes == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ $extraordinario->extHoraInicioMartes == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ $extraordinario->extHoraInicioMartes == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ $extraordinario->extHoraInicioMartes == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ $extraordinario->extHoraInicioMartes == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ $extraordinario->extHoraInicioMartes == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ $extraordinario->extHoraInicioMartes == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ $extraordinario->extHoraInicioMartes == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ $extraordinario->extHoraInicioMartes == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>                    
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraFinMartes', 'Hora de fin *', array('class' => '')); !!}
                        <select id="extHoraFinMartes" class="browser-default validate select2" name="extHoraFinMartes" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ $extraordinario->extHoraFinMartes == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ $extraordinario->extHoraFinMartes == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ $extraordinario->extHoraFinMartes == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ $extraordinario->extHoraFinMartes == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ $extraordinario->extHoraFinMartes == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ $extraordinario->extHoraFinMartes == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ $extraordinario->extHoraFinMartes == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ $extraordinario->extHoraFinMartes == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ $extraordinario->extHoraFinMartes == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ $extraordinario->extHoraFinMartes == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ $extraordinario->extHoraFinMartes == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ $extraordinario->extHoraFinMartes == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ $extraordinario->extHoraFinMartes == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ $extraordinario->extHoraFinMartes == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ $extraordinario->extHoraFinMartes == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ $extraordinario->extHoraFinMartes == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ $extraordinario->extHoraFinMartes == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ $extraordinario->extHoraFinMartes == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ $extraordinario->extHoraFinMartes == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ $extraordinario->extHoraFinMartes == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ $extraordinario->extHoraFinMartes == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ $extraordinario->extHoraFinMartes == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ $extraordinario->extHoraFinMartes == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ $extraordinario->extHoraFinMartes == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>   
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            <label for="extAulaMartes">Aula *</label>
                            <input type="text" name="extAulaMartes" id="extAulaMartes" maxlength="3" value="{{$extraordinario->extAulaMartes}}">
                        </div>
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Miércoles</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioMiercoles', 'Hora de inicio *', array('class' => '')); !!}
                        <select id="extHoraInicioMiercoles" class="browser-default validate select2" name="extHoraInicioMiercoles" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ $extraordinario->extHoraInicioMiercoles == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ $extraordinario->extHoraInicioMiercoles == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ $extraordinario->extHoraInicioMiercoles == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ $extraordinario->extHoraInicioMiercoles == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ $extraordinario->extHoraInicioMiercoles == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ $extraordinario->extHoraInicioMiercoles == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ $extraordinario->extHoraInicioMiercoles == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ $extraordinario->extHoraInicioMiercoles == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ $extraordinario->extHoraInicioMiercoles == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ $extraordinario->extHoraInicioMiercoles == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ $extraordinario->extHoraInicioMiercoles == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ $extraordinario->extHoraInicioMiercoles == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ $extraordinario->extHoraInicioMiercoles == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ $extraordinario->extHoraInicioMiercoles == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ $extraordinario->extHoraInicioMiercoles == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ $extraordinario->extHoraInicioMiercoles == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ $extraordinario->extHoraInicioMiercoles == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ $extraordinario->extHoraInicioMiercoles == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ $extraordinario->extHoraInicioMiercoles == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ $extraordinario->extHoraInicioMiercoles == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ $extraordinario->extHoraInicioMiercoles == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ $extraordinario->extHoraInicioMiercoles == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ $extraordinario->extHoraInicioMiercoles == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ $extraordinario->extHoraInicioMiercoles == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraFinMiercoles', 'Hora de fin *', array('class' => '')); !!}
                        <select id="extHoraFinMiercoles" class="browser-default validate select2" name="extHoraFinMiercoles" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ $extraordinario->extHoraFinMiercoles == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ $extraordinario->extHoraFinMiercoles == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ $extraordinario->extHoraFinMiercoles == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ $extraordinario->extHoraFinMiercoles == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ $extraordinario->extHoraFinMiercoles == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ $extraordinario->extHoraFinMiercoles == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ $extraordinario->extHoraFinMiercoles == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ $extraordinario->extHoraFinMiercoles == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ $extraordinario->extHoraFinMiercoles == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ $extraordinario->extHoraFinMiercoles == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ $extraordinario->extHoraFinMiercoles == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ $extraordinario->extHoraFinMiercoles == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ $extraordinario->extHoraFinMiercoles == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ $extraordinario->extHoraFinMiercoles == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ $extraordinario->extHoraFinMiercoles == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ $extraordinario->extHoraFinMiercoles == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ $extraordinario->extHoraFinMiercoles == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ $extraordinario->extHoraFinMiercoles == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ $extraordinario->extHoraFinMiercoles == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ $extraordinario->extHoraFinMiercoles == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ $extraordinario->extHoraFinMiercoles == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ $extraordinario->extHoraFinMiercoles == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ $extraordinario->extHoraFinMiercoles == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ $extraordinario->extHoraFinMiercoles == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            <label for="extAulaMiercoles">Aula *</label>
                            <input type="text" name="extAulaMiercoles" id="extAulaMiercoles" maxlength="3" value="{{$extraordinario->extAulaMiercoles}}">
                        </div>
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Jueves</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioJueves', 'Hora de inicio *', array('class' => '')); !!}
                        <select id="extHoraInicioJueves" class="browser-default validate select2" name="extHoraInicioJueves" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ $extraordinario->extHoraInicioJueves == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ $extraordinario->extHoraInicioJueves == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ $extraordinario->extHoraInicioJueves == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ $extraordinario->extHoraInicioJueves == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ $extraordinario->extHoraInicioJueves == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ $extraordinario->extHoraInicioJueves == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ $extraordinario->extHoraInicioJueves == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ $extraordinario->extHoraInicioJueves == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ $extraordinario->extHoraInicioJueves == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ $extraordinario->extHoraInicioJueves == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ $extraordinario->extHoraInicioJueves == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ $extraordinario->extHoraInicioJueves == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ $extraordinario->extHoraInicioJueves == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ $extraordinario->extHoraInicioJueves == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ $extraordinario->extHoraInicioJueves == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ $extraordinario->extHoraInicioJueves == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ $extraordinario->extHoraInicioJueves == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ $extraordinario->extHoraInicioJueves == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ $extraordinario->extHoraInicioJueves == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ $extraordinario->extHoraInicioJueves == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ $extraordinario->extHoraInicioJueves == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ $extraordinario->extHoraInicioJueves == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ $extraordinario->extHoraInicioJueves == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ $extraordinario->extHoraInicioJueves == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraFinJueves', 'Hora de fin *', array('class' => '')); !!}
                        <select id="extHoraFinJueves" class="browser-default validate select2" name="extHoraFinJueves" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ $extraordinario->extHoraFinJueves == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ $extraordinario->extHoraFinJueves == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ $extraordinario->extHoraFinJueves == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ $extraordinario->extHoraFinJueves == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ $extraordinario->extHoraFinJueves == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ $extraordinario->extHoraFinJueves == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ $extraordinario->extHoraFinJueves == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ $extraordinario->extHoraFinJueves == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ $extraordinario->extHoraFinJueves == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ $extraordinario->extHoraFinJueves == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ $extraordinario->extHoraFinJueves == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ $extraordinario->extHoraFinJueves == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ $extraordinario->extHoraFinJueves == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ $extraordinario->extHoraFinJueves == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ $extraordinario->extHoraFinJueves == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ $extraordinario->extHoraFinJueves == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ $extraordinario->extHoraFinJueves == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ $extraordinario->extHoraFinJueves == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ $extraordinario->extHoraFinJueves == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ $extraordinario->extHoraFinJueves == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ $extraordinario->extHoraFinJueves == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ $extraordinario->extHoraFinJueves == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ $extraordinario->extHoraFinJueves == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ $extraordinario->extHoraFinJueves == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            <label for="extAulaJueves">Aula *</label>
                            <input type="text" name="extAulaJueves" id="extAulaJueves" maxlength="3" value="{{$extraordinario->extAulaJueves}}">
                        </div>
                    </div>
                </div>


                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Viernes</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioViernes', 'Hora de inicio *', array('class' => '')); !!}
                        <select id="extHoraInicioViernes" class="browser-default validate select2" name="extHoraInicioViernes" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ $extraordinario->extHoraInicioViernes == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ $extraordinario->extHoraInicioViernes == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ $extraordinario->extHoraInicioViernes == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ $extraordinario->extHoraInicioViernes == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ $extraordinario->extHoraInicioViernes == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ $extraordinario->extHoraInicioViernes == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ $extraordinario->extHoraInicioViernes == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ $extraordinario->extHoraInicioViernes == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ $extraordinario->extHoraInicioViernes == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ $extraordinario->extHoraInicioViernes == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ $extraordinario->extHoraInicioViernes == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ $extraordinario->extHoraInicioViernes == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ $extraordinario->extHoraInicioViernes == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ $extraordinario->extHoraInicioViernes == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ $extraordinario->extHoraInicioViernes == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ $extraordinario->extHoraInicioViernes == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ $extraordinario->extHoraInicioViernes == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ $extraordinario->extHoraInicioViernes == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ $extraordinario->extHoraInicioViernes == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ $extraordinario->extHoraInicioViernes == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ $extraordinario->extHoraInicioViernes == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ $extraordinario->extHoraInicioViernes == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ $extraordinario->extHoraInicioViernes == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ $extraordinario->extHoraInicioViernes == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraFinViernes', 'Hora de fin *', array('class' => '')); !!}
                        <select id="extHoraFinViernes" class="browser-default validate select2" name="extHoraFinViernes" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ $extraordinario->extHoraFinViernes == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ $extraordinario->extHoraFinViernes == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ $extraordinario->extHoraFinViernes == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ $extraordinario->extHoraFinViernes == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ $extraordinario->extHoraFinViernes == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ $extraordinario->extHoraFinViernes == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ $extraordinario->extHoraFinViernes == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ $extraordinario->extHoraFinViernes == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ $extraordinario->extHoraFinViernes == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ $extraordinario->extHoraFinViernes == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ $extraordinario->extHoraFinViernes == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ $extraordinario->extHoraFinViernes == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ $extraordinario->extHoraFinViernes == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ $extraordinario->extHoraFinViernes == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ $extraordinario->extHoraFinViernes == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ $extraordinario->extHoraFinViernes == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ $extraordinario->extHoraFinViernes == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ $extraordinario->extHoraFinViernes == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ $extraordinario->extHoraFinViernes == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ $extraordinario->extHoraFinViernes == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ $extraordinario->extHoraFinViernes == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ $extraordinario->extHoraFinViernes == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ $extraordinario->extHoraFinViernes == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ $extraordinario->extHoraFinViernes == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            <label for="extAulaViernes">Aula *</label>
                            <input type="text" name="extAulaViernes" id="extAulaViernes" maxlength="3" value="{{$extraordinario->extAulaViernes}}">
                        </div>
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Sábado</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioSabado', 'Hora de inicio *', array('class' => '')); !!}
                        <select id="extHoraInicioSabado" class="browser-default validate select2" name="extHoraInicioSabado" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ $extraordinario->extHoraInicioSabado == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ $extraordinario->extHoraInicioSabado == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ $extraordinario->extHoraInicioSabado == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ $extraordinario->extHoraInicioSabado == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ $extraordinario->extHoraInicioSabado == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ $extraordinario->extHoraInicioSabado == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ $extraordinario->extHoraInicioSabado == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ $extraordinario->extHoraInicioSabado == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ $extraordinario->extHoraInicioSabado == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ $extraordinario->extHoraInicioSabado == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ $extraordinario->extHoraInicioSabado == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ $extraordinario->extHoraInicioSabado == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ $extraordinario->extHoraInicioSabado == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ $extraordinario->extHoraInicioSabado == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ $extraordinario->extHoraInicioSabado == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ $extraordinario->extHoraInicioSabado == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ $extraordinario->extHoraInicioSabado == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ $extraordinario->extHoraInicioSabado == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ $extraordinario->extHoraInicioSabado == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ $extraordinario->extHoraInicioSabado == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ $extraordinario->extHoraInicioSabado == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ $extraordinario->extHoraInicioSabado == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ $extraordinario->extHoraInicioSabado == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ $extraordinario->extHoraInicioSabado == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraFinSabado', 'Hora de fin *', array('class' => '')); !!}
                        <select id="extHoraFinSabado" class="browser-default validate select2" name="extHoraFinSabado" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ $extraordinario->extHoraFinSabado == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ $extraordinario->extHoraFinSabado == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ $extraordinario->extHoraFinSabado == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ $extraordinario->extHoraFinSabado == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ $extraordinario->extHoraFinSabado == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ $extraordinario->extHoraFinSabado == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ $extraordinario->extHoraFinSabado == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ $extraordinario->extHoraFinSabado == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ $extraordinario->extHoraFinSabado == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ $extraordinario->extHoraFinSabado == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ $extraordinario->extHoraFinSabado == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ $extraordinario->extHoraFinSabado == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ $extraordinario->extHoraFinSabado == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ $extraordinario->extHoraFinSabado == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ $extraordinario->extHoraFinSabado == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ $extraordinario->extHoraFinSabado == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ $extraordinario->extHoraFinSabado == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ $extraordinario->extHoraFinSabado == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ $extraordinario->extHoraFinSabado == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ $extraordinario->extHoraFinSabado == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ $extraordinario->extHoraFinSabado == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ $extraordinario->extHoraFinSabado == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ $extraordinario->extHoraFinSabado == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ $extraordinario->extHoraFinSabado == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <div class="input-field">
                            <label for="extAulaSabado">Aula *</label>
                            <input type="text" name="extAulaSabado" id="extAulaSabado" maxlength="3" value="{{$extraordinario->extAulaSabado}}">
                        </div>
                    </div>
                </div>

                <br>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Sesión 1</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extFechaSesion01', 'Fecha sesión *', array('class' => '')); !!}
                        {!! Form::date('extFechaSesion01', $extraordinario->extFechaSesion01, array('id' => 'extFechaSesion01', 'class' => 'validate')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioSesion01', 'Hora de inicio *', array('class' => '')); !!}
                        <select id="extHoraInicioSesion01" class="browser-default validate select2" name="extHoraInicioSesion01" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ $extraordinario->extHoraInicioSesion01 == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ $extraordinario->extHoraInicioSesion01 == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ $extraordinario->extHoraInicioSesion01 == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ $extraordinario->extHoraInicioSesion01 == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ $extraordinario->extHoraInicioSesion01 == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ $extraordinario->extHoraInicioSesion01 == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ $extraordinario->extHoraInicioSesion01 == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ $extraordinario->extHoraInicioSesion01 == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ $extraordinario->extHoraInicioSesion01 == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ $extraordinario->extHoraInicioSesion01 == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ $extraordinario->extHoraInicioSesion01 == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ $extraordinario->extHoraInicioSesion01 == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ $extraordinario->extHoraInicioSesion01 == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ $extraordinario->extHoraInicioSesion01 == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ $extraordinario->extHoraInicioSesion01 == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ $extraordinario->extHoraInicioSesion01 == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ $extraordinario->extHoraInicioSesion01 == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ $extraordinario->extHoraInicioSesion01 == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ $extraordinario->extHoraInicioSesion01 == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ $extraordinario->extHoraInicioSesion01 == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ $extraordinario->extHoraInicioSesion01 == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ $extraordinario->extHoraInicioSesion01 == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ $extraordinario->extHoraInicioSesion01 == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ $extraordinario->extHoraInicioSesion01 == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="extHoraFinSesion01">Hora fin *</label>
                        <select id="extHoraFinSesion01" class="browser-default validate select2" name="extHoraFinSesion01" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ $extraordinario->extHoraFinSesion01 == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ $extraordinario->extHoraFinSesion01 == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ $extraordinario->extHoraFinSesion01 == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ $extraordinario->extHoraFinSesion01 == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ $extraordinario->extHoraFinSesion01 == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ $extraordinario->extHoraFinSesion01 == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ $extraordinario->extHoraFinSesion01 == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ $extraordinario->extHoraFinSesion01 == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ $extraordinario->extHoraFinSesion01 == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ $extraordinario->extHoraFinSesion01 == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ $extraordinario->extHoraFinSesion01 == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ $extraordinario->extHoraFinSesion01 == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ $extraordinario->extHoraFinSesion01 == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ $extraordinario->extHoraFinSesion01 == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ $extraordinario->extHoraFinSesion01 == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ $extraordinario->extHoraFinSesion01 == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ $extraordinario->extHoraFinSesion01 == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ $extraordinario->extHoraFinSesion01 == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ $extraordinario->extHoraFinSesion01 == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ $extraordinario->extHoraFinSesion01 == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ $extraordinario->extHoraFinSesion01 == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ $extraordinario->extHoraFinSesion01 == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ $extraordinario->extHoraFinSesion01 == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ $extraordinario->extHoraFinSesion01 == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Sesión 2</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extFechaSesion02', 'Fecha sesión *', array('class' => '')); !!}
                        {!! Form::date('extFechaSesion02', $extraordinario->extFechaSesion02, array('id' => 'extFechaSesion02', 'class' => 'validate')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioSesion02', 'Hora de inicio *', array('class' => '')); !!}
                        <select id="extHoraInicioSesion02" class="browser-default validate select2" name="extHoraInicioSesion02" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ $extraordinario->extHoraInicioSesion02 == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ $extraordinario->extHoraInicioSesion02 == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ $extraordinario->extHoraInicioSesion02 == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ $extraordinario->extHoraInicioSesion02 == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ $extraordinario->extHoraInicioSesion02 == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ $extraordinario->extHoraInicioSesion02 == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ $extraordinario->extHoraInicioSesion02 == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ $extraordinario->extHoraInicioSesion02 == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ $extraordinario->extHoraInicioSesion02 == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ $extraordinario->extHoraInicioSesion02 == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ $extraordinario->extHoraInicioSesion02 == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ $extraordinario->extHoraInicioSesion02 == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ $extraordinario->extHoraInicioSesion02 == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ $extraordinario->extHoraInicioSesion02 == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ $extraordinario->extHoraInicioSesion02 == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ $extraordinario->extHoraInicioSesion02 == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ $extraordinario->extHoraInicioSesion02 == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ $extraordinario->extHoraInicioSesion02 == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ $extraordinario->extHoraInicioSesion02 == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ $extraordinario->extHoraInicioSesion02 == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ $extraordinario->extHoraInicioSesion02 == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ $extraordinario->extHoraInicioSesion02 == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ $extraordinario->extHoraInicioSesion02 == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ $extraordinario->extHoraInicioSesion02 == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="extHoraFinSesion02">Hora fin *</label>
                        <select id="extHoraFinSesion02" class="browser-default validate select2" name="extHoraFinSesion02" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ $extraordinario->extHoraFinSesion02 == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ $extraordinario->extHoraFinSesion02 == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ $extraordinario->extHoraFinSesion02 == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ $extraordinario->extHoraFinSesion02 == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ $extraordinario->extHoraFinSesion02 == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ $extraordinario->extHoraFinSesion02 == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ $extraordinario->extHoraFinSesion02 == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ $extraordinario->extHoraFinSesion02 == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ $extraordinario->extHoraFinSesion02 == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ $extraordinario->extHoraFinSesion02 == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ $extraordinario->extHoraFinSesion02 == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ $extraordinario->extHoraFinSesion02 == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ $extraordinario->extHoraFinSesion02 == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ $extraordinario->extHoraFinSesion02 == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ $extraordinario->extHoraFinSesion02 == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ $extraordinario->extHoraFinSesion02 == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ $extraordinario->extHoraFinSesion02 == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ $extraordinario->extHoraFinSesion02 == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ $extraordinario->extHoraFinSesion02 == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ $extraordinario->extHoraFinSesion02 == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ $extraordinario->extHoraFinSesion02 == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ $extraordinario->extHoraFinSesion02 == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ $extraordinario->extHoraFinSesion02 == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ $extraordinario->extHoraFinSesion02 == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Sesión 3</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extFechaSesion03', 'Fecha sesión *', array('class' => '')); !!}
                        {!! Form::date('extFechaSesion03', $extraordinario->extFechaSesion03, array('id' => 'extFechaSesion03', 'class' => 'validate')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioSesion03', 'Hora de inicio *', array('class' => '')); !!}
                        <select id="extHoraInicioSesion03" class="browser-default validate select2" name="extHoraInicioSesion03" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ $extraordinario->extHoraInicioSesion03 == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ $extraordinario->extHoraInicioSesion03 == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ $extraordinario->extHoraInicioSesion03 == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ $extraordinario->extHoraInicioSesion03 == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ $extraordinario->extHoraInicioSesion03 == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ $extraordinario->extHoraInicioSesion03 == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ $extraordinario->extHoraInicioSesion03 == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ $extraordinario->extHoraInicioSesion03 == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ $extraordinario->extHoraInicioSesion03 == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ $extraordinario->extHoraInicioSesion03 == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ $extraordinario->extHoraInicioSesion03 == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ $extraordinario->extHoraInicioSesion03 == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ $extraordinario->extHoraInicioSesion03 == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ $extraordinario->extHoraInicioSesion03 == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ $extraordinario->extHoraInicioSesion03 == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ $extraordinario->extHoraInicioSesion03 == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ $extraordinario->extHoraInicioSesion03 == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ $extraordinario->extHoraInicioSesion03 == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ $extraordinario->extHoraInicioSesion03 == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ $extraordinario->extHoraInicioSesion03 == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ $extraordinario->extHoraInicioSesion03 == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ $extraordinario->extHoraInicioSesion03 == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ $extraordinario->extHoraInicioSesion03 == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ $extraordinario->extHoraInicioSesion03 == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="extHoraFinSesion03">Hora fin *</label>
                        <select id="extHoraFinSesion03" class="browser-default validate select2" name="extHoraFinSesion03" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ $extraordinario->extHoraFinSesion03 == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ $extraordinario->extHoraFinSesion03 == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ $extraordinario->extHoraFinSesion03 == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ $extraordinario->extHoraFinSesion03 == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ $extraordinario->extHoraFinSesion03 == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ $extraordinario->extHoraFinSesion03 == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ $extraordinario->extHoraFinSesion03 == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ $extraordinario->extHoraFinSesion03 == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ $extraordinario->extHoraFinSesion03 == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ $extraordinario->extHoraFinSesion03 == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ $extraordinario->extHoraFinSesion03 == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ $extraordinario->extHoraFinSesion03 == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ $extraordinario->extHoraFinSesion03 == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ $extraordinario->extHoraFinSesion03 == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ $extraordinario->extHoraFinSesion03 == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ $extraordinario->extHoraFinSesion03 == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ $extraordinario->extHoraFinSesion03 == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ $extraordinario->extHoraFinSesion03 == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ $extraordinario->extHoraFinSesion03 == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ $extraordinario->extHoraFinSesion03 == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ $extraordinario->extHoraFinSesion03 == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ $extraordinario->extHoraFinSesion03 == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ $extraordinario->extHoraFinSesion03 == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ $extraordinario->extHoraFinSesion03 == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Sesión 4</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extFechaSesion04', 'Fecha sesión *', array('class' => '')); !!}
                        {!! Form::date('extFechaSesion04', $extraordinario->extFechaSesion04, array('id' => 'extFechaSesion04', 'class' => 'validate')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioSesion04', 'Hora de inicio *', array('class' => '')); !!}
                        <select id="extHoraInicioSesion04" class="browser-default validate select2" name="extHoraInicioSesion04" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ $extraordinario->extHoraInicioSesion04 == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ $extraordinario->extHoraInicioSesion04 == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ $extraordinario->extHoraInicioSesion04 == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ $extraordinario->extHoraInicioSesion04 == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ $extraordinario->extHoraInicioSesion04 == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ $extraordinario->extHoraInicioSesion04 == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ $extraordinario->extHoraInicioSesion04 == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ $extraordinario->extHoraInicioSesion04 == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ $extraordinario->extHoraInicioSesion04 == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ $extraordinario->extHoraInicioSesion04 == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ $extraordinario->extHoraInicioSesion04 == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ $extraordinario->extHoraInicioSesion04 == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ $extraordinario->extHoraInicioSesion04 == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ $extraordinario->extHoraInicioSesion04 == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ $extraordinario->extHoraInicioSesion04 == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ $extraordinario->extHoraInicioSesion04 == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ $extraordinario->extHoraInicioSesion04 == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ $extraordinario->extHoraInicioSesion04 == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ $extraordinario->extHoraInicioSesion04 == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ $extraordinario->extHoraInicioSesion04 == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ $extraordinario->extHoraInicioSesion04 == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ $extraordinario->extHoraInicioSesion04 == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ $extraordinario->extHoraInicioSesion04 == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ $extraordinario->extHoraInicioSesion04 == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="extHoraFinSesion04">Hora fin *</label>
                        <select id="extHoraFinSesion04" class="browser-default validate select2" name="extHoraFinSesion04" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ $extraordinario->extHoraFinSesion04 == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ $extraordinario->extHoraFinSesion04 == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ $extraordinario->extHoraFinSesion04 == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ $extraordinario->extHoraFinSesion04 == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ $extraordinario->extHoraFinSesion04 == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ $extraordinario->extHoraFinSesion04 == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ $extraordinario->extHoraFinSesion04 == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ $extraordinario->extHoraFinSesion04 == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ $extraordinario->extHoraFinSesion04 == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ $extraordinario->extHoraFinSesion04 == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ $extraordinario->extHoraFinSesion04 == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ $extraordinario->extHoraFinSesion04 == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ $extraordinario->extHoraFinSesion04 == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ $extraordinario->extHoraFinSesion04 == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ $extraordinario->extHoraFinSesion04 == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ $extraordinario->extHoraFinSesion04 == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ $extraordinario->extHoraFinSesion04 == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ $extraordinario->extHoraFinSesion04 == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ $extraordinario->extHoraFinSesion04 == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ $extraordinario->extHoraFinSesion04 == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ $extraordinario->extHoraFinSesion04 == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ $extraordinario->extHoraFinSesion04 == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ $extraordinario->extHoraFinSesion04 == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ $extraordinario->extHoraFinSesion04 == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Sesión 5</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extFechaSesion05', 'Fecha sesión *', array('class' => '')); !!}
                        {!! Form::date('extFechaSesion05', $extraordinario->extFechaSesion05, array('id' => 'extFechaSesion05', 'class' => 'validate')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioSesion05', 'Hora de inicio *', array('class' => '')); !!}
                        <select id="extHoraInicioSesion05" class="browser-default validate select2" name="extHoraInicioSesion05" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ $extraordinario->extHoraInicioSesion05 == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ $extraordinario->extHoraInicioSesion05 == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ $extraordinario->extHoraInicioSesion05 == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ $extraordinario->extHoraInicioSesion05 == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ $extraordinario->extHoraInicioSesion05 == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ $extraordinario->extHoraInicioSesion05 == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ $extraordinario->extHoraInicioSesion05 == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ $extraordinario->extHoraInicioSesion05 == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ $extraordinario->extHoraInicioSesion05 == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ $extraordinario->extHoraInicioSesion05 == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ $extraordinario->extHoraInicioSesion05 == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ $extraordinario->extHoraInicioSesion05 == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ $extraordinario->extHoraInicioSesion05 == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ $extraordinario->extHoraInicioSesion05 == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ $extraordinario->extHoraInicioSesion05 == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ $extraordinario->extHoraInicioSesion05 == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ $extraordinario->extHoraInicioSesion05 == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ $extraordinario->extHoraInicioSesion05 == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ $extraordinario->extHoraInicioSesion05 == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ $extraordinario->extHoraInicioSesion05 == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ $extraordinario->extHoraInicioSesion05 == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ $extraordinario->extHoraInicioSesion05 == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ $extraordinario->extHoraInicioSesion05 == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ $extraordinario->extHoraInicioSesion05 == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="extHoraFinSesion05">Hora fin *</label>
                        <select id="extHoraFinSesion05" class="browser-default validate select2" name="extHoraFinSesion05" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ $extraordinario->extHoraFinSesion05 == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ $extraordinario->extHoraFinSesion05 == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ $extraordinario->extHoraFinSesion05 == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ $extraordinario->extHoraFinSesion05 == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ $extraordinario->extHoraFinSesion05 == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ $extraordinario->extHoraFinSesion05 == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ $extraordinario->extHoraFinSesion05 == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ $extraordinario->extHoraFinSesion05 == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ $extraordinario->extHoraFinSesion05 == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ $extraordinario->extHoraFinSesion05 == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ $extraordinario->extHoraFinSesion05 == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ $extraordinario->extHoraFinSesion05 == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ $extraordinario->extHoraFinSesion05 == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ $extraordinario->extHoraFinSesion05 == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ $extraordinario->extHoraFinSesion05 == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ $extraordinario->extHoraFinSesion05 == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ $extraordinario->extHoraFinSesion05 == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ $extraordinario->extHoraFinSesion05 == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ $extraordinario->extHoraFinSesion05 == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ $extraordinario->extHoraFinSesion05 == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ $extraordinario->extHoraFinSesion05 == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ $extraordinario->extHoraFinSesion05 == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ $extraordinario->extHoraFinSesion05 == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ $extraordinario->extHoraFinSesion05 == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Sesión 6</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extFechaSesion06', 'Fecha sesión *', array('class' => '')); !!}
                        {!! Form::date('extFechaSesion06', $extraordinario->extFechaSesion06, array('id' => 'extFechaSesion06', 'class' => 'validate')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioSesion06', 'Hora de inicio *', array('class' => '')); !!}
                        <select id="extHoraInicioSesion06" class="browser-default validate select2" name="extHoraInicioSesion06" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ $extraordinario->extHoraInicioSesion06 == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ $extraordinario->extHoraInicioSesion06 == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ $extraordinario->extHoraInicioSesion06 == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ $extraordinario->extHoraInicioSesion06 == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ $extraordinario->extHoraInicioSesion06 == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ $extraordinario->extHoraInicioSesion06 == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ $extraordinario->extHoraInicioSesion06 == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ $extraordinario->extHoraInicioSesion06 == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ $extraordinario->extHoraInicioSesion06 == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ $extraordinario->extHoraInicioSesion06 == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ $extraordinario->extHoraInicioSesion06 == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ $extraordinario->extHoraInicioSesion06 == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ $extraordinario->extHoraInicioSesion06 == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ $extraordinario->extHoraInicioSesion06 == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ $extraordinario->extHoraInicioSesion06 == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ $extraordinario->extHoraInicioSesion06 == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ $extraordinario->extHoraInicioSesion06 == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ $extraordinario->extHoraInicioSesion06 == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ $extraordinario->extHoraInicioSesion06 == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ $extraordinario->extHoraInicioSesion06 == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ $extraordinario->extHoraInicioSesion06 == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ $extraordinario->extHoraInicioSesion06 == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ $extraordinario->extHoraInicioSesion06 == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ $extraordinario->extHoraInicioSesion06 == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="extHoraFinSesion06">Hora fin *</label>
                        <select id="extHoraFinSesion06" class="browser-default validate select2" name="extHoraFinSesion06" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ $extraordinario->extHoraFinSesion06 == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ $extraordinario->extHoraFinSesion06 == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ $extraordinario->extHoraFinSesion06 == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ $extraordinario->extHoraFinSesion06 == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ $extraordinario->extHoraFinSesion06 == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ $extraordinario->extHoraFinSesion06 == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ $extraordinario->extHoraFinSesion06 == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ $extraordinario->extHoraFinSesion06 == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ $extraordinario->extHoraFinSesion06 == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ $extraordinario->extHoraFinSesion06 == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ $extraordinario->extHoraFinSesion06 == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ $extraordinario->extHoraFinSesion06 == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ $extraordinario->extHoraFinSesion06 == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ $extraordinario->extHoraFinSesion06 == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ $extraordinario->extHoraFinSesion06 == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ $extraordinario->extHoraFinSesion06 == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ $extraordinario->extHoraFinSesion06 == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ $extraordinario->extHoraFinSesion06 == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ $extraordinario->extHoraFinSesion06 == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ $extraordinario->extHoraFinSesion06 == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ $extraordinario->extHoraFinSesion06 == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ $extraordinario->extHoraFinSesion06 == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ $extraordinario->extHoraFinSesion06 == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ $extraordinario->extHoraFinSesion06 == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Sesión 7</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extFechaSesion07', 'Fecha sesión *', array('class' => '')); !!}
                        {!! Form::date('extFechaSesion07', $extraordinario->extFechaSesion07, array('id' => 'extFechaSesion07', 'class' => 'validate')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioSesion07', 'Hora de inicio *', array('class' => '')); !!}
                        <select id="extHoraInicioSesion07" class="browser-default validate select2" name="extHoraInicioSesion07" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ $extraordinario->extHoraInicioSesion07 == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ $extraordinario->extHoraInicioSesion07 == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ $extraordinario->extHoraInicioSesion07 == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ $extraordinario->extHoraInicioSesion07 == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ $extraordinario->extHoraInicioSesion07 == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ $extraordinario->extHoraInicioSesion07 == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ $extraordinario->extHoraInicioSesion07 == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ $extraordinario->extHoraInicioSesion07 == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ $extraordinario->extHoraInicioSesion07 == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ $extraordinario->extHoraInicioSesion07 == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ $extraordinario->extHoraInicioSesion07 == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ $extraordinario->extHoraInicioSesion07 == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ $extraordinario->extHoraInicioSesion07 == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ $extraordinario->extHoraInicioSesion07 == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ $extraordinario->extHoraInicioSesion07 == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ $extraordinario->extHoraInicioSesion07 == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ $extraordinario->extHoraInicioSesion07 == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ $extraordinario->extHoraInicioSesion07 == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ $extraordinario->extHoraInicioSesion07 == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ $extraordinario->extHoraInicioSesion07 == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ $extraordinario->extHoraInicioSesion07 == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ $extraordinario->extHoraInicioSesion07 == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ $extraordinario->extHoraInicioSesion07 == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ $extraordinario->extHoraInicioSesion07 == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="extHoraFinSesion07">Hora fin *</label>
                        <select id="extHoraFinSesion07" class="browser-default validate select2" name="extHoraFinSesion07" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ $extraordinario->extHoraFinSesion07 == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ $extraordinario->extHoraFinSesion07 == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ $extraordinario->extHoraFinSesion07 == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ $extraordinario->extHoraFinSesion07 == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ $extraordinario->extHoraFinSesion07 == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ $extraordinario->extHoraFinSesion07 == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ $extraordinario->extHoraFinSesion07 == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ $extraordinario->extHoraFinSesion07 == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ $extraordinario->extHoraFinSesion07 == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ $extraordinario->extHoraFinSesion07 == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ $extraordinario->extHoraFinSesion07 == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ $extraordinario->extHoraFinSesion07 == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ $extraordinario->extHoraFinSesion07 == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ $extraordinario->extHoraFinSesion07 == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ $extraordinario->extHoraFinSesion07 == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ $extraordinario->extHoraFinSesion07 == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ $extraordinario->extHoraFinSesion07 == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ $extraordinario->extHoraFinSesion07 == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ $extraordinario->extHoraFinSesion07 == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ $extraordinario->extHoraFinSesion07 == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ $extraordinario->extHoraFinSesion07 == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ $extraordinario->extHoraFinSesion07 == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ $extraordinario->extHoraFinSesion07 == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ $extraordinario->extHoraFinSesion07 == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Sesión 8</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extFechaSesion08', 'Fecha sesión *', array('class' => '')); !!}
                        {!! Form::date('extFechaSesion08', $extraordinario->extFechaSesion08, array('id' => 'extFechaSesion08', 'class' => 'validate')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioSesion08', 'Hora de inicio *', array('class' => '')); !!}
                        <select id="extHoraInicioSesion08" class="browser-default validate select2" name="extHoraInicioSesion08" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ $extraordinario->extHoraInicioSesion08 == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ $extraordinario->extHoraInicioSesion08 == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ $extraordinario->extHoraInicioSesion08 == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ $extraordinario->extHoraInicioSesion08 == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ $extraordinario->extHoraInicioSesion08 == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ $extraordinario->extHoraInicioSesion08 == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ $extraordinario->extHoraInicioSesion08 == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ $extraordinario->extHoraInicioSesion08 == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ $extraordinario->extHoraInicioSesion08 == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ $extraordinario->extHoraInicioSesion08 == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ $extraordinario->extHoraInicioSesion08 == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ $extraordinario->extHoraInicioSesion08 == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ $extraordinario->extHoraInicioSesion08 == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ $extraordinario->extHoraInicioSesion08 == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ $extraordinario->extHoraInicioSesion08 == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ $extraordinario->extHoraInicioSesion08 == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ $extraordinario->extHoraInicioSesion08 == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ $extraordinario->extHoraInicioSesion08 == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ $extraordinario->extHoraInicioSesion08 == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ $extraordinario->extHoraInicioSesion08 == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ $extraordinario->extHoraInicioSesion08 == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ $extraordinario->extHoraInicioSesion08 == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ $extraordinario->extHoraInicioSesion08 == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ $extraordinario->extHoraInicioSesion08 == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="extHoraFinSesion08">Hora fin *</label>
                        <select id="extHoraFinSesion08" class="browser-default validate select2" name="extHoraFinSesion08" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ $extraordinario->extHoraFinSesion08 == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ $extraordinario->extHoraFinSesion08 == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ $extraordinario->extHoraFinSesion08 == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ $extraordinario->extHoraFinSesion08 == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ $extraordinario->extHoraFinSesion08 == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ $extraordinario->extHoraFinSesion08 == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ $extraordinario->extHoraFinSesion08 == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ $extraordinario->extHoraFinSesion08 == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ $extraordinario->extHoraFinSesion08 == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ $extraordinario->extHoraFinSesion08 == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ $extraordinario->extHoraFinSesion08 == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ $extraordinario->extHoraFinSesion08 == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ $extraordinario->extHoraFinSesion08 == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ $extraordinario->extHoraFinSesion08 == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ $extraordinario->extHoraFinSesion08 == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ $extraordinario->extHoraFinSesion08 == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ $extraordinario->extHoraFinSesion08 == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ $extraordinario->extHoraFinSesion08 == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ $extraordinario->extHoraFinSesion08 == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ $extraordinario->extHoraFinSesion08 == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ $extraordinario->extHoraFinSesion08 == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ $extraordinario->extHoraFinSesion08 == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ $extraordinario->extHoraFinSesion08 == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ $extraordinario->extHoraFinSesion08 == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Sesión 9</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extFechaSesion09', 'Fecha sesión *', array('class' => '')); !!}
                        {!! Form::date('extFechaSesion09', $extraordinario->extFechaSesion09, array('id' => 'extFechaSesion09', 'class' => 'validate')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioSesion09', 'Hora de inicio *', array('class' => '')); !!}
                        <select id="extHoraInicioSesion09" class="browser-default validate select2" name="extHoraInicioSesion09" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ $extraordinario->extHoraInicioSesion09 == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ $extraordinario->extHoraInicioSesion09 == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ $extraordinario->extHoraInicioSesion09 == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ $extraordinario->extHoraInicioSesion09 == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ $extraordinario->extHoraInicioSesion09 == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ $extraordinario->extHoraInicioSesion09 == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ $extraordinario->extHoraInicioSesion09 == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ $extraordinario->extHoraInicioSesion09 == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ $extraordinario->extHoraInicioSesion09 == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ $extraordinario->extHoraInicioSesion09 == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ $extraordinario->extHoraInicioSesion09 == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ $extraordinario->extHoraInicioSesion09 == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ $extraordinario->extHoraInicioSesion09 == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ $extraordinario->extHoraInicioSesion09 == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ $extraordinario->extHoraInicioSesion09 == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ $extraordinario->extHoraInicioSesion09 == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ $extraordinario->extHoraInicioSesion09 == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ $extraordinario->extHoraInicioSesion09 == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ $extraordinario->extHoraInicioSesion09 == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ $extraordinario->extHoraInicioSesion09 == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ $extraordinario->extHoraInicioSesion09 == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ $extraordinario->extHoraInicioSesion09 == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ $extraordinario->extHoraInicioSesion09 == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ $extraordinario->extHoraInicioSesion09 == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="extHoraFinSesion09">Hora fin *</label>
                        <select id="extHoraFinSesion06" class="browser-default validate select2" name="extHoraFinSesion06" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ $extraordinario->extHoraFinSesion06 == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ $extraordinario->extHoraFinSesion06 == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ $extraordinario->extHoraFinSesion06 == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ $extraordinario->extHoraFinSesion06 == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ $extraordinario->extHoraFinSesion06 == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ $extraordinario->extHoraFinSesion06 == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ $extraordinario->extHoraFinSesion06 == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ $extraordinario->extHoraFinSesion06 == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ $extraordinario->extHoraFinSesion06 == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ $extraordinario->extHoraFinSesion06 == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ $extraordinario->extHoraFinSesion06 == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ $extraordinario->extHoraFinSesion06 == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ $extraordinario->extHoraFinSesion06 == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ $extraordinario->extHoraFinSesion06 == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ $extraordinario->extHoraFinSesion06 == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ $extraordinario->extHoraFinSesion06 == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ $extraordinario->extHoraFinSesion06 == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ $extraordinario->extHoraFinSesion06 == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ $extraordinario->extHoraFinSesion06 == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ $extraordinario->extHoraFinSesion06 == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ $extraordinario->extHoraFinSesion06 == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ $extraordinario->extHoraFinSesion06 == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ $extraordinario->extHoraFinSesion06 == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ $extraordinario->extHoraFinSesion06 == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Sesión 10</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extFechaSesion10', 'Fecha sesión *', array('class' => '')); !!}
                        {!! Form::date('extFechaSesion10', $extraordinario->extFechaSesion10, array('id' => 'extFechaSesion10', 'class' => 'validate')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioSesion10', 'Hora de inicio *', array('class' => '')); !!}
                        <select id="extHoraInicioSesion10" class="browser-default validate select2" name="extHoraInicioSesion10" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ $extraordinario->extHoraInicioSesion10 == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ $extraordinario->extHoraInicioSesion10 == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ $extraordinario->extHoraInicioSesion10 == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ $extraordinario->extHoraInicioSesion10 == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ $extraordinario->extHoraInicioSesion10 == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ $extraordinario->extHoraInicioSesion10 == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ $extraordinario->extHoraInicioSesion10 == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ $extraordinario->extHoraInicioSesion10 == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ $extraordinario->extHoraInicioSesion10 == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ $extraordinario->extHoraInicioSesion10 == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ $extraordinario->extHoraInicioSesion10 == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ $extraordinario->extHoraInicioSesion10 == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ $extraordinario->extHoraInicioSesion10 == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ $extraordinario->extHoraInicioSesion10 == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ $extraordinario->extHoraInicioSesion10 == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ $extraordinario->extHoraInicioSesion10 == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ $extraordinario->extHoraInicioSesion10 == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ $extraordinario->extHoraInicioSesion10 == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ $extraordinario->extHoraInicioSesion10 == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ $extraordinario->extHoraInicioSesion10 == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ $extraordinario->extHoraInicioSesion10 == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ $extraordinario->extHoraInicioSesion10 == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ $extraordinario->extHoraInicioSesion10 == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ $extraordinario->extHoraInicioSesion10 == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="extHoraFinSesion10">Hora fin *</label>
                        <select id="extHoraFinSesion10" class="browser-default validate select2" name="extHoraFinSesion10" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ $extraordinario->extHoraFinSesion10 == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ $extraordinario->extHoraFinSesion10 == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ $extraordinario->extHoraFinSesion10 == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ $extraordinario->extHoraFinSesion10 == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ $extraordinario->extHoraFinSesion10 == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ $extraordinario->extHoraFinSesion10 == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ $extraordinario->extHoraFinSesion10 == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ $extraordinario->extHoraFinSesion10 == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ $extraordinario->extHoraFinSesion10 == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ $extraordinario->extHoraFinSesion10 == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ $extraordinario->extHoraFinSesion10 == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ $extraordinario->extHoraFinSesion10 == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ $extraordinario->extHoraFinSesion10 == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ $extraordinario->extHoraFinSesion10 == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ $extraordinario->extHoraFinSesion10 == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ $extraordinario->extHoraFinSesion10 == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ $extraordinario->extHoraFinSesion10 == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ $extraordinario->extHoraFinSesion10 == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ $extraordinario->extHoraFinSesion10 == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ $extraordinario->extHoraFinSesion10 == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ $extraordinario->extHoraFinSesion10 == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ $extraordinario->extHoraFinSesion10 == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ $extraordinario->extHoraFinSesion10 == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ $extraordinario->extHoraFinSesion10 == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Sesión 11</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extFechaSesion11', 'Fecha sesión *', array('class' => '')); !!}
                        {!! Form::date('extFechaSesion11', $extraordinario->extFechaSesion11, array('id' => 'extFechaSesion11', 'class' => 'validate')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioSesion11', 'Hora de inicio *', array('class' => '')); !!}
                        <select id="extHoraInicioSesion11" class="browser-default validate select2" name="extHoraInicioSesion11" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ $extraordinario->extHoraInicioSesion11 == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ $extraordinario->extHoraInicioSesion11 == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ $extraordinario->extHoraInicioSesion11 == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ $extraordinario->extHoraInicioSesion11 == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ $extraordinario->extHoraInicioSesion11 == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ $extraordinario->extHoraInicioSesion11 == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ $extraordinario->extHoraInicioSesion11 == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ $extraordinario->extHoraInicioSesion11 == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ $extraordinario->extHoraInicioSesion11 == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ $extraordinario->extHoraInicioSesion11 == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ $extraordinario->extHoraInicioSesion11 == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ $extraordinario->extHoraInicioSesion11 == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ $extraordinario->extHoraInicioSesion11 == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ $extraordinario->extHoraInicioSesion11 == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ $extraordinario->extHoraInicioSesion11 == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ $extraordinario->extHoraInicioSesion11 == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ $extraordinario->extHoraInicioSesion11 == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ $extraordinario->extHoraInicioSesion11 == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ $extraordinario->extHoraInicioSesion11 == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ $extraordinario->extHoraInicioSesion11 == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ $extraordinario->extHoraInicioSesion11 == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ $extraordinario->extHoraInicioSesion11 == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ $extraordinario->extHoraInicioSesion11 == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ $extraordinario->extHoraInicioSesion11 == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="extHoraFinSesion11">Hora fin *</label>
                        <select id="extHoraFinSesion11" class="browser-default validate select2" name="extHoraFinSesion11" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ $extraordinario->extHoraFinSesion11 == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ $extraordinario->extHoraFinSesion11 == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ $extraordinario->extHoraFinSesion11 == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ $extraordinario->extHoraFinSesion11 == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ $extraordinario->extHoraFinSesion11 == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ $extraordinario->extHoraFinSesion11 == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ $extraordinario->extHoraFinSesion11 == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ $extraordinario->extHoraFinSesion11 == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ $extraordinario->extHoraFinSesion11 == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ $extraordinario->extHoraFinSesion11 == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ $extraordinario->extHoraFinSesion11 == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ $extraordinario->extHoraFinSesion11 == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ $extraordinario->extHoraFinSesion11 == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ $extraordinario->extHoraFinSesion11 == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ $extraordinario->extHoraFinSesion11 == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ $extraordinario->extHoraFinSesion11 == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ $extraordinario->extHoraFinSesion11 == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ $extraordinario->extHoraFinSesion11 == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ $extraordinario->extHoraFinSesion11 == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ $extraordinario->extHoraFinSesion11 == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ $extraordinario->extHoraFinSesion11 == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ $extraordinario->extHoraFinSesion11 == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ $extraordinario->extHoraFinSesion11 == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ $extraordinario->extHoraFinSesion11 == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Sesión 12</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extFechaSesion12', 'Fecha sesión *', array('class' => '')); !!}
                        {!! Form::date('extFechaSesion12', $extraordinario->extFechaSesion12, array('id' => 'extFechaSesion12', 'class' => 'validate')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioSesion12', 'Hora de inicio *', array('class' => '')); !!}
                        <select id="extHoraInicioSesion12" class="browser-default validate select2" name="extHoraInicioSesion12" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ $extraordinario->extHoraInicioSesion12 == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ $extraordinario->extHoraInicioSesion12 == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ $extraordinario->extHoraInicioSesion12 == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ $extraordinario->extHoraInicioSesion12 == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ $extraordinario->extHoraInicioSesion12 == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ $extraordinario->extHoraInicioSesion12 == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ $extraordinario->extHoraInicioSesion12 == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ $extraordinario->extHoraInicioSesion12 == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ $extraordinario->extHoraInicioSesion12 == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ $extraordinario->extHoraInicioSesion12 == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ $extraordinario->extHoraInicioSesion12 == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ $extraordinario->extHoraInicioSesion12 == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ $extraordinario->extHoraInicioSesion12 == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ $extraordinario->extHoraInicioSesion12 == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ $extraordinario->extHoraInicioSesion12 == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ $extraordinario->extHoraInicioSesion12 == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ $extraordinario->extHoraInicioSesion12 == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ $extraordinario->extHoraInicioSesion12 == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ $extraordinario->extHoraInicioSesion12 == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ $extraordinario->extHoraInicioSesion12 == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ $extraordinario->extHoraInicioSesion12 == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ $extraordinario->extHoraInicioSesion12 == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ $extraordinario->extHoraInicioSesion12 == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ $extraordinario->extHoraInicioSesion12 == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="extHoraFinSesion12">Hora fin *</label>
                        <select id="extHoraFinSesion12" class="browser-default validate select2" name="extHoraFinSesion12" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ $extraordinario->extHoraFinSesion12 == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ $extraordinario->extHoraFinSesion12 == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ $extraordinario->extHoraFinSesion12 == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ $extraordinario->extHoraFinSesion12 == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ $extraordinario->extHoraFinSesion12 == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ $extraordinario->extHoraFinSesion12 == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ $extraordinario->extHoraFinSesion12 == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ $extraordinario->extHoraFinSesion12 == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ $extraordinario->extHoraFinSesion12 == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ $extraordinario->extHoraFinSesion12 == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ $extraordinario->extHoraFinSesion12 == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ $extraordinario->extHoraFinSesion12 == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ $extraordinario->extHoraFinSesion12 == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ $extraordinario->extHoraFinSesion12 == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ $extraordinario->extHoraFinSesion12 == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ $extraordinario->extHoraFinSesion12 == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ $extraordinario->extHoraFinSesion12 == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ $extraordinario->extHoraFinSesion12 == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ $extraordinario->extHoraFinSesion12 == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ $extraordinario->extHoraFinSesion12 == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ $extraordinario->extHoraFinSesion12 == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ $extraordinario->extHoraFinSesion12 == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ $extraordinario->extHoraFinSesion12 == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ $extraordinario->extHoraFinSesion12 == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Sesión 13</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extFechaSesion13', 'Fecha sesión *', array('class' => '')); !!}
                        {!! Form::date('extFechaSesion13', $extraordinario->extFechaSesion13, array('id' => 'extFechaSesion13', 'class' => 'validate')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioSesion13', 'Hora de inicio *', array('class' => '')); !!}
                        <select id="extHoraInicioSesion13" class="browser-default validate select2" name="extHoraInicioSesion13" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ $extraordinario->extHoraInicioSesion13 == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ $extraordinario->extHoraInicioSesion13 == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ $extraordinario->extHoraInicioSesion13 == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ $extraordinario->extHoraInicioSesion13 == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ $extraordinario->extHoraInicioSesion13 == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ $extraordinario->extHoraInicioSesion13 == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ $extraordinario->extHoraInicioSesion13 == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ $extraordinario->extHoraInicioSesion13 == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ $extraordinario->extHoraInicioSesion13 == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ $extraordinario->extHoraInicioSesion13 == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ $extraordinario->extHoraInicioSesion13 == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ $extraordinario->extHoraInicioSesion13 == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ $extraordinario->extHoraInicioSesion13 == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ $extraordinario->extHoraInicioSesion13 == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ $extraordinario->extHoraInicioSesion13 == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ $extraordinario->extHoraInicioSesion13 == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ $extraordinario->extHoraInicioSesion13 == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ $extraordinario->extHoraInicioSesion13 == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ $extraordinario->extHoraInicioSesion13 == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ $extraordinario->extHoraInicioSesion13 == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ $extraordinario->extHoraInicioSesion13 == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ $extraordinario->extHoraInicioSesion13 == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ $extraordinario->extHoraInicioSesion13 == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ $extraordinario->extHoraInicioSesion13 == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="extHoraFinSesion13">Hora fin *</label>
                        <select id="extHoraFinSesion13" class="browser-default validate select2" name="extHoraFinSesion13" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ $extraordinario->extHoraFinSesion13 == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ $extraordinario->extHoraFinSesion13 == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ $extraordinario->extHoraFinSesion13 == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ $extraordinario->extHoraFinSesion13 == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ $extraordinario->extHoraFinSesion13 == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ $extraordinario->extHoraFinSesion13 == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ $extraordinario->extHoraFinSesion13 == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ $extraordinario->extHoraFinSesion13 == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ $extraordinario->extHoraFinSesion13 == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ $extraordinario->extHoraFinSesion13 == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ $extraordinario->extHoraFinSesion13 == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ $extraordinario->extHoraFinSesion13 == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ $extraordinario->extHoraFinSesion13 == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ $extraordinario->extHoraFinSesion13 == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ $extraordinario->extHoraFinSesion13 == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ $extraordinario->extHoraFinSesion13 == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ $extraordinario->extHoraFinSesion13 == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ $extraordinario->extHoraFinSesion13 == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ $extraordinario->extHoraFinSesion13 == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ $extraordinario->extHoraFinSesion13 == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ $extraordinario->extHoraFinSesion13 == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ $extraordinario->extHoraFinSesion13 == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ $extraordinario->extHoraFinSesion13 == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ $extraordinario->extHoraFinSesion13 == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Sesión 14</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extFechaSesion14', 'Fecha sesión *', array('class' => '')); !!}
                        {!! Form::date('extFechaSesion14', $extraordinario->extFechaSesion14, array('id' => 'extFechaSesion14', 'class' => 'validate')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioSesion14', 'Hora de inicio *', array('class' => '')); !!}
                        <select id="extHoraInicioSesion14" class="browser-default validate select2" name="extHoraInicioSesion14" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ $extraordinario->extHoraInicioSesion14 == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ $extraordinario->extHoraInicioSesion14 == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ $extraordinario->extHoraInicioSesion14 == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ $extraordinario->extHoraInicioSesion14 == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ $extraordinario->extHoraInicioSesion14 == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ $extraordinario->extHoraInicioSesion14 == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ $extraordinario->extHoraInicioSesion14 == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ $extraordinario->extHoraInicioSesion14 == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ $extraordinario->extHoraInicioSesion14 == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ $extraordinario->extHoraInicioSesion14 == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ $extraordinario->extHoraInicioSesion14 == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ $extraordinario->extHoraInicioSesion14 == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ $extraordinario->extHoraInicioSesion14 == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ $extraordinario->extHoraInicioSesion14 == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ $extraordinario->extHoraInicioSesion14 == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ $extraordinario->extHoraInicioSesion14 == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ $extraordinario->extHoraInicioSesion14 == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ $extraordinario->extHoraInicioSesion14 == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ $extraordinario->extHoraInicioSesion14 == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ $extraordinario->extHoraInicioSesion14 == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ $extraordinario->extHoraInicioSesion14 == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ $extraordinario->extHoraInicioSesion14 == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ $extraordinario->extHoraInicioSesion14 == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ $extraordinario->extHoraInicioSesion14 == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="extHoraFinSesion14">Hora fin *</label>
                        <select id="extHoraFinSesion14" class="browser-default validate select2" name="extHoraFinSesion14" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ $extraordinario->extHoraFinSesion14 == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ $extraordinario->extHoraFinSesion14 == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ $extraordinario->extHoraFinSesion14 == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ $extraordinario->extHoraFinSesion14 == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ $extraordinario->extHoraFinSesion14 == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ $extraordinario->extHoraFinSesion14 == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ $extraordinario->extHoraFinSesion14 == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ $extraordinario->extHoraFinSesion14 == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ $extraordinario->extHoraFinSesion14 == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ $extraordinario->extHoraFinSesion14 == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ $extraordinario->extHoraFinSesion14 == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ $extraordinario->extHoraFinSesion14 == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ $extraordinario->extHoraFinSesion14 == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ $extraordinario->extHoraFinSesion14 == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ $extraordinario->extHoraFinSesion14 == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ $extraordinario->extHoraFinSesion14 == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ $extraordinario->extHoraFinSesion14 == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ $extraordinario->extHoraFinSesion14 == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ $extraordinario->extHoraFinSesion14 == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ $extraordinario->extHoraFinSesion14 == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ $extraordinario->extHoraFinSesion14 == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ $extraordinario->extHoraFinSesion14 == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ $extraordinario->extHoraFinSesion14 == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ $extraordinario->extHoraFinSesion14 == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>
                    </div>
                </div>


                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Sesión 15</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extFechaSesion15', 'Fecha sesión *', array('class' => '')); !!}
                        {!! Form::date('extFechaSesion15', $extraordinario->extFechaSesion15, array('id' => 'extFechaSesion15', 'class' => 'validate')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioSesion15', 'Hora de inicio *', array('class' => '')); !!}
                        <select id="extHoraInicioSesion15" class="browser-default validate select2" name="extHoraInicioSesion15" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ $extraordinario->extHoraInicioSesion15 == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ $extraordinario->extHoraInicioSesion15 == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ $extraordinario->extHoraInicioSesion15 == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ $extraordinario->extHoraInicioSesion15 == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ $extraordinario->extHoraInicioSesion15 == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ $extraordinario->extHoraInicioSesion15 == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ $extraordinario->extHoraInicioSesion15 == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ $extraordinario->extHoraInicioSesion15 == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ $extraordinario->extHoraInicioSesion15 == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ $extraordinario->extHoraInicioSesion15 == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ $extraordinario->extHoraInicioSesion15 == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ $extraordinario->extHoraInicioSesion15 == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ $extraordinario->extHoraInicioSesion15 == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ $extraordinario->extHoraInicioSesion15 == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ $extraordinario->extHoraInicioSesion15 == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ $extraordinario->extHoraInicioSesion15 == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ $extraordinario->extHoraInicioSesion15 == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ $extraordinario->extHoraInicioSesion15 == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ $extraordinario->extHoraInicioSesion15 == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ $extraordinario->extHoraInicioSesion15 == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ $extraordinario->extHoraInicioSesion15 == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ $extraordinario->extHoraInicioSesion15 == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ $extraordinario->extHoraInicioSesion15 == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ $extraordinario->extHoraInicioSesion15 == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="extHoraFinSesion15">Hora fin *</label>
                        <select id="extHoraFinSesion15" class="browser-default validate select2" name="extHoraFinSesion15" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ $extraordinario->extHoraFinSesion15 == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ $extraordinario->extHoraFinSesion15 == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ $extraordinario->extHoraFinSesion15 == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ $extraordinario->extHoraFinSesion15 == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ $extraordinario->extHoraFinSesion15 == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ $extraordinario->extHoraFinSesion15 == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ $extraordinario->extHoraFinSesion15 == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ $extraordinario->extHoraFinSesion15 == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ $extraordinario->extHoraFinSesion15 == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ $extraordinario->extHoraFinSesion15 == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ $extraordinario->extHoraFinSesion15 == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ $extraordinario->extHoraFinSesion15 == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ $extraordinario->extHoraFinSesion15 == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ $extraordinario->extHoraFinSesion15 == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ $extraordinario->extHoraFinSesion15 == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ $extraordinario->extHoraFinSesion15 == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ $extraordinario->extHoraFinSesion15 == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ $extraordinario->extHoraFinSesion15 == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ $extraordinario->extHoraFinSesion15 == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ $extraordinario->extHoraFinSesion15 == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ $extraordinario->extHoraFinSesion15 == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ $extraordinario->extHoraFinSesion15 == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ $extraordinario->extHoraFinSesion15 == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ $extraordinario->extHoraFinSesion15 == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Sesión 16</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extFechaSesion16', 'Fecha sesión *', array('class' => '')); !!}
                        {!! Form::date('extFechaSesion16', $extraordinario->extFechaSesion16, array('id' => 'extFechaSesion16', 'class' => 'validate')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioSesion16', 'Hora de inicio *', array('class' => '')); !!}
                        <select id="extHoraInicioSesion16" class="browser-default validate select2" name="extHoraInicioSesion16" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ $extraordinario->extHoraInicioSesion16 == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ $extraordinario->extHoraInicioSesion16 == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ $extraordinario->extHoraInicioSesion16 == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ $extraordinario->extHoraInicioSesion16 == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ $extraordinario->extHoraInicioSesion16 == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ $extraordinario->extHoraInicioSesion16 == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ $extraordinario->extHoraInicioSesion16 == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ $extraordinario->extHoraInicioSesion16 == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ $extraordinario->extHoraInicioSesion16 == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ $extraordinario->extHoraInicioSesion16 == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ $extraordinario->extHoraInicioSesion16 == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ $extraordinario->extHoraInicioSesion16 == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ $extraordinario->extHoraInicioSesion16 == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ $extraordinario->extHoraInicioSesion16 == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ $extraordinario->extHoraInicioSesion16 == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ $extraordinario->extHoraInicioSesion16 == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ $extraordinario->extHoraInicioSesion16 == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ $extraordinario->extHoraInicioSesion16 == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ $extraordinario->extHoraInicioSesion16 == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ $extraordinario->extHoraInicioSesion16 == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ $extraordinario->extHoraInicioSesion16 == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ $extraordinario->extHoraInicioSesion16 == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ $extraordinario->extHoraInicioSesion16 == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ $extraordinario->extHoraInicioSesion16 == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="extHoraFinSesion16">Hora fin *</label>
                        <select id="extHoraFinSesion16" class="browser-default validate select2" name="extHoraFinSesion16" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ $extraordinario->extHoraFinSesion16 == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ $extraordinario->extHoraFinSesion16 == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ $extraordinario->extHoraFinSesion16 == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ $extraordinario->extHoraFinSesion16 == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ $extraordinario->extHoraFinSesion16 == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ $extraordinario->extHoraFinSesion16 == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ $extraordinario->extHoraFinSesion16 == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ $extraordinario->extHoraFinSesion16 == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ $extraordinario->extHoraFinSesion16 == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ $extraordinario->extHoraFinSesion16 == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ $extraordinario->extHoraFinSesion16 == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ $extraordinario->extHoraFinSesion16 == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ $extraordinario->extHoraFinSesion16 == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ $extraordinario->extHoraFinSesion16 == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ $extraordinario->extHoraFinSesion16 == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ $extraordinario->extHoraFinSesion16 == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ $extraordinario->extHoraFinSesion16 == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ $extraordinario->extHoraFinSesion16 == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ $extraordinario->extHoraFinSesion16 == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ $extraordinario->extHoraFinSesion16 == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ $extraordinario->extHoraFinSesion16 == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ $extraordinario->extHoraFinSesion16 == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ $extraordinario->extHoraFinSesion16 == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ $extraordinario->extHoraFinSesion16 == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Sesión 17</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extFechaSesion17', 'Fecha sesión *', array('class' => '')); !!}
                        {!! Form::date('extFechaSesion17', $extraordinario->extFechaSesion17, array('id' => 'extFechaSesion17', 'class' => 'validate')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioSesion17', 'Hora de inicio *', array('class' => '')); !!}
                        <select id="extHoraInicioSesion17" class="browser-default validate select2" name="extHoraInicioSesion17" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ $extraordinario->extHoraInicioSesion17 == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ $extraordinario->extHoraInicioSesion17 == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ $extraordinario->extHoraInicioSesion17 == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ $extraordinario->extHoraInicioSesion17 == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ $extraordinario->extHoraInicioSesion17 == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ $extraordinario->extHoraInicioSesion17 == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ $extraordinario->extHoraInicioSesion17 == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ $extraordinario->extHoraInicioSesion17 == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ $extraordinario->extHoraInicioSesion17 == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ $extraordinario->extHoraInicioSesion17 == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ $extraordinario->extHoraInicioSesion17 == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ $extraordinario->extHoraInicioSesion17 == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ $extraordinario->extHoraInicioSesion17 == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ $extraordinario->extHoraInicioSesion17 == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ $extraordinario->extHoraInicioSesion17 == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ $extraordinario->extHoraInicioSesion17 == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ $extraordinario->extHoraInicioSesion17 == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ $extraordinario->extHoraInicioSesion17 == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ $extraordinario->extHoraInicioSesion17 == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ $extraordinario->extHoraInicioSesion17 == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ $extraordinario->extHoraInicioSesion17 == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ $extraordinario->extHoraInicioSesion17 == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ $extraordinario->extHoraInicioSesion17 == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ $extraordinario->extHoraInicioSesion17 == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="extHoraFinSesion17">Hora fin *</label>
                        <select id="extHoraFinSesion17" class="browser-default validate select2" name="extHoraFinSesion17" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ $extraordinario->extHoraFinSesion17 == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ $extraordinario->extHoraFinSesion17 == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ $extraordinario->extHoraFinSesion17 == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ $extraordinario->extHoraFinSesion17 == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ $extraordinario->extHoraFinSesion17 == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ $extraordinario->extHoraFinSesion17 == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ $extraordinario->extHoraFinSesion17 == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ $extraordinario->extHoraFinSesion17 == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ $extraordinario->extHoraFinSesion17 == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ $extraordinario->extHoraFinSesion17 == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ $extraordinario->extHoraFinSesion17 == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ $extraordinario->extHoraFinSesion17 == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ $extraordinario->extHoraFinSesion17 == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ $extraordinario->extHoraFinSesion17 == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ $extraordinario->extHoraFinSesion17 == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ $extraordinario->extHoraFinSesion17 == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ $extraordinario->extHoraFinSesion17 == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ $extraordinario->extHoraFinSesion17 == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ $extraordinario->extHoraFinSesion17 == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ $extraordinario->extHoraFinSesion17 == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ $extraordinario->extHoraFinSesion17 == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ $extraordinario->extHoraFinSesion17 == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ $extraordinario->extHoraFinSesion17 == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ $extraordinario->extHoraFinSesion17 == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>
                    </div>
                </div>

                <div class="row" style="background-color:#ECECEC;">
                    <p style="text-align: center;font-size:1.2em;">Sesión 18</p>
                </div>
                <div class="row">                    
                    <div class="col s12 m6 l4">
                        {!! Form::label('extFechaSesion18', 'Fecha sesión *', array('class' => '')); !!}
                        {!! Form::date('extFechaSesion18', $extraordinario->extFechaSesion18, array('id' => 'extFechaSesion18', 'class' => 'validate')) !!}
                    </div>

                    <div class="col s12 m6 l4">
                        {!! Form::label('extHoraInicioSesion18', 'Hora de inicio *', array('class' => '')); !!}
                        <select id="extHoraInicioSesion18" class="browser-default validate select2" name="extHoraInicioSesion18" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ $extraordinario->extHoraInicioSesion18 == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ $extraordinario->extHoraInicioSesion18 == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ $extraordinario->extHoraInicioSesion18 == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ $extraordinario->extHoraInicioSesion18 == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ $extraordinario->extHoraInicioSesion18 == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ $extraordinario->extHoraInicioSesion18 == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ $extraordinario->extHoraInicioSesion18 == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ $extraordinario->extHoraInicioSesion18 == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ $extraordinario->extHoraInicioSesion18 == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ $extraordinario->extHoraInicioSesion18 == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ $extraordinario->extHoraInicioSesion18 == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ $extraordinario->extHoraInicioSesion18 == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ $extraordinario->extHoraInicioSesion18 == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ $extraordinario->extHoraInicioSesion18 == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ $extraordinario->extHoraInicioSesion18 == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ $extraordinario->extHoraInicioSesion18 == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ $extraordinario->extHoraInicioSesion18 == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ $extraordinario->extHoraInicioSesion18 == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ $extraordinario->extHoraInicioSesion18 == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ $extraordinario->extHoraInicioSesion18 == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ $extraordinario->extHoraInicioSesion18 == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ $extraordinario->extHoraInicioSesion18 == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ $extraordinario->extHoraInicioSesion18 == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ $extraordinario->extHoraInicioSesion18 == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>
                    </div>
                    <div class="col s12 m6 l4">
                        <label for="extHoraFinSesion18">Hora fin *</label>
                        <select id="extHoraFinSesion18" class="browser-default validate select2" name="extHoraFinSesion18" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            <option value="00" {{ $extraordinario->extHoraFinSesion18 == "00" ? 'selected' : '' }}>00</option>
                            <option value="01" {{ $extraordinario->extHoraFinSesion18 == "01" ? 'selected' : '' }}>01</option>
                            <option value="02" {{ $extraordinario->extHoraFinSesion18 == "02" ? 'selected' : '' }}>02</option>
                            <option value="03" {{ $extraordinario->extHoraFinSesion18 == "03" ? 'selected' : '' }}>03</option>
                            <option value="04" {{ $extraordinario->extHoraFinSesion18 == "04" ? 'selected' : '' }}>04</option>
                            <option value="05" {{ $extraordinario->extHoraFinSesion18 == "05" ? 'selected' : '' }}>05</option>
                            <option value="06" {{ $extraordinario->extHoraFinSesion18 == "06" ? 'selected' : '' }}>06</option>
                            <option value="07" {{ $extraordinario->extHoraFinSesion18 == "07" ? 'selected' : '' }}>07</option>
                            <option value="08" {{ $extraordinario->extHoraFinSesion18 == "08" ? 'selected' : '' }}>08</option>
                            <option value="09" {{ $extraordinario->extHoraFinSesion18 == "09" ? 'selected' : '' }}>09</option>
                            <option value="10" {{ $extraordinario->extHoraFinSesion18 == "10" ? 'selected' : '' }}>10</option>
                            <option value="11" {{ $extraordinario->extHoraFinSesion18 == "11" ? 'selected' : '' }}>11</option>
                            <option value="12" {{ $extraordinario->extHoraFinSesion18 == "12" ? 'selected' : '' }}>12</option>
                            <option value="13" {{ $extraordinario->extHoraFinSesion18 == "13" ? 'selected' : '' }}>13</option>
                            <option value="14" {{ $extraordinario->extHoraFinSesion18 == "14" ? 'selected' : '' }}>14</option>
                            <option value="15" {{ $extraordinario->extHoraFinSesion18 == "15" ? 'selected' : '' }}>15</option>
                            <option value="16" {{ $extraordinario->extHoraFinSesion18 == "16" ? 'selected' : '' }}>16</option>
                            <option value="17" {{ $extraordinario->extHoraFinSesion18 == "17" ? 'selected' : '' }}>17</option>
                            <option value="18" {{ $extraordinario->extHoraFinSesion18 == "18" ? 'selected' : '' }}>18</option>
                            <option value="19" {{ $extraordinario->extHoraFinSesion18 == "19" ? 'selected' : '' }}>19</option>
                            <option value="20" {{ $extraordinario->extHoraFinSesion18 == "20" ? 'selected' : '' }}>20</option>
                            <option value="21" {{ $extraordinario->extHoraFinSesion18 == "21" ? 'selected' : '' }}>21</option>
                            <option value="22" {{ $extraordinario->extHoraFinSesion18 == "22" ? 'selected' : '' }}>22</option>
                            <option value="23" {{ $extraordinario->extHoraFinSesion18 == "23" ? 'selected' : '' }}>23</option>                                                      
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m6">
                        {!! Form::label('empleado_id', 'Docente *', array('class' => '')); !!}
                        <select id="empleado_id" class="browser-default validate select2" required name="empleado_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            @foreach($empleados as $empleado)
                                <option value="{{$empleado->id}}" {{ $empleado->id == $extraordinario->bachiller_empleado_id ? 'selected' : '' }}>{{$empleado->id ." - ".$empleado->empNombre ." ". $empleado->empApellido1." ".$empleado->empApellido2}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col s12 m6">
                        {!! Form::label('empleado_sinodal_id', 'Sinodal', array('class' => '')); !!}
                        <select id="empleado_sinodal_id" class="browser-default validate select2" name="empleado_sinodal_id" style="width: 100%;">
                            <option value="" selected disabled>SELECCIONE UNA OPCIÓN</option>
                            @foreach($empleados as $empleado)
                                <option value="{{$empleado->id}}" {{ $empleado->id == $extraordinario->bachiller_empleado_sinodal_id ? 'selected' : '' }}>{{$empleado->id ." - ".$empleado->empNombre ." ". $empleado->empApellido1." ".$empleado->empApellido2}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

          </div>
          <div class="card-action">
            {!! Form::button('<i class="material-icons left">save</i> Guardar', ['class' => 'btn-large waves-effect  darken-3','type' => 'submit']) !!}
          </div>
        </div>
      {!! Form::close() !!}
    </div>
  </div>

@endsection

@section('footer_scripts')

{{--  @include('scripts.aulas')  --}}

@endsection