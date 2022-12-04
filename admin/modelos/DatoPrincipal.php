<?php
  //Incluímos inicialmente la conexión a la base de datos
  require "../config/Conexion_v2.php";

  class DatoPrincipal
  {
    //Implementamos nuestro constructor
    public function __construct()
    {
    }

    //Implementamos un método para insertar registros
    public function editar( $usuario, $password, $email, $celular, $direccion) {

      $clavehash = empty($password) ? '' : "password='" . hash("SHA256", $password) . "',"; 

      $sql_0 = "UPDATE colegiado SET usuario='$usuario', $clavehash email='$email', 
      celular = '$celular', direccion = '$direccion'
      WHERE idcolegiado='".$_SESSION['idusuario']."';";
      return ejecutarConsulta($sql_0);       
      
    }

    //Implementar un método para mostrar los datos de un registro a modificar
    public function mostrar() {     
      $sql3 = "SELECT * FROM colegiado WHERE idcolegiado='".$_SESSION['idusuario']."';";
      return ejecutarConsultaSimpleFila($sql3);      
    }    

  }

?>
