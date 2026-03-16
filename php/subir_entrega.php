<?php
session_start();
include 'conexion.php';

$deber_id = $_POST['id_deberes'];
$alumno_id = $_SESSION['id'];
$clase_id = $_POST['clase_id']; // ← AÑADIDO

$nombre_archivo = $_FILES['archivo']['name'];
$ruta = "../uploads/" . time() . "_" . $nombre_archivo;

move_uploaded_file($_FILES['archivo']['tmp_name'], $ruta);

$sql = "INSERT INTO entregas (id_deberes, id_alumno, archivo, fecha_entrega)
        VALUES ('$deber_id', '$alumno_id', '$ruta', NOW())";

$conn->query($sql);

header("Location: ../clases.php?id=" . $clase_id);
exit();
?>
