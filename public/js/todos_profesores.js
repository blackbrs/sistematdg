var lenguaje_datatable;
$(document).ready(function() {

    lenguaje_datatable = {
        "decimal": "",
        "emptyTable": "No hay información",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
        "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
        "infoFiltered": "(Filtrado de _MAX_ total entradas)",
        "infoPostFix": "",
        "thousands": ",",
        "lengthMenu": "Mostrar _MENU_ Entradas",
        "loadingRecords": "Cargando...",
        "processing": "Procesando...",
        "search": "Buscar:",
        "zeroRecords": "Sin resultados encontrados",
        "paginate": {
            "first": "Primero",
            "last": "Ultimo",
            "next": "Siguiente",
            "previous": "Anterior"
        }
    };
    //Carar con datos la data table
    cargarDataTable();
    //Cargar los datos
    cargarDatosProfesores();

    if ($.urlParam("save") == 1) {
        Swal.fire(
            'Usuario:',
            "Registrado con éxito!",
            'success'
        );
    } else if ($.urlParam("save") == 2) {

        Swal.fire(
            'Profesor:',
            "Modificado con éxito!",
            'success'
        );
    }

    history.pushState({ data: true }, 'Titulo', '/todos/profesores/sistema');
});

$(document).on("click", "#btn-filtro-buscar", function() {
    cargarDatosProfesores();
});
// Al dar click en buscar que se limpien los campos de codigo y nombre y se regresan los datos sin filtro
$(document).on("click", "#btn-filtro-limpiar-busqueda", function() {

    $("#txt-filtro-nombre").val("");
    $("#txt-filtro-apellido").val("");
    $("#txt-filtro-codigo").val("");
    cargarDatosProfesores();
});

function cargarDatosProfesores() {
// Inicializamos las variables a utilizar
var nombre = '';
var codigo = '';
var apellido = '';
//Obtenemos los datos
var txt_filter_nombre = $("#txt-filtro-nombre").val();
console.log(txt_filter_nombre);
var txt_filter_codigo = $("#txt-filtro-codigo").val();
console.log(txt_filter_nombre);
var txt_filter_apellido = $("#txt-filtro-apellido").val();
console.log(txt_filter_apellido);
// Validamos que los imputs contengan o no informacion
if (txt_filter_nombre != undefined || txt_filter_nombre != '') {
    nombre = txt_filter_nombre;
}
if (txt_filter_codigo != undefined || txt_filter_codigo != '') {
    codigo = txt_filter_codigo;
}if (txt_filter_apellido != undefined || txt_filter_apellido != '') {
    apellido = txt_filter_apellido;
}

// Parametros que se enviaran a la peticion de los datos.
var params = {
    nombre: nombre,
    codigo: codigo,
    apellido: apellido,
}

  //ahora ejecutamos la peticion AJAX

  axios.get('/todos/profesores/ver', {
    params: params
}).then(response => {
    console.log(response.data);
    if (response.data.length > 0) {
        $("#table-filtro-nombres-codigo").DataTable({
            "destroy": true,
            "processing": true,
            "data": response.data,
            "ordering": false,
            "pageLength": 10,
            "columns": [
                { 'data': 'codigo' },
                { 'data': 'nombre'},
                { 'data': 'apellido'},
                {
                    sortable: false,
                    "render": function ( data, type, full, meta ) {

                        // Id del TDG
                        var estado = full.estado; //Cuando haga el filtro tengo que agregar [0]
                        var respuesta = " ";
                        if (estado == 1) {
                            return respuesta = "Activo";
                        } else {
                            return  respuesta ="Inactivo";
                        }


                        }
                },
                {
                    sortable: false,
                    "render": function ( data, type, full, meta ) {
                        var htmlButtons = '';
                        // Id del TDG
                        var id = full.id; //Cuando haga el filtro tengo que agregar [0]
                        //console.log(id);
                        // Concatenar ruta para el formulario

                        // Ruta que lleva como parametro el tipo de solicitud que se va ratificar y el id del tdg

                        var htmlButtons = `<a href="/profesores/${id}/edit"  class=" btn btn-primary btn-past btn-color btn-sm" role="button"><span class="oi oi-pencil"></span>  Editar</a>`;

                        return htmlButtons;
                        }
                },
            ],
            "columnDefs": [
                { "width": "20%", "targets": 0 },
                { "width": "20%", "targets": 1 },
                { "width": "20%", "targets": 2 },
                { "width": "20%", "targets": 3 },
                { "width": "20%", "targets": 4 },
              ],
            "info": false,
            "searching": false,
            "ordering": false,
            "lengthChange": false,
            "language": lenguaje_datatable,
        });
    } else if (response.data.length == 0) {
        cargarDataTable();
    }
}).catch(e => {
    // Imprimir error en consola
    console.log(e);

    // En caso de que no hayan resultados, siempre pasasr la configuración a la tabla
    cargarDataTable()

    // Mostrar mensaje de error en caso de que algo haya salido mal con la consulta
    Swal.fire({
        type: 'error',
        title: 'Oops...',
        text: '¡Algo ha salido mal!, por favor intente más tarde.',
    });
})
}
function cargarDataTable() {
    var table = $("#table-filtro-nombres-codigo").DataTable({
        "destroy": true,
        "processing": true,
        "ordering": false,
        "pageLength": 10,
        "info": false,
        "searching": false,
        "ordering": false,
        "lengthChange": false,
        "language": lenguaje_datatable,
    });

    table
        .clear()
        .draw();
}

$.urlParam = function(name) {
    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
    if (results == null) {
        return null;
    }
    return decodeURI(results[1]) || 0;
}
