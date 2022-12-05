<?php
  //Incluímos inicialmente la conexión a la base de datos
  require "../config/Conexion_v2.php";

  class Datos_hijos
  {
    //Implementamos nuestro constructor
    public function __construct()
    {
    }

    //Implementamos un método para insertar registros
    public function insertar( $idcolegiado, $num_documento, $nombre, $apellido, $nacimiento, $sexo) {

      $sql = "INSERT INTO hijos(idcolegiado, nombres, apellidos, dni, fecha_nacimiento, sexo) 
      VALUES ('$idcolegiado','$nombre','$apellido','$num_documento','$nacimiento','$sexo')";

      return ejecutarConsulta($sql);      
    }

    //Implementamos un método para editar registros $cci, $tipo, $ocupacion, $ruc, $cv_documentado, $cv_nodocumentado
    public function editar($idhijos, $idcolegiado, $num_documento, $nombre, $apellido, $nacimiento, $sexo) {    
      $sql = "UPDATE hijos SET idcolegiado='$idcolegiado', nombres='$nombre', apellidos='$apellido', dni='$num_documento', fecha_nacimiento='$nacimiento', sexo='$sexo' 
      WHERE idhijos='$idhijos'";
      return ejecutarConsulta($sql);  
    }

    //Implementar un método para mostrar los datos de un registro a modificar
    public function mostrar($idhijos) {
      $sql = "SELECT * FROM hijos WHERE idhijos='$idhijos'";
      return ejecutarConsultaSimpleFila($sql);

    }

    public function desactivar($idhijos) {
      $sql = "UPDATE hijos SET estado='0' WHERE idhijos='$idhijos'";
      return ejecutarConsulta($sql);
    } 

    public function activar($idhijos) {
      $sql = "UPDATE hijos SET estado='1' WHERE idhijos='$idhijos'";
      return ejecutarConsulta($sql);
    }

    //Implementar un método para listar los registros
    public function tbla_principal() {
      $sql = "SELECT * FROM hijos WHERE idcolegiado ='".$_SESSION['idusuario']."'";
      return ejecutarConsultaArray($sql);        

    }


  }

?>
