@extends('layouts.app')

@section('content')

    <div class="container-fluid">

	        <div class="row bg-title">
            <!-- .page title -->
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Conceptos y Afectaciones</h4> </div>
            <!-- /.page title -->
			 <!-- .breadcrumb -->
			 
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12"> 
			    <div class="box-header-tools pull-right" >
	  <a href="{{ url('planilla?return='.$return) }}" class="tips btn btn-xs btn-warning btn-sm btn-circle"><i class="fa  fa-arrow-left"></i></a>
	</div>
            </div>
            <!-- /.breadcrumb -->
        </div>

<!-- .row -->
        <div class="row">		
		<div class="white-box"> 
			<div class="row row-in"  >
			<div class="col-lg-1 col-sm-6 b-0">			
			</div>
			<div class="col-lg-10 col-sm-6 b-0">
		<div class="form-group  " >
		 <label for="Habilitado" class="col-md-2 "> Concepto a modificar </label>
		 <div class="col-md-7">
				{!! Form::open(array('url'=>'captura_habilitado', 'class'=>'form-horizontal')) !!} 
                                    {!!  Form::select('habilitado', $habilitado,null,['class'=>'select2' ])  !!}
		 </div> 
		 <div class="col-md-3">
				<button class="btn btn-primary btn-xs" type="submit" > <i class=""></i>
			    <span class=""></span>Buscar</button>
				{!! Form::close() !!}
		 </div>
		</div>			
		</div>
	<div class="col-lg-1 col-sm-6 b-0">			
			</div>
    </div>	
		</div>		
		</div>
<!-- .row -->
        <div class="row">		
		<div class="white-box"> 
	<div class="row row-in"  >		
					
	 {!! Form::open(array('url'=>'editable/delete/0?return='.$return, 'class'=>'form-horizontal' ,'id' =>'SximoTable' )) !!}
		
	 <div class="table-responsive" style="min-height:300px;  padding-bottom:60px;">
		 
    <table class="table table-bordered table-hover">
        <thead>
			<tr>
				<th class="number"><span> No </span> </th>
				<th> <input type="checkbox" class="checkall" /></th>
				<th ><span>{{ Lang::get('core.btn_action') }}</span></th>
				

						
							<th><span>Nombres</span></th>			
						    <th><span>
							@if(isset($campo)) 
                            {{ $campo }}
                            @endif
							</span></th>
	
			  </tr>
        </thead>

        <tbody>        						
            @foreach ($rowData as $row)
                <tr>
					<td width="30"> {{ ++$i }} </td>
					<td width="50"><input type="checkbox" class="ids" name="ids[]" value="{{ $row->planilla_id }}" />  </td>	
					<td>
					 	<div class="dropdown">
						  <button class="btn btn-primary btn-xs dropdown-toggle" type="button" data-toggle="dropdown"> <i class="fa fa-cog"></i>
						  <span class="caret"></span></button>
						  <ul class="dropdown-menu">
							@if($access['is_edit'] ==1)
							<li><a  href="{{ URL::to('editable/update/'.$row->planilla_id.'?return='.$return) }}" class="tips" title="{{ Lang::get('core.btn_edit') }}"><i class="fa fa-edit "></i> {{ Lang::get('core.btn_edit') }} </a></li>
							@endif
						  </ul>
						</div>

					</td>


						 <td>
							{{ SiteHelpers::formatLookUp($row->id_trabajador,'id_trabajador','1:jl_empleados:id_trabajador:ape_paterno') }} 
						 	{{ SiteHelpers::formatLookUp($row->id_trabajador,'id_trabajador','1:jl_empleados:id_trabajador:ape_materno') }} ,
							{{ SiteHelpers::formatLookUp($row->id_trabajador,'id_trabajador','1:jl_empleados:id_trabajador:nombres') }}
						 </td>
						
					 <td>	@if(isset($row->{Session::get('codigo_itd')})) 				 
						 	{{ $row->{Session::get('codigo_itd')} }}						 
						    @endif
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
@stop