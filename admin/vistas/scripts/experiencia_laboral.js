var tabla;
//Función que se ejecuta al inicio
function init() {

  $("#lExperienciaLaboral").addClass("active");

  mostrar_datos_experiencia();
  tabla_empresa_laboral();

  // ══════════════════════════════════════ S E L E C T 2 ══════════════════════════════════════
  lista_select2("../ajax/ajax_general.php?op=select2Empresa", '#empresa_select2', null);

  // ══════════════════════════════════════ G U A R D A R   F O R M ══════════════════════════════════════
  $("#guardar_registro_experiencia").on("click", function (e) {  $("#submit-form-experiencia-laboral").submit(); });  
  $("#guardar_registro_empresa").on("click", function (e) {  $("#submit-form-empresa").submit(); });  

  // ══════════════════════════════════════ INITIALIZE SELECT2 ══════════════════════════════════════ 
  $("#empresa_select2").select2({ theme: "bootstrap4", placeholder: "Selecione empresa", allowClear: true, });
  
  // Formato para telefono
  $("[data-mask]").inputmask();
}

init();

$("#doc1_i").click(function() {  $('#doc1').trigger('click'); });
$("#doc1").change(function(e) {  addImageApplication(e,$("#doc1").attr("id")) });

// Eliminamos el doc 1
function doc1_eliminar() {
	$("#doc1").val("");
	$("#doc1_ver").html('<img src="../dist/svg/pdf_trasnparent.svg" alt="" width="50%" >');
	$("#doc1_nombre").html("");
}

//Función limpiar
function limpiar_form_experiencia() {

  $("#idexperiencia_laboral").val("");
  $("#fecha_inicio").val("");
  $("#fecha_fin").val("");
  $('#trabajo_actual').prop('checked', false); 
  $("#cargo_laboral").val("");
  $("#url_empresa").val("");

  $("#empresa_select2").val("").trigger("change");

  $("#doc1").val("");
  $("#doc_old_1").val("");
  $("#doc1_ver").html('<img src="../dist/svg/pdf_trasnparent.svg" alt="" width="50%" >');
  $("#doc1_nombre").html('');
  
  // Limpiamos las validaciones
  $(".form-control").removeClass('is-valid');
  $(".form-control").removeClass('is-invalid');
  $(".error.invalid-feedback").remove();
}

//Función para guardar o editar
function guardar_y_editar_experiencia(e) {
  // e.preventDefault(); //No se activará la acción predeterminada del evento
  var formData = new FormData($("#form-experiencia-laboral")[0]);

  $.ajax({
    url: "../ajax/experiencia_laboral.php?op=guardar_y_editar_experiencia_laboral",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function (e) {
      try {
        e = JSON.parse(e);  //console.log(e); 
        if (e.status == true) {	
          Swal.fire("Correcto!", "Experiencia guardada correctamente", "success");                
          mostrar_datos_experiencia(); 
          limpiar_form_experiencia();     
        }else{
          ver_errores(e);
        }
      } catch (err) { console.log('Error: ', err.message); toastr_error("Error temporal!!",'Puede intentalo mas tarde, o comuniquese con:<br> <i><a href="tel:+51921305769" >921-305-769</a></i> ─ <i><a href="tel:+51921487276" >921-487-276</a></i>', 700); }      

      $("#guardar_registro").html('Guardar Cambios').removeClass('disabled');
      $('#barra_progress_experiencia_div').hide();
    },
    xhr: function () {
      var xhr = new window.XMLHttpRequest();
      xhr.upload.addEventListener("progress", function (evt) {
        if (evt.lengthComputable) {
          var percentComplete = (evt.loaded / evt.total)*100;
          /*console.log(percentComplete + '%');*/
          $("#barra_progress_experiencia").css({"width": percentComplete+'%'});
          $("#barra_progress_experiencia").text(percentComplete.toFixed(2)+" %");
        }
      }, false);
      return xhr;
    },
    beforeSend: function () {
      $("#guardar_registro").html('<i class="fas fa-spinner fa-pulse fa-lg"></i>').addClass('disabled');
      $("#barra_progress_experiencia").css({ width: "0%",  });
      $("#barra_progress_experiencia").text("0%");
    },
    complete: function () {
      $("#barra_progress_experiencia").css({ width: "0%", });
      $("#barra_progress_experiencia").text("0%");
    },
    error: function (jqXhr) { ver_errores(jqXhr); },
  });
}

// mostramos los datos para editar
function mostrar_datos_experiencia() {

  $(".tooltip").removeClass("show").addClass("hidde");

  limpiar_form_experiencia();  

  $.post("../ajax/experiencia_laboral.php?op=mostrar_datos_experiencia", function (e, status) {

    e = JSON.parse(e);  console.log(e);   

    if (e.status == true) {       

      $("#usuario").val( e.data.usuario == null || e.data.usuario == '' ? '': e.data.usuario );
      $("#password").val(''); 
      $("#email").val( e.data.email == null || e.data.email == '' ? '': e.data.email ); 
      $("#celular").val( e.data.celular == null || e.data.celular == '' ? '': e.data.celular ); 
      $("#direccion").val( e.data.direccion == null || e.data.direccion == '' ? '': e.data.direccion );   

      $("#span_usuario").html( e.data.usuario == null || e.data.usuario == '' ? '--': e.data.usuario );
      $("#span_password").html( '****' ); 
      $("#span_email").html( e.data.email == null || e.data.email == '' ? '--': e.data.email ); 
      $("#span_celular").html( e.data.celular == null || e.data.celular == '' ? '--': e.data.celular ); 
      $("#span_direccion").html( e.data.direccion == null || e.data.direccion == '' ? '--': e.data.direccion );  
      
    } else {
      ver_errores(e);
    }    
  }).fail( function(e) { ver_errores(e); } );
}

function limpiar_fecha_fin() {
  if ($(`#trabajo_actual`).is(':checked')) {
    $(`#fecha_fin`).hide();
    $(`#span_fecha_fin`).show();
    $("#fecha_fin").rules('remove', 'required');
  } else {
    $(`#fecha_fin`).show();
    $(`#span_fecha_fin`).hide();
    $("#fecha_fin").rules('add', { required: true, messages: {  required: "Campo requerido" } });
  }
}
// .....::::::::::::::::::::::::::::::::::::: E M P R E S A   L A B O R A L  :::::::::::::::::::::::::::::::::::::::..

function limpiar_form_empresa() {
  $("#idempresa ").val("");
  $("#nombre_empresa").val("");
  $("#num_documento_empresa").val(""); 
  $("#direccion_empresa").val(""); 
  $("#telefono_empresa").val(""); 
  $("#correo_empresa").val("");   

  // Limpiamos las validaciones
  $(".form-control").removeClass('is-valid');
  $(".form-control").removeClass('is-invalid');
  $(".error.invalid-feedback").remove();
}
function tabla_empresa_laboral() {

  tabla=$('#tabla-empresas').dataTable({
    responsive: true,
    lengthMenu: [[ -1, 5, 10, 25, 75, 100, 200,], ["Todos", 5, 10, 25, 75, 100, 200, ]],//mostramos el menú de registros a revisar
    aProcessing: true,//Activamos el procesamiento del datatables
    aServerSide: true,//Paginación y filtrado realizados por el servidor
    dom: '<Bl<f>rtip>',//Definimos los elementos del control de tabla
    buttons: [
      { extend: 'copyHtml5', footer: true, exportOptions: { columns: [0,2,3,6,4], } }, 
      { extend: 'excelHtml5', footer: true, exportOptions: { columns: [0,2,3,6,4], } }, 
      { extend: 'pdfHtml5', footer: false,  exportOptions: { columns: [0,2,3,6,4], } }, 
    ],
    ajax:{
      url: '../ajax/experiencia_laboral.php?op=tabla_empresa_laboral',
      type : "get",
      dataType : "json",						
      error: function(e){
        console.log(e.responseText); ver_errores(e);
      }
    },      
    createdRow: function (row, data, ixdex) {   
      // columna: #
      if (data[0] != '') { $("td", row).eq(0).addClass("text-center"); }
      // columna: #
      if (data[1] != '') { $("td", row).eq(1).addClass("text-nowrap"); }
    },
    language: {
      lengthMenu: "Mostrar: _MENU_ registros",
      buttons: { copyTitle: "Tabla Copiada", copySuccess: { _: "%d líneas copiadas", 1: "1 línea copiada", }, },
      sLoadingRecords: '<i class="fas fa-spinner fa-pulse fa-lg"></i> Cargando datos...'
    },
    bDestroy: true,
    iDisplayLength: 10,//Paginación
    order: [[ 0, "asc" ]],//Ordenar (columna,orden)
    columnDefs: [
      // { targets: [6], visible: false, searchable: false, },            
    ],
  }).DataTable();
}

//Función para guardar o editar
function guardar_y_editar_empresa(e) {
  // e.preventDefault(); //No se activará la acción predeterminada del evento
  var formData = new FormData($("#form-empresa")[0]);

  $.ajax({
    url: "../ajax/experiencia_laboral.php?op=guardar_y_editar_empresa",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function (e) {
      try {
        e = JSON.parse(e);  //console.log(e); 
        if (e.status == true) {	
          Swal.fire("Correcto!", "Empresa guardado correctamente", "success");           
          tabla.ajax.reload(null, false);
          lista_select2("../ajax/ajax_general.php?op=select2Empresa", '#empresa', null);
          $('#modal-agregar-empresa').modal('hide');
        }else{
          ver_errores(e);
        }
      } catch (err) { console.log('Error: ', err.message); toastr_error("Error temporal!!",'Puede intentalo mas tarde, o comuniquese con:<br> <i><a href="tel:+51921305769" >921-305-769</a></i> ─ <i><a href="tel:+51921487276" >921-487-276</a></i>', 700); }      

      $("#guardar_registro_empresa").html('Guardar Cambios').removeClass('disabled');
      $('#barra_progress_empresa_div').hide();
    },
    xhr: function () {
      var xhr = new window.XMLHttpRequest();
      xhr.upload.addEventListener("progress", function (evt) {
        if (evt.lengthComputable) {
          var percentComplete = (evt.loaded / evt.total)*100;
          /*console.log(percentComplete + '%');*/
          $("#barra_progress_empresa").css({"width": percentComplete+'%'});
          $("#barra_progress_empresa").text(percentComplete.toFixed(2)+" %");
        }
      }, false);
      return xhr;
    },
    beforeSend: function () {
      $("#guardar_registro_empresa").html('<i class="fas fa-spinner fa-pulse fa-lg"></i>').addClass('disabled');
      $("#barra_progress_empresa").css({ width: "0%",  });
      $("#barra_progress_empresa").text("0%");
    },
    complete: function () {
      $("#barra_progress_empresa").css({ width: "0%", });
      $("#barra_progress_empresa").text("0%");
    },
    error: function (jqXhr) { ver_errores(jqXhr); },
  });
}

//Función para desactivar registros
function activar_empresa(idempresa, nombre) {
  Swal.fire({
    title: "¿Está Seguro de Activar?",
    html: `<b class="text-success">${nombre}</b> <br> Esta <b>empresa se mostrará</b> al agregar experiencia laboral`,
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#28a745",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, Activar!",
  }).then((result) => {
    if (result.isConfirmed) {
      $.post("../ajax/experiencia_laboral.php?op=activar", { 'idempresa': idempresa }, function (e) {
        e = JSON.parse(e);  console.log(e); 
        if (e.status == true) {
          Swal.fire("Activado!", "Tu Empresa ha sido activada.", "success");    
          tabla.ajax.reload(null, false);
          lista_select2("../ajax/ajax_general.php?op=select2Empresa", '#empresa', null);
        } else {
          ver_errores(e);
        }        
      }).fail( function(e) { ver_errores(e); } );    
    }
  });   
}

//Función para desactivar registros
function desactivar_empresa(idempresa, nombre) {
  Swal.fire({
    title: "¿Está Seguro de  Desactivar?",
    html: `<b class="text-danger"><del>${nombre}</del></b> <br> Esta <b>empresa NO se mostrara</b> al agregar experiencia laboral`,
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#28a745",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, desactivar!",
  }).then((result) => {
    if (result.isConfirmed) {
      $.post("../ajax/experiencia_laboral.php?op=desactivar", { 'idempresa': idempresa }, function (e) {
        e = JSON.parse(e);  console.log(e); 
        if (e.status == true) {
          Swal.fire("Desactivado!", "Tu Empresa ha sido desactivada.", "success");    
          tabla.ajax.reload(null, false);
          lista_select2("../ajax/ajax_general.php?op=select2Empresa", '#empresa', null);
        } else {
          ver_errores(e);
        }        
      }).fail( function(e) { ver_errores(e); } );    
    }
  });   
}

function mostrar_editar_empresa(idempresa) {

  $(".tooltip").removeClass("show").addClass("hidde");
  limpiar_form_empresa();  
  $('#modal-agregar-empresa').modal('show');

  $.post("../ajax/experiencia_laboral.php?op=mostrar_editar_empresa",{'idempresa':idempresa}, function (e, status) {

    e = JSON.parse(e);  console.log(e);   

    if (e.status == true) {       
      $("#idempresa").val( e.data.idempresa );
      $("#nombre_empresa").val( e.data.razon_social );
      $("#num_documento_empresa").val(e.data.ruc); 
      $("#direccion_empresa").val( e.data.direccion ); 
      $("#telefono_empresa").val( e.data.celular ); 
      $("#correo_empresa").val( e.data.correo );   
      
    } else {
      ver_errores(e);
    }    
  }).fail( function(e) { ver_errores(e); } );
}

// .....::::::::::::::::::::::::::::::::::::: V A L I D A T E   F O R M  :::::::::::::::::::::::::::::::::::::::..

$(function () {   

  
  $("#empresa_select2").on('change', function() { $(this).trigger('blur'); });

  $("#form-experiencia-laboral").validate({
    rules: {
      empresa_select2:  { required: true, },
      usuario:  { required: true, minlength: 6, maxlength: 10 },
      password: { minlength: 6, maxlength: 20 },
      email:    { email: true, required: true, minlength: 6, maxlength: 100 },
      celular:  { minlength: 8, maxlength: 20 },
      direccion:{ minlength: 5, maxlength: 70 },
    },
    messages: {
      empresa_select2:  {required: "Campo requerido." },
      usuario:  { required: "Campo requerido.", minlength: "MÍNIMO 6 caracteres.", maxlength: "MÁXIMO 10 caracteres.", },
      password: { minlength: "MÍNIMO 6 caracteres.", maxlength: "MÁXIMO 20 caracteres.", },
      email:    { required: "Campo requerido.", minlength: "MÍNIMO 6 caracteres.", maxlength: "MÁXIMO 100 caracteres.", email: "Ingrese un coreo electronico válido.", },
      celular:  { minlength: "MÍNIMO 8 caracteres.", maxlength: "MÁXIMO 20 caracteres.", },
      direccion:{ minlength: "MÍNIMO 5 caracteres.", maxlength: "MÁXIMO 70 caracteres.", },
    },
        
    errorElement: "span",

    errorPlacement: function (error, element) {
      error.addClass("invalid-feedback");
      element.closest(".form-group").append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass("is-invalid").removeClass("is-valid");
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass("is-invalid").addClass("is-valid");
    },
    submitHandler: function (e) {
      $(".modal-body").animate({ scrollTop: $(document).height() }, 600); // Scrollea hasta abajo de la página
      guardar_y_editar_experiencia(e);

    },
  });

  $("#form-empresa").validate({
    rules: {
      tipo_documento_empresa: { required: true,  },
      num_documento_empresa:  { required: true, minlength: 8, maxlength: 20 },
      nombre_empresa:         { required: true, minlength: 6, maxlength: 200 },
      direccion_empresa:      { minlength: 4, maxlength: 100 },
      telefono_empresa:       { minlength: 9, maxlength: 20 },
      correo_empresa:         { email: true, minlength: 6, maxlength: 100 },
    },
    messages: {
      tipo_documento_empresa: { required: "Campo requerido.", },
      num_documento_empresa:  { required: "Campo requerido.", minlength: "MÍNIMO 8 caracteres.", maxlength: "MÁXIMO 20 caracteres.", },
      nombre_empresa:         { required: "Campo requerido.", required: "Campo requerido.", minlength: "MÍNIMO 6 caracteres.", maxlength: "MÁXIMO 200 caracteres.",},
      direccion_empresa:      { minlength: "MÍNIMO 4 caracteres.", maxlength: "MÁXIMO 100 caracteres.", },
      telefono_empresa:       { minlength: "MÍNIMO 9 caracteres.", maxlength: "MÁXIMO 20 caracteres.", },
      correo_empresa:         { minlength: "MÍNIMO 6 caracteres.", maxlength: "MÁXIMO 100 caracteres.", email: "Ingrese un coreo electronico válido.", },
    },
        
    errorElement: "span",

    errorPlacement: function (error, element) {
      error.addClass("invalid-feedback");
      element.closest(".form-group").append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass("is-invalid").removeClass("is-valid");
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass("is-invalid").addClass("is-valid");
    },
    submitHandler: function (e) {
      $(".modal-body").animate({ scrollTop: $(document).height() }, 600); // Scrollea hasta abajo de la página
      guardar_y_editar_empresa(e);

    },
  });

  $("#empresa_select2").rules('add', { required: true, messages: {  required: "Campo requerido" } });
  
});

// .....::::::::::::::::::::::::::::::::::::: F U N C I O N E S    A L T E R N A S  :::::::::::::::::::::::::::::::::::::::..
