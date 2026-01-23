<?php
session_start(); // <-- importante

include 'conexion.php';

if(isset($_POST['correo']) && isset($_POST['contraseña'])) {

    $correo = $_POST['correo'];
    $contraseña = $_POST['contraseña'];

    $sql = "SELECT * FROM usuarios WHERE correo='$correo'";
    $result = $conn->query($sql);

    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if(password_verify($contraseña, $row['contraseña'])) {
           
            $_SESSION['id'] = $row['id'];
            $_SESSION['nombre'] = $row['nombre'];
            $_SESSION['rol'] = $row['rol'];

            
            header("Location: ../mainPage.php");
            exit();
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "Usuario no encontrado.";
    }

} else {
    echo "Por favor completa todos los campos del formulario.";
}

$conn->close();
?>
