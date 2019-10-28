$(document).ready(function(){
    listar();
    $(".element-select").select2({
        dropdownParent: $("#modalServicio"),
        width: '225px'
    });
    cargarCombos();
    $( "#fecha" ).datepicker({dateFormat:"dd/mm/yy"}); 
    $("#nuevoServicio").click(function(){nuevoServicio();});
    $("#guardarServicio").click(function(){guardarServicio();});
    $("#editarServicio").click(function(){editarServicio();});
    $("#eliminarServicio").click(function(){eliminarServicio();});
    $("#exportarServicio").click(function(){exportarServicio();});
    $("#subtotal").maskMoney({allowZero:true});
    $("#costoProv").maskMoney({allowZero:true});
    $("#agregarFactura").click(function(){agregarFactura();});
    crearDataTable("tablaFactura",null,columnasFactura()); 
    $("#agregarGuia").click(function(){agregarGuia();});
    crearDataTable("tablaGuia",null,columnasGuia()); 
});

function listar(){
    $('#planilla').DataTable( {
        language: {
        url: './jl/datatables/language/Spanish.json'
        },
        "pageLength": 8,
        "ajax": {
            "url": "./listarPlanillas",
            "dataSrc": ""
        },
        "columns": [
            {data: null,defaultContent:'',className:'select-checkbox',orderable:false,"width":"2%"},
            {"title":"Nro. Doc.","data":"num_doc","width":"4%"},
            {"title":"Nombres","data":"nombres","width":"14%"},
            {"title":"C.C.","data":"centro_costo","width":"8%"},
            {"title":"Tipo AFP","data":"afp","width":"4%","render":formatearAfp},
            {"title":"CUSSP","data":"cussp","width":"4%"},
            {"title":"Ingresos","data":"total_ingresos","width":"4%","render":validarNumeroNull},
			{"title":"Descuentos","data":"total_descuentos","width":"4%","render":validarNumeroNull},
			{"title":"Neto","data":"neto_pagar","width":"4%","render":validarNumeroNull}
        ],
        "ordering": false,
        select: true,
    } );    
}

function cargarCombos(){
    $.ajax({
        type: "get",
        url: "./comboCliente",
        success: function (data) {
            var selectList = document.getElementById("cliente");
            var option = document.createElement('option');
		    option.value = "";
		    option.text = "Seleccione...";
		    selectList.appendChild(option);
            for (var i = 0; i < data.length; i++) {
                option = document.createElement("option");
                option.value = data[i].id;
                option.text = data[i].nombre;
                selectList.appendChild(option);
            }    
        },
        error: function(error){
        }
    });
    $.ajax({
        type: "get",
        url: "./comboVehiculo",
        success: function (data) {
            var selectList = document.getElementById("vehiculo");
            var option = document.createElement('option');
		    option.value = "";
		    option.text = "Seleccione...";
		    selectList.appendChild(option);
            for (var i = 0; i < data.length; i++) {
                option = document.createElement("option");
                option.value = data[i].id;
                option.text = data[i].nombre;
                selectList.appendChild(option);
            }    
        },
        error: function(error){
        }
    });
    $.ajax({
        type: "get",
        url: "./comboTrabajador",
        success: function (data) {
            var selectList = document.getElementById("chofer");
            var option = document.createElement('option');
		    option.value = "";
		    option.text = "Seleccione...";
		    selectList.appendChild(option);
            for (var i = 0; i < data.length; i++) {
                option = document.createElement("option");
                option.value = data[i].id;
                option.text = data[i].nombre;
                selectList.appendChild(option);
            }    
        },
        error: function(error){
        }
    });  
    $.ajax({
        type: "get",
        url: "./comboTrabajador",
        success: function (data) {
            var selectList = document.getElementById("estibador");
            var option = document.createElement('option');
		    option.value = "";
		    option.text = "Seleccione...";
		    selectList.appendChild(option);
            for (var i = 0; i < data.length; i++) {
                option = document.createElement("option");
                option.value = data[i].id;
                option.text = data[i].nombre;
                selectList.appendChild(option);
            }    
        },
        error: function(error){
        }
    });
}

function limpiarFormulario(){
    $("#idServicio").val("");
	$("#nroServicio").val("");
	$("#fecha").val("");
	$("#cliente").val("").trigger('change');
	$("#tipoServicio").val("");
	$("#vehiculo").val("").trigger('change');
	$("#chofer").val("").trigger('change');
	$("#estibador").val("").trigger('change');
	$("#kmInicial").val("");
	$("#kmFinal").val("");
	$("#estado").val("");
	$("#subtotal").val("");
	$("#total").val("");
	$("#factura").val("");
	$("#guia").val("");
}

function nuevoServicio(){
    limpiarFormulario();
    $('#tablaFactura').DataTable().clear().draw();
    $('#tablaGuia').DataTable().clear().draw();
    $("#nroServicio").focus();
	$("#modalServicio").modal('show');
}

function guardarServicio(){
    var facturas="";	
	$('#tablaFactura').DataTable()
    .rows( function ( idx, data, node ) {
    	try {
			facturas = facturas+data.nro_factura+",";			
		} catch (e) {
		}       
    } );	
	$('#facturas').val(facturas);
	var guias="";	
	$('#tablaGuia').DataTable()
    .rows( function ( idx, data, node ) {
    	try {
			guias = guias+data.nro_guia+",";			
		} catch (e) {
		}       
    } );	
	$('#guias').val(guias);
    
    var data = $("#formServicio").serialize();
    $.ajax({
        type: "post",
        url: "./grabarServicio",
        data: data,
        success: function (data) {
            $('#planilla').DataTable().ajax.reload();
            $("#cerrarServicio").click();
            swal("Se guardo correctamente", "", "success");
        },
        error: function(error){
            swal("No se guardo!", "Hubo un error...", "error");
        }
    });    
}

function editarServicio(){
    var dataSeleccionada=$('#planilla').DataTable().rows('.selected').data();
    if(dataSeleccionada.length == '1'){
        $.each(dataSeleccionada, function(index, value){
            try {
                id=value.id;
            } 
            catch (e) {
            }
        }); 
        $.ajax({
            type: "post",
            url: "./obtenerServicio",
            data: {id: id},
            success: function (data) {
                $('#tablaFactura').DataTable().clear().draw();
                $('#tablaGuia').DataTable().clear().draw();
                $("#idServicio").val(data.servicio_id);
                $("#nroServicio").val(data.nro_servicio);
                $("#fecha").val(formatearFecha(data.fecha,null,null));
            	$("#cliente").val(data.cliente_id).trigger('change');
            	$("#tipoServicio").val(data.tipo);
            	$("#vehiculo").val(data.vehiculo_id).trigger('change');
            	$("#chofer").val(data.conductor_id).trigger('change');
            	$("#estibador").val(data.estibador_id).trigger('change');
            	$("#kmInicial").val(data.km_inicial);
            	$("#kmFinal").val(data.km_final);
            	$("#estado").val(data.estado);
            	$("#subtotal").val(data.subtotal);
            	$("#total").val(data.total);
            	$("#costoProv").val(data.costo_proveedor);
            	$("#facturaProv").val(data.factura_proveedor);
            	$("#factura").val("");
	            $("#guia").val("");
	            $('#facturas').val(data.facturas);
	            $('#guias').val(data.guias);
	            arrayFacturas=[];
                var facturas = data.facturas.split(",");
                $.each(facturas, function(index, value){
                    if(value!=""){
                        var factura = {nro_factura:value};
	                    arrayFacturas.push(factura);
                    }
                }); 
	            $('#tablaFactura').DataTable().rows.add(arrayFacturas).draw();
	            arrayGuias=[];
                var guias = data.guias.split(",");
                $.each(guias, function(index, value){
                    if(value!=""){
                        var guia = {nro_guia:value};
	                    arrayGuias.push(guia);
                    }
                }); 
	            $('#tablaGuia').DataTable().rows.add(arrayGuias).draw();
                $("#modalServicio").modal('show');
            },
            error: function(error){
                swal("No se cargo el servicio!", "Hubo un error...", "error");
            }
        });
    }
}

function eliminarServicio(){
    var dataSeleccionada=$('#planilla').DataTable().rows('.selected').data();
    if(dataSeleccionada.length == '1'){
        $.each(dataSeleccionada, function(index, value){
            try {
                id=value.id;
            } 
            catch (e) {
            }
        }); 
        swal({
            title: "Estas seguro?",
            text: "Si eliminas el servicio no se podra recuperar",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    type: "post",
                    url: "./eliminarServicio",
                    data: {id: id},
                    success: function (data) {
                        $('#planilla').DataTable().ajax.reload();
                        swal("El servicio ha sido eliminado", "", "success");
                    },
                    error: function(error){
                        swal("No se pudo eliminar", "Hubo un error...", "error");
                    }
                });             
            } 
        });
    }
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

function formatearAfp(data, type, row ){
	var estado=data;
	if(data==null){
        estado="ONP";
	}
	return estado;	
}

function calcularTotal(){
    var subtotal=parseFloat(validarNumeroNull($("#subtotal").val()).replace(/,/g, "")).toFixed(2);
    var total=parseFloat(subtotal)+parseFloat(subtotal*0.18);
    $('#total').val(formatearMonto(total.toFixed(2)));		
}

function validarNumeroNull(valor){
	var valorReal="0.00";
	if(valor!=null &&  typeof valor != 'undefined' && String(valor).trim()!= ""){
		valorReal=valor;
	}
	return valorReal;
}

function formatearMonto(valor){
	var numeroFormateado="";
	if(valor!=null){
		numeroFormateado=accounting.formatMoney(valor,{symbol : "",thousand : ",",decimal : ".",});	
	}
	return  numeroFormateado;
}

function crearDataTable(idTablaReal,data,columnas){
	var dt=$('#'+idTablaReal).DataTable({
	        language: {
                url: './jl/datatables/language/Spanish.json'
            },
	        data: data,
	        paging: false,
	     	lengthChange: false,
	     	searching: false,
	     	responsive:false,
	     	fixedHeader: true,
	     	bInfo: false,
	        columns:columnas
	 });
	dt.on( 'order.dt search.dt', function () {
		 dt.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
	            cell.innerHTML = i+1;
	        } );
	 } ).draw();
	try {
		new $.fn.dataTable.FixedHeader(dt, {
	        "alwaysCloneTop": true
		});
	} catch (e) {
	}
}

function agregarFactura(){
    var factura = $("#factura").val();
    $.ajax({
        type: "post",
        url: "./obtenerPorNroFactura",
        data: {factura: factura},
        success: function (data) {
            if(data!=""){
                var agregar=true;
                $('#tablaFactura').DataTable()
                .rows( function ( idx, dataTabla, node ) {
                    if(dataTabla.nro_factura==data.nro_factura){
                        agregar=false;    
                    }
                } );	
                if(agregar){
                    $('#tablaFactura').DataTable().row.add(data).draw();
                }
            }
            else{
               swal("No se encontro la factura!", "", "error"); 
            }
        },
        error: function(error){
            swal("No se encontro la factura!", "", "error");
        }
    }); 
}

function columnasFactura(){
	var columnas=[ { title: "#",data:null,"width": "2%"},
	               { title: "Nro. Factura",data:"nro_factura","width": "6%" },
			       { title: "Accion",data:null,render:  eliminarFactura,"width": "4%" }
			     ];
	return columnas;
}

function eliminarFactura(data, type, row ){
	var html="";
	html+="&nbsp;";
	html+="&nbsp;";
	html+="<a class='btn btn-danger' href='javascript:void(0);' role='button' title='Eliminar' id='idButtonEliminarFactura'" +
			"onclick='quitarFactura(\""+data.nro_factura+"\")'><i class='fas fa-trash-alt'></i></a>";
	return html;
}

function quitarFactura(nro_factura){
	$('#tablaFactura').DataTable()
    .rows( function ( idx, data, node ) {
        return data.nro_factura === nro_factura;
    } )
    .remove()
    .draw();
}

function agregarGuia(){
    var guia = $("#guia").val();
    $.ajax({
        type: "post",
        url: "./obtenerPorNroGuia",
        data: {guia: guia},
        success: function (data) {
            if(data!=""){
                var agregar=true;
                $('#tablaGuia').DataTable()
                .rows( function ( idx, dataTabla, node ) {
                    if(dataTabla.nro_guia==data.nro_guia){
                        agregar=false;    
                    }
                } );	
                if(agregar){
                    $('#tablaGuia').DataTable().row.add(data).draw();
                }
            }
            else{
               swal("No se encontro la guia!", "", "error"); 
            }
        },
        error: function(error){
            swal("No se encontro la guia!", "", "error");
        }
    }); 
}

function columnasGuia(){
	var columnas=[ { title: "#",data:null,"width": "2%"},
	               { title: "Nro. Guia",data:"nro_guia","width": "6%" },
			       { title: "Accion",data:null,render:  eliminarGuia,"width": "4%" }
			     ];
	return columnas;
}

function eliminarGuia(data, type, row ){
	var html="";
	html+="&nbsp;";
	html+="&nbsp;";
	html+="<a class='btn btn-danger' href='javascript:void(0);' role='button' title='Eliminar' id='idButtonEliminarGuia'" +
			"onclick='quitarGuia(\""+data.nro_guia+"\")'><i class='fas fa-trash-alt'></i></a>";
	return html;
}

function quitarGuia(nro_guia){
	$('#tablaGuia').DataTable()
    .rows( function ( idx, data, node ) {
        return data.nro_guia === nro_guia;
    } )
    .remove()
    .draw();
}

function exportarServicio(nro_guia){
    $("#exportServicio").modal('show');
}