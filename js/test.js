function recuperar_banco() {
  
  $.post("../ajax/test.php?op=mostrar_data", function (e, textStatus, jqXHR) {
    e = JSON.parse(e); console.log(e);
    if (e.status == true) {
    } else {
      console.log('error');
    }
  });
}


$(function () {

  // $('#unidad_medida').on('change', function() { $(this).trigger('blur'); });

  $("#form-buscar-all").validate({
    rules: {
      capitulo_all: { required: true, },
      nombre_all:   { required: true, minlength:3, maxlength:40 },      
    },
    messages: {
      capitulo_all: { required: "Campo requerido", },
      nombre_all:   { required: "Campo requerido",  minlength:"Minimo 3 caracteres", maxlength:"Maximo 200 caracteres"}, 
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
      // guardaryeditar(e);
    },
  });

  // $('#unidad_medida').rules('add', { required: true, messages: {  required: "Campo requerido" } });
});
