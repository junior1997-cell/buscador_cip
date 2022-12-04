var tabla;
//Función que se ejecuta al inicio
function init() {

  $("#lCurriculum").addClass("active");

  // ver_cv();
  tbla_principal();

  // ══════════════════════════════════════ G U A R D A R   F O R M ══════════════════════════════════════
  $("#guardar_registro").on("click", function (e) {  $("#submit-form-hijo").submit(); });  

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
  // $("#guardar_registro").html('Guardar Cambios').removeClass('disabled');
  $("#idhijos").val("");
  $("#nombre_h_").val("");
  $("#num_documento").val("");
  $("#apellido_h_").val("");
  $("#sexo").val("").trigger("change");
  $("#nacimiento").val("");

}

//Función Listar
function tbla_principal() {

  tabla=$('#tabla-datos-hijos').dataTable({
    responsive: true,
    lengthMenu: [[ -1, 5, 10], ["Todos", 5, 10]],//mostramos el menú de registros a revisar
    aProcessing: true,//Activamos el procesamiento del datatables
    aServerSide: true,//Paginación y filtrado realizados por el servidor
    dom: '<Bl<f>rtip>',//Definimos los elementos del control de tabla
    buttons: [
      { extend: 'copyHtml5', footer: true, exportOptions: { columns: [0,1,2,3,4,5,6,7], } }, 
      { extend: 'excelHtml5', footer: true, exportOptions: { columns: [0,1,2,3,4,5,6,7], } }, 
      { extend: 'pdfHtml5', footer: false, orientation: 'landscape', pageSize: 'LEGAL', exportOptions: { columns: [0,1,2,3,4,5,6,7], } }, 
    ],
    ajax:{
      url: '../ajax/datos_hijos.php?op=tbla_principal',
      type : "get",
      dataType : "json",						
      error: function(e){
        console.log(e.responseText);  ver_errores(e);
      }
    },
    createdRow: function (row, data, ixdex) {
      // columna: #
      if (data[0] != '') { $("td", row).eq(0).addClass('text-center'); } 
      // columna: 1
      if (data[1] != '') { $("td", row).eq(1).addClass('text-nowrap'); }
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
      // { targets: [9, 10, 11, 12, 13, 14, 15, 16,17], visible: false, searchable: false, }, 
    ],
  }).DataTable();  
  $('.cargando').hide();
}

//Función para guardar o editar
function guardar_y_editar_hijo(e) {
  // e.preventDefault(); //No se activará la acción predeterminada del evento
  var formData = new FormData($("#form-hijo")[0]);

  $.ajax({
    url: "../ajax/datos_hijos.php?op=guardaryeditar",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function (e) {
      try {
        e = JSON.parse(e);  //console.log(e); 
        if (e.status == true) {	
          Swal.fire("Correcto!", "Trabajador guardado correctamente", "success");
          tabla.ajax.reload(null, false);          
          limpiar();
          $("#modal-agregar-hijo").modal("hide"); 

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
function mostrar(idhijos) {
  $(".tooltip").removeClass("show").addClass("hidde");
  limpiar();  

  $("#cargando-1-fomulario").hide();
  $("#cargando-2-fomulario").show();

  $("#modal-agregar-hijo").modal("show")

  $.post("../ajax/datos_hijos.php?op=mostrar", { idhijos: idhijos }, function (e, status) {

    e = JSON.parse(e);  console.log(e);   

    if (e.status == true) {
      
      $("#idhijos").val(e.data.idhijos);
      $("#tipo_documento").val("DNI").trigger("change");
      $("#nombre_h_").val(e.data.nombres);
      $("#num_documento").val(e.data.dni);
      $("#apellido_h_").val(e.data.apellidos);
      $("#sexo").val(e.data.sexo).trigger("change");   
      $("#nacimiento").datepicker("setDate" , format_d_m_a(e.data.fecha_nacimiento)); 
       
      $("#cargando-1-fomulario").show();
      $("#cargando-2-fomulario").hide();

    } else {
      ver_errores(e);
    }    
  }).fail( function(e) { ver_errores(e); } );
}
//Función para desactivar registros
function desactivar(idhijos,nombre,apellidos) {
  Swal.fire({
    title: "Está Seguro de  Desactivar a",
    html: `<del style="color: red;"><b>${nombre} ${apellidos}</b></del>`,
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#28a745",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, desactivar!",
  }).then((result) => {
    if (result.isConfirmed) {
      $.post("../ajax/datos_hijos.php?op=desactivar", { idhijos: idhijos }, function (e) {
        Swal.fire("Desactivado!", "Tu registro ha sido desactivado.", "success");
        tabla.ajax.reload(null, false); 
      });
    }
  });
}

//Función para activar registros
function activar(idhijos,nombre,apellidos) {
  Swal.fire({
    title: "Está Seguro de  Activar el registro a",
    html: `<del style="color: red;"><b>${nombre} ${apellidos}</b></del>`,
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#28a745",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, activar!",
  }).then((result) => {
    if (result.isConfirmed) {
      $.post("../ajax/datos_hijos.php?op=activar", { idhijos: idhijos }, function (e) {
        Swal.fire("Activado!", "Tu registro ha sido activado.", "success");
        tabla.ajax.reload();
      });
    }
  });
}
// .....::::::::::::::::::::::::::::::::::::: V A L I D A T E   F O R M  :::::::::::::::::::::::::::::::::::::::..

$(function () {   

  $("#sexo").on('change', function() { $(this).trigger('blur'); });

  $("#form-hijo").validate({
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
      guardar_y_editar_hijo(e);

    },
  });

  $("#sexo").rules('add', { required: true, messages: {  required: "Campo requerido" } });
});


