<?php
// iniciamos la sesion
session_start(); 

// verificamos que el usuario este logeado, si no lo mandamos al login
if(!isset($_SESSION['id'])){
    header("Location: login.html");
    exit();
}

// guardamos el nombre y rol del usuario en variables
$nombre = $_SESSION['nombre'];
$rol = $_SESSION['rol'];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>EduMain - Pagina principal</title>
    <link rel="icon" type="image/x-icon" href="imagen/logo.ico">
    <!-- traemos los estilos -->
    <link rel="stylesheet" href="mainPage.css">
    <script>
        // funcion para mostrar/ocultar el menu del perfil
        function togglePerfilMenu() {
            document.getElementById("perfilMenu").classList.toggle("show");
        }
    </script>

    <!-- contenedor del menu de perfil (aparece al hacer click) -->
    <div class="perfil-container">
        <div id="perfilMenu" class="perfil-menu">
            <a href="perfil.php">Ver perfil</a>
            <a href="cambiarContrasena.php">Cambiar contrasena</a>
            <a href="logout.php">Cerrar sesion</a>
        </div>
    </div>

</head>

<!-- boton para abrir el menu del perfil -->
<div>
    <a class="botonPerfil" href="perfil.php">perfil</a>
</div>

<body>

<!-- menu con bienvenida y opciones -->
<div class="menu">
    <h2>Bienvenido, <?php echo $nombre; ?> (<?php echo $rol; ?>)</h2>
    <ul>
        <li><a href="php/misclases.php">Mis clases</a></li>
        <!-- si es profesor muestra opcion de crear clase -->
        <?php if($rol == "profesor"): ?>
        <li><a href="clase/crearclase.html">Crear clase</a></li>
        <?php endif; ?>
        <li><a href="php/logout.php">Cerrar sesion</a></li>
    </ul>

    <!-- si es alumno mostramos formulario para unirse a clase con codigo -->
    <?php if($rol == "alumno"): ?>
    <form action="php/unirse.php" method="POST">
        <input type="text" name="codigo" placeholder="Codigo de la clase" required>
        <input type="submit" value="Unirse a la clase">
    </form>
    <?php endif; ?>
</div>

<h3>Mis clases</h3>

<?php
// traemos la conexion a la bd
include 'php/conexion.php';

// mostramos las clases segun si eres alumno o profesor
if($rol == 'alumno'){ 
    // si es alumno buscamos sus clases en alumnos_clases
    $alumno_id = $_SESSION['id'];
    $sql = "SELECT c.* FROM clases c
            INNER JOIN alumnos_clases ac ON c.id = ac.clase_id
            WHERE ac.alumno_id='$alumno_id'";
    $res = $conn->query($sql);
    echo "<div class='cuadrado-clases'>";
    // mostramos cada clase como un cuadrado clickeable
    while($clase = $res->fetch_assoc()){
        echo "<a class='clase' href='clases.php?id=".htmlspecialchars($clase['id'])."'>"
        .htmlspecialchars($clase['nombre']).
        "</a>";
    }
    echo "</div>";
}

if($rol == 'profesor'){
    // si es profesor buscamos sus clases (las que creo)
    $profesor_id = $_SESSION['id'];
    $sql = "SELECT * FROM clases WHERE profesor_id='$profesor_id'";
    $res = $conn->query($sql);
    echo "<div class='cuadrado-clases'>";
    // mostramos cada clase como un cuadrado clickeable
    while($clase = $res->fetch_assoc()){
        echo "<a class='clase' href='clases.php?id=".htmlspecialchars($clase['id'])."'>"
        .htmlspecialchars($clase['nombre']).
        "</a>";
    }
    echo "</div>";
}

// cerramos la conexion a la base de datos
$conn->close();
?>

</body>
</html>