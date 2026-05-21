<html>
    <head>
        <link rel="stylesheet" href="../codigoClase.css">
        <link rel="icon" href="uploads/logo.png" type="image/png">
    </head>
</html>

<?php
session_start();
include 'conexion.php';

# Si no ets professor no pots crear una classe
if(!isset($_SESSION['id']) || $_SESSION['rol'] != 'profesor'){
    die("<p class='error'>No tens permís per crear classes</p>");
}

# Comprova si les dades del formulari han arribat
if(isset($_POST['nombre'])){
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $profesor_id = $_SESSION['id'];

    # Genera un codi aleatori de 6 caràcters
    $codigo = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, 6);

    $sql = "INSERT INTO clases (nombre, descripcion, profesor_id, codigo)
            VALUES ('$nombre','$descripcion','$profesor_id','$codigo')";    

    if($conn->query($sql) === TRUE){
        echo "<div class='resultado'>";

        echo "<h2 class='success'>Classe creada!</h2>";
        echo "<div class='codigo-container'>";
        echo "<p class='codigo'>Codi: <strong id='codigoClase'>$codigo</strong></p>";
        echo "<button class='boton-copiar' onclick='copiarCodigo()'>Copiar</button>";
        echo "</div>";

        echo "<a class='boton-link' href='../clases.php?id=".$conn->insert_id."'>Anar a la classe</a>";
        echo "<a class='boton-link secundario' href='../mainPage.php'>Tornar al menú</a>";

        echo "</div>";
    } else {
        echo "<p class='error'>Error en crear la classe</p>";
    }

} else {
    echo "<p class='error'>Si us plau completa el formulari</p>";
}
?>
<script>
function copiarCodigo() {
    const codigo = document.getElementById("codigoClase").innerText;

    if (navigator.clipboard) {
        navigator.clipboard.writeText(codigo)
            .then(() => alert("Codi copiat: " + codigo))
            .catch(() => copiarFallback(codigo));
    } else {
        copiarFallback(codigo);
    }
}

function copiarFallback(texto) {
    const textarea = document.createElement("textarea");
    textarea.value = texto;
    document.body.appendChild(textarea);
    textarea.select();
    document.execCommand("copy");
    document.body.removeChild(textarea);

}
</script>