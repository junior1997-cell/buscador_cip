<?php
  //Activamos el almacenamiento en el buffer
  ob_start();

  session_start();
  if (!isset($_SESSION["nombre"])){
    header("Location: index.php?file=".basename($_SERVER['PHP_SELF']));
  }else{
    ?>
    <!DOCTYPE html>
    <html lang="es">
      <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Datos Colegiado | CIP</title>

        <?php $title = "Datos Colegiado"; require 'head.php'; ?>

      </head>
      <body class="hold-transition sidebar-mini sidebar-collapse layout-fixed layout-navbar-fixed">
        <!-- Content Wrapper. Contains page content -->
        <div class="wrapper">
          <?php
          require 'nav.php';
          require 'aside.php';
          if ($_SESSION['colegiado']==1){
            //require 'enmantenimiento.php';
            ?>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
              <!-- Content Header (Page header) -->
              <section class="content-header">
                <div class="container-fluid">
                  <div class="row mb-2">
                    <div class="col-sm-6">
                      <h1>Datos Principales</h1>
                    </div>
                    <div class="col-sm-6">
                      <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="dato_principal.php">Home</a></li>
                        <li class="breadcrumb-item active">Datos Principales</li>
                      </ol>
                    </div>
                  </div>
                </div>
                <!-- /.container-fluid -->
              </section>

              <!-- Main content -->
              <section class="content">
                <div class="container-fluid">
                  <div class="row">
                    <div class="col-md-3">

                      <!-- Profile Image -->
                      <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                          <div class="text-center">
                          <img class="profile-user-img img-fluid img-circle" src="<?php echo $_SESSION['hosting'] . $_SESSION['imagen'] ;?>" alt="User profile picture">
                          </div>

                          <h3 class="profile-username text-center"> <?php echo $_SESSION['nombre']; ?></h3>

                          <p class="text-muted text-center mb-3"> <?php echo $_SESSION['especialidad']; ?></p>

                          <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                              <b>CIP: </b> <?php echo $_SESSION['codigo_cip']; ?>
                            </li>
                            <li class="list-group-item">
                              <b>Capítulo: </b> <?php echo $_SESSION['capitulo']; ?>
                            </li>
                            <li class="list-group-item">
                              <b>DNI: </b> <?php echo $_SESSION['num_documento']; ?>
                            </li>
                            <li class="list-group-item">
                              <b>Estado: </b> <?php $estado = ($_SESSION['estado'] == 't' ?  '<span class="badge badge-success">Activo</span>' : '<span class="badge badge-danger">Deshabilitado</span>' ); echo $estado; ?>
                            </li>
                          </ul>

                          <!-- <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a> -->
                        </div>
                        <!-- /.card-body -->
                      </div>
                      <!-- /.card -->
                      
                    </div>
                    <!-- /.col -->
                    <div class="col-md-9">
                      <div class="card card-primary card-outline">
                        <div class="card-header p-3"> DATOS DE CONTACTO </div>
                        <!-- /.card-header -->

                        <div class="card-body">                           
                          <form class="form-horizontal" id="form-dato-principal" name="form-dato-principal" method="POST">
                            <div class="form-group row">
                              <label for="usuario" class="col-sm-2 col-form-label">Usuario</label>
                              <div class="col-sm-10">
                                <span class="span_data" id="span_usuario"><i class="fas fa-spinner fa-pulse"></i> </span>
                                <input type="text" class="form-control input_data hidden" id="usuario" name="usuario" placeholder="Usuario" autocomplete="off">
                              </div>
                            </div>
                            <div class="form-group row">
                              <label for="password" class="col-sm-2 col-form-label">Password <small class="text-danger">(nuevo)</small></label>
                              <div class="col-sm-10">
                                <span class="span_data" id="span_password"><i class="fas fa-spinner fa-pulse"></i> </span>
                                <input type="password" class="form-control input_data hidden" id="password" name="password" placeholder="Password" autocomplete="off">
                                  
                                <div class="custom-control custom-checkbox m-t-5px input_data hidden">                                   
                                  <input class="custom-control-input" type="checkbox" id="customCheckbox2" onclick="ver_password()">
                                  <label for="customCheckbox2" class="custom-control-label">ver password</label>
                                </div>
                              </div>
                            </div>
                            <div class="form-group row">
                              <label for="email" class="col-sm-2 col-form-label">Email</label>
                              <div class="col-sm-10">
                                <span class="span_data" id="span_email"><i class="fas fa-spinner fa-pulse"></i> </span>
                                <input type="email" class="form-control input_data hidden" id="email" name="email" placeholder="Email" autocomplete="off">
                              </div>
                            </div>    
                            <div class="form-group row">
                              <label for="celular" class="col-sm-2 col-form-label">Celular</label>
                              <div class="col-sm-10">
                                <span class="span_data" id="span_celular"><i class="fas fa-spinner fa-pulse"></i> </span>
                                <input type="tel" class="form-control input_data hidden" id="celular" name="celular" placeholder="Celular" autocomplete="off">
                              </div>
                            </div>   
                            <div class="form-group row">
                              <label for="direccion" class="col-sm-2 col-form-label">Dirección</label>
                              <div class="col-sm-10">
                                <span class="span_data" id="span_direccion"><i class="fas fa-spinner fa-pulse"></i> </span>
                                <textarea class="form-control input_data hidden" id="direccion" name="direccion" placeholder="Dirección"></textarea>
                              </div>
                            </div>   
                            
                            <!-- barprogress -->
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-5 hidden" id="barra_progress_colegiado_div">
                              <div class="progress" >
                                <div id="barra_progress_colegiado" class="progress-bar" role="progressbar" aria-valuenow="2" aria-valuemin="0" aria-valuemax="100" style="min-width: 2em; width: 0%;">
                                  0%
                                </div>
                              </div>
                            </div> 
                            
                            <div class="form-group row">
                              <div class="offset-sm-2 col-sm-10">
                                <button type="button" class="btn btn-warning btn-editar" onclick="show_hide_form(2)"><i class="fa-solid fa-pencil"></i> Editar</button>
                                <button type="button" class="btn btn-default btn-close hidden" onclick="show_hide_form(1)" ><i class="fa-solid fa-xmark"></i> Close</button>
                                <button type="submit" class="btn btn-success btn-guardar hidden" id="guardar_registro"><i class="fa-solid fa-floppy-disk"></i> Guardar</button>
                              </div>
                            </div>                            
                            
                          </form>                           
                          <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                      </div>
                      <!-- /.card -->
                    </div>
                    <!-- /.col -->
                  </div>
                  <!-- /.row -->
                </div>
                <!-- /.container-fluid -->

              </section>
              <!-- /.content -->
            </div>

            <?php
          }else{
            require 'noacceso.php';
          }
          require 'footer.php';
          ?>
        </div>
        <!-- /.content-wrapper -->
        
        <?php require 'script.php'; ?>       
        
        <!-- Funciones del modulo -->
        <script type="text/javascript" src="scripts/dato_principal.js"></script>

        <script> $(function () {  $('[data-toggle="tooltip"]').tooltip();  }); </script>
        
      </body>
    </html>

    <?php  
  }
  ob_end_flush();

?>
