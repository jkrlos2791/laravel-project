$(document).ready(function(){
    cargarComboEmpresa();
    if($("#hiddenEmpresa").val()!=null && $("#hiddenEmpresa").val()!=""){
        $("#sectorIngresarEmpresa").css("display","none");    
    }
	//$("#ingresarEmpresa").click(function(){ingresarEmpresa();});
	$("#sectorIngresarEmpresa").css("display","none");
});

function cargarComboEmpresa(){
	$.ajax({
        type: "get",
        url: "./comboEmpresas",
        success: function (data) {
            var selectList = document.getElementById("empresaIngresar");
            var option = document.createElement('option'); 
		    option.value = "";
		    option.text = "Seleccione...";
		    selectList.appendChild(option);
            for (var i = 0; i < data.length; i++) {
                option = document.createElement("option");
                option.value = data[i].empresa_id;
                option.text = data[i].razon_social;
                selectList.appendChild(option);
            }    
        },
        error: function(error){
        }
    });
}

/*
function ingresarEmpresa(){
    if(validarIngresarEmpresa()){
        $.ajax({
		type: "post",
		url: "./ingresarEmpresa",
		data: {idEmpresa: $("#empresaIngresar").val()},
		success: function (data) {
			if(data!=null && data!=""){
        	    document.location.href = "http://planilla.asecoint.com.pe";
			}
			else{
				swal("No se ingreso!", "Hubo un error...", "error");
			}
		},
		error: function(error){
			swal("No se ingreso!", "Hubo un error...", "error");
		}
	    });    
    }
    else{
        swal("No se pudo buscar!", msg.toString(), "warning");
    }
}
*/

var msg=[];
function validarIngresarEmpresa(){
	var flag=true;
	msg=[];	
	if($("#empresaIngresar").val()==""){
		flag=false;
		msg.push("Debes seleccionar una empresa.");
	}	
	return flag;    
}