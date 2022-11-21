<?php
$conn = "host=localhost port=5432 dbname=BDCIP user=postgres password=123456789 options='--client_encoding=UTF8'";
$conexion = pg_connect($conn);

//Si tenemos un posible error en la conexión lo mostramos
if (!$conexion) {
  printf("Falló conexión a la base de datos: %s\n", mysqli_connect_error());
  exit();
}

if (!function_exists('ejecutarConsulta')) {

  function ejecutarConsulta($sql) {
    global $conexion;
    $query = pg_query($conexion, $sql);
    if (pg_last_error($conexion)) { 
      try {
        throw new Exception("MySQL error <b>" . pg_last_error($conexion) . "</b> Query:<br> $query", pg_result_error_field($conexion, PGSQL_DIAG_SQLSTATE));
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
        'affected_rows' => pg_affected_rows($conexion),
        'sqlstate' => pg_result_status($conexion),
        'field_count' => pg_num_rows($conexion),
      );
    }
  }

  function ejecutarConsultaSimpleFila($sql) {
    global $conexion;
    $query = pg_query($conexion, $sql);
    if (pg_last_error($conexion)) {
      try {
        throw new Exception("MySQL error <b>". pg_last_error($conexion) ."</b> Query:<br> $query", pg_result_error_field($conexion, PGSQL_DIAG_SQLSTATE));
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
        'affected_rows' => pg_affected_rows($conexion),
        'sqlstate' => pg_result_status($conexion),
        'field_count' => pg_num_rows($conexion),
      );
    }
  }

  function ejecutarConsultaArray($sql) {
    global $conexion;  //$data= Array();	$i = 0;

    $query = pg_query($conexion, $sql);

    if (pg_last_error($conexion)) {
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
        #'affected_rows' => pg_affected_rows($conexion),
        #'sqlstate' => pg_result_status($conexion),
        #'field_count' => pg_num_rows($conexion), 
      );
    }
  }

  function ejecutarConsulta_retornarID($sql) {
    global $conexion;
    $query = pg_query($conexion, $sql);
    if (pg_last_error($conexion)) {
      try {
        throw new Exception("MySQL error <b> ". pg_last_error($conexion) ."</b> Query:<br> $query", pg_result_error_field($conexion, PGSQL_DIAG_SQLSTATE));
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
        'affected_rows' => pg_affected_rows($conexion),
        'sqlstate' => pg_result_status($conexion),
        'field_count' => pg_num_rows($conexion), 
      );
    }
  }

  function limpiarCadena($str) {
    // htmlspecialchars($str);
    global $conexion;
    $str = pg_escape_string($conexion, trim($str));
    return $str;
  }

  function encodeCadenaHtml($str) {
    // htmlspecialchars($str);
    global $conexion;
    $encod = "UTF-8";
    $str = pg_escape_string($conexion, trim($str));
    return htmlspecialchars($str, ENT_QUOTES);
  }

  function decodeCadenaHtml($str) {
    $encod = "UTF-8";
    return htmlspecialchars_decode($str, ENT_QUOTES);
  }
}

?>
