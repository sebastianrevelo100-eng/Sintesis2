<?php
session_start();
include 'conexion.php';




// si no eres profesor no puedes crear clase

if(!isset($_SESSION['id']) || $_SESSION['rol'] != 'profesor'){
    die("no tienes permiso para crear clases");
}




// si llegaron los datos del formulario

if(isset($_POST['nombre'])){
    $nombre = $_POST['nombre']; // nombre de la clase
    $descripcion = $_POST['descripcion']; // descripcion
    $profesor_id = $_SESSION['id'];

    // codigo random de 6 letras y numeros
    $codigo = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, 6);

    // guardar en la base de datos
    $sql = "INSERT INTO clases (nombre, descripcion, profesor_id, codigo)
            VALUES ('$nombre','$descripcion','$profesor_id', '$codigo)";

    if($conn->query($sql) === TRUE){
        // mostrar mensaje y link a la clase
        echo "clase creada! codigo: $codigo <br>";
        echo "<a href='../clases.php?id=".$conn->insert_id."'>ir a la pagina de la clase</a><br>";
        echo "<a href='../mainPage.php'>volver al menu</a>";
    } else {
        echo "error al crear clase <br>" . $conn->error;
    }

} else {
    echo "por favor completa el formulario";
}
?>
