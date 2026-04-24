<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Perfil</title>
    <!-- traemos los estilos de la pagina -->
    <link rel="stylesheet" href="clases.css">
</head>
<body>

<?php
// iniciamos sesion para acceder a los datos del usuario
session_start();
// traemos la conexion a la bd
include "php/conexion.php";

// verificamos que el usuario este logeado
if(!isset($_SESSION['id'])){
    header("Location: login.html");
    exit();
}

// obtenemos el id del usuario logeado
$id = $_SESSION['id'];
// buscamos los datos del usuario en la bd
$sql = "SELECT * FROM usuarios WHERE id='$id'";
$res = $conn->query($sql);

// si encuentra el usuario guardamos sus datos
if($res && $res->num_rows > 0){
    $user = $res->fetch_assoc();
} else {
    echo "Usuario no encontrado";
    exit();
}
?>

<!-- incluimos el menu desplegable -->
<?php include 'desplegable.php'; ?>

<div class="container">

<h1>Mi Perfil</h1>

<!-- mostramos la informacion del usuario -->
<div style="background-color: lightgray; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
    <p><strong>Nombre:</strong> <?php echo $user['nombre']; ?></p>
    <p><strong>Email:</strong> <?php echo $user['correo']; ?></p>
    <p><strong>Rol:</strong> <?php echo ucfirst($user['rol']); ?></p>
</div>

<!-- formulario para cambiar el nombre del usuario -->
<h2>Cambiar Nombre</h2>
<form action="cambiarNombre.php" method="POST" class="form-deber">
    <input type="text" name="nuevo_nombre" placeholder="Nuevo nombre" value="<?php echo $user['nombre']; ?>" required>
    <button type="submit">Guardar nombre</button>
</form>

<!-- formulario para cambiar la contraseña -->
<h2>Cambiar Contrasena</h2>
<form action="cambiarContrasena.php" method="POST" class="form-deber">
    <input type="password" name="nueva_contrasena" placeholder="Nueva contrasena" required>
    <button type="submit">Cambiar contrasena</button>
</form>

<!-- boton para volver a la pagina principal -->
<a class="volver" href="mainPage.php">Volver</a>

</div>

</body>
</html>