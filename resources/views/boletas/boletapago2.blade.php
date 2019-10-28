<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Boletas</title>
        <link href="{{ asset('sximo/js/plugins/bootstrap/css/bootstrap.css')}}" rel="stylesheet"> 
        <link href="{{ asset('sximo/js/plugins/jasny-bootstrap/css/jasny-bootstrap.min.css')}}" rel="stylesheet">
        <link href="{{ asset('jl/core/styles/boletas/boletas.css')}}" rel="stylesheet">
    </head>   
    <body class="letra" >           
        @foreach ($planillas as $planilla) 
            <div class="pagina">
                <div class="row">
                    <div class="col-xs-3" >
                        <img src="{{asset('/uploads/logos/'.$planilla->ruc.'.png')}}" width="220" height="55" />
                    </div>
                    <div class="col-xs-6 titulo"> 
                        BOLETA DE PAGO </br>
                        DECRETO SUPREMO N° 020-2008-TR DEL 15-01-08 </br>
                        MES DE {{ $planilla->mes}} 2018 </br>
                        DEL 01/11/2017 AL 30/11/2017
                    </div>
                    <div class="col-xs-3 titulo" >
                        {{ $planilla->ruc }} </br>
                        {{ $planilla->razon_social }} </br>
                        {{ $planilla->direccion }} {{ $planilla->num_direccion }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-3" >
                        <table>
                            <tr> 
                                <th>DATOS DEL TRABAJADOR</th>
                            </tr> 
                        </table>
                    </div>
                </div>
                <table>
                    <tr> 
                        <th class="col-xs-1">CODIGO</th>
                        <th class="col-xs-5">APELLIDOS Y NOMBRES</th>
                        <th class="col-xs-1">DNI</th>
                        <th class="col-xs-2">F. NAC.</th>
                        <th class="col-xs-1">TIPO</th>
                        <th class="col-xs-2">CATEGORIA</th>
                    </tr> 
                    <tr> 
                        <td class="col-xs-1">001</td>
                        <td class="col-xs-5">{{ $planilla->ape_paterno }} {{ $planilla->ape_materno }}, {{ $planilla->nombres }}</td>
                        <td class="col-xs-1">{{ $planilla->num_doc }}</td>
                        <td class="col-xs-2">{{ $planilla->fecha_nacimiento }}</td>
                        <td class="col-xs-1">EMPLEADO</td>
                        <td class="col-xs-2">TRABAJADOR</td>
                    </tr>
                </table>
                <table>
                    <tr> 
                        <th class="col-xs-2">CARGO</th>
                        <th class="col-xs-1">ONP</th>
                        <th class="col-xs-2">AFP</th>
                        <th class="col-xs-2">CUSPP</th>
                        <th class="col-xs-2">F. ING.</th>
                        <th class="col-xs-1">INI.VAC.</th>
                        <th class="col-xs-1">FIN.VAC.</th>
                        <th class="col-xs-1">DIAS.VAC.</th>
                    </tr> 
                    <tr> 
                        <td class="col-xs-2">{{ $planilla->ocupacion }}</td>
                        <td class="col-xs-1"></td>
                        <td class="col-xs-2"></td>
                        <td class="col-xs-2"></td>
                        <td class="col-xs-2">{{ $planilla->fecha_ingreso }}</td>
                        <td class="col-xs-1"></td>
                        <td class="col-xs-1"></td>
                        <td class="col-xs-1"></td>
                    </tr>
                </table>
                <div class="row">
                    <div class="col-xs-9" >
                        <table>
                            <tr>
                                <th>D. TRAB.</th>
                                <th>D. DESC.</th>
                                <th>D. FALTA</th> 
                                <th>D. FERIADO</th>
                                <th>H. TRAB.</th>
                                <th>H. TARDZ.</th>
                                <th>REM.MEN.</th>
                                <th>R. DIA</th>
                                <th>R. HORA</th>
                            </tr> 
                            <tr> 
                                <td>{{ $planilla->dias_computables }}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <table>
                    <tr> 
                        <th class="col-xs-4">INGRESOS</th>
                        <th class="col-xs-4">DESCUENTOS</th>
                        <th class="col-xs-4">APORTE PATRONAL</th>
                    </tr> 
                    <tr> 
                        <td class="col-xs-4 izquierda">
                            
                            <div class="row">
  <div class="col-xs-7"> Haber Básico </div>
  <div class="col-xs-5 importe"> {{ number_format( $planilla->c0121, 2 ) }} </div>
</div>
<div class="row">
  <div class="col-xs-7"> Asignación Familiar </div>
  <div class="col-xs-5 importe"> {{ number_format( $planilla->c0201, 2 ) }} </div>
</div>
<div class="row">
  <div class="col-xs-6">Rem. Vacacional</div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->c0118, 2 ) }} </div>
</div>
<div class="row">
  <div class="col-xs-6"> Descanso Médico </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->c0916, 2 ) }} </div>
</div>
<div class="row">
  <div class="col-xs-6"> Subsidios </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->importe_hn, 2 ) }} </div>
</div>
<div class="row">
  <div class="col-xs-6"> Lic. de paternidad </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->c0107, 2 ) }} </div>
</div>
<div class="row">
  <div class="col-xs-6"> Importe Nocturno </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->incentivos, 2 ) }} </div>
</div>
<div class="row">
  <div class="col-xs-6"> Bono </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->c0909, 2 ) }} </div>
</div>

                        </td>
                        <td class="col-xs-4 izquierda">
                            
                            <div class="row">
  <div class="col-xs-6"> ONP </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->c0607, 2 ) }} </div>
</div> 
<div class="row">
  <div class="col-xs-6"> AFP Comisión </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->c0601, 2 ) }} </div>
</div> 
<div class="row">
  <div class="col-xs-6"> AFP Fondo </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->c0608, 2 ) }} </div>
</div> 
<div class="row">
  <div class="col-xs-6"> AFP Seguro </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->c0606, 2 ) }} </div>
</div> 
<div class="row">
  <div class="col-xs-6"> Dcto. 5ta Cat. </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->c0605, 2 ) }} </div>
</div> 
<div class="row">
  <div class="col-xs-7"> Otros Dsctos./pres. </div>
  <div class="col-xs-5 importe"> {{ number_format( $planilla->c0706, 2 ) }} </div>
</div> 
<div class="row">
  <div class="col-xs-6"> EPS </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->prestamos, 2 ) }} </div>
</div> 
<div class="row">
  <div class="col-xs-6"> Adelanto Rem. </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->c0701, 2 ) }} </div>
</div> 
                            
                        </td>
                        <td class="col-xs-4 izquierda">
                            
<div class="row">
  <div class="col-xs-6"> Essalud </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->essalud, 2 ) }} </div>
</div> 
<div class="row">
  <div class="col-xs-6"> SCTR </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->essalud, 2 ) }} </div>
</div> 

                        </td>
                    </tr>
                    <tr> 
                        <th class="col-xs-4">
                            
                                <div class="row">
  <div class="col-xs-7"> TOTAL INGRESOS </div>
  <div class="col-xs-5 importe"> {{ number_format( $planilla->total_ingresos, 2 ) }} </div>
</div>
                            
                        </th>
                        <th class="col-xs-4">
                            
                                <div class="row">
  <div class="col-xs-8"> TOTAL DESCUENTOS </div>
  <div class="col-xs-4 importe"> {{ number_format( $planilla->total_descuentos, 2 ) }} </div>
</div>
                            
                        </th>
                        <th class="col-xs-4">
                            
                                <div class="row">
  <div class="col-xs-7"> NETO A PAGAR </div>
  <div class="col-xs-5 importe"> {{ number_format( $planilla->neto_pagar, 2 ) }} </div>
</div>
                            
                        </th>
                    </tr> 
                </table>
<div class="row">
  <div class="col-xs-12">Lima, 31 de Noviembre del 2017</div>
</div>
    </br></br></br>
<div class="row">
  <div class="col-xs-6 centro">EMPLEADOR </div>
  <div class="col-xs-6 centro">TRABAJADOR </div>
</div> 
    </br>
                <div class="row">
                    <div class="col-xs-3" >
                        <img src="{{asset('/uploads/logos/Captura.PNG')}}" width="220" height="55" />
                    </div>
                    <div class="col-xs-6 titulo"> 
                        BOLETA DE PAGO </br>
                        DECRETO SUPREMO N° 020-2008-TR DEL 15-01-08 </br>
                        MES DE {{ $planilla->mes}} 2018 </br>
                        DEL 01/11/2017 AL 30/11/2017
                    </div>
                    <div class="col-xs-3 titulo" >
                        {{ $planilla->ruc }} </br>
                        {{ $planilla->razon_social }} </br>
                        {{ $planilla->direccion }} {{ $planilla->num_direccion }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-3" >
                        <table>
                            <tr> 
                                <th>DATOS DEL TRABAJADOR</th>
                            </tr> 
                        </table>
                    </div>
                </div>
                <table>
                    <tr> 
                        <th class="col-xs-1">CODIGO</th>
                        <th class="col-xs-5">APELLIDOS Y NOMBRES</th>
                        <th class="col-xs-1">DNI</th>
                        <th class="col-xs-2">F. NAC.</th>
                        <th class="col-xs-1">TIPO</th>
                        <th class="col-xs-2">CATEGORIA</th>
                    </tr> 
                    <tr> 
                        <td class="col-xs-1">001</td>
                        <td class="col-xs-5">{{ $planilla->ape_paterno }} {{ $planilla->ape_materno }}, {{ $planilla->nombres }}</td>
                        <td class="col-xs-1">{{ $planilla->num_doc }}</td>
                        <td class="col-xs-2">{{ $planilla->fecha_nacimiento }}</td>
                        <td class="col-xs-1">EMPLEADO</td>
                        <td class="col-xs-2">TRABAJADOR</td>
                    </tr>
                </table>
                <table>
                    <tr> 
                        <th class="col-xs-2">CARGO</th>
                        <th class="col-xs-1">ONP</th>
                        <th class="col-xs-2">AFP</th>
                        <th class="col-xs-2">CUSPP</th>
                        <th class="col-xs-2">F. ING.</th>
                        <th class="col-xs-1">INI.VAC.</th>
                        <th class="col-xs-1">FIN.VAC.</th>
                        <th class="col-xs-1">DIAS.VAC.</th>
                    </tr> 
                    <tr> 
                        <td class="col-xs-2">{{ $planilla->ocupacion }}</td>
                        <td class="col-xs-1"></td>
                        <td class="col-xs-2"></td>
                        <td class="col-xs-2"></td>
                        <td class="col-xs-2">{{ $planilla->fecha_ingreso }}</td>
                        <td class="col-xs-1"></td>
                        <td class="col-xs-1"></td>
                        <td class="col-xs-1"></td>
                    </tr>
                </table>
                <div class="row">
                    <div class="col-xs-9" >
                        <table>
                            <tr>
                                <th>D. TRAB.</th>
                                <th>D. DESC.</th>
                                <th>D. FALTA</th> 
                                <th>D. FERIADO</th>
                                <th>H. TRAB.</th>
                                <th>H. TARDZ.</th>
                                <th>REM.MEN.</th>
                                <th>R. DIA</th>
                                <th>R. HORA</th>
                            </tr> 
                            <tr> 
                                <td>{{ $planilla->dias_computables }}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <table>
                    <tr> 
                        <th class="col-xs-4">INGRESOS</th>
                        <th class="col-xs-4">DESCUENTOS</th>
                        <th class="col-xs-4">APORTE PATRONAL</th>
                    </tr> 
                    <tr> 
                        <td class="col-xs-4 izquierda">
                            
                            <div class="row">
  <div class="col-xs-7"> Haber Básico </div>
  <div class="col-xs-5 importe"> {{ number_format( $planilla->c0121, 2 ) }} </div>
</div>
<div class="row">
  <div class="col-xs-7"> Asignación Familiar </div>
  <div class="col-xs-5 importe"> {{ number_format( $planilla->c0201, 2 ) }} </div>
</div>
<div class="row">
  <div class="col-xs-6">Rem. Vacacional</div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->c0118, 2 ) }} </div>
</div>
<div class="row">
  <div class="col-xs-6"> Descanso Médico </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->c0916, 2 ) }} </div>
</div>
<div class="row">
  <div class="col-xs-6"> Subsidios </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->importe_hn, 2 ) }} </div>
</div>
<div class="row">
  <div class="col-xs-6"> Lic. de paternidad </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->c0107, 2 ) }} </div>
</div>
<div class="row">
  <div class="col-xs-6"> Importe Nocturno </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->incentivos, 2 ) }} </div>
</div>
<div class="row">
  <div class="col-xs-6"> Bono </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->c0909, 2 ) }} </div>
</div>

                        </td>
                        <td class="col-xs-4 izquierda">
                            
                            <div class="row">
  <div class="col-xs-6"> ONP </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->c0607, 2 ) }} </div>
</div> 
<div class="row">
  <div class="col-xs-6"> AFP Comisión </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->c0601, 2 ) }} </div>
</div> 
<div class="row">
  <div class="col-xs-6"> AFP Fondo </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->c0608, 2 ) }} </div>
</div> 
<div class="row">
  <div class="col-xs-6"> AFP Seguro </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->c0606, 2 ) }} </div>
</div> 
<div class="row">
  <div class="col-xs-6"> Dcto. 5ta Cat. </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->c0605, 2 ) }} </div>
</div> 
<div class="row">
  <div class="col-xs-7"> Otros Dsctos./pres. </div>
  <div class="col-xs-5 importe"> {{ number_format( $planilla->c0706, 2 ) }} </div>
</div> 
<div class="row">
  <div class="col-xs-6"> EPS </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->prestamos, 2 ) }} </div>
</div> 
<div class="row">
  <div class="col-xs-6"> Adelanto Rem. </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->c0701, 2 ) }} </div>
</div> 
                            
                        </td>
                        <td class="col-xs-4 izquierda">
                            
<div class="row">
  <div class="col-xs-6"> Essalud </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->essalud, 2 ) }} </div>
</div> 
<div class="row">
  <div class="col-xs-6"> SCTR </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->essalud, 2 ) }} </div>
</div> 

                        </td>
                    </tr>
                    <tr> 
                        <th class="col-xs-4">
                            
                                <div class="row">
  <div class="col-xs-7"> TOTAL INGRESOS </div>
  <div class="col-xs-5 importe"> {{ number_format( $planilla->total_ingresos, 2 ) }} </div>
</div>
                            
                        </th>
                        <th class="col-xs-4">
                            
                                <div class="row">
  <div class="col-xs-8"> TOTAL DESCUENTOS </div>
  <div class="col-xs-4 importe"> {{ number_format( $planilla->total_descuentos, 2 ) }} </div>
</div>
                            
                        </th>
                        <th class="col-xs-4">
                            
                                <div class="row">
  <div class="col-xs-7"> NETO A PAGAR </div>
  <div class="col-xs-5 importe"> {{ number_format( $planilla->neto_pagar, 2 ) }} </div>
</div>
                            
                        </th>
                    </tr> 
                </table>
<div class="row">
  <div class="col-xs-12">Lima, 31 de Noviembre del 2017</div>
</div>
    </br></br></br>
<div class="row">
  <div class="col-xs-6 centro">EMPLEADOR </div>
  <div class="col-xs-6 centro">TRABAJADOR </div>
</div>
</div>
@endforeach
 </body>
</html>