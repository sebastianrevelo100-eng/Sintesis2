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
<link rel="icon" href="uploads/logo.png" type="image/png">
<h2 class="textoMiPerfil">El meu perfil</h2>
<div class="container">
<!-- EDITAR NOMBRE Y CORREO -->
<h3>Editar dades</h3>
<form action="perfil.php" method="POST">
    <input class="inputNombre" type="text" name="nombre" value="<?php echo $user['nombre']; ?>" required>
    <input class="inputCorreo" type="email" name="correo" value="<?php echo $user['correo']; ?>" required>
    <button type="submit" name="actualizarPerfil">Desar canvis</button>
</form>

<hr>

<!-- CAMBIAR CONTRASEÑA -->
<h3>Canviar contrasenya</h3>
<form action="perfil.php" method="POST">
    <input type="password" name="actual" placeholder="Contrasenya actual" required>
    <input type="password" name="nueva" placeholder="Nova contrasenya" required>
    <button type="submit" name="cambiarPassword">Canviar contrasenya</button>
</form>

<hr>

<a href="mainPage.php">Tornar</a>

</div>

<?php
if(isset($_POST['actualizarPerfil'])){
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];

    $sql = "UPDATE usuarios
            SET nombre='$nombre', correo='$correo'
            WHERE id='$id'";

    if($conn->query($sql)){
        $_SESSION['nombre'] = $nombre;
        echo "<p>Dades actualitzades</p>";
    } else {
        echo "Error: " . $conn->error;
    }
}

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
            echo "<script>alert('Contrasenya actualitzada');</script>";
        } else {
            echo "<script>alert('Contrasenya incorrecta');</script>";
        }

    } else {
        echo "<p>Contrasenya incorrecta</p>";
    }
}
?>