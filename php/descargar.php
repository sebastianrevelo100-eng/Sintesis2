<?php
session_start();
include 'conexion.php';

// pillamos el id que viene por la url
$id_entrega = $_GET['id'];

// buscamos la entrega en la bd
$sql = "SELECT archivo_nombre, archivo_tipo, id_alumno 
        FROM entregas 
        WHERE id='$id_entrega'";
$res = $conn->query($sql);

// si no existe pues nada
if(!$res || $res->num_rows == 0){
    echo "No encontrado";
    exit();
}

$datos = $res->fetch_assoc();

// nombre del archivo y tipo
$nombre = $datos['archivo_nombre'];
$tipo = $datos['archivo_tipo'];
$id_alumno = $datos['id_alumno'];

// comprobamos que el que descarga sea profe o el alumno dueño
if($_SESSION['rol'] != "profesor" && $_SESSION['id'] != $id_alumno){
    echo "No tienes permiso";
    exit();
}

// ruta donde guardo los archivos (a lo cutre pero funciona)
$ruta = "C:/xampp/htdocs/Sintesis2/uploads/" . $nombre;

// si no está el archivo pues error
if(!file_exists($ruta)){
    echo "Archivo no encontrado en: " . $ruta;
    exit();
}

// headers para que el navegador lo descargue
header("Content-Type: $tipo");
header("Content-Disposition: attachment; filename=\"$nombre\"");
header("Content-Length: " . filesize($ruta));

// enviamos el archivo tal cual
readfile($ruta);
exit();
