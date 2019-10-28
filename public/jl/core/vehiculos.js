$(document).ready(function(){
    listar();
    $(".element-select").select2({
        dropdownParent: $("#modal"),
        width: '225px'
    });
    cargarCombos();
    $("#nuevo").click(function(){nuevo();});
    $("#guardar").click(function(){guardar();});
    $("#editar").click(function(){editar();});
    $("#eliminar").click(function(){eliminar();});
    $("#exportar").click(function(){exportar();});
});

function listar(){
    $('#tabla').DataTable( {
        language: {
        url: './jl/datatables/language/Spanish.json'
        },
        "pageLength": 8,
        "ajax": {
            "url": "./listarVehiculos",
            "dataSrc": ""
        },
        "columns": [
            {data: null,defaultContent:'',className:'select-checkbox',orderable:false,"width":"2%"},
            {"title":"Marca","data":"marca","width":"4%"},
            {"title":"Modelo","data":"modelo","width":"4%"},
            {"title":"Placa","data":"placa","width":"4%"},
            {"title":"Tipo","data":"tipo","width":"8%"},
            {"title":"Carga (TN)","data":"carga","width":"4%"},
            {"title":"Empresa","data":"empresa","width":"14%"}
        ],
        "ordering": false,
        select: true,
    } );    
}

function cargarCombos(){
    $.ajax({
        type: "get",
        url: "./comboAgencia",
        success: function (data) {
            var selectList = document.getElementById("empresa");
            var option = document.createElement('option');
		    option.value = "";
		    option.text = "Seleccione...";
		    selectList.appendChild(option);
            for (var i = 0; i < data.length; i++) {
                option = document.createElement("option");
                option.value = data[i].nombre;
                option.text = data[i].nombre;
                selectList.appendChild(option);
            }    
        },
        error: function(error){
        }
    });
}

function limpiarFormulario(){
    $("#idVehiculo").val("");
	$("#marca").val("");
	$("#modelo").val("");
	$("#placa").val("");
	$("#tipo").val("");
	$("#carga").val("");
	$("#empresa").val("").trigger('change');
}

function nuevo(){
    limpiarFormulario();
    $("#marca").focus();
	$("#modal").modal('show');
}

function guardar(){
    var data = $("#formVehiculo").serialize();
    $.ajax({
        type: "post",
        url: "./grabarVehiculo",
        data: data,
        success: function (data) {
            $('#tabla').DataTable().ajax.reload();
            $("#cerrar").click();
            swal("Se guardo correctamente", "", "success");
        },
        error: function(error){
            swal("No se guardo!", "Hubo un error...", "error");
        }
    });    
}

function editar(){
    var dataSeleccionada=$('#tabla').DataTable().rows('.selected').data();
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
            url: "./obtenerVehiculo",
            data: {id: id},
            success: function (data) {
                $("#idVehiculo").val(data.vehiculo_id);
                $("#marca").val(data.marca);
                $("#modelo").val(data.modelo);
            	$("#placa").val(data.placa);
            	$("#tipo").val(data.tipo);
            	$("#carga").val(data.carga_tn);
            	$("#empresa").val(data.empresa).trigger('change');
                $("#modal").modal('show');
            },
            error: function(error){
                swal("No se cargo la data!", "Hubo un error...", "error");
            }
        });
    }
}

function eliminar(){
    var dataSeleccionada=$('#tabla').DataTable().rows('.selected').data();
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
            text: "Si eliminas el registro no se podra recuperar",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    type: "post",
                    url: "./eliminarVehiculo",
                    data: {id: id},
                    success: function (data) {
                        $('#tabla').DataTable().ajax.reload();
                        swal("El registro ha sido eliminado", "", "success");
                    },
                    error: function(error){
                        swal("No se pudo eliminar", "Hubo un error...", "error");
                    }
                });             
            } 
        });
    }
}

function exportar(){
    $("#exportServicio").modal('show');
}