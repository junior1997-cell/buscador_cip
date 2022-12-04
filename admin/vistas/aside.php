<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="escritorio.php" class="brand-link">
    <img src="../dist/svg/logo-icono.svg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: 0.8;" />
    <span class="brand-text font-weight-light">Colegio de Ingenieros</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar"> 
    <!-- Sidebar user panel (optional) -->
    <!-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="../dist/svg/empresa-logo.svg" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block">Construccion del baño portodoloque parte de no se</a>
      </div>
    </div>     -->

    <!-- SidebarSearch Form -->
    <div class="form-inline mt-4">
      <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search" />
        <div class="input-group-append"><button class="btn btn-sidebar"><i class="fas fa-search fa-fw"></i></button></div>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column /*nav-flat*/" data-widget="treeview" role="menu" data-accordion="false">
        <!-- MANUAL DE USUARIO -->
        
        <?php if ($_SESSION['colegiado']==1) {  ?>
          <!-- ESCRITORIO -->
          <li class="nav-item">
            <a href="escritorio.php" class="nav-link pl-2" id="mEscritorio">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Escritorio
                <span class="right badge badge-danger">Home</span>
              </p>
            </a>
          </li>
        <?php  }  ?>

        <?php if ($_SESSION['colegiado']==1) {  ?>
          <!-- ACCESOS -->
          <li class="nav-item  b-radio-3px" id="bloc_Accesos">
            <a href="#" class="nav-link pl-2" id="mAccesos">
              <i class="nav-icon fas fa-shield-alt"></i>
              <p>
                Accesos
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">2</span>
              </p>
            </a>
            <ul class="nav nav-treeview ">
              <!-- Usuarios del sistema -->
              <li class="nav-item ">
                <a href="usuario.php" class="nav-link " id="lUsuario">
                  <i class="nav-icon fas fa-users-cog"></i>
                  <p>Usuarios</p>
                </a>
              </li>
              <!-- Permisos de los usuarios del sistema -->
              <li class="nav-item ">
                <a href="permiso.php" class="nav-link" id="lPermiso">
                  <i class="nav-icon fas fa-lock"></i>
                  <p>Permisos</p>
                </a>
              </li>      
            </ul>
          </li>
        <?php  }  ?>             
        
        <?php if ($_SESSION['colegiado']==1) {  ?>
          <li class="nav-item">
            <a href="papelera.php" class="nav-link pl-2" id="mPapelera">
              <i class="nav-icon fas fa-trash-alt"></i>
              <p>Papelera</p>
            </a>
          </li>
        <?php  }  ?>
        
        <li class="nav-header">MÓDULOS</li>

        <!-- cargando -->     
        <li class="nav-item ver-otros-modulos-2" style="display: none !important;">
          <a href="#" class="nav-link" >
          <i class="fas fa-spinner fa-pulse "></i>
            <p>Cargando...</p>
          </a>
        </li>           
        
        <?php if ($_SESSION['colegiado']==1) {  ?>  
          <li class="nav-item ver-otros-modulos-1">
            <a href="dato_principal.php" class="nav-link pl-2" id="lDatoPrincipal">
              <i class="nav-icon fa-regular fa-address-card"></i>
              <p>Datos Principales </p>
            </a>
          </li>
        <?php  }  ?>  
        
        <?php if ($_SESSION['colegiado']==1) {  ?>  
          <li class="nav-item ver-otros-modulos-1">
            <a href="mi_cv.php" class="nav-link pl-2" id="lCurriculum">
              <i class="nav-icon fa-regular fa-folder-open"></i>
              <p>Mi Curriculum </p>
            </a>
          </li>
        <?php  }  ?> 
        
        <?php if ($_SESSION['colegiado']==1) {  ?>  
          <li class="nav-item ver-otros-modulos-1">
            <a href="conyuge.php" class="nav-link pl-2" id="lManodeObra">
              <i class="nav-icon fa-solid fa-children"></i>
              <p>Datos de Conyuge </p>
            </a>
          </li>
        <?php  }  ?>    

        <?php if ($_SESSION['colegiado']==1) {  ?>  
          <li class="nav-item ver-otros-modulos-1">
            <a href="mano_de_obra.php" class="nav-link pl-2" id="lManodeObra">
              <i class="nav-icon fa-solid fa-baby"></i>
              <p>Datos de Hijos </p>
            </a>
          </li>
        <?php  }  ?>     
        
        <?php if ($_SESSION['colegiado']==1) {  ?>  
          <li class="nav-item ver-otros-modulos-1">
            <a href="experiencia_laboral.php" class="nav-link pl-2" id="lExperienciaLaboral">
              <i class="nav-icon fa-solid fa-briefcase"></i>
              <p>Experiencia Laboral </p>
            </a>
          </li>
        <?php  }  ?>  

      </ul>      
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
