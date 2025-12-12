<?php
    //KONFIGURASI KE SIMRS
    $servername = "localhost";
    $username = "root";
    $password = "arunaparasilvanursari";
    $db = "simrs3";
    
    // Create connection
    $Conn = new mysqli($servername, $username, $password, $db);
    
    // Check connection
    if ($Conn->connect_error) {
        die("Connection failed: " . $Conn->connect_error);
    }
?>