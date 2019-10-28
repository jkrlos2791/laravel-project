@extends('layouts.app')

@section('content')

<section class="content-header">
  <h1>
   {{ $pageTitle }}
    <small></small>
	<a href="{{ URL::to('calculo_rentaquinta') }}" class=" tips btn btn-xs btn-info btn-sm btn-circle"  title="Calcular Gratificación" >
	<i class="fa fa-spinner"></i>  </a>
  </h1>
</section>

  <div class="content">
 <div class="box box-danger ">
 	<div class="box-header with-border"> 
		<div class="box-header-tools pull-left" >
		<h4>Acceso</h4>
		</div>
	</div>	
 <div class="box-body">
 <ul class="parsley-error-list">
			@foreach($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>
        {!! Form::open(array('url'=>'renta_ingresar', 'class'=>'form-horizontal')) !!} 
		<div class="col-md-1">
		</div> 
         <div class="col-md-10">
 		 <div class="form-group  " >
		 <label for="empresa" class=" control-label col-md-3 text-right"> Empleado </label>
		 <div class="col-md-6">				
         {!!  Form::select('empleado', $empleado,null,['class'=>'select2' ])  !!}
		 </div> 
		 <div class="col-md-3" >
				<button class="btn btn-primary btn-sm" type="submit" > <i class="fa fa-sign-in"></i>Ver</button>				
		 </div>
		 </div> 
		 </div> 
        <div class="col-md-1">
		</div>		 
		{!! Form::close() !!}
 </div>
 </div>
 	<div class="box box-danger ">
	<div class="box-header with-border"> 
		<div class="box-header-tools pull-left" >
		<h4>Información</h4>
		</div>
	</div>	
<div class="box-body">
		<ul class="parsley-error-list">
			@foreach($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>

		 {!! Form::open(array('url'=>'rentaquinta/save?return='.$return, 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}
<table class="table table-bordered table-hover">		      
<tr>
<td colspan="8"><label for="Remuneraciones" class=" control-label text-left"> Remuneraciones </label>{!! Form::hidden('quinta_id', $row['quinta_id']) !!}</td>
</tr>
<tr>
<td width="200"><label for="rem1" class=" control-label text-left"> Enero </label></td>
<td width="150"><input  type='text' name='rem1' id='rem1' value='{{ number_format($row['rem1']+0,2) }}' class='form-control' /> </td>
<td width="200"><label for="rem2" class=" control-label text-left"> Febrero </label></td>
<td width="150"><input  type='text' name='rem2' id='rem2' value='{{ number_format($row['rem2']+0,2) }}' class='form-control' /> </td>
<td width="200"><label for="rem3" class=" control-label text-left"> Marzo </label></td>
<td width="150"><input  type='text' name='rem3' id='rem3' value='{{ number_format($row['rem3']+0,2) }}' class='form-control' /> </td>
<td width="200"><label for="rem4" class=" control-label text-left"> Abril </label></td>
<td width="150"><input  type='text' name='rem4' id='rem4' value='{{ number_format($row['rem4']+0,2) }}' class='form-control' /> </td>
</tr>
<tr>
<td width="200"><label for="rem5" class=" control-label text-left"> Mayo </label></td>
<td width="150"><input  type='text' name='rem5' id='rem5' value='{{ number_format($row['rem5']+0,2) }}' class='form-control' />  </td>
<td width="200"><label for="rem6" class=" control-label text-left"> Junio </label></td>
<td width="150"><input  type='text' name='rem6' id='rem6' value='{{ number_format($row['rem6']+0,2) }}' class='form-control' />  </td>
<td width="200"><label for="rem7" class=" control-label text-left"> Julio </label></td>
<td width="150"><input  type='text' name='rem7' id='rem7' value='{{ number_format($row['rem7']+0,2) }}' class='form-control' />  </td>
<td width="200"><label for="rem8" class=" control-label text-left"> Agosto </label></td>
<td width="150"><input  type='text' name='rem8' id='rem8' value='{{ number_format($row['rem8']+0,2) }}' class='form-control' /> </td>
</tr>
<tr>
<td width="200"><label for="rem9" class=" control-label text-left"> Septiembre </label></td>
<td width="150"><input  type='text' name='rem9' id='rem9' value='{{ number_format($row['rem9']+0,2) }}' class='form-control' />  </td>
<td width="200"><label for="rem10" class=" control-label text-left"> Octubre </label></td>
<td width="150"><input  type='text' name='rem10' id='rem10' value='{{ number_format($row['rem10']+0,2) }}' class='form-control' /> </td>
<td width="200"><label for="rem11" class=" control-label text-left"> Noviembre </label></td>
<td width="150"><input  type='text' name='rem11' id='rem11' value='{{ number_format($row['rem11']+0,2) }}' class='form-control' />  </td>
<td width="200"><label for="rem12" class=" control-label text-left"> Diciembre </label></td>
<td width="150"><input  type='text' name='rem12' id='rem12' value='{{ number_format($row['rem12']+0,2) }}' class='form-control' />  </td>
</tr>
<tr>
<td colspan="7"><label for="rem_subtotal" class=" control-label text-left"> SUBTOTAL </label></td>
<td colspan="1"><input  type='text' name='rem_subtotal' id='rem_subtotal' value='{{ number_format($row['rem_subtotal']+0,2) }}' class='form-control' />   </td>
</tr>
<tr>
<td width="200"><label for="grati1" class=" control-label text-left"> Gratificación Julio </label></td>
<td width="150"><input  type='text' name='grati1' id='grati1' value='{{ number_format($row['grati1']+0,2) }}' class='form-control' />  </td>
<td width="200"><label for="boni1" class=" control-label text-left"> Bonif. Extr. Julio </label></td>
<td width="150"><input  type='text' name='boni1' id='boni1' value='{{ number_format($row['boni1']+0,2) }}' class='form-control' />  </td>
<td width="200"><label for="grati2" class=" control-label text-left"> Gratificación Diciembre </label></td>
<td width="150"><input  type='text' name='grati2' id='grati2' value='{{ number_format($row['grati2']+0,2) }}' class='form-control' /> </td>
<td width="200"><label for="boni2" class=" control-label text-left"> Bonif. Extr. Diciembre </label></td>
<td width="150"><input  type='text' name='boni2' id='boni2' value='{{ number_format($row['boni2']+0,2) }}' class='form-control' /> </td>
</tr>
<tr>
<td width="200"><label for="canasta" class=" control-label text-left"> Canasta Navidad </label></td>
<td width="150"><input  type='text' name='canasta' id='canasta' value='{{ number_format($row['canasta']+0,2) }}' class='form-control' />   </td>
<td width="200"><label for="distribucion" class=" control-label text-left"> Distribución Utilidades </label></td>
<td width="150"><input  type='text' name='distribucion' id='distribucion' value='{{ number_format($row['distribucion']+0,2) }}' class='form-control' />   </td>
<td width="200"><label for="otros" class=" control-label text-left"> Otros Ingresos Extr. </label></td>
<td width="150"><input  type='text' name='otros' id='otros' value='{{ number_format($row['otros']+0,2) }}' class='form-control' />   </td>
<td colspan="2"></td>
</tr>
<tr>
<td colspan="7"><label for="total_ingresos" class=" control-label text-left"> TOTAL INGRESOS </label></td>
<td colspan="1"><input  type='text' name='total_ingresos' id='total_ingresos' value='{{ number_format($row['total_ingresos']+0,2) }}' class='form-control' />   </td>
</tr>
<tr>
<td colspan="7"><label for="deduccion" class=" control-label text-left"> Deducción 7 UIT </label></td>
<td colspan="1"><input  type='text' name='deduccion' id='deduccion' value='{{ number_format($row['deduccion']+0,2) }}' class='form-control' />    </td>
</tr>
<tr>
<td colspan="7"><label for="base_imponible" class=" control-label text-left"> BASE IMPONIBLE </label></td>
<td colspan="1"><input  type='text' name='base_imponible' id='base_imponible' value='{{ number_format($row['base_imponible']+0,2) }}' class='form-control' />   </td>
</tr>
<tr>
<td width="200"><label for="tasa1" class=" control-label text-left"> Tasa (00 - 05 UIT) </label></td>
<td width="150"><input  type='text' name='tasa1' id='tasa1' value='{{ number_format($row['tasa1']+0,2) }}' class='form-control' />   </td>
<td width="200"><label for="tasa2" class=" control-label text-left"> Tasa (05 - 20 UIT) </label></td>
<td width="150"><input  type='text' name='tasa2' id='tasa2' value='{{ number_format($row['tasa2']+0,2) }}' class='form-control' />   </td>
<td width="200"><label for="tasa3" class=" control-label text-left"> Tasa (20 - 35 UIT) </label></td>
<td width="150"><input  type='text' name='tasa3' id='tasa3' value='{{ number_format($row['tasa3']+0,2) }}' class='form-control' /> </td>
<td width="200"><label for="tasa4" class=" control-label text-left"> Tasa (35 - 45 UIT) </label></td>
<td width="150"><input  type='text' name='tasa4' id='tasa4' value='{{ number_format($row['tasa4']+0,2) }}' class='form-control' /> </td>
</tr>
<tr>
<td width="200"><label for="tasa5" class=" control-label text-left"> Tasa (45 - ++ UIT) </label></td>
<td width="150"><input  type='text' name='tasa5' id='tasa5' value='{{ number_format($row['tasa5']+0,2) }}' class='form-control' />   </td>
<td colspan="6"></td>
</tr>
<tr>
<td colspan="7"><label for="impuesto_anual" class=" control-label text-left"> IMPUESTO ANUAL </label></td>
<td colspan="1"><input  type='text' name='impuesto_anual' id='impuesto_anual' value='{{ number_format($row['impuesto_anual']+0,2) }}' class='form-control' />   </td>
</tr>
<tr>
<td colspan="8"><label for="Retenciones" class=" control-label text-left"> Retenciones </label></td>
</tr>
<tr>
<td width="200"><label for="ret1" class=" control-label text-left"> Enero </label></td>
<td width="150"><input  type='text' name='ret1' id='ret1' value='{{ number_format($row['ret1']+0,2) }}' class='form-control' /> </td>
<td width="200"><label for="ret2" class=" control-label text-left"> Febrero </label></td>
<td width="150"><input  type='text' name='ret2' id='ret2' value='{{ number_format($row['ret2']+0,2) }}' class='form-control' /> </td>
<td width="200"><label for="ret3" class=" control-label text-left"> Marzo </label></td>
<td width="150"><input  type='text' name='ret3' id='ret3' value='{{ number_format($row['ret3']+0,2) }}' class='form-control' />  </td>
<td width="200"><label for="ret4" class=" control-label text-left"> Abril </label></td>
<td width="150"><input  type='text' name='ret4' id='ret4' value='{{ number_format($row['ret4']+0,2) }}' class='form-control' />  </td>
</tr>
<tr>
<td width="200"><label for="ret5" class=" control-label text-left"> Mayo </label></td>
<td width="150"><input  type='text' name='ret5' id='ret5' value='{{ number_format($row['ret5']+0,2) }}' class='form-control' />  </td>
<td width="200"><label for="ret6" class=" control-label text-left"> Junio </label></td>
<td width="150"><input  type='text' name='ret6' id='ret6' value='{{ number_format($row['ret6']+0,2) }}' class='form-control' />  </td>
<td width="200"><label for="ret7" class=" control-label text-left"> Julio </label></td>
<td width="150"><input  type='text' name='ret7' id='ret7' value='{{ number_format($row['ret7']+0,2) }}' class='form-control' />  </td>
<td width="200"><label for="ret8" class=" control-label text-left"> Agosto </label></td>
<td width="150"><input  type='text' name='ret8' id='ret8' value='{{ number_format($row['ret8']+0,2) }}' class='form-control' /> </td>
</tr>
<tr>
<td width="200"><label for="ret9" class=" control-label text-left"> Septiembre </label></td>
<td width="150"><input  type='text' name='ret9' id='ret9' value='{{ number_format($row['ret9']+0,2) }}' class='form-control' />  </td>
<td width="200"><label for="ret10" class=" control-label text-left"> Octubre </label></td>
<td width="150"><input  type='text' name='ret10' id='ret10' value='{{ number_format($row['ret10']+0,2) }}' class='form-control' />  </td>
<td width="200"><label for="ret11" class=" control-label text-left"> Noviembre </label></td>
<td width="150"><input  type='text' name='ret11' id='ret11' value='{{ number_format($row['ret11']+0,2) }}' class='form-control' />  </td>
<td width="200"><label for="ret12" class=" control-label text-left"> Diciembre </label></td>
<td width="150"><input  type='text' name='ret12' id='ret12' value='{{ number_format($row['ret12']+0,2) }}' class='form-control' />  </td>
</tr>
<tr>
<td colspan="7"><label for="total_retenciones" class=" control-label text-left"> TOTAL RETENCIONES </label></td>
<td colspan="1"><input  type='text' name='total_retenciones' id='total_retenciones' value='{{ number_format($row['total_retenciones']+0,2) }}' class='form-control' />   </td>
</tr>
<tr>
<td colspan="7"><label for="saldo_impuesto_anual" class=" control-label text-left"> SALDO IMPUESTO ANUAL </label></td>
<td colspan="1"><input  type='text' name='saldo_impuesto_anual' id='saldo_impuesto_anual' value='{{ number_format($row['saldo_impuesto_anual']+0,2) }}' class='form-control' />   </td>
</tr>
<tr>
<td colspan="7"><label for="ret_ord" class=" control-label text-left"> RETENCION ORD. </label></td>
<td colspan="1"><input  type='text' name='ret_ord' id='ret_ord' value='{{ number_format($row['ret_ord']+0,2) }}' class='form-control' />   </td>
</tr>
<tr>
<td colspan="7"><label for="ret_ext" class=" control-label text-left"> RETENCION EXT. </label></td>
<td colspan="1"><input  type='text' name='ret_ext' id='ret_ext' value='{{ number_format($row['ret_ext']+0,2) }}' class='form-control' />    </td>
</tr>
<tr>
<td colspan="7"><label for="ret_final" class=" control-label text-left"> RETENCION </label></td>
<td colspan="1"><input  type='text' name='ret_final' id='ret_final' value='{{ number_format($row['ret_final']+0,2) }}' class='form-control' />   </td>
</tr>
</table>
			<div style="clear:both"></div>			 
		 {!! Form::close() !!}
	</div>
</div>		 
</div>			 
   <script type="text/javascript">
	</script>		 
@stop