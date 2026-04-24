<?php
// iniciamos la sesion para usar las variables de usuario
session_start();
// traemos la conexion a la base de datos 
include 'php/conexion.php';

// verificamos si el usuario esta logeado, si no lo mandamos al login
if(!isset($_SESSION['id'])){
    header("Location: login.html");
    exit();
}

// obtenemos el id de la clase desde la url (clases.php?id=3)
$clase_id = $_GET['id'];
// buscamos la clase en la base de datos
$sql = "SELECT * FROM clases WHERE id='$clase_id'";
$res = $conn->query($sql);

// si existe la clase la guardamos en una variable
if($res && $res->num_rows > 0){
    $clase = $res->fetch_assoc();
} else {
    echo "clase no encontrada";
    exit();
}

// obtenemos cual pestaña esta seleccionada (si no existe mostramos anuncios por defecto)
$tab = $_GET['tab'] ?? 'anuncios';
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title><?php echo $clase['nombre']; ?></title>
<!-- cargamos el archivo css con los estilos de la pagina -->
<link rel="stylesheet" href="clases.css">
</head>
<body>

<!-- incluimos el menu desplegable de arriba -->
<?php include 'desplegable.php'; ?>

<div class="container">

<!-- mostramos el nombre de la clase -->
<h1 class="titulo-clase"><?php echo $clase['nombre']; ?></h1>
<!-- mostramos la descripcion de la clase -->
<p class="descripcion-clase"><?php echo $clase['descripcion']; ?></p>

<!-- las pestañas para navegar entre secciones -->
<div class="tabs">
    <a href="clases.php?id=<?php echo $clase_id; ?>&tab=anuncios">Anuncios</a>
    <a href="clases.php?id=<?php echo $clase_id; ?>&tab=actividades">Actividades</a>
    <a href="clases.php?id=<?php echo $clase_id; ?>&tab=entregas">Entregas</a>
    <a href="clases.php?id=<?php echo $clase_id; ?>&tab=personas">Personas</a>
</div>

<hr>

<?php
// pestaña de anuncios - mostrada por defecto
if($tab == "anuncios"){
    echo "<h2>Anuncios</h2>";
    echo "<p>Aqui puedes poner anuncios de la clase.</p>";
}

// pestaña de actividades - donde se cran y ven los deberes
if($tab == "actividades"){
    echo "<h2>Actividades</h2>";
    
    // si el usuario es profesor mostramos el formulario para crear deberes
    if($_SESSION['rol'] == "profesor"){
        echo '
        <h3>Crear nuevo deber</h3>
        <form class="form-deber" action="php/crear_deber.php" method="POST">
            <input type="hidden" name="clase_id" value="'.$clase_id.'">
            <input type="text" name="titulo" placeholder="Titulo del deber" required>
            <textarea name="descripcion" placeholder="Descripcion"></textarea>
            <input type="date" name="fecha_limite" required>
            <button type="submit">Crear deber</button>
        </form>
        <hr>
        ';
    }

    // traemos todos los deberes de esta clase ordenados por fecha
    $sql_deberes = "SELECT * FROM deberes WHERE clase_id='$clase_id' ORDER BY fecha_limite ASC";
    $res_deberes = $conn->query($sql_deberes);

    // mostramos cada deber en una tarjeta
    if($res_deberes && $res_deberes->num_rows > 0){
        while($deberes = $res_deberes->fetch_assoc()){
            echo "<div class='deber'>";
            echo "<h3>".htmlspecialchars($deberes['titulo'])."</h3>";
            echo "<p>".htmlspecialchars($deberes['descripcion'])."</p>";
            echo "<p>Fecha limite: ".$deberes['fecha_limite']."</p>";
            // boton para ir a entregar el archivo
            echo "<a class='boton-entregar' href='entregar.php?id=".$deberes['id']."&clase_id=".$clase_id."'>Entregar archivo</a>";
            echo "</div>";
        }
    } else {
        echo "<p>No hay actividades todavia.</p>";
    }
}

// pestaña personas - lista de gente en la clase
if($tab == "personas"){
    echo "<h2>Personas</h2>";
    echo "<p>Aqui puedes ver las personas que pertenecen a la clase.</p>";
}

// pestaña entregas - donde se ven los archivos entregados
if($tab == "entregas"){
    echo "<h2>Entregas</h2>";
    
    // si el usuario es profesor ve todas las entregas de todos
    if($_SESSION['rol'] == "profesor"){
        // traemos todas las entregas de esta clase con info del deber, alumno y archivo
        $sql_entregas = "SELECT e.*, d.titulo as deber_titulo, u.nombre as alumno_nombre 
                         FROM entregas e 
                         JOIN deberes d ON e.id_deberes = d.id 
                         JOIN usuarios u ON e.id_alumno = u.id 
                         WHERE d.clase_id='$clase_id' 
                         ORDER BY e.fecha_entrega DESC";
        $res_entregas = $conn->query($sql_entregas);
        
        // mostramos cada entrega
        if($res_entregas && $res_entregas->num_rows > 0){
            while($entrega = $res_entregas->fetch_assoc()){
                echo "<div class='deber'>";
                echo "<h3>Deber: " . $entrega['deber_titulo'] . "</h3>";
                echo "<p>Alumno: " . $entrega['alumno_nombre'] . "</p>";
                echo "<p>Fecha: " . $entrega['fecha_entrega'] . "</p>";
                // boton para descargar el archivo entregado
                echo "<a class='boton-entregar' href='php/descargar.php?id=" . $entrega['id'] . "'>Descargar archivo</a>";
                echo "</div>";
            }
        } else {
            echo "<p>No hay entregas todavia.</p>";
        }
    } else {
        // si es estudiante solo ve sus propias entregas
        $mi_id = $_SESSION['id'];
        // traemos solo las entregas del estudiante logeado
        $sql_mis_entregas = "SELECT e.*, d.titulo as deber_titulo
                             FROM entregas e
                             JOIN deberes d ON e.id_deberes = d.id
                             WHERE d.clase_id='$clase_id' AND e.id_alumno='$mi_id'
                             ORDER BY e.fecha_entrega DESC";
        $res_mis_entregas = $conn->query($sql_mis_entregas);
        
        // mostramos las entregas del estudiante
        if($res_mis_entregas && $res_mis_entregas->num_rows > 0){
            while($mi_entrega = $res_mis_entregas->fetch_assoc()){
                echo "<div class='deber'>";
                echo "<h3>Deber: " . $mi_entrega['deber_titulo'] . "</h3>";
                echo "<p>Tu entrega: " . $mi_entrega['fecha_entrega'] . "</p>";
                // boton para descargar su propio archivo
                echo "<a class='boton-entregar' href='php/descargar.php?id=" . $mi_entrega['id'] . "'>Descargar tu archivo</a>";
                echo "</div>";
            }
        } else {
            echo "<p>No has entregado nada todavia.</p>";
        }
    }
}
?>

<!-- boton para volver a la pagina principal -->
<a class="volver" href="mainPage.php">Volver al menu</a>

</div>

</body>
</html>
