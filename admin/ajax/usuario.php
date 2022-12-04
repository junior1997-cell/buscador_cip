<?php
  ob_start();
  if (strlen(session_id()) < 1) {
    session_start(); //Validamos si existe o no la sesión
  }

  switch ($_GET["op"]) {

    case 'verificar':

      require_once "../modelos/Usuario.php";
      $usuario = new Usuario(); 

      $logina = $_POST['logina'];
      $clavea = $_POST['clavea']; 

      //Hash SHA256 en la contraseña
      $clavehash = hash("SHA256", $clavea); //echo $clavehash; die;

      $rspta = $usuario->verificar($logina, $clavehash);   //$fetch = $rspta->fetch_object();

      if ( $rspta['status'] == true ) {
        if ( !empty($rspta['data']) ) {
          //Declaramos las variables de sesión
          $_SESSION['idusuario']      = $rspta['data']['idcolegiado'];
          $_SESSION['id_colegiado_cip']= $rspta['data']['id_colegiado_cip'];
          $_SESSION['imagen']         = $rspta['data']['foto'];
          $_SESSION['hosting']        = $rspta['data']['hosting'];
          $_SESSION['nombre']         = $rspta['data']['nombres_y_apellidos'];
          $_SESSION['tipo_documento'] = 'DNI';
          $_SESSION['codigo_cip']     = $rspta['data']['codigo_cip'];
          $_SESSION['num_documento']  = $rspta['data']['dni'];
          $_SESSION['login']          = $rspta['data']['usuario'];
          $_SESSION['capitulo']       = $rspta['data']['capitulo'];
          $_SESSION['especialidad']   = $rspta['data']['especialidad'];
          $_SESSION['cargo']          = 'Colegiado';          
          $_SESSION['telefono']       = '';
          $_SESSION['email']          = $rspta['data']['email'];
          $_SESSION['estado']         = $rspta['data']['estado']; // f ó t
          $_SESSION['situacion']      = $rspta['data']['situacion']; // VIVO ó MUERTO
         

          //Determinamos los accesos del usuario
          $_SESSION['colegiado']  = 1;
          $_SESSION['admin']      = 0;
          // in_array(1, $valores) ? ($_SESSION['escritorio'] = 1)         : ($_SESSION['escritorio'] = 0);
          // in_array(2, $valores) ? ($_SESSION['acceso'] = 1)             : ($_SESSION['acceso'] = 0);

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
 
  require_once "../modelos/Usuario.php";   

  $usuario = new Usuario();  

  // ::::::::::::::::::::::::::::::::: D A T O S   U S U A R I O S :::::::::::::::::::::::::::::
  $idusuario = isset($_POST["idusuario"]) ? limpiarCadena($_POST["idusuario"]) : "";
  $trabajador = isset($_POST["trabajador"]) ? limpiarCadena($_POST["trabajador"]) : "";
  $trabajador_old = isset($_POST["trabajador_old"]) ? limpiarCadena($_POST["trabajador_old"]) : "";
  $cargo = isset($_POST["cargo"]) ? limpiarCadena($_POST["cargo"]) : "";
  $login = isset($_POST["login"]) ? limpiarCadena($_POST["login"]) : "";
  $clave = isset($_POST["password"]) ? limpiarCadena($_POST["password"]) : "";
  $clave_old = isset($_POST["password-old"]) ? limpiarCadena($_POST["password-old"]) : "";
  $permiso = isset($_POST['permiso']) ? $_POST['permiso'] : "";

  // ::::::::::::::::::::::::::::::::: D A T O S   T R A B A J A D O R :::::::::::::::::::::::::::::
  $idtrabajador_trab	  = isset($_POST["idtrabajador_trab"])? limpiarCadena($_POST["idtrabajador_trab"]):"";
  $nombre_trab		      = isset($_POST["nombre_trab"])? limpiarCadena($_POST["nombre_trab"]):"";
  $tipo_documento_trab 	= isset($_POST["tipo_documento_trab"])? limpiarCadena($_POST["tipo_documento_trab"]):"";
  $num_documento_trab  	= isset($_POST["num_documento_trab"])? limpiarCadena($_POST["num_documento_trab"]):"";
  $direccion_trab		    = isset($_POST["direccion_trab"])? limpiarCadena($_POST["direccion_trab"]):"";
  $telefono_trab		    = isset($_POST["telefono_trab"])? limpiarCadena($_POST["telefono_trab"]):"";
  $nacimiento_trab		  = isset($_POST["nacimiento_trab"])? limpiarCadena($_POST["nacimiento_trab"]):"";
  $edad_trab		        = isset($_POST["edad_trab"])? limpiarCadena($_POST["edad_trab"]):"";      
  $email_trab			      = isset($_POST["email_trab"])? limpiarCadena($_POST["email_trab"]):"";
  $banco_trab			      = isset($_POST["banco_trab"])? limpiarCadena($_POST["banco_trab"]):"";
  $c_bancaria_trab		  = isset($_POST["c_bancaria_trab"])? limpiarCadena($_POST["c_bancaria_trab"]):"";
  $c_bancaria_format    = isset($_POST["c_bancaria_trab"])? limpiarCadena($_POST["c_bancaria_trab"]):"";     
  $cci_trab	          	= isset($_POST["cci_trab"])? limpiarCadena($_POST["cci_trab"]):"";
  $cci_format      	    = isset($_POST["cci_trab"])? limpiarCadena($_POST["cci_trab"]):"";
  $titular_cuenta_trab  = isset($_POST["titular_cuenta_trab"])? limpiarCadena($_POST["titular_cuenta_trab"]):""; 
  $tipo_trab	          = isset($_POST["tipo_trab"])? limpiarCadena($_POST["tipo_trab"]):"";
  $ocupacion_trab	      = isset($_POST["ocupacion_trab"])? limpiarCadena($_POST["ocupacion_trab"]):"";
  $ruc_trab	          	= isset($_POST["ruc_trab"])? limpiarCadena($_POST["ruc_trab"]):"";

  $imagen1			    = isset($_POST["foto1"])? limpiarCadena($_POST["foto1"]):"";
  $imagen2			    = isset($_POST["foto2"])? limpiarCadena($_POST["foto2"]):"";
  $imagen3			    = isset($_POST["foto3"])? limpiarCadena($_POST["foto3"]):"";

  $cv_documentado			    = isset($_POST["doc4"])? limpiarCadena($_POST["doc4"]):"";
  $cv_nodocumentado			  = isset($_POST["doc5"])? limpiarCadena($_POST["doc5"]):"";

  switch ($_GET["op"]) {

    case 'guardar_y_editar_usuario':

      $clavehash = "";

      if (!empty($clave)) {
        //Hash SHA256 en la contraseña
        $clavehash = hash("SHA256", $clave);
      } else {
        if (!empty($clave_old)) {
          // enviamos la contraseña antigua
          $clavehash = $clave_old;
        } else {
          //Hash SHA256 en la contraseña
          $clavehash = hash("SHA256", "123456");
        }
      }

      if (empty($idusuario)) {

        $rspta = $usuario->insertar($trabajador, $cargo, $login, $clavehash, $permiso);

        echo json_encode($rspta, true);

      } else {

        $rspta = $usuario->editar($idusuario, $trabajador_old, $trabajador, $cargo, $login, $clavehash, $permiso);

        echo json_encode($rspta, true);
      }
    break;

    case 'desactivar':

      $rspta = $usuario->desactivar($_GET["id_tabla"]);

      echo json_encode($rspta, true);

    break;

    case 'activar':

      $rspta = $usuario->activar($_GET["id_tabla"]);

      echo json_encode($rspta, true);

    break;

    case 'eliminar':

      $rspta = $usuario->eliminar($_GET["id_tabla"]);

      echo json_encode($rspta, true);

    break;

    case 'mostrar':

      $rspta = $usuario->mostrar($idusuario);
      //Codificar el resultado utilizando json
      echo json_encode($rspta, true);

    break;

    case 'tbla_principal':

      $rspta = $usuario->listar();
          
      //Vamos a declarar un array
      $data = [];  
      $imagen_error = "this.src='../dist/svg/user_default.svg'"; $cont=1;
      $toltip = '<script> $(function () { $(\'[data-toggle="tooltip"]\').tooltip(); }); </script>';

      if ($rspta['status']) {
        foreach ($rspta['data'] as $key => $value) {
          $data[] = [
            "0"=>$cont++,
            "1" => $value['estado'] ? '<button class="btn btn-warning btn-sm" onclick="mostrar(' . $value['idusuario'] . ')" data-toggle="tooltip" data-original-title="Editar"><i class="fas fa-pencil-alt"></i></button>' .
                ($value['cargo']=='Administrador' ? ' <button class="btn btn-danger btn-sm disabled" data-toggle="tooltip" data-original-title="El administrador no se puede eliminar."><i class="fas fa-skull-crossbones"></i> </button>' : ' <button class="btn btn-danger  btn-sm" onclick="eliminar(' . $value['idusuario'] .', \''.encodeCadenaHtml($value['nombres']).'\')" data-toggle="tooltip" data-original-title="Eliminar o papelera"><i class="fas fa-skull-crossbones"></i> </button>' ) :
                '<button class="btn btn-warning  btn-sm" onclick="mostrar(' . $value['idusuario'] . ')" data-toggle="tooltip" data-original-title="Editar"><i class="fas fa-pencil-alt"></i></button>' . 
                ' <button class="btn btn-primary  btn-sm" onclick="activar(' . $value['idusuario'] . ')" data-toggle="tooltip" data-original-title="Recuperar"><i class="fa fa-check"></i></button>',
            "2" => '<div class="user-block">'. 
              '<img class="img-circle" src="../dist/docs/all_trabajador/perfil/' . $value['imagen_perfil'] . '" alt="User Image" onerror="' . $imagen_error . '">'.
              '<span class="username"><p class="text-primary m-b-02rem" >' . $value['nombres'] . '</p></span>'. 
              '<span class="description"> - ' . $value['tipo_documento'] .  ': ' . $value['numero_documento'] . ' </span>'.
            '</div>',
            "3" => $value['telefono'],
            "4" => $value['login'],
            "5" => $value['cargo'],
            "6" => ($value['estado'] ? '<span class="text-center badge badge-success">Activado</span>' : '<span class="text-center badge badge-danger">Desactivado</span>').$toltip,
          ];
        }
        $results = [
          "sEcho" => 1, //Información para el datatables
          "iTotalRecords" => count($data), //enviamos el total registros al datatable
          "iTotalDisplayRecords" => 1, //enviamos el total registros a visualizar
          "data" => $data,
        ];
        echo json_encode($results, true);
      } else {
        echo $rspta['code_error'] .' - '. $rspta['message'] .' '. $rspta['data'];
      }

    break;

    case 'permisos':
      //Obtenemos todos los permisos de la tabla permisos      
      $rspta = $permisos->listar();

      if ( $rspta['status'] ) {

        //Obtener los permisos asignados al usuario
        $id = $_GET['id'];
        $marcados = $usuario->listarmarcados($id);
        //Declaramos el array para almacenar todos los permisos marcados
        $valores = [];

        if ($marcados['status']) {

          //Almacenar los permisos asignados al usuario en el array
          foreach ($marcados['data'] as $key => $value) {
            array_push($valores, $value['idpermiso']);
          }

          $data = ""; $num = 8;  $stado_close = false;
          //Mostramos la lista de permisos en la vista y si están o no marcados <label for=""></label>
          foreach ($rspta['data'] as $key => $value) {

            $div_open = ''; $div_close = '';

            if ( ($key + 1) == 1 ) {                  
              $div_open = '<ol class="list-unstyled row"><div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-3">'. 
              '<li class="text-primary"><input class="h-1rem w-1rem" type="checkbox" id="marcar_todo" onclick="marcar_todos_permiso();"> ' .
                '<label for="marcar_todo" class="marcar_todo">Marcar Todo</label>'.
              '</li>';                 
            } else {
              if ( ($key + 1) == $num ) { 
                $div_close = '</div>';
                $num += 9;
                $stado_close = true;
              } else {
                if ($stado_close) {
                  $div_open = '<div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-3">';
                  $stado_close = false; 
                }             
              }
            }               
            
            $sw = in_array($value['idpermiso'], $valores) ? 'checked' : '';

            $data .= $div_open.'<li>'. 
              '<div class="form-group mb-0">'.
                '<div class="custom-control custom-checkbox">'.
                  '<input id="permiso_'.$value['idpermiso'].'" class="custom-control-input permiso h-1rem w-1rem" type="checkbox" ' . $sw . ' name="permiso[]" value="' . $value['idpermiso'] . '"> '.
                  '<label for="permiso_'.$value['idpermiso'].'" class="custom-control-label font-weight-normal" >' .$value['icono'] .' '. $value['nombre'].'</label>' . 
                '</div>'.
              '</div>'.
            '</li>'. $div_close;
          }

          $retorno = array(
            'status' => true, 
            'message' => 'Salió todo ok', 
            'data' => $data.'</ol>', 
          );

          echo json_encode($retorno, true);

        } else {
          echo json_encode($marcados, true);
        }

      } else {
        echo json_encode($rspta, true);
      }    

    break;    

    case 'select2Trabajador':

      $rspta = $usuario->select2_trabajador();  $data = "";

      if ($rspta['status']) {

        foreach ($rspta['data'] as $key => $value) {
          $data  .= '<option value=' . $value['id'] . ' title="'.$value['imagen_perfil'].'">' . $value['nombre'] . ' - ' . $value['numero_documento'] . '</option>';
        }
    
        $retorno = array(
          'status' => true, 
          'message' => 'Salió todo ok', 
          'data' => $data, 
        );

        echo json_encode($retorno, true);
      } else {
        echo json_encode($rspta, true);
      }    
    break;    
    
    // ::::::::::::::::::::::::::::::::: S E C C I O N   T R A B A J A D O R :::::::::::::::::::::::::::::
    case 'guardar_y_editar_trabajador':

      // imgen de perfil
      if (!file_exists($_FILES['foto1']['tmp_name']) || !is_uploaded_file($_FILES['foto1']['tmp_name'])) {

        $imagen1=$_POST["foto1_actual"]; $flat_img1 = false;

      } else {

        $ext1 = explode(".", $_FILES["foto1"]["name"]); $flat_img1 = true;						

        $imagen1 = rand(0, 20) . round(microtime(true)) . rand(21, 41) . '.' . end($ext1);

        move_uploaded_file($_FILES["foto1"]["tmp_name"], "../dist/docs/all_trabajador/perfil/" . $imagen1);
        
      }

      // imgen DNI ANVERSO
      if (!file_exists($_FILES['foto2']['tmp_name']) || !is_uploaded_file($_FILES['foto2']['tmp_name'])) {

        $imagen2=$_POST["foto2_actual"]; $flat_img2 = false;

      } else {

        $ext2 = explode(".", $_FILES["foto2"]["name"]); $flat_img2 = true;

        $imagen2 = rand(0, 20) . round(microtime(true)) . rand(21, 41) . '.' . end($ext2);

        move_uploaded_file($_FILES["foto2"]["tmp_name"], "../dist/docs/all_trabajador/dni_anverso/" . $imagen2);
        
      }

      // imgen DNI REVERSO
      if (!file_exists($_FILES['foto3']['tmp_name']) || !is_uploaded_file($_FILES['foto3']['tmp_name'])) {

        $imagen3=$_POST["foto3_actual"]; $flat_img3 = false;

      } else {

        $ext3 = explode(".", $_FILES["foto3"]["name"]); $flat_img3 = true;
        
        $imagen3 = rand(0, 20) . round(microtime(true)) . rand(21, 41) . '.' . end($ext3);

        move_uploaded_file($_FILES["foto3"]["tmp_name"], "../dist/docs/all_trabajador/dni_reverso/" . $imagen3);
        
      }

      // cv documentado
      if (!file_exists($_FILES['doc4']['tmp_name']) || !is_uploaded_file($_FILES['doc4']['tmp_name'])) {

        $cv_documentado=$_POST["doc_old_4"]; $flat_cv1 = false;

      } else {

        $ext3 = explode(".", $_FILES["doc4"]["name"]); $flat_cv1 = true;
        
        $cv_documentado = rand(0, 20) . round(microtime(true)) . rand(21, 41) . '.' . end($ext3);

        move_uploaded_file($_FILES["doc4"]["tmp_name"], "../dist/docs/all_trabajador/cv_documentado/" .  $cv_documentado);
        
      }

      // cv  no documentado
      if (!file_exists($_FILES['doc5']['tmp_name']) || !is_uploaded_file($_FILES['doc5']['tmp_name'])) {

        $cv_nodocumentado=$_POST["doc_old_5"]; $flat_cv2 = false;

      } else {

        $ext3 = explode(".", $_FILES["doc5"]["name"]); $flat_cv2 = true;
        
        $cv_nodocumentado = rand(0, 20) . round(microtime(true)) . rand(21, 41) . '.' . end($ext3);

        move_uploaded_file($_FILES["doc5"]["tmp_name"], "../dist/docs/all_trabajador/cv_no_documentado/" . $cv_nodocumentado);
        
      }

      if (empty($idtrabajador)){

        $rspta=$alltrabajador->insertar($nombre_trab, $tipo_documento_trab, $num_documento_trab, $direccion_trab, $telefono_trab, $nacimiento_trab, $edad_trab, $email_trab, $banco_trab, str_replace("-", "",$c_bancaria_trab), $c_bancaria_format, str_replace("-", "",$cci_trab), $cci_format, $titular_cuenta_trab, $tipo_trab, $ocupacion_trab, $ruc_trab, $imagen1, $imagen2, $imagen3, $cv_documentado, $cv_nodocumentado);
        
        echo json_encode($rspta, true);

      }else {            
        $rspta = array( 'status' => false, 'message' => 'No hay editar usuario en este modulo', );      
        echo json_encode($rspta, true);
      }            

    break;

    // default: 
    //   $rspta = ['status'=>'error_code', 'message'=>'Te has confundido en escribir en el <b>swich.</b>', 'data'=>[]]; echo json_encode($rspta, true); 
    // break;
  }
  
  ob_end_flush();
?>
