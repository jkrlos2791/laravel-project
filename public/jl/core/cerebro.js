$(document).ready(function(){
    obtenerModulos();
    crearDataTable("modulos",null,columnasModulos()); 
    $("#nuevoModulo").click(function(){nuevoModulo();});
	$("#guardarModulo").click(function(){guardarModulo();});
	$("#eliminarModulo").click(function(){eliminarModulo();});
	$(".element-select-modal").select2({
        dropdownParent: $("#modalSearch"),
        width: '600px'
    });
	$("#eliminarContrato").click(function(){eliminarContrato();});	
	$("#sueldo").maskMoney({allowZero:true});
	$( "#ingreso" ).datepicker({dateFormat:"dd/mm/yy"}); 
});

function obtenerModulos(){
	$.ajax({
        type: "get",
        url: "./listarModulos",
        success: function (data) {
			if(data!=""){
				$('#modulos').DataTable().clear().draw();
				$('#modulos').DataTable().rows.add(data).draw();
			}
        },
        error: function(error){
        }
    });
}

function nuevoModulo(){
    limpiarModales();
	$("#modalFormModulo").modal('show');
}

function guardarModulo(){
    if(validar()){
        //var nombre = $("#nombre").val();
        var data=new FormData($("#formModulo")[0]);
        //var file = $("#archivo").files[0];
        $.ajax({
            type: "post",
            url: "./crearModulo",
            //data: {nombre: nombre},
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
				if(data!=null && data!=""){					
					var modulo_id=data.modulo_id;
					$('#modulos').DataTable()
					.rows( function ( idx, data2, node ) {
						return data2.modulo_id === modulo_id;
					} )
					.remove()
					.draw();
					$('#modulos').DataTable().row.add(data).draw();							
					$("#cerrarModulo").click();
					swal("Se guardo correctamente", "", "success");
				}
				else{
					swal("No se guardo!", "Hubo un error...", "error");
				}
            },
            error: function(error){
                swal("Cuidado!", "Hubo un error...", "error");
            }
        });
    }
	else{
		swal("No se pudo guardar", msg.toString(), "warning");
	}
}

function eliminarModulo(){
    var dataSeleccionada=$('#modulos').DataTable().rows('.selected').data();
    if(dataSeleccionada.length == '1'){
        $.each(dataSeleccionada, function(index, value){
            try {
                modulo_id=value.modulo_id;
            } 
            catch (e) {
            }
        }); 
        swal({
            title: "Estas seguro?",
            text: "Si eliminas el modulo no se podra recuperar",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    type: "post",
                    url: "./eliminarModulo",
                    data: {modulo_id: modulo_id},
                    success: function (data) {
						var modulo_id=data.modulo_id;
						$('#modulos').DataTable()
						.rows( function ( idx, data, node ) {
							return data.modulo_id === modulo_id;
						} )
						.remove()
						.draw();
                        swal("El modulo ha sido eliminado", "", "success");
                    },
                    error: function(error){
                        swal("No se pudo eliminar", "Hubo un error...", "error");
                    }
                });             
            } 
        });
    }
}

function pruebaChart(){
    var bachilleres=[];
    var titulos=[];
    var maestrias=[];
    var doctorados=[];
    var segundas=[];
    var datos=[];
	$.ajax({
        type: "get",
        url: "./obtenerChart",
        success: function (data) {
            for (var i = 0; i < data.length; i++) {
                if("Bachiller"==data[i].nombre_grado){
                    bachilleres.push(data[i].nombre_grado);
                }
                else if("Títulos Profesionales"==data[i].nombre_grado){
                    titulos.push(data[i].nombre_grado);
                }
                else if("Maestrías"==data[i].nombre_grado){
                    maestrias.push(data[i].nombre_grado);
                }
                else if("Doctorados"==data[i].nombre_grado){
                    doctorados.push(data[i].nombre_grado);
                }
                else if("Segundas Especialidades"==data[i].nombre_grado){
                    segundas.push(data[i].nombre_grado);
                }
            }    
            datos.push(bachilleres.length);
            datos.push(titulos.length);
            datos.push(maestrias.length);
            datos.push(doctorados.length);
            datos.push(segundas.length);
        },
        error: function(error){
        }
    });
    
    var ctx = document.getElementById('myChart');
    var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        //labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
        labels: ['Bachiller', 'Títulos Profesionales', 'Maestrías', 'Doctorado', 'Segundas Especialidades'],
        datasets: [{
            label: '# of Votes',
            //data: [12, 19, 3, 5, 2, 3],
            data: datos,
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
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

function columnasModulos(){
	var columnas=[ { data: null,defaultContent:'',className:'select-checkbox',orderable:false,"width":"2%"},
	               { title: "Nombre",data:"nombre","width": "6%" },
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
	if($("#nombre").val()==""){
		flag=false;
		msg.push("Ingresar nombre");
	}
	return flag;
}

function nuevoContrato(){
    limpiarModales();
	$("#modalContrato").modal('show');
}

function limpiarModales(){
    $("#nombre").val("");
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