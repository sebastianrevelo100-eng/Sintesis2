<?php
session_start();
include 'conexion.php';

$deber_id = $_POST['id_deberes'];
$alumno_id = $_SESSION['id'];
$clase_id = $_POST['clase_id'];

$nombre_archivo = $_FILES['archivo']['name'];
$tipo_archivo = $_FILES['archivo']['type'];

$ruta_archivo = "../uploads/" . $nombre_archivo;

move_uploaded_file($_FILES['archivo']['tmp_name'], $ruta_archivo);

$sql = "INSERT INTO entregas (id_deberes, id_alumno, archivo_nombre, archivo_contenido, archivo_tipo, fecha_entrega) 
        VALUES ('$deber_id', '$alumno_id', '$nombre_archivo', '$ruta_archivo', '$tipo_archivo', NOW())";

$conn->query($sql);

header("Location: ../clases.php?id=" . $clase_id);
exit();
?>
