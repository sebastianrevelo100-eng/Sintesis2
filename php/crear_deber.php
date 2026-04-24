<?php
// iniciamos sesion
session_start();
// traemos la conexion a la bd
include 'conexion.php';

// obtenemos los datos del formulario
$titulo = $_POST['titulo'];
$descripcion = $_POST['descripcion'];
$fecha = $_POST['fecha_limite'];
$clase_id = $_POST['clase_id'];
// obtenemos el id del profesor desde la sesion
$profesor = $_SESSION['id'];

// insertamos el nuevo deber en la base de datos
$sql = "INSERT INTO deberes (clase_id, titulo, descripcion, fecha_limite, creada_por)
        VALUES ('$clase_id', '$titulo', '$descripcion', '$fecha', '$profesor')";

// ejecutamos la query
$conn->query($sql);

// redirigimos a la pagina de la clase
header("Location: ../clases.php?id=".$clase_id);
exit();
?>
