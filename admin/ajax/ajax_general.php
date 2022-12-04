<?php
  ob_start();

  if (strlen(session_id()) < 1) {

    session_start(); //Validamos si existe o no la sesión
  }

  if (!isset($_SESSION["nombre"])) {

    $retorno = ['status'=>'login', 'message'=>'Tu sesion a terminado pe, inicia nuevamente', 'data' => [] ];
    echo json_encode($retorno);  //Validamos el acceso solo a los usuarios logueados al sistema.

  } else {     

    require_once "../modelos/Ajax_general.php";

    $ajax_general = new Ajax_general();
    
    $scheme_host  =  ($_SERVER['HTTP_HOST'] == 'localhost' ? 'http://localhost/buscador_cip/' :  $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'].'/');
    $imagen_error = "this.src='../dist/svg/404-v2.svg'";
    $toltip       = '<script> $(function () { $(\'[data-toggle="tooltip"]\').tooltip(); }); </script>';

    switch ($_GET["op"]) {       

      // buscar datos de RENIEC
      case 'reniec':

        $dni = $_POST["dni"];

        $rspta = $ajax_general->datos_reniec($dni);

        echo json_encode($rspta);

      break;
      
      // buscar datos de SUNAT
      case 'sunat':

        $ruc = $_POST["ruc"];

        $rspta = $ajax_general->datos_sunat($ruc);

        echo json_encode($rspta, true);

      break;
      
      /* ══════════════════════════════════════ E M P R E S A   L A B O R A L  ══════════════════════════════════════ */
      case 'select2Empresa':

        $rspta=$ajax_general->select2Empresa(); $cont = 1; $data = "";

        if ($rspta['status'] == true) {

          foreach ($rspta['data'] as $key => $value) {
            $data .= '<option  value=' . $value['idempresa'] . ' title="'.$value['razon_social'].'">' . $cont++ . '. ' . $value['razon_social'] .' - '. $value['ruc'] . '</option>';
          }

          $retorno = array('status' => true, 'message' => 'Salió todo ok',  'data' => $data, );
  
          echo json_encode($retorno, true);

        } else {

          echo json_encode($rspta, true); 
        } 
      break;       

      /* ══════════════════════════════════════ D E S E M P E Ñ O ══════════════════════════════════════ */
      
      
      /* ══════════════════════════════════════ P R O V E E D O R  ══════════════════════════════════════ */
      
      
      /* ══════════════════════════════════════ B A N C O  ══════════════════════════════════════ */
      
      
      /* ══════════════════════════════════════ C O L O R ══════════════════════════════════════ */
      

      /* ══════════════════════════════════════ U N I D A D   D E   M E D I D A  ══════════════════════════════════════ */
      
      
      /* ══════════════════════════════════════ C A T E G O R I A ══════════════════════════════════════ */
      
      

      /* ══════════════════════════════════════ T I P O   T I E R R A   C O N C R E T O ══════════════════════════════════════ */
      

      /* ══════════════════════════════════════ CLASIFICACION DE GRUPO ══════════════════════════════════════ */
      

      /* ══════════════════════════════════════ P R O D U C T O ══════════════════════════════════════ */


      /* ══════════════════════════════════════ S E R V i C I O S  M A Q U I N A R I A ════════════════════════════ */

      
      /* ══════════════════════════════════════ S E R V i C I O S  E Q U I P O S ════════════════════════════ */

     

      /* ══════════════════════════════════════ C O M P R A   D E   I N S U M O ════════════════════════════ */

      

      /* ══════════════════════════════════════ C O M P R A   D E   A C T I V O   F I J O  ════════════════════════════ */

      

      /* ══════════════════════════════════════ E M P R E S A   A   C A R G O ══════════════════════════════════════ */
      

      /* ══════════════════════════════════════ M A R C A S  ════════════════════════════ */
      

      default: 
        $rspta = ['status'=>'error_code', 'message'=>'Te has confundido en escribir en el <b>swich.</b>', 'data'=>[]]; echo json_encode($rspta, true); 
      break;
    }
      
  }

  ob_end_flush();
?>
