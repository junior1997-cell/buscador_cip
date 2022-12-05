<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion_v2.php";

class Usuario
{
  //Implementamos nuestro constructor
  public function __construct()
  {
  }

  //Implementamos un método para editar registros
  public function editar_colegiado($idcolegiado, $usuario, $password) {

    $clavehash = empty($password) ? '' : ", password='" . hash("SHA256", $password) . "'"; 

    $sql = "UPDATE colegiado SET usuario='$usuario' $clavehash WHERE idcolegiado='$idcolegiado';";
    return ejecutarConsulta($sql);      

  } 

  //Implementar un método para mostrar los datos de un registro a modificar
  public function mostrar_editar_colegiado($idusuario) {
    $sql = "SELECT * FROM colegiado WHERE idcolegiado = '$idusuario';";
    return ejecutarConsultaSimpleFila($sql);
  }

  //Implementar un método para listar los registros
  public function tabla_colegiado() {
    $sql = "SELECT * FROM colegiado ORDER BY nombres_y_apellidos ASC;";
    return ejecutarConsultaArray($sql);
  }
  
  //Función para verificar el acceso al sistema
  public function verificar($login, $clave) {
    $sql = "SELECT * FROM colegiado as c WHERE c.usuario = '$login' AND c.password = '$clave';";
    return ejecutarConsultaSimpleFila($sql);
  }

  //Función para verificar el acceso al sistema
  public function verificar_admin($login, $clave) {
    $sql = "SELECT * FROM administrador as c WHERE c.usuario = '$login' AND c.password = '$clave';";
    return ejecutarConsultaSimpleFila($sql);
  } 
  
}

?>
