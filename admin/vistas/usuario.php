<?php
  //Activamos el almacenamiento en el buffer
  ob_start();

  session_start();
  if (!isset($_SESSION["nombre"])){
    header("Location: index.php?file=".basename($_SERVER['PHP_SELF']));
  }else{
    ?>
    <!doctype html>
    <html lang="es">
      <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Admin colegiados | Admin Sevens</title>

        <?php $title = "Admin colegiados"; require 'head.php'; ?>
        
      </head>
      <body class="hold-transition sidebar-mini sidebar-collapse layout-fixed layout-navbar-fixed">
        <!-- Content Wrapper. Contains page content -->
        <div class="wrapper">
          <?php
          require 'nav.php';
          require 'aside.php';
          if ( $_SESSION['admin'] == 1 ){
            //require 'enmantenimiento.php';
            ?>    
          
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
              <!-- Content Header (Page header) -->
              <section class="content-header">
                <div class="container-fluid">
                  <div class="row mb-2">
                    <div class="col-sm-6">
                      <h1>Admin colegiados</h1>
                    </div>
                    <div class="col-sm-6">
                      <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="usuario.php">Home</a></li>
                        <li class="breadcrumb-item active">Admin</li>
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
                    <div class="col-12">
                      <div class="card card-primary card-outline">
                        <div class="card-header">                               
                          
                          <h3 class="card-title btn-agregar">
                            <!-- <button type="button" class="btn bg-gradient-success" onclick="limpiar_form_usuario(); "><i class="fas fa-user-plus"></i> Agregar</button> -->
                            Actualizar credenciales de colegiados 
                          </h3>                
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">

                          <div id="mostrar-tabla">
                            <table id="tabla-colegiado" class="table table-bordered table-striped display" style="width: 100% !important;">
                              <thead>
                                <tr class="text-nowrap">
                                  <th >#</th> 
                                  <th >OP</th>
                                  <th >Nombres</th>
                                  <th >Cap./Espec.</th>                                  
                                  <th >Incorporacion</th>
                                  <th >Situación</th>  
                                  <th >Estado</th>        
                                </tr>
                              </thead>
                              <tbody>  </tbody>
                              <tfoot>
                                <tr class="text-nowrap">
                                  <th >#</th>
                                  <th >OP</th>
                                  <th >Nombres</th>
                                  <th >Cap./Espec.</th>
                                  <th >Incorporacion</th>
                                  <th >Situación</th> 
                                  <th >Estado</th>             
                                </tr>
                              </tfoot>
                            </table>
                          </div>
                          
                        </div>
                        <!-- /.card-body -->
                      </div>
                      <!-- /.card -->
                    </div>
                    <!-- /.col -->
                  </div>
                  <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
                
                <!-- Modal agregar trabajador -->
                <div class="modal fade" id="modal-agregar-colegiado">
                  <div class="modal-dialog modal-dialog-scrollable modal-md">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">Editar Colegiado</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span class="text-danger" aria-hidden="true">&times;</span>
                        </button>
                      </div>

                      <div class="modal-body">
                        <!-- form start -->
                        <form id="form-colegiado" name="form-colegiado" method="POST">
                          <div class="card-body">
                            <div class="row" id="cargando-3-fomulario">
                              <!-- id trabajador -->
                              <input type="hidden" name="idcolegiado" id="idcolegiado" />
                              
                              <!-- Nombre -->
                              <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                  <label for="input_usuario">Nombre y Apellidos</label>
                                  <span class="form-control" id="nombre_colegiado" ></span>
                                </div>
                              </div>      

                              <!-- Nombre -->
                              <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                  <label for="input_usuario">Usuario</label>
                                  <input type="text" name="input_usuario" class="form-control" id="input_usuario" placeholder="Usuario" />
                                </div>
                              </div>      

                              <!-- Nombre -->
                              <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                  <label for="input_password">Password <small class="text-danger">(nuevo)</small> </label>
                                  <input type="password" name="input_password" class="form-control" id="input_password" placeholder="Password" />
                                </div>
                                <div class="custom-control custom-checkbox m-t-5px">                                   
                                  <input class="custom-control-input" type="checkbox" id="customCheckbox2" onclick="ver_password()">
                                  <label for="customCheckbox2" class="custom-control-label">ver password</label>
                                </div>
                              </div>                              

                              <!-- Progress -->
                              <div class="col-md-12">
                                <div class="form-group">
                                  <div class="progress" id="barra_progress_colegiado_div" style="display: none !important;">
                                    <div id="barra_progress_colegiado" class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
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
                          <button type="submit" style="display: none;" id="submit-form-colegiado">Submit</button>
                        </form>
                      </div>
                      <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-danger" onclick="limpiar_form_colegiado();" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" id="guardar_registro_colegiado">Guardar Cambios</button>
                      </div>
                    </div>
                  </div>
                </div>

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

        <script type="text/javascript" src="scripts/usuario.js"></script>

        <script> $(function () { $('[data-toggle="tooltip"]').tooltip(); }) </script>

      </body>
    </html> 
    
    <?php  
  }
  ob_end_flush();

?>
