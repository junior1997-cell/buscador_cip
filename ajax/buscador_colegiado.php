<?php

  ob_start();

  // if (strlen(session_id()) < 1) {

  //   session_start(); //Validamos si existe o no la sesión
  // }

  // if (!isset($_SESSION["nombre"])) {
  //   $retorno = ['status'=>'login', 'message'=>'Tu sesion a terminado pe, inicia nuevamente', 'data' => [] ];
  //   echo json_encode($retorno);  //Validamos el acceso solo a los usuarios logueados al sistema.
  // } else {

    //Validamos el acceso solo al usuario logueado y autorizado.
    // if ($_SESSION['recurso'] == 1) {
    if (true) {

      require_once "../modelos/Buscador_colegiado.php";

      $buscador_colegiado = new Buscador_colegiado();

      date_default_timezone_set('America/Lima');  $date_now = date("d-m-Y h.i.s A");

      $imagen_error = "this.src='dist/svg/user_default.svg'";
      $toltip = '<script> $(function () { $(\'[data-toggle="tooltip"]\').tooltip(); }); </script>';
      
      $nombre_all 		  = isset($_POST["nombre_all"])? limpiarCadena($_POST["nombre_all"]):"";
      $capitulo_all	  	= isset($_POST["capitulo_all"])? limpiarCadena($_POST["capitulo_all"]):"";

      $nombre_nombre 		= isset($_POST["nombre_nombre"])? limpiarCadena($_POST["nombre_nombre"]):"";
      $capitulo_nombre	= isset($_POST["capitulo_nombre"])? limpiarCadena($_POST["capitulo_nombre"]):"";

      $nombre_cip 		  = isset($_POST["nombre_cip"])? limpiarCadena($_POST["nombre_cip"]):"";
      $capitulo_cip	  	= isset($_POST["capitulo_cip"])? limpiarCadena($_POST["capitulo_cip"]):"";

      $nombre_dni 		  = isset($_POST["nombre_dni"])? limpiarCadena($_POST["nombre_dni"]):"";
      $capitulo_dni	  	= isset($_POST["capitulo_dni"])? limpiarCadena($_POST["capitulo_dni"]):"";

      switch ($_GET["op"]) {

        case 'buscar':
          $rspta=$buscador_colegiado->buscar_all($_GET["capitulo"], $_GET["nombre"], $_GET["tipo_busqueda"]);
          $data = [];         
          $cont=1;          

          if ($rspta['status'] == true) {
            foreach ($rspta['data'] as $key => $reg) {              
  
              $ficha_tecnica = empty($reg['documento_cv'])
              ? ( '<div><center><button class="btn btn-danger"><i class="fa fa-file-pdf-o fa-2x text-gray-50"></i></button></center></div>')
              : ( '<center><a target="_blank" href="admin/dist/docs/colegiado/cv/' . $reg['documento_cv'] . '"><i class="far fa-file-pdf-o fa-2x" style="color:#ff0000c4"></i></a></center>');

              $data[] = [
                "0"=>$cont++,
                "1" => '<button class="btn '. ($reg['count_exp'] == 0 ? 'btn-outline-info' : 'btn-info' ) .'  btn-sm" onclick="detalle_colegiado('.$reg['idcolegiado'].')" style="cursor: pointer !important;" ><i class="far fa-eye"></i></button>',                  
                "2" => '<div class="user-block w-300px">
                  <img class="profile-user-img img-circle cursor-pointer" src="http://ciptarapoto.com/intranet/web/' . $reg['foto'] . '" alt="user image" onerror="'.$imagen_error.'" onclick="ver_perfil_colegiado(\'http://ciptarapoto.com/intranet/web/'.$reg['foto']. '\', \''.$reg['nombres_y_apellidos'].'\')" width="50px">
                  <span class="username"><p class="text-primary m-b-02rem" >'. $reg['nombres_y_apellidos'].'</p></span>
                  <span class="description">DNI: '. $reg['dni'] .' </span>
                </div>' ,
                "3" => $reg['codigo_cip'], 
                "4" => '<div class="w-200px">' . $reg['capitulo'] . '<br> <span class="text-primary">'.$reg['especialidad'].'</span> </div>', 
                "5" => '<div class="font-size-10px">' . ($reg['estado'] == 'f' ? '<span class="text-center p-1 badge-danger">NO HABILITADO</span>' : '<span class="text-center p-1 badge-success">HABILITADO</span>') . '</div>',
                "6" => date("d/m/Y", strtotime($reg['fecha_incorporacion'])),
                "7" => $reg['situacion'] ,
                "8" => '<a href="mailto:'.$reg['email'].'">'.$reg['email'].'</a>'  ,
                "9" => $ficha_tecnica ,
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

        case 'ver_detalle_colegiado':

          $rspta=$buscador_colegiado->ver_detalle_colegiado($_POST["id"]);
          //Codificar el resultado utilizando json
          echo json_encode($rspta, true);

        break;
        
        // case 'buscar_pg':
        //   $rspta=$trabajador->buscar_all($_GET["capitulo"], $_GET["nombre"], $_GET["tipo_busqueda"]);
        //   $data = [];         
        //   $cont=1;          

        //   if ($rspta['status'] == true) {
        //     foreach ($rspta['data'] as $key => $reg) {              
  
        //       // $ficha_tecnica = empty($reg['ficha_tecnica'])
        //       //   ? ( '<div><center><a type="btn btn-danger" class=""><i class="far fa-file-pdf fa-2x text-gray-50"></i></a></center></div>')
        //       //   : ( '<center><a target="_blank" href="../dist/docs/material/ficha_tecnica/' . $reg['ficha_tecnica'] . '"><i class="far fa-file-pdf fa-2x" style="color:#ff0000c4"></i></a></center>');

        //       $data[] = [
        //         "0"=>$cont++,
        //         "1" => ' <button class="btn btn-info btn-sm" onclick="detalle_colegiado(\' \')" ><i class="far fa-eye"></i></button>',                  
        //         "2" => '<div class="user-block w-300px">
        //           <img class="profile-user-img img-circle cursor-pointer" src="http://ciptarapoto.com/intranet/web/' . $reg[0] . '" alt="user image" onerror="'.$imagen_error.'" onclick="ver_perfil_colegiado(\'http://ciptarapoto.com/intranet/web/'.$reg[0]. '\', \''.$reg[1].'\')" width="50px">
        //           <span class="username"><p class="text-primary m-b-02rem" >'. $reg[1].'</p></span>
        //           <span class="description">DNI: '. $reg[2] .' </span>
        //         </div>' ,
        //         "3" => $reg[3], 
        //         "4" => '<div class="w-200px">' . $reg[4] . '<br> <span class="text-primary">'.$reg[5].'</span> </div>', 
        //         "5" => '<div class="font-size-10px">' . ($reg[6] == 'f' ? '<span class="text-center p-1 badge-danger">NO HABILITADO</span>' : '<span class="text-center p-1 badge-success">HABILITADO</span>') . '</div>',
        //         "6" => date("d/m/Y", strtotime($reg[7])),
        //         "7" => $reg[8] ,
        //         "8" => $reg[9] ,
        //         "9" => $reg[10] ,
        //       ];
        //     }
  
        //     $results = [
        //       "sEcho" => 1, //Información para el datatables
        //       "iTotalRecords" => count($data), //enviamos el total registros al datatable
        //       "iTotalDisplayRecords" => 1, //enviamos el total registros a visualizar
        //       "data" => $data,
        //     ];
  
        //     echo json_encode($results);
        //   } else {
        //     echo $rspta['code_error'] .' - '. $rspta['message'] .' '. $rspta['data'];
        //   }
        // break;
        
        // case 'buscar_export_csv':
        //   $rspta=$trabajador->buscar_export_csv_pg();
        //   $data = [];         
        //   $cont=1;          

        //   if ($rspta['status'] == true) {
        //     foreach ($rspta['data'] as $key => $reg) {              
        //         $data[] = [
        //         "0"=>  $cont++,
        //         "1"=> $reg[0],                            
        //         "2" => $reg[1],
        //         "3" => $reg[2], 
        //         "4" => $reg[3], 
        //         "5" => $reg[4],
        //         "6" => $reg[5],
        //         "7" => $reg[6],
        //         "8" => "",
        //         "9" => $reg[4],
        //         "10" => hash("SHA256", $reg[4]),
        //         "11" => $reg[7],
        //         "12" => $reg[8] ,
        //         "13" => $reg[9] ,
        //         "14" => $reg[10] ,
        //         "15" => 'http://ciptarapoto.com/intranet/web/', 
        //       ];
        //     }
  
        //     $results = [
        //       "sEcho" => 1, //Información para el datatables
        //       "iTotalRecords" => count($data), //enviamos el total registros al datatable
        //       "iTotalDisplayRecords" => 1, //enviamos el total registros a visualizar
        //       "data" => $data,
        //     ];
  
        //     echo json_encode($results);
        //   } else {
        //     echo $rspta['code_error'] .' - '. $rspta['message'] .' '. $rspta['data'];
        //   }
        // break;

        default: 
          $rspta = ['status'=>'error_code', 'message'=>'Te has confundido en escribir en el <b>swich.</b>', 'data'=>[]]; echo json_encode($rspta, true); 
        break;

      }

      //Fin de las validaciones de acceso
    } else {
      $retorno = ['status'=>'nopermiso', 'message'=>'Tu sesion a terminado pe, inicia nuevamente', 'data' => [] ];
      echo json_encode($retorno);
    }
  // }


  ob_end_flush();

?>
