<?php
session_start(); 

// verificamos si el usuario no ha iniciado sesion, si no lo envia al login.html
if(!isset($_SESSION['id'])){
    header("Location: login.html");
    exit();
}

// Guardamos el nombre y rol del usuario para mostrar en la página
$nombre = $_SESSION['nombre'];
$rol = $_SESSION['rol'];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>EduMain - Página principal</title>
    <link rel="stylesheet" href="mainPage.css">
    <link>
    <script>

        
        function togglePerfilMenu() {
            document.getElementById("perfilMenu").classList.toggle("show");
        }


    </script>

    <div class="perfil-container">

    <div id="perfilMenu" class="perfil-menu">
        <a href="perfil.php">Ver perfil</a>
        <a href="editarPerfil.php">Editar nombre y foto</a>
        <a href="cambiarContrasena.php">Cambiar contraseña</a>
        <a href="logout.php">Cerrar sesión</a>
    </div>
</div>



</head>

<div>
    <a class="botonPerfil" href="cambiarNombre.php">perfil</a>
</div>

<body>

<!-- meuno de arriba (benvingut alum, mis clases etc.) -->
<div class="menu">
    <h2>Benvingut, <?php echo $nombre; ?> (<?php echo $rol; ?>)</h2>
    <ul>
        <li><a href="php/misclases.php">Mis clases</a></li>
        <?php if($rol == "profesor"): ?>
        <li><a href="clase/crearclase.html">Crear clase</a></li>
        <?php endif; ?>
        <li><a href="php/logout.php">Tancar sessió</a></li>
    </ul>

    <!-- formulario para que el alumno se una a una clase con el codigo-->
    <?php if($rol == "alumno"): ?>
    <form action="php/unirse.php" method="POST">
        <input type="text" name="codigo" placeholder="Códi de la classe" required>
        <input type="submit" value="Unir-se a la classe">
    </form>
    <?php endif; ?>
</div>



<h3>Les meves classes</h3>

<?php
include 'php/conexion.php'; // nos conectamos a la base de datos

if (!isset($_COOKIE['cookies_aceptadas'])) {
    $mostrarFooterCookies = true;
} else {
    $mostrarFooterCookies = false;
}

// Muestra las clases depende si eres profe o alumno
if($rol == 'alumno'){ 
    $alumno_id = $_SESSION['id'];
    $sql = "SELECT c.* FROM clases c
            INNER JOIN alumnos_clases ac ON c.id = ac.clase_id
            WHERE ac.alumno_id='$alumno_id'";
    $res = $conn->query($sql);
    echo "<div class='cuadrado-clases'>";
    while($clase = $res->fetch_assoc()){
        echo "<a class='clase' href='clases.php?id=".htmlspecialchars($clase['id'])."'>"
        .htmlspecialchars($clase['nombre']).
        "</a>";
    }
    echo "</div>";
}

if($rol == 'profesor'){
    $profesor_id = $_SESSION['id'];
    $sql = "SELECT * FROM clases WHERE profesor_id='$profesor_id'";
    $res = $conn->query($sql);
    echo "<div class='cuadrado-clases'>";
    while($clase = $res->fetch_assoc()){
        echo "<a class='clase' href='clases.php?id=".htmlspecialchars($clase['id'])."'>"
        .htmlspecialchars($clase['nombre']).
        "</a>";

    }
    echo "</div>";
}




$conn->close();
?>

<?php if ($mostrarFooterCookies): ?>
<footer style="
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
    background: #222;
    color: white;
    padding: 15px;
    text-align: center;
">
    Este sitio utiliza cookies para mejorar la experiencia.
    <form action="aceptarCookies.php" method="POST" style="display:inline;">
        <button class="botonAceptar" type="submit" style="margin-left:10px; padding:5px 10px;">Aceptar</button>
    </form>
    <form action="aceptarCookies.php" method="POST" style="display:inline;">
        <button class="botonAceptar" type="submit" style="margin-left:10px; padding:5px 10px;">Aceptar solo esenciales</button>
    </form>
    <form action="aceptarCookies.php" method="POST" style="display:inline;">
        <button class="botonRechazar" type="submit" style="margin-left:10px; padding:5px 10px;">Rechazar</button>
    </form>
</footer>
<?php endif; ?>

</body>
</html>