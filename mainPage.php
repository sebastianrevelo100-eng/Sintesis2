<?php
session_start(); // Iniciar sesión

// Verificar si el usuario ha iniciado sesión
if(!isset($_SESSION['id'])){
    header("Location: login.html"); // Si no hay sesión, redirige al login
    exit();
}

$nombre = $_SESSION['nombre'];
$rol = $_SESSION['rol'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduMain - Página principal</title>
    <link rel="stylesheet" href="mainpage.css">
</head>
<body>
    <div class="menu">
        <h2>Bienvenido, <?php echo $nombre; ?> (<?php echo $rol; ?>)</h2>
        <ul>
            <li><a href="#">Mis clases</a></li>
            <?php if($rol == "profesor"): ?>
                 <li><a href="clase/crearclase.html">Crear clase</a></li>
            <?php endif; ?>
            <li><a href="php/logout.php">Cerrar sesión</a></li>
        </ul>
<?php if($rol == 'alumno'): ?>
<form action="php/unirse.php" method="POST">
    <input type="text" name="codigo" placeholder="Código de clase" required>
    <input type="submit" value="Unirse a la clase">
</form>
<?php endif; ?>

    </div>
    </div>
    
</body>
</html>
