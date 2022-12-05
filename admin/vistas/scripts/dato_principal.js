
//Función que se ejecuta al inicio
function init() {

  $("#lDatoPrincipal").addClass("active");

  mostrar_datos_colegiado();

  // ══════════════════════════════════════ G U A R D A R   F O R M ══════════════════════════════════════
  $("#guardar_registro").on("click", function (e) {  $("#submit-form-dato-principal").submit(); });  
  
  // Formato para telefono
  $("[data-mask]").inputmask();
}


init();

//Función limpiar
function limpiar_form_colegiado() {

  $("#usuario").val("");
  $("#password").val(""); 
  $("#email").val(""); 
  $("#celular").val(""); 
  $("#direccion").val("");   
  
  // Limpiamos las validaciones
  $(".form-control").removeClass('is-valid');
  $(".form-control").removeClass('is-invalid');
  $(".error.invalid-feedback").remove();
}

function show_hide_form(flag) {
  if (flag == 1) {
    $(".btn-editar").show();
    $(".btn-close").hide();
    $(".btn-guardar").hide();

    $(".span_data").show();
    $(".input_data").hide();
    $("#password").val(''); 
  } else if (flag == 2) {
    $(".btn-editar").hide();
    $(".btn-close").show();
    $(".btn-guardar").show();

    $(".span_data").hide();
    $(".input_data").show();
    $("#password").val(''); 
  } else if (flag == 3) {
    $(".btn-editar").hide();
    $(".btn-close").show();
    $(".btn-guardar").show();
  }  
}

//Función para guardar o editar
function guardar_y_editar_colegiado(e) {
  // e.preventDefault(); //No se activará la acción predeterminada del evento
  var formData = new FormData($("#form-dato-principal")[0]);

  $.ajax({
    url: "../ajax/dato_principal.php?op=guardar_y_editar_colegiado",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function (e) {
      try {
        e = JSON.parse(e);  //console.log(e); 
        if (e.status == true) {	
          Swal.fire("Correcto!", "Datos guardado correctamente", "success");                
          mostrar_datos_colegiado();          
          show_hide_form(1);
        }else{
          ver_errores(e);
        }
      } catch (err) { console.log('Error: ', err.message); toastr_error("Error temporal!!",'Puede intentalo mas tarde, o comuniquese con:<br> <i><a href="tel:+51921305769" >921-305-769</a></i> ─ <i><a href="tel:+51921487276" >921-487-276</a></i>', 700); }      

      $("#guardar_registro").html('Guardar Cambios').removeClass('disabled');
      $('#barra_progress_colegiado_div').hide();
    },
    xhr: function () {
      var xhr = new window.XMLHttpRequest();
      xhr.upload.addEventListener("progress", function (evt) {
        if (evt.lengthComputable) {
          var percentComplete = (evt.loaded / evt.total)*100;
          /*console.log(percentComplete + '%');*/
          $("#barra_progress_colegiado").css({"width": percentComplete+'%'});
          $("#barra_progress_colegiado").text(percentComplete.toFixed(2)+" %");
        }
      }, false);
      return xhr;
    },
    beforeSend: function () {
      $("#guardar_registro").html('<i class="fas fa-spinner fa-pulse fa-lg"></i>').addClass('disabled');
      $("#barra_progress_colegiado").css({ width: "0%",  });
      $("#barra_progress_colegiado").text("0%");
    },
    complete: function () {
      $("#barra_progress_colegiado").css({ width: "0%", });
      $("#barra_progress_colegiado").text("0%");
    },
    error: function (jqXhr) { ver_errores(jqXhr); },
  });
}

// mostramos los datos para editar
function mostrar_datos_colegiado() {

  $(".tooltip").removeClass("show").addClass("hidde");

  limpiar_form_colegiado();  

  $.post("../ajax/dato_principal.php?op=mostrar", function (e, status) {

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

function ver_password() {
  var x = document.getElementById("password");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}

// .....::::::::::::::::::::::::::::::::::::: V A L I D A T E   F O R M  :::::::::::::::::::::::::::::::::::::::..

$(function () {   

  $("#banco_0").on('change', function() { $(this).trigger('blur'); });
  $("#tipo").on('change', function() { $(this).trigger('blur'); });
  $("#ocupacion").on('change', function() { $(this).trigger('blur'); });
  $("#desempenio").on('change', function() { $(this).trigger('blur'); });

  $("#form-dato-principal").validate({
    rules: {
      usuario:  { required: true, minlength: 4, maxlength: 20 },
      password: { minlength: 6, maxlength: 20 },
      email:    { email: true, required: true, minlength: 6, maxlength: 100 },
      celular:  { minlength: 8, maxlength: 20 },
      direccion:{ minlength: 5, maxlength: 70 },
    },
    messages: {
      usuario:  { required: "Campo requerido.", minlength: "MÍNIMO 4 caracteres.", maxlength: "MÁXIMO 20 caracteres.", },
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
      guardar_y_editar_colegiado(e);

    },
  });

  $("#banco_0").rules('add', { required: true, messages: {  required: "Campo requerido" } });
  $("#tipo").rules('add', { required: true, messages: {  required: "Campo requerido" } });
  $("#ocupacion").rules('add', { required: true, messages: {  required: "Campo requerido" } });
  $("#desempenio").rules('add', { required: true, messages: {  required: "Campo requerido" } });
});

// .....::::::::::::::::::::::::::::::::::::: F U N C I O N E S    A L T E R N A S  :::::::::::::::::::::::::::::::::::::::..
