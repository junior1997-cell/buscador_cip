<?php
  //Incluímos inicialmente la conexión a la base de datos
  require "../config/Conexion.php";

  class Test
  {
    //Implementamos nuestro constructor
    public function __construct()
    {
    }    

    //Implementar un método para mostrar los datos de un registro a modificar
    public function mostrar_data() {
      
      $sql="SELECT * from colegiado where idsituacion = 1 and estado = true order by colegiado asc";
      $trabajador = ejecutarConsultaArray($sql);  if ($trabajador['status'] == false) { return  $trabajador;}      

      return $trabajador;
    }

  }

?>
