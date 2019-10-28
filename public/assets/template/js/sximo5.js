/* Sximo builder 
	copyright 2014 . sximo builder com 
*/

jQuery(document).ready(function($){

	$('.sidebar-menu li ul li.active').parents('li').addClass('active');
	$('.clearCache').click(function(){
		  $('.pageLoading').show();
		  var url = $(this).attr('href');
		  $.get( url  , function( data ) {
		     $('.pageLoading').hide();
		     notyMessage(data.message); 
		         
		  });
		  return false;
		}); 

	
	$('.tips').tooltip();	

	$('.date').datepicker({format:'yyyy-mm-dd',autoClose:true})
	$('.datetime').datetimepicker({format: 'yyyy-mm-dd hh:ii:ss',autoClose:true}); 
	/* Tooltip */
	$('.editor').summernote();
	 $('.previewImage').magnificPopup({type:'image'});	
	$(".select2").select2({ width:"100%"});	

	$('.popup').click(function (e) {
		e.stopPropagation();
	});	
     window.prettyPrint && prettyPrint();

	$(".checkall").click(function() {
		var cblist = $(".ids");
		if($(this).is(":checked"))
		{				
			cblist.prop("checked", !cblist.is(":checked"));
		} else {	
			cblist.removeAttr("checked");
		}	
	});
	
	// Upload Image Preview 
	$(".inputfile").change(function () { uploadPreview(this); });



//Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_square-green',
      radioClass: 'iradio_square-green'
    }); 

	$('.removeCurrentFiles').on('click',function(){
		var removeUrl = $(this).attr('href');
		$.get(removeUrl,function(response){
			if(response.status == 'success')
			{
				
			}
		});
		$(this).parent('div').empty();	
		return false;
	});	
    	
})

function addMoreFiles(id){

   $("."+id+"Upl").append('<input type="file" name="'+id+'[]" />')
}

function SximoConfirmDelete( url )
{
	if(confirm('Are u sure deleting this record ? '))
	{
		window.location.href = url;	
	}
	return false;
}
function SximoDelete(  )
{	
	var total = $('input[class="ids"]:checkbox:checked').length;
	if(confirm('are u sure removing selected rows ?'))
	{
			$('#SximoTable').submit();// do the rest here	
	}	
}	

var newwindow;
function ajaxPopupStatic(url ,w , h)
{
	var w = (w == '' ? w : 800 );	
	var h = (h == '' ? wh: 600 );	
	newwindow=window.open(url,'name','height='+w+',width='+h+',resizable=yes,toolbar=no,scrollbars=yes,location=no');
	if (window.focus) {newwindow.focus()}
}

function SximoModal( url , title)
{
	$('#sximo-modal-content').html(' ....Loading content , please wait ...');
	$('.modal-title').html(title);
	$('#sximo-modal-content').load(url,function(){
	});
	$('#sximo-modal').modal('show');	
}

function notyMessage(message)
{

	$.toast({
	    heading: 'Success',
	    text: message,
	    position: 'top-right',

	    icon: 'success',
	    hideAfter: 3000,
	    stack: 6
	});
	
}
function notyMessageError(message)
{

	$.toast({
	    heading: 'Error',
	    text: message,
	    position: 'top-right',

	    icon: 'error',
	    hideAfter: 3000,
	    stack: 6
	});
	
}

function requestFullScreen() {

  var el = document.body;

  // Supports most browsers and their versions.
  var requestMethod = el.requestFullScreen || el.webkitRequestFullScreen 
  || el.mozRequestFullScreen || el.msRequestFullScreen;

  if (requestMethod) {

    // Native full screen.
    requestMethod.call(el);

  } else if (typeof window.ActiveXObject !== "undefined") {

    // Older IE.
    var wscript = new ActiveXObject("WScript.Shell");

    if (wscript !== null) {
      wscript.SendKeys("{F11}");
    }
  }
}


function uploadPreview(input ) {
		//alert(input.files[0].size +' : '+ input.files[0].name +' : '+ input.files[0].type);

		var id = $(input).attr('id'); 
		target = '.'+id+'_preview';
		var sizeInMB = (input.files[0].size / 1024).toFixed(2);

		var Type = input.files[0].type;
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $(target).html('<div class="upload-box-img-preview"><img class="upload-image-preview" src="'+e.target.result+'" alt="your image" width="150" /><br /> <b> Size: </b> '+ sizeInMB+' Kb <br /> <b>  Type: </b> '+ Type+'</div>');
        }
        reader.readAsDataURL(input.files[0]);
    }
}
