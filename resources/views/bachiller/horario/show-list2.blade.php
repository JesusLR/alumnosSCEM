@extends('layouts.dashboard')



@section('template_title')
    Horarios del alumno
@endsection

@section('head')
    {!! HTML::style(asset('/vendors/data-tables/css/jquery.dataTables.min.css'), array('type' => 'text/css', 'rel' => 'stylesheet')) !!}
@endsection

@section('breadcrumbs')
    <a href="{{url('libreta_de_pago')}}" class="breadcrumb">Inicio</a>
    <a href="{{url('bachiller_horario_alumno')}}" class="breadcrumb">Horarios del alumno</a>
@endsection

@section('content')

<div id="table-datatables">
    <h4 class="header">Horarios del alumno</h4>
    <p><b>Clave:</b> {{$alumno->aluClave}}</p>
    <p><b>Nombre:</b> {{$persona->perNombre.' '.$persona->perApellido1.' '.$persona->perApellido2}} <a href="{{route('bachiller.bachiller_horario_clases_alumno.imprimir', ['aluClave' => $alumno->aluClave])}}" type="buttton" target="_blank" class="btn-large waves-effect darken-3"><i class="material-icons left">picture_as_pdf</i> Horario</a></p>
    <br>
    <br>
    @php
        $contador = 1;
        use App\Models\Bachiller\Bachiller_horarios;
    @endphp
    <style>
  
          table tbody tr:nth-child(odd) {
        background: #F3F4F7;
    }

    table tbody tr:nth-child(even) {
        background: #DFDCDB;
    }

    table th {
        background: #F3F3F3;
        color: #000;

    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    tr { background: white; } 
        tr.alt { background: #CDC9C9; }
        
        tr:hover {background: #CDC9C9;}
        td:hover {background:#CDC9C9;}
        </style>
    <div class="row">
        <div class="col s12">
            <table id="tbl-horario-alumno" class="cell-border" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Materia</th>
                        <th>Materia complementaria</th>
                        <th>Lunes</th>
                        <th>Martes</th>
                        <th>Miercoles</th>
                        <th>Jueves</th>
                        <th>Viernes</th>
                        <th>Sábado</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($agrupamos as $bachiller_grupo_id => $horarios)
                        @foreach ($horarios as $horario)
                            @if ($horario->bachiller_grupo_id == $bachiller_grupo_id && $contador++ == 1)
                            <tr>
                                <td>{{ $horario->materia }}</td>
                                <td>{{ $horario->materia_acd }}</td>
                                @php
                                    $bachiller_horarios = Bachiller_horarios::where('grupo_id', $bachiller_grupo_id)
                                    ->whereNull('deleted_at')
                                    ->orderBy('ghDia', 'ASC')
                                    ->orderBy('ghInicio', 'ASC')
                                    ->orderBy('gMinInicio', 'ASC')
                                    ->orderBy('ghFinal', 'ASC')
                                    ->orderBy('gMinFinal', 'ASC')
                                    ->get();
                                @endphp

                                {{--  lunes   --}}
                                <td>
                                    @foreach ($bachiller_horarios as $hora)
                                    
                                        @if ($hora->ghDia == 1)
                                            @if ($hora->ghInicio < 10)
                                                @php
                                                    $inicioL = '0'.$hora->ghInicio;
                                                @endphp
                                            @else     
                                                @php
                                                    $inicioL = $hora->ghInicio; 
                                                @endphp                                  
                                            @endif

                                            @if ($hora->ghFinal < 10)
                                                @php
                                                    $finL = '0'.$hora->ghFinal;
                                                @endphp
                                            @else     
                                                @php
                                                    $finL = $hora->ghFinal; 
                                                @endphp                                  
                                            @endif
                                            {{ $inicioL.':'.$hora->gMinInicio }} a {{ $finL.':'.$hora->gMinFinal }}
                                            <br>
                                        @endif                                        
                                    @endforeach
                                </td>
                                
                                {{--  martes   --}}
                                <td>
                                    @foreach ($bachiller_horarios as $hora)
                                    
                                        @if ($hora->ghDia == 2)
                                            @if ($hora->ghInicio < 10)
                                                @php
                                                    $inicioM = '0'.$hora->ghInicio;
                                                @endphp
                                            @else     
                                                @php
                                                    $inicioM = $hora->ghInicio; 
                                                @endphp                                  
                                            @endif

                                            @if ($hora->ghFinal < 10)
                                                @php
                                                    $finM = '0'.$hora->ghFinal;
                                                @endphp
                                            @else     
                                                @php
                                                    $finM = $hora->ghFinal; 
                                                @endphp                                  
                                            @endif
                                            {{ $inicioM.':'.$hora->gMinInicio }} a {{ $finM.':'.$hora->gMinFinal }}
                                            <br>
                                        @endif                                        
                                    @endforeach
                                </td>

                                {{--  miercoles   --}}
                                <td>
                                    @foreach ($bachiller_horarios as $hora)
                                    
                                        @if ($hora->ghDia == 3)
                                            @if ($hora->ghInicio < 10)
                                                @php
                                                    $inicioMi = '0'.$hora->ghInicio;
                                                @endphp
                                            @else     
                                                @php
                                                    $inicioMi = $hora->ghInicio; 
                                                @endphp                                  
                                            @endif

                                            @if ($hora->ghFinal < 10)
                                                @php
                                                    $finMi = '0'.$hora->ghFinal;
                                                @endphp
                                            @else     
                                                @php
                                                    $finMi = $hora->ghFinal; 
                                                @endphp                                  
                                            @endif
                                            {{ $inicioMi.':'.$hora->gMinInicio }} a {{ $finMi.':'.$hora->gMinFinal }}
                                            <br>
                                        @endif                                        
                                    @endforeach
                                </td>

                                {{--  jueves   --}}
                                <td>
                                    @foreach ($bachiller_horarios as $hora)
                                    
                                        @if ($hora->ghDia == 4)
                                            @if ($hora->ghInicio < 10)
                                                @php
                                                    $inicioJ = '0'.$hora->ghInicio;
                                                @endphp
                                            @else     
                                                @php
                                                    $inicioJ = $hora->ghInicio; 
                                                @endphp                                  
                                            @endif

                                            @if ($hora->ghFinal < 10)
                                                @php
                                                    $finJ = '0'.$hora->ghFinal;
                                                @endphp
                                            @else     
                                                @php
                                                    $finJ = $hora->ghFinal; 
                                                @endphp                                  
                                            @endif
                                            {{ $inicioJ.':'.$hora->gMinInicio }} a {{ $finJ.':'.$hora->gMinFinal }}
                                            <br>
                                        @endif                                        
                                    @endforeach
                                </td>

                                {{--  viernes   --}}
                                <td>
                                    @foreach ($bachiller_horarios as $hora)
                                    
                                        @if ($hora->ghDia == 5)
                                            @if ($hora->ghInicio < 10)
                                                @php
                                                    $inicioV = '0'.$hora->ghInicio;
                                                @endphp
                                            @else     
                                                @php
                                                    $inicioV = $hora->ghInicio; 
                                                @endphp                                  
                                            @endif

                                            @if ($hora->ghFinal < 10)
                                                @php
                                                    $finV = '0'.$hora->ghFinal;
                                                @endphp
                                            @else     
                                                @php
                                                    $finV = $hora->ghFinal; 
                                                @endphp                                  
                                            @endif
                                            {{ $inicioV.':'.$hora->gMinInicio }} a {{ $finV.':'.$hora->gMinFinal }}
                                            <br>
                                        @endif                                        
                                    @endforeach
                                </td>

                                {{--  sabado   --}}
                                <td>
                                    @foreach ($bachiller_horarios as $hora)
                                    
                                        @if ($hora->ghDia == 6)
                                            @if ($hora->ghInicio < 10)
                                                @php
                                                    $inicioS = '0'.$hora->ghInicio;
                                                @endphp
                                            @else     
                                                @php
                                                    $inicioS = $hora->ghInicio; 
                                                @endphp                                  
                                            @endif

                                            @if ($hora->ghFinal < 10)
                                                @php
                                                    $finS = '0'.$hora->ghFinal;
                                                @endphp
                                            @else     
                                                @php
                                                    $finS = $hora->ghFinal; 
                                                @endphp                                  
                                            @endif
                                            {{ $inicioS.':'.$hora->gMinInicio }} a {{ $finS.':'.$hora->gMinFinal }}
                                            <br>
                                        @endif                                        
                                    @endforeach
                                </td>
                            </tr>
                            @endif
                        @endforeach     
                        @php
                            $contador = 1;
                        @endphp               
                    @empty
                        
                    @endforelse
                </tbody>    
                <tfoot>
                    <tr>
                        <th style="background-color: #F3F3F3; color: #000">Materia</th>
                        <th style="background-color: #F3F3F3; color: #000">Materia complementaria</th>
                        <th style="background-color: #F3F3F3; color: #000">Lunes</th>
                        <th style="background-color: #F3F3F3; color: #000">Martes</th>
                        <th style="background-color: #F3F3F3; color: #000">Miercoles</th>
                        <th style="background-color: #F3F3F3; color: #000">Jueves</th>
                        <th style="background-color: #F3F3F3; color: #000">Viernes</th>
                        <th style="background-color: #F3F3F3; color: #000">Sábado</th>
                    </tr>
                </tfoot>           
            </table>
        </div>
    </div>
</div>

{{--  <div class="preloader">
    <div id="preloader"></div>
</div>  --}}


@endsection

@section('footer_scripts')

{{--  <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>  --}}
{!! HTML::script(asset('/bachiller/dataTables.js'), array('type' => 'text/javascript')) !!}



<script>
    new DataTable('#tbl-horario-alumno', {
        "pageLength": 15,
        "processing": true,
        initComplete: function () {
            this.api()
                .columns()
                .every(function () {
                    let column = this;
                    let title = column.footer().textContent;
     
                    // Create input element
                    let input = document.createElement('input');
                    input.placeholder = title;
                    column.footer().replaceChildren(input);
     
                    // Event listener for user input
                    input.addEventListener('keyup', () => {
                        if (column.search() !== this.value) {
                            column.search(input.value).draw();
                        }
                    });
                });
        }
    });
</script>

 <script type="text/javascript">
    /*$(document).ready(function() {
       
        
        $.fn.dataTable.ext.errMode = 'throw';
        
        $('#tbl-horario-alumno').dataTable({
            // "language":{"url":base_url+"/api/lang/javascript/datatables"},
            "order": [[ 0, 'asc' ]],
            "serverSide": true,
            "dom": '"top"i',
            "pageLength": 15,
            "stateSave": true,
            "columnDefs":[
                {
                    "targets": [0],
                    "visible": false,
                }            
                
            ],


            "ajax": {
                "type" : "GET",
                'url': base_url+"/api/bachiller_horario_alumno/",
                beforeSend: function () {
                    $('.preloader').fadeIn(200,function(){$(this).append('<div id="preloader"></div>');;});
                },
                complete: function () {
                    $('.preloader').fadeOut(200,function(){$('#preloader').remove();});
                }, error: function(XMLHttpRequest, textStatus, errorThrown) {
                    if (errorThrown === "Unauthorized") {
                        swal({
                            title: "Ups...",
                            text: "La sesion ha expirado",
                            type: "warning",
                            confirmButtonText: "Ok",
                            confirmButtonColor: '#3085d6',
                            showCancelButton: false
                            }, function(isConfirm) {
                            if (isConfirm) {
                                window.location.href = 'login';
                            } else {
                                window.location.href = 'login';
                            }
                        });
                    }
                }
            },
            
            "columns":[
                {data: "matClave"},
                {data: "materia"},
                {data: "materia_acd"},
                {data: "lunes"},
                {data: "martes"},
                {data: "miercoles"},
                {data: "jueves"},
                {data: "viernes"},
                {data: "sabado"}

            ],
            //Apply the search
            initComplete: function () {

                var searchFill = JSON.parse(localStorage.getItem( 'DataTables_' + this.api().context[0].sInstance ))

                var index = 0
                this.api().columns().every(function () {
                    var column = this;
                    var columnClass = column.footer().className;
                    if(columnClass != 'non_searchable'){
                        var input = document.createElement("input");


                        var columnDataOld = searchFill.columns[index].search.search
                        $(input).attr("placeholder", "Buscar").addClass("busquedas").val(columnDataOld);


                        $(input).appendTo($(column.footer()).empty())
                        .on('change', function () {
                            column.search($(this).val(), false, false, true).draw();
                        });
                    }

                    index ++
                });
            },

            stateSaveCallback: function(settings,data) {
                localStorage.setItem( 'DataTables_' + settings.sInstance, JSON.stringify(data) )
            },
            stateLoadCallback: function(settings) {
                return JSON.parse(localStorage.getItem( 'DataTables_' + settings.sInstance ) )
            }

        });

    });*/



</script>


@endsection