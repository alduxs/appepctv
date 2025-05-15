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
        $query = "INSERT INTO categorias (cat_nombre) VALUES (?)";
        $intIdRegistro = $Insert_row->insertContenido($link, $arrData, $query);
        break;

    case 'U':
        //
        $arrData[0] = sanInt($_POST["id"]);
    
        $arrData[1] = sanStrHtml($_POST["nombre"]);
        //
        $Update_row = new General();
        $query = "UPDATE categorias SET cat_nombre = ? WHERE cat_id = ?";
        $intIdRegistro = $Update_row->updateContenido($link, $arrData, $query);
        break;


    case 'D':
        //Recibo variables
        $arrData[0] = sanInt($_POST["intIdRegistro"]);
        $arrData[1] = sanStrHtmlSpecial($_POST["strDb"]);
       
        // Borro el registro de la DB
        $objRegistro = new ComonClases();
        $rsRegistro = $objRegistro->deleteRegistro($link, $arrData);
        //
        break;
}
//
header("Location: lstCategorias.php?seccion=categorias");
