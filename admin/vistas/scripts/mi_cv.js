var tabla;
//Función que se ejecuta al inicio
function init() {

  $("#lCurriculum").addClass("active");

  ver_cv();

  // ══════════════════════════════════════ G U A R D A R   F O R M ══════════════════════════════════════
  $("#guardar_registro").on("click", function (e) {  $("#submit-form-cv").submit(); });  
  $("#form-cv").on("submit", function(e) { guardar_y_editar_cv(e); });
  // Formato para telefono
  $("[data-mask]").inputmask();
}

$("#doc1_i").click(function() {  $('#doc1').trigger('click'); });
$("#doc1").change(function(e) {  addImageApplication(e,$("#doc1").attr("id")) });

// Eliminamos el doc 1
function doc1_eliminar() {
	$("#doc1").val("");
	$("#doc1_ver").html('<img src="../dist/svg/pdf_trasnparent.svg" alt="" width="50%" >');
	$("#doc1_nombre").html("");
}

init();

//Función Listar
function ver_cv() {
  $.post("../ajax/mi_cv.php?op=verdatos", function (e, status) {
    e = JSON.parse(e);  console.log(e);   
    if (e.status == true) {
      
      // cargamos la imagen adecuada par el archivo
      if (e.data.documento_cv == null || e.data.documento_cv == "") {
        $("#div-ver-cv").html('─ No tiene CV');
      } else {
        var ver_doc = doc_view_extencion(e.data.documento_cv, 'colegiado', 'cv', '100%', '506');
        $("#div-ver-cv").html(ver_doc);
      }      

    } else {
      ver_errores(e);
    }    
  }).fail( function(e) { ver_errores(e); } );
}

function guardar_y_editar_cv(e) {
  e.preventDefault(); //No se activará la acción predeterminada del evento
  var formData = new FormData($("#form-cv")[0]);

  $.ajax({
    url: "../ajax/mi_cv.php?op=guardar_y_editar_cv",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function (e) {
      try {
        e = JSON.parse(e); console.log(e);
        if (e.status == true) {

          Swal.fire("Correcto!", "CV guardado correctamente", "success");
          ver_cv();
          $("#modal-agregar-cv").modal("hide");
          
        } else {
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

// .....::::::::::::::::::::::::::::::::::::: V A L I D A T E   F O R M  :::::::::::::::::::::::::::::::::::::::..

$(function () { 

  // $("#form-cv").validate({
  //   rules: {
  //     idcolegiado: { minlength: 1 },      
  //   },
  //   messages: {
  //     idcolegiado: { minlength: "Minimo 1.", },      
  //   },
        
  //   errorElement: "span",

  //   errorPlacement: function (error, element) {
  //     error.addClass("invalid-feedback");
  //     element.closest(".form-group").append(error);
  //   },
  //   highlight: function (element, errorClass, validClass) {
  //     $(element).addClass("is-invalid").removeClass("is-valid");
  //   },
  //   unhighlight: function (element, errorClass, validClass) {
  //     $(element).removeClass("is-invalid").addClass("is-valid");
  //   },
  //   submitHandler: function (e) {
  //     $(".modal-body").animate({ scrollTop: $(document).height() }, 600); // Scrollea hasta abajo de la página
  //     guardar_y_editar_cv(e);

  //   },
  // });

});

// .....::::::::::::::::::::::::::::::::::::: F U N C I O N E S    A L T E R N A S  :::::::::::::::::::::::::::::::::::::::..

function ver_perfil(file, nombre) {
  $('.modal-title-perfil-trabajador').html(nombre);
  $(".tooltip").removeClass("show").addClass("hidde");
  $("#modal-ver-perfil-trabajador").modal("show");
  $('#html-perfil-trabajador').html(`<span class="jq_image_zoom"><img class="img-thumbnail" src="${file}" onerror="this.src='../dist/svg/user_default.svg';" alt="Perfil" width="100%"></span>`);
  $('.jq_image_zoom').zoom({ on:'grab' });
}