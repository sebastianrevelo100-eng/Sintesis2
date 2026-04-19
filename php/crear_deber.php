<?php
session_start();
include 'conexion.php';

$titulo = $_POST['titulo'];
$descripcion = $_POST['descripcion'];
$fecha = $_POST['fecha_limite'];
$clase_id = $_POST['clase_id'];
$profesor = $_SESSION['id'];

$sql = "INSERT INTO deberes (clase_id, titulo, descripcion, fecha_limite, creada_por)
        VALUES ('$clase_id', '$titulo', '$descripcion', '$fecha', '$profesor')";

$conn->query($sql);

header("Location: ../clases.php?id=".$clase_id);
exit();
?>
