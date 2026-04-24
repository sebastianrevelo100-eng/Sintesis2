<?php
// iniciamos la sesion para acceder a los datos del usuario
session_start();
// traemos la conexion a la base de datos
include "php/conexion.php";

// obtenemos el id del usuario desde la sesion
$id = $_SESSION['id'];
// obtenemos el nuevo nombre que ingreso el usuario
$nuevo_nombre = $_POST['nuevo_nombre'];

// actualizamos el nombre en la base de datos
$sql = "UPDATE usuarios SET nombre='$nuevo_nombre' WHERE id='$id'";

// si la actualizacion fue exitosa
if($conn->query($sql) === TRUE){
    // actualizamos tambien la sesion para que se vea el cambio de inmediato
    $_SESSION['nombre'] = $nuevo_nombre;
    // redirigimos a perfil.php
    header("Location: perfil.php");
} else {
    echo "Error: " . $conn->error;
}
?>