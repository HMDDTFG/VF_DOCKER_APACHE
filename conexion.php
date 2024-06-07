<?php
$servername = "localhost";
//$port = x ; //especificamos puerto si no es el 3306
$username = "root";
$password = "";
$dbname = "store";

try{
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "<strong>Conexion exitosa</strong><br>";
}catch(PDOException $e){
    echo "Fallo de conexión" . $e->getMessage();
}
?>