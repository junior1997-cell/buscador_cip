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
        <title>Escritorio | CIP</title>

        <?php $title = "Escritorio"; require 'head.php'; ?>
     
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
                        <h1 class="m-0">Tablero</h1>
                      </div>
                      <!-- /.col -->
                      <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                          <li class="breadcrumb-item"><a href="escritorio.php">Home</a></li>
                          <li class="breadcrumb-item active">Tablero</li>
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
                      <div class="col-md-3">

                        <!-- Profile Image -->
                        <div class="card card-primary card-outline">
                          <div class="card-body box-profile text-center">
                            <div class="text-center">
                              <img class="profile-user-img img-fluid img-circle" src="<?php echo $_SESSION['hosting'] . $_SESSION['imagen'] ;?>" alt="User profile picture">
                            </div>

                            <h3 class="profile-username text-center"> <?php echo $_SESSION['nombre']; ?></h3>

                            <p class="text-muted text-center mb-3"> <?php echo $_SESSION['especialidad']; ?></p>
                            <!-- <small class="text-muted text-center mb-2 pb-2"> <?php echo $_SESSION['capitulo']; ?></small> -->

                            <!-- <ul class="list-group list-group-unbordered mb-3 mt-2">
                              <li class="list-group-item">
                                <b>Followers</b> <a class="float-right">1,322</a>
                              </li>
                              <li class="list-group-item">
                                <b>Following</b> <a class="float-right">543</a>
                              </li>
                              <li class="list-group-item">
                                <b>Friends</b> <a class="float-right">13,287</a>
                              </li>
                            </ul> -->

                            <!-- About Me Box -->
                            <div class="card card-success text-left">
                              <div class="card-header text-center">
                                <h3 class="card-title ">Sobre Mi</h3>
                              </div>
                              <!-- /.card-header -->
                              <div class="card-body" id="div-todo-sobre-mi">
                                
                              </div>
                              <!-- /.card-body -->
                            </div>
                            <!-- /.card -->

                            <a href="dato_principal.php" class="btn btn-success btn-block"><b>Actualizar</b></a>
                          </div>
                          <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                        
                      </div>
                      <!-- /.col -->
                      <div class="col-md-9">
                        <div class="card">
                          <div class="card-header p-2">
                            <ul class="nav nav-pills">
                              <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Familia</a></li>
                              <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Experiencia Laboral</a></li>
                              <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">C.V.</a></li>
                            </ul>
                          </div><!-- /.card-header -->
                          <div class="card-body">
                            <div class="tab-content">

                              <!-- ══════════════════════════════════════ Familia ══════════════════════════════════════ -->
                              <div class="active tab-pane" id="activity">
                                <!-- Post -->
                                <div class="post" id="div-esposo">
                                  <div class="user-block">
                                    <!-- <img class="img-circle img-bordered-sm" src="../../dist/img/user1-128x128.jpg" alt="user image"> -->
                                    <span class="username ml-0">
                                      <a href="#">Esposo</a>
                                      <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                                    </span>
                                    <span class="description ml-0 actualizado-esposo">Actualizado el: </span>
                                  </div>
                                  <!-- /.user-block -->                                    
                                </div>
                                <!-- /.post -->

                                <!-- Post -->
                                <div class="post clearfix" id="div-hijos">
                                  <div class="user-block">
                                    <!-- <img class="img-circle img-bordered-sm" src="../../dist/img/user7-128x128.jpg" alt="User Image"> -->
                                    <span class="username ml-0">
                                      <a href="#">Hijos</a>
                                      <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                                    </span>
                                    <span class="description ml-0" id="actualizado-hijos">Actualizado el: </span>
                                  </div>
                                  <!-- /.user-block -->                                   
                                </div>
                                <!-- /.post -->
                                
                              </div>
                              <!-- /.tab-pane -->
                              
                              <!-- ══════════════════════════════════════ Experiencia Laboral ═══════════════════════════ -->
                              <div class="tab-pane" id="timeline">
                                <!-- The timeline -->
                                <div class="timeline timeline-inverse" id="div-experiencia-laboral">                                  
                                  
                                </div>
                              </div>
                              <!-- /.tab-pane -->
                              
                              <!-- ══════════════════════════════════════ C.V. ══════════════════════════════════════════ -->
                              <div class="tab-pane" id="settings">
                                <div id="div-pdf-cv"></div>
                              </div>
                              <!-- /.tab-pane -->

                            </div>
                            <!-- /.tab-content -->
                          </div><!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                      </div>
                      <!-- /.col -->
                    </div>
                    <!-- /.row -->
                  </div><!-- /.container-fluid -->
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
        <script type="text/javascript" src="scripts/escritorio.js"></script>

        <script>  $(function () { $('[data-toggle="tooltip"]').tooltip(); }); </script>
        
      </body>
    </html>
    <?php    
  }
  ob_end_flush();
?>
