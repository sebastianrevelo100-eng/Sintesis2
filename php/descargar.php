<?php
session_start();
include 'conexion.php';

// solo profesores
if($_SESSION['rol'] != "profesor"){
    echo "No puedes.";
    exit();
}

// id de la entrega
$id_entrega = $_GET['id'];

// buscar en db
$sql = "SELECT archivo, archivo_nombre, archivo_contenido, archivo_tipo FROM entregas WHERE id=?";
$stmt = $conn->prepare($sql);
if(!$stmt){
    echo "Error en prepare: " . $conn->error;
    exit();
}
$stmt->bind_param("i", $id_entrega);
if(!$stmt->execute()){
    echo "Error en execute: " . $stmt->error;
    exit();
}
$stmt->bind_result($archivo_path, $nombre, $contenido, $tipo);
$stmt->fetch();
$stmt->close();

if($contenido){
    // nuevo metodo, desde db
    header('Content-Type: ' . $tipo);
    header('Content-Disposition: attachment; filename="' . $nombre . '"');
    header('Content-Length: ' . strlen($contenido));
    echo $contenido;
    exit();
} elseif($archivo_path && file_exists($archivo_path)){
    // viejo metodo, desde archivo
    $partes = explode('_', basename($archivo_path), 2);
    $nombre = $partes[1] ?? basename($archivo_path);
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . $nombre . '"');
    header('Content-Length: ' . filesize($archivo_path));
    readfile($archivo_path);
    exit();
} else {
    echo "No encontrado. ID: $id_entrega, Path: $archivo_path";
}

$conn->close();
?>