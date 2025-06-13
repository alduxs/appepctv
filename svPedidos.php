<?PHP
include_once("includes/checkLogin.inc.php");
include_once('includes/conexion.inc.php');
include_once('includes/funciones.inc.php');
include_once('includes/class.inc.php');
/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/
//
$link = Conectarse();
//
$strOperacion = sanStrHtmlSpecial($_POST["strOperacion"]);
//
if (isset($_POST["intPage"])) {
    $intPage = $_POST["intPage"];
} else {
    $intPage = 1;
}
//
//include("includes/class.upload.php");
//
date_default_timezone_set('America/Los_Angeles');
//
switch ($strOperacion) {
    case 'I':
        //

        $Insert_row = new General();

        $fecha = date('Ymd h:i:s');
        $update = $fecha;

        $fechin = invertFecha($_POST["fechain"]);
        $horain = hora($_POST["horain"]);
        $retiro = $fechin . $horain;

        $fechout = invertFecha($_POST["fechaout"]);
        $horaout = hora($_POST["horaout"]);
        $devolucion = $fechout . $horaout;

        $idtemporal = $_POST["idtemporal"];

        //INSERTAR PEDIDO TEMP
        $arrDataTemp[0] = '';
        $arrDataTemp[1] = sanStrHtml($_POST["nombre"]);
        $arrDataTemp[2] = $retiro;
        $arrDataTemp[3] = $devolucion;
        $arrDataTemp[4] = $idtemporal;

        $query = "INSERT INTO pedidos_temp (pedidos_nombre,pedidos_fechain,pedidos_fechaout,pedidos_id_temp) VALUES (?,?,?,?)";
        $intIdRegistroTemp = $Insert_row->insertContenido($link, $arrDataTemp, $query); //Registro de página

        //INSERTA EN TABLA PEDIDO
        $arrData[0] = '';
        $arrData[1] = sanStrHtml($_POST["nombre"]);
        $arrData[2] = $retiro;
        $arrData[3] = $devolucion;
        $arrData[4] = 1;
        $arrData[5] = $idtemporal;
        //
        $query = "INSERT INTO pedidos (pedidos_nombre,pedidos_fechain,pedidos_fechaout,pedidos_estado,pedidos_id_temporal) VALUES (?,?,?,?,?)";
        $intIdRegistro = $Insert_row->insertContenido($link, $arrData, $query); //Registro de página

        //INSERTA TP
        $arrData2[0] = '';
        $arrData2[1] = $intIdRegistro;
        $arrData2[2] = 1;
        $arrData2[3] = sanInt($_POST["materia"]);
        //
        $query = "INSERT INTO pedidos_detalle (pd_id_pedido,pd_tipo,pd_id_registro) VALUES (?,?,?)";
        $intIdRegistro2 = $Insert_row->insertContenido($link, $arrData2, $query); //Registro de página

        //INSERTA Profesor
        $arrData2[0] = '';
        $arrData2[1] = $intIdRegistro;
        $arrData2[2] = 2;
        $arrData2[3] = sanInt($_POST["docente"]);
        //
        $query = "INSERT INTO pedidos_detalle (pd_id_pedido,pd_tipo,pd_id_registro) VALUES (?,?,?)";
        $intIdRegistro3 = $Insert_row->insertContenido($link, $arrData2, $query); //Registro de página

        //INSERTA Responsables
        $arrData2[0] = '';
        $arrData2[1] = $intIdRegistro;
        $arrData2[2] = 3;
        $arrData2[3] = sanInt($_POST["responsable"]);
        //
        $query = "INSERT INTO pedidos_detalle (pd_id_pedido,pd_tipo,pd_id_registro) VALUES (?,?,?)";
        $intIdRegistro4 = $Insert_row->insertContenido($link, $arrData2, $query); //Registro de página

        for ($i=0; $i < count($_POST["integrantes"]); $i++) { 
            
            //INSERTA Integrantes
            $arrData2[0] = '';
            $arrData2[1] = $intIdRegistro;
            $arrData2[2] = 4;
            $arrData2[3] = sanInt($_POST["integrantes"][$i]);
            //
            $query = "INSERT INTO pedidos_detalle (pd_id_pedido,pd_tipo,pd_id_registro) VALUES (?,?,?)";
            $intIdRegistro4 = $Insert_row->insertContenido($link, $arrData2, $query); //Registro de página
        }

        //INSERTA Otos Detalles
        $arrData2[0] = '';
        $arrData2[1] = $intIdRegistro;
        $arrData2[2] = sanStrHtml($_POST["comision"]);
        $arrData2[3] = sanStrHtml($_POST["curso"]);
        //
        $query = "INSERT INTO pedidos_detalle2 (pd2_id_pedido,pd2_comision,pd2_curso) VALUES (?,?,?)";
        $intIdRegistro4 = $Insert_row->insertContenido($link, $arrData2, $query); //Registro de página

        //SELECIONA DE LA TABLA DE PEDIDOS EQUPOS TEMPORAL TODoS LOS EQUIPOS SOLICITADOS
        $query = "SELECT *
        FROM pedidos_equipos_temp
        WHERE pe_id_pedido_temp ='" . $idtemporal."'";
        $rsCont = $Insert_row->getAllContenido($link, $query);

        while ($arrCont = $rsCont->fetch(PDO::FETCH_BOTH)) {

            $arrDataPedEq[0] = '';
            $arrDataPedEq[1] = $idtemporal;
            $arrDataPedEq[2] = $intIdRegistro;
            $arrDataPedEq[3] = $arrCont["pe_id_equipo"];
            $arrDataPedEq[4] = 0;
            //
            $query = "INSERT INTO pedidos_equipos (pe_id_pedido_temp,pe_id_pedido,pe_id_equipo,pe_posicion) VALUES (?,?,?,?)";
            $intIdRegistroPedEq = $Insert_row->insertContenido($link, $arrDataPedEq, $query); //Registro de página

        }

        $query = "DELETE FROM pedidos_equipos_temp WHERE pe_id_pedido_temp = '" . $idtemporal."'";
        $intIdRegistroDeltemp = $Insert_row->getAllContenido($link, $query);


        break;


    case 'U':
        // BUSCO LOS DATOS DEL CONTENIDO A MODIFICAR
        // PARA VERIFICAR SI SE CAMBIARON LAS IMAGENES

        //

        $idtemporal = $_POST["idtemporal"];

        $fechin = invertFecha($_POST["fechain"]);
        $horain = hora($_POST["horain"]);
        $retiro = $fechin . $horain;

        $fechout = invertFecha($_POST["fechaout"]);
        $horaout = hora($_POST["horaout"]);
        $devolucion = $fechout . $horaout;

        $Update_row = new General();

        //UPDATE PEDIDO TEMP
        $arrDataTemp[0] = $idtemporal;
        $arrDataTemp[1] = sanStrHtml($_POST["nombre"]);
        $arrDataTemp[2] = $retiro;
        $arrDataTemp[3] = $devolucion;
        

        $query = "UPDATE pedidos_temp SET  pedidos_nombre = ?,pedidos_fechain = ?,pedidos_fechaout = ? WHERE pedidos_id_temp = ?";
        $intIdRegistroTemp = $Update_row->updateContenido($link, $arrDataTemp, $query); //Registro de página

        //UPDATE PEDIDOS
        $arrData[0] = sanInt($_POST["id"]);
        $arrData[1] = sanStrHtml($_POST["nombre"]);
        $arrData[2] = $retiro;
        $arrData[3] = $devolucion;
        $arrData[4] = 1;
        //
        
        $query = "UPDATE pedidos SET  pedidos_nombre = ?,pedidos_fechain = ?,pedidos_fechaout = ?, pedidos_estado = ? WHERE pedidos_id = ?";
        $intIdRegistro = $Update_row->updateContenido($link, $arrData, $query);


        //Borra Todos los Detalles
        $query = "DELETE FROM pedidos_detalle WHERE pd_id_pedido = " . $arrData[0];
        $intIdRegistroDel1 = $Update_row->getAllContenido($link, $query);

        //Borra Todos los Módulos
        $query = "DELETE FROM pedidos_detalle2 WHERE pd2_id_pedido = " . $arrData[0];
        $intIdRegistroDel1 = $Update_row->getAllContenido($link, $query);

        //Borra Todos los Equipos
        $query = "DELETE FROM pedidos_equipos WHERE pe_id_pedido = " . $arrData[0];
        $intIdRegistroDel1 = $Update_row->getAllContenido($link, $query);

        //INSERTA Tp
        $arrData2[0] = '';
        $arrData2[1] = $arrData[0];
        $arrData2[2] = 1;
        $arrData2[3] = sanInt($_POST["materia"]);
        //
        $query = "INSERT INTO pedidos_detalle (pd_id_pedido,pd_tipo,pd_id_registro) VALUES (?,?,?)";
        $intIdRegistro2 = $Update_row->insertContenido($link, $arrData2, $query); //Registro de página

        //INSERTA Profesor
        $arrData2[0] = '';
        $arrData2[1] = $arrData[0];
        $arrData2[2] = 2;
        $arrData2[3] = sanInt($_POST["docente"]);
        //
        $query = "INSERT INTO pedidos_detalle (pd_id_pedido,pd_tipo,pd_id_registro) VALUES (?,?,?)";
        $intIdRegistro3 = $Update_row->insertContenido($link, $arrData2, $query); //Registro de página

        //INSERTA Responsables
        $arrData2[0] = '';
        $arrData2[1] = $arrData[0];
        $arrData2[2] = 3;
        $arrData2[3] = sanInt($_POST["responsable"]);
        //
        $query = "INSERT INTO pedidos_detalle (pd_id_pedido,pd_tipo,pd_id_registro) VALUES (?,?,?)";
        $intIdRegistro4 = $Update_row->insertContenido($link, $arrData2, $query); //Registro de página


        for ($i=0; $i < count($_POST["integrantes"]); $i++) { 
            
            //INSERTA Integrante
            $arrData2[0] = '';
            $arrData2[1] = $arrData[0];
            $arrData2[2] = 4;
            $arrData2[3] = sanInt($_POST["integrantes"][$i]);
            //
            $query = "INSERT INTO pedidos_detalle (pd_id_pedido,pd_tipo,pd_id_registro) VALUES (?,?,?)";
            $intIdRegistro4 = $Update_row->insertContenido($link, $arrData2, $query); //Registro de página
        }

        //INSERTA Otos Detalles
        $arrData2[0] = '';
        $arrData2[1] = $arrData[0];
        $arrData2[2] = sanStrHtml($_POST["comision"]);
        $arrData2[3] = sanStrHtml($_POST["curso"]);
        //
        $query = "INSERT INTO pedidos_detalle2 (pd2_id_pedido,pd2_comision,pd2_curso) VALUES (?,?,?)";
        $intIdRegistro4 = $Update_row->insertContenido($link, $arrData2, $query); //Registro de página


        //SELECIONA DE LA TABLA DE PEDIDOS EQUPOS TEMPORAL TODoS LOS EQUIPOS SOLICITADOS
        $query = "SELECT *
        FROM pedidos_equipos_temp
        WHERE pe_id_pedido_temp ='" . $idtemporal."'";
        $rsCont = $Update_row->getAllContenido($link, $query);

        while ($arrCont = $rsCont->fetch(PDO::FETCH_BOTH)) {

            $arrDataPedEq[0] = '';
            $arrDataPedEq[1] = $idtemporal;
            $arrDataPedEq[2] = $arrData[0];
            $arrDataPedEq[3] = $arrCont["pe_id_equipo"];
            $arrDataPedEq[4] = 0;
            //
            $query = "INSERT INTO pedidos_equipos (pe_id_pedido_temp,pe_id_pedido,pe_id_equipo,pe_posicion) VALUES (?,?,?,?)";
            $intIdRegistroPedEq = $Update_row->insertContenido($link, $arrDataPedEq, $query); //Registro de página

        }


        $query = "DELETE FROM pedidos_equipos_temp WHERE pe_id_pedido_temp = '" . $idtemporal."'";
        $intIdRegistroDeltemp = $Update_row->getAllContenido($link, $query);
       

        break;

    case 'D':

        //Recibo variables
        $arrData[0] = sanInt($_POST["intIdRegistro"]);
        $arrData[1] = sanStrHtmlSpecial($_POST["strDb"]);

        $Update_row = new General();
        //Borra pagina
        $query = "DELETE FROM paginas WHERE pg_id = " . $arrData[0];
        $intIdRegistroDel0 = $Update_row->getAllContenido($link, $query);

        //Borra Todos los Módulos
        $query = "DELETE FROM modulos WHERE mod_pag_id = " . $arrData[0];
        $intIdRegistroDel1 = $Update_row->getAllContenido($link, $query);
        //Borra Todos los contenidos de modulos
        $query = "DELETE FROM contenido WHERE cont_pag_id = " . $arrData[0];
        $intIdRegistroDel2 = $Update_row->getAllContenido($link, $query);

        //Borra notas  relacionadas
        $strQuery = "DELETE FROM postxvinculos WHERE pxv_id_recurso = " . $arrData[0] . " AND pxv_tipo = 2";
        $rsContd = $Update_row->getAllContenido($link, $strQuery);

        //
        break;
}
//
header("Location: lstPedidos.php?seccion=pedidos&intPage=$intPage");
