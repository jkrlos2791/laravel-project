<div class="m-t" style="padding-top:25px;">	
    <div class="row m-b-lg animated fadeInDown delayp1 text-center">
        <h3> {{ $pageTitle }} <small> {{ $pageNote }} </small></h3>
        <hr />       
    </div>
</div>
<div class="m-t">
	<div class="table-responsive" > 	

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
						
					<tr>
						<td width='30%' class='label-view text-right'></td>
						<td> <a href="javascript:history.go(-1)" class="btn btn-primary"> Back To Grid <a> </td>
						
					</tr>					
				
			</tbody>	
		</table>   

	 
	
	</div>
</div>	