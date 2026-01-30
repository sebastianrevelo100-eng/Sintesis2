<?php
session_start();
include 'conexion.php';

// Comprobar que llegan los datos
if (!empty($_POST['correo']) && !empty($_POST['contraseña'])) {

    $correo = $_POST['correo'];
    $contraseña = $_POST['contraseña'];

    $sql = "SELECT * FROM usuarios WHERE correo = '$correo'";
    $resultado = $conn->query($sql);

    if ($resultado->num_rows > 0) {

        $usuario = $resultado->fetch_assoc();

        // Comparación directa (modo principiante)
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

$conn->close();
?>