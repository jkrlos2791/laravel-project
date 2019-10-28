$(document).ready(function(){ 
	crearDataTable("conceptos",null,columnas()); 
	$(".element-select-ca").select2({
		dropdownParent: $("#modalSearch"),
        width: '600px'
    }); 
	cargarCombos();
	$("#buscar").click(function(){buscar();});
	$("#buscarPorConcepto").click(function(){buscarPorConcepto();});
	$("#editar").click(function(){editar();});
	$("#cantidad").maskMoney({allowZero:true});
    $("#guardarEditable").click(function(){guardar();});
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
			order: [[ 1, "asc" ]],
	});
	try {
		new $.fn.dataTable.FixedHeader(dt, {
	        "alwaysCloneTop": true
		});
	} catch (e) {
	}
}

function columnas(){
	var columnas=[ 
		{data: null,defaultContent:'',className:'select-checkbox',orderable:false,"width":"2%"},
		{ title: "Nombres",data:"nombres","width": "6%" },
		{ title: "Conceptos",data:"conceptos","width": "6%","render":formatearNumero },
	];
	return columnas;
}

function cargarCombos(){
    $.ajax({
        type: "get",
        url: "./comboConceptos",
        success: function (data) {
            var selectList = document.getElementById("concepto");
            var option = document.createElement('option');
		    option.value = "";
		    option.text = "Seleccione...";
		    selectList.appendChild(option);
            for (var i = 0; i < data.length; i++) {
                option = document.createElement("option");
                option.value = data[i].codigo;
                option.text = data[i].descripcion;
                selectList.appendChild(option);
            }    
        },
        error: function(error){
        }
    });
}

function buscar(){
    $("#modalSearch").modal('show');
}

function buscarPorConcepto(){
    var data = $("#formSearch").serialize();
    $.ajax({
        type: "post",
        url: "./listarPorConcepto",
        data: data,
        success: function (data) {
            if(data!=""){
    			$('#conceptos').DataTable().clear().draw();
    			$('#conceptos').DataTable().rows.add(data).draw();
    			$('#codigoConcepto').val($('#concepto').val());
    			$("#tituloConcepto").html($("#concepto option:selected").text());
                $("#cerrar").click();
            }
            else{
                swal("Sin conceptos", "No existen trabajadores para el periodo", "warning");
            }
        },
        error: function(error){
            swal("No se pudo buscar!", "Hubo un error...", "error");
        }
    });    
}

function editar(){
    var dataSeleccionada=$('#conceptos').DataTable().rows('.selected').data();
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
            url: "./obtenerEditable",
            data: {id: id, codigoConcepto: $('#codigoConcepto').val()},
            success: function (data) {
                $("#idEditable").val(data.planilla_id);
                $("#cantidad").val(data.concepto);
                $("#modalEditable").modal('show');
            },
            error: function(error){
                swal("No se cargo la data!", "Hubo un error...", "error");
            }
        });
    }
}

function guardar(){
    var data = $("#formEditable").serialize();
    $.ajax({
        type: "post",
        url: "./grabarEditable",
        data: data,
        success: function (data) {
			var id=data.id;			
			$('#conceptos').DataTable()
			.rows( function ( idx, data2, node ) {
			return data2.id === id;
			} )
			.remove()
			.draw();
			$('#conceptos').DataTable().row.add(data).draw();		
            $("#cerrarEditable").click();
            swal("Se guardo correctamente", "", "success");
        },
        error: function(error){
            swal("No se guardo!", "Hubo un error...", "error");
        }
    });    
}

function formatearNumero(valor){
	var numeroFormateado="0.00";
	if(valor!=null &&  typeof valor != 'undefined' && String(valor).trim()!= ""){
		numeroFormateado=accounting.formatMoney(valor,{symbol : "",thousand : ",",decimal : ".",});	
	}
	return numeroFormateado;
}