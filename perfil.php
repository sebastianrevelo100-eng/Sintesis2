<!DOCTYPE html>
<html lang="en">
<head>
    <title>Modifica perfil</title>
</head>
<body>
    
<?php

session_start();
include "php/conexion.php";

$id = $_SESSION['id'];
$sql = $conn->query("SELECT * FROM usuarios WHERE id=$id");
$user = $sql->fetch_assoc();

?>

<form action="cambiarNombre.php" method="POST">
    <input class="changeName" type="text" name="nuevo_nombre" value="<?php echo $user['nombre']; ?>" required>
    <button class="modifyButton" type="submit">Cambiar</button>
    <h1><?php echo $user['nombre']; ?></h1>
</form>



</body>
</html>