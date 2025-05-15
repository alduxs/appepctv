<?php
    session_start();
    if(!isset($_SESSION["strUsername"])){
        header("Location: index.php?idErr=2");
    }
?>