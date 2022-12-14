<?php
  //Incluímos inicialmente la conexión a la base de datos
  require "../config/Conexion_v2.php";

  class Escritorio
  {
    //Implementamos nuestro constructor
    public function __construct()
    {
    }    

    //Implementar un método para mostrar los datos de un registro a modificar
    public function mostrar_datos_colegiado_esposo_hijos_experiencia_laboral() {

      $sql="SELECT * FROM colegiado WHERE idcolegiado='".$_SESSION['idusuario']."';";
      $colegiado = ejecutarConsultaSimpleFila($sql);   if ($colegiado['status'] == false) { return  $colegiado;}

      $sql2 = "SELECT * FROM conyuge WHERE idcolegiado='".$_SESSION['idusuario']."';";
      $esposo = ejecutarConsultaSimpleFila($sql2);   if ($esposo['status'] == false) { return  $esposo;}

      $sql2 = "SELECT * FROM hijos WHERE idcolegiado='".$_SESSION['idusuario']."';";
      $hijos = ejecutarConsultaArray($sql2);   if ($hijos['status'] == false) { return  $hijos;}

      $sql2 = "SELECT el.idexperiencia_laboral, el.idcolegiado, el.idempresa, el.fecha_inicio, el.fecha_fin, el.trabajo_actual, 
      el.cargo_laboral, el.url_empresa, el.certificado, el.bg_color, el.updated_at, e.razon_social, e.ruc, e.direccion, 
      e.celular, e.correo
      FROM experiencia_laboral as el, empresa as e
      WHERE el.idempresa = e.idempresa AND el.estado = '1' AND el.idcolegiado = '".$_SESSION['idusuario']."';";
      $experiencia = ejecutarConsultaArray($sql2);   if ($experiencia['status'] == false) { return  $experiencia;}

      return $retorno=[
        'status'=>true, 
        'message'=>'todo oka ps', 
        'data'=>[
          'colegiado'   =>$colegiado['data'], 
          'esposo'      =>$esposo['data'], 
          'hijos'       =>$hijos['data'], 
          'experiencia' =>$experiencia['data'], 
        ]
      ];
    }
  }

?>
