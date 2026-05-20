<?php
session_start();
include 'conexion.php';

// Comprovar que arriben les dades
if (isset($_POST['nombre']) && isset($_POST['correo']) && isset($_POST['contraseña']) && isset($_POST['rol'])) {



    # Crea les diferents variables necessàries per a registrar-se
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $contraseña = $_POST['contraseña'];
    $rol = $_POST['rol'];

    // Comprovar que no estiguin buits
    if ($nombre == "" || $correo == "" || $contraseña == "" || $rol == "") {
        echo "Por favor completa todos los campos del formulario.";
        exit;
    }

    // Insertar usuari 
    $sql = "INSERT INTO usuarios (nombre, correo, contraseña, rol) 
            VALUES ('$nombre', '$correo', '$contraseña', '$rol')";

    if ($conn->query($sql) === TRUE) {
        // Guardar sesión
        $_SESSION['id'] = $conn->insert_id;
        $_SESSION['nombre'] = $nombre;
        $_SESSION['rol'] = $rol;

        // Redirigir
        header("Location: ../mainPage.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }

} else {
    echo "Por favor completa todos los campos del formulario.";
}

// Guardar en la BD
$sql = "INSERT INTO usuarios (email, password, foto_perfil) 
        VALUES ('$email', '$passwordHash', '$fotoPerfil')";


$conn->close();
?>
