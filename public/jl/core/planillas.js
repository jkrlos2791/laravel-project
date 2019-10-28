$(document).ready(function(){
    //listar();
    crearDataTable("planilla",null,columnasPlanillas());
    cargarPlanillas();
    crearDataTable("liquidacion",null,columnasLiquidaciones());
    cargarLiquidaciones();
	cargarCombos();
	$("#exportar").click(function(){exportar();});
    //$("#guardarEmpleado").click(function(){guardarEmpleado();});
});

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

function columnasPlanillas(){
	var columnas=[			    
	        { title: "#",data:null,"width": "2%",orderable:false},
            {"title":"Nro. Doc.","data":"num_doc","width":"4%",orderable:false},
            {"title":"Nombres","data":"nombres","width":"14%"},
            {"title":"C.C.","data":"centro_costo","width":"8%"},
            {"title":"Tipo AFP","data":"afp","width":"4%","render":formatearAfp,orderable:false},
            {"title":"CUSSP","data":"cussp","width":"4%",orderable:false},
            {"title":"Ingresos","data":"total_ingresos","width":"4%","render":formatearMonto},
			{"title":"Descuentos","data":"total_descuentos","width":"4%","render":formatearMonto},
			{"title":"Neto","data":"neto_pagar","width":"4%","render":formatearMonto}
			     ];
	return columnas;
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

function columnasLiquidaciones(){
	var columnas=[			    
	        { title: "#",data:null,"width": "2%",orderable:false},
            {"title":"Nro. Doc.","data":"num_doc","width":"4%",orderable:false},
            {"title":"Nombres","data":"nombres","width":"14%"},
            {"title":"C.C.","data":"centro_costo","width":"8%"},
            {"title":"Tipo AFP","data":"afp","width":"4%","render":formatearAfp,orderable:false},
            {"title":"CUSSP","data":"cussp","width":"4%",orderable:false},
            {"title":"Fecha Ingreso","data":"fecha_ingreso","width":"4%","render":formatearFecha},
			{"title":"Fecha Cese","data":"fecha_cese","width":"4%","render":formatearFecha},
			{"title":"Tiempo Computable","data":"tiempo_computable","width":"4%"},
			{ title: "Accion",data:null,render: mostrarLiquidacion,"width": "4%" },
			     ];
	return columnas;
}

function mostrarLiquidacion(data, type, row ){
	var html="";
	html+="&nbsp;";
	html+="&nbsp;";
	html+="<a class='btn btn-dark' href='descargar_liquidacion/"+data.id+"' role='button' title='Ver Liquidacion' id='idButtonDescargaLiquidacion'" +
			"target='_blank'><i class='fas fa-file-pdf'></i></a>";
	return html;
}

function cargarPlanillas(){
	$.ajax({
        type: "get",
        url: "./listarPlanillas",
        success: function (data) {
			if(data!=""){
				$('#planilla').DataTable().clear().draw();
				$('#planilla').DataTable().rows.add(data).draw();
			}
        },
        error: function(error){
        }
    });
}

function cargarLiquidaciones(){
	$.ajax({
        type: "get",
        url: "./listarLiquidaciones",
        success: function (data) {
			if(data!=""){
				$('#liquidacion').DataTable().clear().draw();
				$('#liquidacion').DataTable().rows.add(data).draw();
			}
        },
        error: function(error){
        }
    });
}

function listar(){
    var dt=$('#planilla').DataTable( {
        language: {
        url: './jl/datatables/language/Spanish.json'
        },
        "pageLength": 8,
        "ajax": {
            "url": "./listarPlanillas",
            "dataSrc": ""
        },
        "columns": [
			{ title: "#",data:null,"width": "2%",orderable:false},
            {"title":"Nro. Doc.","data":"num_doc","width":"4%",orderable:false},
            {"title":"Nombres","data":"nombres","width":"14%"},
            {"title":"C.C.","data":"centro_costo","width":"8%"},
            {"title":"Tipo AFP","data":"afp","width":"4%","render":formatearAfp,orderable:false},
            {"title":"CUSSP","data":"cussp","width":"4%",orderable:false},
            {"title":"Ingresos","data":"total_ingresos","width":"4%","render":formatearMonto},
			{"title":"Descuentos","data":"total_descuentos","width":"4%","render":formatearMonto},
			{"title":"Neto","data":"neto_pagar","width":"4%","render":formatearMonto}
        ],
        select: true,
    } );   
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

function validarNumeroNull(valor){
	var valorReal="0.00";
	if(valor!=null &&  typeof valor != 'undefined' && String(valor).trim()!= ""){
		valorReal=valor;
	}
	return valorReal;
}

function formatearMonto(valor){
	var numeroFormateado="0.00";
	if(valor!=null){
		numeroFormateado=accounting.formatMoney(valor,{symbol : "",thousand : ",",decimal : ".",});	
	}
	return  numeroFormateado;
}

function exportar(){
	$("#exportPlanilla").modal('show');
}

function cargarCombos(){
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
                option.value = data[i].centro_costo;
                option.text = data[i].centro_costo;
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
}