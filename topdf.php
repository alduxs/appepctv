<?php

ini_set('display_errors', 1);

ini_set('display_startup_errors', 1);

error_reporting(E_ALL);

include_once('includes/funciones.inc.php');

$fecha = date('d-m-Y');



?>
<?php
  //============================================================+
  // File name   : example_003.php
  // Begin       : 2008-03-04
  // Last Update : 2010-08-08
  //
  // Description : Example 003 for TCPDF class
  //               Custom Header and Footer
  //
  // Author: Nicola Asuni
  //
  // (c) Copyright:
  //               Nicola Asuni
  //               Tecnick.com s.r.l.
  //               Via Della Pace, 11
  //               09044 Quartucciu (CA)
  //               ITALY
  //               www.tecnick.com
  //               info@tecnick.com
  //============================================================+

  /**
   * Creates an example PDF TEST document using TCPDF
   * @package com.tecnick.tcpdf
   * @abstract TCPDF - Example: Custom Header and Footer
   * @author Nicola Asuni
   * @since 2008-03-04
   */

  require_once('includes/vendor/tcpdf/config/lang/spa.php');
  require_once('includes/vendor/tcpdf/tcpdf.php');

  

  // Extend the TCPDF class to create custom Header and Footer
  class MYPDF extends TCPDF
  {

    //Page header
    public function Header()
    {
      // Logo
      $image_file = 'img/logo.png';
      $this->Image($image_file, 10, 10, 180, '', 'PNG', '', 'T', false, 72, '', false, false, 0, false, false, false);

    }

    // Page footer
    public function Footer()
    {
      $image_file2 = 'img/logo.png';
      $this->Image($image_file2, 10, 280, 180, '', 'PNG', '', 'C', false, 72, '', false, false, 0, false, false, false);
    }
  }

  

  // create new PDF document
  $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

  // set document information
  $pdf->SetCreator(PDF_CREATOR);
  $pdf->SetAuthor('EPCTV');
  $pdf->SetTitle('Pedido de Equipos');
  $pdf->SetSubject('Pedido de Equipos');
  $pdf->SetKeywords('Equipos, PEdidos');

  // set default header data
  $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

  // set header and footer fonts
  $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
  $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

  // set default monospaced font
  $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

  //set margins
  $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
  $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
  $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

  //set auto page breaks
  $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

  //set image scale factor
  $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

  //set some language-dependent strings
  $pdf->setLanguageArray($l);

  

  // ---------------------------------------------------------

  // set font
  $pdf->SetFont('Helvetica', '', 10);

  // add a page
  $pdf->AddPage();

 

  // define some HTML content with style
  $html = <<<EOF
<!-- EXAMPLE OF CSS STYLE -->

<h1>Simulador Prestamo </h1>
<h3>Datos de la Simulación efectuada el: </h1>
<table width="400" border="1" cellpadding="20" cellspacing="0">
  <tr>
    <td align="left">Importe a financiar:</td>
    <td align="left"></td>
  </tr>
  <tr>
    <td align="left">Nº de Cuotas:</td>
    <td align="left"></td>
  </tr>
  <tr>
    <td align="left">Tasa:</td>
    <td align="left">%</td>
  </tr>
</table>
<p>&nbsp;</p>

<table width="400" border="1" cellpadding="20" cellspacing="0">
  <tr>
    <td align="left">Ingreso mensual requerido:</td>
    <td align="left"></td>
  </tr>
  <tr>
    <td align="left">Cuota Inicial:</td>
    <td align="left"></td>
  </tr>
  <tr>
    <td align="left">Cuota Promedio: </td>
    <td align="left"></td>
  </tr>
  <tr>
    <td align="left">Cuota final:</td>
    <td align="left"></td>
  </tr>
   <tr>
    <td align="left">Gastos Administrativos: </td>
    <td align="left"></td>
  </tr>
</table>

EOF;

  // output the HTML content
  $pdf->writeHTML($html, true, false, true, false, '');

  // ---------------------------------------------------------

  //Close and output PDF document
  $pdf->Output('pedido.pdf', 'I');

  //============================================================+
  // END OF FILE
  //============================================================+

