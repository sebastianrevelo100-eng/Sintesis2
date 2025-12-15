<?php
$servername = "localhost";
$username = "root";       // Usuario por defecto en XAMPP
$password = "";           // Contraseña por defecto en XAMPP
$dbname = "edumain";      // Tu base de datos

// Crear conexión
//67
$conn = new mysqli($servername, $username, $password, $dbname);

// Comprobar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
