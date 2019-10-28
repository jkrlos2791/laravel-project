@extends('layouts.app')

@section('content')
{{--*/ usort($tableGrid, "SiteHelpers::_sort") /*--}}

    <section class="content-header">
      <h1>
         Cálculo Planilla
        <small></small>
      </h1>
    </section>
	
  <div class="content">
    <!-- Page header -->
	
<div class="box box-primary ">
	<div class="box-header with-border"> 
		<div class="box-header-tools pull-left" >	
			<a href="{{ URL::to( 'gratificacion/search?return='.$return) }}" class="btn btn-xs btn-warning btn-sm btn-circle" onclick="SximoModal(this.href,'Advance Search'); return false;" title="{{ Lang::get('core.btn_search') }}"><i class="fa  fa-search"></i> </a>				
			<a href="{{ URL::to('descargar_boletas') }}" class="tips btn btn-xs btn-info btn-sm btn-circle" title="{{ Lang::get('core.btn_download') }}">
			<i class="fa fa-cloud-download"></i></a>
			@if($access['is_excel'] ==1)
			<a href="{{ URL::to('descargar') }}" class="tips btn btn-xs btn-info btn-sm btn-circle" title="{{ Lang::get('core.btn_download') }}">
			<i class="fa fa-cloud-download"></i></a>
			@endif
		</div>

		<div class="box-header-tools pull-right" >
		
		
				<style>
			.btn:active
{
  background-color:yellow;
}
		.btn.active
{
  color: #fff;
  background-color:red;
}
		</style>
		

		<div class="btn-group">
            <a type="button" class="active btn btn-default" id="regi1" href="{{ URL::to( 'listar_empleados') }}"><i class="icon-rock"></i>Empleados</a>
            <a type="button" class="btn btn-default" id="regi2" href="{{ URL::to( 'listar_obreros') }}"><i class="icon-rocket"></i>Obreros</a>
		</div>
		    
			<a href="{{ URL::to('generacion') }}" class=" tips btn btn-xs btn-info btn-sm btn-circle"  title="Calcular PLanilla" ><i class="fa fa-spinner"></i>  </a>
			<a href="{{ url($pageModule) }}" class=" tips btn btn-xs btn-info btn-sm btn-circle"  title="{{ Lang::get('core.btn_clearsearch') }}" ><i class="fa fa-spinner"></i>  </a>		
		</div>
	</div>

	<div class="sbox-body"> 	
	

	 {!! (isset($search_map) ? $search_map : '') !!}
	
	 {!! Form::open(array('url'=>'planillageneracion/delete/0?return='.$return, 'class'=>'form-horizontal' ,'id' =>'SximoTable' )) !!}
	 <div class="table-responsive" style="min-height:300px;  padding-bottom:60px;">
    <table class="table table-bordered table-hover">
        <thead>
			<tr>
				<th class="number"><span> No </span> </th>
				<th> <input type="checkbox" class="checkall" /></th>
				<th ><span>{{ Lang::get('core.btn_action') }}</span></th>
				
				<th><span>Documento</span></th>
				<th><span>Trabajador</span></th>
				<th>Centro Costo</th>
				<th><span>Regimen</span></th>
				<th><span>Tipo AFP</span></th>
				<th><span>Tipo Comision</span></th>
				<th><span>CUSSP</span></th>
				<th><span>Fecha de Nacimiento</span></th>
				<th><span>Dias Computables</span></th>
				<th><span>Remuneración</span></th>
				<th><span>Haber Básico</span></th>
				<th><span>Asig. Fam</span></th>
				<th><span>Rem.Vaca</span></th>
				<th><span>Imp.Desc.Med</span></th>
				<th><span>Imp.Sub.Mater</span></th>
				<th><span>Grati.Ordinaria</span></th>
				<th><span>Feriado/Grat.Extra</span></th>
				<th><span>Imp.Horas Noct</span></th>
				<th><span>Base Imponible</span></th>
				<th><span>Movilidad Suped</span></th>
				<th><span>Condicion Trabajo</span></th>
				<th><span>Bono de productividad</span></th>
				<th><span>Grat.Extraordinaria</span></th>
				<th><span>Incentivos</span></th>
				<th><span>Canasta Navidad</span></th>
				<th><span>Total Ingresos</span></th>
				<th><span>AFP_Com</span></th>
				<th><span>AFP_Fon</span></th>
				<th><span>AFP_Seg</span></th>
				<th><span>AFP</span></th>
				<th><span>5ta Categoria</span></th>
				<th><span>Pago Vacaciones / Bono / Incentivos</span></th>
				<th><span>ONP</span></th>
				<th><span>Descuento E.P.S</span></th>
				<th><span>Adelanto Remuneracion</span></th>
				<th><span>Prestamos</span></th>
				<th><span>Entrega Canasta Navidad</span></th>
				<th><span>Total Descuentos</span></th>
				<th><span>Neto Pagar</span></th>
				<th><span>ESSALUD</span></th>
			  </tr>
        </thead>

        <tbody>        						
            @foreach ($rowData as $row)
                <tr>
					<td width="30"> {{ ++$i }} </td>
					<td width="50"><input type="checkbox" class="ids" name="ids[]" value="{{ $row->planilla_id }}" />  </td>	
					<td>
					 	<div class="dropdown">
						  <button class="btn btn-primary btn-xs dropdown-toggle btn-sm btn-circle" type="button" data-toggle="dropdown"> <i class="fa fa-cog"></i>
						  <span class="caret"></span></button>
						  <ul class="dropdown-menu">
						 	@if($access['is_detail'] ==100)
							<li><a href="{{ URL::to('planillageneracion/show/'.$row->planilla_id.'?return='.$return)}}" class="tips" title="{{ Lang::get('core.btn_view') }}"><i class="fa  fa-search "></i> {{ Lang::get('core.btn_view') }} </a></li>
							@endif
							@if($access['is_edit'] ==100)
							<li><a  href="{{ URL::to('planillageneracion/update/'.$row->planilla_id.'?return='.$return) }}" class="tips" title="{{ Lang::get('core.btn_edit') }}"><i class="fa fa-edit "></i> {{ Lang::get('core.btn_edit') }} </a></li>
							@endif
						  </ul>
						</div>

					</td>

						 <td>
							{{ SiteHelpers::formatLookUp($row->id_trabajador,'id_trabajador','1:jl_empleados:id_trabajador:num_doc') }} 
						 </td>
				         <td>
							{{ SiteHelpers::formatLookUp($row->id_trabajador,'id_trabajador','1:jl_empleados:id_trabajador:ape_paterno') }} 
						 	{{ SiteHelpers::formatLookUp($row->id_trabajador,'id_trabajador','1:jl_empleados:id_trabajador:ape_materno') }} ,
							{{ SiteHelpers::formatLookUp($row->id_trabajador,'id_trabajador','1:jl_empleados:id_trabajador:nombres') }}
						 </td>
						 <td>
							{{ SiteHelpers::formatLookUp($row->id_trabajador,'id_trabajador','1:jl_empleados:id_trabajador:centro_costo') }} 
						 </td>
					     <td>
							{{ SiteHelpers::formatLookUp( SiteHelpers::formatLookUp($row->id_trabajador,'id_trabajador','1:jl_empleados:id_trabajador:snp_afp_id') ,'snp_afp_id','1:snp_afps:snp_afp_id:nombre') }} 
						 </td>
						<td>
							{{ SiteHelpers::formatLookUp(SiteHelpers::formatLookUp($row->id_trabajador,'id_trabajador','1:jl_empleados:id_trabajador:afp_id'),'afp_id','1:afps:afp_id:nombre') }} 
						 </td>
						<td>
							{{ SiteHelpers::formatLookUp(SiteHelpers::formatLookUp($row->id_trabajador,'id_trabajador','1:jl_empleados:id_trabajador:comision_tipo_id'),'comision_tipo_id','1:comision_tipos:comision_tipo_id:nombre') }} 
						</td>
					    <td>
							{{ SiteHelpers::formatLookUp($row->id_trabajador,'id_trabajador','1:jl_empleados:id_trabajador:n_cuspp') }}  
						</td>
					    <td>
							{{ SiteHelpers::formatLookUp($row->id_trabajador,'id_trabajador','1:jl_empleados:id_trabajador:fecha_nacimiento') }}  
						</td>
					    <td>
							{{ SiteHelpers::formatLookUp($row->id_trabajador,'id_trabajador','1:planillas:id_trabajador:dias_computables') }}  
						</td>
					    <td>
							{{ SiteHelpers::formatLookUp($row->id_trabajador,'id_trabajador','1:contratos:id_trabajador:sueldo') }}
						</td>
					    <td>
							{{ number_format($row->c0121,2) }}
						</td>
					    <td>
							{{ number_format($row->c0201,2) }}
						</td>
					    <td>
							{{ number_format($row->c0118,2) }}
						</td>
					   <td>
							{{ number_format($row->c0916,2) }}
						</td>
					   <td>
							{{ number_format($row->c0915,2) }}
						</td>
					    <td>
							{{ number_format($row->c0402,2) }}
						</td>
					    <td>
							{{ number_format($row->c0107,2) }}
						</td>
					    <td>
							{{ number_format($row->importe_hn,2) }}
						</td>
					    <td>
							{{ number_format($row->base_imponible,2) }}
						</td>
					   <td>
							{{ number_format($row->c0909,2) }}
						</td>
					    <td>
							{{ number_format($row->c0917,2) }}
						</td>
					    <td>
							{{ number_format($row->c0902,2) }}
						</td>
					   <td>
							{{ number_format($row->c0403,2) }}
						</td>
					   <td>
							{{ number_format($row->incentivos,2) }}
						</td>
					   <td>
							{{ number_format($row->c0903,2) }}
						</td>
					   <td>
							{{ number_format($row->total_ingresos,2) }}
						</td>
					   <td>
							{{ number_format($row->c0601,2) }}
						</td>
					   <td>
							{{ number_format($row->c0608,2) }}
						</td>
					   <td>
							{{ number_format($row->c0606,2) }}
						</td>
					    <td>
							{{ number_format($row->afp,2) }}
						</td>
					   <td>
							{{ number_format($row->c0605,2) }}
						</td>
					   <td>
							{{ number_format($row->c0706,2) }}
						</td>
					   <td>
							{{ number_format($row->c0607,2) }}
						</td>
					   <td>
							{{ number_format($row->eps,2) }}
						</td>
					   <td>
							{{ number_format($row->c0701,2) }}
						</td>
					   <td>
							{{ number_format($row->prestamos,2) }}
						</td>
					   <td>
							{{ number_format($row->c0903,2) }}
						</td>
					   <td>
							{{ number_format($row->total_descuentos,2) }}
						</td>
					   <td>
							
						   {{ number_format($row->neto_pagar, 2) }}
						</td>
					   <td>
						   
							{{ number_format($row->essalud, 2) }}
						</td>
                </tr>
				
            @endforeach
              
        </tbody>
      
    </table>
	<input type="hidden" name="md" value="" />
	</div>
	{!! Form::close() !!}
	@include('footer')
	</div>
</div>	
	</div>	  
</div>	

<script>
$(".btn-group > .btn").click(function(){
    $(".btn-group > .btn").removeClass("active");
    $(this).addClass("active");
});
</script>

@stop