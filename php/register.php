<?php
session_start(); // Iniciar sesión

include 'conexion.php';

if(isset($_POST['nombre']) && isset($_POST['correo']) && isset($_POST['contraseña']) && isset($_POST['rol'])) {

    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $contraseña = $_POST['contraseña'];
    $rol = $_POST['rol'];

    // Insertar usuario en la base de datos
    $sql = "INSERT INTO usuarios (nombre, correo, contraseña, rol) 
            VALUES ('$nombre', '$correo', '$contraseña', '$rol')";

    if ($conn->query($sql) === TRUE) {
        // Guardar datos en sesión
        $_SESSION['id'] = $conn->insert_id;
        $_SESSION['nombre'] = $nombre;
        $_SESSION['rol'] = $rol;

        // Redirigir a mainpage.php
        header("Location: ../mainpage.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }

} else {
    echo "Por favor completa todos los campos del formulario.";
}

$conn->close();
?>
