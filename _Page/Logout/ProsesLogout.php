<?php
    session_start();
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    session_destroy();   
    session_unset();
    header('Location:../../Login.php');
?>