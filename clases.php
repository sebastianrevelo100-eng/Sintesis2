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

<?php if($_SESSION['rol'] == "profesor"): ?>
    <h2>Crear nuevo deber</h2>
    <form action="php/crear_deber.php" method="POST">
        <input type="hidden" name="clase_id" value="<?php echo $clase_id; ?>">
        <input type="text" name="titulo" placeholder="Título del deber" required>
        <textarea name="descripcion" placeholder="Descripción"></textarea>
        <input type="date" name="fecha_limite" required>
        <button type="submit">Crear deber</button>
    </form>
    <hr>
<?php endif; ?>

<h2>Deberes de esta clase</h2>

<?php
$sql_deberes = "SELECT * FROM deberes WHERE clase_id='$clase_id' ORDER BY fecha_limite ASC";
$res_deberes = $conn->query($sql_deberes);

if($res_deberes->num_rows > 0){
    while($deberes = $res_deberes->fetch_assoc()){
        echo "<div class='deber'>";
        echo "<h3>".htmlspecialchars($deberes['titulo'])."</h3>";
        echo "<p>".htmlspecialchars($deberes['descripcion'])."</p>";
        echo "<p>Fecha límite: ".$deberes['fecha_limite']."</p>";
        echo "<a href='entregar.php?id=".$deberes['id']."&clase_id=".$clase_id."'>Entregar archivo</a>";
        echo "</div><hr>";
    }
} else {
    echo "<p>No hay deberes en esta clase.</p>";
}
?>

<a href="mainPage.php">volver al menu</a>

</body>
</html>
