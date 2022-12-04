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
        <title>Mi CV | CIP</title>

        <?php $title = "Mi CV"; require 'head.php'; ?>
     
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
                        <h1 class="m-0">Curriculum Viatae</h1>
                      </div>
                      <!-- /.col -->
                      <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                          <li class="breadcrumb-item"><a href="mi_cv.php">Home</a></li>
                          <li class="breadcrumb-item active">CV</li>
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
                    <div class="row">
                      <div class="col-md-12">                      
                        <!-- Box Comment -->
                        <div class="card card-widget">
                          <div class="card-header">
                            <div class="user-block">
                              <img class="img-circle" src="<?php echo $_SESSION['hosting'] . $_SESSION['imagen'] ;?>" alt="User Image">
                              <span class="username"><a href="#"><?php echo $_SESSION['nombre']; ?></a></span>
                              <span class="description"><?php echo $_SESSION['especialidad']; ?></span>
                            </div>
                            <!-- /.user-block -->
                            <div class="card-tools">
                              <button type="button" class="btn btn-success" title="Agregar Curriculum" data-toggle="modal" data-target="#modal-agregar-cv">
                                <i class="far fa-plus"></i> Agregar CV
                              </button>
                              
                            </div>
                            <!-- /.card-tools -->
                          </div>
                          <!-- /.card-header -->
                          <div class="card-body" id="div-ver-cv">
                            
                          </div>
                          <!-- /.card-body -->                          
                          
                        </div>
                        <!-- /.card -->                        
                      </div>                      
                    </div>
                    <!-- /.row -->
                  </div><!-- /.container-fluid -->

                  <!-- Modal agregar -->
                  <div class="modal fade" id="modal-agregar-cv">
                    <div class="modal-dialog modal-dialog-scrollable modal-md">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Agregar CV</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span class="text-danger" aria-hidden="true">&times;</span>
                          </button>
                        </div>

                        <div class="modal-body">
                          <!-- form start -->
                          <form id="form-cv" name="form-cv" method="POST">
                            <div class="card-body p-0">
                              <div class="row" id="cargando-1-fomulario">
                                <!-- id proyecto -->
                                <input type="hidden" name="idcolegiado" id="idcolegiado" value="<?php echo $_SESSION['idusuario'] ;?>" />                             

                                <!-- Pdf 1 -->
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12 mt-2">
                                  <!-- linea divisoria -->
                                  <div class="col-lg-12 borde-arriba-naranja mt-2"></div>
                                  <div class="row  mt-4">
                                    <!-- <div class="col-md-12 p-t-15px p-b-5px" >
                                      <label for="Presupuesto" class="control-label">CV Documentado</label>
                                    </div> -->
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
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top:20px;">
                                  <div class="progress" id="barra_progress_div">
                                    <div id="barra_progress" class="progress-bar" role="progressbar" aria-valuenow="2" aria-valuemin="0" aria-valuemax="100" style="min-width: 2em; width: 0%;">
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
                            <button type="submit" style="display: none;" id="submit-form-cv">Submit</button>
                          </form>
                        </div>
                        <div class="modal-footer justify-content-between">
                          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-success" id="guardar_registro">Guardar Cambios</button>
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
        <script type="text/javascript" src="scripts/mi_cv.js"></script>

        <script>  $(function () { $('[data-toggle="tooltip"]').tooltip(); }); </script>
        
      </body>
    </html>
    <?php    
  }
  ob_end_flush();
?>
