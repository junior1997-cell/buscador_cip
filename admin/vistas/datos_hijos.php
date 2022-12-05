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
        <title>Datos hijos |Colegiado - CIP</title>

        <?php $title = "Datos de hijos"; require 'head.php'; ?>
     
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
            if ($_SESSION['colegiado']==1 || $_SESSION['admin'] == 1){
              //require 'enmantenimiento.php';
              ?>           
              <!--Contenido-->
              <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                  <div class="container-fluid">
                    <div class="row mb-2">
                      <div class="col-sm-6">
                     <h1 class="m-0 font-weight-bold "> <i class="fa-solid fa-person"></i> Hijos(as) de : <?php echo $_SESSION['nombre']; ?></h1>
                      </div>
                      <!-- /.col -->
                      <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                          <li class="breadcrumb-item"><a href="mi_cv.php">Home</a></li>
                          <li class="breadcrumb-item active">Datos de hijos</li>
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
                            <!-- <div class="user-block">
                              <img class="img-circle" src="<?php echo $_SESSION['hosting'] . $_SESSION['imagen'] ;?>" alt="User Image">
                              <span class="username"><a href="#"><?php echo $_SESSION['nombre']; ?></a></span>
                              <span class="description"><?php echo $_SESSION['especialidad']; ?></span>
                            </div> -->
                            <!-- /.user-block -->
                            <div class="card-tools">
                              <button type="button" class="btn btn-danger" onclick="limpiar();" title="Agregar Curriculum" data-toggle="modal" data-target="#modal-agregar-hijo">
                                <i class="far fa-plus"></i> Agregar
                              </button>
                              
                            </div>
                            <!-- /.card-tools -->
                          </div>
                          <!-- /.card-header -->
                          <div class="card-body" id="div-ver-cv">
                            
                          <table id="tabla-datos-hijos" class="table table-bordered table-striped display" style="width: 100% !important;">
                            <thead style="background-color: #0b0b0b; color: white;" >
                              <tr>
                                <th colspan="7" class="cargando text-center bg-danger"><i class="fas fa-spinner fa-pulse fa-sm"></i> Buscando... </th>
                              </tr>
                              <tr>
                                <th class="text-center">#</th>
                                <th class="">Acciones</th>
                                <th>Nombres y Apellidos</th>                                
                                <th>DNI</th>
                                <th>Fecha nacimiento.</th>
                                <th>Sexo</th>
                                <th>Estado</th>
                              </tr>
                            </thead>
                            <tbody></tbody>
                          </table>
                            
                        </div>
                          <!-- /.card-body -->                          
                          
                        </div>
                        <!-- /.card -->                        
                      </div>                      
                    </div>
                    <!-- /.row -->
                  </div><!-- /.container-fluid -->

                  <!-- Modal agregar -->
                  <div class="modal fade" id="modal-agregar-hijo">
                    <div class="modal-dialog modal-dialog-scrollable modal-md">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Agregar Hijo</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span class="text-danger" aria-hidden="true">&times;</span>
                          </button>
                        </div>

                        <div class="modal-body">
                          <!-- form start -->
                          <form id="form-hijo" name="form-hijo" method="POST">

                            <div class="card-body p-0">

                              <div class="row" id="cargando-1-fomulario">
                                <!-- id proyecto -->
                                <input type="hidden" name="idcolegiado" id="idcolegiado" value="<?php echo $_SESSION['idusuario'] ;?>" />    
                                <input type="hidden" name="idhijos" id="idhijos">                         

                                <!-- Tipo de documento -->
                                <div class="col-12 col-sm-6 col-md-6 col-lg-6 hidden">
                                  <div class="form-group">
                                    <label for="tipo_documento">Tipo de documento</label>
                                    <select name="tipo_documento" id="tipo_documento" class="form-control" placeholder="Tipo de documento">
                                      <option selected value="DNI">DNI</option>
                                    </select>
                                  </div>
                                </div>

                                <!-- N° de documento -->
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                  <div class="form-group">
                                    <label for="num_documento">N° de documento <sup class="text-danger">(unico*)</sup></label>
                                    <div class="input-group">
                                      <input type="number" name="num_documento" class="form-control" id="num_documento" placeholder="N° de documento" />
                                      <div class="input-group-append" data-toggle="tooltip" data-original-title="Buscar Reniec/SUNAT" onclick="buscar_sunat_reniec();">
                                        <span class="input-group-text" style="cursor: pointer;">
                                          <i class="fas fa-search text-primary" id="search"></i>
                                          <i class="fa fa-spinner fa-pulse fa-fw fa-lg text-primary" id="charge" style="display: none;"></i>
                                        </span>
                                      </div>
                                    </div>
                                  </div>
                                </div>

                                <!-- Nombre -->
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                  <div class="form-group">
                                    <label for="nombre_h_">Nombre</label>
                                    <input type="text" name="nombre_h_" class="form-control" id="nombre_h_" placeholder="Nombres" />
                                  </div>
                                </div>
                                <!-- Apellido -->
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                  <div class="form-group">
                                    <label for="apellido_h_">Apellido</label>
                                    <input type="text" name="apellido_h_" class="form-control" id="apellido_h_" placeholder="Apellidos" />
                                  </div>
                                </div>

                                <!-- FECHA NACIMIENTO -->
                                <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                  <div class="form-group">
                                    <label for="">Nacimiento: <sup class="text-danger">*</sup></label>
                                    <div class="input-group date"  data-target-input="nearest">
                                      <input type="text" class="form-control" id="nacimiento" name="nacimiento" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask />
                                      <div class="input-group-append click-btn-nacimiento cursor-pointer" for="nacimiento" >
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                      </div>
                                    </div>                                 
                                  </div>
                                </div>

                                <!-- sexo -->
                                <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                  <div class="form-group">
                                    <label for="Sexo">Sexo</label>
                                    <!-- Select2 de sexo -->                      
                                    <select name="sexo" id="sexo" class="form-control select2" placeholder="Sexo">
                                      <option value="M">Masculino</option>
                                      <option value="F">Femenino</option> 
                                    </select>
                                  </div>
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
                            <button type="submit" style="display: none;" id="submit-form-hijo">Submit</button>

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

        <script type="text/javascript" src="scripts/datos_hijos.js"></script>

        <script>  $(function () { $('[data-toggle="tooltip"]').tooltip(); }); </script>
        
      </body>
    </html>
    <?php    
  }
  ob_end_flush();
?>
