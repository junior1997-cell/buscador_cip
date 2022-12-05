var tabla;
//Función que se ejecuta al inicio
function init() {

  $("#lConyuge").addClass("active");

  mostrar();

  // ══════════════════════════════════════ G U A R D A R   F O R M ══════════════════════════════════════
  $("#guardar_registro").on("click", function (e) {  $("#submit-form-conyuge").submit(); });  

  // ══════════════════════════════════════ INITIALIZE SELECT2 ══════════════════════════════════════
  $("#sexo").select2({ theme: "bootstrap4",  placeholder: "Selecionar Sexo", allowClear: true, });

  //$('#nacimiento').inputmask('dd-mm-yyyy', { 'placeholder': 'dd-mm-yyyy' })
  $('#nacimiento').datepicker({ format: "dd-mm-yyyy", language: "es", autoclose: true, endDate: moment().format('DD/MM/YYYY'), clearBtn: true, weekStart: 0, orientation: "bottom auto", todayBtn: true });
  // Formato para telefono
  $("[data-mask]").inputmask();

}
// click input group para habilitar: datepiker
$('.click-btn-nacimiento').on('click', function (e) {$('#nacimiento').focus().select(); });

init();

// ══════════════════════════════════════ F U N C I O N E S ══════════════════════════════════════
// funcion limpiar
function limpiar() {

  $("#nombre_h_").val("");
  $("#num_documento").val("");
  $("#apellido_h_").val("");
  $("#sexo").val("").trigger("change");
  $("#nacimiento").val("");

  $("#telefono1").val("");
  $("#telefono2").val("");
  $("#telefono3").val("");
}

function active_imput(flag) {
  if (flag == 1) {
    $(".btn-editar").show();
    $(".bnt-guardar").hide();
    $(".input_data").attr('readonly','readonly');
  } else {
    $(".btn-editar").hide();
    $(".bnt-guardar").show();
    $('.input_data').removeAttr('readonly');
  }
}

//Función para guardar o editar
function guardar_y_editar_conyuge(e) {
  // e.preventDefault(); //No se activará la acción predeterminada del evento
  var formData = new FormData($("#form-conyuge")[0]);

  $.ajax({
    url: "../ajax/conyuge.php?op=guardaryeditar",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function (e) {
      try {
        e = JSON.parse(e);  //console.log(e); 
        if (e.status == true) {	
          Swal.fire("Correcto!", "Conyuge guardado correctamente", "success");
          mostrar();
          limpiar();
          active_imput(1);
        }else{
          ver_errores(e);
        }
      } catch (err) { console.log('Error: ', err.message); toastr_error("Error temporal!!",'Puede intentalo mas tarde, o comuniquese con:<br> <i><a href="tel:+51921305769" >921-305-769</a></i> ─ <i><a href="tel:+51921487276" >921-487-276</a></i>', 700); }      
      $("#guardar_registro").html('Guardar Cambios').removeClass('disabled');
    },
    xhr: function () {
      var xhr = new window.XMLHttpRequest();
      xhr.upload.addEventListener("progress", function (evt) {
        if (evt.lengthComputable) {
          var percentComplete = (evt.loaded / evt.total)*100;
          /*console.log(percentComplete + '%');*/
          $("#barra_progress").css({"width": percentComplete+'%'});
          $("#barra_progress").text(percentComplete.toFixed(2)+" %");
        }
      }, false);
      return xhr;
    },
    beforeSend: function () {
      $("#guardar_registro").html('<i class="fas fa-spinner fa-pulse fa-lg"></i>').addClass('disabled');
      $("#barra_progress").css({ width: "0%",  });
      $("#barra_progress").text("0%");
    },
    complete: function () {
      $("#barra_progress").css({ width: "0%", });
      $("#barra_progress").text("0%");
    },
    error: function (jqXhr) { ver_errores(jqXhr); },
  });
}

// mostramos los datos para editar
function mostrar() {
  $(".tooltip").removeClass("show").addClass("hidde");
  limpiar();  

  $("#cargando-1-fomulario").hide();
  $("#cargando-2-fomulario").show();

  $("#modal-agregar-conyuge").modal("show")

  $.post("../ajax/conyuge.php?op=mostrar", function (e, status) {

    e = JSON.parse(e);  console.log(e);   

    if (e.status == true) {
      
      $("#idconyuge").val(e.data.idconyuge);
      $("#tipo_documento").val("DNI").trigger("change");
      $("#nombre_h_").val(e.data.nombres);
      $("#num_documento").val(e.data.dni);
      $("#apellido_h_").val(e.data.apellidos);
      $("#sexo").val(e.data.sexo).trigger("change");   
      $("#nacimiento").datepicker("setDate" , format_d_m_a(e.data.fecha_nacimiento)); 
      
      $("#telefono1").val(e.data.telefono_1);
      $("#telefono2").val(e.data.telefono_2);
      $("#telefono3").val(e.data.telefono_3);

      $("#cargando-1-fomulario").show();
      $("#cargando-2-fomulario").hide();

    } else {
      ver_errores(e);
    }    
  }).fail( function(e) { ver_errores(e); } );
}

// .....::::::::::::::::::::::::::::::::::::: V A L I D A T E   F O R M  :::::::::::::::::::::::::::::::::::::::..

$(function () {   

  $("#sexo").on('change', function() { $(this).trigger('blur'); });

  $("#form-conyuge").validate({
    rules: {
      nombre_h_: { required: true },
      apellido_h_: { required: true },
      num_documento:  { required: true, minlength: 8, maxlength: 8 },
      sexo:      { required: true},
    },
    messages: {
      nombre_h_: { required: "Campo requerido.", },
      apellido_h_: { required: "Campo requerido.", },
      num_documento:  { required: "Campo requerido.", minlength: "MÍNIMO 8 caracteres.", maxlength: "MÁXIMO 8 caracteres.", },
      sexo:{ required: "Campo requerido.", },
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
      guardar_y_editar_conyuge(e);

    },
  });

  $("#sexo").rules('add', { required: true, messages: {  required: "Campo requerido" } });
});


