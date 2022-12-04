var tabla; var tabla2;
var cant_banco_multimple = 1;
//Función que se ejecuta al inicio
function init() {

  $("#bloc_Recurso").addClass("menu-open bg-color-191f24");

  $("#mRecurso").addClass("active");

  $("#lAllTrabajador").addClass("active");

  tbla_principal();

  // ══════════════════════════════════════ S E L E C T 2 ══════════════════════════════════════
  lista_select2("../ajax/ajax_general.php?op=select2Banco", '#banco_0', null);
  lista_select2("../ajax/ajax_general.php?op=select2TipoTrabajador", '#tipo', null);
  lista_select2("../ajax/ajax_general.php?op=select2OcupacionTrabajador", '#ocupacion', null);
  lista_select2("../ajax/ajax_general.php?op=select2DesempenioTrabajador", '#desempenio', null);  

  // ══════════════════════════════════════ G U A R D A R   F O R M ══════════════════════════════════════
  $("#guardar_registro").on("click", function (e) {  $("#submit-form-trabajador").submit(); });  

  // ══════════════════════════════════════ INITIALIZE SELECT2 ══════════════════════════════════════
  $("#banco_0").select2({templateResult: formatState, theme: "bootstrap4", placeholder: "Selecione banco", allowClear: true, });
  $("#tipo").select2({ theme: "bootstrap4", placeholder: "Selecione tipo", allowClear: true, });
  $("#ocupacion").select2({ theme: "bootstrap4",  placeholder: "Selecione Ocupación", allowClear: true, });
  $("#desempenio").select2({ theme: "bootstrap4",  placeholder: "Selecione Desempeño", allowClear: true, });

  //no_select_tomorrow('#nacimiento');

  //$('#nacimiento').inputmask('dd-mm-yyyy', { 'placeholder': 'dd-mm-yyyy' })
  $('#nacimiento').datepicker({ format: "dd-mm-yyyy", language: "es", autoclose: true, endDate: moment().format('DD/MM/YYYY'), clearBtn: true, weekStart: 0, orientation: "bottom auto", todayBtn: true });
  // Formato para telefono
  $("[data-mask]").inputmask();
}

// click input group para habilitar: datepiker
$('.click-btn-nacimiento').on('click', function (e) {$('#nacimiento').focus().select(); });

init();

function formatState (state) {
  //console.log(state);
  if (!state.id) { return state.text; }
  var baseUrl = state.title != '' ? `../dist/docs/banco/logo/${state.title}`: '../dist/docs/banco/logo/logo-sin-banco.svg'; 
  var onerror = `onerror="this.src='../dist/docs/banco/logo/logo-sin-banco.svg';"`;
  var $state = $(`<span><img src="${baseUrl}" class="img-circle mr-2 w-25px" ${onerror} />${state.text}</span>`);
  return $state;
};

// abrimos el navegador de archivos
$("#foto1_i").click(function() { $('#foto1').trigger('click'); });
$("#foto1").change(function(e) { addImage(e,$("#foto1").attr("id")) });

$("#doc4_i").click(function() {  $('#doc4').trigger('click'); });
$("#doc4").change(function(e) {  addImageApplication(e,$("#doc4").attr("id")) });

function foto1_eliminar() {

	$("#foto1").val("");

	$("#foto1_i").attr("src", "../dist/img/default/img_defecto.png");

	$("#foto1_nombre").html("");
}

// Eliminamos el doc 4
function doc4_eliminar() {

	$("#doc4").val("");

	$("#doc4_ver").html('<img src="../dist/svg/pdf_trasnparent.svg" alt="" width="50%" >');

	$("#doc4_nombre").html("");
}

//Función limpiar
function limpiar_form_trabajador() {
  cant_banco_multimple = 1;
  $("#guardar_registro").html('Guardar Cambios').removeClass('disabled');

  $("#idtrabajador").val("");
  $("#tipo_documento option[value='DNI']").attr("selected", true);
  $("#nombre").val(""); 
  $("#num_documento").val(""); 
  $("#direccion").val(""); 
  $("#telefono").val(""); 
  $("#email").val(""); 
  $("#nacimiento").val("");
  $("#edad").val("0");  $("#p_edad").html("0");    
  $("#cta_bancaria").val("");  
  $("#cci").val("");  
  $("#banco_0").val("").trigger("change"); $("#lista_bancos").html("");

  $("#tipo").val("").trigger("change");
  $("#ocupacion").val("").trigger("change");
  $("#desempenio").val("").trigger("change");
  $("#titular_cuenta").val("");

  $("#foto1_i").attr("src", "../dist/img/default/img_defecto.png");
	$("#foto1").val("");
	$("#foto1_actual").val("");  
  $("#foto1_nombre").html(""); 

  $("#doc4").val("");
  $("#doc_old_4").val("");
  $("#doc4_ver").html('<img src="../dist/svg/pdf_trasnparent.svg" alt="" width="50%" >');
  $("#doc4_nombre").html('');

  
  // Limpiamos las validaciones
  $(".form-control").removeClass('is-valid');
  $(".form-control").removeClass('is-invalid');
  $(".error.invalid-feedback").remove();
}

//Función Listar
function tbla_principal() {

  tabla=$('#tabla-trabajador').dataTable({
    responsive: true,
    lengthMenu: [[ -1, 5, 10, 25, 75, 100, 200,], ["Todos", 5, 10, 25, 75, 100, 200, ]],//mostramos el menú de registros a revisar
    aProcessing: true,//Activamos el procesamiento del datatables
    aServerSide: true,//Paginación y filtrado realizados por el servidor
    dom: '<Bl<f>rtip>',//Definimos los elementos del control de tabla
    buttons: [
      { extend: 'copyHtml5', footer: true, exportOptions: { columns: [0,9,10,11,3,4,12,13,14,15,16,5,], } }, 
      { extend: 'excelHtml5', footer: true, exportOptions: { columns: [0,9,10,11,3,4,12,13,14,15,16,5,], } }, 
      { extend: 'pdfHtml5', footer: false, orientation: 'landscape', pageSize: 'LEGAL', exportOptions: { columns: [0,9,10,11,3,4,12,13,14,15,16,5,], } }, 
    ],
    ajax:{
      url: '../ajax/all_trabajador.php?op=tbla_principal',
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
      { targets: [9, 10, 11, 12, 13, 14, 15, 16,17], visible: false, searchable: false, }, 
    ],
  }).DataTable();  
}

//Función para guardar o editar
function guardar_y_editar_trabajador(e) {
  // e.preventDefault(); //No se activará la acción predeterminada del evento
  var formData = new FormData($("#form-trabajador")[0]);

  $.ajax({
    url: "../ajax/all_trabajador.php?op=guardaryeditar",
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
          limpiar_form_trabajador();
          $("#modal-agregar-trabajador").modal("hide"); 
          cant_banco_multimple = 1; 
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
function mostrar(idtrabajador) {
  $(".tooltip").removeClass("show").addClass("hidde");
  limpiar_form_trabajador();  

  $("#cargando-1-fomulario").hide();
  $("#cargando-2-fomulario").show();

  $("#modal-agregar-trabajador").modal("show")

  $.post("../ajax/all_trabajador.php?op=mostrar", { idtrabajador: idtrabajador }, function (e, status) {

    e = JSON.parse(e);  console.log(e);   

    if (e.status == true) {       

      $(`#tipo_documento option[value='${e.data.trabajador.tipo_documento}']`).attr("selected", true);
      $("#nombre").val(e.data.trabajador.nombres);
      $("#num_documento").val(e.data.trabajador.numero_documento);
      $("#direccion").val(e.data.trabajador.direccion);
      $("#telefono").val(e.data.trabajador.telefono);
      $("#email").val(e.data.trabajador.email);
      $("#nacimiento").datepicker("setDate" , format_d_m_a(e.data.trabajador.fecha_nacimiento));      
      $("#tipo").val(e.data.trabajador.idtipo_trabajador).trigger("change");      
      $("#titular_cuenta").val(e.data.trabajador.titular_cuenta);
      $("#idtrabajador").val(e.data.trabajador.idtrabajador);
      $("#ruc").val(e.data.trabajador.ruc);     

      $("#ocupacion").val(e.data.trabajador.idocupacion).trigger('change');
      $("#desempenio").val(e.data.detalle_desempenio).trigger('change');
      
      e.data.bancos.forEach(function(valor, index){ 
        
        if ( index > 0 ) { 
          add_bancos(valor.idbancos); 
          $(`.cta_bancaria_${index}`).val(valor.cuenta_bancaria);
          $(`.cci_${index}`).val(valor.cci);
          if (valor.banco_seleccionado == '1') { $(`#banco_seleccionado_${index}`).prop('checked', true); } 
          //console.log('crear - banco: ' + valor.idbancos + ' index: '+ index + ' select: '+ valor.banco_seleccionado);
        } else {
          $(`.cta_bancaria_${index}`).val(valor.cuenta_bancaria);
          $(`.cci_${index}`).val(valor.cci);
          $(`#banco_${index}`).val(valor.idbancos).trigger("change");
          if (valor.banco_seleccionado == '1') { $(`#banco_seleccionado_${index}`).prop('checked', true); } 
          //console.log('editar - banco: ' + valor.idbancos + ' index: '+ index + ' select: '+ valor.banco_seleccionado);
        }       
         
      }); 
      
      if (e.data.trabajador.imagen_perfil!="") {
        $("#foto1_i").attr("src", "../dist/docs/all_trabajador/perfil/" + e.data.trabajador.imagen_perfil);
        $("#foto1_actual").val(e.data.trabajador.imagen_perfil);
      }

      if (e.data.trabajador.imagen_dni_anverso != "") {
        $("#foto2_i").attr("src", "../dist/docs/all_trabajador/dni_anverso/" + e.data.trabajador.imagen_dni_anverso);
        $("#foto2_actual").val(e.data.trabajador.imagen_dni_anverso);
      }

      if (e.data.trabajador.imagen_dni_reverso != "") {
        $("#foto3_i").attr("src", "../dist/docs/all_trabajador/dni_reverso/" + e.data.trabajador.imagen_dni_reverso);
        $("#foto3_actual").val(e.data.trabajador.imagen_dni_reverso);
      }

      //validamoos DOC-4
      if (e.data.trabajador.cv_documentado != "" ) {
        $("#doc_old_4").val(e.data.trabajador.cv_documentado);
        $("#doc4_nombre").html('CV documentado.' + extrae_extencion(e.data.trabajador.cv_documentado));
        var doc_html = doc_view_extencion(e.data.trabajador.cv_documentado, 'all_trabajador', 'cv_documentado', '100%', '210' );
        $("#doc4_ver").html(doc_html);         
      } else {
        $("#doc4_ver").html('<img src="../dist/svg/pdf_trasnparent_no.svg" alt="" width="50%" >');
        $("#doc4_nombre").html('');
        $("#doc_old_4").val("");
      }

      //validamoos DOC-5
      if (e.data.trabajador.cv_no_documentado != "" ) {
        $("#doc_old_5").val(e.data.trabajador.cv_no_documentado);
        $("#doc5_nombre").html('CV no documentado.' + extrae_extencion(e.data.trabajador.cv_no_documentado));
        var doc_html = doc_view_extencion(e.data.trabajador.cv_no_documentado, 'all_trabajador', 'cv_no_documentado', '100%', '210' );
        $("#doc5_ver").html(doc_html);        
      } else {
        $("#doc5_ver").html('<img src="../dist/svg/pdf_trasnparent_no.svg" alt="" width="50%" >');
        $("#doc5_nombre").html('');
        $("#doc_old_5").val("");
      }

      calcular_edad('#nacimiento','#edad','#p_edad');

       

      $("#cargando-1-fomulario").show();
      $("#cargando-2-fomulario").hide();

    } else {
      ver_errores(e);
    }    
  }).fail( function(e) { ver_errores(e); } );
}

// .....::::::::::::::::::::::::::::::::::::: V A L I D A T E   F O R M  :::::::::::::::::::::::::::::::::::::::..

$(function () {   

  $("#banco_0").on('change', function() { $(this).trigger('blur'); });
  $("#tipo").on('change', function() { $(this).trigger('blur'); });
  $("#ocupacion").on('change', function() { $(this).trigger('blur'); });
  $("#desempenio").on('change', function() { $(this).trigger('blur'); });

  $("#form-trabajador").validate({
    rules: {
      tipo_documento: { required: true },
      num_documento:  { required: true, minlength: 6, maxlength: 20 },
      nombre:         { required: true, minlength: 6, maxlength: 100 },
      email:          { email: true, minlength: 10, maxlength: 50 },
      direccion:      { minlength: 5, maxlength: 70 },
      telefono:       { minlength: 8 },
      tipo_trabajador:{ required: true},
      cta_bancaria:   { minlength: 10,},
      banco_0:      { required: true},
      banco_seleccionado:{ required: true},
      tipo:           { required: true},
      ocupacion:      { required: true},
      desempenio:     { required: true},
      ruc:            { minlength: 11, maxlength: 11},
    },
    messages: {
      tipo_documento: { required: "Campo requerido.", },
      num_documento:  { required: "Campo requerido.", minlength: "MÍNIMO 6 caracteres.", maxlength: "MÁXIMO 20 caracteres.", },
      nombre:         { required: "Campo requerido.", minlength: "MÍNIMO 6 caracteres.", maxlength: "MÁXIMO 100 caracteres.", },
      email:          { required: "Campo requerido.", email: "Ingrese un coreo electronico válido.", minlength: "MÍNIMO 10 caracteres.", maxlength: "MÁXIMO 50 caracteres.", },
      direccion:      { minlength: "MÍNIMO 5 caracteres.", maxlength: "MÁXIMO 70 caracteres.", },
      telefono:       { minlength: "MÍNIMO 8 caracteres.", },
      tipo_trabajador:{ required: "Campo requerido.", },
      cta_bancaria:   { minlength: "MÍNIMO 10 caracteres.", },
      tipo:           { required: "Campo requerido.", },
      ocupacion:      { required: "Campo requerido.", },
      desempenio:     { required: "Campo requerido.", },
      banco_0:        { required: "Campo requerido.", },
      banco_seleccionado:{ required: "Requerido.", },
      ruc:            { minlength: "MÍNIMO 11 caracteres.", maxlength: "MÁXIMO 11 caracteres.", },
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
      guardar_y_editar_trabajador(e);

    },
  });

  $("#banco_0").rules('add', { required: true, messages: {  required: "Campo requerido" } });
  $("#tipo").rules('add', { required: true, messages: {  required: "Campo requerido" } });
  $("#ocupacion").rules('add', { required: true, messages: {  required: "Campo requerido" } });
  $("#desempenio").rules('add', { required: true, messages: {  required: "Campo requerido" } });
});

// .....::::::::::::::::::::::::::::::::::::: F U N C I O N E S    A L T E R N A S  :::::::::::::::::::::::::::::::::::::::..

function ver_perfil(file, nombre) {
  $('.modal-title-perfil-trabajador').html(nombre);
  $(".tooltip").removeClass("show").addClass("hidde");
  $("#modal-ver-perfil-trabajador").modal("show");
  $('#html-perfil-trabajador').html(`<span class="jq_image_zoom"><img class="img-thumbnail" src="${file}" onerror="this.src='../dist/svg/user_default.svg';" alt="Perfil" width="100%"></span>`);
  $('.jq_image_zoom').zoom({ on:'grab' });
}