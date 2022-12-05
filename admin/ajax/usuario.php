<?php
  ob_start();
  if (strlen(session_id()) < 1) {
    session_start(); //Validamos si existe o no la sesión
  }

  require_once "../modelos/Usuario.php";   

  $usuario = new Usuario();  

  date_default_timezone_set('America/Lima');  $date_now = date("d-m-Y h.i.s A");

  $imagen_error = "this.src='../dist/svg/user_default.svg'";
  $toltip = '<script> $(function () { $(\'[data-toggle="tooltip"]\').tooltip(); }); </script>';

  switch ($_GET["op"]) {

    case 'verificar':      

      $logina = $_POST['logina'];
      $clavea = $_POST['clavea']; 
      $soy_administrador = $_POST['soy_administrador']; 

      //Hash SHA256 en la contraseña
      $clavehash = hash("SHA256", $clavea); //echo $clavehash; die;

      $scheme_host=  ($_SERVER['HTTP_HOST'] == 'localhost' ? 'http://localhost/buscador_cip/admin/dist/svg/' :  $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'].'/admin/dist/svg/');

      $rspta = $soy_administrador == '1' ? $usuario->verificar_admin($logina, $clavehash) : $usuario->verificar($logina, $clavehash);  

      if ( $rspta['status'] == true ) {
        if ( !empty($rspta['data']) ) {

          if ($soy_administrador == '1') {
            //Declaramos las variables de sesión
            $_SESSION['idusuario']      = $rspta['data']['idadministrador'];
            $_SESSION['id_colegiado_cip']= 0;
            $_SESSION['imagen']         = $rspta['data']['foto'];
            $_SESSION['hosting']        = $scheme_host;
            $_SESSION['nombre']         = $rspta['data']['nombres_y_apellidos'];
            $_SESSION['tipo_documento'] = 'DNI';
            $_SESSION['codigo_cip']     = '000000';
            $_SESSION['num_documento']  = $rspta['data']['dni'];
            $_SESSION['login']          = $rspta['data']['usuario'];
            $_SESSION['capitulo']       = 'NINGUNO';
            $_SESSION['especialidad']   = 'NINGUNO';
            $_SESSION['fecha_incorporacion'] = 'NINGUNO';
            $_SESSION['cargo']          = 'Adminstrador';          
            $_SESSION['telefono']       = '';
            $_SESSION['email']          = $rspta['data']['email'];
            $_SESSION['estado']         = $rspta['data']['estado']; // f ó t
            $_SESSION['situacion']      = 1; // VIVO ó MUERTO          

            //Determinamos los accesos del usuario
            $_SESSION['colegiado']  = 0;
            $_SESSION['admin']      = 1;
          } else {
            //Declaramos las variables de sesión
            $_SESSION['idusuario']      = $rspta['data']['idcolegiado'];
            $_SESSION['id_colegiado_cip']= 0;
            $_SESSION['imagen']         = $rspta['data']['foto'];
            $_SESSION['hosting']        = $rspta['data']['hosting'];
            $_SESSION['nombre']         = $rspta['data']['nombres_y_apellidos'];
            $_SESSION['tipo_documento'] = 'DNI';
            $_SESSION['codigo_cip']     = $rspta['data']['codigo_cip'];
            $_SESSION['num_documento']  = $rspta['data']['dni'];
            $_SESSION['login']          = $rspta['data']['usuario'];
            $_SESSION['capitulo']       = $rspta['data']['capitulo'];
            $_SESSION['especialidad']   = $rspta['data']['especialidad'];
            $_SESSION['fecha_incorporacion'] = $rspta['data']['fecha_incorporacion'];
            $_SESSION['cargo']          = 'Colegiado';          
            $_SESSION['telefono']       = '';
            $_SESSION['email']          = $rspta['data']['email'];
            $_SESSION['estado']         = $rspta['data']['estado']; // f ó t
            $_SESSION['situacion']      = $rspta['data']['situacion']; // VIVO ó MUERTO          

            //Determinamos los accesos del usuario
            $_SESSION['colegiado']  = 1;
            $_SESSION['admin']      = 0;
          }          

          // Retornamos lo encontrado
          echo json_encode($rspta, true);
        } else {
          echo json_encode($rspta, true);
        }
      }else{        
        echo json_encode($rspta, true);
      }
      
    break;
    
    case 'salir':
      //Limpiamos las variables de sesión
      session_unset();
      //Destruìmos la sesión
      session_destroy();
      //Redireccionamos al login
      header("Location: index.php?file=".(isset($_GET["file"]) ? $_GET["file"] : ""));
    break;

    // default: 
    //   $rspta = ['status'=>'error_code', 'message'=>'Te has confundido en escribir en el <b>swich.</b>', 'data'=>[]]; echo json_encode($rspta, true); 
    // break;
    
  } 
  

  // ::::::::::::::::::::::::::::::::: D A T O S   U S U A R I O S :::::::::::::::::::::::::::::
  $idcolegiado = isset($_POST["idcolegiado"]) ? limpiarCadena($_POST["idcolegiado"]) : "";
  $input_usuario = isset($_POST["input_usuario"]) ? limpiarCadena($_POST["input_usuario"]) : "";
  $input_password = isset($_POST["input_password"]) ? limpiarCadena($_POST["input_password"]) : "";

  switch ($_GET["op"]) {

    case 'guardar_y_editar_colegiado':      

      if (empty($idcolegiado)) {

        $rspta = ['status'=>false, 'message'=>'No hay id colegiado <b>swich.</b>', 'data'=>[]];
        echo json_encode($rspta, true);

      } else {

        $rspta = $usuario->editar_colegiado($idcolegiado, $input_usuario, $input_password);
        echo json_encode($rspta, true);
      }
    break;
    
    case 'mostrar_editar_colegiado':

      $rspta = $usuario->mostrar_editar_colegiado($idcolegiado);
      //Codificar el resultado utilizando json
      echo json_encode($rspta, true);

    break;

    case 'tbla_principal':

      $rspta = $usuario->tabla_colegiado();
          
      $data = [];         
      $cont=1;          

      if ($rspta['status'] == true) {
        foreach ($rspta['data'] as $key => $reg) {              

          $ficha_tecnica = empty($reg['documento_cv'])
          ? ( '<div><center><button class="btn btn-danger"><i class="fa fa-file-pdf-o fa-2x text-gray-50"></i></button></center></div>')
          : ( '<center><a target="_blank" href="admin/dist/docs/curriculum/cv/' . $reg['documento_cv'] . '"><i class="far fa-file-pdf-o fa-2x" style="color:#ff0000c4"></i></a></center>');

          $data[] = [
            "0"=>$cont++,
            "1" => '<button class="btn btn-info btn-sm" onclick="detalle_colegiado(\''. $reg['idcolegiado'].'\')" ><i class="fa-solid fa-pencil"></i></button>',                  
            "2" => '<div class="user-block w-300px">
              <img class="profile-user-img img-circle cursor-pointer" src="http://ciptarapoto.com/intranet/web/' . $reg['foto'] . '" alt="user image" onerror="'.$imagen_error.'" onclick="ver_perfil_colegiado(\'http://ciptarapoto.com/intranet/web/'.$reg['foto']. '\', \''.$reg['nombres_y_apellidos'].'\')" width="50px">
              <span class="username"><p class="text-primary m-b-02rem" >'. $reg['nombres_y_apellidos'].'</p></span>
              <span class="description"><b>DNI: </b>'. $reg['dni'] .' ─ <b>CIP: </b>'.$reg['codigo_cip'].' </span>
            </div>' ,
            "3" => '<div class="w-200px font-size-12px">' . $reg['capitulo'] . '<br> <span class="text-primary">'.$reg['especialidad'].'</span> </div>',            
            "4" => date("d/m/Y", strtotime($reg['fecha_incorporacion'])),
            "5" => $reg['situacion'] ,
            "6" => '<div class="font-size-10px">' . ($reg['estado'] == 'f' ? '<span class="badge bg-danger">NO HABILITADO</span>' : '<span class="badge bg-success">HABILITADO</span>') . '</div>',
          ];
        }

        $results = [
          "sEcho" => 1, //Información para el datatables
          "iTotalRecords" => count($data), //enviamos el total registros al datatable
          "iTotalDisplayRecords" => 1, //enviamos el total registros a visualizar
          "data" => $data,
        ];

        echo json_encode($results);
      } else {
        echo $rspta['code_error'] .' - '. $rspta['message'] .' '. $rspta['data'];
      }

    break;
    

    // default: 
    //   $rspta = ['status'=>'error_code', 'message'=>'Te has confundido en escribir en el <b>swich.</b>', 'data'=>[]]; echo json_encode($rspta, true); 
    // break;
  }
  
  ob_end_flush();
?>
