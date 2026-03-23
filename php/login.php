<?php
session_start();
include 'conexion.php';

// comprovar que llegan los datos
if (!empty($_POST['correo']) && !empty($_POST['contraseña'])) {

    $correo = $_POST['correo'];
    $contraseña = $_POST['contraseña'];

    $sql = "SELECT * FROM usuarios WHERE correo = '$correo'";
    $resultado = $conn->query($sql);

    if ($resultado->num_rows > 0) {

        $usuario = $resultado->fetch_assoc();

        // comparacion directa
        if ($contraseña == $usuario['contraseña']) {

            $_SESSION['id'] = $usuario['id'];
            $_SESSION['nombre'] = $usuario['nombre'];
            $_SESSION['rol'] = $usuario['rol'];

            header("Location: ../mainPage.php");
            exit();

        } else {
            echo "Contraseña incorrecta";
        }

    } else {
        echo "Usuario no encontrado";
    }

} else {
    echo "Rellena los campos";
}

$_SESSION['foto_perfil'] = $user['foto_perfil'];


$conn->close();
?>