<?php
session_start();
include 'conexion.php';

$alumno_id = $_SESSION['id'];
$codigo = $_POST['codigo'];

# busca la clase pel codi
$sql = "SELECT * FROM clases WHERE codigo='$codigo'";
$res = $conn->query($sql);

if($res && $res->num_rows > 0){
    $clase = $res->fetch_assoc();
    $clase_id = $clase['id'];

    # afegir a l'alumne a la classe
    $conn->query("INSERT INTO alumnos_clases (alumno_id, clase_id) VALUES ('$alumno_id','$clase_id')");
    
    header("Location: ../mainPage.php");
    exit();

} else {
    echo "No s'ha trobat cap classe amb aquest codi.";
}

$conn->close();
?>
