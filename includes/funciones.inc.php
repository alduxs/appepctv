<?php
//
// ME DICE QUE DIA ES
//
function prtDay($dia) {
  switch($dia) {
    case '0':$dia="Domingo";break;
    case '1':$dia="Lunes";break;
    case '2':$dia="Martes";break;
    case '3':$dia="Mi&eacute;rcoles";break;
    case '4':$dia="Jueves";break;
    case '5':$dia="Viernes";break;
    case '6':$dia="S&aacute;bado";break;
  }
  return $dia;
}
function prtMonth($mes) {
  switch($mes) {
    case '01':$mes="ENE";break;
    case '02':$mes="FEB";break;
    case '03':$mes="MAR";break;
    case '04':$mes="ABR";break;
    case '05':$mes="MAY";break;
    case '06':$mes="JUN";break;
    case '07':$mes="JUL";break;
    case '08':$mes="AGO";break;
    case '09':$mes="SEP";break;
    case '10':$mes="OCT";break;
    case '11':$mes="NOV";break;
    case '12':$mes="DIC";break;
  }
  return $mes;
}

function prtMonthCom($mes) {
  switch($mes) {
    case '01':$mes="Enero";break;
    case '02':$mes="Febrero";break;
    case '03':$mes="Marzo";break;
    case '04':$mes="Abril";break;
    case '05':$mes="Mayo";break;
    case '06':$mes="Junio";break;
    case '07':$mes="Julio";break;
    case '08':$mes="Agosto";break;
    case '09':$mes="Septiembre";break;
    case '10':$mes="Octubre";break;
    case '11':$mes="Noviembre";break;
    case '12':$mes="Diciembre";break;
  }
  return $mes;
}

function monthReplace($pstrfecha) {
  $strFecha = str_replace("January", "Enero", $pstrfecha);
  $strFecha = str_replace("February", "Febrero", $strFecha);
  $strFecha = str_replace("March", "Marzo", $strFecha);
  $strFecha = str_replace("April", "Abril", $strFecha);
  $strFecha = str_replace("May", "Mayo", $strFecha);
  $strFecha = str_replace("June", "Junio", $strFecha);
  $strFecha = str_replace("July", "Julio", $strFecha);
  $strFecha = str_replace("August", "Agosto", $strFecha);
  $strFecha = str_replace("September", "Septiembre", $strFecha);
  $strFecha = str_replace("October", "Octubre", $strFecha);
  $strFecha = str_replace("November", "Noviembre", $strFecha);
  $strFecha = str_replace("December", "Diciembre", $strFecha);

  return $strFecha;
}

function revertFecha($strFecha) {
  $dia = substr($strFecha, 6,2);    // devuelve "f"
  $mes = substr($strFecha, 4,2);    // devuelve "ef"
  $anio = substr($strFecha, 0, 4); // devuelve "d"

  $strFecha = $dia."/".$mes."/".$anio;
  return $strFecha;
}

function revertHora($strFecha) {
  $hora = substr($strFecha, 8,2);    // devuelve "f"
  $minutos = substr($strFecha, 10,2);    // devuelve "ef"

  $hora = $hora.":".$minutos;
  return $hora;
}

function invertFecha($strFecha) {
  $dia = substr($strFecha, 0,2);    // devuelve "f"
  $mes = substr($strFecha, 3,2);    // devuelve "ef"
  $anio = substr($strFecha, 6, 4); // devuelve "d"

  $strFecha = $anio.$mes.$dia;
  return $strFecha;
}
function hora($strhora){
  $pieces = explode(":",$strhora);
  $hora = $pieces[0].$pieces[1];
  return $hora;
}
//
// CATEGORIAS
function categorias($categoria) {
  $valores = array();
  switch($categoria) {
    case '1':$name_cat="In company";$has_cat="podcast";$imagen="auriculares.png";break;
    case '2':$name_cat="Agenda Anual";$has_cat="textos";$imagen="textos.png";break;
  }
  $valores[0] = $name_cat;
  $valores[1] = $has_cat;
  $valores[2] = $imagen;
  return $valores;
}

function categoriaUser($categoria) {
  switch($categoria) {
    case '1':$name_cat="Departamento Técnico";break;
    case '2':$name_cat="Docente";break;
    case '3':$name_cat="Estudiante";break;
  }

  return $name_cat;
}
function categoriGear($categoria) {
  switch($categoria) {
    case '2':$name_cat="1";break;
    case '3':$name_cat="2";break;
    case '4':$name_cat="3";break;
    case '6':$name_cat="T";break;
  }

  return $name_cat;
}

function estado($categoria) {
  switch($categoria) {
    case '1':$name="<span class=\"label label-primary\">Disponible</span>";break;
    case '2':$name="<span class=\"label label-info\">Solicitado</span>";break;
    case '3':$name="<span class=\"label label-warning\">Reservado</span>";break;
    case '4':$name="<span class=\"label label-danger\">En uso</span>";break;
    
  }
  return $name;
}

function estadoPedido($categoria) {
  switch($categoria) {
    case '1':$name="<span class=\"label label-warning\">Reservado</span>";break;
    case '2':$name="<span class=\"label label-primary\">Entregado</span>";break;
    case '3':$name="<span class=\"label label-info\">Devuelto</span>";break;
    case '4':$name="<span class=\"label label-danger\">Cancelado</span>";break;
    
  }
  return $name;
}
//
// GENERA LA PAGINACION
//
function printPaginado($pstrPagina, $intQtyPages, $intPage, $strListado,$param="0") {
  $strHTML="";
  if ($intQtyPages > 1) {
    $strHTML = "<ul class=\"unstyled\">";
    for ($i=1;$i<=$intQtyPages;$i++) {
      if ($intPage == $i)
      //si muestro el indice de la pagina actual, no coloco enlace
      $strHTML.= "<li><a  class=\"btn btn-info btn-xs btn-bitbucket\">" . $i . "</a></li>";
      else
      //si el indice no corresponde con la pagina mostrada actualmente, coloco el enlace para ir a esa pagina
      $strHTML.= "<li><a href=\"".$pstrPagina."?intPage=" . $i . "&seccion=".$strListado."&ev=".$param."\" class=\"btn btn-white btn-xs btn-bitbucket\">" . $i . "</a></li>";
    }
    $strHTML.= "</ul>";
  }
  return $strHTML;
}

function printPaginadoHome($pstrPagina, $intQtyPages, $intPage) {
  $strHTML="";
  if ($intQtyPages > 1) {
    $strHTML = "<nav>";
    $strHTML .= "<ul class=\"pagination justify-content-center\">";
    for ($i=1;$i<=$intQtyPages;$i++) {
      if ($intPage == $i)
      //si muestro el indice de la pagina actual, no coloco enlace
      $strHTML.= "<li class=\"page-item active\"><a  class=\"page-link\">" . $i . "</a></li>";
      else
      //si el indice no corresponde con la pagina mostrada actualmente, coloco el enlace para ir a esa pagina
      $strHTML.= "<li class=\"page-item\"><a href=\"".$pstrPagina."?p=" . $i ."\" class=\"page-link\">" . $i . "</a></li>";
    }
    $strHTML.= "</ul>";
  }
  return $strHTML;
}

function printPaginadoHome2($pstrPagina, $intQtyPages, $intPage) {
  $strHTML="";
  $strHTML = "<nav>";
  if ($intQtyPages > 1) {
    $strHTML = "<ul class=\"pagination justify-content-center\">";

    
    if ($intQtyPages<=5) {
      for ($i=1;$i<=$intQtyPages;$i++) {
        if ($intPage == $i)
        //si muestro el indice de la pagina actual, no coloco enlace
        $strHTML.= "<li class=\"page-item active\"><a  class=\"page-link\">" . $i . "</a></li>";
        else
        //si el indice no corresponde con la pagina mostrada actualmente, coloco el enlace para ir a esa pagina
        $strHTML.= "<li class=\"page-item\"><a href=\"".$pstrPagina."?p=" . $i ."\" class=\"page-link\">" . $i . "</a></li>";
      }
    }
    if ($intQtyPages>5) {
      if ($intPage <=3){
        for ($i=1;$i<=5;$i++) {
          if ($intPage == $i)
          //si muestro el indice de la pagina actual, no coloco enlace
          $strHTML.= "<li class=\"page-item active\"><a  class=\"page-link\">" . $i . "</a></li>";
          else
          //si el indice no corresponde con la pagina mostrada actualmente, coloco el enlace para ir a esa pagina
          $strHTML.= "<li class=\"page-item\"><a href=\"".$pstrPagina."?p=" . $i ."\" class=\"page-link\">" . $i . "</a></li>";
        }
        $strHTML.= "<li>
          <span class=\"puntos\">...</span>
        </li>";
        $strHTML.= "<li class=\"page-item\"><a href=\"".$pstrPagina."?p=" . $intQtyPages . "\" class=\"page-link\">" . $intQtyPages . "</a></li>";
      }

      if ($intPage > 3 && $intPage <= ($intQtyPages-3)){
        $strHTML.= "<li class=\"page-item\"><a href=\"".$pstrPagina."?p=1\" class=\"page-link\">1</a></li>";
        $strHTML.= "<li>
          <span class=\"puntos\">...</span>
        </li>";
        for ($i=($intPage-2);$i<=($intPage+2);$i++) {
          if ($intPage == $i)
          //si muestro el indice de la pagina actual, no coloco enlace
          $strHTML.= "<li class=\"page-item active\"><a  class=\"page-link\">" . $i . "</a></li>";
          else
          //si el indice no corresponde con la pagina mostrada actualmente, coloco el enlace para ir a esa pagina
          $strHTML.= "<li class=\"page-item\"><a href=\"".$pstrPagina."?p=" . $i . "\" class=\"page-link\">" . $i . "</a></li>";
        }
        $strHTML.= "<li>
          <span class=\"puntos\">...</span>
        </li>";
        $strHTML.= "<li class=\"page-item\"><a href=\"".$pstrPagina."?p=" . $intQtyPages . "\" class=\"page-link\">" . $intQtyPages . "</a></li>";
      }

      if ($intPage > ($intQtyPages-3)){
        $strHTML.= "<li class=\"page-item\"><a href=\"".$pstrPagina."?p=1\" class=\"page-link\">1</a></li>";
        $strHTML.= "<li>
          <span class=\"puntos\">...</span>
        </li>";

        for ($i=($intQtyPages-4);$i<=$intQtyPages;$i++) {
          if ($intPage == $i)
          //si muestro el indice de la pagina actual, no coloco enlace
          $strHTML.= "<li class=\"page-item active\"><a  class=\"page-link\">" . $i . "</a></li>";
          else
          //si el indice no corresponde con la pagina mostrada actualmente, coloco el enlace para ir a esa pagina
          $strHTML.= "<li class=\"page-item\"><a href=\"".$pstrPagina."?p=" . $i . "\" class=\"page-link\">" . $i . "</a></li>";
        }
      }

    }
    
   

    $strHTML.= "</ul>";
    $strHTML.= "</nav>";
  }

  return $strHTML;
}



function printPaginadofe($pstrPagina, $intQtyPages, $intPage, $strListado='') {
  $strHTML="";
  if ($intQtyPages > 1) {

    $strHTML = "<ul class=\"list-inline\">";
    if($intPage==1){
      $strHTML .= "<li class=\"list-inline-item\">
        <a class=\"u-pagination-v1__item u-pagination-v1-1 u-pagination-v1__item--disabled g-pa-12-21\" href=\"".$pstrPagina."?page=" .($intPage-1)."\" aria-label=\"Previa\">
          <span aria-hidden=\"true\">
            <i class=\"fa fa-angle-left\"></i>
          </span>
          <span class=\"sr-only\">Previa</span>
        </a>
      </li>";
    } else {
      $strHTML .= "<li class=\"list-inline-item\">
        <a class=\"u-pagination-v1__item u-pagination-v1-1 g-pa-12-21\" href=\"".$pstrPagina."?page=" .($intPage-1)."\" aria-label=\"Previa\">
          <span aria-hidden=\"true\">
            <i class=\"fa fa-angle-left\"></i>
          </span>
          <span class=\"sr-only\">Previa</span>
        </a>
      </li>";
    }

    for ($i=1;$i<=$intQtyPages;$i++) {
      if ($intPage == $i)
      //si muestro el indice de la pagina actual, no coloco enlace
      $strHTML.= "<li class=\"list-inline-item g-hidden-sm-down\"><a  class=\"u-pagination-v1__item u-pagination-v1-1 u-pagination-v1-1--active g-pa-12-19\">" . $i . "</a></li>";
      else
      //si el indice no corresponde con la pagina mostrada actualmente, coloco el enlace para ir a esa pagina
      $strHTML.= "<li class=\"list-inline-item g-hidden-sm-down\"><a href=\"".$pstrPagina."?page=" . $i . "\" class=\"u-pagination-v1__item u-pagination-v1-1 g-pa-12-19\">" . $i . "</a></li>";
    }
    if($intPage==$intQtyPages){
      $strHTML.= "<li class=\"list-inline-item\">
        <a class=\"u-pagination-v1__item u-pagination-v1-1 u-pagination-v1__item--disabled g-pa-12-21\" href=\"".$pstrPagina."?page=" .($intPage+1)."\" aria-label=\"Próxima\">
          <span aria-hidden=\"true\">
            <i class=\"fa fa-angle-right\"></i>
          </span>
          <span class=\"sr-only\">Próxima</span>
        </a>
      </li>";
    } else {
      $strHTML.= "<li class=\"list-inline-item\">
        <a class=\"u-pagination-v1__item u-pagination-v1-1 g-pa-12-21\" href=\"".$pstrPagina."?page=" .($intPage+1)."\" aria-label=\"Próxima\">
          <span aria-hidden=\"true\">
            <i class=\"fa fa-angle-right\"></i>
          </span>
          <span class=\"sr-only\">Próxima</span>
        </a>
      </li>";
    }

    $strHTML.= "<li class=\"list-inline-item float-right\">
      <span class=\"u-pagination-v1__item-info g-pa-12-19\">Página ".$intPage." de ".$intQtyPages."</span>
    </li>";

    $strHTML.= "</ul>";
  }
  return $strHTML;
}

function printPaginado4($pstrPagina, $intQtyPages, $intPage) {
  $strHTML="";
  if ($intQtyPages > 1) {
    $strHTML = "<ul class=\"list-inline\">";

    if($intPage==1){
      $strHTML .= "<li class=\"list-inline-item\">
        <a class=\"u-pagination-v1__item u-pagination-v1-1 u-pagination-v1__item--disabled g-pa-12-21\" href=\"".$pstrPagina."?page=" .($intPage-1)."\" aria-label=\"Previa\">
          <span aria-hidden=\"true\">
            <i class=\"fa fa-angle-left\"></i>
          </span>
          <span class=\"sr-only\">Previa</span>
        </a>
      </li>";
    } else {
      $strHTML .= "<li class=\"list-inline-item\">
        <a class=\"u-pagination-v1__item u-pagination-v1-1 g-pa-12-21\" href=\"".$pstrPagina."?page=" .($intPage-1)."\" aria-label=\"Previa\">
          <span aria-hidden=\"true\">
            <i class=\"fa fa-angle-left\"></i>
          </span>
          <span class=\"sr-only\">Previa</span>
        </a>
      </li>";
    }

    if ($intQtyPages<=3) {
      for ($i=1;$i<=$intQtyPages;$i++) {
        if ($intPage == $i)
        //si muestro el indice de la pagina actual, no coloco enlace
        $strHTML.= "<li class=\"list-inline-item g-hidden-sm-down\"><a  class=\"u-pagination-v1__item u-pagination-v1-1 u-pagination-v1-1--active g-pa-12-19\">" . $i . "</a></li>";
        else
        //si el indice no corresponde con la pagina mostrada actualmente, coloco el enlace para ir a esa pagina
        $strHTML.= "<li class=\"list-inline-item g-hidden-sm-down\"><a href=\"".$pstrPagina."?page=" . $i . "\" class=\"u-pagination-v1__item u-pagination-v1-1 g-pa-12-19\">" . $i . "</a></li>";
      }
    }
    if ($intQtyPages>3) {
      if ($intPage <=2){
        for ($i=1;$i<=3;$i++) {
          if ($intPage == $i)
          //si muestro el indice de la pagina actual, no coloco enlace
          $strHTML.= "<li class=\"list-inline-item g-hidden-sm-down\"><a  class=\"u-pagination-v1__item u-pagination-v1-1 u-pagination-v1-1--active g-pa-12-19\">" . $i . "</a></li>";
          else
          //si el indice no corresponde con la pagina mostrada actualmente, coloco el enlace para ir a esa pagina
          $strHTML.= "<li class=\"list-inline-item g-hidden-sm-down\"><a href=\"".$pstrPagina."?page=" . $i . "\" class=\"u-pagination-v1__item u-pagination-v1-1 g-pa-12-19\">" . $i . "</a></li>";
        }
        $strHTML.= "<li class=\"list-inline-item g-hidden-sm-down\">
          <span class=\"g-pa-12-19\">...</span>
        </li>";
        $strHTML.= "<li class=\"list-inline-item g-hidden-sm-down\"><a href=\"".$pstrPagina."?page=" . $intQtyPages . "\" class=\"u-pagination-v1__item u-pagination-v1-1 g-pa-12-19\">" . $intQtyPages . "</a></li>";
      }

      if ($intPage > 2 && $intPage <= ($intQtyPages-2)){
        $strHTML.= "<li class=\"list-inline-item g-hidden-sm-down\"><a href=\"".$pstrPagina."?page=1\" class=\"u-pagination-v1__item u-pagination-v1-1 g-pa-12-19\">1</a></li>";
        $strHTML.= "<li class=\"list-inline-item g-hidden-sm-down\">
          <span class=\"g-pa-12-19\">...</span>
        </li>";
        for ($i=($intPage-1);$i<=($intPage+1);$i++) {
          if ($intPage == $i)
          //si muestro el indice de la pagina actual, no coloco enlace
          $strHTML.= "<li class=\"list-inline-item g-hidden-sm-down\"><a  class=\"u-pagination-v1__item u-pagination-v1-1 u-pagination-v1-1--active g-pa-12-19\">" . $i . "</a></li>";
          else
          //si el indice no corresponde con la pagina mostrada actualmente, coloco el enlace para ir a esa pagina
          $strHTML.= "<li class=\"list-inline-item g-hidden-sm-down\"><a href=\"".$pstrPagina."?page=" . $i . "\" class=\"u-pagination-v1__item u-pagination-v1-1 g-pa-12-19\">" . $i . "</a></li>";
        }
        $strHTML.= "<li class=\"list-inline-item g-hidden-sm-down\">
          <span class=\"g-pa-12-19\">...</span>
        </li>";
        $strHTML.= "<li class=\"list-inline-item g-hidden-sm-down\"><a href=\"".$pstrPagina."?page=" . $intQtyPages . "\" class=\"u-pagination-v1__item u-pagination-v1-1 g-pa-12-19\">" . $intQtyPages . "</a></li>";
      }

      if ($intPage > ($intQtyPages-2)){
        $strHTML.= "<li class=\"list-inline-item g-hidden-sm-down\"><a href=\"".$pstrPagina."?page=1\" class=\"u-pagination-v1__item u-pagination-v1-1 g-pa-12-19\">1</a></li>";
        $strHTML.= "<li class=\"list-inline-item g-hidden-sm-down\">
          <span class=\"g-pa-12-19\">...</span>
        </li>";

        for ($i=($intQtyPages-2);$i<=$intQtyPages;$i++) {
          if ($intPage == $i)
          //si muestro el indice de la pagina actual, no coloco enlace
          $strHTML.= "<li class=\"list-inline-item g-hidden-sm-down\"><a  class=\"u-pagination-v1__item u-pagination-v1-1 u-pagination-v1-1--active g-pa-12-19\">" . $i . "</a></li>";
          else
          //si el indice no corresponde con la pagina mostrada actualmente, coloco el enlace para ir a esa pagina
          $strHTML.= "<li class=\"list-inline-item g-hidden-sm-down\"><a href=\"".$pstrPagina."?page=" . $i . "\" class=\"u-pagination-v1__item u-pagination-v1-1 g-pa-12-19\">" . $i . "</a></li>";
        }
      }

    }
    if($intPage==$intQtyPages){
      $strHTML.= "<li class=\"list-inline-item\">
        <a class=\"u-pagination-v1__item u-pagination-v1-1 u-pagination-v1__item--disabled g-pa-12-21\" href=\"".$pstrPagina."?page=" .($intPage+1)."\" aria-label=\"Próxima\">
          <span aria-hidden=\"true\">
            <i class=\"fa fa-angle-right\"></i>
          </span>
          <span class=\"sr-only\">Próxima</span>
        </a>
      </li>";
    } else {
      $strHTML.= "<li class=\"list-inline-item\">
        <a class=\"u-pagination-v1__item u-pagination-v1-1 g-pa-12-21\" href=\"".$pstrPagina."?page=" .($intPage+1)."\" aria-label=\"Próxima\">
          <span aria-hidden=\"true\">
            <i class=\"fa fa-angle-right\"></i>
          </span>
          <span class=\"sr-only\">Próxima</span>
        </a>
      </li>";
    }
    $strHTML.= "<li class=\"list-inline-item float-right\">
      <span class=\"u-pagination-v1__item-info g-pa-12-19\">Página ".$intPage." de ".$intQtyPages."</span>
    </li>";

    $strHTML.= "</ul>";
  }

  return $strHTML;
}



// FUNCION DE ENVIO DE MAIL
//
function sendMail($strFrom, $strTo, $strSubject, $strHTML) {
  mail($strTo, $strSubject, $strHTML, "From: {$strFrom}\r\nMIME-Version: 1.0\r\nContent-Type: text/html; charset=utf-8 ");
}
//
//	REEMPLAZA CARACTERES EXTRAÑOS EN LAS URL
//
function buildLink($pstrTitulo) {
  $strURL = str_replace(" ", "-", stripslashes($pstrTitulo));
  $strURL = str_replace("?", "", $strURL);
  $strURL = str_replace("¿", "", $strURL);
  $strURL = str_replace("\"", "", $strURL);
  $strURL = str_replace("/", "-", $strURL);
  $strURL = str_replace("|", "", $strURL);
  $strURL = str_replace(",", "", $strURL);
  $strURL = str_replace("!", "", $strURL);
  $strURL = str_replace("'", "", $strURL);
  $strURL = str_replace("=", "", $strURL);
  $strURL = str_replace(".", "", $strURL);
  $strURL = str_replace(":", "", $strURL);
  $strURL = str_replace("\"", "", $strURL);
  $strURL = str_replace("(", "-", $strURL);
  $strURL = str_replace(")", "-", $strURL);
  $strURL = str_replace("#", "-", $strURL);
  $strURL = str_replace("á", "a", $strURL);
  $strURL = str_replace("é", "e", $strURL);
  $strURL = str_replace("í", "i", $strURL);
  $strURL = str_replace("ó", "o", $strURL);
  $strURL = str_replace("ú", "u", $strURL);
  $strURL = str_replace("ü", "u", $strURL);
  $strURL = str_replace("ñ", "n", $strURL);
  $strURL = str_replace("Á", "A", $strURL);
  $strURL = str_replace("É", "E", $strURL);
  $strURL = str_replace("Í", "I", $strURL);
  $strURL = str_replace("Ó", "O", $strURL);
  $strURL = str_replace("Ú", "U", $strURL);
  $strURL = str_replace("Ü", "U", $strURL);
  $strURL = str_replace("Ñ", "N", $strURL);
  $strURL = str_replace("&quot;", "", $strURL);
  $strURL = str_replace("&aacute;", "a", $strURL);
  $strURL = str_replace("&eacute;", "e", $strURL);
  $strURL = str_replace("&iacute;", "i", $strURL);
  $strURL = str_replace("&oacute;", "o", $strURL);
  $strURL = str_replace("&uacute;", "u", $strURL);
  $strURL = str_replace("&Aacute;", "A", $strURL);
  $strURL = str_replace("&Eacute;", "E", $strURL);
  $strURL = str_replace("&Iacute;", "I", $strURL);
  $strURL = str_replace("&Oacute;", "O", $strURL);
  $strURL = str_replace("&Uacute;", "U", $strURL);
  $strURL = str_replace("&ntilde;", "n", $strURL);
  $strURL = str_replace("&Ntilde;", "N", $strURL);
  $strURL = str_replace("&ldquo;", "", $strURL);
  $strURL = str_replace("&rdquo;", "", $strURL);
  $strURL = str_replace("&quot;", "", $strURL);
  $strURL = str_replace("&iquest;", "", $strURL);
  $strURL = strtolower ($strURL);
  return $strURL;
}
//
//
/*function selfURL(){
  $s        = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
  $protocol = strleft(strtolower($_SERVER["SERVER_PROTOCOL"]), "/").$s;
  $port     = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);
  return $protocol."://".$_SERVER['SERVER_NAME'].$port.$_SERVER['REQUEST_URI'];
}*/
function strleft($s1, $s2){
  return substr($s1, 0, strpos($s1, $s2));
}
//
// SINITIZA CADENAS
function sanStrHtmlSpecial($pstrVariable){ // Para cadenas simples sin HTML
  $pstrVariable = filter_var($pstrVariable, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
  $pstrVariable = htmlentities($pstrVariable, ENT_QUOTES, "UTF-8");
  return $pstrVariable;
}
function sanStrHtml($pstrVariable){ // Para cadenas simples sin HTML
  $pstrVariable = htmlentities($pstrVariable, ENT_QUOTES, "UTF-8");
  return $pstrVariable;
}
// SINITIZA ENTEROS
function sanInt($pintVariable){ // Para cadenas simples sin HTML
  $pintVariable = filter_var($pintVariable, FILTER_VALIDATE_INT);
  return $pintVariable;
}
function sanFloat($pintVariable){ // Para cadenas simples sin HTML
  $pintVariable = filter_var($pintVariable, FILTER_VALIDATE_FLOAT);
  return $pintVariable;
}
//
//	DEVUELVE LA URL EXACTA
//
function requested_page() {
  $strProtocol = ((int) $_SERVER['SERVER_PORT'] === 443)? 'https://' : 'http://';
  $strCurrentPage = $strProtocol . $_SERVER['HTTP_HOST'] . ((!empty($_SERVER['REQUEST_URI']))? $_SERVER['REQUEST_URI'] : '');

  return $strCurrentPage;
}
function get_ip(){
  // Intentamos primero saber si se ha utilizado un proxy para acceder a la página,
  // y si éste ha indicado en alguna cabecera la IP real del usuario.
  if (getenv('HTTP_CLIENT_IP')) {
    $ip = getenv('HTTP_CLIENT_IP');
  } elseif (getenv('HTTP_X_FORWARDED_FOR')) {
    $ip = getenv('HTTP_X_FORWARDED_FOR');
  } elseif (getenv('HTTP_X_FORWARDED')) {
    $ip = getenv('HTTP_X_FORWARDED');
  } elseif (getenv('HTTP_FORWARDED_FOR')) {
    $ip = getenv('HTTP_FORWARDED_FOR');
  } elseif (getenv('HTTP_FORWARDED')) {    
    $ip = getenv('HTTP_FORWARDED');
  } else {
    // Método por defecto de obtener la IP del usuario
    // Si se utiliza un proxy, esto nos daría la IP del proxy
    // y no la IP real del usuario.
    $ip = $_SERVER['REMOTE_ADDR'];
  }

  return $ip;
}
//
//LImpia caracteres
function limpiacaracteres($pstrTitulo) {
  $strURL = str_replace(" ", "-", stripslashes($pstrTitulo));
  $strURL = str_replace("?", "", $strURL);
  $strURL = str_replace("¿", "", $strURL);
  $strURL = str_replace("\"", "", $strURL);
  $strURL = str_replace("/", "-", $strURL);
  $strURL = str_replace("|", "", $strURL);
  $strURL = str_replace(",", "", $strURL);
  $strURL = str_replace("!", "", $strURL);
  $strURL = str_replace("'", "", $strURL);
  $strURL = str_replace("=", "", $strURL);
  $strURL = str_replace(".", "", $strURL);
  $strURL = str_replace(":", "", $strURL);
  $strURL = str_replace("\"", "", $strURL);
  $strURL = str_replace("(", "-", $strURL);
  $strURL = str_replace(")", "-", $strURL);
  $strURL = str_replace("á", "a", $strURL);
  $strURL = str_replace("é", "e", $strURL);
  $strURL = str_replace("í", "i", $strURL);
  $strURL = str_replace("ó", "o", $strURL);
  $strURL = str_replace("ú", "u", $strURL);
  $strURL = str_replace("ü", "u", $strURL);
  $strURL = str_replace("ñ", "n", $strURL);
  $strURL = str_replace("Á", "A", $strURL);
  $strURL = str_replace("É", "E", $strURL);
  $strURL = str_replace("Í", "I", $strURL);
  $strURL = str_replace("Ó", "O", $strURL);
  $strURL = str_replace("Ú", "U", $strURL);
  $strURL = str_replace("Ü", "U", $strURL);
  $strURL = str_replace("Ñ", "N", $strURL);
  $strURL = str_replace("&quot;", "", $strURL);
  $strURL = strtolower ($strURL);
  return $strURL;
}

function limpiaCaracteresDni($pstrTitulo) {
  $strURL = str_replace(".", "", stripslashes($pstrTitulo));
  $strURL = str_replace(",", "", $strURL);
  $strURL = str_replace("-", "", $strURL);
  return $strURL;
}

function replaceCaracter2($pstrTitulo) {
  $strURL = str_replace("&aacute;", "á", $pstrTitulo);
  $strURL = str_replace("&eacute;", "é", $strURL);
  $strURL = str_replace("&iacute;", "í", $strURL);
  $strURL = str_replace("&oacute;", "ó", $strURL);
  $strURL = str_replace("&uacute;", "ú", $strURL);
  $strURL = str_replace("&Aacute;", "Á", $strURL);
  $strURL = str_replace("&Eacute;", "É", $strURL);
  $strURL = str_replace("&Iacute;", "Í", $strURL);
  $strURL = str_replace("&Oacute;", "Ó", $strURL);
  $strURL = str_replace("&Uacute;", "Ú", $strURL);
  $strURL = str_replace("&ntilde;", "ñ", $strURL);
  $strURL = str_replace("&Ntilde;", "Ñ", $strURL);
  $strURL = str_replace("&ldquo;", "'", $strURL);
  $strURL = str_replace("&rdquo;", "'", $strURL);
  $strURL = str_replace("&quot;", "'", $strURL);
  $strURL = str_replace("&nbsp;", "", $strURL);
  $strURL = str_replace("&iquest;", "¿", $strURL);
  return $strURL;
}
function replaceCaracterReverse($pstrTitulo) {
  $strURL = str_replace("á","&aacute;", $pstrTitulo);
  $strURL = str_replace("é","&eacute;",$strURL);
  $strURL = str_replace("í","&iacute;", $strURL);
  $strURL = str_replace("ó","&oacute;",$strURL);
  $strURL = str_replace("ú","&uacute;",$strURL);
  $strURL = str_replace("Á","&Aacute;",$strURL);
  $strURL = str_replace("É","&Eacute;",$strURL);
  $strURL = str_replace("Í","&Iacute;",$strURL);
  $strURL = str_replace("Ó","&Oacute;",$strURL);
  $strURL = str_replace("Ú","&Uacute;",$strURL);
  $strURL = str_replace("ñ","&ntilde;",$strURL);
  $strURL = str_replace("Ñ","&Ntilde;",$strURL);
  $strURL = str_replace("'","&ldquo;",$strURL);
  $strURL = str_replace("'","&rdquo;", $strURL);
  $strURL = str_replace("'","&quot;",$strURL);
  $strURL = str_replace("","&nbsp;",$strURL);
  $strURL = str_replace("¿","&iquest;",$strURL);
  return $strURL;
}

function in_range($number=0, $value1=0, $value2=0){
  if( !is_numeric($number) OR !is_numeric($value1) OR !is_numeric($value2) ) return false;
  if($value1>$value2){
      $min = $value2;
      $max = $value1;
  }else{
      $min = $value1;
      $max = $value2;
  }
  if( $number <= $max AND $number >= $min ) return true;
  return false;
} 
?>
