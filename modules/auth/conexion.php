<?php
$host = "localhost";
$db   = "proyectofinalweb"; //aqui se coloca el nombre de la base de datos
$user = "root";
$pass = "santa123#"; //si no tiene password dejar en blanco(en mi caso si tengo)

try {
    $conn = new PDO("mysql:host=localhost;dbname=$db;charset=utf8", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch(PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>

