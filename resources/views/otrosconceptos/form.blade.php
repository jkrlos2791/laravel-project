@extends('layouts.app')

@section('content')

<section class="content-header">
  <h1>
   {{ $pageTitle }}
    <small></small>
  </h1>
</section>

  <div class="content">
 
 	<div class="box box-danger ">

	<div class="box-header with-border"> 
		<div class="box-header-tools pull-left" >
		</div>

		<div class="box-header-tools pull-right" >
			<a href="{{ url($pageModule.'?return='.$return) }}" class="tips btn btn-xs btn-warning btn-sm btn-circle"  title="{{ Lang::get('core.btn_back') }}" ><i class="fa  fa-arrow-left"></i></a> 
		</div>
	</div>	
	
<div class="box-body">
		<ul class="parsley-error-list">
			@foreach($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>

		 {!! Form::open(array('url'=>'otrosconceptos/save?return='.$return, 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}
<div class="col-md-12">
						<fieldset>
										{!! Form::hidden('planilla_id', $row['planilla_id']) !!}							
									  
									  <div class="form-group  " >
										<label for="0811" class=" control-label col-md-4 text-left">{{ Session::get('descripcion_oc') }}</label>
										<div class="col-md-7">
										  <input  type='text' name='codigo' id='codigo' value='{{ $row[Session::get('codigo_oc')] }}' 
						     class='form-control ' /> 
										 </div> 
										 <div class="col-md-1">
										 	
										 </div>
									  </div> </fieldset>
			</div>
	
			<div style="clear:both"></div>	
								
				  <div class="form-group">
					<label class="col-sm-4 text-right">&nbsp;</label>
					<div class="col-sm-8">	
					<button type="submit" name="apply" class="btn btn-info btn-sm" ><i class="fa  fa-check-circle"></i> {{ Lang::get('core.sb_apply') }}</button>
					<button type="submit" name="submit" class="btn btn-primary btn-sm" ><i class="fa  fa-save "></i> {{ Lang::get('core.sb_save') }}</button>
					<button type="button" onclick="location.href='{{ URL::to('otrosconceptos?return='.$return) }}' " class="btn btn-warning btn-sm "><i class="fa  fa-arrow-circle-left "></i>  {{ Lang::get('core.sb_cancel') }} </button>
					</div>	  
			
				  </div> 
		 
		 {!! Form::close() !!}
</div>		 
</div>	
</div>			 
   <script type="text/javascript">
	$(document).ready(function() { 

		$('.removeMultiFiles').on('click',function(){
			var removeUrl = '{{ url("editable/removefiles?file=")}}'+$(this).attr('url');
			$(this).parent().remove();
			$.get(removeUrl,function(response){});
			$(this).parent('div').empty();	
			return false;
		});		
		
	});
	</script>		 
@stop