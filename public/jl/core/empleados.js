$(document).ready(function(){	
	cargarCombos();
	cargarAutocompletes();
	mostrarData();
	cargarContratos();
	cargarSubsidios();
	cargarHoras();
	$(".element-select-modal").select2({
        dropdownParent: $("#modalSearch"),
        width: '600px'
    });
	$( "#nacimiento" ).datepicker({dateFormat:"dd/mm/yy"});
	$( "#fechaInscripcion" ).datepicker({dateFormat:"dd/mm/yy"}); 
	$( "#fechaCese" ).datepicker({dateFormat:"dd/mm/yy"}); 	
	crearDataTable("contratos",null,columnasContratos()); 
	crearDataTable("subsidios",null,columnasSubsidios()); 
	crearDataTable("horasExtras",null,columnasHorasExtras()); 		
    $("#guardarEmpleado").click(function(){guardar();});
	$("#nuevoContrato").click(function(){nuevoContrato();});
	$("#editarContrato").click(function(){editarContrato();});
	$("#guardarContrato").click(function(){guardarContrato();});
	$("#eliminarContrato").click(function(){eliminarContrato();});	
	$("#sueldo").maskMoney({allowZero:true});
	$( "#ingreso" ).datepicker({dateFormat:"dd/mm/yy"}); 
	$( "#inicio" ).datepicker({dateFormat:"dd/mm/yy"}); 
	$( "#fin" ).datepicker({dateFormat:"dd/mm/yy"}); 
	$("#nuevoSubsidio").click(function(){nuevoSubsidio();});
	$("#editarSubsidio").click(function(){editarSubsidio();});
	$("#guardarSubsidio").click(function(){guardarSubsidio();});
	$("#eliminarSubsidio").click(function(){eliminarSubsidio();});	
	$( "#inicioSubsidio" ).datepicker({dateFormat:"dd/mm/yy"}); 
	$( "#finSubsidio" ).datepicker({dateFormat:"dd/mm/yy"}); 
	$("#nuevoHora").click(function(){nuevoHora();});
	$("#editarHora").click(function(){editarHora();});
	$("#guardarHora").click(function(){guardarHora();});
	$("#eliminarHora").click(function(){eliminarHora();});
	$( "#fechaHora" ).datepicker({dateFormat:"dd/mm/yy"}); 	
});

function cargarCombos(){
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
        url: "./comboEstadoEmpleados",
        success: function (data) {
            var selectList = document.getElementById("estado");
            var option = document.createElement('option');
		    option.value = "";
		    option.text = "Seleccione...";
		    selectList.appendChild(option);
            for (var i = 0; i < data.length; i++) {
                option = document.createElement("option");
                option.value = data[i].estado_empleado_id;
                option.text = data[i].nombre;
                selectList.appendChild(option);
            }    
        },
        error: function(error){
        }
    });
	$.ajax({
        type: "get",
        url: "./comboCentroCostos",
        success: function (data) {
            var selectList = document.getElementById("centroCosto");
            var option = document.createElement('option');
		    option.value = "";
		    option.text = "Seleccione...";
		    selectList.appendChild(option);
            for (var i = 0; i < data.length; i++) {
                option = document.createElement("option");
                option.value = data[i].centro_costo_id;
                option.text = data[i].centro_costo;
                selectList.appendChild(option);
            }    
        },
        error: function(error){
        }
    });
	$.ajax({
        type: "get",
        url: "./comboCategorias",
        success: function (data) {
            var selectList = document.getElementById("categoria");
            var option = document.createElement('option');
		    option.value = "";
		    option.text = "Seleccione...";
		    selectList.appendChild(option);
            for (var i = 0; i < data.length; i++) {
                option = document.createElement("option");
                option.value = data[i].categoria_id;
                option.text = data[i].nom_categoria;
                selectList.appendChild(option);
            }    
        },
        error: function(error){
        }
    });
	$.ajax({
        type: "get",
        url: "./comboTipoTrabajadores",
        success: function (data) {
            var selectList = document.getElementById("tipoTrabajador");
            var option = document.createElement('option');
		    option.value = "";
		    option.text = "Seleccione...";
		    selectList.appendChild(option);
            for (var i = 0; i < data.length; i++) {
                option = document.createElement("option");
                option.value = data[i].tipo_trabajador_id;
                option.text = data[i].nombre;
                selectList.appendChild(option);
            }    
        },
        error: function(error){
        }
    });
	$.ajax({
        type: "get",
        url: "./comboSituacionEspecial",
        success: function (data) {
            var selectList = document.getElementById("situacionEspecial");
            var option = document.createElement('option');
		    option.value = "";
		    option.text = "Seleccione...";
		    selectList.appendChild(option);
            for (var i = 0; i < data.length; i++) {
                option = document.createElement("option");
                option.value = data[i].situacion_especial_id;
                option.text = data[i].descripcion;
                selectList.appendChild(option);
            }    
        },
        error: function(error){
        }
    });
	$.ajax({
        type: "get",
        url: "./comboTipoPago",
        success: function (data) {
            var selectList = document.getElementById("tipoPago");
            var option = document.createElement('option');
		    option.value = "";
		    option.text = "Seleccione...";
		    selectList.appendChild(option);
            for (var i = 0; i < data.length; i++) {
                option = document.createElement("option");
                option.value = data[i].tipo_pago_id;
                option.text = data[i].descripcion;
                selectList.appendChild(option);
            }    
        },
        error: function(error){
        }
    });
	$.ajax({
        type: "get",
        url: "./comboOcupacional",
        success: function (data) {
            var selectList = document.getElementById("categoriaOcupacional");
            var option = document.createElement('option');
		    option.value = "";
		    option.text = "Seleccione...";
		    selectList.appendChild(option);
            for (var i = 0; i < data.length; i++) {
                option = document.createElement("option");
                option.value = data[i].cat_ocupacional_id;
                option.text = data[i].nombre;
                selectList.appendChild(option);
            }    
        },
        error: function(error){
        }
    });
	$.ajax({
        type: "get",
        url: "./comboPeriocidad",
        success: function (data) {
            var selectList = document.getElementById("periocidadRem");
            var option = document.createElement('option');
		    option.value = "";
		    option.text = "Seleccione...";
		    selectList.appendChild(option);
            for (var i = 0; i < data.length; i++) {
                option = document.createElement("option");
                option.value = data[i].periodo_id;
                option.text = data[i].descripcion;
                selectList.appendChild(option);
            }    
        },
        error: function(error){
        }
    });
	$.ajax({
        type: "get",
        url: "./comboSituacionLaboral",
        success: function (data) {
            var selectList = document.getElementById("situacionLaboral");
            var option = document.createElement('option');
		    option.value = "";
		    option.text = "Seleccione...";
		    selectList.appendChild(option);
            for (var i = 0; i < data.length; i++) {
                option = document.createElement("option");
                option.value = data[i].laboral_id;
                option.text = data[i].descripcion;
                selectList.appendChild(option);
            }    
        },
        error: function(error){
        }
    });
	$.ajax({
        type: "get",
        url: "./comboComisionTipos",
        success: function (data) {
            var selectList = document.getElementById("tipoComision");
            var option = document.createElement('option');
		    option.value = "";
		    option.text = "Seleccione...";
		    selectList.appendChild(option);
            for (var i = 0; i < data.length; i++) {
                option = document.createElement("option");
                option.value = data[i].comision_tipo_id;
                option.text = data[i].nombre;
                selectList.appendChild(option);
            }    
        },
        error: function(error){
        }
    });
	$.ajax({
        type: "get",
        url: "./comboServicioPropio",
        success: function (data) {
            var selectList = document.getElementById("eps");
            var option = document.createElement('option');
		    option.value = "";
		    option.text = "Seleccione...";
		    selectList.appendChild(option);
            for (var i = 0; i < data.length; i++) {
                option = document.createElement("option");
                option.value = data[i].servicios_id;
                option.text = data[i].descripcion;
                selectList.appendChild(option);
            }    
        },
        error: function(error){
        }
    });
	$.ajax({
        type: "get",
        url: "./comboSnpAfp",
        success: function (data) {
            var selectList = document.getElementById("regimenPen");
            var option = document.createElement('option');
		    option.value = "";
		    option.text = "Seleccione...";
		    selectList.appendChild(option);
            for (var i = 0; i < data.length; i++) {
                option = document.createElement("option");
                option.value = data[i].snp_afp_id;
                option.text = data[i].nombre;
                selectList.appendChild(option);
            }    
        },
        error: function(error){
        }
    });
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
        url: "./comboTipoContratos",
        success: function (data) {
            var selectList = document.getElementById("tipo");
            var option = document.createElement('option');
		    option.value = "";
		    option.text = "Seleccione...";
		    selectList.appendChild(option);
            for (var i = 0; i < data.length; i++) {
                option = document.createElement("option");
                option.value = data[i].tipo_contrato_id;
                option.text = data[i].descripcion;
                selectList.appendChild(option);
            }    
        },
        error: function(error){
        }
    });
	$.ajax({
        type: "get",
        url: "./comboTipoSubsidios",
        success: function (data) {
            var selectList = document.getElementById("tipoSubsidio");
            var option = document.createElement('option');
		    option.value = "";
		    option.text = "Seleccione...";
		    selectList.appendChild(option);
            for (var i = 0; i < data.length; i++) {
                option = document.createElement("option");
                option.value = data[i].tipo_suspension_id;
                option.text = data[i].descripcion;
                selectList.appendChild(option);
            }    
        },
        error: function(error){
        }
    });
}

function cargarAutocompletes(){
	$.ajax({
        type: "get",
        url: "./comboNacionalidad",
        success: function (data) {
            $( "#nacionalidad" ).autocomplete({
                source: data,
                minLength: 3
            });
        },
        error: function(error){
        }
    });
	$.ajax({
        type: "get",
        url: "./comboOcupacion",
        success: function (data) {
            $( "#ocupacion" ).autocomplete({
                source: data,
                minLength: 3
            });
        },
        error: function(error){
        }
    }); 
	$.ajax({
        type: "get",
        url: "./comboEducativos",
        success: function (data) {
            $( "#nivelEducativo" ).autocomplete({
                source: data,
                minLength: 3
            });
        },
        error: function(error){
        }
    });    
}

function mostrarData(){
	$.ajax({
		type: "get",			
        url: "./obtenerEmpleado",
        success: function (data) {
			if(data!=""){
				$("#idEmpleado").val(data.id_trabajador);
				$("#paterno").val(data.ape_paterno);
				$("#materno").val(data.ape_materno);
				$("#nombres").val(data.nombres);
				$("#tipoDoc").val(data.tipo_doc);
				$("#numDoc").val(data.num_doc);
				$("#nacimiento").val(formatearFecha(data.fecha_nacimiento,null,null));
				$("#estadoCivil").val(data.estado_civil);
				$("#sexo").val(data.sexo);
				$("#centroCosto").val(data.centro_costo);
				$("#email").val(data.email);
				$("#celular").val(data.celular);
				$("#estado").val(data.estado_empleado_id);
				$("#categoria").val(data.categoria);
				$("#tipoTrabajador").val(data.tipo_trabajador);
				$("#nacionalidad").val(data.nacionalidad);
				$("#situacionEspecial").val(data.situacion_especial);
				$("#tipoPago").val(data.tipo_pago);
				$("#categoriaOcupacional").val(data.categoria_ocupacional);
				$("#ocupacion").val(data.ocupacion);
				$("#periocidadRem").val(data.periocidad);
				$("#discapacidad").val(data.discapacidad);
				$("#horarioNocturno").val(data.horario_nocturno);
				$("#cargaFamiliar").val(data.carga_familiar);
				$("#nivelEducativo").val(data.nivel_educativo);
				$("#cuspp").val(data.n_cuspp);
				$("#eps").val(data.servicios_propios);
				$("#fechaInscripcion").val(formatearFecha(data.fecha_inscripcion,null,null));
				$("#regimenPen").val(data.snp_afp_id);
				$("#afp").val(data.afp_id);
				$("#tipoComision").val(data.comision_tipo_id);
				$("#situacionLaboral").val(data.situacion_laboral);
				$("#fechaCese").val(formatearFecha(data.fecha_cese,null,null));
			}
			else{
			    bloquearCards();
				bloquearBotones();
			}
        },
        error: function(error){
        }
    });
}

function bloquearCards(){
    $("#cardContratos").css("display","none");  
    $("#cardSubsidios").css("display","none"); 
    $("#cardHorasExtras").css("display","none"); 
}

function desbloquearCards(){
    $("#cardContratos").css("display","");  
    $("#cardSubsidios").css("display",""); 
    $("#cardHorasExtras").css("display",""); 
}

function cargarContratos(){
	$.ajax({
        type: "get",
        url: "./listarContratos",
        success: function (data) {
			if(data!=""){
				$('#contratos').DataTable().clear().draw();
				$('#contratos').DataTable().rows.add(data).draw();
			}
        },
        error: function(error){
        }
    });
}

function cargarSubsidios(){
	$.ajax({
        type: "get",
        url: "./listarSubsidios",
        success: function (data) {
			if(data!=""){
				$('#subsidios').DataTable().clear().draw();
				$('#subsidios').DataTable().rows.add(data).draw();
			}
        },
        error: function(error){
        }
    });
}

function cargarHoras(){
	$.ajax({
        type: "get",
        url: "./listarHoras",
        success: function (data) {
			if(data!=""){
				$('#horasExtras').DataTable().clear().draw();
				$('#horasExtras').DataTable().rows.add(data).draw();
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
			order: [[ 1, "asc" ]],
	});
	try {
		new $.fn.dataTable.FixedHeader(dt, {
	        "alwaysCloneTop": true
		});
	} catch (e) {
	}
}

function columnasContratos(){
	var columnas=[ { data: null,defaultContent:'',className:'select-checkbox',orderable:false,"width":"2%"},
	               { title: "Tipo",data:"descripcion","width": "6%" },
				   { title: "Sueldo",data:"sueldo","width": "6%","render":formatearMonto },
				   { title: "Fecha Ingreso",data:"fecha_ingreso","width": "6%","render":formatearFecha },
				   { title: "Inicio",data:"inicio_contrato","width": "6%","render":formatearFecha },
				   { title: "Fin",data:"fin_contrato","width": "6%","render":formatearFecha },				   
			     ];
	return columnas;
}

function columnasSubsidios(){
	var columnas=[ { data: null,defaultContent:'',className:'select-checkbox',orderable:false,"width":"2%"},
	               { title: "Tipo",data:"descripcion","width": "6%" },
				   { title: "Fecha Inicio",data:"fecha_inicio","width": "6%","render":formatearFecha },
				   { title: "Fecha Fin",data:"fecha_fin","width": "6%","render":formatearFecha },
				   { title: "Dias",data:"nro_dias","width": "6%" },
			     ];
	return columnas;
}

function columnasHorasExtras(){
	var columnas=[ { data: null,defaultContent:'',className:'select-checkbox',orderable:false,"width":"2%"},
	               { title: "Fecha",data:"fecha","width": "6%","render":formatearFecha },
				   { title: "Horas",data:"nro_horas","width": "6%" },
				   { title: "Feriado",data:"feriado","width": "6%","render":formatearFeriado },
			     ];
	return columnas;
}

function formatearFeriado(valor){
	var feriado="No";
	if(valor=="1"){
		feriado="Si";
	}
	return  feriado;
}

function formatearMonto(valor){
	var numeroFormateado="";
	if(valor!=null){
		numeroFormateado=accounting.formatMoney(valor,{symbol : "",thousand : ",",decimal : ".",});	
	}
	return  numeroFormateado;
}

function formatearFecha(data, type, row ){
	var fecha="";
	if(data!=null && data!=""){
	    var parts=data.split('-');
        var date=new Date(parts[0],parts[1]-1,parts[2]);
        fecha=$.datepicker.formatDate("dd/mm/yy",date);
	}
	return fecha;	
}

function guardar(){
	if(validar()){
		var data = $("#formEmpleado").serialize();
		$.ajax({
			type: "post",
			url: "./grabarDato",
			data: data,
			success: function (data) {
				if(data!=null && data!=""){
					$("#idEmpleado").val(data.id_trabajador);
					$("#paterno").val(data.ape_paterno);
					$("#materno").val(data.ape_materno);
					$("#nombres").val(data.nombres);
					$("#tipoDoc").val(data.tipo_doc);
					$("#numDoc").val(data.num_doc);
					$("#nacimiento").val(formatearFecha(data.fecha_nacimiento,null,null));
					$("#estadoCivil").val(data.estado_civil);
					$("#sexo").val(data.sexo);
					$("#centroCosto").val(data.centro_costo);
					$("#email").val(data.email);
					$("#celular").val(data.celular);
					$("#estado").val(data.estado_empleado_id);
					$("#categoria").val(data.categoria);
					$("#tipoTrabajador").val(data.tipo_trabajador);
					$("#nacionalidad").val(data.nacionalidad);
					$("#situacionEspecial").val(data.situacion_especial);
					$("#tipoPago").val(data.tipo_pago);
					$("#categoriaOcupacional").val(data.categoria_ocupacional);
					$("#ocupacion").val(data.ocupacion);
					$("#periocidadRem").val(data.periocidad);
					$("#discapacidad").val(data.discapacidad);
					$("#horarioNocturno").val(data.horario_nocturno);
					$("#cargaFamiliar").val(data.carga_familiar);
					$("#nivelEducativo").val(data.nivel_educativo);
					$("#cuspp").val(data.n_cuspp);
					$("#eps").val(data.servicios_propios);
					$("#fechaInscripcion").val(formatearFecha(data.fecha_inscripcion,null,null));
					$("#regimenPen").val(data.snp_afp_id);
					$("#afp").val(data.afp_id);
					$("#tipoComision").val(data.comision_tipo_id);
					$("#situacionLaboral").val(data.situacion_laboral);
					$("#fechaCese").val(formatearFecha(data.fecha_cese,null,null));
					desbloquearCards();
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
    for (var i = 0; i < msg.length; i++) {
        var item = document.createElement('li');
        item.classList.add("list-group-item");
        item.appendChild(document.createTextNode(msg[i]));
        list.appendChild(item);
    }
    swal({title:"Validar", content: list, icon: "warning"});
}

function desbloquearBotones(){
	document.getElementById("nuevoContrato").disabled = false;
	document.getElementById("editarContrato").disabled = false;
	document.getElementById("eliminarContrato").disabled = false;
	document.getElementById("nuevoSubsidio").disabled = false;
	document.getElementById("editarSubsidio").disabled = false;
	document.getElementById("eliminarSubsidio").disabled = false;
}

var msg=[];
function validar(){
	var flag=true;
	msg=[];	
	if($("#paterno").val()==""){
		flag=false;
		msg.push("Ingresar Apellido paterno");
	}
	if($("#materno").val()==""){
		flag=false;
		msg.push("Ingresar Apellido materno");
	}
	if($("#nombres").val()==""){
		flag=false;
		msg.push("Ingresar Nombres");
	}
	if($("#tipoDoc").val()==""){
		flag=false;
		msg.push("Ingresar Tipo de documento");
	}
	if($("#numDoc").val()==""){
		flag=false;
		msg.push("Ingresar Nro. de documento");
	}
	if($("#estado").val()==""){
		flag=false;
		msg.push("Ingresar Estado");
	}
	if($("#categoria").val()==""){
		flag=false;
		msg.push("Ingresar Categoria");
	}
	if($("#regimenPen").val()==""){
		flag=false;
		msg.push("Ingresar Regimen pensionario");
	}	
	if($("#idEmpleado").val()!="" && $('#contratos').DataTable().data().count()==0){
		flag=false;
		msg.push("Crear minimo un contrato.");
	}
	return flag;
}

function nuevoContrato(){
    limpiarModales();
	$("#modalContrato").modal('show');
}

function limpiarModales(){
    $("#idContrato").val("");
	$("#tipo").val("");
	$("#sueldo").val("");
	$("#ingreso").val("");
	$("#inicio").val("");
	$("#fin").val("");
	$("#idSubsidio").val("");
	$("#tipoSubsidio").val("");
	$("#inicioSubsidio").val("");
	$("#finSubsidio").val("");
	$("#idHora").val("");
	$("#fechaHora").val("");
	$("#nroHora").val("");
	$("#feriadoHora").val("");
}

function editarContrato(){
    var dataSeleccionada=$('#contratos').DataTable().rows('.selected').data();
    if(dataSeleccionada.length == '1'){
        $.each(dataSeleccionada, function(index, value){
            try {
                id=value.contrato_id;
            } 
            catch (e) {
            }
        }); 
        $.ajax({
            type: "post",
            url: "./obtenerContrato",
            data: {id: id},
            success: function (data) {
                $("#idContrato").val(data.contrato_id);
                $("#tipo").val(data.tipo_contrato_id);
				$("#sueldo").val(data.sueldo);
                $("#ingreso").val(formatearFecha(data.fecha_ingreso,null,null));
            	$("#inicio").val(formatearFecha(data.inicio_contrato,null,null));
            	$("#fin").val(formatearFecha(data.fin_contrato,null,null));
                $("#modalContrato").modal('show');
            },
            error: function(error){
                swal("No se cargo el contrato!", "Hubo un error...", "error");
            }
        });
    }
}

function guardarContrato(){
	if(validarGuardarContrato()){
		var data = $("#formContrato").serialize();
		$.ajax({
			type: "post",
			url: "./grabarContrato",
			data: data,
			success: function (data) {
				if(data!=null && data!=""){					
					var contrato_id=data.contrato_id;
					$('#contratos').DataTable()
					.rows( function ( idx, data2, node ) {
						return data2.contrato_id === contrato_id;
					} )
					.remove()
					.draw();
					$('#contratos').DataTable().row.add(data).draw();							
					$("#cerrarContrato").click();
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

function validarGuardarContrato(){
	var flag=true;
	msg=[];	
	if($("#tipo").val()==""){
		flag=false;
		msg.push("Ingresar Tipo de contrato");
	}
	if($("#sueldo").val()=="" || $("#sueldo").val()=="0.00"){
		flag=false;
		msg.push("Ingresar Sueldo");
	}
	if($("#ingreso").val()==""){
		flag=false;
		msg.push("Ingresar Ingreso contrato");
	}
	if($("#inicio").val()==""){
		flag=false;
		msg.push("Ingresar Fin de contrato");
	}
	return flag;
}

function eliminarContrato(){
    var dataSeleccionada=$('#contratos').DataTable().rows('.selected').data();
    if(dataSeleccionada.length == '1'){
        $.each(dataSeleccionada, function(index, value){
            try {
                contrato_id=value.contrato_id;
            } 
            catch (e) {
            }
        }); 
        swal({
            title: "Estas seguro?",
            text: "Si eliminas el contrato no se podra recuperar",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    type: "post",
                    url: "./eliminarContrato",
                    data: {contrato_id: contrato_id},
                    success: function (data) {
						var contrato_id=data.contrato_id;
						$('#contratos').DataTable()
						.rows( function ( idx, data, node ) {
							return data.contrato_id === contrato_id;
						} )
						.remove()
						.draw();
                        swal("El contrato ha sido eliminado", "", "success");
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
	document.getElementById("nuevoContrato").disabled = true;
	document.getElementById("editarContrato").disabled = true;
	document.getElementById("eliminarContrato").disabled = true;
	document.getElementById("nuevoSubsidio").disabled = true;
	document.getElementById("editarSubsidio").disabled = true;
	document.getElementById("eliminarSubsidio").disabled = true;
}

function nuevoSubsidio(){
    limpiarModales();
    $("#groupNroSubsidio").css("display","none");  
	$("#modalSubsidio").modal('show');
}

function editarSubsidio(){
    var dataSeleccionada=$('#subsidios').DataTable().rows('.selected').data();
    if(dataSeleccionada.length == '1'){
        $.each(dataSeleccionada, function(index, value){
            try {
                id=value.suspension_id;
            } 
            catch (e) {
            }
        }); 
        $.ajax({
            type: "post",
            url: "./obtenerSubsidio",
            data: {id: id},
            success: function (data) {
                $("#idSubsidio").val(data.suspension_id);
                $("#tipoSubsidio").val(data.tipo_suspension_id);
            	$("#inicioSubsidio").val(formatearFecha(data.fecha_inicio,null,null));
            	$("#finSubsidio").val(formatearFecha(data.fecha_fin,null,null));
            	$("#nroSubsidio").val(data.nro_suspension);
                hacerSegunTipo();
                $("#modalSubsidio").modal('show');
            },
            error: function(error){
                swal("No se cargo el subsidio!", "Hubo un error...", "error");
            }
        });
    }
}

function guardarSubsidio(){
	if(validar){
		var data = $("#formSubsidio").serialize();
		$.ajax({
			type: "post",
			url: "./grabarSubsidio",
			data: data,
			success: function (data) {
				if(data!=null && data!=""){					
					var suspension_id=data.suspension_id;
					$('#subsidios').DataTable()
					.rows( function ( idx, data2, node ) {
						return data2.suspension_id === suspension_id;
					} )
					.remove()
					.draw();
					$('#subsidios').DataTable().row.add(data).draw();							
					$("#cerrarSubsidio").click();
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
		swal("No se pudo guardar", msg.toString(), "warning");
	}
}

function eliminarSubsidio(){
    var dataSeleccionada=$('#subsidios').DataTable().rows('.selected').data();
    if(dataSeleccionada.length == '1'){
        $.each(dataSeleccionada, function(index, value){
            try {
                suspension_id=value.suspension_id;
            } 
            catch (e) {
            }
        }); 
        swal({
            title: "Estas seguro?",
            text: "Si eliminas el subsidio no se podra recuperar",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    type: "post",
                    url: "./eliminarSubsidio",
                    data: {suspension_id: suspension_id},
                    success: function (data) {
						var suspension_id=data.suspension_id;
						$('#subsidios').DataTable()
						.rows( function ( idx, data, node ) {
							return data.suspension_id === suspension_id;
						} )
						.remove()
						.draw();
                        swal("El subsidio ha sido eliminado", "", "success");
                    },
                    error: function(error){
                        swal("No se pudo eliminar", "Hubo un error...", "error");
                    }
                });             
            } 
        });
    }
}

function nuevoHora(){
    limpiarModales();
	$("#modalHora").modal('show');
}

function editarHora(){
    var dataSeleccionada=$('#horasExtras').DataTable().rows('.selected').data();
    if(dataSeleccionada.length == '1'){
        $.each(dataSeleccionada, function(index, value){
            try {
                id=value.hora_id;
            } 
            catch (e) {
            }
        }); 
        $.ajax({
            type: "post",
            url: "./obtenerHora",
            data: {id: id},
            success: function (data) {
                $("#idHora").val(data.hora_id);
				$("#fechaHora").val(formatearFecha(data.fecha,null,null));
                $("#nroHora").val(data.nro_horas);
				$("#feriadoHora").val(data.feriado);
                $("#modalHora").modal('show');
            },
            error: function(error){
                swal("No se cargo las horas extras!", "Hubo un error...", "error");
            }
        });
    }
}

function guardarHora(){
	if(validar){
		var data = $("#formHora").serialize();
		$.ajax({
			type: "post",
			url: "./grabarHora",
			data: data,
			success: function (data) {
				if(data!=null && data!=""){					
					var hora_id=data.hora_id;
					$('#horasExtras').DataTable()
					.rows( function ( idx, data2, node ) {
						return data2.hora_id === hora_id;
					} )
					.remove()
					.draw();
					$('#horasExtras').DataTable().row.add(data).draw();							
					$("#cerrarHora").click();
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
		swal("No se pudo guardar", msg.toString(), "warning");
	}
}

function eliminarHora(){
    var dataSeleccionada=$('#horasExtras').DataTable().rows('.selected').data();
    if(dataSeleccionada.length == '1'){
        $.each(dataSeleccionada, function(index, value){
            try {
                hora_id=value.hora_id;
            } 
            catch (e) {
            }
        }); 
        swal({
            title: "Estas seguro?",
            text: "Si eliminas las horas extra no se podra recuperar",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    type: "post",
                    url: "./eliminarHora",
                    data: {hora_id: hora_id},
                    success: function (data) {
						var hora_id=data.hora_id;
						$('#horasExtras').DataTable()
						.rows( function ( idx, data, node ) {
							return data.hora_id === hora_id;
						} )
						.remove()
						.draw();
                        swal("La hora extra ha sido eliminada", "", "success");
                    },
                    error: function(error){
                        swal("No se pudo eliminar", "Hubo un error...", "error");
                    }
                });             
            } 
        });
    }
}

function hacerSegunTipo() {
    if($("#tipoSubsidio").val()!="7" && $("#tipoSubsidio").val()!="8" && $("#tipoSubsidio").val()!="9"){
        $("#groupNroSubsidio").css("display","none");    
    }
    else{
        $("#groupNroSubsidio").css("display","");     
    }
}