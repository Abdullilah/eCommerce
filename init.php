<?php
    ob_start();
    include "admin/conect.php";

    //Root
    $tpl = 'includes/templates/';  // Template root
    $lan = 'includes/languages/';  // languages root
    $func= 'includes/functions/';  // functions root

    include $lan . "english.php"; 
    include $func. "functions.php";

    include $tpl . "header.php";
    
    ob_end_flush();
?>