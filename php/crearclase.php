<?php
// iniciamos sesion
session_start();
// traemos la conexion a la bd
include 'conexion.php';

// verificamos que el usuario sea profesor
if(!isset($_SESSION['id']) || $_SESSION['rol'] != 'profesor'){
    die("no tienes permiso");
}

// si llegaron los datos del formulario
if(isset($_POST['nombre'])){
    // obtenemos los datos del formulario
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $profesor_id = $_SESSION['id'];
    // generamos un codigo aleatorio de 6 caracteres
    $codigo = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, 6);

    // insertamos la nueva clase en la base de datos
    $sql = "INSERT INTO clases (nombre, descripcion, profesor_id, codigo) 
            VALUES ('$nombre','$descripcion','$profesor_id','$codigo')";

    // si la creacion fue exitosa mostramos mensajes
    if($conn->query($sql) === TRUE){
        echo "clase creada! codigo: $codigo <br>";
        // link para ir a la clase creada
        echo "<a href='../clases.php?id=".$conn->insert_id."'>ir a la clase</a><br>";
        // link para volver a la pagina principal
        echo "<a href='../mainPage.php'>volver</a>";
    } else {
        echo "error: " . $conn->error;
    }
} else {
    echo "completa el formulario";
}
?>
