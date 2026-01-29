<?php
session_start();

if(!isset($_SESSION['id'])){
    header("Location: login.html");
    exit();
}

$nombre = $_SESSION['nombre'];
$rol = $_SESSION['rol'];
?>


<!-- uri revisa la mainpage -->
<!-- karma restaurant -->



<!DOCTYPE html>
    <html>

    <head>
        <meta charset="UTF-8">
        <title>EduMain - Página principal</title>
        <link rel="stylesheet" href="mainPage.css">
    </head>
        <body>

        <!-- cabezera -->
        <div class="menu">
            <h2>Benvingut, <?php echo $nombre; ?> (<?php echo $rol; ?>)</h2>

            <ul>
        <li><a href="php/misclases.php">Mis clases</a></li>
        <?php if($rol == "profesor"): ?>
        <li><a href="clase/crearclase.html">Crear clase</a></li>
        <?php endif; ?>
        <li><a href="php/logout.php">Tancar sessió</a></li>
        </ul>

        <?php if($rol == "alumno"): ?>

        <form action="php/unirse.php" method="POST">
            <input type="text" name="codigo" placeholder="Códi de la classe" required>
            <input type="submit" value="Unir-se a la classe">
        </form>

        <?php endif; ?>
        </div> <!-- fin cabezera -->

        <!-- bloque de clases separado abajo -->
        <div class="clases">
        <h3>Les meves classes</h3>

        <?php
        include 'php/conexion.php';

        // mostrar las clases del usuario
        if($rol == 'alumno'){
            $alumno_id = $_SESSION['id'];
            $sql = "SELECT c.* FROM clases c
                    INNER JOIN alumnos_clases ac ON c.id = ac.clase_id
                    WHERE ac.alumno_id='$alumno_id'";
            $res = $conn->query($sql);
            while($clase = $res->fetch_assoc()){
                echo "<p><a href='clases.php?id=".$clase['id']."'>".$clase['nombre']."</a></p>";
            }
        }

        if($rol == 'profesor'){
            $profesor_id = $_SESSION['id'];
            $sql = "SELECT * FROM clases WHERE profesor_id='$profesor_id'";
            $res = $conn->query($sql);
            while($clase = $res->fetch_assoc()){
                echo "<p><a href='clases.php?id=".$clase['id']."'>".$clase['nombre']."</a></p>";
            }
        }

        $conn->close();
        ?>






        </body>
    </html>
