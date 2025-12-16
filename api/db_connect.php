<?php
// INFINITYFREE CREDENTIALS (Confirmed from your screenshot)
$servername = "sql206.infinityfree.com"; 
$username = "if0_40696687";              
$password = "sCiirGYh4WCtF";             
$dbname = "if0_40696687_yankicks";       

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>