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
@foreach ($planillas as $planilla) 
<div class="pagina">
</br></br></br></br>
<div class="row">
  <div class="col-xs-4 negrita"> {{ $planilla->razon_social }} </div>
  <div class="col-xs-3 titulo"> RECARGA CONSUMO - {{ $planilla->mes}} </div>
   <div class="col-xs-5 derecha" style="height: 25px; width: 300px; float: right; top: -2px;"><img src="{{asset('/uploads/logos/1504640535-31842722.png')}}" /> </div>
</div>

<div class="row">
  <div class="col-xs-4"> Perú </div>
  <div class="col-xs-3 centro"> Del 01/01/2016 al 01/01/2016 </div>
  <div class="col-xs-5 derecha"></div> 
</div>

<div class="row">
  <div class="col-xs-4">{{ $planilla->direccion }} {{ $planilla->num_direccion }}  </div>
  <div class="col-xs-3 titulo"> </div>
  <div class="col-xs-5 derecha"></div> 
</div>

<div class="row">
  <div class="col-xs-4">RUC: {{ $planilla->ruc }}</div>
  <div class="col-xs-3 titulo"> </div>
  <div class="col-xs-5 derecha"></div>
</div>
<div class="row">
  <div class="col-xs-4"></div>
  <div class="col-xs-3 titulo"> </div>
  <div class="col-xs-5 derecha"></div>
</div>
</br></br>
<table class="table table-bordered">
<tr> 
<td colspan="3" class="">
<div class="row">
  <div class="col-xs-6"> Nombre:  {{ $planilla->ape_paterno }} {{ $planilla->ape_materno }}, {{ $planilla->nombres }}</div>
  <div class="col-xs-3"> F. Nac:  {{ $planilla->fecha_nacimiento }}</div>
  <div class="col-xs-3"> </div>
</div>
<div class="row">
  <div class="col-xs-4"> DNI: {{ $planilla->num_doc }} </div>
  <div class="col-xs-4"> F. Ingreso: {{ $planilla->fecha_ingreso }} </div>
  <div class="col-xs-4"> F. Cese: {{ $planilla->fecha_cese }} </div>
</div>
<div class="row">
  <div class="col-xs-4"> D. TRAB: {{ $planilla->dias_computables }} </div>
  <div class="col-xs-4"> Categ: 01 TRABAJADOR </div>
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
  <div class="col-xs-6 importe"> {{ number_format( $planilla->{'0121'}, 2 ) }} </div>
</div>
<div class="row">
  <div class="col-xs-6"> Asignación Familiar </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->{'0201'}, 2 ) }} </div>
</div>
<div class="row">
  <div class="col-xs-6"> Vacaciones </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->{'0118'}, 2 ) }} </div>
</div>
<div class="row">
  <div class="col-xs-6"> Descanso Médico </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->{'0916'}, 2 ) }} </div>
</div>
<div class="row">
  <div class="col-xs-6"> Importe Nocturno </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->importe_hn, 2 ) }} </div>
</div>
<div class="row">
  <div class="col-xs-6"> Feriados </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->{'0107'}, 2 ) }} </div>
</div>
<div class="row">
  <div class="col-xs-6"> Incentivos </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->incentivos, 2 ) }} </div>
</div>
<div class="row">
  <div class="col-xs-6"> Movilidad Supeditada </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->{'0909'}, 2 ) }} </div>
</div>
<div class="row">
  <div class="col-xs-6"> Bono </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->bono, 2 ) }} </div>
</div>
<div class="row">
  <div class="col-xs-6"> Canasta x Fiestas </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->{'0903'}, 2 ) }} </div>
</div>     
     </td>
<td class="">     
<div class="row titulo">
  <div class="col-xs-12"> DESCUENTOS </div>
</div>
<div class="row">
  <div class="col-xs-6"> ONP </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->{'0607'}, 2 ) }} </div>
</div> 
<div class="row">
  <div class="col-xs-6"> AFP Comisión </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->{'0601'}, 2 ) }} </div>
</div> 
<div class="row">
  <div class="col-xs-6"> AFP Fondo </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->{'0608'}, 2 ) }} </div>
</div> 
<div class="row">
  <div class="col-xs-6"> AFP Seguro </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->{'0606'}, 2 ) }} </div>
</div> 
<div class="row">
  <div class="col-xs-6"> Dscto. 5ta Categoría </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->{'0605'}, 2 ) }} </div>
</div> 
<div class="row">
  <div class="col-xs-6"> Pago Incentivo o Bono </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->{'0706'}, 2 ) }} </div>
</div> 
<div class="row">
  <div class="col-xs-6"> Préstamos </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->prestamos, 2 ) }} </div>
</div> 
<div class="row">
  <div class="col-xs-6"> Adelanto Rem. </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->{'0701'}, 2 ) }} </div>
</div> 
<div class="row">
  <div class="col-xs-6"> Canastas x Fiestas </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->{'0706'}, 2 ) }} </div>
</div> 
<div class="row">
  <div class="col-xs-6"> Falta </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->{'0705'}, 2 ) }} </div>
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
    </tr>
</table>  
<div class="row">
 <div class="col-xs-7"> NETO A PAGAR </div>
 <div class="col-xs-5 importe"> {{ number_format( $planilla->neto_pagar, 2 ) }} </div>
</div>   

    </br></br></br>
<div class="row">
  <div class="col-xs-6 centro">REPRESENTANTE LEGAL </div>
  <div class="col-xs-6 centro">{{ $planilla->ape_paterno }} {{ $planilla->ape_materno }}, {{ $planilla->nombres }} </div>
</div> 
    </br></br></br></br></br></br></br></br></br>
<div class="row">
  <div class="col-xs-4 negrita"> {{ $planilla->razon_social }} </div>
  <div class="col-xs-3 titulo"> RECARGA CONSUMO - {{ $planilla->mes}} </div>
   <div class="col-xs-5 derecha" style="height: 25px; width: 300px; float: right; top: -2px;"><img src="{{asset('/uploads/logos/1504640535-31842722.png')}}" /> </div>
</div>

<div class="row">
  <div class="col-xs-4"> Perú </div>
  <div class="col-xs-3 centro"> Del 01/01/2016 al 01/01/2016 </div>
  <div class="col-xs-5 derecha"></div> 
</div>

<div class="row">
  <div class="col-xs-4">{{ $planilla->direccion }} {{ $planilla->num_direccion }}  </div>
  <div class="col-xs-3 titulo"> </div>
  <div class="col-xs-5 derecha"></div> 
</div>

<div class="row">
  <div class="col-xs-4">RUC: {{ $planilla->ruc }}</div>
  <div class="col-xs-3 titulo"> </div>
  <div class="col-xs-5 derecha"></div>
</div>
<div class="row">
  <div class="col-xs-4"></div>
  <div class="col-xs-3 titulo"> </div>
  <div class="col-xs-5 derecha"></div>
</div>
</br></br>  
<table class="table table-bordered">
<tr> 
<td colspan="3" class="">
<div class="row">
  <div class="col-xs-6"> Nombre:  {{ $planilla->ape_paterno }} {{ $planilla->ape_materno }}, {{ $planilla->nombres }}</div>
  <div class="col-xs-3"> F. Nac:  {{ $planilla->fecha_nacimiento }}</div>
  <div class="col-xs-3"> </div>
</div>
<div class="row">
  <div class="col-xs-4"> DNI: {{ $planilla->num_doc }} </div>
  <div class="col-xs-4"> F. Ingreso: {{ $planilla->fecha_ingreso }} </div>
  <div class="col-xs-4"> F. Cese: {{ $planilla->fecha_cese }} </div>
</div>
<div class="row">
  <div class="col-xs-4"> D. TRAB: {{ $planilla->dias_computables }} </div>
  <div class="col-xs-4"> Categ: 01 TRABAJADOR </div>
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
  <div class="col-xs-6 importe"> {{ number_format( $planilla->{'0121'}, 2 ) }} </div>
</div>
<div class="row">
  <div class="col-xs-6"> Asignación Familiar </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->{'0201'}, 2 ) }} </div>
</div>
<div class="row">
  <div class="col-xs-6"> Vacaciones </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->{'0118'}, 2 ) }} </div>
</div>
<div class="row">
  <div class="col-xs-6"> Descanso Médico </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->{'0916'}, 2 ) }} </div>
</div>
<div class="row">
  <div class="col-xs-6"> Importe Nocturno </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->importe_hn, 2 ) }} </div>
</div>
<div class="row">
  <div class="col-xs-6"> Feriados </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->{'0107'}, 2 ) }} </div>
</div>
<div class="row">
  <div class="col-xs-6"> Incentivos </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->incentivos, 2 ) }} </div>
</div>
<div class="row">
  <div class="col-xs-6"> Movilidad Supeditada </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->{'0909'}, 2 ) }} </div>
</div>
<div class="row">
  <div class="col-xs-6"> Bono </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->bono, 2 ) }} </div>
</div>
<div class="row">
  <div class="col-xs-6"> Canasta x Fiestas </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->{'0903'}, 2 ) }} </div>
</div>    
     </td>
<td class="">     
<div class="row titulo">
  <div class="col-xs-12"> DESCUENTOS </div>
</div>
<div class="row">
  <div class="col-xs-6"> ONP </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->{'0607'}, 2 ) }} </div>
</div> 
<div class="row">
  <div class="col-xs-6"> AFP Comisión </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->{'0601'}, 2 ) }} </div>
</div> 
<div class="row">
  <div class="col-xs-6"> AFP Fondo </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->{'0608'}, 2 ) }} </div>
</div> 
<div class="row">
  <div class="col-xs-6"> AFP Seguro </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->{'0606'}, 2 ) }} </div>
</div>  
<div class="row">
  <div class="col-xs-6"> Dscto. 5ta Categoría </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->{'0605'}, 2 ) }} </div>
</div> 
<div class="row">
  <div class="col-xs-6"> Pago Incentivo o Bono </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->{'0706'}, 2 ) }} </div>
</div> 
<div class="row">
  <div class="col-xs-6"> Préstamos </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->prestamos, 2 ) }} </div>
</div> 
<div class="row">
  <div class="col-xs-6"> Adelanto Rem. </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->{'0701'}, 2 ) }} </div>
</div> 
<div class="row">
  <div class="col-xs-6"> Canastas x Fiestas </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->{'0706'}, 2 ) }} </div>
</div> 
<div class="row">
  <div class="col-xs-6"> Falta </div>
  <div class="col-xs-6 importe"> {{ number_format( $planilla->{'0705'}, 2 ) }} </div>
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
    </tr>  
</table>  
 <div class="row">
 <div class="col-xs-7"> NETO A PAGAR </div>
 <div class="col-xs-5 importe"> {{ number_format( $planilla->neto_pagar, 2 ) }} </div>
</div> 

    </br></br></br>
<div class="row">
 <div class="col-xs-6 centro">REPRESENTANTE LEGAL </div>
  <div class="col-xs-6 centro">{{ $planilla->ape_paterno }} {{ $planilla->ape_materno }}, {{ $planilla->nombres }} </div>
</div> 
</div>
@endforeach
 </body>
</html>