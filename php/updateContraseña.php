<?php
session_start();
include 'conexion.php';

$id = $_SESSION['id'];

$actual = $_POST['actual'];
$nueva = $_POST['nueva'];

// comprobar contraseña actual
$sql = "SELECT contrasena FROM usuarios WHERE id='$id'";
$res = $conn->query($sql);
$user = $res->fetch_assoc();

if($actual == $user['contrasena']){

    $sqlUpdate = "UPDATE usuarios 
                  SET contrasena='$nueva' 
                  WHERE id='$id'";

    if($conn->query($sqlUpdate)){
        echo "Contraseña actualizada";
    } else {
        echo "Error";
    }

} else {
    echo "Contraseña incorrecta";
}