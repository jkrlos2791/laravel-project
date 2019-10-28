@extends('layouts.app')

@section('content')
<div class="page-content row">
    <!-- Page header -->

	 
	 
 	<div class="page-content-wrapper m-t">   

<div class="sbox ">
	<div class="sbox-title">
		<div class="sbox-tools pull-left" >
	   		<a href="{{ url('liquidacion?return='.$return) }}" class="tips btn btn-xs btn-default" title="{{ Lang::get('core.btn_back') }}"><i class="fa  fa-arrow-left"></i></a>
			@if($access['is_add'] ==1)
	   		<a href="{{ url('liquidacion/update/'.$id.'?return='.$return) }}" class="tips btn btn-xs btn-default" title="{{ Lang::get('core.btn_edit') }}"><i class="fa  fa-pencil"></i></a>
			@endif 
					
		</div>	

		<div class="sbox-tools " >
			<a href="{{ ($prevnext['prev'] != '' ? url('liquidacion/show/'.$prevnext['prev'].'?return='.$return ) : '#') }}" class="tips btn btn-xs btn-default"><i class="fa fa-arrow-left"></i>  </a>	
			<a href="{{ ($prevnext['next'] != '' ? url('liquidacion/show/'.$prevnext['next'].'?return='.$return ) : '#') }}" class="tips btn btn-xs btn-default"> <i class="fa fa-arrow-right"></i>  </a>
			@if(Session::get('gid') ==1)
				<a href="{{ URL::to('sximo/module/config/'.$pageModule) }}" class="tips btn btn-xs btn-default" title=" {{ Lang::get('core.btn_config') }}" ><i class="fa  fa-ellipsis-v"></i></a>
			@endif 			
		</div>


	</div>
	<div class="sbox-content" > 	

		<table class="table table-striped table-bordered" >
			<tbody>	
		
					<tr>
						<td width='30%' class='label-view text-right'>Liquidacion Id</td>
						<td>{{ $row->liquidacion_id}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Id Trabajador</td>
						<td>{{ $row->id_trabajador}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Periodo Id</td>
						<td>{{ $row->periodo_id}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Cargo</td>
						<td>{{ $row->cargo}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Centro Costo</td>
						<td>{{ $row->centro_costo}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Fecha Ingreso</td>
						<td>{{ $row->fecha_ingreso}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Fecha Cese</td>
						<td>{{ $row->fecha_cese}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Condicion Trabajo</td>
						<td>{{ $row->condicion_trabajo}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Tiempo Servicio</td>
						<td>{{ $row->tiempo_servicio}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Faltas</td>
						<td>{{ $row->faltas}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Tiempo Computable</td>
						<td>{{ $row->tiempo_computable}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Motivo Cese</td>
						<td>{{ $row->motivo_cese}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Sistema Pension</td>
						<td>{{ $row->sistema_pension}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Tipo Comision Afp</td>
						<td>{{ $row->tipo_comision_afp}} </td>
						
					</tr>
				
			</tbody>	
		</table>   

	 
	
	</div>
</div>	

	</div>
</div>
	  
@stop