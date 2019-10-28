$(document).ready(function(){	
	cargarCombos();
	mostrarData();
	cargarPorcentajes();
	crearDataTable("porcentajes",null,columnasPorcentajes()); 
    $("#guardarConfiguracion").click(function(){guardar();});
	$("#nuevoPorcentaje").click(function(){nuevoPorcentaje();});
	$("#guardarPorcentaje").click(function(){guardarPorcentaje();});
	$("#eliminarPorcentaje").click(function(){eliminarPorcentaje();});
	$("#rmv").maskMoney({allowZero:true});
	$("#comision").maskMoney({allowZero:true});
	$("#comisionMixta").maskMoney({allowZero:true});
	$("#fondo").maskMoney({allowZero:true});
	$("#seguro").maskMoney({allowZero:true});
	$("#tope").maskMoney({allowZero:true});
	$("#importeTope").maskMoney({allowZero:true});
});

function elegirImportacion() {
    if($("#tipoImportacion").val()=="Empleados"){
        $('#archivo').attr('action', 'http://planilla.asecoint.com.pe/importar_empleados');    
    }
    else if($("#tipoImportacion").val()=="Subsidios"){
        $('#archivo').attr('action', 'http://planilla.asecoint.com.pe/importar_subsidios');       
    }
    else if($("#tipoImportacion").val()=="Conceptos"){
        $('#archivo').attr('action', 'http://planilla.asecoint.com.pe/importar_conceptos');        
    }
    else{
        $('#archivo').attr('action', '');      
    }
}

function cargarCombos(){
	$.ajax({
        type: "get",
        url: "./comboAfp",
        success: function (data) {
            var selectList = document.getElementById("afp");
            var option = document.createElement('option');
		    option.value = "";
		    option.text = "Seleccione...";
		    selectList.appendChild(option);
            for (var i = 0; i < data.length; i++) {
                option = document.createElement("option");
                option.value = data[i].afp_id;
                option.text = data[i].nombre;
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
        url: "./obtenerConfiguracion",
        success: function (data) {
			if(data!=""){
			    $("#rmv").val(formatearMonto(data.valor));
			}
        },
        error: function(error){
        }
    });
}

function cargarPorcentajes(){
	$.ajax({
        type: "get",
        url: "./listarPorcentajes",
        success: function (data) {
			if(data!=""){
				$('#porcentajes').DataTable().clear().draw();
				$('#porcentajes').DataTable().rows.add(data).draw();
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

function columnasPorcentajes(){
	var columnas=[ { data: null,defaultContent:'',className:'select-checkbox',orderable:false,"width":"2%"},
	               { title: "AFP",data:"nombre","width": "6%"},
	               { title: "Periodo",data:"mes","width": "6%", "render": formatearPorcentaje },
	               { title: "Comision",data:"comision","width": "6%", "render": formatearMonto },
	               { title: "Comision Mixta",data:"comision_mixta","width": "6%", "render": formatearMonto },
	               { title: "Fondo",data:"fondo","width": "6%", "render": formatearMonto },
	               { title: "Seguro",data:"seguro","width": "6%", "render": formatearMonto },
	               { title: "Tope",data:"tope","width": "6%", "render": formatearMonto },
	               { title: "Importe Tope",data:"importe_tope","width": "6%", "render": formatearMonto },
			     ];
	return columnas;
}

function formatearPorcentaje(data, type, row ){
	return data+" "+row.anio;	
}

function formatearMonto(valor){
	var numeroFormateado="";
	if(valor!=null){
		numeroFormateado=accounting.formatMoney(valor,{symbol : "",thousand : ",",decimal : ".",});	
	}
	return  numeroFormateado;
}

function guardar(){
	if(validar()){
		var data = $("#formConfiguracion").serialize();
		$.ajax({
			type: "post",
			url: "./grabarConfiguracion",
			data: data,
			success: function (data) {
				if(data!=null && data!=""){
    				$("#rmv").val(formatearMonto(data.valor));
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

var msgConfiguracion=[];
function validar(){
	var flag=true;
	msgConfiguracion=[];	
	if($("#rmv").val()=="" || $("#rmv").val()=="0" || $("#rmv").val()=="0.00"){
		flag=false;
		msgConfiguracion.push("Ingresar Remuneracion minima vital");
	}	
	return flag;
}

function mostrarMensajeValidacion(){
    var list = document.createElement('ul');
    list.classList.add("list-group");
    for (var i = 0; i < msgConfiguracion.length; i++) {
        var item = document.createElement('li');
        item.classList.add("list-group-item");
        item.appendChild(document.createTextNode(msgConfiguracion[i]));
        list.appendChild(item);
    }
    swal({title:"Validar", content: list, icon: "warning"});
}

function nuevoPorcentaje(){
    limpiarModales();
	$("#modalPorcentaje").modal('show');
}

function limpiarModales(){
    $("#idPorcentaje").val("");
    $("#afp").val("");
	$("#mes").val("");
	$("#anio").val("");
    $("#comision").val("0.00");
    $("#comisionMixta").val("0.00");
    $("#fondo").val("0.00");
    $("#seguro").val("0.00");
    $("#tope").val("0.00");
    $("#importeTope").val("0.00");
}

function guardarPorcentaje(){
	if(validarGuardarPorcentaje()){
		var data = $("#formPorcentaje").serialize();
		$.ajax({
			type: "post",
			url: "./grabarPorcentaje",
			data: data,
			success: function (data) {
			    if(data=="PORCENTAJE_EXISTE"){
					swal("Validar", "Ya existe ese tipo de porcentaje para ese periodo", "warning");
				}
				else if(data!=null && data!=""){					
					var afp_porcentaje_id=data.afp_porcentaje_id;
					$('#porcentajes').DataTable()
					.rows( function ( idx, data2, node ) {
						return data2.afp_porcentaje_id === afp_porcentaje_id;
					} )
					.remove()
					.draw();
					$('#porcentajes').DataTable().row.add(data).draw();							
					$("#cerrarPorcentaje").click();
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

function validarGuardarPorcentaje(){
	var flag=true;
	msgConfiguracion=[];	
	if($("#afp").val()==""){
		flag=false;
		msgConfiguracion.push("Ingresar Tipo AFP");
	}
	if($("#mes").val()==""){
		flag=false;
		msgConfiguracion.push("Ingresar Mes");
	}
	if($("#anio").val()==""){
		flag=false;
		msgConfiguracion.push("Ingresar Año");
	}
	if($("#comision").val()=="" || $("#comision").val()=="0" || $("#comision").val()=="0.00"){
		flag=false;
		msgConfiguracion.push("Ingresar Comision");
	}
	if($("#comisionMixta").val()=="" || $("#comisionMixta").val()=="0" || $("#comisionMixta").val()=="0.00"){
		flag=false;
		msgConfiguracion.push("Ingresar Comision mixta");
	}
	if($("#fondo").val()=="" || $("#fondo").val()=="0" || $("#fondo").val()=="0.00"){
		flag=false;
		msgConfiguracion.push("Ingresar Fondo");
	}
	if($("#seguro").val()=="" || $("#seguro").val()=="0" || $("#seguro").val()=="0.00"){
		flag=false;
		msgConfiguracion.push("Ingresar Seguro");
	}
	if($("#tope").val()=="" || $("#tope").val()=="0" || $("#tope").val()=="0.00"){
		flag=false;
		msgConfiguracion.push("Ingresar Tope");
	}
	if($("#importeTope").val()=="" || $("#importeTope").val()=="0" || $("#importeTope").val()=="0.00"){
		flag=false;
		msgConfiguracion.push("Ingresar Importe tope");
	}
	return flag;
}

function eliminarPorcentaje(){
    var dataSeleccionada=$('#porcentajes').DataTable().rows('.selected').data();
    if(dataSeleccionada.length == '1'){
        $.each(dataSeleccionada, function(index, value){
            try {
                afp_porcentaje_id=value.afp_porcentaje_id;
            } 
            catch (e) {
            }
        }); 
        swal({
            title: "Estas seguro?",
            text: "Si eliminas el porcentaje no se podra recuperar",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    type: "post",
                    url: "./eliminarPorcentaje",
                    data: {afp_porcentaje_id: afp_porcentaje_id},
                    success: function (data) {
						var afp_porcentaje_id=data.afp_porcentaje_id;
						$('#porcentajes').DataTable()
						.rows( function ( idx, data, node ) {
							return data.afp_porcentaje_id === afp_porcentaje_id;
						} )
						.remove()
						.draw();
                        swal("El porcentaje ha sido eliminado", "", "success");
                    },
                    error: function(error){
                        swal("No se pudo eliminar", "Hubo un error...", "error");
                    }
                });             
            } 
        });
    }
}