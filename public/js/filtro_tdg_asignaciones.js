// Declarar variables globales
var lenguaje_datatable;

$(document).ready(function(){
    // Variable del idioma para la datatable
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

    // Al cargar la página que la tabla esté sin información
    //cargarDataTable();
      

    // Cargar datos a la tabla
    cargarDatosTdg();
});

// Al dar click en buscar que se actualicé la tabla
$(document).on("click", "#btn-filtro-buscar", function(){
    cargarDatosTdg();
});

// Al dar click en buscar que se limpien los campos de codigo y nombre y se regresan los datos sin filtro
$(document).on("click", "#btn-filtro-limpiar-busqueda", function(){
    $("#txt-filtro-codigo").val("");
    $("#txt-filtro-nombre").val("");
    cargarDatosTdg();
});

// Al seleccionar un tipo de solicitud que se actualice la tabla con los TDG aptos para esa solicitud
$(document).on("change", "#select-filtro-solicitud", function(){
    //alert($(this).val());
    cargarDatosTdg();
});

// Función para llenar la tabla TDG
function cargarDatosTdg() {

    // Inicializar variables
    var codigo = '';
    var nombre = '';

    // Obtener valores de los input
    var txt_filter_codigo = $("#txt-filtro-codigo").val();
    var txt_filter_nombre = $("#txt-filtro-nombre").val();
    var filter_escuela_id = $("#filtro-escuela_id").val();

    // Validar si los input no continen nada
    if(txt_filter_codigo != undefined || txt_filter_codigo != '') {
        codigo = txt_filter_codigo;
    }

    if(txt_filter_nombre != undefined || txt_filter_nombre != '') {
        nombre = txt_filter_nombre;
    }

    // Parametros a enviar a la perticion de datos
    var params = {
        escuela_id: filter_escuela_id,
        codigo: codigo,
        nombre: nombre,
    };

    //console.log(params);

    // Ejecutar petición ajax
    axios.get('/todos/tdg/asignaciones', {
        params: params
    }).then(response => {
        //console.log(response.data);
        console.log(response.data);
        response.data.forEach(element => {
            console.log('codigo: '+element[0].codigo);
        });
        if(response.data.length > 0){
            // Llenar la tabla con los resultados traidos de la peticion
            $("#table-filtro-tdgs").DataTable({
        
                "destroy": true,
                "processing": true,
                "data": response.data,
                "ordering": false,
                "pageLength": 10,
                "columns": [
                    { 'data': '0.codigo' },
                    { 'data': '0.nombre' },
                    { sortable: false,
                    "render": function ( data, type, full, meta ) {
                        var id = full[0].id;
                        console.log(id);
                        /// Acá se le va a concatenar dependiendo de que tipo de solicitud es
                        var htmlButtons = `<a href="/ingresar/tdg/asignacion/${id}">Asignar grupo</a>`;
                        return htmlButtons;
                    }},
                ],
                "info": false,
                "searching": false,
                "ordering": false,
                "lengthChange": false,
                "language": lenguaje_datatable,
            });
        } else if(response.data.length == 0) {
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

// Cargar el DataTable sin ningún dato
function cargarDataTable(){
    var table = $("#table-filtro-tdgs").DataTable({
        "destroy": true,
        "processing": true,
        "ordering": false,
        "pageLength": 10,
        "info": false,
        "searching": false,
        "ordering": false,
        "lengthChange": false,
        "language": lenguaje_datatable,
        "columnDefs": [
            { "width": "10%", "targets": 0 },
            { "width": "65%", "targets": 1 },
            { "width": "15%", "targets": 2 },

        ],  
    });

    table
        .clear()
        .draw();
}