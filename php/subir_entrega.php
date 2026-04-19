<?php
session_start();
include 'conexion.php';

$deber_id = $_POST['id_deberes'];
$alumno_id = $_SESSION['id'];
$clase_id = $_POST['clase_id'];

$nombre_archivo = $_FILES['archivo']['name'];
$tipo_archivo = $_FILES['archivo']['type'];

// leer el archivo
$contenido = file_get_contents($_FILES['archivo']['tmp_name']);

// guardar en db
$sql = "INSERT INTO entregas (id_deberes, id_alumno, archivo_nombre, archivo_contenido, archivo_tipo, fecha_entrega) VALUES (?, ?, ?, ?, ?, NOW())";

$stmt = $conn->prepare($sql);
if(!$stmt){
    echo "Error prepare: " . $conn->error;
    exit();
}

// unset primero
$null = NULL;
$stmt->bind_param("iisss", $deber_id, $alumno_id, $nombre_archivo, $null, $tipo_archivo);

// ahora envia el contenido
$stmt->send_long_data(3, $contenido);

if(!$stmt->execute()){
    echo "Error execute: " . $stmt->error;
    exit();
}
$stmt->close();

header("Location: ../clases.php?id=" . $clase_id);
exit();
?>
?>
