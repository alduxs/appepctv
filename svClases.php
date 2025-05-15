<?PHP
include_once("includes/checkLogin.inc.php");
include_once('includes/conexion.inc.php');
include_once('includes/funciones.inc.php');
$link = Conectarse();
include_once('includes/class.inc.php');
//
include("includes/class.upload.php");
//
$strOperacion = sanStrHtmlSpecial($_POST["strOperacion"]);
//
switch ($strOperacion) {
    case 'I':
        //
      
        $arrData[0] = '';
        $arrData[1] = sanStrHtml($_POST["nombre"]);
        //

        $Insert_row = new General();
        $query = "INSERT INTO equipo_clases (ecl_nombre) VALUES (?)";
        $intIdRegistro = $Insert_row->insertContenido($link, $arrData, $query);
        //LLENA TABLA DE RELACION
        if($_POST["clase"]==0){
            $arrData2[0] = '';
            $arrData2[1] = 0;
            $arrData2[2] = $intIdRegistro;
            $arrData2[3] = $intIdRegistro;
        } else {
            $arrData2[0] = '';
            $arrData2[1] = $_POST["clase"];
            $arrData2[2] = $intIdRegistro;
            $arrData2[3] = $_POST["clase"];
        }
        $query = "INSERT INTO equipos_clases_relacion (eqr_id_padre,eqr_id_clase,eqr_id_grupo) VALUES (?,?,?)";
        $intIdRegistro2 = $Insert_row->insertContenido($link, $arrData2, $query);
        break;

    case 'U':
        //
        $arrData[0] = sanInt($_POST["id"]);
    
        $arrData[1] = sanStrHtml($_POST["nombre"]);
        //
        $Update_row = new General();
        $query = "UPDATE equipo_clases SET ecl_nombre = ? WHERE ecl_id = ?";
        $intIdRegistro = $Update_row->updateContenido($link, $arrData, $query);

         //LLENA TABLA DE RELACION
         if($_POST["clase"]==0){
            $arrData2[0] = sanInt($_POST["id"]);
            $arrData2[1] = 0;
            $arrData2[2] = sanInt($_POST["id"]);
            $arrData2[3] = sanInt($_POST["id"]);
        } else {
            $arrData2[0] = sanInt($_POST["id"]);
            $arrData2[1] = $_POST["clase"];
            $arrData2[2] = sanInt($_POST["id"]);
            $arrData2[3] = $_POST["clase"];
        }
        $query = "UPDATE equipos_clases_relacion SET eqr_id_padre = ?,eqr_id_clase = ?,eqr_id_grupo = ? WHERE eqr_id_clase = ?";
        $intIdRegistro2 = $Update_row->updateContenido($link, $arrData2, $query);
        break;


    case 'D':
        //Recibo variables
        $arrData[0] = sanInt($_POST["intIdRegistro"]);
        $arrData[1] = sanStrHtmlSpecial($_POST["strDb"]);
       
        // Borro el registro de la DB
        $objRegistro = new ComonClases();
        $rsRegistro = $objRegistro->deleteRegistro($link, $arrData);
        //
        //Borra el registro de la Tabla Temporal
        $Update_row = new General();
        $query = "DELETE FROM equipos_clases_relacion WHERE eqr_id_clase = " . $arrData[0];
        $rsCont = $Update_row->getAllContenido($link, $query);
        //
        break;
}
//
header("Location: lstClases.php?seccion=clases");
