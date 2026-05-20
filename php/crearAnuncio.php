<?php
session_start();
include 'conexion.php';

if(!isset($_SESSION['id']) || $_SESSION['rol'] != 'profesor'){
    die("Acceso denegado");
}

$clase_id = $_POST['clase_id'];
$titulo = $_POST['titulo'];
$descripcion = $_POST['descripcion'];

if(empty($titulo) || empty($descripcion)){
    die("Faltan datos");
}

$sql = "INSERT INTO anuncios (clase_id, titulo, descripcion)
        VALUES ('$clase_id', '$titulo', '$descripcion')";

if(!$conn->query($sql)){
    die("Error: " . $conn->error);
}

// volver a la pestaña anuncios
header("Location: ../clases.php?id=$clase_id&tab=anuncios");
exit();
?>