var tabla;
function buscar_all() {

  var capitulo_all = $('#capitulo_all').val() ;
  var nombre_all   = $('#nombre_all').val() ;

  tabla = $("#tabla-resultado-busqueda").dataTable({
    responsive: true,
    lengthMenu: [[ -1, 5, 10, 25, 75, 100, 200,], ["Todos", 5, 10, 25, 75, 100, 200, ]], //mostramos el menú de registros a revisar
    aProcessing: true, //Activamos el procesamiento del datatables
    aServerSide: true, //Paginación y filtrado realizados por el servidor
    dom: "<Bl<f>rtip>", //Definimos los elementos del control de tabla
    buttons: [
      { extend: 'copyHtml5', footer: true, exportOptions: { columns: [0,2,10,4,5,11,7,8], } }, 
      { extend: 'excelHtml5', footer: true, exportOptions: { columns: [0,2,10,4,5,11,7,8], } }, 
      { extend: 'pdfHtml5', footer: false, orientation: 'landscape', pageSize: 'LEGAL', exportOptions: { columns: [0,2,10,4,5,11,7,8], } },      
    ],
    ajax: {
      url: `ajax/buscador_colegiado.php?op=buscar&capitulo=${capitulo_all}&nombre=${nombre_all}&tipo_busqueda=all`,
      type: "get",
      dataType: "json",
      error: function (e) {
        console.log(e.responseText); ver_errores(e);
      },
    },
    createdRow: function (row, data, ixdex) {         
      // columna: #
      if (data[0] != '') { $("td", row).eq(0).addClass("text-center"); } 
      // columna: op
      if (data[1] != '') { $("td", row).eq(1).addClass("text-nowrap"); }
      // columna: nombres
      if (data[2] != '') { $("td", row).eq(2).addClass("w-100px"); }
      // columna: estado
      if (data[5] != '') { $("td", row).eq(5).addClass("text-nowrap"); }
    },
    language: {
      lengthMenu: "Mostrar: _MENU_ registros",
      buttons: { copyTitle: "Tabla Copiada", copySuccess: { _: "%d líneas copiadas", 1: "1 línea copiada", }, },
      sLoadingRecords: '<i class="fas fa-spinner fa-pulse fa-lg"></i> Cargando datos...'
    },
    bDestroy: true,
    iDisplayLength: 10, //Paginación
    order: [[0, "asc"]], //Ordenar (columna,orden)
    columnDefs: [
      // { targets: [10,11], visible: false, searchable: false, },
      // { targets: [7], render: function (data, type) { var number = $.fn.dataTable.render.number(',', '.', 2).display(data); if (type === 'display') { let color = 'numero_positivos'; if (data < 0) {color = 'numero_negativos'; } return `<span class="float-left">S/</span> <span class="float-right ${color} "> ${number} </span>`; } return number; }, },
    ],
  }).DataTable();
}

function buscar_nombre() {
  
  var capitulo_nombre = $('#capitulo_nombre').val() ;
  var nombre_nombre   = $('#nombre_nombre').val() ;

  tabla = $("#tabla-resultado-busqueda").dataTable({
    responsive: true,
    lengthMenu: [[ -1, 5, 10, 25, 75, 100, 200,], ["Todos", 5, 10, 25, 75, 100, 200, ]], //mostramos el menú de registros a revisar
    aProcessing: true, //Activamos el procesamiento del datatables
    aServerSide: true, //Paginación y filtrado realizados por el servidor
    dom: "<Bl<f>rtip>", //Definimos los elementos del control de tabla
    buttons: [
      { extend: 'copyHtml5', footer: true, exportOptions: { columns: [0,2,10,4,5,11,7,8], } }, 
      { extend: 'excelHtml5', footer: true, exportOptions: { columns: [0,2,10,4,5,11,7,8], } }, 
      { extend: 'pdfHtml5', footer: false, orientation: 'landscape', pageSize: 'LEGAL', exportOptions: { columns: [0,2,10,4,5,11,7,8], } },      
    ],
    ajax: {
      url: `ajax/buscador_colegiado.php?op=buscar&capitulo=${capitulo_nombre}&nombre=${nombre_nombre}&tipo_busqueda=nombre`,
      type: "get",
      dataType: "json",
      error: function (e) {
        console.log(e.responseText); ver_errores(e);
      },
    },
    createdRow: function (row, data, ixdex) {         
      // columna: #
      if (data[0] != '') { $("td", row).eq(0).addClass("text-center"); } 
      // columna: op
      if (data[1] != '') { $("td", row).eq(1).addClass("text-nowrap"); }
      // columna: nombres
      // if (data[2] != '') { $("td", row).eq(2).addClass("w-100px"); }
      // columna: estado
      if (data[5] != '') { $("td", row).eq(5).addClass("text-nowrap"); }
    },
    language: {
      lengthMenu: "Mostrar: _MENU_ registros",
      buttons: { copyTitle: "Tabla Copiada", copySuccess: { _: "%d líneas copiadas", 1: "1 línea copiada", }, },
      sLoadingRecords: '<i class="fas fa-spinner fa-pulse fa-lg"></i> Cargando datos...'
    },
    bDestroy: true,
    iDisplayLength: 10, //Paginación
    order: [[0, "asc"]], //Ordenar (columna,orden)
    columnDefs: [
      // { targets: [10,11], visible: false, searchable: false, },
      // { targets: [7], render: function (data, type) { var number = $.fn.dataTable.render.number(',', '.', 2).display(data); if (type === 'display') { let color = 'numero_positivos'; if (data < 0) {color = 'numero_negativos'; } return `<span class="float-left">S/</span> <span class="float-right ${color} "> ${number} </span>`; } return number; }, },
    ],
  }).DataTable();

  $('.div-resultado').show();
}

function buscar_cip() {
  
  var capitulo_cip = $('#capitulo_cip').val() ;
  var nombre_cip   = $('#nombre_cip').val() ;

  tabla = $("#tabla-resultado-busqueda").dataTable({
    responsive: true,
    lengthMenu: [[ -1, 5, 10, 25, 75, 100, 200,], ["Todos", 5, 10, 25, 75, 100, 200, ]], //mostramos el menú de registros a revisar
    aProcessing: true, //Activamos el procesamiento del datatables
    aServerSide: true, //Paginación y filtrado realizados por el servidor
    dom: "<Bl<f>rtip>", //Definimos los elementos del control de tabla
    buttons: [
      { extend: 'copyHtml5', footer: true, exportOptions: { columns: [0,2,10,4,5,11,7,8], } }, 
      { extend: 'excelHtml5', footer: true, exportOptions: { columns: [0,2,10,4,5,11,7,8], } }, 
      { extend: 'pdfHtml5', footer: false, orientation: 'landscape', pageSize: 'LEGAL', exportOptions: { columns: [0,2,10,4,5,11,7,8], } },      
    ],
    ajax: {
      url: `ajax/buscador_colegiado.php?op=buscar&capitulo=${capitulo_cip}&nombre=${nombre_cip}&tipo_busqueda=cip`,
      type: "get",
      dataType: "json",
      error: function (e) {
        console.log(e.responseText); ver_errores(e);
      },
    },
    createdRow: function (row, data, ixdex) {         
      // columna: #
      if (data[0] != '') { $("td", row).eq(0).addClass("text-center"); } 
      // columna: op
      if (data[1] != '') { $("td", row).eq(1).addClass("text-nowrap"); }
      // columna: nombres
      // if (data[2] != '') { $("td", row).eq(2).addClass("text-nowrap"); }
      // columna: estado
      if (data[5] != '') { $("td", row).eq(5).addClass("text-nowrap"); }
    },
    language: {
      lengthMenu: "Mostrar: _MENU_ registros",
      buttons: { copyTitle: "Tabla Copiada", copySuccess: { _: "%d líneas copiadas", 1: "1 línea copiada", }, },
      sLoadingRecords: '<i class="fas fa-spinner fa-pulse fa-lg"></i> Cargando datos...'
    },
    bDestroy: true,
    iDisplayLength: 10, //Paginación
    order: [[0, "asc"]], //Ordenar (columna,orden)
    columnDefs: [
      // { targets: [10,11], visible: false, searchable: false, },
      // { targets: [7], render: function (data, type) { var number = $.fn.dataTable.render.number(',', '.', 2).display(data); if (type === 'display') { let color = 'numero_positivos'; if (data < 0) {color = 'numero_negativos'; } return `<span class="float-left">S/</span> <span class="float-right ${color} "> ${number} </span>`; } return number; }, },
    ],
  }).DataTable();

  $('.div-resultado').show();
}

function buscar_dni() {
  
  var capitulo_dni = $('#capitulo_dni').val() ;
  var nombre_dni   = $('#nombre_dni').val();

  tabla = $("#tabla-resultado-busqueda").dataTable({
    responsive: true,
    lengthMenu: [[ -1, 5, 10, 25, 75, 100, 200,], ["Todos", 5, 10, 25, 75, 100, 200, ]], //mostramos el menú de registros a revisar
    aProcessing: true, //Activamos el procesamiento del datatables
    aServerSide: true, //Paginación y filtrado realizados por el servidor
    dom: "<Bl<f>rtip>", //Definimos los elementos del control de tabla
    buttons: [
      { extend: 'copyHtml5', footer: true, exportOptions: { columns: [0,2,10,4,5,11,7,8], } }, 
      { extend: 'excelHtml5', footer: true, exportOptions: { columns: [0,2,10,4,5,11,7,8], } }, 
      { extend: 'pdfHtml5', footer: false, orientation: 'landscape', pageSize: 'LEGAL', exportOptions: { columns: [0,2,10,4,5,11,7,8], } },      
    ],
    ajax: {
      url: `ajax/buscador_colegiado.php?op=buscar&capitulo=${capitulo_dni}&nombre=${nombre_dni}&tipo_busqueda=dni`,
      type: "get",
      dataType: "json",
      error: function (e) {
        console.log(e.responseText); ver_errores(e);
      },
    },
    createdRow: function (row, data, ixdex) {         
      // columna: #
      if (data[0] != '') { $("td", row).eq(0).addClass("text-center"); } 
      // columna: op
      if (data[1] != '') { $("td", row).eq(1).addClass("text-nowrap"); }
      // columna: nombres
      // if (data[2] != '') { $("td", row).eq(2).addClass("text-nowrap"); }
      // columna: estado
      if (data[5] != '') { $("td", row).eq(5).addClass("text-nowrap"); }
    },
    language: {
      lengthMenu: "Mostrar: _MENU_ registros",
      buttons: { copyTitle: "Tabla Copiada", copySuccess: { _: "%d líneas copiadas", 1: "1 línea copiada", }, },
      sLoadingRecords: '<i class="fas fa-spinner fa-pulse fa-lg"></i> Cargando datos...'
    },
    bDestroy: true,
    iDisplayLength: 10, //Paginación
    order: [[0, "asc"]], //Ordenar (columna,orden)
    columnDefs: [
      // { targets: [10,11], visible: false, searchable: false, },
      // { targets: [7], render: function (data, type) { var number = $.fn.dataTable.render.number(',', '.', 2).display(data); if (type === 'display') { let color = 'numero_positivos'; if (data < 0) {color = 'numero_negativos'; } return `<span class="float-left">S/</span> <span class="float-right ${color} "> ${number} </span>`; } return number; }, },
    ],
  }).DataTable();

  $('.div-resultado').show();
}

function ver_perfil_colegiado(ruta, nombre) {
  $('#title-name-modal').html(nombre);
  $('#div-ver-perfil').html( `<img src="${ruta}" alt="" width="100%" onerror="this.src='dist/svg/user_default.svg';" >` );
  $('#modal-ver-perfil').modal('show');
}

function detalle_colegiado(id) {
  console.log("id "+id);    
  $('#modal-ver-detalle-colegiado').modal('show');
  $('#div-html-lista-experiencia').html(`<div class="col-lg-12 text-center"><i class="fas fa-spinner fa-pulse fa-6x"></i><br/><br/><h4>Cargando...</h4></div>`);
  $(".tooltip").removeClass("show").addClass("hidde");   

  $.post("ajax/buscador_colegiado.php?op=ver_detalle_colegiado", { 'id':id }, function (e, status) {

    e = JSON.parse(e);  console.log(e);   

    if (e.status == true) { 

      var data_html = "";

      if (e.data.length === 0) {

        $('#div-html-lista-experiencia').html("─ No tiene actualizado su experiencia laboral.");

      } else {

        e.data.forEach((val, key) => {

          var fecha_fin = val.trabajo_actual == '0' ? `${moment(val.fecha_inicio).format('DD')} ${extraer_nombre_mes_abreviados(val.fecha_inicio)} ${moment(val.fecha_inicio).format('YYYY')}`: 'Actual' ;

          var certificado = val.certificado == '' || val.certificado == null  ? `<button class="btn btn-outline-info btn-sm" data-toggle="tooltip" data-original-title="Vacio"><i class="fa fa-file-pdf-o fa-2x"></i></button>`:  `<a href="admin/dist/docs/experiencia_laboral/certificado/${val.certificado}" class="btn btn-info btn-sm" target="_blank" data-toggle="tooltip" data-original-title="Ver doc"><i class="fa fa-file-pdf-o fa-2x"></i></a>`;

          data_html = data_html.concat(`
            <div class="col-12 text-center m-b-10px">
              <span class="text-success font-size-17px">${moment(val.fecha_inicio).format('DD')} ${extraer_nombre_mes_abreviados(val.fecha_inicio)} ${moment(val.fecha_inicio).format('YYYY')}</span> &nbsp; al &nbsp; <span class="text-success font-size-17px">${fecha_fin}</span>
            </div>
            <div class="col-6">
              <div class="row">                
                <div class="col-12">
                  DATOS DEL COLEGIADO
                </div>
                <div class="col-12">
                  <!-- card -->
                  <div class="card" style="margin: 5px;">
                    <div class="card-body">
                      <div class="mt-1"><span class="text-bold">Fecha Inicio: </span> ${format_d_m_a(val.fecha_inicio)} </div>
                      <div class="mt-1"><span class="text-bold">Fecha Fin: </span> ${val.trabajo_actual == '0' ? format_d_m_a(val.fecha_fin) : 'Actual'} </div>
                      <div class="mt-1"><span class="text-bold">Cargo Laboral: </span> ${val.cargo_laboral} </div>
                      <div class="mt-1"><span class="text-bold">Certificado: </span> ${certificado} </div>
                    </div>
                  </div>
                  <!-- card -->
                </div>
              </div>                  
            </div>
            <div class="col-6">
              <div class="row">
                <div class="col-12">
                  DATOS DEL LA EMPRESA
                </div>
                <div class="col-12">
                  <!-- card -->
                  <div class="card" style="margin: 5px;">
                    <div class="card-body">
                      <div class="mt-1"><span class="text-bold">Razon Social: </span> ${val.razon_social} </div>
                      <div class="mt-1"><span class="text-bold">RUC: </span> ${val.ruc} </div>
                      <div class="mt-1"><span class="text-bold">Celular: </span> ${val.celular} </div> 
                      <div class="mt-1"><span class="text-bold">Dirección: </span> ${val.direccion} </div>
                      <div class="mt-1"><span class="text-bold">Correo: </span><a href="mailto:${val.correo}">${val.correo}</a></div>   
                    </div>
                  </div>
                  <!-- card -->
                </div>
              </div>                  
            </div>
            <div class="col-12">
              <hr style="background-color: #fa001f;height: 2px;margin: 5px;">
            </div>       
          `);
        }); 

        $('#div-html-lista-experiencia').html(`${data_html}`);
      }      

      $('[data-toggle="tooltip"]').tooltip();

    } else {
      ver_errores(e);
    }    
  }).fail( function(e) { ver_errores(e); } );
}

// ::::::::::::::::::::::::::: ver detalle :::::::::::::::::::::::::::::

function ver_detalle_colegiado(id) {
  
}


$(function () {

  // $('#unidad_medida').on('change', function() { $(this).trigger('blur'); });

  $.validator.addMethod("regex", function(value, element, regexp) { var re = new RegExp(regexp); return this.optional(element) || re.test(value); },"Ingrese Solo texto, lo <b>números NO</b> estan permitidos." );

  $("#form-buscar-all").validate({
    rules: {
      capitulo_all: { required: true, },
      nombre_all:   { required: true, minlength:2, maxlength:40 },      
    },
    messages: {
      capitulo_all: { required: "Campo requerido", },
      nombre_all:   { required: "Campo requerido",  minlength:"Minimo 2 caracteres", maxlength:"Maximo 200 caracteres"}, 
    },

    errorElement: "span",

    errorPlacement: function (error, element) { error.addClass("invalid-feedback"); element.closest(".form-group").append(error); },

    highlight: function (element, errorClass, validClass) { $(element).addClass("is-invalid").removeClass("is-valid"); },

    unhighlight: function (element, errorClass, validClass) { $(element).removeClass("is-invalid").addClass("is-valid"); },

    submitHandler: function (e) {
      $(".modal-body").animate({ scrollTop: $(document).height() }, 600); // Scrollea hasta abajo de la página
      buscar_all(e);
    },
  });

  $("#form-buscar-nombre").validate({
    rules: {
      capitulo_nombre: { required: true, },
      nombre_nombre:   { required: true, minlength:2, maxlength:40 },      
    },
    messages: {
      capitulo_nombre: { required: "Campo requerido", },
      nombre_nombre:   { required: "Campo requerido",  minlength:"Minimo 2 caracteres", maxlength:"Maximo 200 caracteres"}, 
    },

    errorElement: "span",

    errorPlacement: function (error, element) { error.addClass("invalid-feedback"); element.closest(".form-group").append(error); },

    highlight: function (element, errorClass, validClass) { $(element).addClass("is-invalid").removeClass("is-valid"); },

    unhighlight: function (element, errorClass, validClass) { $(element).removeClass("is-invalid").addClass("is-valid"); },
    
    submitHandler: function (e) {
      $(".modal-body").animate({ scrollTop: $(document).height() }, 600); // Scrollea hasta abajo de la página
      buscar_nombre(e);
    },
  });

  $("#form-buscar-cip").validate({
    rules: {
      capitulo_cip: { required: true, },
      nombre_cip:   { required: true, minlength:2, maxlength:50, number: true, },      
    },
    messages: {
      capitulo_cip: { required: "Campo requerido", },
      nombre_cip:   { required: "Campo requerido", number: 'Ingrese un número', minlength:"Minimo 8 caracteres", maxlength:"Maximo 8 caracteres"}, 
    },

    errorElement: "span",

    errorPlacement: function (error, element) { error.addClass("invalid-feedback"); element.closest(".form-group").append(error); },

    highlight: function (element, errorClass, validClass) { $(element).addClass("is-invalid").removeClass("is-valid"); },

    unhighlight: function (element, errorClass, validClass) { $(element).removeClass("is-invalid").addClass("is-valid"); },
    
    submitHandler: function (e) {
      $(".modal-body").animate({ scrollTop: $(document).height() }, 600); // Scrollea hasta abajo de la página
      buscar_cip(e);
    },
  });

  $("#form-buscar-dni").validate({
    rules: {
      capitulo_dni: { required: true, },
      nombre_dni:   { required: true, number: true, minlength:8, maxlength:8 },      
    },
    messages: {
      capitulo_dni: { required: "Campo requerido", },
      nombre_dni:   { required: "Campo requerido",number: 'Ingrese un número',  minlength:"Minimo 8 caracteres", maxlength:"Maximo 8 caracteres"}, 
    },

    errorElement: "span",

    errorPlacement: function (error, element) { error.addClass("invalid-feedback"); element.closest(".form-group").append(error); },

    highlight: function (element, errorClass, validClass) { $(element).addClass("is-invalid").removeClass("is-valid"); },

    unhighlight: function (element, errorClass, validClass) { $(element).removeClass("is-invalid").addClass("is-valid"); },
    
    submitHandler: function (e) {
      $(".modal-body").animate({ scrollTop: $(document).height() }, 600); // Scrollea hasta abajo de la página
      buscar_dni(e);
    },
  });

  $("#nombre_nombre").rules("add", { regex: /^[a-zA-Z ]+$/ })

  // $('#unidad_medida').rules('add', { required: true, messages: {  required: "Campo requerido" } });
});
