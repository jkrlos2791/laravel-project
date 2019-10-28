@extends('layouts.app')

@section('content')

    <div class="container-fluid">

	        <div class="row bg-title">
            <!-- .page title -->
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">{{ $pageTitle }}</h4> </div>
            <!-- /.page title -->
			 <!-- .breadcrumb -->
			 
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12"> 
			    <div class="box-header-tools pull-right" >
	  <a href="{{ url('dashboard?return='.$return) }}" class="tips btn btn-xs btn-warning btn-sm btn-circle"><i class="fa  fa-arrow-left"></i></a>
	</div>
            </div>
            <!-- /.breadcrumb -->
        </div>

<!-- .row -->
        <div class="row">		
		<div class="white-box"> 
	<div class="row row-in"  >

						<div class="col-lg-4 col-sm-6 row-in-br">
			 <ul class="col-in">
                                <li>
                                    <a href="{{ URL::to('centrocosto') }}">
                                        <span class="circle circle-md bg-danger"><i class="ti-plus"></i></span>
                                    </a>    
                                </li>
                                <li >
                                    <h4>Centro de Costos</h4>
                                    <p> Administración del centro de costos</p>
                                    
                                </li>
                            </ul>
		</div>		
		<div class="col-lg-4 col-sm-6 row-in-br">
			 <ul class="col-in">
                                <li>
                                    <a href="{{ URL::to('afp') }}">
                                        <span class="circle circle-md bg-danger"><i class="ti-plus"></i></span>
                                    </a>    
                                </li>
                                <li >
                                    <h4>AFP</h4>
                                    <p> Administración del AFP</p>
                                    
                                </li>
                            </ul>
		</div>
	</div>

</div>  
</div>
	 
</div>
@stop