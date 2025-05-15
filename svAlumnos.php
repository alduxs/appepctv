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
        $arrData[2] = sanStrHtml($_POST["apellido"]);
        $arrData[3] = sanStrHtml($_POST["dni"]);
        $arrData[4] = sanStrHtml($_POST["celular"]);
        $arrData[5] = sanStrHtml($_POST["email"]);
        $arrData[6] = sanStrHtml($_POST["estado"]);
        //

        $Insert_row = new General();
        $query = "INSERT INTO data_estudiantes (estudiantes_name,estudiantes_apellido,estudiantes_dni,estudiantes_celular,estudiantes_email,estudiantes_estado) VALUES (?,?,?,?,?,?)";
        $intIdRegistro = $Insert_row->insertContenido($link, $arrData, $query);
        
        break;

    case 'U':
        //
        $arrData[0] = sanInt($_POST["id"]);
    
        $arrData[1] = sanStrHtml($_POST["nombre"]);
        $arrData[2] = sanStrHtml($_POST["apellido"]);
        $arrData[3] = sanStrHtml($_POST["dni"]);
        $arrData[4] = sanStrHtml($_POST["celular"]);
        $arrData[5] = sanStrHtml($_POST["email"]);
        $arrData[6] = sanStrHtml($_POST["estado"]);
        //
        $Update_row = new General();
        $query = "UPDATE data_estudiantes SET estudiantes_name = ?,estudiantes_apellido = ?,estudiantes_dni = ?,estudiantes_celular = ?,estudiantes_email = ?,estudiantes_estado = ? WHERE estudiantes_id = ?";
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
        
        //
        break;
}
//
header("Location: lstAlumnos.php?seccion=alumnos");
