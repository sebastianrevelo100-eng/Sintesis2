<?php
session_start();
include "php/conexion.php";

$id = $_SESSION['id'];
$nuevoNombre = $_POST['nuevoNombre'];

$sql = "UPDATE usuario SET nombre='$nuevoNombre' WHERE id=$id";
$conn->query($sql);

$_SESSION['nombre'] = $nuevoNombre;

header("Location: perfil.php");
exit;
?>