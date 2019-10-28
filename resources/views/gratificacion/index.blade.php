@extends('layouts.app')

@section('content')
{{--*/ usort($tableGrid, "SiteHelpers::_sort") /*--}}

    <section class="content-header">
      <h1>
         {{ $pageTitle }}
        <small></small>
      </h1>
    </section>

  <div class="content">
    <!-- Page header -->
	
<div class="box box-primary ">
	<div class="box-header with-border"> 
		<div class="box-header-tools pull-left" >	
			<a href="{{ URL::to( 'gratificacion/search?return='.$return) }}" class="btn btn-xs btn-warning btn-sm btn-circle" onclick="SximoModal(this.href,'Advance Search'); return false;" title="{{ Lang::get('core.btn_search') }}"><i class="fa  fa-search"></i> </a>				
			@if($access['is_excel'] ==1)
			<a href="{{ URL::to('gratificacion/download?return='.$return) }}" class="tips btn btn-xs btn-info btn-sm btn-circle" title="{{ Lang::get('core.btn_download') }}">
			<i class="fa fa-cloud-download"></i></a>
			@endif
		</div>

		<div class="box-header-tools pull-right" >
			<a href="{{ URL::to('calculo_gratificacion') }}" class=" tips btn btn-xs btn-info btn-sm btn-circle"  title="Calcular Gratificación" ><i class="fa fa-spinner"></i>  </a>		
			<a href="{{ url($pageModule) }}" class=" tips btn btn-xs btn-info btn-sm btn-circle"  title="{{ Lang::get('core.btn_clearsearch') }}" ><i class="fa fa-spinner"></i>  </a>		
		</div>
	</div>

	<div class="sbox-body"> 	
	

	 {!! (isset($search_map) ? $search_map : '') !!}
		
	 {!! Form::open(array('url'=>'gratificacion/delete/0?return='.$return, 'class'=>'form-horizontal' ,'id' =>'SximoTable' )) !!}
	 <div class="table-responsive" style="min-height:300px;  padding-bottom:60px;">
    <table class="table table-bordered table-hover">
        <thead>
			<tr>
				<th class="number"><span> No </span> </th>
				<th> <input type="checkbox" class="checkall" /></th>
				<th ><span>{{ Lang::get('core.btn_action') }}</span></th>
				
				<th><span>Fecha Nacimiento</span></th>
				<th><span>DNI</span></th>
				<th><span>Apellidos y Nombres</span></th>
				<th><span>Cargo</span></th>
				<th><span>Fecha Ingreso</span></th>
				<th><span>Régimen Pensionario</span></th>
				<th><span>CUSSP</span></th>
				<th><span>Haber Básico</span></th>
				<th><span>Asig. Familiar</span></th>
				<th><span>Prom. Rem. Variables</span></th>
				<th><span>Total Remuneración Computable</span></th>
				<th><span>Meses Efectivos</span></th>
				<th><span>Días Efectivos</span></th>
				<th><span>Días Faltas</span></th>
				<th><span>Meses Efectivos Computables</span></th>
				<th><span>Días Efectivos Computables</span></th>
				<th><span>Gratificación Ley 30334</span></th>
				<th><span>Bonificación Ley 30334</span></th>
				<th><span>Total Gratificación</span></th>
				
			  </tr>
        </thead>

        <tbody>        						
            @foreach ($rowData as $row)
                <tr>
					<td width="30"> {{ ++$i }} </td>
					<td width="50"><input type="checkbox" class="ids" name="ids[]" value="{{ $row->gratificacion_id }}" />  </td>	
					<td>
					 	<div class="dropdown">
						  <button class="btn btn-primary btn-xs dropdown-toggle" type="button" data-toggle="dropdown"> <i class="fa fa-cog"></i>
						  <span class="caret"></span></button>
						  <ul class="dropdown-menu">
						 	@if($access['is_detail'] ==1)
							<li><a href="{{ URL::to('gratificacion/show/'.$row->gratificacion_id.'?return='.$return)}}" class="tips" title="{{ Lang::get('core.btn_view') }}"><i class="fa  fa-search "></i> {{ Lang::get('core.btn_view') }} </a></li>
							@endif
							@if($access['is_edit'] ==1)
							<li><a  href="{{ URL::to('gratificacion/update/'.$row->gratificacion_id.'?return='.$return) }}" class="tips" title="{{ Lang::get('core.btn_edit') }}"><i class="fa fa-edit "></i> {{ Lang::get('core.btn_edit') }} </a></li>
							@endif
						  </ul>
						</div>

					</td>
            <td>{{ SiteHelpers::formatLookUp($row->id_trabajador,'id_trabajador','1:jl_empleados:id_trabajador:fecha_nacimiento') }}</td>
			<td>{{ SiteHelpers::formatLookUp($row->id_trabajador,'id_trabajador','1:jl_empleados:id_trabajador:num_doc') }}</td>
			<td>{{ SiteHelpers::formatLookUp($row->id_trabajador,'id_trabajador','1:jl_empleados:id_trabajador:ape_paterno') }} 
				{{ SiteHelpers::formatLookUp($row->id_trabajador,'id_trabajador','1:jl_empleados:id_trabajador:ape_materno') }},
				{{ SiteHelpers::formatLookUp($row->id_trabajador,'id_trabajador','1:jl_empleados:id_trabajador:nombres') }}</td>				
			<td>{{ SiteHelpers::formatLookUp($row->id_trabajador,'id_trabajador','1:jl_empleados:id_trabajador:num_doc') }}</td>
			<td>{{ SiteHelpers::formatLookUp($row->id_trabajador,'id_trabajador','1:contratos:id_trabajador:fecha_ingreso') }}</td>
			<td>{{ SiteHelpers::formatLookUp( SiteHelpers::formatLookUp($row->id_trabajador,'id_trabajador','1:jl_empleados:id_trabajador:snp_afp_id') ,'snp_afp_id','1:snp_afps:snp_afp_id:nombre') }}</td>
			<td>{{ SiteHelpers::formatLookUp($row->id_trabajador,'id_trabajador','1:jl_empleados:id_trabajador:n_cuspp') }}</td>
			<td>{{ number_format($row->haber_basico,2) }}</td>
			<td>{{ number_format($row->asig_fam,2) }}</td>
			<td>{{ number_format($row->pro_rem_var,2) }}</td>
			<td>{{ number_format($row->total_rem_com,2) }}</td>
			<td>{{ $row->ts_meses }}</td>
			<td>{{ $row->ts_dias }}</td>
			<td>{{ $row->faltas }}</td>
			<td>{{ $row->tc_meses }}</td>
			<td>{{ $row->tc_dias }}</td>
			<td>{{ number_format($row->grati_30334,2) }}</td>
			<td>{{ number_format($row->boni_30334,2) }}</td>
			<td>{{ number_format($row->total_grati,2) }}</td>
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
	
@stop