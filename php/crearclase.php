<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
include 'conexion.php';

// Verificar sesión
if(!isset($_SESSION['id']) || $_SESSION['rol'] != 'profesor'){
    die("No tienes permiso para crear clases.");
}

// Verificar que los datos llegaron
if(isset($_POST['nombre'])){
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $descripcion = $conn->real_escape_string($_POST['descripcion']);
    $profesor_id = $_SESSION['id'];

    $codigo = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, 6);
    $sql = "INSERT INTO clases (nombre, descripcion, profesor_id, codigo) VALUES ('$nombre', '$descripcion', '$profesor_id', '$codigo')";


    if($conn->query($sql) === TRUE){
        echo "Clase creada correctamente. <a href='../mainPage.php'>Volver al menú</a>";
    } else {
        echo "Error al crear clase: " . $conn->error;
    }

} else {
    echo "Por favor completa el formulario.";
}
?>
