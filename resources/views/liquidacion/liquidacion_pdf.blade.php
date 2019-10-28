<!DOCTYPE html>
<html lang="en">
  <head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>JL</title>
      <link href="{{ asset('sximo/js/plugins/bootstrap/css/bootstrap.css')}}" rel="stylesheet"> 
      <link href="{{ asset('sximo/js/plugins/jasny-bootstrap/css/jasny-bootstrap.min.css')}}" rel="stylesheet">
      <link href="{{ asset('sximo/css/liquidacion.css')}}" rel="stylesheet">
  </head>   
<body class="general" >           
<div class="pagina">

<div class="row">
  <div class="col-xs-12 titulo"> 
	"LIQUIDACIÓN DE BENEFICIOS SOCIALES"
  </div>
  <br/><br/><br/>
</div>
<div class="row">
<div class="col-xs-12 descripcion-superior"> 
	{{ $liquidacion->razon_social }} con RUC Nro.{{ $liquidacion->ruc }} domiciliado en, {{ $liquidacion->direccion }} representado por el Sr.
	{{ $liquidacion->representante }} identificado con DNI Nro.{{ $liquidacion->num_documento }}, en cumplimiento de las obligaciones laborales que 
	asumido en calidad de empleador del Señor(a):
</div>
<br/><br/><br/><br/>
</div>
<div class="row">
<div class="col-xs-12 seccion"> 
	1. DATOS GENERALES DEL TRABAJADOR
</div>
<br/><br/>
</div>
<div class="row">
<div class="col-xs-6 "> 
Apellidos y Nombres:
</div>
<div class="col-xs-6 negrita"> 
{{ $liquidacion->ape_paterno }}{{ $liquidacion->ape_materno }}, {{ $liquidacion->nombres }}
</div>
</div>
<div class="row">
<div class="col-xs-6 "> 
DNI:
</div>
<div class="col-xs-6 "> 
{{ $liquidacion->num_doc }}
</div>
</div>
<div class="row">
<div class="col-xs-6 "> 
Cargo:
</div>
<div class="col-xs-6 "> 

</div>
</div>
<div class="row">
<div class="col-xs-6 "> 
Centro de Costos:
</div>
<div class="col-xs-6 "> 
{{ $liquidacion->centro_costo }}
</div>
</div>
<div class="row">
<div class="col-xs-6 "> 
Fecha de Ingreso:
</div>
<div class="col-xs-6 "> 
{{ $liquidacion->fecha_ingreso }}
</div>
</div>
<div class="row">
<div class="col-xs-6 "> 
Fecha de Cese:
</div>
<div class="col-xs-6 "> 
{{ $liquidacion->fecha_cese }}
</div>
</div>
<div class="row">
<div class="col-xs-6 "> 
Condición de Trabajo:
</div>
<div class="col-xs-6 "> 
{{ $liquidacion->descripcion }}
</div>
</div>
<div class="row">
<div class="col-xs-6 "> 
Motivo del Cese:
</div>
<div class="col-xs-6 "> 
Renuncia Voluntaria
</div>
</div>
<div class="row">
<div class="col-xs-6 "> 
Sistema de Pensiones:
</div>
<div class="col-xs-6 "> 
{{ $liquidacion->nombre }}
</div>
</div>
<div class="row">
<div class="col-xs-6 "> 
Tipo de Comisión:
</div>
<div class="col-xs-6 "> 

</div>
</div>
<div class="row">
<div class="col-xs-6 "> 
Remuneración Mensual:
</div>
<div class="col-xs-6 "> 
{{ number_format( $liquidacion->sueldo, 2 ) }}
</div>
</div>
<div class="row">
<div class="col-xs-6 "> 
Tiempo de Servicio:
</div>
<div class="col-xs-6 "> 
{{ $liquidacion->tiempo_servicio }}
</div>
</div>
<div class="row">
<div class="col-xs-6 "> 
Faltas:
</div>
<div class="col-xs-6 "> 
{{ $liquidacion->faltas }}
</div>
</div>
<div class="row">
<div class="col-xs-6 "> 
Tiempo Computable:
</div>
<div class="col-xs-6 "> 
{{ $liquidacion->tiempo_computable }}
</div>
<br/><br/><br/>
</div>
<div class="row">
<div class="col-xs-12 seccion"> 
	2. COMPENSACIÓN POR TIEMPO DE SERVICIOS (C.T.S.)
</div>
<br/><br/>
</div>
<div class="row">
<div class="col-xs-12 negrita"> 
Remuneración Computable:
</div>
</div>
<div class="row">
<div class="col-xs-6 "> 
Haber Básico:
</div>
<div class="col-xs-6 "> 
{{ number_format( $liquidacion->sueldo, 2 ) }}
</div>
</div>
<div class="row">
<div class="col-xs-6 "> 
Asignación Familiar:
</div>
<div class="col-xs-6 "> 
{{ number_format( $liquidacion->asignacion_familiar, 2 ) }}
</div>
</div>
<div class="row">
<div class="col-xs-6 "> 
Gratificación Ordinaria (1/6):
</div>
<div class="col-xs-6 "> 
{{ number_format( $liquidacion->gratificacion, 2 ) }}
</div>
</div>
<div class="row">
<div class="col-xs-6 "> 
Promedio Hora Nocturna:
</div>
<div class="col-xs-6 "> 
{{ number_format( $liquidacion->promedio_hn_cts, 2 ) }}
</div>
</div>
<div class="row">
<div class="col-xs-6 "> 
Otros Conceptos :
</div>
<div class="col-xs-6 "> 
{{ number_format( $liquidacion->otros_conceptos_cts, 2 ) }}
</div>
</div>
<div class="row">
<div class="col-xs-6 negrita"> 
Total Computable  :
</div>
<div class="col-xs-6 negrita"> 
{{ number_format( $liquidacion->total_computable_cts, 2 ) }}
</div>
</div>
<div class="row">
<div class="col-xs-6 "> 
PERIODO PENDIENTE  :
</div>
<div class="col-xs-6 "> 
{{ $liquidacion->periodo_pendiente }}
</div>
</div>
<div class="row">
<div class="col-xs-12 negrita"> 
CTS trunco  :
</div>
</div>
<div class="row">
<div class="col-xs-6 "> 
Por los meses  :
</div>
<div class="col-xs-6 "> 
{{ number_format( $liquidacion->cts_meses, 2 ) }}
</div>
</div>
<div class="row">
<div class="col-xs-6 "> 
Por los días  :
</div>
<div class="col-xs-6 "> 
{{ number_format( $liquidacion->cts_dias, 2 ) }}
</div>
</div>
<div class="row">
<div class="col-xs-6 negrita"> 
Total CTS  por pagar  :
</div>
<div class="col-xs-6 negrita"> 
{{ number_format( $liquidacion->total_cts, 2 ) }}
</div>
<br/><br/><br/>
</div>
<div class="row">
<div class="col-xs-12 seccion"> 
	3. VACACIONES
</div>
<br/><br/>
</div>
<div class="row">
<div class="col-xs-12 negrita"> 
Remuneración Computable:
</div>
</div>
<div class="row">
<div class="col-xs-6 "> 
Sueldo Básico:
</div>
<div class="col-xs-6 "> 
{{ number_format( $liquidacion->sueldo, 2 ) }}
</div>
</div>
<div class="row">
<div class="col-xs-6 "> 
Asignación Familiar:
</div>
<div class="col-xs-6 "> 
{{ number_format( $liquidacion->asignacion_familiar, 2 ) }}
</div>
</div>
<div class="row">
<div class="col-xs-6 "> 
Otros Conceptos :
</div>
<div class="col-xs-6 "> 
{{ number_format( $liquidacion->otros_conceptos_cts, 2 ) }}
</div>
</div>
<div class="row">
<div class="col-xs-6 negrita"> 
Total Computable  :
</div>
<div class="col-xs-6 negrita"> 
{{ number_format( $liquidacion->total_computable_vc, 2 ) }}
</div>
</div>
<div class="row">
<div class="col-xs-6 "> 
Tiempo de Servicio:
</div>
<div class="col-xs-6 "> 
{{ $liquidacion->tiempo_servicio }}
</div>
</div>
<div class="row">
<div class="col-xs-6 "> 
Faltas:
</div>
<div class="col-xs-6 "> 
{{ $liquidacion->faltas }}
</div>
</div>
<div class="row">
<div class="col-xs-6 "> 
Tiempo Computable:
</div>
<div class="col-xs-6 "> 
{{ $liquidacion->tiempo_computable }}
</div>
</div>
<div class="row">
<div class="col-xs-12 negrita"> 
Vacaciones truncas  :
</div>
</div>
<div class="row">
<div class="col-xs-6 "> 
Total  :
</div>
<div class="col-xs-6 "> 
{{ $liquidacion->suma_dias }} Días - {{ $liquidacion->suma_meses }} Meses
</div>
</div>
<div class="row">
<div class="col-xs-12 "> 
Descanso Fisico  :
</div>
</div>
<div class="row">
<div class="col-xs-6 "> 
Total  :
</div>
<div class="col-xs-6 "> 
{{ $liquidacion->descanso_dias }} Días - {{ $liquidacion->descanso_meses }} Meses
</div>
</div>
<div class="row">
<div class="col-xs-6 "> 
Por los meses  :
</div>
<div class="col-xs-6 "> 
{{ number_format( $liquidacion->monto_meses_vc, 2 ) }}
</div>
</div>
<div class="row">
<div class="col-xs-6 "> 
Por los días  :
</div>
<div class="col-xs-6 "> 
{{ number_format( $liquidacion->monto_dias_vc, 2 ) }}
</div>
</div>
<div class="row">
<div class="col-xs-6 negrita"> 
Total Vacaciones  por pagar  :
</div>
<div class="col-xs-6 negrita"> 
{{ number_format( $liquidacion->total_vacaciones, 2 ) }}
</div>
<br/><br/><br/>
</div>
<div class="row">
<div class="col-xs-12 seccion"> 
	4. GRATIFICACIONES
</div>
<br/><br/>
</div>
<div class="row">
<div class="col-xs-12 negrita"> 
Remuneración Computable:
</div>
</div>
<div class="row">
<div class="col-xs-6 "> 
Sueldo Básico:
</div>
<div class="col-xs-6 "> 
{{ number_format( $liquidacion->sueldo, 2 ) }}
</div>
</div>
<div class="row">
<div class="col-xs-6 "> 
Asignación Familiar:
</div>
<div class="col-xs-6 "> 
{{ number_format( $liquidacion->asignacion_familiar, 2 ) }}
</div>
</div>
<div class="row">
<div class="col-xs-6 "> 
Promedio Hora Nocturna:
</div>
<div class="col-xs-6 "> 
{{ number_format( $liquidacion->promedio_hn_cts, 2 ) }}
</div>
</div>
<div class="row">
<div class="col-xs-6 "> 
Otros Conceptos :
</div>
<div class="col-xs-6 "> 
{{ number_format( $liquidacion->otros_conceptos_cts, 2 ) }}
</div>
</div>
<div class="row">
<div class="col-xs-6 negrita"> 
Total Computable  :
</div>
<div class="col-xs-6 negrita"> 
{{ number_format( $liquidacion->total_computable_gr, 2 ) }}
</div>
</div>
<div class="row">
<div class="col-xs-6 "> 
PERIODO PENDIENTE  :
</div>
<div class="col-xs-6 "> 
{{ $liquidacion->periodo_pendiente_gr }}
</div>
</div>
<div class="row">
<div class="col-xs-12 negrita"> 
Gratificaciones truncas  :
</div>
</div>
<div class="row">
<div class="col-xs-6 "> 
Por los meses  :
</div>
<div class="col-xs-6 "> 
{{ number_format( $liquidacion->monto_meses_gr, 2 ) }}
</div>
</div>
<div class="row">
<div class="col-xs-6 "> 
Por los días  :
</div>
<div class="col-xs-6 "> 
{{ number_format( $liquidacion->monto_dias_gr, 2 ) }}
</div>
</div>
<div class="row">
<div class="col-xs-6 "> 
Bonificación extraordinaria - Ley N° 30334  :
</div>
<div class="col-xs-6 "> 
{{ number_format( $liquidacion->boni_extra_gr, 2 ) }}
</div>
</div>
<div class="row">
<div class="col-xs-6 negrita"> 
Total Gratificaciones por pagar   :
</div>
<div class="col-xs-6 negrita"> 
{{ number_format( $liquidacion->total_gratificaciones, 2 ) }}
</div>
<br/><br/><br/>
</div>
<div class="row">
<div class="col-xs-12 seccion"> 
	5. DESCUENTOS
</div>
<br/><br/>
</div>
<div class="row">
<div class="col-xs-6 negrita"> 
Total descuentos:
</div>
<div class="col-xs-6 negrita"> 
{{ number_format( $liquidacion->total_descuentos, 2 ) }}
</div>
<br/><br/><br/>
</div>
<div class="row">
<div class="col-xs-12 seccion"> 
	6. RESUMEN
</div>
<br/><br/>
</div>
<div class="row">
<div class="col-xs-6 "> 
A. Compensacion por tiempos de sercicio  :
</div>
<div class="col-xs-6 "> 
{{ number_format( $liquidacion->total_cts, 2 ) }}
</div>
</div>
<div class="row">
<div class="col-xs-6 "> 
B. Vacaciones no gozadas y truncas  :
</div>
<div class="col-xs-6 "> 
{{ number_format( $liquidacion->total_vacaciones, 2 ) }}
</div>
</div>
<div class="row">
<div class="col-xs-6 "> 
C. Gratificaciones truncas :
</div>
<div class="col-xs-6 "> 
{{ number_format( $liquidacion->total_gratificaciones, 2 ) }}
</div>
</div>
<div class="row">
<div class="col-xs-6 "> 
D. DESCUENTOS:
</div>
<div class="col-xs-6 "> 
{{ number_format( $liquidacion->total_descuentos, 2 ) }}
</div>
</div>
<div class="row">
<div class="col-xs-6 negrita"> 
>> Total remuneraciones y beneficios sociales liquidados  :
</div>
<div class="col-xs-6 negrita"> 
{{ number_format( $liquidacion->total_liquidacion, 2 ) }}
</div>
<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
</div>
<div class="row">
<div class="col-xs-12 descripcion-inferior"> 
	Las partes que suscriben en presente documento declaran su conformidad con el período de servicios reconocido, 
	el cálculo de los beneficios sociales, así como el monto pagado de los mismos.
</div>
<br/><br/><br/><br/><br/>
</div>
<div class="row">
<div class="col-xs-6 negrita centro subrayado_arriba"> 
REPRESENTANTE LEGAL
</div>
<div class="col-xs-6 negrita centro subrayado_arriba">
 {{ $liquidacion->ape_paterno }}{{ $liquidacion->ape_materno }}, {{ $liquidacion->nombres }}
<br/>
{{ $liquidacion->num_doc }}
</div>
</div>

</div>
</body>
</html>