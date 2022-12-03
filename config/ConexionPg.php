<?php
$conn = "host=localhost port=5432 dbname=BDCIP user=postgres password=123456789 options='--client_encoding=UTF8'";
$conexion_pg = pg_connect($conn);

//Si tenemos un posible error en la conexión lo mostramos
if (!$conexion_pg) {
  printf("Falló conexión a la base de datos: %s\n", mysqli_connect_error());
  exit();
}

if (!function_exists('ejecutarConsulta')) {

  function ejecutarConsulta_Pg($sql) {
    global $conexion_pg;
    $query = pg_query($conexion_pg, $sql);
    if (pg_last_error($conexion_pg)) { 
      try {
        throw new Exception("MySQL error <b>" . pg_last_error($conexion_pg) . "</b> Query:<br> $query", pg_result_error_field($conexion_pg, PGSQL_DIAG_SQLSTATE));
      } catch (Exception $e) {
        //echo "Error No: " . $e->getCode() . " - " . $e->getMessage() . "<br >"; echo nl2br($e->getTraceAsString());
        return array( 
          'status' => false, 
          'code_error' => $e->getCode(), 
          'message' => $e->getMessage(), 
          'data' => '<br><b>Rutas de errores:</b> <br>'.nl2br($e->getTraceAsString()),
        );          
      }
    } else {
      $insert_id = pg_fetch_row($query);
      return array( 
        'status' => true, 
        'message' => 'Salió todo ok, en ejecutarConsulta()', 
        'data' => $query, 
        'id_tabla' => $insert_id[0],
        'affected_rows' => pg_affected_rows($conexion_pg),
        'sqlstate' => pg_result_status($conexion_pg),
        'field_count' => pg_num_rows($conexion_pg),
      );
    }
  }

  function ejecutarConsultaSimpleFila_Pg($sql) {
    global $conexion_pg;
    $query = pg_query($conexion_pg, $sql);
    if (pg_last_error($conexion_pg)) {
      try {
        throw new Exception("MySQL error <b>". pg_last_error($conexion_pg) ."</b> Query:<br> $query", pg_result_error_field($conexion_pg, PGSQL_DIAG_SQLSTATE));
      } catch (Exception $e) {
        //echo "Error No: " . $e->getCode() . " - " . $e->getMessage() . "<br >"; echo nl2br($e->getTraceAsString());
        $data_errores = array( 
          'status' => false, 
          'code_error' => $e->getCode(), 
          'message' => $e->getMessage(), 
          'data' => '<br><b>Rutas de errores:</b> <br>'.nl2br($e->getTraceAsString()),
        );
        return $data_errores;
      }

    } else {
      $row = pg_fetch_row($query);
      return array( 
        'status' => true, 
        'message' => 'Salió todo ok, en ejecutarConsultaSimpleFila()', 
        'data' => $row, 
        'id_tabla' => '',
        'affected_rows' => pg_affected_rows($conexion_pg),
        'sqlstate' => pg_result_status($conexion_pg),
        'field_count' => pg_num_rows($conexion_pg),
      );
    }
  }

  function ejecutarConsultaArray_Pg($sql) {
    global $conexion_pg;  //$data= Array();	$i = 0;

    $query = pg_query($conexion_pg, $sql);

    if (pg_last_error($conexion_pg)) {
      try {
        throw new Exception("MySQL error <b>". pg_last_error($query) ."</b> Query:<br> $query", pg_result_error_field($query, PGSQL_DIAG_SQLSTATE));
      } catch (Exception $e) {
        //echo "Error No: " . $e->getCode() . " - " . $e->getMessage() . "<br >"; echo nl2br($e->getTraceAsString());
        return array( 
          'status' => false, 
          'code_error' => $e->getCode(), 
          'message' => $e->getMessage(), 
          'data' => '<br><b>Rutas de errores:</b> <br>'.nl2br($e->getTraceAsString()),
        );          
      }
    } else {
      for ($data = []; ($row = pg_fetch_row($query)); $data[] = $row);
      return  array( 
        'count' => count($data), 
        'status' => true, 
        'message' => 'Salió todo ok, en ejecutarConsultaArray()', 
        'data' => $data, 
        'id_tabla' => '',
        #'affected_rows' => pg_affected_rows($conexion_pg),
        #'sqlstate' => pg_result_status($conexion_pg),
        #'field_count' => pg_num_rows($conexion_pg), 
      );
    }
  }

  function ejecutarConsulta_retornarID_Pg($sql) {
    global $conexion_pg;
    $query = pg_query($conexion_pg, $sql);
    if (pg_last_error($conexion_pg)) {
      try {
        throw new Exception("MySQL error <b> ". pg_last_error($conexion_pg) ."</b> Query:<br> $query", pg_result_error_field($conexion_pg, PGSQL_DIAG_SQLSTATE));
      } catch (Exception $e) {
        //echo "Error No: " . $e->getCode() . " - " . $e->getMessage() . "<br >"; echo nl2br($e->getTraceAsString());
        return array( 
          'status' => false, 
          'code_error' => $e->getCode(), 
          'message' => $e->getMessage(), 
          'data' => '<br><b>Rutas de errores:</b> <br>'.nl2br($e->getTraceAsString()),
        );          
      }
    } else {
      $insert_id = pg_fetch_row($query);
      return  array( 
        'status' => true, 
        'message' => 'Salió todo ok, en ejecutarConsultaArray()', 
        'data' => $insert_id, 
        'id_tabla' => $insert_id,
        'affected_rows' => pg_affected_rows($conexion_pg),
        'sqlstate' => pg_result_status($conexion_pg),
        'field_count' => pg_num_rows($conexion_pg), 
      );
    }
  }

  function limpiarCadena_Pg($str) {
    // htmlspecialchars($str);
    global $conexion_pg;
    $str = pg_escape_string($conexion_pg, trim($str));
    return $str;
  }

  function encodeCadenaHtml_Pg($str) {
    // htmlspecialchars($str);
    global $conexion_pg;
    $encod = "UTF-8";
    $str = pg_escape_string($conexion_pg, trim($str));
    return htmlspecialchars($str, ENT_QUOTES);
  }

  function decodeCadenaHtml_Pg($str) {
    $encod = "UTF-8";
    return htmlspecialchars_decode($str, ENT_QUOTES);
  }
}

?>
