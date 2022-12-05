var tabla;  

//Función que se ejecuta al inicio
function init() {

  $("#bloc_Accesos").addClass("menu-open");
  $("#mAccesos").addClass("active");
  $("#lUsuario").addClass("active");

  tbla_principal();
  
  // ══════════════════════════════════════ G U A R D A R   F O R M ══════════════════════════════════════
  $("#guardar_registro_colegiado").on("click", function (e) {  $("#submit-form-colegiado").submit(); });

  // Formato para telefono
  $("[data-mask]").inputmask();   
}
 
//Función limpiar
function limpiar_form_colegiado() {

  $("#idcolegiado").val("");
  $("#nombre_colegiado").html("");
  $("#input_usuario").val("");   
  $("#input_password").val(""); 

  // Limpiamos las validaciones
  $(".form-control").removeClass('is-valid');
  $(".form-control").removeClass('is-invalid');
  $(".error.invalid-feedback").remove();
}


//Función Listar
function tbla_principal() {

  tabla = $('#tabla-colegiado').dataTable({
    responsive: true,
    lengthMenu: [[ -1, 5, 10, 25, 75, 100, 200,], ["Todos", 5, 10, 25, 75, 100, 200, ]],//mostramos el menú de registros a revisar
    aProcessing: true,//Activamos el procesamiento del datatables
    aServerSide: true,//Paginación y filtrado realizados por el servidor
    dom: '<Bl<f>rtip>',//Definimos los elementos del control de tabla
    buttons: [
      { extend: 'copyHtml5', footer: true, exportOptions: { columns: [0,2,3,4,5], } }, 
      { extend: 'excelHtml5', footer: true, exportOptions: { columns: [0,2,3,4,5], } }, 
      { extend: 'pdfHtml5', footer: false, exportOptions: { columns: [0,2,3,4,5], } },
    ],
    ajax:{
      url: '../ajax/usuario.php?op=tbla_principal',
      type : "get",
      dataType : "json",						
      error: function(e){        
        console.log(e.responseText); ver_errores(e);
      }
    },
    createdRow: function (row, data, ixdex) {
      // columna: 0
      if (data[0] != '') { $("td", row).eq(0).addClass("text-center"); }
      // columna: 1
      if (data[2] != '') { $("td", row).eq(2).addClass("text-nowrap"); }
      // columna: 
      // if (data[4] != '') { $("td", row).eq(4).addClass("text-nowrap"); }
    },
    language: {
      lengthMenu: "Mostrar: _MENU_ registros",
      buttons: { copyTitle: "Tabla Copiada", copySuccess: { _: "%d líneas copiadas", 1: "1 línea copiada", }, },
      sLoadingRecords: '<i class="fas fa-spinner fa-pulse fa-lg"></i> Cargando datos...'
    },
    bDestroy: true,
    iDisplayLength: 10,//Paginación
    order: [[ 0, "asc" ]]//Ordenar (columna,orden)
  }).DataTable();
}

//Función para guardar o editar
function guardar_y_editar_colegiado(e) {
  // e.preventDefault(); //No se activará la acción predeterminada del evento
  var formData = new FormData($("#form-colegiado")[0]);

  $.ajax({
    url: "../ajax/usuario.php?op=guardar_y_editar_colegiado",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function (e) { 
      try {
        e = JSON.parse(e); console.log(e);
        if (e.status == true) {          
          limpiar_form_colegiado(); 
          sw_success('Correcto!', "Actualizado correctamente." );  
          $("#modal-agregar-colegiado").modal('hide');        
        } else {
          ver_errores(e);
        }
      } catch (err) { console.log('Error: ', err.message); toastr.error('<h5 class="font-size-16px">Error temporal!!</h5> puede intentalo mas tarde, o comuniquese con <i><a href="tel:+51921305769" >921-305-769</a></i> ─ <i><a href="tel:+51921487276" >921-487-276</a></i>'); }             

      $("#guardar_registro_colegiado").html('Guardar Cambios').removeClass('disabled');
    },
    xhr: function () {
      var xhr = new window.XMLHttpRequest();
      xhr.upload.addEventListener( "progress", function (evt) {
        if (evt.lengthComputable) {
          var prct = (evt.loaded / evt.total) * 100;
          prct = Math.round(prct);
          $("#barra_progress_colegiado").css({ width: prct + "%", });
          $("#barra_progress_colegiado").text(prct + "%");
        }
      }, false );
      return xhr;
    },
    beforeSend: function () {
      $("#guardar_registro_colegiado").html('<i class="fas fa-spinner fa-pulse fa-lg"></i>').addClass('disabled');
      $("#barra_progress_colegiado_div").show();
      $("#barra_progress_colegiado").css({ width: "0%",  });
      $("#barra_progress_colegiado").text("0%");
    },
    complete: function () {
      $("#barra_progress_colegiado_div").hide();
      $("#barra_progress_colegiado").css({ width: "0%", });
      $("#barra_progress_colegiado").text("0%");
    },
    error: function (jqXhr) { ver_errores(jqXhr); },
  });
}

function detalle_colegiado(idcolegiado) {
  $(".tooltip").remove();

  $("#cargando-1-fomulario").hide();
  $("#cargando-2-fomulario").show(); 

  limpiar_form_colegiado();   

  $("#modal-agregar-colegiado").modal('show');

  $.post("../ajax/usuario.php?op=mostrar_editar_colegiado", { 'idcolegiado': idcolegiado }, function (e, status) {

    e = JSON.parse(e);  //console.log(e); 

    if (e.status == true) {

      $("#idcolegiado").val(e.data.idcolegiado);
      $("#nombre_colegiado").html(e.data.nombres_y_apellidos);
      $("#input_usuario").val(e.data.usuario);   
      // $("#input_password").val(e.data.password); 

      $("#cargando-1-fomulario").show();
      $("#cargando-2-fomulario").hide();    
    } else {
      ver_errores(e);
    }  

  }).fail( function(e) { console.log(e); ver_errores(e); } );

}


// :::::::::::::::::::::::::::::::::::::::::::::::::::: S E C C I O N   T R A B A J A D O R  ::::::::::::::::::::::::::::::::::::::::::::::::::::

init();

// .....::::::::::::::::::::::::::::::::::::: V A L I D A T E   F O R M  :::::::::::::::::::::::::::::::::::::::..

$(function () {

  $("#form-colegiado").validate({
    ignore: '.select2-input, .select2-focusser',
    rules: {
      input_usuario:  { required: true, minlength: 4, maxlength: 20 },
      input_password: { minlength: 6, maxlength: 20 },
    },
    messages: {
      input_usuario:  { required: "Este campo es requerido.", minlength: "MÍNIMO 4 caracteres.", maxlength: "MÁXIMO 20 caracteres.", },
      input_password: { minlength: "MÍNIMO 6 caracteres.", maxlength: "MÁXIMO 20 caracteres.", },
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
      guardar_y_editar_colegiado(e);
    },
  });
  
});

// .....::::::::::::::::::::::::::::::::::::: F U N C I O N E S    A L T E R N A S  :::::::::::::::::::::::::::::::::::::::..

function ver_password() {
  var x = document.getElementById("input_password");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}