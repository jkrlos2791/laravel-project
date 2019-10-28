<!DOCTYPE html>
<html lang="en">
  <head>
  <meta charset="utf-8">
  <title>Shangel Perú</title>
  <link href="{{ asset('assets/css/cargo_cliente.css')}}" rel="stylesheet"> 
</head>   
<body> 
@foreach ($planillas as $planilla) 
<div class="pagina">
</br></br></br></br>
<div class="row">
  <div class="col-xs-4 negrita"> 
  {{ $planilla->razon_social }} 
  </br> 
  Perú 
  </br> 
  {{ $planilla->direccion }} {{ $planilla->num_direccion }}
  </br>
  RUC: {{ $planilla->ruc }}
  </div>
  <div class="col-xs-3 titulo"> 
  Boleta de Pago - {{ $planilla->mes}} 
  </br>
  Del 01/11/2017 al 30/11/2017
  </div>
   <div class="col-xs-5 derecha" >
   <img src="{{asset('/uploads/logos/Captura.PNG')}}" width="350" height="100" />
   </br>
   D.S. N° 020-2008-TR DEL 15-01-08
   </div>
</div>
</br></br>
<table class="table table-bordered">
<tr> 
<td colspan="3" class="">
<div class="row">
  <div class="col-xs-6"> Nombre:  {{ $planilla->ape_paterno }} {{ $planilla->ape_materno }}, {{ $planilla->nombres }}</div>
  <div class="col-xs-3"> F. Nac:  {{ $planilla->fecha_nacimiento }}</div>
  <div class="col-xs-3"> F. Ingreso: {{ $planilla->fecha_ingreso }}</div>
</div>     
<div class="row">
  <div class="col-xs-4"> Codigo: {{ $planilla->num_doc }} </div>
  <div class="col-xs-4"> D. Leg: 728 General </div>
  <div class="col-xs-4"> DNI: {{ $planilla->num_doc }} </div>
</div>   
<div class="row">
  <div class="col-xs-4"> Categ: 01 TRABAJADOR </div>
  <div class="col-xs-4"> D. TRAB: {{ $planilla->dias_computables }}</div>
  <div class="col-xs-4">  </div>
</div>   
<div class="row">
  <div class="col-xs-4"> Cargo: {{ $planilla->ocupacion }} </div>
  <div class="col-xs-4"> D. DESC: </div>
  <div class="col-xs-4">  </div>
</div>   
<div class="row">
  <div class="col-xs-4"> Tipo: EMPLEADO </div>
  <div class="col-xs-4"> D. FALTA: </div>
  <div class="col-xs-4">  </div>
</div> 
<div class="row">
  <div class="col-xs-4">  </div>
  <div class="col-xs-4"> D. FER: </div>
  <div class="col-xs-4">  </div>
</div>
    </td>   
    </tr> 
 <tr>
  <td class="">        
<div class="row titulo">
  <div class="col-xs-12"> INGRESOS </div>
</div>
<div class="row">
  <div class="col-xs-6"> Haber Básico </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->c0121, 2 ) }} </div>
</div>
<div class="row">
  <div class="col-xs-6"> Asignación Familiar </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->c0201, 2 ) }} </div>
</div>
<div class="row">
  <div class="col-xs-6"> Vacaciones </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->c0118, 2 ) }} </div>
</div>
<div class="row">
  <div class="col-xs-6"> Descanso Médico </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->c0916, 2 ) }} </div>
</div>
<div class="row">
  <div class="col-xs-6"> Importe Nocturno </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->importe_hn, 2 ) }} </div>
</div>
<div class="row">
  <div class="col-xs-6"> Feriados </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->c0107, 2 ) }} </div>
</div>
<div class="row">
  <div class="col-xs-6"> Incentivos </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->incentivos, 2 ) }} </div>
</div>
<div class="row">
  <div class="col-xs-6"> Movilidad Supeditada </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->c0909, 2 ) }} </div>
</div>
<div class="row">
  <div class="col-xs-6"> Bono </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->bono, 2 ) }} </div>
</div>
<div class="row">
  <div class="col-xs-6"> Canasta x Fiestas </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->c0903, 2 ) }} </div>
</div>     
     </td>
<td class="">     
<div class="row titulo">
  <div class="col-xs-12"> DESCUENTOS </div>
</div>
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
  <div class="col-xs-6"> Dscto. 5ta Categoría </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->c0605, 2 ) }} </div>
</div> 
<div class="row">
  <div class="col-xs-6"> Pago Incentivo o Bono </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->c0706, 2 ) }} </div>
</div> 
<div class="row">
  <div class="col-xs-6"> Préstamos </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->prestamos, 2 ) }} </div>
</div> 
<div class="row">
  <div class="col-xs-6"> Adelanto Rem. </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->c0701, 2 ) }} </div>
</div> 
<div class="row">
  <div class="col-xs-6"> Canastas x Fiestas </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->c0706, 2 ) }} </div>
</div> 
<div class="row">
  <div class="col-xs-6"> Falta </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->c0705, 2 ) }} </div>
</div>     
</td>     
<td class="">     
<div class="row titulo">
  <div class="col-xs-12"> APORTE PATRONAL </div>
</div>
<div class="row">
  <div class="col-xs-6"> Essalud </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->essalud, 2 ) }} </div>
</div>    
     </td>
 </tr>   
<tr>  
    <td class="">
    <div class="row">
  <div class="col-xs-7"> TOTAL INGRESOS </div>
  <div class="col-xs-5 importe"> {{ number_format( $planilla->total_ingresos, 2 ) }} </div>
</div>
    </td>
  <td class="">
    <div class="row">
  <div class="col-xs-7"> TOTAL DESCUENTOS </div>
  <div class="col-xs-5 importe"> {{ number_format( $planilla->total_descuentos, 2 ) }} </div>
</div>
    </td>
  <td class="">
    <div class="row">
  <div class="col-xs-7"> NETO A PAGAR </div>
  <div class="col-xs-5 importe"> {{ number_format( $planilla->neto_pagar, 2 ) }} </div>
</div>
    </td> 
    </tr>
</table>  
@endforeach
 </body>
</html>