<?php
session_start();
session_destroy();
session_unset();
require('index.php');
die; 
?>