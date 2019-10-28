<!DOCTYPE html>
<html lang="en">
  <head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Shangel Perú</title>
      <link href="{{ asset('sximo/js/plugins/bootstrap/css/bootstrap.css')}}" rel="stylesheet"> 
      <link href="{{ asset('sximo/js/plugins/jasny-bootstrap/css/jasny-bootstrap.min.css')}}" rel="stylesheet">
      <link href="{{ asset('sximo/css/boletas.css')}}" rel="stylesheet">
  </head>   
<body class="letra" >           
@foreach ($trabajadores as $trabajador) 
<div class="pagina">
<div class="row">
  <div class="col-xs-4 negrita"> {{ $trabajador->empresa }} </div>
  <div class="col-xs-3 titulo"> Boleta de Pago - {{ $trabajador->mes }} </div>
  <div class="col-xs-5 derecha"> D.S. N° 020-2008-TR DEL 15-01-08 </div>
</div>   
<div class="row">
  <div class="col-xs-4 negrita"> Perú </div>
  <div class="col-xs-3 centro"> Del 01/01/2016 al 01/01/2016 </div>
  <div class="col-xs-5">  </div>
</div>    
<table class="table table-bordered">
<tr> 
<td colspan="3" class="">
<div class="row">
  <div class="col-xs-6"> Nombre: {{ $trabajador->apellidos }}, {{ $trabajador->nombres }} </div>
  <div class="col-xs-3"> F. Nac: {{ $trabajador->fecha_nacimiento }} </div>
  <div class="col-xs-3"> F. Ingreso: {{ $trabajador->fecha_ingreso }} </div>
</div>     
<div class="row">
  <div class="col-xs-4"> Codigo: {{ $trabajador->documento }} </div>
  <div class="col-xs-4"> D. Leg: 728 General </div>
  <div class="col-xs-4"> DNI: {{ $trabajador->documento }} </div>
</div>   
<div class="row">
  <div class="col-xs-4"> Categ: 01 TRABAJADOR </div>
  <div class="col-xs-4"> D. TRAB: {{ $trabajador->dias_computables }}</div>
  <div class="col-xs-4">  </div>
</div>   
<div class="row">
  <div class="col-xs-4"> Cargo: {{ $trabajador->ocupacion }} </div>
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
  <div class="col-xs-6 importe"> {{ number_format( $trabajador->haber_basico, 2 ) }} </div>
</div>
<div class="row">
  <div class="col-xs-6"> Asignación Familiar </div>
  <div class="col-xs-6 importe"> {{ number_format( $trabajador->asignacion_familiar, 2 ) }} </div>
</div>
<div class="row">
  <div class="col-xs-6"> Vacaciones </div>
  <div class="col-xs-6 importe"> {{ number_format( $trabajador->remuneracion_vacacional, 2 ) }} </div>
</div>
<div class="row">
  <div class="col-xs-6"> Descanso Médico </div>
  <div class="col-xs-6 importe"> {{ number_format( $trabajador->descanso_medico, 2 ) }} </div>
</div>
<div class="row">
  <div class="col-xs-6"> Importe Nocturno </div>
  <div class="col-xs-6 importe"> {{ number_format( $trabajador->horas_nocturnas, 2 ) }} </div>
</div>
<div class="row">
  <div class="col-xs-6"> Feriados </div>
  <div class="col-xs-6 importe"> {{ number_format( $trabajador->feriados, 2 ) }} </div>
</div>
<div class="row">
  <div class="col-xs-6"> Incentivos </div>
  <div class="col-xs-6 importe"> {{ number_format( $trabajador->incentivos, 2 ) }} </div>
</div>
<div class="row">
  <div class="col-xs-6"> Movilidad Supeditada </div>
  <div class="col-xs-6 importe"> {{ number_format( $trabajador->prestamos, 2 ) }} </div>
</div>
<div class="row">
  <div class="col-xs-6"> Bono </div>
  <div class="col-xs-6 importe"> {{ number_format( $trabajador->bono_productividad, 2 ) }} </div>
</div>
<div class="row">
  <div class="col-xs-6"> Canasta x Fiestas </div>
  <div class="col-xs-6 importe"> {{ number_format( $trabajador->canasta_navidad, 2 ) }} </div>
</div>     
     </td>
<td class="">     
<div class="row titulo">
  <div class="col-xs-12"> DESCUENTOS </div>
</div>
<div class="row">
  <div class="col-xs-6"> ONP </div>
  <div class="col-xs-6 importe"> {{ number_format( $trabajador->onp, 2 ) }} </div>
</div> 
<div class="row">
  <div class="col-xs-6"> AFP Comisión </div>
  <div class="col-xs-6 importe"> {{ number_format( $trabajador->afp_comision, 2 ) }} </div>
</div> 
<div class="row">
  <div class="col-xs-6"> AFP Fondo </div>
  <div class="col-xs-6 importe"> {{ number_format( $trabajador->afp_fondo, 2 ) }} </div>
</div> 
<div class="row">
  <div class="col-xs-6"> AFP Seguro </div>
  <div class="col-xs-6 importe"> {{ number_format( $trabajador->afp_seguro, 2 ) }} </div>
</div> 
<div class="row">
  <div class="col-xs-6"> Dscto. 5ta Categoría </div>
  <div class="col-xs-6 importe"> {{ number_format( $trabajador->retencion_5ta_categoria, 2 ) }} </div>
</div> 
<div class="row">
  <div class="col-xs-6"> Pago Incentivo o Bono </div>
  <div class="col-xs-6 importe"> {{ number_format( $trabajador->pago_vacaciones_bonos_incentivos, 2 ) }} </div>
</div> 
<div class="row">
  <div class="col-xs-6"> Préstamos </div>
  <div class="col-xs-6 importe"> {{ number_format( $trabajador->prestamos, 2 ) }} </div>
</div> 
<div class="row">
  <div class="col-xs-6"> Adelanto Rem. </div>
  <div class="col-xs-6 importe"> {{ number_format( $trabajador->adelanto_remuneracion, 2 ) }} </div>
</div> 
<div class="row">
  <div class="col-xs-6"> Canastas x Fiestas </div>
  <div class="col-xs-6 importe"> {{ number_format( $trabajador->entrega_canasta_navidad, 2 ) }} </div>
</div> 
<div class="row">
  <div class="col-xs-6"> Falta </div>
  <div class="col-xs-6 importe"> {{ number_format( $trabajador->faltas, 2 ) }} </div>
</div>     
</td>     
<td class="">     
<div class="row titulo">
  <div class="col-xs-12"> APORTE PATRONAL </div>
</div>
<div class="row">
  <div class="col-xs-6"> Essalud </div>
  <div class="col-xs-6 importe"> {{ number_format( $trabajador->essalud, 2 ) }} </div>
</div>    
     </td>
 </tr>   
<tr>  
    <td class="">
    <div class="row">
  <div class="col-xs-7"> TOTAL INGRESOS </div>
  <div class="col-xs-5 importe"> {{ number_format( $trabajador->total_ingresos, 2 ) }} </div>
</div>
    </td>
  <td class="">
    <div class="row">
  <div class="col-xs-7"> TOTAL DESCUENTOS </div>
  <div class="col-xs-5 importe"> {{ number_format( $trabajador->total_descuentos, 2 ) }} </div>
</div>
    </td>
  <td class="">
    <div class="row">
  <div class="col-xs-7"> NETO A PAGAR </div>
  <div class="col-xs-5 importe"> {{ number_format( $trabajador->neto_a_pagar, 2 ) }} </div>
</div>
    </td> 
    </tr>
</table>  
<div class="row">
  <div class="col-xs-12"> Importe abonado a la cuenta, Banco - NINGUNO </div>
</div>   
<div class="row">
  <div class="col-xs-12">Lima, 31 de Julio del 2016 </div>
</div>
    </br></br></br>
<div class="row">
  <div class="col-xs-6 centro">EMPLEADOR </div>
  <div class="col-xs-6 centro">TRABAJADOR </div>
</div> 
    </br></br>
<div class="row">
  <div class="col-xs-4 negrita"> {{ $trabajador->empresa }} </div>
  <div class="col-xs-3 titulo"> Boleta de Pago - {{ $trabajador->mes }} </div>
  <div class="col-xs-5 derecha"> D.S. N° 020-2008-TR DEL 15-01-08 </div>
</div>   
<div class="row">
  <div class="col-xs-4 negrita"> Perú </div>
  <div class="col-xs-3 centro"> Del 01/01/2016 al 01/01/2016 </div>
  <div class="col-xs-5">  </div>
</div>    
<table class="table table-bordered">
<tr> 
<td colspan="3" class="">
<div class="row">
  <div class="col-xs-6"> Nombre: {{ $trabajador->apellidos }}, {{ $trabajador->nombres }} </div>
  <div class="col-xs-3"> F. Nac: {{ $trabajador->fecha_nacimiento }} </div>
  <div class="col-xs-3"> F. Ingreso: {{ $trabajador->fecha_ingreso }} </div>
</div>     
<div class="row">
  <div class="col-xs-4"> Codigo: {{ $trabajador->documento }} </div>
  <div class="col-xs-4"> D. Leg: 728 General </div>
  <div class="col-xs-4"> DNI: {{ $trabajador->documento }} </div>
</div>   
<div class="row">
  <div class="col-xs-4"> Categ: 01 TRABAJADOR </div>
  <div class="col-xs-4"> D. TRAB: </div>
  <div class="col-xs-4">  </div>
</div>   
<div class="row">
  <div class="col-xs-4"> Cargo: {{ $trabajador->ocupacion }} </div>
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
  <div class="col-xs-6 importe"> {{ number_format( $trabajador->haber_basico, 2 ) }} </div>
</div>
<div class="row">
  <div class="col-xs-6"> Asignación Familiar </div>
  <div class="col-xs-6 importe"> {{ number_format( $trabajador->asignacion_familiar, 2 ) }} </div>
</div>
<div class="row">
  <div class="col-xs-6"> Vacaciones </div>
  <div class="col-xs-6 importe"> {{ number_format( $trabajador->remuneracion_vacacional, 2 ) }} </div>
</div>
<div class="row">
  <div class="col-xs-6"> Descanso Médico </div>
  <div class="col-xs-6 importe"> {{ number_format( $trabajador->descanso_medico, 2 ) }} </div>
</div>
<div class="row">
  <div class="col-xs-6"> Importe Nocturno </div>
  <div class="col-xs-6 importe"> {{ number_format( $trabajador->horas_nocturnas, 2 ) }} </div>
</div>
<div class="row">
  <div class="col-xs-6"> Feriados </div>
  <div class="col-xs-6 importe"> {{ number_format( $trabajador->feriados, 2 ) }} </div>
</div>
<div class="row">
  <div class="col-xs-6"> Incentivos </div>
  <div class="col-xs-6 importe"> {{ number_format( $trabajador->incentivos, 2 ) }} </div>
</div>
<div class="row">
  <div class="col-xs-6"> Movilidad Supeditada </div>
  <div class="col-xs-6 importe"> {{ number_format( $trabajador->prestamos, 2 ) }} </div>
</div>
<div class="row">
  <div class="col-xs-6"> Bono </div>
  <div class="col-xs-6 importe"> {{ number_format( $trabajador->bono_productividad, 2 ) }} </div>
</div>
<div class="row">
  <div class="col-xs-6"> Canasta x Fiestas </div>
  <div class="col-xs-6 importe"> {{ number_format( $trabajador->canasta_navidad, 2 ) }} </div>
</div>     
     </td>
<td class="">     
<div class="row titulo">
  <div class="col-xs-12"> DESCUENTOS </div>
</div>
<div class="row">
  <div class="col-xs-6"> ONP </div>
  <div class="col-xs-6 importe"> {{ number_format( $trabajador->onp, 2 ) }} </div>
</div> 
<div class="row">
  <div class="col-xs-6"> AFP Comisión </div>
  <div class="col-xs-6 importe"> {{ number_format( $trabajador->afp_comision, 2 ) }} </div>
</div> 
<div class="row">
  <div class="col-xs-6"> AFP Fondo </div>
  <div class="col-xs-6 importe"> {{ number_format( $trabajador->afp_fondo, 2 ) }} </div>
</div> 
<div class="row">
  <div class="col-xs-6"> AFP Seguro </div>
  <div class="col-xs-6 importe"> {{ number_format( $trabajador->afp_seguro, 2 ) }} </div>
</div> 
<div class="row">
  <div class="col-xs-6"> Dscto. 5ta Categoría </div>
  <div class="col-xs-6 importe"> {{ number_format( $trabajador->retencion_5ta_categoria, 2 ) }} </div>
</div> 
<div class="row">
  <div class="col-xs-6"> Pago Incentivo o Bono </div>
  <div class="col-xs-6 importe"> {{ number_format( $trabajador->pago_vacaciones_bonos_incentivos, 2 ) }} </div>
</div> 
<div class="row">
  <div class="col-xs-6"> Préstamos </div>
  <div class="col-xs-6 importe"> {{ number_format( $trabajador->prestamos, 2 ) }} </div>
</div> 
<div class="row">
  <div class="col-xs-6"> Adelanto Rem. </div>
  <div class="col-xs-6 importe"> {{ number_format( $trabajador->adelanto_remuneracion, 2 ) }} </div>
</div> 
<div class="row">
  <div class="col-xs-6"> Canastas x Fiestas </div>
  <div class="col-xs-6 importe"> {{ number_format( $trabajador->entrega_canasta_navidad, 2 ) }} </div>
</div> 
<div class="row">
  <div class="col-xs-6"> Falta </div>
  <div class="col-xs-6 importe"> {{ number_format( $trabajador->faltas, 2 ) }} </div>
</div>     
</td>     
<td class="">     
<div class="row titulo">
  <div class="col-xs-12"> APORTE PATRONAL </div>
</div>
<div class="row">
  <div class="col-xs-6"> Essalud </div>
  <div class="col-xs-6 importe"> {{ number_format( $trabajador->essalud, 2 ) }} </div>
</div>    
     </td>
 </tr>   
<tr>  
    <td class="">
    <div class="row">
  <div class="col-xs-7"> TOTAL INGRESOS </div>
  <div class="col-xs-5 importe"> {{ number_format( $trabajador->total_ingresos, 2 ) }} </div>
</div>
    </td>
  <td class="">
    <div class="row">
  <div class="col-xs-7"> TOTAL DESCUENTOS </div>
  <div class="col-xs-5 importe"> {{ number_format( $trabajador->total_descuentos, 2 ) }} </div>
</div>
    </td>
  <td class="">
    <div class="row">
  <div class="col-xs-7"> NETO A PAGAR </div>
  <div class="col-xs-5 importe"> {{ number_format( $trabajador->neto_a_pagar, 2 ) }} </div>
</div>
    </td> 
    </tr>
</table>  
<div class="row">
  <div class="col-xs-12"> Importe abonado a la cuenta, Banco - NINGUNO </div>
</div>   
<div class="row">
  <div class="col-xs-12">Lima, 31 de Julio del 2016 </div>
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