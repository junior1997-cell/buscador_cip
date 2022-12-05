<?php
  //Incluímos inicialmente la conexión a la base de datos
  require "../config/Conexion_v2.php";

  class Conyuge
  {
    //Implementamos nuestro constructor
    public function __construct()
    {
    }

    //Implementamos un método para insertar registros
    public function insertar( $idcolegiado, $num_documento, $nombre, $apellido, $nacimiento, $sexo, $tel_1, $tel_2, $tel_3) {

      $sql = "INSERT INTO conyuge (idcolegiado, nombres, apellidos, dni, fecha_nacimiento, sexo, telefono_1, telefono_2, telefono_3 ) 
      VALUES ('$idcolegiado','$nombre','$apellido','$num_documento','$nacimiento','$sexo', '$tel_1', '$tel_2', '$tel_3')";

      return ejecutarConsulta($sql);      
    }

    //Implementamos un método para editar registros $cci, $tipo, $ocupacion, $ruc, $cv_documentado, $cv_nodocumentado
    public function editar($idconyuge, $idcolegiado, $num_documento, $nombre, $apellido, $nacimiento, $sexo, $tel_1, $tel_2, $tel_3) {    
      $sql = "UPDATE conyuge SET idcolegiado='$idcolegiado', nombres='$nombre', apellidos='$apellido', 
      dni='$num_documento', fecha_nacimiento='$nacimiento', sexo='$sexo', telefono_1='$tel_1', 
      telefono_2='$tel_2', telefono_3='$tel_3' 
      WHERE idconyuge='$idconyuge'";
      return ejecutarConsulta($sql);  
    }

    //Implementar un método para mostrar los datos de un registro a modificar
    public function mostrar() {
      $sql = "SELECT * FROM conyuge WHERE idcolegiado='".$_SESSION['idusuario']."'";
      return ejecutarConsultaSimpleFila($sql);

    }

    public function desactivar($idconyuge) {
      $sql = "UPDATE conyuge SET estado='0' WHERE idconyuge='$idconyuge'";
      return ejecutarConsulta($sql);
    } 

    public function activar($idconyuge) {
      $sql = "UPDATE conyuge SET estado='1' WHERE idconyuge='$idconyuge'";
      return ejecutarConsulta($sql);
    }

    //Implementar un método para listar los registros
    public function tbla_principal() {
      $sql = "SELECT * FROM conyuge WHERE idcolegiado ='".$_SESSION['idusuario']."'";
      return ejecutarConsultaArray($sql);        

    }

  }

?>
