<?php
  //Incluímos inicialmente la conexión a la base de datos
  require "../config/Conexion.php";

  class Buscador_colegiado
  {
    //Implementamos nuestro constructor
    public function __construct()
    {
    }    

    // buscador all
    public function buscar_all($capitulo, $nombre, $tipo) {
      
      $filtro_cap = (empty($capitulo) || $capitulo == '0' || $capitulo == 0 ) ? '' : "AND c.idcapitulo = '$capitulo'" ;

      $filtro_tipo = "";
      if ($tipo == 'all') {
        $filtro_tipo = "and col.nombres||' '||col.ap_pat||' '||col.ap_mat LIKE '%$nombre%'";
      } else if ($tipo == 'nombre') {
        $filtro_tipo = "and col.nombres||' '||col.ap_pat||' '||col.ap_mat LIKE '%$nombre%'";
      } else if ($tipo == 'cip') {
        $filtro_tipo = "and numerocolegiatura LIKE '%$nombre%'";
      } else if ($tipo == 'dni') {
        $filtro_tipo = "and nro_documento LIKE '%$nombre%'";
      }

      $sql_1="SELECT col.foto,  col.nombres||' '||col.ap_pat||' '||col.ap_mat as colegiado, col.nro_documento, 
      col.numerocolegiatura, c.descripcion as Capítulo, especial.descripcion as Especialidad, 
      col.estadohabil, col.fecha_incorporacion, situa.descripcion as Situación, col.email, col.ruta_archivo
      FROM colegiado col, detalle_colegiado_capitulo_especialidad det_cap, capitulo c, especialidad especial, situacion situa
      WHERE col.idsituacion = 1 AND col.idcolegiado = det_cap.idcolegiado AND det_cap.idcapitulo = c.idcapitulo  
      AND det_cap.idespecialidad = especial.idespecialidad AND col.idsituacion = situa.idsituacion
      $filtro_cap $filtro_tipo
      order by col.nombres";
      $colegiado_0 = ejecutarConsultaArray($sql_1);  if ($colegiado_0['status'] == false) { return  $colegiado_0;}
      
      return  array( 
        'count' => count($colegiado_0['data']), 
        'status' => true, 
        'message' => 'Salió todo ok, en ejecutarConsultaArray()', 
        'data' => $colegiado_0['data'], 
      );
    }    

    public function buscar_export_csv() {
      

      $sql_1="SELECT col.idcolegiado, 
      col.foto,  
      col.nombres||' '||col.ap_pat||' '||col.ap_mat as colegiado, 
      col.nro_documento, 
      col.numerocolegiatura, 
      c.descripcion as Capítulo, 
      especial.descripcion as Especialidad, 
      col.estadohabil, 
      col.fecha_incorporacion, 
      situa.descripcion as Situación, 
      col.email
      FROM colegiado col, detalle_colegiado_capitulo_especialidad det_cap, capitulo c, especialidad especial, situacion situa
      WHERE col.idsituacion = 1 AND col.idcolegiado = det_cap.idcolegiado AND det_cap.idcapitulo = c.idcapitulo  
      AND det_cap.idespecialidad = especial.idespecialidad AND col.idsituacion = situa.idsituacion
  
      order by col.nombres";
      $colegiado_0 = ejecutarConsultaArray($sql_1);  if ($colegiado_0['status'] == false) { return  $colegiado_0;}
      
      return  array( 
        'count' => count($colegiado_0['data']), 
        'status' => true, 
        'message' => 'Salió todo ok, en ejecutarConsultaArray()', 
        'data' => $colegiado_0['data'], 
      );
    }    

  } 

?>
