<?php
session_start();
include 'conexion.php';


$id_entrega = $_GET['id'];

# Busquem la entrega a la base de dades
$sql = "SELECT archivo_nombre, archivo_tipo, id_alumno 
        FROM entregas 
        WHERE id='$id_entrega'";
$res = $conn->query($sql);

# Si no existeix o hi ha un error, mostrem el missatge d'error
if(!$res || $res->num_rows == 0){
    echo "No encontrado";
    exit();
}

$datos = $res->fetch_assoc();

# Definim les 3 variables que es necessiten per la descarrega
$nombre = $datos['archivo_nombre'];
$tipo = $datos['archivo_tipo'];
$id_alumno = $datos['id_alumno'];


if($_SESSION['rol'] != "profesor" && $_SESSION['id'] != $id_alumno){
    echo "No tienes permiso";
    exit();
}

# Ruta on es guarda l'arxiu
$ruta = "C:/xampp/htdocs/Sintesis2/uploads/" . $nombre;

# Si no esta l'arxiu mostra l'error
if(!file_exists($ruta)){
    echo "Archivo no encontrado en: " . $ruta;
    exit();
}


if (ob_get_level()) {
    ob_end_clean();
}


header("Content-Description: File Transfer");
header("Content-Type: $tipo");
header("Content-Disposition: attachment; filename=\"$nombre\"");
header("Content-Transfer-Encoding: binary");
header("Content-Length: " . filesize($ruta));


readfile($ruta);
exit();
