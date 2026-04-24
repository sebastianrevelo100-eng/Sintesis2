<?php
// iniciamos sesion para verificar que el usuario este logeado
session_start();
// traemos la conexion a la bd
include 'php/conexion.php';

// verificamos que el usuario este logeado
if(!isset($_SESSION['id'])){
    header("Location: login.html");
    exit();
}

// obtenemos el id del usuario logeado
$id = $_SESSION['id'];
// obtenemos la nueva contrasena que ingreso el usuario
$nueva_contrasena = $_POST['nueva_contrasena'];

// hacemos un update a la tabla usuarios con la nueva contrasena
$sql = "UPDATE usuarios SET contraseña='$nueva_contrasena' WHERE id='$id'";

// si el update fue exitoso redirigimos a perfil
if($conn->query($sql) === TRUE){
    echo "Contrasena cambio";
    echo "<a href='perfil.php'>Volver a perfil</a>";
} else {
    echo "Error: " . $conn->error;
}
?>
