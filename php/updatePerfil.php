<?php
session_start();
include 'conexion.php';

$id = $_SESSION['id'];
$nombre = $_POST['nombre'];
$correo = $_POST['correo'];

$sql = "UPDATE usuarios 
        SET nombre='$nombre', correo='$correo' 
        WHERE id='$id'";

if($conn->query($sql)){
    $_SESSION['nombre'] = $nombre; // actualizar sesión
    header("Location: ../mainPage.php");
} else {
    echo "Error: " . $conn->error;
}