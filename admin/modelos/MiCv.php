<?php
  //Incluímos inicialmente la conexión a la base de datos
  require "../config/Conexion_v2.php";

  class MiCv
  {
    //Implementamos nuestro constructor
    public function __construct()
    {
    }    

    //Implementar un método para mostrar los datos de un registro a modificar
    public function editar_cv($cv) {

      $sql="UPDATE colegiado SET documento_cv='$cv' WHERE idcolegiado='".$_SESSION['idusuario']."';";
      return ejecutarConsulta($sql);   
      
    }

    //Implementar un método para mostrar los datos de un registro a modificar
    public function mostrar_cv() {

      $sql="SELECT * FROM colegiado WHERE idcolegiado='".$_SESSION['idusuario']."';";
      return ejecutarConsultaSimpleFila($sql);
    }

    //Implementar un método para mostrar los datos de un registro a modificar
    public function obtenercv() {

      $sql="SELECT * FROM colegiado WHERE idcolegiado='".$_SESSION['idusuario']."';";
      return ejecutarConsultaSimpleFila($sql);
    }
  }

?>
