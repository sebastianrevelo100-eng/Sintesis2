<?php
session_start();
include 'php/conexion.php';

if(!isset($_SESSION['id'])){
    header("Location: login.html");
    exit();
}

$clase_id = $_GET['id']; // el id que viene del link de mainPage

$sql = "SELECT * FROM clases WHERE id='$clase_id'";
$res = $conn->query($sql);

if($res && $res->num_rows > 0){
    $clase = $res->fetch_assoc();
} else {
    echo "clase no encontrada";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title><?php echo $clase['nombre']; ?></title>
</head>
<body>

<h1><?php echo $clase['nombre']; ?></h1>
<p><?php echo $clase['descripcion']; ?></p>

<a href="mainPage.php">volver al menu</a>

</body>
</html>
