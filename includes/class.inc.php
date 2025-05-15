<?php
include_once('constantes.inc.php');
//
class errorHandler{
  function reportError($pstrMysqlError, $pstrQueryError, $pstrURL, $pstrIP){
    $strHTML = "<strong>MYSQL ERROR:</strong> " . $pstrMysqlError . "<br /><br />";
    $strHTML.= "<strong>QUERY ERROR:</strong> " . $pstrQueryError . "<br /><br />";
    $strHTML.= "<strong>URL:</strong> " . $pstrURL . "<br /><br />";
    $strHTML.= "<strong>IP ADDRESS:</strong> " . $pstrIP . "<br /><br />";
    $strSubject = "SITE UNDER ATTACK [\"" . _CONST_TITLE_  . "\"]";
    //
    //if($pstrIP == "127.0.0.1"){
    echo $strHTML;
    /*}
    else{
    sendMail("contacto@2ocho.com.ar", "contacto@2ocho.com.ar", $strSubject, $strHTML);
  }*/
  exit();
}
}
class Usuarios {

  function makeBackendLogin($link,$parrData) {
    $strQuery = 'SELECT * FROM login WHERE ds_usuario = :usuario AND ds_password = :password';
    $stmt = $link->prepare($strQuery);
    $stmt->bindValue(':usuario', $parrData[0]);
    $stmt->bindValue(':password', $parrData[1]);
    $result = $stmt->execute();
    if (!$result) {
      $err = $stmt->errorInfo();
      $objErrorHandler = new errorHandler();
      $objErrorHandler->reportError("Error: " . $err[2], $strQuery, selfURL(), $_SERVER['REMOTE_ADDR']);
      unset($objErrorHandler);
      exit();
    }
    return $stmt;
  }

  function getOneUser($link,$pintIdUser) {
    $strQuery = "SELECT * FROM login WHERE id_usuario = ? ";
    $stmt = $link->prepare($strQuery);
    $stmt->bindValue(1, $pintIdUser);
    $result = $stmt->execute();
    if (!$result) {
      $err = $stmt->errorInfo();
      $objErrorHandler = new errorHandler();
      $objErrorHandler->reportError("Error: " . $err[2], $strQuery, selfURL(), $_SERVER['REMOTE_ADDR']);
      unset($objErrorHandler);
      exit();
    } else {
      return $stmt;
    }
  }

  function getAllUsers($link) {
    $strQuery = "SELECT * FROM login  ORDER BY ds_apellido, ds_nombre DESC";
    $stmt = $link->prepare($strQuery);
    $result = $stmt->execute();
    if (!$result) {
      $err = $stmt->errorInfo();
      $objErrorHandler = new errorHandler();
      $objErrorHandler->reportError("Error: " . $err[2], $strQuery, selfURL(), $_SERVER['REMOTE_ADDR']);
      unset($objErrorHandler);
      exit();
    } else {
      return $stmt;
    }
  }

  function getAllUsersPaginados($link,$arrData) {
    $link->setAttribute( PDO::ATTR_EMULATE_PREPARES, false );
    $strQuery = "SELECT * FROM login  ORDER BY ds_apellido, ds_nombre DESC LIMIT ?,?";
    $stmt = $link->prepare($strQuery);
    $stmt->bindValue(1, $arrData[0]);
    $stmt->bindValue(2, $arrData[1]);
    $result = $stmt->execute();
    if (!$result) {
      $err = $stmt->errorInfo();
      $objErrorHandler = new errorHandler();
      $objErrorHandler->reportError("Error: " . $err[2], $strQuery, selfURL(), $_SERVER['REMOTE_ADDR']);
      unset($objErrorHandler);
      exit();
    } else {
      return $stmt;
    }
  }

  function insertUser($link,$arrData) {
    $strQuery = "INSERT INTO login (ds_nombre,ds_apellido,ds_imagen,id_dni,ds_mail,id_celular,ds_usuario,ds_password,id_tipo,id_habilitado) ";
    $strQuery.= "VALUES (?,?,?,?,?,?,?,?,?,?)";
    $stmt = $link->prepare($strQuery);
    $stmt->bindValue(1, $arrData[1]);
    $stmt->bindValue(2, $arrData[2]);
    $stmt->bindValue(3, $arrData[3]);
    $stmt->bindValue(4, $arrData[4]);
    $stmt->bindValue(5, $arrData[5]);
    $stmt->bindValue(6, $arrData[6]);
    $stmt->bindValue(7, $arrData[7]);
    $stmt->bindValue(8, $arrData[8]);
    $stmt->bindValue(9, $arrData[9]);
    $stmt->bindValue(10, $arrData[10]);
    $result = $stmt->execute();
    if (!$result) {
      $err = $stmt->errorInfo();
      $objErrorHandler = new errorHandler();
      $objErrorHandler->reportError("Error: " . $err[2], $strQuery, selfURL(), $_SERVER['REMOTE_ADDR']);
      unset($objErrorHandler);
      exit();
    }
    $lastReg = $link->lastInsertId();
    return $lastReg;
  }

  function updateUser($link,$parrData) {
    $strQuery = "UPDATE login SET ds_nombre = ?, ds_apellido = ?,ds_imagen = ?,id_dni = ?,ds_mail = ?,id_celular = ?, ds_usuario = ?, ds_password=?, id_tipo=?, id_habilitado=? ";
    $strQuery.= "WHERE id_usuario = ?";
    $stmt = $link->prepare($strQuery);
    $stmt->bindValue(1, $parrData[1]);
    $stmt->bindValue(2, $parrData[2]);
    $stmt->bindValue(3, $parrData[3]);
    $stmt->bindValue(4, $parrData[4]);
    $stmt->bindValue(5, $parrData[5]);
    $stmt->bindValue(6, $parrData[6]);
    $stmt->bindValue(7, $parrData[7]);
    $stmt->bindValue(8, $parrData[8]);
    $stmt->bindValue(9, $parrData[9]);
    $stmt->bindValue(10, $parrData[10]);
    $stmt->bindValue(11, $parrData[0]);
    $result = $stmt->execute();
    if (!$result) {
      $err = $stmt->errorInfo();
      $objErrorHandler = new errorHandler();
      $objErrorHandler->reportError("Error: " . $err[2], $strQuery, selfURL(), $_SERVER['REMOTE_ADDR']);
      unset($objErrorHandler);
      exit();
    }
    return true;
  }

  function updatePerfil($link,$parrData) {
    $strQuery = "UPDATE login SET ds_nombre = ?, ds_apellido = ?,ds_imagen = ?,id_dni = ?,ds_mail = ?,id_celular = ?, ds_usuario = ?, ds_password=? ";
    $strQuery.= "WHERE id_usuario = ?";
    $stmt = $link->prepare($strQuery);
    $stmt->bindValue(1, $parrData[1]);
    $stmt->bindValue(2, $parrData[2]);
    $stmt->bindValue(3, $parrData[3]);
    $stmt->bindValue(4, $parrData[4]);
    $stmt->bindValue(5, $parrData[5]);
    $stmt->bindValue(6, $parrData[6]);
    $stmt->bindValue(7, $parrData[7]);
    $stmt->bindValue(8, $parrData[8]);
    $stmt->bindValue(9, $parrData[0]);
    $result = $stmt->execute();
    if (!$result) {
      $err = $stmt->errorInfo();
      $objErrorHandler = new errorHandler();
      $objErrorHandler->reportError("Error: " . $err[2], $strQuery, selfURL(), $_SERVER['REMOTE_ADDR']);
      unset($objErrorHandler);
      exit();
    }
    return true;
  }
}
//
class General {
  function getAllContenido($link,$strQuery) {
    $strQuery = $strQuery;
    $stmt = $link->prepare($strQuery);
    $result = $stmt->execute();
    if (!$result) {
      $err = $stmt->errorInfo();
      $objErrorHandler = new errorHandler();
      $objErrorHandler->reportError("Error: " . $err[2], $strQuery, selfURL(), $_SERVER['REMOTE_ADDR']);
      unset($objErrorHandler);
      exit();
    } else {
      return $stmt;
    }
  }

  function getAllContenidoPG($link,$parrData,$strQuery) {
    $link->setAttribute( PDO::ATTR_EMULATE_PREPARES, false );
    $strQuery = $strQuery;
    $stmt = $link->prepare($strQuery);
    $stmt->bindValue(1, $parrData[0]);
    $stmt->bindValue(2, $parrData[1]);
    $result = $stmt->execute();
    if (!$result) {
      $err = $stmt->errorInfo();
      $objErrorHandler = new errorHandler();
      $objErrorHandler->reportError("Error: " . $err[2], $strQuery, selfURL(), $_SERVER['REMOTE_ADDR']);
      unset($objErrorHandler);
      exit();
    } else {
      return $stmt;
    }
  }

  /*function getOneContenido($link,$pintIdCont,$strQuery) {
    $strQuery = $strQuery;
    $stmt = $link->prepare($strQuery);
    $resultado = count($pintIdCont);
    for ($i=1;$i < $resultado;$i++)
    {
      $stmt->bindValue($i, $pintIdCont[$i]);
    }
    $result = $stmt->execute();
    if (!$result) {
      $err = $stmt->errorInfo();
      $objErrorHandler = new errorHandler();
      $objErrorHandler->reportError("Error: " . $err[2], $strQuery, selfURL(), $_SERVER['REMOTE_ADDR']);
      unset($objErrorHandler);
      exit();
    } else {
      return $stmt;
    }
  }*/

  function getOneContenido($link,$pintIdCont,$strQuery) {
    $strQuery = $strQuery;
    $stmt = $link->prepare($strQuery);
    
    if(is_array($pintIdCont)){
      $resultado = count($pintIdCont);
      for ($i=1;$i < $resultado;$i++)
      {
        $stmt->bindValue($i, $pintIdCont[$i]);
      }
    } else{
      $stmt->bindValue(1, $pintIdCont);
    }

    
    /*var_dump(gettype($pintIdCont));
    var_dump($resultado);exit();*/

    
    $result = $stmt->execute();
    if (!$result) {
      $err = $stmt->errorInfo();
      $objErrorHandler = new errorHandler();
      $objErrorHandler->reportError("Error: " . $err[2], $strQuery, selfURL(), $_SERVER['REMOTE_ADDR']);
      unset($objErrorHandler);
      exit();
    } else {
      return $stmt;
    }
  }

  function insertContenido($link,$parrData,$strQuery) {
    $strQuery = $strQuery;
    $stmt = $link->prepare($strQuery);
    $resultado = count($parrData);
    for ($i=1;$i < $resultado;$i++)
    {
      $stmt->bindValue($i, $parrData[$i]);
    }
    $result = $stmt->execute();
    if (!$result) {
      $err = $stmt->errorInfo();
      $objErrorHandler = new errorHandler();
      $objErrorHandler->reportError("Error: " . $err[2], $strQuery, selfURL(), $_SERVER['REMOTE_ADDR']);
      unset($objErrorHandler);
      exit();
    }
    $lastReg = $link->lastInsertId();
    return $lastReg;
  }

  function updateContenido($link,$parrData,$strQuery) {
    $stmt = $link->prepare($strQuery);
    $resultado = count($parrData);
    $contador = 0;
    for ($i=1;$i < $resultado;$i++)
    {
      $stmt->bindValue($i, $parrData[$i]);
      $contador = $i+1;
    }
    $stmt->bindValue($contador, $parrData[0]);
    $result = $stmt->execute();
    if (!$result) {
      $err = $stmt->errorInfo();
      $objErrorHandler = new errorHandler();
      $objErrorHandler->reportError("Error: " . $err[2], $strQuery, selfURL(), $_SERVER['REMOTE_ADDR']);
      unset($objErrorHandler);
      exit();
    }
    return true;
  }

  function updateContenidoOrden($link,$parrData,$strQuery) {
    $stmt = $link->prepare($strQuery);
		$stmt->bindValue(1, $parrData[1]);
		$stmt->bindValue(2, $parrData[0]);
		$result = $stmt->execute();
		if (!$result) {
			$err = $stmt->errorInfo();
			$objErrorHandler = new errorHandler();
			$objErrorHandler->reportError("Error: " . $err[2], $strQuery, selfURL(), $_SERVER['REMOTE_ADDR']);
			unset($objErrorHandler);
			exit();
		}
    return true;
  }

  function deleteContenido($link,$strSeccion,$strQuery) {
    $strQuery = $strQuery;
    $stmt = $link->prepare($strQuery);
    $stmt->bindValue(1, $strSeccion[1]);
    $result = $stmt->execute();
    if (!$result) {
      $err = $stmt->errorInfo();
      $objErrorHandler = new errorHandler();
      $objErrorHandler->reportError("Error: " . $err[2], $strQuery, selfURL(), $_SERVER['REMOTE_ADDR']);
      unset($objErrorHandler);
      exit();
    }
    return true;
  }

}
//
class Archivos {
  function getAllContenido($link,$strQuery) {
    $strQuery = $strQuery;
    $stmt = $link->prepare($strQuery);
    $result = $stmt->execute();
    if (!$result) {
      $err = $stmt->errorInfo();
      $objErrorHandler = new errorHandler();
      $objErrorHandler->reportError("Error: " . $err[2], $strQuery, selfURL(), $_SERVER['REMOTE_ADDR']);
      unset($objErrorHandler);
      exit();
    } else {
      return $stmt;
    }
  }

  function getAllContenidoPG($link,$parrData,$strQuery) {
    $link->setAttribute( PDO::ATTR_EMULATE_PREPARES, false );
    $strQuery = $strQuery;
    $stmt = $link->prepare($strQuery);
    $stmt->bindValue(1, $parrData[0]);
    $stmt->bindValue(2, $parrData[1]);
    $result = $stmt->execute();
    if (!$result) {
      $err = $stmt->errorInfo();
      $objErrorHandler = new errorHandler();
      $objErrorHandler->reportError("Error: " . $err[2], $strQuery, selfURL(), $_SERVER['REMOTE_ADDR']);
      unset($objErrorHandler);
      exit();
    } else {
      return $stmt;
    }
  }

  function getOneContenido($link,$pintIdCont,$strQuery) {
    $strQuery = $strQuery;
    $stmt = $link->prepare($strQuery);
    $resultado = count($pintIdCont);
    for ($i=1;$i < $resultado;$i++)
    {
      $stmt->bindValue($i, $pintIdCont[$i]);
    }
    $result = $stmt->execute();
    if (!$result) {
      $err = $stmt->errorInfo();
      $objErrorHandler = new errorHandler();
      $objErrorHandler->reportError("Error: " . $err[2], $strQuery, selfURL(), $_SERVER['REMOTE_ADDR']);
      unset($objErrorHandler);
      exit();
    } else {
      return $stmt;
    }
  }

  function insertContenido($link,$parrData,$strQuery) {
    $strQuery = $strQuery;
    $stmt = $link->prepare($strQuery);
    $resultado = count($parrData);
    for ($i=1;$i < $resultado;$i++)
    {
      $stmt->bindValue($i, $parrData[$i]);
    }
    $result = $stmt->execute();
    if (!$result) {
      $err = $stmt->errorInfo();
      $objErrorHandler = new errorHandler();
      $objErrorHandler->reportError("Error: " . $err[2], $strQuery, selfURL(), $_SERVER['REMOTE_ADDR']);
      unset($objErrorHandler);
      exit();
    }
    $lastReg = $link->lastInsertId();
    return $lastReg;
  }


}
//
class Galerias {
  function getAllImagenes($link,$pintIdCont,$strQuery) {
    $strQuery = $strQuery;
    $stmt = $link->prepare($strQuery);
    $resultado = count($pintIdCont);
    for ($i=1;$i < $resultado;$i++)
    {
      $stmt->bindValue($i, $pintIdCont[$i]);
    }
    $result = $stmt->execute();
    if (!$result) {
      $err = $stmt->errorInfo();
      $objErrorHandler = new errorHandler();
      $objErrorHandler->reportError("Error: " . $err[2], $strQuery, selfURL(), $_SERVER['REMOTE_ADDR']);
      unset($objErrorHandler);
      exit();
    } else {
      return $stmt;
    }
  }

}
//
class iUpload {
  function renameFile($pstrFileName) {
    //$pstrFileName = strtolower($pstrFileName);

    $valores = array("á","é","í","ó","ú","Á","É","Í","Ó","Ú"," ","ñ","º","(",")","ä","ë","ï","ö","ü","Ä","Ë","Ï","Ö","Ü",",","'","[","]","{","}","?","¿","/","$","+","*","&","!","#","@","%",";",":","|"); // Valores no permitidos
    $valoresr = array("a","e","i","o","u","A","E","I","O","U","_","n","_","_","_","a","e","i","o","u","A","E","I","O","U","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_"); // Valores permitidos
    $pstrFileName = str_replace($valores, $valoresr, $pstrFileName);
    $strPDF = strtolower($pstrFileName);


    $randomNumber = rand(0,9999);
    $strTMPName = explode('.', $strPDF);
    $strPDF = $strTMPName[0] . $randomNumber . "." . strtolower($strTMPName[1]);
    return $strPDF;
  }

  function renameFile2($pstrFileName) {

    $valores = array("á","é","í","ó","ú","Á","É","Í","Ó","Ú"," ","ñ","º","(",")","ä","ë","ï","ö","ü","Ä","Ë","Ï","Ö","Ü",",","'","[","]","{","}","?","¿","/","$","+","*","&","!","#","@","%",";",":","|"); // Valores no permitidos
    $valoresr = array("a","e","i","o","u","A","E","I","O","U","_","n","_","_","_","a","e","i","o","u","A","E","I","O","U","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_"); // Valores permitidos
    $pstrFileName = str_replace($valores, $valoresr, $pstrFileName);
    $strPDF = strtolower($pstrFileName);


    $strTMPName = explode('.', $strPDF);
    $strPDF = $strTMPName[0]  . "." . strtolower($strTMPName[1]);
    return $strPDF;
  }

  function renameImage($pstrFileName) {
    $pstrFileName = strtolower($pstrFileName); // Pone en minúscula el nombre de la imagen
    $valores = array("á","é","í","ó","ú"," ","ñ","º","(",")","ä","ë","ï","ö","ü",",","'","[","]","{","}","?","¿","/","$","+","*","&","!","#","@","%",";",":","|"); // Valores no permitidos
    $pstrFileName = str_replace($valores, "_", $pstrFileName);
    $randomNumber = rand(0,9999);
    $strTMPName = explode('.', $pstrFileName);
    $strImage = $strTMPName[0] . $randomNumber;
    return $strImage;
  }

  function deleteFile($pstrArchivo) {
    unlink($pstrArchivo);
    return true;
  }
  function renameImageBlob($pstrFileName) {
    //$pstrFileName = strtolower($pstrFileName); // Pone en minúscula el nombre de la imagen
    $valores = array("á","é","í","ó","ú","Á","É","Í","Ó","Ú"," ","ñ","º","(",")","ä","ë","ï","ö","ü","Ä","Ë","Ï","Ö","Ü",",","'","[","]","{","}","?","¿","/","$","+","*","&","!","#","@","%",";",":","|"); // Valores no permitidos
    $valoresr = array("a","e","i","o","u","A","E","I","O","U","_","n","_","_","_","a","e","i","o","u","A","E","I","O","U","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_"); // Valores permitidos

    $pstrFileName = str_replace($valores, $valoresr, $pstrFileName);
    
    $strImage = $pstrFileName;
    return $strImage;
  }
}

//
class ComonClases {
  function deleteRegistro($link,$strSeccion) {
    if ($strSeccion[1] == "usuarios"){
      $strQuery = "DELETE FROM login WHERE id_usuario = ?";
    }

    if ($strSeccion[1] == "categorias"){
      $strQuery = "DELETE FROM categorias WHERE cat_id = ?";
    }

    if ($strSeccion[1] == "equipos"){
      $strQuery = "DELETE FROM equipos WHERE eq_id = ?";
    }

    if ($strSeccion[1] == "clases"){
      $strQuery = "DELETE FROM equipo_clases WHERE ecl_id = ?";
    }
    if ($strSeccion[1] == "tpracticos"){
      $strQuery = "DELETE FROM trabajos_practicos WHERE tp_id = ?";
    }
    if ($strSeccion[1] == "alumnos"){
      $strQuery = "DELETE FROM data_estudiantes WHERE estudiantes_id = ?";
    }
    if ($strSeccion[1] == "profesores"){
      $strQuery = "DELETE FROM data_profesores WHERE profesores_id = ?";
    }
    if ($strSeccion[1] == "materias"){
      $strQuery = "DELETE FROM data_materia WHERE materia_id = ?";
    }
    /*
   
    if ($strSeccion[1] == "archivos"){
      $strQuery = "DELETE FROM archivos WHERE id = ?";
    }

    if ($strSeccion[1] == "post"){
      $strQuery = "DELETE FROM contenido2 WHERE id = ?";
    }

    if ($strSeccion[1] == "socios"){
      $strQuery = "DELETE FROM socios WHERE soc_id = ?";
    }

    if ($strSeccion[1] == "docentes"){
      $strQuery = "DELETE FROM docentes WHERE doc_id = ?";
    }
    
    if ($strSeccion[1] == "cdirectiva"){
      $strQuery = "DELETE FROM comision WHERE com_id = ?";
    }
    if ($strSeccion[1] == "revistas"){
      $strQuery = "DELETE FROM revistas WHERE rev_id = ?";
    }

    if ($strSeccion[1] == "alianzas"){
      $strQuery = "DELETE FROM alianzas WHERE al_id = ?";
    }

    if ($strSeccion[1] == "intalianzas"){
      $strQuery = "DELETE FROM integrantesalianzas WHERE int_id = ?";
    }*/

    $stmt = $link->prepare($strQuery);
    $stmt->bindValue(1, $strSeccion[0]);
    $result = $stmt->execute();
    if (!$result) {
      $err = $stmt->errorInfo();
      $objErrorHandler = new errorHandler();
      $objErrorHandler->reportError("Error: " . $err[2], $strQuery, selfURL(), $_SERVER['REMOTE_ADDR']);
      unset($objErrorHandler);
      exit();
    }
      return true;
  }

}
?>
