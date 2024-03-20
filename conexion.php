<?php
function connect(){
    $server = "localhost";
    $user = "root";
    $password = "1234";
    $db = "test";
    $conn = new mysqli($server,$user,$password,$db);
    if($conn->connect_errno){
        echo "Imposible conectar a MySQL";
        exit;
    }
    return $conn;
    
}

