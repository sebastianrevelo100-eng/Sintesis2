<?php
session_start();
include 'conexion.php';

// Comprobar que llegan los datos
if (isset($_POST['nombre']) && isset($_POST['correo']) && isset($_POST['contraseña']) && isset($_POST['rol'])) {

    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $contraseña = $_POST['contraseña'];
    $rol = $_POST['rol'];

    // Comprobar que no están vacíos
    if ($nombre == "" || $correo == "" || $contraseña == "" || $rol == "") {
        echo "Por favor completa todos los campos del formulario.";
        exit;
    }

    // Insertar usuario
    $sql = "INSERT INTO usuarios (nombre, correo, contraseña, rol) 
            VALUES ('$nombre', '$correo', '$contraseña', '$rol')";

    if ($conn->query($sql) === TRUE) {
        // Guardar sesión
        $_SESSION['id'] = $conn->insert_id;
        $_SESSION['nombre'] = $nombre;
        $_SESSION['rol'] = $rol;

        // Redirigir
        header("Location: ../mainPage.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }

} else {
    echo "Por favor completa todos los campos del formulario.";
}

$email = $_POST['email'];
$primeraLetra = strtoupper($email[0]); // Primera letra del correo

$fotoPerfil = null;

// Si el usuario sube una foto
if (!empty($_FILES['foto']['name'])) {
    $nombreFoto = time() . "_" . $_FILES['foto']['name'];
    move_uploaded_file($_FILES['foto']['tmp_name'], "uploads/perfiles/" . $nombreFoto);
    $fotoPerfil = $nombreFoto;
} else {
    // Si NO sube foto → generar imagen con la letra
    $imagen = imagecreatetruecolor(200, 200);
    $colorFondo = imagecolorallocate($imagen, 52, 152, 219); // azul
    $colorTexto = imagecolorallocate($imagen, 255, 255, 255); // blanco

    imagefill($imagen, 0, 0, $colorFondo);

    $fuente = __DIR__ . "/fonts/arial.ttf"; // pon una fuente en tu proyecto
    imagettftext($imagen, 100, 0, 60, 150, $colorTexto, $fuente, $primeraLetra);

    $nombreFoto = "letra_" . time() . ".png";
    imagepng($imagen, "uploads/perfiles/" . $nombreFoto);
    imagedestroy($imagen);

    $fotoPerfil = $nombreFoto;
}

// Guardar en la BD
$sql = "INSERT INTO usuarios (email, password, foto_perfil) 
        VALUES ('$email', '$passwordHash', '$fotoPerfil')";


$conn->close();
?>
