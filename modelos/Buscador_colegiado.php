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
    public function buscar_all($capitulo, $nombre) {
      
      $filtro_cap = (empty($capitulo) || $capitulo == '0' || $capitulo == 0 ) ? '' : "AND c.idcapitulo = '$capitulo'" ;

      $sql_1="SELECT col.foto,  col.nombres||' '||col.ap_pat||' '||col.ap_mat as colegiado, col.numerocolegiatura,c.descripcion as Capítulo, 
      especial.descripcion as Especialidad, col.estadohabil, col.fecha_incorporacion, situa.descripcion as Situación, col.email,
      col.ruta_archivo
      FROM colegiado col, detalle_colegiado_capitulo_especialidad det_cap, capitulo c, especialidad especial, situacion situa
      WHERE col.idsituacion = 1 AND col.idcolegiado = det_cap.idcolegiado AND det_cap.idcapitulo = c.idcapitulo  
      AND det_cap.idespecialidad = especial.idespecialidad AND col.idsituacion = situa.idsituacion
      $filtro_cap
      AND col.nombres||' '||col.ap_pat||' '||col.ap_mat  LIKE '%$nombre%'
      order by col.nombres";
      $colegiado_0 = ejecutarConsultaArray($sql_1);  if ($colegiado_0['status'] == false) { return  $colegiado_0;}   

      
      return  array( 
        'count' => count($colegiado_0['data']), 
        'status' => true, 
        'message' => 'Salió todo ok, en ejecutarConsultaArray()', 
        'data' => $colegiado_0['data'], 
      );
    }

    // buscador all
    public function buscar_nombre($capitulo, $nombre) {

      $filtro_cap = (empty($capitulo) || $capitulo == '0' || $capitulo == 0 ) ? '' : "AND c.idcapitulo = '$capitulo'" ;

      $sql="SELECT col.foto,  col.nombres||' '||col.ap_pat||' '||col.ap_mat as colegiado, col.numerocolegiatura,c.descripcion as Capítulo, 
      especial.descripcion as Especialidad, col.estadohabil, col.fecha_incorporacion, situa.descripcion as Situación, col.email,
      col.ruta_archivo
      FROM colegiado col, detalle_colegiado_capitulo_especialidad det_cap, capitulo c, especialidad especial, situacion situa
      WHERE col.idsituacion = 1 AND col.idcolegiado = det_cap.idcolegiado AND det_cap.idcapitulo = c.idcapitulo  
      AND det_cap.idespecialidad = especial.idespecialidad AND col.idsituacion = situa.idsituacion
      and col.nombres||' '||col.ap_pat||' '||col.ap_mat LIKE '%$nombre%' order by nombres asc";
      $trabajador = ejecutarConsultaArray($sql);  if ($trabajador['status'] == false) { return  $trabajador;}      

      return $trabajador;
    }

    // buscador all
    public function buscar_cip($capitulo, $cip) {

      $filtro_cap = (empty($capitulo) || $capitulo == '0' || $capitulo == 0 ) ? '' : "AND c.idcapitulo = '$capitulo'" ;
      
      $sql="SELECT col.foto,  col.nombres||' '||col.ap_pat||' '||col.ap_mat as colegiado, col.numerocolegiatura,c.descripcion as Capítulo, 
      especial.descripcion as Especialidad, col.estadohabil, col.fecha_incorporacion, situa.descripcion as Situación, col.email,
      col.ruta_archivo
      FROM colegiado col, detalle_colegiado_capitulo_especialidad det_cap, capitulo c, especialidad especial, situacion situa
      WHERE col.idsituacion = 1 AND col.idcolegiado = det_cap.idcolegiado AND det_cap.idcapitulo = c.idcapitulo  
      AND det_cap.idespecialidad = especial.idespecialidad AND col.idsituacion = situa.idsituacion
      and numerocolegiatura LIKE '%$cip%' order by nombres asc";
      $trabajador = ejecutarConsultaArray($sql);  if ($trabajador['status'] == false) { return  $trabajador;}      

      return $trabajador;
    }

    // buscador all
    public function buscar_dni($capitulo, $dni) {

      $filtro_cap = (empty($capitulo) || $capitulo == '0' || $capitulo == 0 ) ? '' : "AND c.idcapitulo = '$capitulo'" ;
      
      $sql="SELECT col.foto,  col.nombres||' '||col.ap_pat||' '||col.ap_mat as colegiado, col.numerocolegiatura,c.descripcion as Capítulo, 
      especial.descripcion as Especialidad, col.estadohabil, col.fecha_incorporacion, situa.descripcion as Situación, col.email,
      col.ruta_archivo
      FROM colegiado col, detalle_colegiado_capitulo_especialidad det_cap, capitulo c, especialidad especial, situacion situa
      WHERE col.idsituacion = 1 AND col.idcolegiado = det_cap.idcolegiado AND det_cap.idcapitulo = c.idcapitulo  
      AND det_cap.idespecialidad = especial.idespecialidad AND col.idsituacion = situa.idsituacion
      and nro_documento LIKE '%$dni%' order by nombres asc";
      $trabajador = ejecutarConsultaArray($sql);  if ($trabajador['status'] == false) { return  $trabajador;}      

      return $trabajador;
    }

  }

?>
