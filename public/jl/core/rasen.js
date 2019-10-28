$(document).ready(function(){
    crearTabla();
    obtener();
    cargarCombos();
});

var ctx = document.getElementById("myChart");
var config = {
type: "bar",
data: {
    labels: [],
    datasets: [{
        label: "Datos",
        data: [],
        backgroundColor: "rgba(63, 104, 191, 0.64)",
        borderColor: "rgba(63, 104, 191, 1)",
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
};
var myChart = new Chart(ctx, config);

function obtener(){
	$.ajax({
        type: "get",
        url: "./rasenListar",
        success: function (data) {
			if(data!=""){
				$("#rasens").DataTable().clear().draw();
				$("#rasens").DataTable().rows.add(data).draw();
			}
        },
        error: function(error){
        }
    });
}

function crearDataTable(idTablaReal,data,columnas){
	var dt=$("#"+idTablaReal).DataTable({
	        language: {
                url: "./jl/datatables/language/Spanish.json"
            },
	        data: data,
			pageLength: 20,
	     	responsive:false,
	     	fixedHeader: true,
	        columns:columnas,
			select: true,
			scrollX: true,
			scrollY: "200px",
            scrollCollapse: true,
			order: [[ 1, "asc" ]],
	});
	try {
		new $.fn.dataTable.FixedHeader(dt, {
	        "alwaysCloneTop": true
		});
	} catch (e) {
	}
}

var columnas=[];
function crearTabla(){
	$.ajax({
        type: "get",
        url: "./rasenCabecera",
        success: function (data) {
			if(data!=""){
			    columnas.push({ data: null,defaultContent:"",className:"select-checkbox",orderable:false,"width":"2%"});
                for (var i = 0; i < data.length; i++) {
	                columnas.push({ title: data[i],data:data[i],"width": "6%" });
                }
	            crearDataTable("rasens",null,columnas); 
			}
        },
        error: function(error){
        }
    });
}

function cargarCombos(){
	$.ajax({
        type: "get",
        url: "./rasenCabecera",
        success: function (data) {
            var selectList = document.getElementById("campo");
            var option = document.createElement("option");
		    option.value = "";
		    option.text = "Seleccione...";
		    selectList.appendChild(option);
            for (var i = 0; i < data.length; i++) {
                option = document.createElement("option");
                option.value = data[i];
                option.text = data[i];
                selectList.appendChild(option);
            }    
        },
        error: function(error){
        }
    });
}

function refreshData(chart, labels, data, label) {
    chart.data.labels = labels;
    chart.data.datasets[0].label = label;
    chart.data.datasets[0].data = data;
    chart.update();
}

function actualizarChart() {
	$.ajax({
        type: "post",
        url: "./rasenGraficar",
        data: {campo: $("#campo").val()},
        success: function (data) {
            refreshData(myChart, data[0], data[1], $("#campo").val());
        },
        error: function(error){
        }
    });
}

function actualizarTipoChart() {
    if (myChart) {
        myChart.destroy();
    }
    var temp = jQuery.extend(true, {}, config);
    temp.type = $("#tipoChart").val();
    myChart = new Chart(ctx, temp);
    myChart.update();
}