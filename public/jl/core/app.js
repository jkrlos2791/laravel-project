$(document).ready(function(){
	$(".empleado-select").select2({
		dropdownParent: $("#modalSearchEmpleado"),
		width: '600px'
    });
    $(".empresa-select").select2({
		dropdownParent: $("#modalSearchEmpresa"),
		width: '600px'
    });
    $(".inicio-empresa-select").select2({
		dropdownParent: $("#modalIngresoEmpresa"),
		width: '600px'
    });
    $(".inicio-periodo-select").select2({
		dropdownParent: $("#modalIngresoEmpresa"),
		width: '600px'
    });
	$("#buscarEmpleado").click(function(){buscarEmpleado();});
	$("#verEmpleado").click(function(){verEmpleado();});
	$("#nuevoEmpleado").click(function(){nuevoEmpleado();});
	$("#buscarEmpresa").click(function(){buscarEmpresa();});
	$("#verEmpresa").click(function(){verEmpresa();});
	$("#nuevoEmpresa").click(function(){nuevoEmpresa();});
	$("#calcularPlanilla").click(function(){calcularPlanilla();});
	$("#calcularPlanilla2").click(function(){calcularPlanilla2();});
	$("#entrarEmpresa").click(function(){entrarEmpresa();});
	$("#ingresarEmpresa").click(function(){ingresarEmpresa();});
});

function buscarEmpleado(){
	$.ajax({
        type: "get",
        url: "./comboEmpleados",
        success: function (data) {
			$('#empleado').find('option').remove().end();
            var selectList = document.getElementById("empleado");
            var option = document.createElement('option');
		    option.value = "";
		    option.text = "Seleccione...";
		    selectList.appendChild(option);
            for (var i = 0; i < data.length; i++) {
                option = document.createElement("option");
                option.value = data[i].id_trabajador;
                option.text = data[i].ape_paterno+" "+data[i].ape_materno+", "+data[i].nombres;
                selectList.appendChild(option);
            }    
        },
        error: function(error){
        }
    });
    $("#modalSearchEmpleado").modal('show');
}

function verEmpleado(){
	if($("#empleado").val()!=""){
		var data = $("#formSearchEmpleado").serialize();
		$.ajax({
			type: "post",
			url: "./capturarIdEmpleado",
			data: data,
			success: function (data) {
				if(data==$("#empleado").val()){
					document.location.href = "http://planilla.asecoint.com.pe/dato";
					$("#cerrar").click();
				}
				else{
					swal("No se pudo buscar!", "Hubo un error...", "error");
				}
			},
			error: function(error){
				swal("No se pudo buscar!", "Hubo un error...", "error");
			}
		});
    }
	else{
		swal("No se pudo buscar!", "Debes seleccionar un empleado...", "error");
	}
}

function nuevoEmpleado(){
		$.ajax({
			type: "post",
			url: "./capturarIdEmpleado",
			success: function (data) {
					document.location.href = "http://planilla.asecoint.com.pe/dato";
			},
			error: function(error){
				swal("No se puede crear!", "Hubo un error...", "error");
			}
		});
}

function buscarEmpresa(){
	$.ajax({
        type: "get",
        url: "./comboEmpresas",
        success: function (data) {
			$('#empresa').find('option').remove().end();
            var selectList = document.getElementById("empresa");
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
    $("#modalSearchEmpresa").modal('show');
}

function verEmpresa(){
	if($("#empresa").val()!=""){
		var data = $("#formSearchEmpresa").serialize();
		$.ajax({
			type: "post",
			url: "./capturarIdEmpresa",
			data: data,
			success: function (data) {
				if(data==$("#empresa").val()){
					document.location.href = "http://planilla.asecoint.com.pe/empresa";
					$("#cerrar").click();
				}
				else{
					swal("No se pudo buscar!", "Hubo un error...", "error");
				}
			},
			error: function(error){
				swal("No se pudo buscar!", "Hubo un error...", "error");
			}
		});
    }
	else{
		swal("No se pudo buscar!", "Debes seleccionar una empresa.", "warning");
	}
}

function nuevoEmpresa(){
		$.ajax({
			type: "post",
			url: "./capturarIdEmpresa",
			success: function (data) {
					document.location.href = "http://planilla.asecoint.com.pe/empresa";
			},
			error: function(error){
				swal("No se puede crear!", "Hubo un error...", "error");
			}
		});
}

function calcularPlanilla(){
    $("#modalCalculoPlanilla").modal('show');
}

function calcularPlanilla2(){
	var data = $("#formCalculoPlanilla").serialize();
	$.ajax({
		type: "post",
		url: "./calculo_planilla",
		data: data,
		success: function (data) {
			if(data=="OK"){
			    
            	$.ajax({
                    type: "get",
                    url: "./calculo_liquidacion",
                    success: function (data) {
                        if(data=="OK"){
                            $("#cerrar").click();
                            swal("Se calculo la planilla correctamente", "", "success");
            				document.location.href = "http://planilla.asecoint.com.pe/planillageneracion";    
                        } 
                        else{
                            swal("No se pudo calcular la liquidacion!", "Hubo un error...", "error");           
                        }
                    },
                    error: function(error){
                        swal("No se pudo calcular la liquidacion!", "Hubo un error...", "error");       
                    }
                });
			    
			    
			}
			else{
				swal("No se pudo calcular la planilla!", "Hubo un error...", "error");
			}
		},
		error: function(error){
			swal("No se pudo calcular la planilla!", "Hubo un error...", "error");
		}
	});
}

function limpiarBD(){
	$.ajax({
        type: "get",
        url: "./limpiarBD",
        success: function (data) {
            console.log("se limpio correctamente");
        },
        error: function(error){
            console.log("error al limpiar");
        }
    });
}

function entrarEmpresa(){
	$.ajax({
        type: "get",
        url: "./comboEmpresas",
        success: function (data) {
			$('#inicioEmpresa').find('option').remove().end();
			$('#inicioPeriodo').find('option').remove().end();
            var selectList = document.getElementById("inicioEmpresa");
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
    $("#modalIngresoEmpresa").modal('show');
}

function cargarComboPeriodos(){
    if($('#inicioEmpresa').val()!=""){
    	$.ajax({
            type: "post",
            url: "./comboPeriodos",
            data: {idEmpresa: $('#inicioEmpresa').val()},
            success: function (data) {
    			$('#inicioPeriodo').find('option').remove().end();
                var selectList = document.getElementById("inicioPeriodo");
                var option = document.createElement('option'); 
    		    option.value = "";
    		    option.text = "Seleccione...";
    		    selectList.appendChild(option);
                for (var i = 0; i < data.length; i++) {
                    option = document.createElement("option");
                    option.value = data[i].periodo_id;
                    option.text = data[i].mes+" "+data[i].anio;
                    selectList.appendChild(option);
                }    
            },
            error: function(error){
            }
        });    
    }
    else{
                   
    }
}

function ingresarEmpresa(){
    if($('#inicioEmpresa').val()!=""){
    	$.ajax({
            type: "post",
            url: "./ingresarEmpresa",
            data: {idEmpresa: $('#inicioEmpresa').val(), idPeriodo: $('#inicioPeriodo').val()},
            success: function (data) {
       			if(data!=null && data!=""){
            	    document.location.href = "http://planilla.asecoint.com.pe";
    			}
    			else{
    				swal("No se ingreso!", "Hubo un error...", "error");
    			}
            },
            error: function(error){
            }
        });    
    }
    else{
        swal("No se pudo ingresar!", "Debes seleccionar una empresa.", "warning");               
    }
}