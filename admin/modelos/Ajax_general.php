<?php 
  //Incluímos inicialmente la conexión a la base de datos
  require "../config/Conexion_v2.php";

  Class Ajax_general
  {
    //Implementamos nuestro constructor
    public function __construct()
    {

    }	 

    //CAPTURAR PERSONA  DE RENIEC 
    public function datos_reniec($dni) { 

      $url = "https://dniruc.apisperu.com/api/v1/dni/".$dni."?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6Imp1bmlvcmNlcmNhZG9AdXBldS5lZHUucGUifQ.bzpY1fZ7YvpHU5T83b9PoDxHPaoDYxPuuqMqvCwYqsM";
      //  Iniciamos curl
      $curl = curl_init();
      // Desactivamos verificación SSL
      curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, 0 );
      // Devuelve respuesta aunque sea falsa
      curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
      // Especificamo los MIME-Type que son aceptables para la respuesta.
      curl_setopt( $curl, CURLOPT_HTTPHEADER, [ 'Accept: application/json' ] );
      // Establecemos la URL
      curl_setopt( $curl, CURLOPT_URL, $url );
      // Ejecutmos curl
      $json = curl_exec( $curl );
      // Cerramos curl
      curl_close( $curl );

      $respuestas = json_decode( $json, true );

      return $respuestas;
    }

    //CAPTURAR PERSONA  DE RENIEC
    public function datos_sunat($ruc)	{ 
      $url = "https://dniruc.apisperu.com/api/v1/ruc/".$ruc."?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6Imp1bmlvcmNlcmNhZG9AdXBldS5lZHUucGUifQ.bzpY1fZ7YvpHU5T83b9PoDxHPaoDYxPuuqMqvCwYqsM";
      //  Iniciamos curl
      $curl = curl_init();
      // Desactivamos verificación SSL
      curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, 0 );
      // Devuelve respuesta aunque sea falsa
      curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
      // Especificamo los MIME-Type que son aceptables para la respuesta.
      curl_setopt( $curl, CURLOPT_HTTPHEADER, [ 'Accept: application/json' ] );
      // Establecemos la URL
      curl_setopt( $curl, CURLOPT_URL, $url );
      // Ejecutmos curl
      $json = curl_exec( $curl );
      // Cerramos curl
      curl_close( $curl );

      $respuestas = json_decode( $json, true );

      return $respuestas;    	

    }

    /* ══════════════════════════════════════ E M P R E S A   L A B O R A L  ══════════════════════════════════════ */
    //Implementar un método para mostrar los datos de un registro a modificar
    public function select2Empresa() {     
      $sql3 = "SELECT * FROM empresa WHERE estado ='1';";
      return ejecutarConsultaArray($sql3);      
    }    

    /* ══════════════════════════════════════  D E S E M P E Ñ O ══════════════════════════════════════ */   
    

    /* ══════════════════════════════════════ P R O V E E D O R  ══════════════════════════════════════ */
   

    /* ══════════════════════════════════════ B A N C O ══════════════════════════════════════ */
    

    /* ══════════════════════════════════════ C O L O R ══════════════════════════════════════ */
    

    /* ══════════════════════════════════════ U N I D A D   D E   M E D I D A ══════════════════════════════════════ */
    

    /* ══════════════════════════════════════ C A T E G O R I A ══════════════════════════════════════ */


    /* ══════════════════════════════════════ T I P O   T I E R R A   C O N C R E T O ══════════════════════════════════════ */


    /* ══════════════════════════════════════ C L A S I F I C A C I O N   D E   G R U P O ══════════════════════════════════════ */


    /* ══════════════════════════════════════ P R O D U C T O  ══════════════════════════════════════ */


    /* ══════════════════════════════════════ S E R V i C I O S  M A Q U I N A RI A ════════════════════════════ */
    

    /* ══════════════════════════════════════ E M P R E S A   A   C A R G O ══════════════════════════════════════ */


    /* ══════════════════════════════════════ M A R C A S  ════════════════════════════ */



  }

?>