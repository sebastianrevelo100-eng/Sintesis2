<?php
// iniciamos la sesión para usar variables de sesión
session_start();

// recibimos el id del deber y de la clase por GET
$id_deberes = $_GET['id'];
$clase_id = $_GET['clase_id'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <!-- esto es para que se vea bien en caracteres especiales -->
    <meta charset="UTF-8">
    <!-- para que se vea bien en móviles (responsive) -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- el título de la pestaña -->
    <title>Entregar deber - EduMain</title>
    <!-- importamos el CSS -->
    <link rel="stylesheet" href="entregar.css">
</head>
<body>


    <!-- contenedor principal con el formulario -->
    <div class="container-entregar">
        <!-- el título -->
        <h2>Subir entrega</h2>

        <!-- formulario para enviar el archivo -->
        <form action="php/subir_entrega.php" method="POST" enctype="multipart/form-data">
            <!-- estos campos no se ven pero se envían con el formulario -->
            <input type="hidden" name="id_deberes" value="<?php echo $id_deberes; ?>">
            <input type="hidden" name="clase_id" value="<?php echo $clase_id; ?>">
            
            <!-- input para seleccionar el archivo -->
            <input type="file" name="archivo" required>
            
            <!-- botón para enviar -->
            <button type="submit">Subir entrega</button>
        </form>
    </div>

</body>
</html>
