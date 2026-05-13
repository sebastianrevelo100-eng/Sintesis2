<html>
    <link rel="stylesheet" href="../php/crearclase.css">
</html>

<?php
session_start();
include 'conexion.php';

// si no eres profe no puedes crear una clase
if(!isset($_SESSION['id']) || $_SESSION['rol'] != 'profesor'){
    die("<p class='error'>No tienes permiso para crear clases</p>");
}

// si llegaron los datos del formulario
if(isset($_POST['nombre'])){
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $profesor_id = $_SESSION['id'];

    // codigo de 6 letras y numeros
    $codigo = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, 6);

    $sql = "INSERT INTO clases (nombre, descripcion, profesor_id, codigo)
            VALUES ('$nombre','$descripcion','$profesor_id','$codigo')";    

    if($conn->query($sql) === TRUE){
        echo "<div class='resultado'>";

        echo "<h2 class='success'>Clase creada!</h2>";
        echo "<div class='codigo-container'>";
        echo "<p class='codigo'>Código: <strong id='codigoClase'>$codigo</strong></p>";
        echo "<button class='boton-copiar' onclick='copiarCodigo()'>Copiar</button>";
        echo "</div>";

        echo "<a class='boton-link' href='../clases.php?id=".$conn->insert_id."'>Ir a la clase</a>";
        echo "<a class='boton-link secundario' href='../mainPage.php'>Volver al menú</a>";

        echo "</div>";
    } else {
        echo "<p class='error'>Error al crear clase</p>";
    }

} else {
    echo "<p class='error'>Por favor completa el formulario</p>";
}
?>
<script>
function copiarCodigo() {
    const codigo = document.getElementById("codigoClase").innerText;

    navigator.clipboard.writeText(codigo).then(() => {
        alert("Código copiado: " + codigo);
    }).catch(err => {
        console.error("Error al copiar:", err);
    });
}
</script>