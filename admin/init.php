<?php
    ob_start();
    include "conect.php";

    //Root
    $tpl = 'includes/templates/';  // Template root
    $lan = 'includes/languages/';  // languages root
    $func= 'includes/functions/';  // functions root
    $js = 'layout/js/';
    $css = 'layout/css/';
    
    if(!isset($_SESSION['Languages'])){
        $_SESSION['Languages'] = 'english';
    } else{
        if(isset($_GET['lang'])){
            $_SESSION['Languages'] = $_GET['lang'];
        } else{
            $_SESSION['Languages'] = 'english';
        }
    }
    include $lan . $_SESSION['Languages'] . ".php"; 
    include $func. "functions.php";


    include $tpl . "header.php"; 
    
    if(!isset($noNavBar)){
        include $tpl . "navbar.php";
    }
    ob_end_flush();
?>