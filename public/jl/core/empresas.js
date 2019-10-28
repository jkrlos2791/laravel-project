$(document).ready(function(){	
	cargarCombos();
	mostrarData();
	cargarPeriodos();
	cargarCentroCostos();
	crearDataTable("periodos",null,columnasPeriodos()); 
	crearDataTable("centroCostos",null,columnasCentroCostos()); 
	$("#ingresarEmpresa").click(function(){ingresarEmpresa();});
    $("#guardarEmpresa").click(function(){guardar();});
	$("#nuevoPeriodo").click(function(){nuevoPeriodo();});
	$("#guardarPeriodo").click(function(){guardarPeriodo();});
	$("#eliminarPeriodo").click(function(){eliminarPeriodo();});	
	$("#nuevoCentroCosto").click(function(){nuevoCentroCosto();});
	$("#editarCentroCosto").click(function(){editarCentroCosto();});
	$("#guardarCentroCosto").click(function(){guardarCentroCosto();});
	$("#eliminarCentroCosto").click(function(){eliminarCentroCosto();});
    Dropzone.options.DropZoneFiddle = {
        url: "./cargarLogo",
        paramName: "file",
        clickable: true,
        maxFilesize: 1, 
        uploadMultiple: false, 
        maxFiles: 1, 
        addRemoveLinks: true,
        acceptedFiles: '.png,.jpg', 
        dictDefaultMessage: "Upload your files here",
        init: function() {
            this.on("sending", function(file, xhr, formData) {
            });
            this.on("success", function(file, responseText) {
                alert('done');
            });
            this.on("addedfile", function(file){
                alert('hi');
            });
        }
    };
});

function cargarCombos(){
    $.ajax({
        type: "get",
        url: "./comboSectores",
        success: function (data) {
            var selectList = document.getElementById("sector");
            var option = document.createElement('option');
		    option.value = 0;
		    option.text = "Seleccione...";
		    selectList.appendChild(option);
            for (var i = 0; i < data.length; i++) {
                option = document.createElement("option");
                option.value = data[i].sector_id;
                option.text = data[i].nombre;
                selectList.appendChild(option);
            }    
        },
        error: function(error){
        }
    });
	$.ajax({
        type: "get",
        url: "./comboDocumentos",
        success: function (data) {
            var selectList = document.getElementById("tipoDoc");
            var option = document.createElement('option');
		    option.value = "";
		    option.text = "Seleccione...";
		    selectList.appendChild(option);
            for (var i = 0; i < data.length; i++) {
                option = document.createElement("option");
                option.value = data[i].tipo_documento_id;
                option.text = data[i].descripcion;
                selectList.appendChild(option);
            }    
        },
        error: function(error){
        }
    });
    $.ajax({
        type: "get",
        url: "./comboMeses",
        success: function (data) {
            var selectList = document.getElementById("mes");
            var option = document.createElement('option');
		    option.value = "";
		    option.text = "Seleccione...";
		    selectList.appendChild(option);
            for (var i = 0; i < data.length; i++) {
                option = document.createElement("option");
                option.value = data[i].mes_id;
                option.text = data[i].mes;
                selectList.appendChild(option);
            }    
        },
        error: function(error){
        }
    });
	$.ajax({
        type: "get",
        url: "./comboAnios",
        success: function (data) {
            var selectList = document.getElementById("anio");
            var option = document.createElement('option');
		    option.value = "";
		    option.text = "Seleccione...";
		    selectList.appendChild(option);
            for (var i = 0; i < data.length; i++) {
                option = document.createElement("option");
                option.value = data[i].anio_id;
                option.text = data[i].anio;
                selectList.appendChild(option);
            }    
        },
        error: function(error){
        }
    });
}

function mostrarData(){
	$.ajax({
		type: "get",			
        url: "./obtenerEmpresa",
        success: function (data) {
			if(data!=""){
				$("#idEmpresa").val(data.empresa_id);
				$("#razonSocial").val(data.razon_social);
				$("#ruc").val(data.ruc);
				$("#sector").val(data.sector_id);
				$("#direccion").val(data.direccion);
				$("#telefono").val(data.telefono);
				$("#email").val(data.email);
				$("#representante").val(data.representante);
				$("#tipoDoc").val(data.tipo_documento_id);
				$("#nroDoc").val(data.num_documento);
			}
			else{
				bloquearBotones();
			}
        },
        error: function(error){
        }
    });
}

function cargarPeriodos(){
	$.ajax({
        type: "get",
        url: "./listarPeriodos",
        success: function (data) {
			if(data!=""){
				$('#periodos').DataTable().clear().draw();
				$('#periodos').DataTable().rows.add(data).draw();
			}
        },
        error: function(error){
        }
    });
}

function cargarCentroCostos(){
	$.ajax({
        type: "get",
        url: "./listarCentroCostos",
        success: function (data) {
			if(data!=""){
				$('#centroCostos').DataTable().clear().draw();
				$('#centroCostos').DataTable().rows.add(data).draw();
			}
        },
        error: function(error){
        }
    });
}

function crearDataTable(idTablaReal,data,columnas){
	var dt=$('#'+idTablaReal).DataTable({
	        language: {
                url: './jl/datatables/language/Spanish.json'
            },
	        data: data,
			pageLength: 8,
	     	responsive:false,
	     	fixedHeader: true,
	        columns:columnas,
			select: true,
//			order: [[ 1, "asc" ]],
	});
	try {
		new $.fn.dataTable.FixedHeader(dt, {
	        "alwaysCloneTop": true
		});
	} catch (e) {
	}
}

function columnasPeriodos(){
	var columnas=[ { data: null,defaultContent:'',className:'select-checkbox',orderable:false,"width":"2%"},
	               { title: "Periodo",data:"mes","width": "6%", "render": formatearPeriodo },
	               { title: "Accion",data:null,render: mostrarIngresarPeriodo,"width": "4%" },
			     ];
	return columnas;
}

function mostrarIngresarPeriodo(data, type, row ){
	var html="";
	html+="&nbsp;";
	html+="&nbsp;";
	html+="<a class='btn btn-success' href='javascript:void(0);' role='button' title='Ingresar' id='idButtonIngresarPeriodo'" +
			"onclick='ingresarPeriodo(\""+data.periodo_id+"\")'><i class='fas fa-sign-in-alt'></i></a>";
	return html;
}

function ingresarPeriodo(periodo_id){
	$.ajax({
		type: "post",
		url: "./ingresarPeriodo",
		data: {periodo_id: periodo_id},
		success: function (data) {
			if(data!=null && data!=""){
        	    document.location.href = "http://planilla.asecoint.com.pe/empresa";
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

function columnasCentroCostos(){
	var columnas=[ { data: null,defaultContent:'',className:'select-checkbox',orderable:false,"width":"2%"},
	               { title: "Descripcion",data:"centro_costo","width": "6%" },
			     ];
	return columnas;
}

function formatearPeriodo(data, type, row ){
	return data+" "+row.anio;	
}

/*
function ingresarEmpresa(){
	$.ajax({
		type: "post",
		url: "./ingresarEmpresa",
		data: {idEmpresa: $("#idEmpresa").val()},
		success: function (data) {
			if(data!=null && data!=""){
        	    document.location.href = "http://planilla.asecoint.com.pe/empresa";
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
*/

function guardar(){
	if(validar()){
		var data = $("#formEmpresa").serialize();
		$.ajax({
			type: "post",
			url: "./grabarEmpresa",
			data: data,
			success: function (data) {
				if(data!=null && data!=""){
    				$("#idEmpresa").val(data.empresa_id);
    				$("#razonSocial").val(data.razon_social);
    				$("#ruc").val(data.ruc);
    				$("#sector").val(data.sector_id);
    				$("#direccion").val(data.direccion);
    				$("#telefono").val(data.telefono);
    				$("#email").val(data.email);
    				$("#representante").val(data.representante);
    				$("#tipoDoc").val(data.tipo_documento_id);
    				$("#nroDoc").val(data.num_documento);
					desbloquearBotones();
					swal("Se guardo correctamente", "", "success");
				}
				else{
					swal("No se guardo!", "Hubo un error...", "error");
				}
			},
			error: function(error){
				swal("No se guardo!", "Hubo un error...", "error");
			}
		});  
	}
	else{
	    mostrarMensajeValidacion();
	}
}

function mostrarMensajeValidacion(){
    var list = document.createElement('ul');
    list.classList.add("list-group");
    for (var i = 0; i < msgEmpresa.length; i++) {
        var item = document.createElement('li');
        item.classList.add("list-group-item");
        item.appendChild(document.createTextNode(msgEmpresa[i]));
        list.appendChild(item);
    }
    swal({title:"Validar", content: list, icon: "warning"});
}

function desbloquearBotones(){
    document.getElementById("ingresarEmpresa").disabled = false;
	document.getElementById("nuevoPeriodo").disabled = false;
	document.getElementById("eliminarPeriodo").disabled = false;
	document.getElementById("nuevoCentroCosto").disabled = false;
	document.getElementById("eliminarCentroCosto").disabled = false;
}

var msgEmpresa=[];
function validar(){
	var flag=true;
	msgEmpresa=[];	
	if($("#razonSocial").val()=="" || $("#razonSocial").val().trim().length==0){
		flag=false;
		msgEmpresa.push("Ingresar Razon social");
	}	
	if($("#ruc").val()==""){
		flag=false;
		msgEmpresa.push("Ingresar RUC");
	}	
	if($("#representante").val()=="" || $("#representante").val().trim().length==0){
		flag=false;
		msgEmpresa.push("Ingresar Representante");
	}	
	if($("#tipoDoc").val()==""){
		flag=false;
		msgEmpresa.push("Ingresar Tipo de doc.");
	}	
	if($("#nroDoc").val()==""){
		flag=false;
		msgEmpresa.push("Ingresar Nro de doc.");
	}	
	return flag;
}

function nuevoPeriodo(){
    limpiarModales();
	$("#modalPeriodo").modal('show');
}

function limpiarModales(){
    $("#idPeriodo").val("");
	$("#mes").val("");
	$("#anio").val("");
	$("#idCentroCosto").val("");
	$("#centroCosto").val("");
}

function guardarPeriodo(){
	if(validarGuardarPeriodo()){
		var data = $("#formPeriodo").serialize();
		$.ajax({
			type: "post",
			url: "./grabarPeriodo",
			data: data,
			success: function (data) {
			    if(data=="PERIODO_EXISTE"){
					swal("Validar", "Ya existe ese periodo para esa empresa", "warning");
				}
				else if(data!=null && data!=""){					
					var periodo_id=data.periodo_id;
					$('#periodos').DataTable()
					.rows( function ( idx, data2, node ) {
						return data2.periodo_id === periodo_id;
					} )
					.remove()
					.draw();
					$('#periodos').DataTable().row.add(data).draw();							
					$("#cerrarPeriodo").click();
					swal("Se guardo correctamente", "", "success");
				}
				else{
					swal("No se guardo!", "Hubo un error...", "error");
				}
			},
			error: function(error){
				swal("No se guardo!", "Hubo un error...", "error");
			}
		});  
	}
	else{
		mostrarMensajeValidacion();
	}
}

function validarGuardarPeriodo(){
    var flag=true;
	msgEmpresa=[];	
	if($("#mes").val()==""){
		flag=false;
		msgEmpresa.push("Ingresar Mes");
	}	
	if($("#anio").val()==""){
		flag=false;
		msgEmpresa.push("Ingresar Año");
	}	
	return flag;
}

function eliminarPeriodo(){
    var dataSeleccionada=$('#periodos').DataTable().rows('.selected').data();
    if(dataSeleccionada.length == '1'){
        $.each(dataSeleccionada, function(index, value){
            try {
                periodo_id=value.periodo_id;
            } 
            catch (e) {
            }
        }); 
        swal({
            title: "Estas seguro?",
            text: "Si eliminas el periodo no se podra recuperar, además de toda la información del mismo",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    type: "post",
                    url: "./eliminarPeriodo",
                    data: {periodo_id: periodo_id},
                    success: function (data) {
						var periodo_id=data.periodo_id;
						$('#periodos').DataTable()
						.rows( function ( idx, data, node ) {
							return data.periodo_id === periodo_id;
						} )
						.remove()
						.draw();
                        swal("El periodo ha sido eliminado", "", "success");
                    },
                    error: function(error){
                        swal("No se pudo eliminar", "Hubo un error...", "error");
                    }
                });             
            } 
        });
    }
}

function bloquearBotones(){
    document.getElementById("ingresarEmpresa").disabled = true;
	document.getElementById("nuevoPeriodo").disabled = true;
	document.getElementById("eliminarPeriodo").disabled = true;
	document.getElementById("nuevoCentroCosto").disabled = true;
	document.getElementById("eliminarCentroCosto").disabled = true;
}

function nuevoCentroCosto(){
    limpiarModales();
	$("#modalCentroCosto").modal('show');
}

function guardarCentroCosto(){
	if(validarGuardarCC()){
		var data = $("#formCentroCosto").serialize();
		$.ajax({
			type: "post",
			url: "./grabarCentroCosto",
			data: data,
			success: function (data) {
			    if(data=="CC_EXISTE"){
					swal("Validar", "Ya existe ese Centro de costo para esta empresa", "warning");
				}
				else if(data!=null && data!=""){					
					var centro_costo_id=data.centro_costo_id;
					$('#centroCostos').DataTable()
					.rows( function ( idx, data2, node ) {
						return data2.centro_costo_id === centro_costo_id;
					} )
					.remove()
					.draw();
					$('#centroCostos').DataTable().row.add(data).draw();							
					$("#cerrarCentroCosto").click();
					swal("Se guardo correctamente", "", "success");
				}
				else{
					swal("No se guardo!", "Hubo un error...", "error");
				}
			},
			error: function(error){
				swal("No se guardo!", "Hubo un error...", "error");
			}
		});  
	}
	else{
		swal("No se pudo guardar", msgEmpresa.toString(), "warning");
	}
}

function validarGuardarCC(){
    var flag=true;
	msgEmpresa=[];	
	if($("#centroCosto").val()=="" || $("#centroCosto").val().trim().length==0){
		flag=false;
		msgEmpresa.push("Ingresar Centro de costo");
	}	
	return flag;
}

function eliminarCentroCosto(){
    var dataSeleccionada=$('#centroCostos').DataTable().rows('.selected').data();
    if(dataSeleccionada.length == '1'){
        $.each(dataSeleccionada, function(index, value){
            try {
                centro_costo_id=value.centro_costo_id;
            } 
            catch (e) {
            }
        }); 
        swal({
            title: "Estas seguro?",
            text: "Si eliminas el centro de costo no se podra recuperar",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    type: "post",
                    url: "./eliminarCentroCosto",
                    data: {centro_costo_id: centro_costo_id},
                    success: function (data) {
						var centro_costo_id=data.centro_costo_id;
						$('#centroCostos').DataTable()
						.rows( function ( idx, data, node ) {
							return data.centro_costo_id === centro_costo_id;
						} )
						.remove()
						.draw();
                        swal("El centro de costo ha sido eliminado", "", "success");
                    },
                    error: function(error){
                        swal("No se pudo eliminar", "Hubo un error...", "error");
                    }
                });             
            } 
        });
    }
}