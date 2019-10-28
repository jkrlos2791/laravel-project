

		 {!! Form::open(array('url'=>'gratificacion/savepublic', 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}

	@if(Session::has('messagetext'))
	  
		   {!! Session::get('messagetext') !!}
	   
	@endif
	<ul class="parsley-error-list">
		@foreach($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
	</ul>		


<div class="col-md-12">
						<fieldset><legend> Cálculo Gratificación</legend>
									
									  <div class="form-group  " >
										<label for="Gratificacion Id" class=" control-label col-md-4 text-left"> Gratificacion Id </label>
										<div class="col-md-7">
										  <input  type='text' name='gratificacion_id' id='gratificacion_id' value='{{ $row['gratificacion_id'] }}' 
						     class='form-control ' /> 
										 </div> 
										 <div class="col-md-1">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="Id Trabajador" class=" control-label col-md-4 text-left"> Id Trabajador </label>
										<div class="col-md-7">
										  <input  type='text' name='id_trabajador' id='id_trabajador' value='{{ $row['id_trabajador'] }}' 
						     class='form-control ' /> 
										 </div> 
										 <div class="col-md-1">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="Periodo Id" class=" control-label col-md-4 text-left"> Periodo Id </label>
										<div class="col-md-7">
										  <input  type='text' name='periodo_id' id='periodo_id' value='{{ $row['periodo_id'] }}' 
						     class='form-control ' /> 
										 </div> 
										 <div class="col-md-1">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="Haber Basico" class=" control-label col-md-4 text-left"> Haber Basico </label>
										<div class="col-md-7">
										  <input  type='text' name='haber_basico' id='haber_basico' value='{{ $row['haber_basico'] }}' 
						     class='form-control ' /> 
										 </div> 
										 <div class="col-md-1">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="Asig Fam" class=" control-label col-md-4 text-left"> Asig Fam </label>
										<div class="col-md-7">
										  <input  type='text' name='asig_fam' id='asig_fam' value='{{ $row['asig_fam'] }}' 
						     class='form-control ' /> 
										 </div> 
										 <div class="col-md-1">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="Pro Rem Var" class=" control-label col-md-4 text-left"> Pro Rem Var </label>
										<div class="col-md-7">
										  <input  type='text' name='pro_rem_var' id='pro_rem_var' value='{{ $row['pro_rem_var'] }}' 
						     class='form-control ' /> 
										 </div> 
										 <div class="col-md-1">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="Total Rem Com" class=" control-label col-md-4 text-left"> Total Rem Com </label>
										<div class="col-md-7">
										  <input  type='text' name='total_rem_com' id='total_rem_com' value='{{ $row['total_rem_com'] }}' 
						     class='form-control ' /> 
										 </div> 
										 <div class="col-md-1">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="Ts Meses" class=" control-label col-md-4 text-left"> Ts Meses </label>
										<div class="col-md-7">
										  <input  type='text' name='ts_meses' id='ts_meses' value='{{ $row['ts_meses'] }}' 
						     class='form-control ' /> 
										 </div> 
										 <div class="col-md-1">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="Ts Dias" class=" control-label col-md-4 text-left"> Ts Dias </label>
										<div class="col-md-7">
										  <input  type='text' name='ts_dias' id='ts_dias' value='{{ $row['ts_dias'] }}' 
						     class='form-control ' /> 
										 </div> 
										 <div class="col-md-1">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="Faltas" class=" control-label col-md-4 text-left"> Faltas </label>
										<div class="col-md-7">
										  <input  type='text' name='faltas' id='faltas' value='{{ $row['faltas'] }}' 
						     class='form-control ' /> 
										 </div> 
										 <div class="col-md-1">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="Tc Meses" class=" control-label col-md-4 text-left"> Tc Meses </label>
										<div class="col-md-7">
										  <input  type='text' name='tc_meses' id='tc_meses' value='{{ $row['tc_meses'] }}' 
						     class='form-control ' /> 
										 </div> 
										 <div class="col-md-1">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="Tc Dias" class=" control-label col-md-4 text-left"> Tc Dias </label>
										<div class="col-md-7">
										  <input  type='text' name='tc_dias' id='tc_dias' value='{{ $row['tc_dias'] }}' 
						     class='form-control ' /> 
										 </div> 
										 <div class="col-md-1">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="Grati 30334" class=" control-label col-md-4 text-left"> Grati 30334 </label>
										<div class="col-md-7">
										  <input  type='text' name='grati_30334' id='grati_30334' value='{{ $row['grati_30334'] }}' 
						     class='form-control ' /> 
										 </div> 
										 <div class="col-md-1">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="Boni 30334" class=" control-label col-md-4 text-left"> Boni 30334 </label>
										<div class="col-md-7">
										  <input  type='text' name='boni_30334' id='boni_30334' value='{{ $row['boni_30334'] }}' 
						     class='form-control ' /> 
										 </div> 
										 <div class="col-md-1">
										 	
										 </div>
									  </div> 					
									  <div class="form-group  " >
										<label for="Total Grati" class=" control-label col-md-4 text-left"> Total Grati </label>
										<div class="col-md-7">
										  <input  type='text' name='total_grati' id='total_grati' value='{{ $row['total_grati'] }}' 
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
				  </div>	  
			
		</div> 
		 
		 {!! Form::close() !!}
		 
   <script type="text/javascript">
	$(document).ready(function() { 
		
		 

		$('.removeCurrentFiles').on('click',function(){
			var removeUrl = $(this).attr('href');
			$.get(removeUrl,function(response){});
			$(this).parent('div').empty();	
			return false;
		});		
		
	});
	</script>		 
