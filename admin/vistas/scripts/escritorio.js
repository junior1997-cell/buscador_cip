var tabla;
//Función que se ejecuta al inicio
function init() {

  // $("#bloc_Recurso").addClass("menu-open bg-color-191f24");

  $("#mEscritorio").addClass("active");

  // $("#lAllTrabajador").addClass("active");

  tbla_principal();

  // ══════════════════════════════════════ S E L E C T 2 ══════════════════════════════════════
  // lista_select2("../ajax/ajax_general.php?op=select2Banco", '#banco_0', null);

  // ══════════════════════════════════════ G U A R D A R   F O R M ══════════════════════════════════════
  // $("#guardar_registro").on("click", function (e) {  $("#submit-form-trabajador").submit(); });  

  // ══════════════════════════════════════ INITIALIZE SELECT2 ══════════════════════════════════════
  // $("#banco_0").select2({templateResult: formatState, theme: "bootstrap4", placeholder: "Selecione banco", allowClear: true, });



  // $('#nacimiento').datepicker({ format: "dd-mm-yyyy", language: "es", autoclose: true, endDate: moment().format('DD/MM/YYYY'), clearBtn: true, weekStart: 0, orientation: "bottom auto", todayBtn: true });
  // Formato para telefono
  $("[data-mask]").inputmask();
}

// click input group para habilitar: datepiker
$('.click-btn-nacimiento').on('click', function (e) {$('#nacimiento').focus().select(); });

init();

//Función Listar
function tbla_principal() {
  $.post("../ajax/escritorio.php?op=mostrar_datos_colegiado_esposo_hijos_experiencia_laboral", function (e, status) {
    e = JSON.parse(e);  console.log(e);   
    if (e.status == true) {

      $('#div-todo-sobre-mi').html(`
        <strong class="text-success"><i class="fas fa-book mr-1 text-success"></i> CIP</strong>
        <p class="text-muted">${e.data.colegiado.codigo_cip}</p>

        <hr class="my-1">

        <strong class="text-success"><i class="fa-regular fa-envelope mr-1 text-success"></i> Correo</strong>
        <p class="text-muted">${e.data.colegiado.email}</p>

        <hr class="my-1">

        <strong class="text-success"><i class="fa-regular fa-calendar-days mr-1 text-success"></i> Fecha Incorporacion</strong>
        <p class="text-muted">${format_d_m_a(e.data.colegiado.fecha_incorporacion)}</p>

        <hr class="my-1">

        <strong class="text-success"><i class="fa-regular fa-id-badge mr-1 text-success"></i> Capitulo</strong>
        <p class="text-muted">${e.data.colegiado.capitulo}</p>
      `);
      
      if (e.data.esposo == null ) {
        $("#div-esposo").append('─ Asigna a tu esposo(a), si no lo tiene omita este mensaje.');
      }else{
        $('#actualizado-esposo').html(`Actualizado el: ${e.data.esposo.updated_at}`);
        $("#div-esposo").append(`
          <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
            <div class="card bg-light d-flex flex-fill">
              <div class="card-header text-muted border-bottom-0">
                Digital Strategist
              </div>
              <div class="card-body pt-0">
                <div class="row">
                  <div class="col-7">
                    <h2 class="lead"><b>Nicole Pearson</b></h2>
                    <p class="text-muted text-sm"><b>About: </b> Web Designer / UX / Graphic Artist / Coffee Lover </p>
                    <ul class="ml-4 mb-0 fa-ul text-muted">
                      <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Address: Demo Street 123, Demo City 04312, NJ</li>
                      <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Phone #: + 800 - 12 12 23 52</li>
                    </ul>
                  </div>
                  <div class="col-5 text-center">
                    <img src="../../dist/img/user1-128x128.jpg" alt="user-avatar" class="img-circle img-fluid">
                  </div>
                </div>
              </div>
              <div class="card-footer">
                <div class="text-right">
                  <a href="#" class="btn btn-sm bg-teal">
                    <i class="fas fa-comments"></i>
                  </a>
                  <a href="#" class="btn btn-sm btn-primary">
                    <i class="fas fa-user"></i> View Profile
                  </a>
                </div>
              </div>
            </div>
          </div>
        `);
      }

      if (e.data.hijos == null) {
        $("#div-hijos").append('─ Asigna a tus hijos, si no lo tiene omita este mensaje.');
      } else {
        $('#actualizado-hijos').html(`Actualizado el: ${e.data.hijos.updated_at}`);
        $("#div-hijos").append(`
          <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
            <div class="card bg-light d-flex flex-fill">
              <div class="card-header text-muted border-bottom-0">
                Digital Strategist
              </div>
              <div class="card-body pt-0">
                <div class="row">
                  <div class="col-7">
                    <h2 class="lead"><b>Nicole Pearson</b></h2>
                    <p class="text-muted text-sm"><b>About: </b> Web Designer / UX / Graphic Artist / Coffee Lover </p>
                    <ul class="ml-4 mb-0 fa-ul text-muted">
                      <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Address: Demo Street 123, Demo City 04312, NJ</li>
                      <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Phone #: + 800 - 12 12 23 52</li>
                    </ul>
                  </div>
                  <div class="col-5 text-center">
                    <img src="../../dist/img/user1-128x128.jpg" alt="user-avatar" class="img-circle img-fluid">
                  </div>
                </div>
              </div>
              <div class="card-footer">
                <div class="text-right">
                  <a href="#" class="btn btn-sm bg-teal">
                    <i class="fas fa-comments"></i>
                  </a>
                  <a href="#" class="btn btn-sm btn-primary">
                    <i class="fas fa-user"></i> View Profile
                  </a>
                </div>
              </div>
            </div>
          </div>
        `);
      }

      if (e.data.experiencia.length === 0) {
        $("#div-experiencia-laboral").html('─ Asigna tu experiencia laboral.');
      } else {

        var data_html = "";

        e.data.experiencia.forEach((val, key) => {

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
                
              </div>
            </div>                   
          `);
        }); 

        $('#div-experiencia-laboral').html(`
          <div class="col-md-12">
            <!-- The time line -->
            <div class="timeline"> ${data_html} <div><i class="fas fa-clock bg-gray"></i></div> </div>
            <!-- END timeline item -->
          </div>
        `);        
      }

      // cargamos la imagen adecuada par el archivo
      if (e.data.colegiado.documento_cv == null || e.data.colegiado.documento_cv == "") {
        $("#div-pdf-cv").html('─ No tiene doc');
      } else {
        var ver_doc = doc_view_extencion(e.data.colegiado.documento_cv, 'colegiado', 'cv', '100%', '406');
        $("#div-pdf-cv").html(ver_doc);
      }
      
      $('[data-toggle="tooltip"]').tooltip();

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
      banco_0:        { required: true},
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