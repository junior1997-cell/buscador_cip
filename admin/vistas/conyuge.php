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
        <title>Datos del conyuge | CIP</title>

        <?php $title = "Datos Conyuge"; require 'head.php'; ?>

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
                      <h1>Datos del conyuge</h1>
                    </div>
                    <div class="col-sm-6">
                      <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="dato_principal.php">Home</a></li>
                        <li class="breadcrumb-item active">Datos del conyuge</li>
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
                          <h3 class="card-title">                            
                            
                          </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                          <!-- Formulario de conyuge -->                      
                          <form id="form-conyuge" name="form-conyuge" method="POST">
                            <div class="row">

                              <!-- id proyecto -->
                              <input type="hidden" name="idcolegiado" id="idcolegiado" value="<?php echo $_SESSION['idusuario'] ;?>" />    
                              <input type="hidden" name="idconyuge" id="idconyuge">  

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
                              <div class="col-12 col-sm-12 col-md-3 col-lg-3">
                                <div class="form-group">
                                  <label for="num_documento">N° de documento <sup class="text-danger">(unico*)</sup></label>
                                  <div class="input-group">
                                    <input type="number" name="num_documento" readonly class="form-control input_data" id="num_documento" placeholder="N° de documento" />
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
                              <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                                <div class="form-group">
                                  <label for="nombre_h_">Nombre</label>
                                  <input type="text" name="nombre_h_" readonly class="form-control input_data" id="nombre_h_" placeholder="Nombres" />
                                </div>
                              </div>
                              
                              <!-- Apellido -->
                              <div class="col-12 col-sm-12 col-md-5 col-lg-5">
                                <div class="form-group">
                                  <label for="apellido_h_">Apellido</label>
                                  <input type="text" name="apellido_h_" readonly class="form-control input_data" id="apellido_h_" placeholder="Apellidos" />
                                </div>
                              </div>

                              <!-- sexo -->
                              <div class="col-12 col-sm-6 col-md-3 col-lg-3">
                                <div class="form-group">
                                  <label for="Sexo">Sexo</label>
                                  <!-- Select2 de sexo -->                      
                                  <select name="sexo" id="sexo" readonly class="form-control select2 input_data" placeholder="Sexo">
                                    <option value="M">Masculino</option>
                                    <option value="F">Femenino</option> 
                                  </select>
                                </div>
                              </div>

                              <!-- FECHA NACIMIENTO -->
                              <div class="col-12 col-sm-6 col-md-4 col-lg-4">
                                <div class="form-group">
                                  <label for="">Nacimiento: <sup class="text-danger">*</sup></label>
                                  <div class="input-group date"  data-target-input="nearest">
                                    <input type="text" class="form-control input_data" readonly id="nacimiento" name="nacimiento" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask />
                                    <div class="input-group-append click-btn-nacimiento cursor-pointer" for="nacimiento" >
                                      <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                  </div>                                 
                                </div>
                              </div>                               

                              <!-- correo -->
                              <div class="col-12 col-sm-12 col-md-5 col-lg-5">
                                <div class="form-group">
                                  <label for="email">Correo electrónico</label>
                                  <input type="email" name="email" class="form-control input_data" id="email" readonly placeholder="Correo electrónico" />
                                </div>
                              </div>

                              <!-- cel 1 -->
                              <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                                <div class="form-group">
                                  <label for="telefono">Teléfono 1</label>
                                  <input type="text" name="telefono1" id="telefono1" readonly class="form-control input_data" data-inputmask="'mask': ['999-999-999', '+51 999 999 999']" data-mask />
                                </div>
                              </div>    

                              <!-- cel 2 -->
                              <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                                <div class="form-group">
                                  <label for="telefono">Teléfono 2</label>
                                  <input type="text" name="telefono2" id="telefono2" readonly class="form-control input_data" data-inputmask="'mask': ['999-999-999', '+51 999 999 999']" data-mask />
                                </div>
                              </div>  
                              
                              <!-- cel 2 -->
                              <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                                <div class="form-group">
                                  <label for="telefono">Teléfono 3</label>
                                  <input type="text" name="telefono3" id="telefono3" readonly class="form-control input_data" data-inputmask="'mask': ['999-999-999', '+51 999 999 999']" data-mask />
                                </div>
                              </div>  

                            </div>

                            <button type="button" class="btn btn-warning btn-editar" onclick="active_imput(2)">Editar</button>             
                            <button type="submit" class="btn btn-success bnt-guardar hidden" id="guardar_registro">Guardar Cambios</button>
                          </form>      
                          
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
        <script type="text/javascript" src="scripts/conyuge.js"></script>

        <script> $(function () {  $('[data-toggle="tooltip"]').tooltip();  }); </script>
        
      </body>
    </html>

    <?php  
  }
  ob_end_flush();

?>
