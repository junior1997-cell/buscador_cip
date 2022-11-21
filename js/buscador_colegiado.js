var tabla;
function buscar_all() {
  // $('#tabla-resultado-busqueda>body').html('<tr class="text-center"><td scope="row" colspan="11">Buscando...</td></tr>');
  // var formData = new FormData($("#form-buscar-all")[0]);

  // $.ajax({
  //   url: "ajax/buscador_colegiado.php?op=buscar_all",
  //   type: "POST",
  //   data: formData,
  //   contentType: false,
  //   processData: false,
  //   success: function (e) {
  //     e = JSON.parse(e);  console.log(e);  
  //     if (e.status == true) {   
  //       var data_html = "";
  //       e.data.forEach((val, key) => {
  //         data_html = data_html.concat(`
  //         <tr>
  //           <td scope="row">${key+1}</td>
  //           <td><img class="cursor-pointer" src="http://ciptarapoto.com/intranet/web/${val[0]}" alt="Perfil" onclick="ver_perfil_colegiado('http://ciptarapoto.com/intranet/web/${val[0]}', '${val[1]}')"></td>
  //           <td>${val[1]}</td>
  //           <td>${val[2]}</td>
  //           <td>${val[3]}</td>                  
  //           <td>${val[4]}</td>
  //           <td>${val[5]}</td>
  //           <td>${val[6]}</td>
  //           <td>${val[7]}</td>
  //           <td>${val[8]}</td>
  //           <td>${val[9]}</td>
  //         </tr>
  //         `);
  //       });

  //       $('#tabla-resultado-busqueda>tbody').html(data_html);
  //       $("#btn-search-all").html('<i class="fa fa-search"></i> Buscar').removeClass('disabled');
  //       $("#barra_progress_all_div").hide();
  //     } else {         
  //       // ver_errores(e);
  //     }
  //   },
  //   xhr: function () {
  //     var xhr = new window.XMLHttpRequest();
  //     xhr.upload.addEventListener("progress", function (evt) {
  //       if (evt.lengthComputable) {
  //         var percentComplete = (evt.loaded / evt.total)*100;
  //         /*console.log(percentComplete + '%');*/
  //         $("#barra_progress_all").css({"width": percentComplete+'%'});
  //         $("#barra_progress_all").text(percentComplete.toFixed(2)+" %");
  //       }
  //     }, false);
  //     return xhr;
  //   },
  //   beforeSend: function () {
  //     $("#barra_progress_all_div").show();
  //     $("#btn-search-all").html('<i class="fas fa-spinner fa-pulse fa-lg"></i>').addClass('disabled');
  //     $("#barra_progress_all").css({ width: "0%",  });
  //     $("#barra_progress_all").text("0%");
  //   },
  //   complete: function () {      
  //     $("#barra_progress_all").css({ width: "0%", });
  //     $("#barra_progress_all").text("0%");
  //   },
  //   error: function (jqXhr) { /*ver_errores(jqXhr);*/ },
  // });

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
}

function buscar_dni() {
  
  var capitulo_dni = $('#capitulo_dni').val() ;
  var nombre_dni   = $('#nombre_dni').val() ;

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
}

function ver_perfil_colegiado(ruta, nombre) {
  $('#title-name-modal').html(nombre);
  $('#div-ver-perfil').html( `<img src="${ruta}" alt="" width="100%" onerror="this.src='dist/svg/user_default.svg';" >` );
  $('#modal-ver-perfil').modal('show');
}


$(function () {

  // $('#unidad_medida').on('change', function() { $(this).trigger('blur'); });

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
      nombre_cip:   { required: true, minlength:2, maxlength:40 },      
    },
    messages: {
      capitulo_cip: { required: "Campo requerido", },
      nombre_cip:   { required: "Campo requerido",  minlength:"Minimo 2 caracteres", maxlength:"Maximo 200 caracteres"}, 
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
      nombre_dni:   { required: true, minlength:2, maxlength:40 },      
    },
    messages: {
      capitulo_dni: { required: "Campo requerido", },
      nombre_dni:   { required: "Campo requerido",  minlength:"Minimo 2 caracteres", maxlength:"Maximo 200 caracteres"}, 
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

  // $('#unidad_medida').rules('add', { required: true, messages: {  required: "Campo requerido" } });
});
