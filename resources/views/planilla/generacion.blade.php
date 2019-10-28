@extends('layouts.app')

@section('content')
<div class="page-content row">
    <!-- Page header -->

	 
	 
 	<div class="page-content-wrapper m-t">   

<div class="sbox ">
	<div class="sbox-title">
			



	</div>
	<div class="sbox-content" > 	

		
		
		<section class="ribon-sximo"> 
	
	 <div style="text-align: center;" class="sbox-content"> 
    @if (Session::has('message'))
	            <div class="alert alert-success">{{ Session::get('message') }}</div>
    @endif 
	{!! Form::open(array('url'=>'calculo_planilla', 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}
	  Calcular Pago Incentivo + Bono? <input  type='checkbox' value='si' name='pagoBonoIncen' id='pagoBonoIncen' class='form-control' />  
	  <button type="submit" class="btn btn-primary" > Calcular Planilla</button>
	 {!! Form::close() !!}
	 </div>
</section>  

	 
	
	</div>
</div>	

	</div>
</div>
	  
@stop