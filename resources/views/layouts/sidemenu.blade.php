<?php $sidebar = SiteHelpers::menus('sidebar') ;
$MenuActive =  (Request::segment(1) !='' ? Request::segment(1) : 'no');
?>
	<!-- Left navbar-header -->
    <div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav slimscrollsidebar">
		<div class="sidebar-head">
		<h3><span class="fa-fw open-close"><i class="ti-menu hidden-xs"></i><i class="ti-close visible-xs"></i></span> <span class="hide-menu">Navegación</span></h3> </div>
		<ul class="nav" id="side-menu">
		@foreach ($sidebar as $menu)
			

			 <li @if(Request::segment(1) == $menu['module']) class="active" @endif>

			@if($menu['module'] =='separator')
			<li class="divider"> 
			{{$menu['menu_name']}}
			</li>
				
			@else
				<li class=" ">
			 	<a 
					@if($menu['menu_type'] =='external')
						href="{{ $menu['url'] }}" 
					@else
						href="{{ URL::to($menu['module'])}}" 
					@endif	
                    
					class="waves-effect"					
			 	
				 @if(count($menu['childs']) > 0 ) class="expand level-closed" @endif>
				 	<i class="{{$menu['menu_icons']}}"></i> 
					<span class="hide-menu">
					
					@if(CNF_MULTILANG ==1 && isset($menu['menu_lang']['title'][Session::get('lang')]))
						{{ $menu['menu_lang']['title'][Session::get('lang')] }}
					@else
						{{$menu['menu_name']}}
					@endif	

                    @if(count($menu['childs']) > 0 )
                    <span class="fa arrow"></span>
                    @endif					
					
					</span> 
				</a> 				
				@endif	
				 <!--- LEVEL II -->
				@if(count($menu['childs']) > 0)
					<ul class="nav nav-second-level">
						@foreach ($menu['childs'] as $menu2)
						 <li @if(Request::segment(1) == $menu2['module']) class="active" @endif>
						 	<a 
								@if($menu2['menu_type'] =='external')
									href="{{ $menu2['url']}}" 
								@else
									href="{{ URL::to($menu2['module'])}}"  
								@endif	

                             class="waves-effect" 
								
							>
							
							<i class="{{$menu2['menu_icons']}}"></i>
							<span class="hide-menu">
							@if(CNF_MULTILANG ==1 && isset($menu2['menu_lang']['title'][Session::get('lang')]))
								{{ $menu2['menu_lang']['title'][Session::get('lang')] }}
							@else
								{{$menu2['menu_name']}}
							@endif	
							
							@if(count($menu2['childs']) > 0 )
                            <span class="fa arrow"></span>
                            @endif
							</span>
							</a> 
							 <!-- LEVEL III -->
							@if(count($menu2['childs']) > 0)
							<ul class="nav nav-third-level">
								@foreach($menu2['childs'] as $menu3)
									<li @if(Request::segment(1) == $menu3['module']) class="active" @endif>
										<a 
											@if($menu['menu_type'] =='external')
												href="{{ $menu3['url'] }}" 
											@else
												href="{{ URL::to($menu3['module'])}}" 
											@endif										
										class="waves-effect"
										>
										<i class="menu-icon fa fa-caret-right"></i>
										<i class="{{$menu3['menu_icons']}}"></i> 
										<span class="hide-menu">
										@if(CNF_MULTILANG ==1 && isset($menu3['menu_lang']['title'][Session::get('lang')]))
											{{ $menu3['menu_lang']['title'][Session::get('lang')] }}
										@else
											{{$menu3['menu_name']}}
										@endif	

                                        @if(count($menu3['childs']) > 0 )
                                        <span class="fa arrow"></span>
                                        @endif										
										</span>	
										</a>
									</li>	
								@endforeach
							</ul>
							@endif	
                          <!-- END LEVEL III -->							
						</li>							
						@endforeach
					</ul>
					</li>
				@endif
				<!-- END LEVEL II -->
			</li>
		@endforeach
      </ul>
	</div>
</div>	  
<!-- Left navbar-header end -->	  
