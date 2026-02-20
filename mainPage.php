<?php
session_start(); 

// verificamos si el usuario no ha iniciado sesion, si no lo envia al login.html
if(!isset($_SESSION['id'])){
    header("Location: login.html");
    exit();
}

// Guardamos el nombre y rol del usuario para mostrar en la página
$nombre = $_SESSION['nombre'];
$rol = $_SESSION['rol'];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>EduMain - Página principal</title>
    <link rel="stylesheet" href="mainPage.css">
    <script ></script>
</head>
<body>

<!-- meuno de arriba (benvingut alum, mis clases etc.) -->
<div class="menu">
    <h2>Benvingut, <?php echo $nombre; ?> (<?php echo $rol; ?>)</h2>
    <ul>
        <li><a href="php/misclases.php">Mis clases</a></li>
        <?php if($rol == "profesor"): ?>
        <li><a href="clase/crearclase.html">Crear clase</a></li>
        <?php endif; ?>
        <li><a href="php/logout.php">Tancar sessió</a></li>
    </ul>

    <div class=archivo>
        <form action="" method="POST" enctype="multipart/form-data">
            <input type="file" name="archivo" required>
            <button type="submit" name="subir">Subir y procesar</button>
        </form>
    </div>

    <!-- formulario para que el alumno se una a una clase con el codigo-->
    <?php if($rol == "alumno"): ?>
    <form action="php/unirse.php" method="POST">
        <input type="text" name="codigo" placeholder="Códi de la classe" required>
        <input type="submit" value="Unir-se a la classe">
    </form>
    <?php endif; ?>
</div>

<h3>Les meves classes</h3>

<?php
include 'php/conexion.php'; // nos conectamos a la base de datos


// texto de prueba con print
$output = shell_exec('"backend\script.py"');
echo "<pre>$output</pre>";


//subir archivos

if(isset($_POST['subir'])){

        $nombreArchivo = time() . "_" . basename($_FILES['archivo']['name']);
        $rutaPython = "C:\\Users\\oriol\\AppData\\Local\\Programs\\Python\\Python314\\python.exe";
        $rutaScript = __DIR__ . "\\backend\\upload.py";
        $rutaArchivo = __DIR__ . "\\uploads\\test.txt";
        $rutaDestino = __DIR__ . "/uploads/" . $nombreArchivo;
    

        $comando = "\"$rutaPython\" \"$rutaScript\" " . escapeshellarg($rutaArchivo);

        $output = shell_exec($comando . " 2>&1");

    echo "<pre>$output</pre>";

    if(move_uploaded_file($_FILES['archivo']['tmp_name'], $rutaDestino)){

        // Ejecutar Python pasándole el archivo
        $output = shell_exec("py backend/upload.py" . escapeshellarg($rutaDestino) . " 2>&1");

        echo "<pre>$output</pre>";

    } else {
        echo "Error al subir el archivo";
    }   
}



// Muestra las clases depende si eres profe o alumno
if($rol == 'alumno'){
    $alumno_id = $_SESSION['id'];
    $sql = "SELECT c.* FROM clases c
            INNER JOIN alumnos_clases ac ON c.id = ac.clase_id
            WHERE ac.alumno_id='$alumno_id'";
    $res = $conn->query($sql);
    echo "<div class='cuadrado-clases'>";
    while($clase = $res->fetch_assoc()){
        echo "<div class='clase'>";
        echo "<a href='clases.php?id=".htmlspecialchars($clase['id'])."'>".htmlspecialchars($clase['nombre'])."</a>";
        echo "</div>";
    }
    echo "</div>";
} 



if($rol == 'profesor'){
    $profesor_id = $_SESSION['id'];
    $sql = "SELECT * FROM clases WHERE profesor_id='$profesor_id'";
    $res = $conn->query($sql);
    echo "<div class='cuadrado-clases'>";
    while($clase = $res->fetch_assoc()){
        echo "<div class='clase'>";
        echo "<a href='clases.php?id=".htmlspecialchars($clase['id'])."'>".htmlspecialchars($clase['nombre'])."</a>";
        echo "</div>";
    }
    echo "</div>";
}

$conn->close();
?>

</body>
</html>