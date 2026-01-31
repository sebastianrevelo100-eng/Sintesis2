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
<<<<<<< HEAD
            echo "Contraseña incorrecta." . $conn->error;
=======
            echo "Contraseña incorrecta";
>>>>>>> e2395eda95f53a683bc86cc18cd89a4856af9ef8
        }

    } else {
<<<<<<< HEAD
        echo "Usuario no encontrado." . $conn->error;
=======
        echo "Usuario no encontrado";
>>>>>>> e2395eda95f53a683bc86cc18cd89a4856af9ef8
    }

} else {
    echo "Rellena los campos";
}

$conn->close();
?>