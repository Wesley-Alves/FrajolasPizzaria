<?php
    require_once("../model/usuario.php");

    session_start();
    if (!isset($_SESSION["usuario"])) {
        header("location:../");
        exit();
    }
?>