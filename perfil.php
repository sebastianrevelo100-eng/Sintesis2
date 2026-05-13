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

<h2>Mi perfil</h2>

<!-- 🔹 EDITAR NOMBRE Y CORREO -->
<h3>Editar datos</h3>
<form action="perfil.php" method="POST">
    <input class="inputNombre" type="text" name="nombre" value="<?php echo $user['nombre']; ?>" required>
    <input class="inputCorreo" type="email" name="correo" value="<?php echo $user['correo']; ?>" required>
    <button type="submit" name="actualizarPerfil">Guardar cambios</button>
</form>

<hr>

<!-- 🔐 CAMBIAR CONTRASEÑA -->
<h3>Cambiar contraseña</h3>
<form action="perfil.php" method="POST">
    <input type="password" name="actual" placeholder="Contraseña actual" required>
    <input type="password" name="nueva" placeholder="Nueva contraseña" required>
    <button type="submit" name="cambiarPassword">Cambiar contraseña</button>
</form>

<hr>

<a href="mainPage.php">Volver</a>

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

    $sql = "SELECT contrasena FROM usuarios WHERE id='$id'";
    $res = $conn->query($sql);
    $user = $res->fetch_assoc();

    if($actual == $user['contrasena']){

        $sqlUpdate = "UPDATE usuarios 
                      SET contrasena='$nueva' 
                      WHERE id='$id'";

        if($conn->query($sqlUpdate)){
            echo "<p>Contraseña actualizada</p>";
        } else {
            echo "Error al actualizar";
        }

    } else {
        echo "<p>Contraseña incorrecta</p>";
    }
}
?>