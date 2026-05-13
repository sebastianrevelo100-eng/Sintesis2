<?php
session_start();
include 'php/conexion.php';

if(!isset($_SESSION['id'])){
    header("Location: login.html");
    exit();
}

$id = $_SESSION['id'];

// datos actuales
$sql = "SELECT nombre, correo FROM usuarios WHERE id='$id'";
$res = $conn->query($sql);
$user = $res->fetch_assoc();
?>

<link rel="stylesheet" href="perfil.css">
<h2 class="textoMiPerfil">Mi perfil</h2>
<div class="container">
<!-- 🔹 EDITAR NOMBRE Y CORREO -->
<h3>Editar datos</h3>
<form action="perfil.php" method="POST">
    <input class="inputNombre" type="text" name="nombre" value="<?php echo $user['nombre']; ?>" required>
    <input class="inputCorreo" type="email" name="correo" value="<?php echo $user['correo']; ?>" required>
    <button type="submit" name="actualizarPerfil">Guardar cambios</button>
</form>

<hr>

<!-- CAMBIAR CONTRASEÑA -->
<h3>Cambiar contraseña</h3>
<form action="perfil.php" method="POST">
    <input type="password" name="actual" placeholder="Contraseña actual" required>
    <input type="password" name="nueva" placeholder="Nueva contraseña" required>
    <button type="submit" name="cambiarPassword">Cambiar contraseña</button>
</form>

<hr>

<a href="mainPage.php">Volver</a>

</div>

<?php
// ========================
// ACTUALIZAR PERFIL
// ========================
if(isset($_POST['actualizarPerfil'])){
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];

    $sql = "UPDATE usuarios 
            SET nombre='$nombre', correo='$correo' 
            WHERE id='$id'";

    if($conn->query($sql)){
        $_SESSION['nombre'] = $nombre;
        echo "<p>Datos actualizados</p>";
    } else {
        echo "Error: " . $conn->error;
    }
}

// ========================
// CAMBIAR CONTRASEÑA
// ========================
if(isset($_POST['cambiarPassword'])){
    $actual = $_POST['actual'];
    $nueva = $_POST['nueva'];

    $sql = "SELECT contraseña FROM usuarios WHERE id='$id'";
    $res = $conn->query($sql);
    $user = $res->fetch_assoc();

    if($actual == $user['contraseña']){

        $sqlUpdate = "UPDATE usuarios 
                      SET contraseña='$nueva' 
                      WHERE id='$id'";

        if($conn->query($sqlUpdate)){
            echo "<script>alert('Contraseña actualizada');</script>";
        } else {
            echo "<script>alert('Contraseña incorrecta');</script>";
        }

    } else {
        echo "<p>Contraseña incorrecta</p>";
    }
}
?>