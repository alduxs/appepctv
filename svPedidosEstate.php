<?PHP
include_once("includes/checkLogin.inc.php");
include_once('includes/conexion.inc.php');
include_once('includes/funciones.inc.php');
include_once('includes/class.inc.php');
error_reporting(E_ALL);
ini_set('display_errors', '1');
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
include("includes/class.upload.php");
//
date_default_timezone_set('America/Los_Angeles');
//
switch ($strOperacion) {
   

    case 'U':
        // BUSCO LOS DATOS DEL CONTENIDO A MODIFICAR
        // PARA VERIFICAR SI SE CAMBIARON LAS IMAGENES

        //var_dump($_POST);exit();

        //
        $arrData[0] = sanInt($_POST["id"]);
        $arrData[1] = sanInt($_POST["estado"]);;
        //
        $Update_row = new General();
        $query = "UPDATE pedidos SET pedidos_estado = ? WHERE pedidos_id = ?";
        $intIdRegistro = $Update_row->updateContenido($link, $arrData, $query);


        //UPDATE DE EQUIPOS
        /*$query = "UPDATE pedidos_equipos SET pe_estado = ".$_POST["estado"]." WHERE pe_id_pedido = ".$arrData[0] ;
        $intIdRegistro2 = $Update_row->getAllContenido($link, $query);*/
       

        break;
    
}
//
header("Location: lstPedidos.php?seccion=pedidos&intPage=$intPage");
