<?php
// Iniciamos la sesión para poder usar $_SESSION
session_start();

// Incluimos la conexión a la base de datos
include 'php/conexion.php';

// Si el usuario NO ha iniciado sesión, lo mandamos al login
if(!isset($_SESSION['id'])){
    header("Location: login.html");
    exit();
}

// Guardamos el id de la clase que viene por la URL (clases.php?id=3)
$clase_id = $_GET['id'];

// Buscamos la clase en la base de datos
$sql = "SELECT * FROM clases WHERE id='$clase_id'";
$res = $conn->query($sql);

// Si existe la clase, guardamos sus datos
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
<link rel="stylesheet" href="clases.css">
</head>
<body>

<?php include 'desplegable.php'; ?>

<div class="container">

<h1 class="titulo-clase"><?php echo $clase['nombre']; ?></h1>
<p class="descripcion-clase"><?php echo $clase['descripcion']; ?></p>

<!-- PESTAÑAS -->
<div class="tabs">
    <a href="clases.php?id=<?php echo $clase_id; ?>&tab=anuncios">Anuncios</a>
    <a href="clases.php?id=<?php echo $clase_id; ?>&tab=actividades">Actividades</a>
    <a href="clases.php?id=<?php echo $clase_id; ?>&tab=entregas">Entregas</a>
    <a href="clases.php?id=<?php echo $clase_id; ?>&tab=personas">Personas</a>
</div>

<hr>

<?php
// =========================
//      PESTAÑA ANUNCIOS
// =========================
if($tab == "anuncios"){
    echo "<h2>Anuncios</h2>";
    echo "<p>Aquí puedes poner anuncios de la clase.</p>";
}

// =========================
//      PESTAÑA ACTIVIDADES
// =========================
if($tab == "actividades"){

    echo "<h2>Actividades</h2>";

    // Si el usuario es profesor, mostramos el formulario para crear deberes
    if($_SESSION['rol'] == "profesor"){
        echo '
        <h3>Crear nuevo deber</h3>
        <form class="form-deber" action="php/crear_deber.php" method="POST">
            <input type="hidden" name="clase_id" value="'.$clase_id.'">
            <input type="text" name="titulo" placeholder="Título del deber" required>
            <textarea name="descripcion" placeholder="Descripción"></textarea>
            <input type="date" name="fecha_limite" required>
            <button type="submit">Crear deber</button>
        </form>
        <hr>
        ';
    }

    // Mostrar los deberes
    $sql_deberes = "SELECT * FROM deberes WHERE clase_id='$clase_id' ORDER BY fecha_limite ASC";
    $res_deberes = $conn->query($sql_deberes);

    if($res_deberes && $res_deberes->num_rows > 0){
        while($deberes = $res_deberes->fetch_assoc()){
            echo "<div class='deber'>";
            echo "<h3>".htmlspecialchars($deberes['titulo'])."</h3>";
            echo "<p>".htmlspecialchars($deberes['descripcion'])."</p>";
            echo "<p>Fecha límite: ".$deberes['fecha_limite']."</p>";
            echo "<a class='boton-entregar' href='entregar.php?id=".$deberes['id']."&clase_id=".$clase_id."'>Entregar archivo</a>";
            echo "</div>";
        }
    } else {
        echo "<p>No hay actividades todavía.</p>";
    }
}

// =========================
//      PESTAÑA PERSONAS
// =========================
if($tab == "personas"){
    echo "<h2>Personas</h2>";
    echo "<p>Aquí puedes ver las personas que pertenecen a la clase.</p>";
}

// =========================
//      PESTAÑA ENTREGAS
// =========================
if($tab == "entregas"){
    echo "<h2>Entregas</h2>";
    
    if($_SESSION['rol'] == "profesor"){
        // aqui mostramos las entregas
        $sql_entregas = "SELECT e.*, d.titulo as deber_titulo, u.nombre as alumno_nombre 
                         FROM entregas e 
                         JOIN deberes d ON e.id_deberes = d.id 
                         JOIN usuarios u ON e.id_alumno = u.id 
                         WHERE d.clase_id='$clase_id' 
                         ORDER BY e.fecha_entrega DESC";
        $res_entregas = $conn->query($sql_entregas);
        
        if($res_entregas && $res_entregas->num_rows > 0){
            while($entrega = $res_entregas->fetch_assoc()){
                echo "<div class='deber'>";
                echo "<h3>Deber: " . $entrega['deber_titulo'] . "</h3>";
                echo "<p>Alumno: " . $entrega['alumno_nombre'] . "</p>";
                echo "<p>Fecha: " . $entrega['fecha_entrega'] . "</p>";
                echo "<a class='boton-entregar' href='php/descargar.php?id=" . $entrega['id'] . "'>Descargar archivo</a>";
                echo "</div>";
            }
        } else {
            echo "<p>No hay entregas todavia.</p>";
        }
    } else {
        echo "<p>No puedes ver esto.</p>";
    }
}
?>

<a class="volver" href="mainPage.php">Volver al menú</a>

</div>

</body>
</html>
