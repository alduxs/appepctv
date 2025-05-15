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
    case 'I':
        //
        $Uploads = new iUpload();
        $Insert_row = new General();

        $fecha = date('Ymd h:i:s');
        $update = $fecha;

        //Carga la página
        $arrData[0] = '';

        $arrData[1] = sanStrHtml($_POST["nombre"]);
        $arrData[2] = sanInt($_POST["publicado"]);
        

        //
        $query = "INSERT INTO combos (cb_nombre,cb_estado) VALUES (?,?)";
        $intIdRegistro = $Insert_row->insertContenido($link, $arrData, $query); //Registro de página

        if ($_POST["cantidadModulos"] > 0) {

            $ordenModulos = explode(",", $_POST["ordenModulos"]);

            //Inicio Bucle
            for ($i = 0; $i < count($ordenModulos); $i++) {

                $vM = $ordenModulos[$i];

                if ($vM != -1) {


                    $arrData2[0] = '';

                    $arrData2[1] = $intIdRegistro;
                    $arrData2[2] = $vM;

                    $query = "INSERT INTO combos_equipos (ce_id_combo,ce_id_tipo_equipo) VALUES (?,?)";
                    $intIdRegistro2 = $Insert_row->insertContenido($link, $arrData2, $query); //Registro de MODULO

                   
                }
            }
            //Fin bucle
        }

        break;

    case 'U':
        // BUSCO LOS DATOS DEL CONTENIDO A MODIFICAR
        // PARA VERIFICAR SI SE CAMBIARON LAS IMAGENES

        //
        $arrData[0] = sanInt($_POST["id"]);

        
        $arrData[1] = sanStrHtml($_POST["nombre"]);
        $arrData[2] = sanInt($_POST["publicado"]);
        //
        $Update_row = new General();
        $query = "UPDATE combos SET  cb_nombre = ?,cb_estado = ? WHERE cb_id = ?";
        $intIdRegistro = $Update_row->updateContenido($link, $arrData, $query);

        //Borra Todos los Módulos
        $query = "DELETE FROM combos_equipos WHERE ce_id_combo = " . $arrData[0];
        $intIdRegistroDel1 = $Update_row->getAllContenido($link, $query);
        

        if ($_POST["cantidadModulos"] > 0) {

            $ordenModulos = explode(",", $_POST["ordenModulos"]);

            //Inicio Bucle
            for ($i = 0; $i < count($ordenModulos); $i++) {

                $vM = $ordenModulos[$i];

                if ($vM != -1) {

                    $arrData2[0] = '';

                    $arrData2[1] = $arrData[0];
                    $arrData2[2] = $vM;

                    $query = "INSERT INTO combos_equipos (ce_id_combo,ce_id_tipo_equipo) VALUES (?,?)";
                    $intIdRegistro2 = $Update_row->insertContenido($link, $arrData2, $query); //Registro de MODULO

                   
                }
            }
            //Fin bucle
        }


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
header("Location: lstCombos.php?seccion=combos&intPage=$intPage");
