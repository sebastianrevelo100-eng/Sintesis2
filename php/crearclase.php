<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
include 'conexion.php';


if(!isset($_SESSION['id']) || $_SESSION['rol'] != 'profesor'){
    die("No tienes permiso para crear clases.");
}


if(isset($_POST['nombre'])){
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $descripcion = $conn->real_escape_string($_POST['descripcion']);
    $profesor_id = $_SESSION['id'];

    $sql = "INSERT INTO clases (nombre, profesor_id, descripcion) VALUES ('$nombre', '$profesor_id', '$descripcion')";

    if($conn->query($sql) === TRUE){
        echo "Clase creada correctamente. <a href='../mainPage.php'>Volver al menú</a>";
    } else {
        echo "Error al crear clase: " . $conn->error;
    }

} else {
    echo "Por favor completa el formulario.";
}
?>
