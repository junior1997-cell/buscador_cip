<?php
  //Incluímos inicialmente la conexión a la base de datos
  require "../config/Conexion_v2.php";

  class ExperienciaLaboral
  {
    //Implementamos nuestro constructor
    public function __construct()
    {
    }

    //Implementamos un método para insertar registros
    public function crear_experiencia( $empresa_select2, $fecha_inicio, $fecha_fin, $trabajo_actual, $cargo_laboral, $url_empresa, $certificado) {

      
      $sql_0 = "INSERT INTO experiencia_laboral( idcolegiado, idempresa, fecha_inicio, fecha_fin, trabajo_actual, cargo_laboral, url_empresa, certificado) 
      VALUES (".$_SESSION['idusuario']."','$empresa_select2','$fecha_inicio', '$fecha_fin','$trabajo_actual','$cargo_laboral','$url_empresa','$certificado')";
      return ejecutarConsulta($sql_0);       
      
    }

    //Implementamos un método para insertar registros
    public function editar_experiencia( $idexperiencia_laboral, $empresa_select2, $fecha_inicio, $fecha_fin, $trabajo_actual, $cargo_laboral, $url_empresa, $certificado) {

      $sql_0 = "UPDATE experiencia_laboral SET idempresa='$empresa_select2', fecha_inicio='$fecha_inicio', fecha_fin='$fecha_fin',
      trabajo_actual='$trabajo_actual', cargo_laboral='$cargo_laboral', url_empresa='$url_empresa', certificado='$certificado' 
      WHERE idexperiencia_laboral='$idexperiencia_laboral'";
      return ejecutarConsulta($sql_0);       
      
    }

    //Implementar un método para mostrar los datos de un registro a modificar
    public function mostrar_datos_experiencia($idexperiencia_laboral) {     
      $sql3 = "SELECT * FROM experiencia_laboral WHERE idexperiencia_laboral='$idexperiencia_laboral';";
      return ejecutarConsultaSimpleFila($sql3);      
    }    

    // .....::::::::::::::::::::::::::::::::::::: E M P R E S A   L A B O R A L  :::::::::::::::::::::::::::::::::::::::..

    public function crear_empresa( $num_documento_empresa, $nombre_empresa, $direccion_empresa, $telefono_empresa, $correo_empresa) {       

      $sql_0 = "SELECT * FROM empresa WHERE ruc = '$num_documento_empresa' ";
      $existe = ejecutarConsultaArray($sql_0);  if ($existe['status'] == false) {  return $existe; }   

      if (empty($existe['data'])) {

        $sql3 = "INSERT INTO empresa( razon_social, ruc, direccion, celular, correo ) 
        VALUES ('$nombre_empresa', '$num_documento_empresa', '$direccion_empresa', '$telefono_empresa', '$correo_empresa');";
        return ejecutarConsulta($sql3);    

      } else {

        $info_repetida = ''; 
        foreach ($existe['data'] as $key => $value) {
          $info_repetida .= '<li class="text-left font-size-13px">
            <b>Razón Social: </b>'.$value['razon_social'].'<br>
            <b>RUC: </b>'.$value['ruc'].'<br>
            <b>Direccion: </b>'.$value['direccion'].'<br>
            <b>Celular: </b>'.$value['celular'].'<br>
            <b>Correo: </b>'.$value['correo'].'<br>            
            <b>Estado: </b>'.( $value['estado']==0 ? '<i class="fas fa-check text-success"></i> SI':'<i class="fas fa-times text-danger"></i> NO') .'<br>            
            <hr class="m-t-2px m-b-2px">
          </li>'; 
        }

        $sw = array( 'status' => 'duplicado', 'message' => 'duplicado', 'data' => '<ol>'.$info_repetida.'</ol>', 'id_tabla' => '' );
        return $sw;

      }          
    } 

    public function editar_empresa($idempresa, $num_documento_empresa, $nombre_empresa, $direccion_empresa, $telefono_empresa, $correo_empresa) {     
      $sql3 = "UPDATE empresa SET razon_social='$nombre_empresa', ruc='$num_documento_empresa', direccion='$direccion_empresa',
      celular='$telefono_empresa', correo='$correo_empresa' 
      WHERE idempresa='$idempresa';";
      return ejecutarConsulta($sql3);      
    } 

    public function activar($idempresa) {
      $sql = "UPDATE empresa SET estado='1' WHERE idempresa='$idempresa'";
      return ejecutarConsulta($sql);
    }

    public function desactivar($idempresa) {
      $sql = "UPDATE empresa SET estado='0' WHERE idempresa='$idempresa'";
      return ejecutarConsulta($sql);
    }

    public function mostrar_editar_empresa($idempresa) {
      $sql = "SELECT * FROM empresa WHERE idempresa='$idempresa'";
      return ejecutarConsultaSimpleFila($sql);
    }

    public function tabla_empresa_laboral() {     
      $sql3 = "SELECT * FROM empresa ORDER BY razon_social ASC ;";
      return ejecutarConsulta($sql3);      
    }    

  }

?>
