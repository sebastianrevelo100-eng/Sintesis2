<?php
include 'conexion.php';

// Tomar los datos del formulario
$nombre = $_POST['nombre'];
$correo = $_POST['correo'];
$contraseña = password_hash($_POST['contraseña'], PASSWORD_DEFAULT);
$rol = $_POST['rol'];

// Insertar en la base de datos
$sql = "INSERT INTO usuarios (nombre, correo, contraseña, rol) 
        VALUES ('$nombre', '$correo', '$contraseña', '$rol')";

if ($conn->query($sql) === TRUE) {
    echo "<p style='font-family: Arial, Helvetica, sans-serif; font-size: large;'>Usuario registrado correctamente.</p>";
    echo "<a href='../index.html' style='font-family: Arial, Helvetica, sans-serif; font-size: large; text-decoration: none; padding: 10px; border-radius: 10px; background-color: rgb(225, 225, 225); border: 2px solid rgb(225, 225, 225);'>Volver al inicio</a>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
