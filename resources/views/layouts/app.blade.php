<?php $sximoconfig  = config('sximo');?>
<!DOCTYPE html>
<!--
   This is a starter template page. Use this page to start your new project from
   scratch. This page gets rid of all links and provides the needed markup only.
   -->
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<!-- Tell the browser to be responsive to screen width -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content=""/>
<meta name="author" content="">
<meta name="keywords" content="">
<title> {{ CNF_APPNAME }} </title>
<!-- Favicon icon -->
<link rel="shortcut icon" href="{{ asset('favicon.ico')}}" type="image/x-icon">	
 <!-- Bootstrap Core CSS -->
 <link href="{{ asset('')}}assets/template/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

 
<!--<link href="{{ asset('sximo/css/sximo.css')}}" rel="stylesheet">
<!--
		<link href="{{ asset('sximo/fonts/awesome/css/font-awesome.min.css')}}" rel="stylesheet">
		<link href="{{ asset('sximo/js/plugins/bootstrap.summernote/summernote.css')}}" rel="stylesheet">
		<link href="{{ asset('sximo/js/plugins/datepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet">
		<link href="{{ asset('sximo/js/plugins/bootstrap.datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet">
		<link href="{{ asset('sximo/js/plugins/select2/select2.css')}}" rel="stylesheet">
		<link href="{{ asset('sximo/js/plugins/iCheck/skins/square/red.css')}}" rel="stylesheet">
		<link href="{{ asset('sximo/js/plugins/fancybox/jquery.fancybox.css') }}" rel="stylesheet">
		<link href="{{ asset('sximo/js/plugins/markitup/skins/simple/style.css') }}" rel="stylesheet">
		<link href="{{ asset('sximo/js/plugins/markitup/sets/default/style.css') }}" rel="stylesheet">			
		<link href="{{ asset('sximo/css/animate.css')}}" rel="stylesheet">		
		<link href="{{ asset('sximo/css/icons.min.css')}}" rel="stylesheet">
		<link href="{{ asset('sximo/js/plugins/toastr/toastr.css')}}" rel="stylesheet">
		<link href="{{ asset('sximo/css/sximo.css')}}" rel="stylesheet">
		<script type="text/javascript" src="{{ asset('sximo/js/plugins/jquery-1.12.3.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('sximo/js/plugins/jquery.cookie.js') }}"></script>			
		<script type="text/javascript" src="{{ asset('sximo/js/plugins/jquery-ui.min.js') }}"></script>				
		<script type="text/javascript" src="{{ asset('sximo/js/plugins/iCheck/icheck.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('sximo/js/plugins/fancybox/jquery.fancybox.js') }}"></script>
		<script type="text/javascript" src="{{ asset('sximo/js/plugins/prettify.js') }}"></script>
		<script type="text/javascript" src="{{ asset('sximo/js/plugins/parsley.js') }}"></script>
		<script type="text/javascript" src="{{ asset('sximo/js/plugins/switch.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('sximo/js/plugins/bootstrap/js/bootstrap.js') }}"></script>
		<script type="text/javascript" src="{{ asset('sximo/js/plugins/jasny-bootstrap/js/jasny-bootstrap.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('sximo/js/sximo.js') }}"></script>
		<script type="text/javascript" src="{{ asset('sximo/js/plugins/jquery.form.js') }}"></script>
		<script type="text/javascript" src="{{ asset('sximo/js/plugins/jquery.jCombo.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('sximo/js/plugins/toastr/toastr.js') }}"></script>
		<script type="text/javascript" src="{{ asset('sximo/js/plugins/bootstrap.summernote/summernote.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('sximo/js/simpleclone.js') }}"></script>
		<script type="text/javascript" src="{{ asset('sximo/js/plugins/markitup/jquery.markitup.js') }}"></script>	
		<script type="text/javascript" src="{{ asset('sximo/js/plugins/markitup/sets/default/set.js') }}"></script>
        <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
        <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
 -->
 
 
 <!-- This is Sidebar menu CSS -->
    <link href="{{ asset('')}}assets/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
    <!-- This is a Animation CSS -->
    <link href="{{ asset('')}}assets/template/css/animate.css" rel="stylesheet">
    <!-- toast CSS -->
    <link href="{{ asset('')}}assets/plugins/bower_components/toast-master/css/jquery.toast.css" rel="stylesheet">    
    <!-- summernotes CSS -->
    <link href="{{ asset('assets')}}/plugins/bower_components/summernote/dist/summernote.css" rel="stylesheet" />    
    <!-- This is a Custom CSS -->
    <link href="{{ asset('')}}assets/template/css/style.css" rel="stylesheet">
    <!-- Popup CSS -->
    <link href="{{ asset('')}}assets/plugins/bower_components/Magnific-Popup-master/dist/magnific-popup.css" rel="stylesheet">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('')}}assets/plugins/bower_components/iCheck/skins/square/green.css">
    <link rel="stylesheet" href="{{ asset('')}}assets/plugins/bower_components/iCheck/skins/minimal/green.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('')}}assets/plugins/bower_components/select2/select2.css">    
    <!-- Legacy  Custom CSS for old sximo layout -->
    <link href="{{ asset('')}}assets/template/css/legacy.css" rel="stylesheet">    
    <!-- color CSS you can use different color css from css/colors folder -->
    <!-- We have chosen the skin-blue (default.css) for this starter
         page. However, you can choose any other skin from folder css / colors .
         -->
    <link href="{{ asset('')}}assets/template/css/colors/blue-dark.css" id="theme" rel="stylesheet">
    @if(session('themes') !='')
    <link href="{{ asset('')}}assets/template/css/colors/{{ session('themes')}}.css" id="theme" rel="stylesheet">
    @endif    
    <!-- Date Picker -->
    <link href="{{ asset('assets/plugins/bower_components/bootstrap.datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/bower_components/datepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet">
    <!-- jQuery -->
    <script src="{{ asset('')}}assets/plugins/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>    
    <!-- Bootstrap Core JavaScript -->
    <script src="{{ asset('')}}assets/template/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- Sidebar menu plugin JavaScript -->
    <script src="{{ asset('')}}assets/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>
    <!--Slimscroll JavaScript For custom scroll-->
    <script src="{{ asset('')}}assets/template/js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="{{ asset('')}}assets/template/js/waves.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="{{ asset('')}}assets/template/js/custom.js"></script>
    <!-- Custom Theme JavaScript -->
    
    <!-- datepicker -->
    <script type="text/javascript" src="{{ asset('assets/plugins/bower_components/datepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/plugins/bower_components/bootstrap.datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>

    <script src="{{ asset('')}}assets/plugins/bower_components/toast-master/js/jquery.toast.js"></script>
    <script src="{{ asset('')}}assets/template/js/toastr.js"></script>    
    <script type="text/javascript" src="{{ asset('assets/plugins/bower_components/parsley.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/plugins/bower_components/jquery.form.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/plugins/bower_components/jquery.jCombo.min.js') }}"></script>
    <script src="{{ asset('')}}assets/plugins/bower_components/Magnific-Popup-master/dist/jquery.magnific-popup.min.js"></script>
    <script src="{{ asset('')}}assets/plugins/bower_components/Magnific-Popup-master/dist/jquery.magnific-popup-init.js"></script> <script src="{{ asset('assets')}}/plugins/bower_components/summernote/dist/summernote.min.js"></script>
    <script src="{{ asset('assets')}}/plugins/bower_components/select2/select2.min.js"></script>
    <script src="{{ asset('assets')}}/plugins/bower_components/iCheck/icheck.min.js"></script>
    <script type="text/javascript" src="{{  asset('assets/plugins/bower_components/simpleclone.js') }}"></script>
    <script src="{{ asset('')}}assets/template/js/sximo5.js"></script>   

  
   
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
		
</head>

  	<body class="fix-header" >

	<!-- Preloader -->
	<!--
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>
        </svg>
    </div>
	-->
	
    <div id="wrapper">
      @include('layouts/headmenu')
      @include('layouts/sidemenu')

        <!-- Page Content -->
        <div id="page-wrapper">
          <div class="ajaxLoading"></div>
            @yield('content') 


        </div> 
		<footer class="footer text-center"><strong>Copyright</strong> &copy; {{ date('Y')}} .</footer>	
        <!-- ============================================================== -->
        <!-- Right sidebar -->
        <!-- ============================================================== -->
        <!-- .right-sidebar -->
        <div class="right-sidebar">
            <div class="slimscrollright">
                <div class="rpanel-title"> Temas <span><i class="ti-close theme-toggle"></i></span> </div>
                <div class="r-panel-body">
                <ul id="themecolors" class="m-t-20">
                    <li><b>Estilos Claros</b></li>
                    <li><a href="{{ url('home/skin/default') }}" data-theme="default" class="default-theme working">1</a></li>
                    <li><a href="{{ url('home/skin/green') }}" data-theme="green" class="green-theme">2</a></li>
                    <li><a href="{{ url('home/skin/gray') }}" data-theme="gray" class="yellow-theme">3</a></li>
                    <li><a href="{{ url('home/skin/blue') }}" data-theme="blue" class="blue-theme">4</a></li>
                    <li><a href="{{ url('home/skin/purple') }}" data-theme="purple" class="purple-theme">5</a></li>
                    <li><a href="{{ url('home/skin/megna') }}" data-theme="megna" class="megna-theme">6</a></li>
                    <li><b>Estilos Oscuros</b></li>
                    <br/>
                    <li><a href="{{ url('home/skin/default-dark') }}" data-theme="default-dark" class="default-dark-theme">7</a></li>
                    <li><a href="{{ url('home/skin/green-dark') }}" data-theme="green-dark" class="green-dark-theme">8</a></li>
                    <li><a href="{{ url('home/skin/gray-dark') }}" data-theme="gray-dark" class="yellow-dark-theme">9</a></li>
                    <li><a href="{{ url('home/skin/blue-dark') }}" data-theme="blue-dark" class="blue-dark-theme">10</a></li>
                    <li><a href="{{ url('home/skin/purple-dark') }}" data-theme="purple-dark" class="purple-dark-theme">11</a></li>
                    <li><a href="{{ url('home/skin/megna-dark') }}" data-theme="megna-dark" class="megna-dark-theme">12</a></li>
                </ul>
                   
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Right sidebar -->
        <!-- ============================================================== -->
        
    </div>
    <!-- /#wrapper -->
<div class="modal fade" id="sximo-modal" tabindex="-1" role="dialog">
<div class="modal-dialog">
  <div class="modal-content">
	<div class="modal-header bg-default">
		
		<button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4 class="modal-title">Modal title</h4>
	</div>
	<div class="modal-body" id="sximo-modal-content">

	</div>

  </div>
</div>
</div>


		<script language="javascript">
		jQuery(document).ready(function($)	{
		   $('.markItUp').markItUp(mySettings );
		});
		</script>


		<!-- /#wrapper -->
{{ Sitehelpers::showNotification() }} 
<script type="text/javascript">
jQuery(document).ready(function ($) {
  
  setInterval(function(){ 
   // var noteurl = $('.notif-value').attr('code'); 
    $.get('{{ url("notification/load") }}',function(data){
      $('.notif-alert').html(data.total);
      var html = '';
      $.each( data.note, function( key, val ) {     
        html += '<li><div class="message-center"><a href="'+val.url+'"><div class="user-img">'+val.image+'</div><div class="mail-contnet"><h5>'+val.title+'</h5> <span class="mail-desc">'+val.text+'</span> <span class="time">'+val.date+'</span> </div></a></div></li>' ;
      });
      $('.notification-menu').html(html);
      if(data.total >=1) {
        $('.notify').show('');
      }
    });
  }, 60000); 
    
}); 
; 
	
	
</script>

</body> 
</html>