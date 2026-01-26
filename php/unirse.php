<?php
session_start();
include 'conexion.php';

$alumno_id = $_SESSION['id']; // el que está logueado
?>

<h2>Unirse a clase</h2>
<form action="unirse.php" method="POST">
    <input type="text" name="codigo" placeholder="Escribe el código de la clase" required>
    <input type="submit" value="Unirse">
</form>

<?php
if(isset($_POST['codigo'])) {
    $codigo = $_POST['codigo'];

    // buscamos la clase por código
    $sql = "SELECT * FROM clases WHERE codigo='$codigo'";
    $res = $conn->query($sql);

    if($res->num_rows > 0) {
        $clase = $res->fetch_assoc();
        $clase_id = $clase['id'];

        // verificamos si ya está inscrito
        $check = "SELECT * FROM alumnos_clases WHERE alumno_id='$alumno_id' AND clase_id='$clase_id'";
        $res_check = $conn->query($check);

        if($res_check->num_rows == 0){
            // lo inscribimos
            $sql_insert = "INSERT INTO alumnos_clases (alumno_id, clase_id) VALUES ('$alumno_id', '$clase_id')";
            $conn->query($sql_insert);
            echo "<p style='color:green;'>Te uniste a la clase ".$clase['nombre']." ✅</p>";
        } else {
            echo "<p style='color:orange;'>Ya estás en esta clase 😅</p>";
        }
    } else {
        echo "<p style='color:red;'>Código incorrecto ❌</p>";
    }
}
?>
