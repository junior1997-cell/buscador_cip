var tabla;
//Función que se ejecuta al inicio
function init() {

  $("#lExperienciaLaboral").addClass("active");

  listar_datos_experiencia();
  tabla_empresa_laboral();

  // ══════════════════════════════════════ S E L E C T 2 ══════════════════════════════════════
  lista_select2("../ajax/ajax_general.php?op=select2Empresa", '#empresa_select2', null);

  // ══════════════════════════════════════ G U A R D A R   F O R M ══════════════════════════════════════
  $("#guardar_registro_experiencia").on("click", function (e) {  $("#submit-form-experiencia-laboral").submit(); });  
  $("#guardar_registro_empresa").on("click", function (e) {  $("#submit-form-empresa").submit(); });  

  // ══════════════════════════════════════ INITIALIZE SELECT2 ══════════════════════════════════════ 
  $("#empresa_select2").select2({ theme: "bootstrap4", placeholder: "Selecione empresa", allowClear: true, });
  $("#bg_color_select2").select2({ templateResult: templateColor, theme: "bootstrap4", placeholder: "Selecione empresa", allowClear: true, });
  
  // Formato para telefono
  $("[data-mask]").inputmask();
}

init();

function templateColor (state) {
  //console.log(state);
  if (!state.id) { return state.text; }  
  var $state = $(`<span ><span class="${state.title}">....</span> ${state.text}</span>`);
  return $state;
};

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
  $("#bg_color_select2").val("").trigger("change");

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
          listar_datos_experiencia(); 
          limpiar_form_experiencia();  
          $('#modal-agregar-experiencia-laboral').modal('hide'); 
          limpiar_fecha_fin();
        }else{
          ver_errores(e);
        }
      } catch (err) { console.log('Error: ', err.message); toastr_error("Error temporal!!",'Puede intentalo mas tarde, o comuniquese con:<br> <i><a href="tel:+51921305769" >921-305-769</a></i> ─ <i><a href="tel:+51921487276" >921-487-276</a></i>', 700); }      

      $("#guardar_registro_experiencia").html('Guardar Cambios').removeClass('disabled');
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
      $("#guardar_registro_experiencia").html('<i class="fas fa-spinner fa-pulse fa-lg"></i>').addClass('disabled');
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
function listar_datos_experiencia() {
  $('#div-html-lista-experiencia').html(`<div class="col-lg-12 text-center"><i class="fas fa-spinner fa-pulse fa-6x"></i><br/><br/><h4>Cargando...</h4></div>`);
  $(".tooltip").removeClass("show").addClass("hidde");   

  $.post("../ajax/experiencia_laboral.php?op=listar_datos_experiencia", function (e, status) {

    e = JSON.parse(e);  console.log(e);   

    if (e.status == true) { 

      var data_html = "";

      if (e.data.length === 0) {

        $('#div-html-lista-experiencia').html("─ Asigna tu experiencia laboral.");

      } else {

        e.data.forEach((val, key) => {

          var fecha_fin = val.trabajo_actual == '0' ? `${moment(val.fecha_inicio).format('DD')} ${extraer_nombre_mes_abreviados(val.fecha_inicio)} ${moment(val.fecha_inicio).format('YYYY')}`: 'Actual' ;

          var certificado = val.certificado == '' || val.certificado == null  ? `<button class="btn btn-outline-info btn-sm" data-toggle="tooltip" data-original-title="Vacio"><i class="fa-regular fa-file-pdf fa-2x"></i></button>`:  `<a href="../dist/docs/experiencia_laboral/certificado/${val.certificado}" class="btn btn-info btn-sm" target="_blank" data-toggle="tooltip" data-original-title="Ver doc"><i class="fa-regular fa-file-pdf fa-2x"></i></a>`;

          data_html = data_html.concat(`
            <!-- timeline time label -->
            <div class="time-label">
              <span class="${val.bg_color}">${moment(val.fecha_inicio).format('DD')} ${extraer_nombre_mes_abreviados(val.fecha_inicio)} ${moment(val.fecha_inicio).format('YYYY')}</span> &nbsp; al &nbsp; <span class="${val.bg_color}">${fecha_fin}</span>
            </div>
            <!-- /.timeline-label -->
            <!-- timeline item -->
            <div class="mb-5">
              <i class="fas fa-briefcase ${val.bg_color}"></i>
              <div class="timeline-item">
                <span class="time"><i class="fas fa-clock"></i> ${moment(val.updated_at).format('LT')}</span>
                <h3 class="timeline-header"><a href="${val.url_empresa}" target="_blank">${val.razon_social}</a> click para visitar</h3>

                <div class="timeline-body">
                  <div class="row">
                    <div class="col-6">
                      <div class="text-primary"><label for="">DETALLE COLEGIADO</label></div>
                    </div>
                    <div class="col-6">                       
                      <div class="text-primary"><label for="">DETALLE EMPRESA</label></div>                       
                    </div>
                    <div class="col-6" >
                      <div class="card px-3 py-2" style="box-shadow: 0 0 1px rgb(0 0 0), 0 1px 3px rgb(0 0 0 / 60%); ">
                        <div class="mt-2"><span class="text-bold">Fecha Inicio: </span> ${format_d_m_a(val.fecha_inicio)} </div>
                        <div class="mt-2"><span class="text-bold">Fecha Fin: </span> ${val.fecha_fin} </div>
                        <div class="mt-2"><span class="text-bold">Cargo Laboral: </span> ${val.cargo_laboral} </div>
                        <div class="mt-2"><span class="text-bold">Certificado: </span> ${certificado} </div>
                      </div> 
                    </div>              

                    <div class="col-6" >
                      <div class="card px-3 py-2" style="box-shadow: 0 0 1px rgb(0 0 0), 0 1px 3px rgb(0 0 0 / 60%); ">
                        <div class="mt-2"><span class="text-bold">Razon Social: </span> ${val.razon_social} </div>
                        <div class="mt-2"><span class="text-bold">RUC: </span> ${val.ruc} </div>
                        <div class="mt-2"><span class="text-bold">Celular: </span> ${val.celular} </div> 
                        <div class="mt-2"><span class="text-bold">Dirección: </span> ${val.direccion} </div>
                        <div class="mt-2"><span class="text-bold">Correo: </span><a href="mailto:${val.correo}">${val.correo}</a></div>                        
                      </div> 
                    </div>
                  </div>
                  
                </div>
                <div class="timeline-footer">
                  <button class="btn btn-warning btn-sm" onclick="mostrar_editar_experiencia(${val.idexperiencia_laboral})"><i class="fa-solid fa-pencil"></i> Editar</button>
                  <button class="btn btn-danger btn-sm" onclick="eliminar_experiencia(${val.idexperiencia_laboral}, '${val.razon_social}')"><i class="fa-solid fa-trash-can"></i> Eliminar</button>
                </div>
              </div>
            </div>                   
          `);
        }); 

        $('#div-html-lista-experiencia').html(`
          <div class="col-md-12">
            <!-- The time line -->
            <div class="timeline"> ${data_html} <div><i class="fas fa-clock bg-gray"></i></div> </div>
            <!-- END timeline item -->
          </div>
        `);
      }      

      $('[data-toggle="tooltip"]').tooltip();

    } else {
      ver_errores(e);
    }    
  }).fail( function(e) { ver_errores(e); } );
}

// mostramos los datos para editar
function mostrar_editar_experiencia(idexperiencia_laboral) {

  $("#cargando-1-fomulario").hide();
  $("#cargando-2-fomulario").show();

  $(".tooltip").removeClass("show").addClass("hidde");  
  $('#modal-agregar-experiencia-laboral').modal('show');  

  $.post("../ajax/experiencia_laboral.php?op=mostrar_datos_experiencia",{'idexperiencia_laboral': idexperiencia_laboral}, function (e, status) {

    e = JSON.parse(e);  console.log(e);   

    if (e.status == true) {        
      $("#idexperiencia_laboral").val(e.data.idexperiencia_laboral);
      $("#fecha_inicio").val(e.data.fecha_inicio);
      $("#fecha_fin").val(e.data.fecha_fin);
      e.data.trabajo_actual == '1' ? $('#trabajo_actual').prop('checked', true) : $('#trabajo_actual').prop('checked', false); 
      $("#cargo_laboral").val(e.data.cargo_laboral);
      $("#url_empresa").val(e.data.url_empresa);

      $("#empresa_select2").val(e.data.idempresa).trigger("change");
      $("#bg_color_select2").val(e.data.bg_color).trigger("change");

      limpiar_fecha_fin();

      restrigir_fecha_input();

      $("#cargando-1-fomulario").show();
      $("#cargando-2-fomulario").hide();

    } else {
      ver_errores(e);
    }    
  }).fail( function(e) { ver_errores(e); } );
}

function eliminar_experiencia(idexperiencia_laboral, nombre) {
  Swal.fire({
    title: "¿Está Seguro de Eliminar?",
    html: `<b class="text-danger"><del>${nombre}</del></b> <br> Al <b>Eliminar</b> no podra recuperarlo.`,
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#28a745",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, Eliminar!",
  }).then((result) => {
    if (result.isConfirmed) {
      $.post("../ajax/experiencia_laboral.php?op=eliminar_experiencia", { 'idexperiencia_laboral': idexperiencia_laboral }, function (e) {
        e = JSON.parse(e);  console.log(e); 
        if (e.status == true) {
          Swal.fire("Eliminado!", "Tu Experiencia Laboral ha sido eliminada.", "success");    
          listar_datos_experiencia();          
        } else {
          ver_errores(e);
        }        
      }).fail( function(e) { ver_errores(e); } );    
    }
  });   
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
  $("#bg_color_select2").on('change', function() { $(this).trigger('blur'); });

  $("#form-experiencia-laboral").validate({
    rules: {
      empresa_select2:  { required: true, },
      fecha_inicio:     { required: true,  },
      fecha_fin:        { required: true,  },
      cargo_laboral:    { required: true, minlength: 4, maxlength: 100 },
      url_empresa:      { minlength: 8, maxlength: 200 },
      bg_color_select2: { required: true, },
    },
    messages: {
      empresa_select2:  { required: "Campo requerido.", },
      fecha_inicio:     { required: "Campo requerido.", },
      fecha_fin:        { required: "Campo requerido.", },
      cargo_laboral:    { required: "Campo requerido.", minlength: "MÍNIMO 4 caracteres.", maxlength: "MÁXIMO 100 caracteres.", },
      url_empresa:      { minlength: "MÍNIMO 8 caracteres.", maxlength: "MÁXIMO 200 caracteres.", },
      bg_color_select2: { required: "Campo requerido.", },
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
  $("#bg_color_select2").rules('add', { required: true, messages: {  required: "Campo requerido" } });
  
});

// .....::::::::::::::::::::::::::::::::::::: F U N C I O N E S    A L T E R N A S  :::::::::::::::::::::::::::::::::::::::..

function restrigir_fecha_input() {  restrigir_fecha_ant("#fecha_fin",$("#fecha_inicio").val());}