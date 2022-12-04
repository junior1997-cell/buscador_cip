<?php
  //Activamos el almacenamiento en el buffer
  ob_start();
  session_start();

  if (!isset($_SESSION["nombre"])){
    header("Location: index.php?file=".basename($_SERVER['PHP_SELF']));
  }else{ ?>
    <!DOCTYPE html>
    <html lang="es">
      <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Experiencia Laboral | CIP</title>

        <?php $title = "Experiencia Laboral"; require 'head.php'; ?>
     
        <link rel="stylesheet" href="../dist/css/switch_domingo.css">
      </head>
      <body class="hold-transition sidebar-mini sidebar-collapse layout-fixed layout-navbar-fixed ">
        
        <div class="wrapper">
          <!-- Preloader -->
          <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="../dist/svg/logo-principal.svg" alt="AdminLTELogo" width="360" />
          </div>
        
          <?php
            require 'nav.php';
            require 'aside.php';
            if ($_SESSION['colegiado']==1){
              //require 'enmantenimiento.php';
              ?>           
              <!--Contenido-->
              <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                  <div class="container-fluid">
                    <div class="row mb-2">
                      <div class="col-sm-6">
                        <h1 class="m-0">Experiencia Laboral</h1>
                      </div>
                      <!-- /.col -->
                      <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                          <li class="breadcrumb-item"><a href="experiencia_laboral.php">Home</a></li>
                          <li class="breadcrumb-item active">Experiencia</li>
                        </ol>
                      </div>
                      <!-- /.col -->
                    </div>
                    <!-- /.row -->
                  </div>
                  <!-- /.container-fluid -->
                </div>
                <!-- /.content-header -->

                <!-- Main content -->
                <section class="content">
                  <div class="container-fluid">
                    <div class="card card-default color-palette-box">
                      <div class="card-header">
                        <h3 class="card-title">
                          <button type="button" class="btn btn-success" title="Agregar" data-toggle="modal" data-target="#modal-agregar-experiencia-laboral">
                            <i class="far fa-plus"></i> Agregar Experiencia
                          </button>
                          <button type="button" class="btn btn-warning" title="Agregar" data-toggle="modal" data-target="#modal-tabla-empresa">
                            <i class="fa-solid fa-building"></i> Agregar Empresa
                          </button>
                        </h3>
                      </div>
                      <div class="card-body">
                        <!-- Timelime example  -->
                        <div class="row">
                          <div class="col-md-12">
                            <!-- The time line -->
                            <div class="timeline">
                              <!-- timeline time label -->
                              <div class="time-label">
                                <span class="bg-red">10 Feb. 2014</span>
                              </div>
                              <!-- /.timeline-label -->
                              <!-- timeline item -->
                              <div>
                                <i class="fas fa-envelope bg-blue"></i>
                                <div class="timeline-item">
                                  <span class="time"><i class="fas fa-clock"></i> 12:05</span>
                                  <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>

                                  <div class="timeline-body">
                                    Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                                    weebly ning heekya handango imeem plugg dopplr jibjab, movity
                                    jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                                    quora plaxo ideeli hulu weebly balihoo...
                                  </div>
                                  <div class="timeline-footer">
                                    <a class="btn btn-primary btn-sm">Read more</a>
                                    <a class="btn btn-danger btn-sm">Delete</a>
                                  </div>
                                </div>
                              </div>
                              <!-- END timeline item -->
                              <!-- timeline item -->
                              <div>
                                <i class="fas fa-user bg-green"></i>
                                <div class="timeline-item">
                                  <span class="time"><i class="fas fa-clock"></i> 5 mins ago</span>
                                  <h3 class="timeline-header no-border"><a href="#">Sarah Young</a> accepted your friend request</h3>
                                </div>
                              </div>
                              <!-- END timeline item -->
                              <!-- timeline item -->
                              <div>
                                <i class="fas fa-comments bg-yellow"></i>
                                <div class="timeline-item">
                                  <span class="time"><i class="fas fa-clock"></i> 27 mins ago</span>
                                  <h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>
                                  <div class="timeline-body">
                                    Take me to your leader!
                                    Switzerland is small and neutral!
                                    We are more like Germany, ambitious and misunderstood!
                                  </div>
                                  <div class="timeline-footer">
                                    <a class="btn btn-warning btn-sm">View comment</a>
                                  </div>
                                </div>
                              </div>
                              <!-- END timeline item -->
                              <!-- timeline time label -->
                              <div class="time-label">
                                <span class="bg-green">3 Jan. 2014</span>
                              </div>
                              <!-- /.timeline-label -->
                              <!-- timeline item -->
                              <div>
                                <i class="fa fa-camera bg-purple"></i>
                                <div class="timeline-item">
                                  <span class="time"><i class="fas fa-clock"></i> 2 days ago</span>
                                  <h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos</h3>
                                  <div class="timeline-body">
                                    <img src="../../dist/img/user1-128x128.jpg" alt="...">
                                    <img src="../../dist/img/user7-128x128.jpg" alt="...">
                                    <img src="../../dist/img/user3-128x128.jpg" alt="...">
                                    <img src="../../dist/img/user4-128x128.jpg" alt="...">
                                    <img src="../../dist/img/user5-128x128.jpg" alt="...">
                                  </div>
                                </div>
                              </div>
                              <!-- END timeline item -->
                              <!-- timeline item -->
                              <div>
                                <i class="fas fa-video bg-maroon"></i>

                                <div class="timeline-item">
                                  <span class="time"><i class="fas fa-clock"></i> 5 days ago</span>

                                  <h3 class="timeline-header"><a href="#">Mr. Doe</a> shared a video</h3>

                                  <div class="timeline-body">
                                    <div class="embed-responsive embed-responsive-16by9">
                                      <!-- <iframe width="727" height="409" src="https://www.youtube.com/embed/ujRvBfyuBhI?rel=0&amp;autoplay=1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> -->
                                      <!-- <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/tMWkeBIohBs" allowfullscreen></iframe> -->
                                    </div>
                                  </div>
                                  <div class="timeline-footer">
                                    <a href="#" class="btn btn-sm bg-maroon">See comments</a>
                                  </div>
                                </div>
                              </div>
                              <!-- END timeline item -->
                              <div>
                                <i class="fas fa-clock bg-gray"></i>
                              </div>
                            </div>
                          </div>
                          <!-- /.col -->
                        </div>
                        <!-- /.row -->
                      </div>
                      <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                  </div>
                  <!-- /.container-fluid -->

                  <!-- MODAL - AGREGAR EXPERIENCIA -->
                  <div class="modal fade" id="modal-agregar-experiencia-laboral">
                    <div class="modal-dialog modal-dialog-scrollable modal-md">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Agregar - <button class="btn btn-info btn-sm">Ver diseño</button></h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span class="text-danger" aria-hidden="true">&times;</span>
                          </button>
                        </div>

                        <div class="modal-body">
                          <!-- form start -->
                          <form id="form-experiencia-laboral" name="form-experiencia-laboral" method="POST">
                            <div class="card-body p-0">
                              <div class="row" id="cargando-1-fomulario">
                                <!-- id proyecto -->
                                <input type="hidden" name="idcolegiado" id="idcolegiado" value="<?php echo $_SESSION['idusuario'] ;?>" />
                                <input type="hidden" name="idexperiencia_laboral" id="idexperiencia_laboral" /> 

                                <!-- Trabajo actual -->
                                <div class="col-lg-12 my-auto text-center">
                                  <div class="custom-control custom-checkbox">                                   
                                    <input class="custom-control-input" type="checkbox" id="trabajo_actual" name="trabajo_actual" value="1" onclick="limpiar_fecha_fin()">
                                    <label for="trabajo_actual" class="custom-control-label">Trabajo actual</label>
                                  </div>
                                </div>   

                                <!-- Empresa -->
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12 mt-4">
                                  <div class="form-group">
                                    <label for="empresa_select2">Seleccionar empresa</label>
                                    <select name="empresa_select2" id="empresa_select2" class="form-control select2" style="width: 100%;"> </select>
                                  </div>
                                </div>

                                <!-- fecha inicio -->
                                <div class="col-lg-6">
                                  <div class="form-group">
                                    <label for="fecha_inicio" class="chargue-format-1">Fecha Inicio</label>
                                    <input type="date" name="fecha_inicio" class="form-control" id="fecha_inicio" placeholder="Fecha Inicio" />
                                  </div>
                                </div>

                                <!-- fecha fin -->
                                <div class="col-lg-6">
                                  <div class="form-group">
                                    <label for="fecha_fin" class="chargue-format-1">Fecha Fin</label>
                                    <input type="date" name="fecha_fin" class="form-control" id="fecha_fin" placeholder="Fecha fin" />
                                    <div class="form-control hidden" id="span_fecha_fin">Actual</div>
                                  </div>
                                </div>                                                              

                                <!-- Cargo Laboral -->
                                <div class="col-lg-12">
                                  <div class="form-group">
                                    <label for="cargo_laboral" class="chargue-format-1">Cargo Laboral</label>
                                    <input type="text" name="cargo_laboral" class="form-control" id="cargo_laboral" placeholder="Cargo Laboral" />
                                  </div>
                                </div>

                                <!-- URl de empresa -->
                                <div class="col-lg-12">
                                  <div class="form-group">
                                    <label for="url_empresa" class="chargue-format-1">URL página empresa</label>
                                    <textarea class="form-control" id="url_empresa" name="url_empresa" placeholder="URL página empresa"></textarea>
                                  </div>
                                </div>

                                <!-- Pdf 1 -->
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12 mt-2">
                                  <!-- linea divisoria -->
                                  <div class="col-lg-12 borde-arriba-naranja mt-2"></div>
                                  <div class="row mt-1">
                                    <div class="col-md-12 text-center mb-2" >
                                      <label for="Presupuesto" class="control-label">Certificado</label>
                                    </div>
                                    <div class="col-6 col-md-6 col-lg-6 col-xl-6 text-center">
                                      <button type="button" class="btn btn-success btn-block btn-xs" id="doc1_i"><i class="fas fa-file-upload"></i> Subir.</button>
                                      <input type="hidden" id="doc_old_1" name="doc_old_1" />
                                      <input style="display: none;" id="doc1" type="file" name="doc1" accept=".pdf, .docx, .doc" class="docpdf" />
                                    </div>
                                    <div class="col-6 col-md-6 col-lg-6 col-xl-6 text-center">
                                      <button type="button" class="btn btn-info btn-block btn-xs" onclick="re_visualizacion(1, 'colegiado', 'cv');"><i class="fa fa-eye"></i> PDF.</button>
                                    </div>
                                  </div>
                                  <div id="doc1_ver" class="text-center mt-4">
                                    <img src="../dist/svg/pdf_trasnparent.svg" alt="" width="50%" />
                                  </div>
                                  <div class="text-center" id="doc1_nombre"><!-- aqui va el nombre del pdf --></div>
                                </div>

                                <!-- barprogress -->
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-5 hidden" id="barra_progress_experiencia_div">
                                  <div class="progress" >
                                    <div id="barra_progress_experiencia" class="progress-bar" role="progressbar" aria-valuenow="2" aria-valuemin="0" aria-valuemax="100" style="min-width: 2em; width: 0%;">
                                      0%
                                    </div>
                                  </div>
                                </div> 
                                
                              </div>

                              <div class="row" id="cargando-2-fomulario" style="display: none;">
                                <div class="col-lg-12 text-center">
                                  <i class="fas fa-spinner fa-pulse fa-6x"></i><br />
                                  <br />
                                  <h4>Cargando...</h4>
                                </div>
                              </div>
                            </div>
                            <!-- /.card-body -->
                            <button type="submit" style="display: none;" id="submit-form-experiencia-laboral">Submit</button>
                          </form>
                        </div>
                        <div class="modal-footer justify-content-between">
                          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-success" id="guardar_registro_experiencia">Guardar Cambios</button>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- MODAL - TABLA EMPRESA -->
                  <div class="modal fade" id="modal-tabla-empresa">
                    <div class="modal-dialog modal-dialog-scrollable modal-xl">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Lista de empresas</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span class="text-danger" aria-hidden="true">&times;</span>
                          </button>
                        </div>

                        <div class="modal-body">

                          <button type="button" class="btn btn-success mb-4" title="Agregar" data-toggle="modal" data-target="#modal-agregar-empresa">
                            <i class="fa-solid fa-building"></i> Agregar Empresa
                          </button>

                          <table id="tabla-empresas" class="table table-bordered table-striped display" style="width: 100% !important;">
                            <thead>
                              <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Aciones</th>
                                <th>Nombre</th>
                                <th>ruc</th>
                                <th>direccion</th>
                                <th>celular</th>
                                <th>correo</th>
                                <th>estado</th>
                              </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                              <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Aciones</th>
                                <th>Nombre</th>
                                <th>ruc</th>
                                <th>direccion</th>
                                <th>celular</th>
                                <th>correo</th>
                                <th>estado</th>
                              </tr>
                            </tfoot>
                          </table>                          
                        </div>
                        <div class="modal-footer justify-content-between">
                          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- MODAL - AGREGAR EMPRESA -->
                  <div class="modal fade bg-color-02020263" id="modal-agregar-empresa">
                    <div class="modal-dialog modal-dialog-scrollable">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Agregar Empresa </h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span class="text-danger" aria-hidden="true">&times;</span>
                          </button>
                        </div>

                        <div class="modal-body">
                          <!-- form start -->
                          <form id="form-empresa" name="form-empresa" method="POST">
                            <div class="card-body">
                              <div class="row" id="cargando-3-fomulario">
                                <!-- id proyecto -->
                                <input type="hidden" name="idempresa" id="idempresa" />

                                <!-- Tipo de documento -->
                                <div class="col-lg-6">
                                  <div class="form-group">
                                    <label for="tipo_documento_empresa">Tipo de documento <sup class="text-danger">*</sup></label>
                                    <select name="tipo_documento_empresa" id="tipo_documento_empresa" class="form-control" placeholder="Tipo de documento">
                                      <option value="RUC">RUC</option>
                                    </select>
                                  </div>
                                </div>

                                <!-- N° de documento -->
                                <div class="col-lg-6">
                                  <div class="form-group">
                                    <label for="num_documento_empresa">N° RUC / DNI <sup class="text-danger">(unico*)</sup></label>
                                    <div class="input-group">
                                      <input type="number" name="num_documento_empresa" class="form-control" id="num_documento_empresa" placeholder="N° de documento" />
                                      <div class="input-group-append" data-toggle="tooltip" data-original-title="Buscar Reniec/SUNAT" onclick="buscar_sunat_reniec('_empresa');">
                                        <span class="input-group-text" style="cursor: pointer;">
                                          <i class="fas fa-search text-primary" id="search_empresa"></i>
                                          <i class="fa fa-spinner fa-pulse fa-fw fa-lg text-primary" id="charge_empresa" style="display: none;"></i>
                                        </span>
                                      </div>
                                    </div>
                                  </div>
                                </div>

                                <!-- Nombre -->
                                <div class="col-lg-12">
                                  <div class="form-group">
                                    <label for="nombre_empresa">Razón Social<sup class="text-danger">*</sup></label>
                                    <input type="text" name="nombre_empresa" class="form-control" id="nombre_empresa" placeholder="Razón Social o  Nombre" />
                                  </div>
                                </div>                                

                                <!-- Direccion -->
                                <div class="col-lg-12">
                                  <div class="form-group">
                                    <label for="direccion_empresa">Dirección</label>
                                    <input type="text" name="direccion_empresa" class="form-control" id="direccion_empresa" placeholder="Dirección" />
                                  </div>
                                </div>

                                <!-- Telefono -->
                                <div class="col-lg-6">
                                  <div class="form-group">
                                    <label for="telefono_empresa">Teléfono</label>
                                    <input type="text" name="telefono_empresa" id="telefono_empresa" class="form-control" data-inputmask="'mask': ['999-999-999', '+099 99 99 999']" data-mask />
                                  </div>
                                </div>

                                <!-- correo -->
                                <div class="col-lg-6">
                                  <div class="form-group">
                                    <label for="correo_empresa">Correo Electrónico</label>
                                    <input type="email" name="correo_empresa" class="form-control" id="correo_empresa" placeholder="Correo" />
                                  </div>
                                </div>
                                
                                <!-- barprogress -->
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-5 hidden" id="barra_progress_empresa_div">
                                  <div class="progress" >
                                    <div id="barra_progress_empresa" class="progress-bar" role="progressbar" aria-valuenow="2" aria-valuemin="0" aria-valuemax="100" style="min-width: 2em; width: 0%;">
                                      0%
                                    </div>
                                  </div>
                                </div> 
                              </div>

                              <div class="row" id="cargando-4-fomulario" style="display: none;">
                                <div class="col-lg-12 text-center">
                                  <i class="fas fa-spinner fa-pulse fa-6x"></i><br />
                                  <br />
                                  <h4>Cargando...</h4>
                                </div>
                              </div>
                            </div>
                            <!-- /.card-body -->
                            <button type="submit" style="display: none;" id="submit-form-empresa">Submit</button>
                          </form>
                        </div>
                        <div class="modal-footer justify-content-between">
                          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-success" id="guardar_registro_empresa">Guardar Cambios</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </section>
                <!-- /.content -->
              </div>
              <!--Fin-Contenido-->
              <?php
            }else{
              require 'noacceso.php';
            }
            require 'footer.php';
          ?>

        </div>

        <?php require 'script.php'; ?>

        <!-- <script src="../plugins/moment/moment.min.js"></script> -->
        <!-- <script src="../plugins/moment/locales.js"></script> -->
        <!-- <script src="../plugins/moment/locale/es.js"></script> -->
        <script type="text/javascript" src="scripts/experiencia_laboral.js"></script>

        <script>  $(function () { $('[data-toggle="tooltip"]').tooltip(); }); </script>
        
      </body>
    </html>
    <?php    
  }
  ob_end_flush();
?>
