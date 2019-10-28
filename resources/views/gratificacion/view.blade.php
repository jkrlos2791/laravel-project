@extends('layouts.app')

@section('content')
<div class="page-content row">
    <!-- Page header -->

	 
	 
 	<div class="page-content-wrapper m-t">   

<div class="sbox ">
	<div class="sbox-title">
		<div class="sbox-tools pull-left" >
	   		<a href="{{ url('gratificacion?return='.$return) }}" class="tips btn btn-xs btn-default" title="{{ Lang::get('core.btn_back') }}"><i class="fa  fa-arrow-left"></i></a>
			@if($access['is_add'] ==1)
	   		<a href="{{ url('gratificacion/update/'.$id.'?return='.$return) }}" class="tips btn btn-xs btn-default" title="{{ Lang::get('core.btn_edit') }}"><i class="fa  fa-pencil"></i></a>
			@endif 
					
		</div>	

		<div class="sbox-tools " >
			<a href="{{ ($prevnext['prev'] != '' ? url('gratificacion/show/'.$prevnext['prev'].'?return='.$return ) : '#') }}" class="tips btn btn-xs btn-default"><i class="fa fa-arrow-left"></i>  </a>	
			<a href="{{ ($prevnext['next'] != '' ? url('gratificacion/show/'.$prevnext['next'].'?return='.$return ) : '#') }}" class="tips btn btn-xs btn-default"> <i class="fa fa-arrow-right"></i>  </a>
			@if(Session::get('gid') ==1)
				<a href="{{ URL::to('sximo/module/config/'.$pageModule) }}" class="tips btn btn-xs btn-default" title=" {{ Lang::get('core.btn_config') }}" ><i class="fa  fa-ellipsis-v"></i></a>
			@endif 			
		</div>


	</div>
	<div class="sbox-content" > 	

		<table class="table table-striped table-bordered" >
			<tbody>	
		
					<tr>
						<td width='30%' class='label-view text-right'>Gratificacion Id</td>
						<td>{{ $row->gratificacion_id}} </td>
						
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
						<td width='30%' class='label-view text-right'>Haber Basico</td>
						<td>{{ $row->haber_basico}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Asig Fam</td>
						<td>{{ $row->asig_fam}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Pro Rem Var</td>
						<td>{{ $row->pro_rem_var}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Total Rem Com</td>
						<td>{{ $row->total_rem_com}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Ts Meses</td>
						<td>{{ $row->ts_meses}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Ts Dias</td>
						<td>{{ $row->ts_dias}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Faltas</td>
						<td>{{ $row->faltas}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Tc Meses</td>
						<td>{{ $row->tc_meses}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Tc Dias</td>
						<td>{{ $row->tc_dias}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Grati 30334</td>
						<td>{{ $row->grati_30334}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Boni 30334</td>
						<td>{{ $row->boni_30334}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Total Grati</td>
						<td>{{ $row->total_grati}} </td>
						
					</tr>
				
			</tbody>	
		</table>   

	 
	
	</div>
</div>	

	</div>
</div>
	  
@stop