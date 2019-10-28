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
			<a href="{{ URL::to( 'liquidacion/search?return='.$return) }}" class="btn btn-xs btn-warning btn-sm btn-circle" onclick="SximoModal(this.href,'Advance Search'); return false;" title="{{ Lang::get('core.btn_search') }}"><i class="fa  fa-search"></i> </a>				
			@if($access['is_excel'] ==1)
			<a href="{{ URL::to('liquidacion/download?return='.$return) }}" class="tips btn btn-xs btn-info btn-sm btn-circle" title="{{ Lang::get('core.btn_download') }}">
			<i class="fa fa-cloud-download"></i></a>
			@endif
		</div>

		<div class="box-header-tools pull-right" >
			<a href="{{ URL::to('calculo_liquidacion') }}" class=" tips btn btn-xs btn-info btn-sm btn-circle"  title="Calcular Liquidación" ><i class="fa fa-spinner"></i>  </a>		
			<a href="{{ url($pageModule) }}" class=" tips btn btn-xs btn-info btn-sm btn-circle"  title="{{ Lang::get('core.btn_clearsearch') }}" ><i class="fa fa-spinner"></i>  </a>		
		</div>
	</div>

	<div class="sbox-body"> 	
	

	 {!! (isset($search_map) ? $search_map : '') !!}
	 
	 {!! Form::open(array('url'=>'liquidacion/delete/0?return='.$return, 'class'=>'form-horizontal' ,'id' =>'SximoTable' )) !!}
	 <div class="table-responsive" style="min-height:300px;  padding-bottom:60px;">
    <table class="table table-bordered table-hover">
        <thead>
			<tr>
				<th class="number"><span> No </span> </th>
				<th> <input type="checkbox" class="checkall" /></th>
				<th ><span>{{ Lang::get('core.btn_action') }}</span></th>
				
				@foreach ($tableGrid as $t)
					@if($t['view'] =='1')				
						<?php $limited = isset($t['limited']) ? $t['limited'] :''; ?>
						@if(SiteHelpers::filterColumn($limited ))
						
							<th><span>{{ $t['label'] }}</span></th>			
						@endif 
					@endif
				@endforeach
				
			  </tr>
        </thead>

        <tbody>        						
            @foreach ($rowData as $row)
                <tr>
					<td width="30"> {{ ++$i }} </td>
					<td width="50"><input type="checkbox" class="ids" name="ids[]" value="{{ $row->liquidacion_id }}" />  </td>	
					<td>
					 	<div class="dropdown">
						  <button class="btn btn-primary btn-xs dropdown-toggle" type="button" data-toggle="dropdown"> <i class="fa fa-cog"></i>
						  <span class="caret"></span></button>
						  <ul class="dropdown-menu">
							<li><a href="{{ URL::to('descargar_liquidacion/'.$row->liquidacion_id.'?return='.$return)}}" class="tips" title="Ver Liquidación"><i class="fa  fa-search "></i> Ver Liquidación </a></li>
						  </ul>
						</div>

					</td>

				 @foreach ($tableGrid as $field)
					 @if($field['view'] =='1')
					 	<?php $limited = isset($field['limited']) ? $field['limited'] :''; ?>
					 	@if(SiteHelpers::filterColumn($limited ))
						 <td>					 
						 	{!! SiteHelpers::formatRows($row->{$field['field']},$field ,$row ) !!}						 
						 </td>
						@endif	
					 @endif					 
				 @endforeach		 
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