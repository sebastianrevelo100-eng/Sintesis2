<?php
// iniciamos la sesion
session_start();
// traemos la conexion a la bd
include 'conexion.php';

// verificamos que lleguen los datos del formulario
if (!empty($_POST['correo']) && !empty($_POST['contraseña'])) {

    // obtenemos los datos del formulario
    $correo = $_POST['correo'];
    $contrasena = $_POST['contraseña'];

    // buscamos el usuario con ese correo
    $sql = "SELECT * FROM usuarios WHERE correo = '$correo'";
    $resultado = $conn->query($sql);

    // si existe el usuario
    if ($resultado->num_rows > 0) {

        // traemos los datos del usuario
        $usuario = $resultado->fetch_assoc();

        // comparamos la contrasena que ingreso con la de la bd
        if ($contrasena == $usuario['contraseña']) {

            // guardamos los datos en la sesion
            $_SESSION['id'] = $usuario['id'];
            $_SESSION['nombre'] = $usuario['nombre'];
            $_SESSION['rol'] = $usuario['rol'];

            // redirigimos a la pagina principal
            header("Location: ../mainPage.php");
            exit();

        } else {
            echo "Contrasena incorrecta";
        }

    } else {
        echo "Usuario no encontrado";
    }

} else {
    echo "Rellena los campos";
}

$conn->close();
?>