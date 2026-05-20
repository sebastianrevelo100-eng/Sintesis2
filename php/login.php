<?php
session_start();
include 'conexion.php';


if (!empty($_POST['correo']) && !empty($_POST['contraseña'])) {

    $correo = $_POST['correo']; #Crea la variable de correu i li asigna el valor del camp al formulari de inici de sessió
    $contraseña = $_POST['contraseña']; #Crea la variable de contrasenya i també li asigna el valor del camp

    $sql = "SELECT * FROM usuarios WHERE correo = '$correo'";
    $resultado = $conn->query($sql);

    if ($resultado->num_rows > 0) {

        $usuario = $resultado->fetch_assoc();

        # comprovació de les credencials
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