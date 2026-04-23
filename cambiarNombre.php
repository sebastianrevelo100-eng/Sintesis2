<?php
session_start();
include "php/conexion.php";

$id = $_SESSION['id'];

// CAMBIAR NOMBRE
if (isset($_POST['cambiar_nombre'])) {
    $nuevo = $_POST['nuevo_nombre'];
    $conn->query("UPDATE usuarios SET nombre='$nuevo' WHERE id=$id");
    $_SESSION['nombre'] = $nuevo;
    header("Location: editar_perfil.php");
    exit;
}

// CAMBIAR CORREO
if (isset($_POST['cambiar_correo'])) {
    $nuevo = $_POST['nuevo_correo'];
    $conn->query("UPDATE usuarios SET email='$nuevo' WHERE id=$id");
    $_SESSION['email'] = $nuevo;
    header("Location: editar_perfil.php");
    exit;
}

// CAMBIAR CONTRASEÑA
if (isset($_POST['cambiar_contrasena'])) {

    $actual = $_POST['actual'];
    $nueva = $_POST['nueva'];

    // Obtener contraseña actual
    $sql = $conn->query("SELECT password FROM usuarios WHERE id=$id");
    $user = $sql->fetch_assoc();

    // Verificar contraseña actual
    if (password_verify($actual, $user['password'])) {

        $hashNueva = password_hash($nueva, PASSWORD_DEFAULT);
        $conn->query("UPDATE usuarios SET password='$hashNueva' WHERE id=$id");

        header("Location: editar_perfil.php?ok=1");
        exit;

    } else {
        header("Location: editar_perfil.php?error=1");
        exit;
    }
}
?>
