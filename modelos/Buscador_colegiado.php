<?php
  //Incluímos inicialmente la conexión a la base de datos
  //require "../config/ConexionPg.php";
  require "../config/ConexionMySql.php";

  class Buscador_colegiado
  {
    //Implementamos nuestro constructor
    public function __construct()
    {
    }    

    // ══════════════════════════════════════ conexion a Mysql ══════════════════════════════════════
    public function buscar_all($capitulo, $nombre, $tipo) {
      $data_array = [];
      $filtro_cap = (empty($capitulo) || $capitulo == '0' || $capitulo == 0 ) ? '' : "AND capitulo = '$capitulo'" ;

      $filtro_tipo = "";
      if ($tipo == 'all') {
        $filtro_tipo = "AND nombres_y_apellidos LIKE '%$nombre%'";
      } else if ($tipo == 'nombre') {
        $filtro_tipo = "AND nombres_y_apellidos LIKE '%$nombre%'";
      } else if ($tipo == 'cip') {
        $filtro_tipo = "AND codigo_cip LIKE '%$nombre%'";
      } else if ($tipo == 'dni') {
        $filtro_tipo = "AND dni LIKE '%$nombre%'";
      }

      $sql_1="SELECT * FROM colegiado  WHERE situacion = 'VIVO' $filtro_cap $filtro_tipo  order by nombres_y_apellidos";
      $colegiado_0 = ejecutarConsultaArray($sql_1);  if ($colegiado_0['status'] == false) { return  $colegiado_0;}

      foreach ($colegiado_0['data'] as $key => $value) {

        $sql_2="SELECT COUNT(idcolegiado) as cantidad FROM experiencia_laboral WHERE idcolegiado = '".$value['idcolegiado']."'";
        $contador = ejecutarConsultaSimpleFila($sql_2);  if ($contador['status'] == false) { return  $contador;}

        $data_array[] = [
          'idcolegiado'       => $value['idcolegiado'], 
          'id_colegiado_cip'  => $value['id_colegiado_cip'], 
          'foto'              => $value['foto'], 
          'nombres_y_apellidos' => $value['nombres_y_apellidos'], 
          'dni'               => $value['dni'], 
          'codigo_cip'        => $value['codigo_cip'], 
          'capitulo'          => $value['capitulo'], 
          'especialidad'      => $value['especialidad'], 
          'documento_cv'      => $value['documento_cv'], 
          'usuario'           => $value['usuario'], 
          'password'          => $value['password'], 
          'estado'            => $value['estado'], 
          'fecha_incorporacion' => $value['fecha_incorporacion'], 
          'situacion'         => $value['situacion'], 
          'email'             => $value['email'], 
          'celular'           => $value['celular'], 
          'direccion'         => $value['direccion'], 
          'hosting'           => $value['hosting'], 
          'updated_at'        => $value['updated_at'],
          'created_at'        => $value['created_at'],

          'count_exp'         => empty($contador['data']) ? 0 : (empty($contador['data']['cantidad']) ? 0 : intval($contador['data']['cantidad']) ) ,
        ];
      }
      
      return  array( 
        'count' => count($colegiado_0['data']), 
        'status' => true, 
        'message' => 'Salió todo ok, en ejecutarConsultaArray()', 
        'data' => $data_array, 
      );
    }

    public function ver_detalle_colegiado($id) {      

      $sql_1="SELECT el.idexperiencia_laboral, el.idcolegiado, el.idempresa, el.fecha_inicio, el.fecha_fin, el.trabajo_actual, 
      el.cargo_laboral, el.url_empresa, el.certificado, el.bg_color, el.updated_at, e.razon_social, e.ruc, e.direccion, 
      e.celular, e.correo
      FROM experiencia_laboral as el, empresa as e
      WHERE el.idempresa = e.idempresa AND el.estado = '1' AND el.idcolegiado =  '$id';";
      $colegiado_0 = ejecutarConsultaArray($sql_1);  if ($colegiado_0['status'] == false) { return  $colegiado_0;}
      
      return  array( 
        'count' => count($colegiado_0['data']), 
        'status' => true, 
        'message' => 'Salió todo ok, en ejecutarConsultaArray()', 
        'data' => $colegiado_0['data'], 
      );
    }
    
    // ══════════════════════════════════════  Conexcion a postgress ══════════════════════════════════════
    // public function buscar_all_pg($capitulo, $nombre, $tipo) {
      
    //   $filtro_cap = (empty($capitulo) || $capitulo == '0' || $capitulo == 0 ) ? '' : "AND c.idcapitulo = '$capitulo'" ;

    //   $filtro_tipo = "";
    //   if ($tipo == 'all') {
    //     $filtro_tipo = "and col.nombres||' '||col.ap_pat||' '||col.ap_mat LIKE '%$nombre%'";
    //   } else if ($tipo == 'nombre') {
    //     $filtro_tipo = "and col.nombres||' '||col.ap_pat||' '||col.ap_mat LIKE '%$nombre%'";
    //   } else if ($tipo == 'cip') {
    //     $filtro_tipo = "and numerocolegiatura LIKE '%$nombre%'";
    //   } else if ($tipo == 'dni') {
    //     $filtro_tipo = "and nro_documento LIKE '%$nombre%'";
    //   }

    //   $sql_1="SELECT col.foto,  col.nombres||' '||col.ap_pat||' '||col.ap_mat as colegiado, col.nro_documento, 
    //   col.numerocolegiatura, c.descripcion as Capítulo, especial.descripcion as Especialidad, 
    //   col.estadohabil, col.fecha_incorporacion, situa.descripcion as Situación, col.email, col.ruta_archivo
    //   FROM colegiado col, detalle_colegiado_capitulo_especialidad det_cap, capitulo c, especialidad especial, situacion situa
    //   WHERE col.idsituacion = 1 AND col.idcolegiado = det_cap.idcolegiado AND det_cap.idcapitulo = c.idcapitulo  
    //   AND det_cap.idespecialidad = especial.idespecialidad AND col.idsituacion = situa.idsituacion
    //   $filtro_cap $filtro_tipo
    //   order by col.nombres";
    //   $colegiado_0 = ejecutarConsultaArray($sql_1);  if ($colegiado_0['status'] == false) { return  $colegiado_0;}
      
    //   return  array( 
    //     'count' => count($colegiado_0['data']), 
    //     'status' => true, 
    //     'message' => 'Salió todo ok, en ejecutarConsultaArray()', 
    //     'data' => $colegiado_0['data'], 
    //   );
    // }
    
    // public function buscar_export_csv_pg() {      

    //   $sql_1="SELECT col.idcolegiado, 
    //   col.foto,  
    //   col.nombres||' '||col.ap_pat||' '||col.ap_mat as colegiado, 
    //   col.nro_documento, 
    //   col.numerocolegiatura, 
    //   c.descripcion as Capítulo, 
    //   especial.descripcion as Especialidad, 
    //   col.estadohabil, 
    //   col.fecha_incorporacion, 
    //   situa.descripcion as Situación, 
    //   col.email
    //   FROM colegiado col, detalle_colegiado_capitulo_especialidad det_cap, capitulo c, especialidad especial, situacion situa
    //   WHERE col.idsituacion = 1 AND col.idcolegiado = det_cap.idcolegiado AND det_cap.idcapitulo = c.idcapitulo  
    //   AND det_cap.idespecialidad = especial.idespecialidad AND col.idsituacion = situa.idsituacion
  
    //   order by col.nombres";
    //   $colegiado_0 = ejecutarConsultaArray_Pg($sql_1);  if ($colegiado_0['status'] == false) { return  $colegiado_0;}
      
    //   return  array( 
    //     'count' => count($colegiado_0['data']), 
    //     'status' => true, 
    //     'message' => 'Salió todo ok, en ejecutarConsultaArray()', 
    //     'data' => $colegiado_0['data'], 
    //   );
    // }    

  } 

?>
