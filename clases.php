<?php
// Iniciamos la sesión para poder usar $_SESSION
session_start();

// Aquesta pàgina mostra tota la informació d'una classe.
// Explicació per a no tècnics:
// - Veureu el nom i la descripció de la classe.
// - Hi ha pestanyes: Anuncis, Activitats, Entregues i Persones.
// - Segons si ets professor o alumne, podràs fer accions diferents (crear deures, posar notes, etc.).

// Incluimos la conexión a la base de datos
include 'php/conexion.php';

// Si el usuario NO ha iniciado sesión, lo mandamos al login
if(!isset($_SESSION['id'])){
    header("Location: login.html");
    exit();
}

// Guardamos el id de la clase que viene por la URL (clases.php?id=3)
$clase_id = $_GET['id'];

// Buscamos la clase en la base de datos
$sql = "SELECT * FROM clases WHERE id='$clase_id'";
$res = $conn->query($sql);

// Si existe la clase, guardamos sus datos
if($res && $res->num_rows > 0){
    $clase = $res->fetch_assoc();
} else {
    echo "classe no trobada";
    exit();
}

$tab = $_GET['tab'] ?? 'anuncios';
$basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo $clase['nombre']; ?></title>
        <link rel="stylesheet" href="<?php echo $basePath; ?>/clases.css">
        <link rel="icon" href="uploads/logo.png" type="image/png">
        </head>
<body>

<div class="container">

<h1 class="titulo-clase"><?php echo $clase['nombre']; ?></h1>
<p class="descripcion-clase"><?php echo $clase['descripcion']; ?></p>

<!-- PESTAÑAS -->
<div class="tabs">
    <a href="<?php echo $basePath; ?>/clases.php?id=<?php echo $clase_id; ?>&tab=anuncios">Anuncis</a>
    <a href="<?php echo $basePath; ?>/clases.php?id=<?php echo $clase_id; ?>&tab=actividades">Activitats</a>
    <a href="<?php echo $basePath; ?>/clases.php?id=<?php echo $clase_id; ?>&tab=entregas">Entregues</a>
    <a href="<?php echo $basePath; ?>/clases.php?id=<?php echo $clase_id; ?>&tab=personas">Persones</a>

    <button id="btnEliminarClase" style="background:#c0392b; color:#fff; border:none; padding: 8px 10px; border-radius:4px; cursor:pointer; position: absolute; top: 40px; right: 120px;">Eliminar classe</button>
    

</div>


<hr>

<?php
// =========================
//      PESTAÑA ANUNCIOS
// =========================
if($tab == "anuncios"){
    echo "<h2 class='titulo-seccion'>Anuncis</h2>";

    // FORMULARIO PROFESOR
    if($_SESSION['rol'] == "profesor"){
        echo '
        <div class="anuncio-form-container">
            <h3 class="subtitulo">Crear anunci</h3>
            <form class="anuncio-form" action="php/crearAnuncio.php" method="POST">
                <input type="hidden" name="clase_id" value="'.$clase_id.'">
                
                <input class="input-anuncio" type="text" name="titulo" placeholder="Títol de l\'anunci" required>
                
                <textarea class="textarea-anuncio" name="descripcion" placeholder="Descripció de l\'anunci" required></textarea>
                
                <button class="btn-anuncio" type="submit">Publicar anunci</button>
            </form>
        </div>
        <hr>
        ';
    }

    // MOSTRAR ANUNCIOS
    $sql_anuncios = "SELECT * FROM anuncios WHERE clase_id='$clase_id' ORDER BY fecha DESC";
    $res_anuncios = $conn->query($sql_anuncios);

    echo "<div class='lista-anuncios'>";

    if($res_anuncios && $res_anuncios->num_rows > 0){
        while($anuncio = $res_anuncios->fetch_assoc()){
            echo "
            <div class='anuncio-card'>
                <div class='anuncio-header'>
                    <h3 class='anuncio-titulo'>".htmlspecialchars($anuncio['titulo'])."</h3>
                    <span class='anuncio-fecha'>".$anuncio['fecha']."</span>
                </div>

                <p class='anuncio-descripcion'>".htmlspecialchars($anuncio['descripcion'])."</p>
            </div>
            ";
        }
    } else {
        echo "<p class='sin-anuncios'>Encara no hi ha anuncis.</p>";
    }

    echo "</div>";
}

// =========================
//      PESTAÑA ACTIVIDADES
// =========================
if($tab == "actividades"){

    echo "<h2>Activitats</h2>";

    if($_SESSION['rol'] == "profesor"){
        echo '
        <h3>Crear nou deure</h3>
        <form class="form-deber" action="php/crear_deber.php" method="POST">
            <input type="hidden" name="clase_id" value="'.$clase_id.'">
            <input type="text" name="titulo" placeholder="Títol del deure" required>
            <textarea name="descripcion" placeholder="Descripció"></textarea>
            <input type="date" name="fecha_limite" required>
            <button type="submit">Crear deure</button>
        </form>
        <hr>
        ';
    }

    $sql_deberes = "SELECT * FROM deberes WHERE clase_id='$clase_id' ORDER BY fecha_limite ASC";
    $res_deberes = $conn->query($sql_deberes);

    if($res_deberes && $res_deberes->num_rows > 0){
        while($deberes = $res_deberes->fetch_assoc()){
            echo "<div class='actividad-card'>";
            echo "<div class='actividad-card-header'>";
            echo "<div><h3>".htmlspecialchars($deberes['titulo'])."</h3>";
            echo "<p class='actividad-tipo'>Tasca</p></div>";
            echo "<span class='actividad-fecha'>Data límit: ".$deberes['fecha_limite']."</span>";
            echo "</div>";
            echo "<p>".htmlspecialchars($deberes['descripcion'])."</p>";
            echo "<div class='actividad-card-footer'>";
            echo "<a class='botonVerAct' href='" . $basePath . "/actividad.php?id=" . $deberes['id'] . "'>Veure activitat</a>";
            echo "</div>";
            echo "</div>";
        }
    } else {
        echo "<p>Encara no hi ha activitats.</p>";
    }
}

// =========================
//      PESTAÑA PERSONAS
// =========================
if($tab == "personas"){
    echo "<h2>Persones</h2>";

    $sql_profe = "SELECT nombre, correo FROM usuarios
              WHERE id = (SELECT profesor_id FROM clases WHERE id='$clase_id')";

    $res_profe = $conn->query($sql_profe);

    if($res_profe && $res_profe->num_rows > 0){
        $profe = $res_profe->fetch_assoc();

        echo "<h3>Professor</h3>";
        echo "<p class='persona profe'>" . htmlspecialchars($profe['nombre']) .
            " (" . htmlspecialchars($profe['correo']) . ")" .
            "</p>";
}

    $sql_alumnos = "SELECT u.id as alumno_id, u.nombre, u.correo
                    FROM usuarios u
                    INNER JOIN alumnos_clases ac ON u.id = ac.alumno_id
                    WHERE ac.clase_id='$clase_id'";

    $res_alumnos = $conn->query($sql_alumnos);

    echo "<h3>Alumnes</h3>";

    if($res_alumnos && $res_alumnos->num_rows > 0){
        echo "<div class='lista-personas'>";
        
        while($alumno = $res_alumnos->fetch_assoc()){
            echo "<div class='persona' style='display:flex; align-items:center; justify-content:space-between;'>";
            echo "<div>" . htmlspecialchars($alumno['nombre']) . " (" . htmlspecialchars($alumno['correo']) . ")</div>";
            if($_SESSION['rol'] === 'profesor'){
                echo "<div><button style='background:#e74c3c;color:#fff;border:none;padding:6px 8px;border-radius:4px;cursor:pointer;' onclick=\"eliminarAlumno('" . $clase_id . "','" . $alumno['alumno_id'] . "')\">Eliminar</button></div>";
            }
            echo "</div>";
        }

        echo "</div>";
    } else {
        echo "<p>No hi ha alumnes en aquesta classe.</p>";
    }
}

// =========================
//      PESTAÑA ENTREGAS
// =========================
if($tab == "entregas"){
    echo "<h2>Entregues</h2>";
    
    if($_SESSION['rol'] == "profesor"){
        $sql_entregas = "SELECT e.*, d.id AS deber_id, d.titulo as deber_titulo, u.nombre as alumno_nombre 
                         FROM entregas e 
                         JOIN deberes d ON e.id_deberes = d.id 
                         JOIN usuarios u ON e.id_alumno = u.id 
                         WHERE d.clase_id='$clase_id' 
                         ORDER BY d.id, e.fecha_entrega DESC";
    } else {
        $alumno_id = intval($_SESSION['id']);
        $sql_entregas = "SELECT e.*, d.id AS deber_id, d.titulo as deber_titulo, u.nombre as alumno_nombre 
                         FROM entregas e 
                         JOIN deberes d ON e.id_deberes = d.id 
                         JOIN usuarios u ON e.id_alumno = u.id 
                         WHERE d.clase_id='$clase_id' AND e.id_alumno='$alumno_id' 
                         ORDER BY d.id, e.fecha_entrega DESC";
    }

    $res_entregas = $conn->query($sql_entregas);
    
    if($res_entregas && $res_entregas->num_rows > 0){
        $entregas_por_deber = [];
        while($entrega = $res_entregas->fetch_assoc()){
            $deber_id = $entrega['deber_id'];
            if(!isset($entregas_por_deber[$deber_id])){
                $entregas_por_deber[$deber_id] = [
                    'titulo' => $entrega['deber_titulo'],
                    'entregas' => []
                ];
            }
            $entregas_por_deber[$deber_id]['entregas'][] = $entrega;
        }
        
        foreach($entregas_por_deber as $deber){
            echo "<div class='actividad-card' style='margin-bottom:20px;'>";
            echo "<h3>Activitat: " . htmlspecialchars($deber['titulo']) . "</h3>";
            foreach($deber['entregas'] as $entrega){
                echo "<div class='entrega-item' style='position:relative; padding:14px 140px 14px 14px; border:1px solid #ccc; border-radius:8px; margin-top:10px; background:#fafafa;'>";
                echo "<p><strong>Alumne:</strong> " . htmlspecialchars($entrega['alumno_nombre']) . "</p>";
                echo "<p><strong>Data:</strong> " . htmlspecialchars($entrega['fecha_entrega']) . "</p>";
                $nota_text = $entrega['nota'] !== null && $entrega['nota'] !== '' ? htmlspecialchars($entrega['nota']) : 'Sense nota';
                echo "<p><strong>Nota:</strong> " . $nota_text . "</p>";
                echo "<a class='boton-entregar' href='" . $basePath . "/php/descargar.php?id=" . $entrega['id'] . "'>Descarregar fitxer</a>";
                if($_SESSION['rol'] === 'profesor'){
                    $nota_val = isset($entrega['nota']) ? $entrega['nota'] : '';
                    echo "<div style='position:absolute; right:10px; top:10px;'>";
                    echo "<button class='btn-poner-nota' onclick=\"openNota('" . $entrega['id'] . "', '" . htmlspecialchars($nota_val) . "')\">Posar nota</button>";
                    echo "</div>";
                }
                echo "</div>";
            }
            echo "</div>";
        }
    } else {
        echo "<p>Encara no hi ha entregues.</p>";
    }
}
?>

<a class="volver" href="mainPage.php">Tornar al menú</a>

</div>

<div id="notaModal" style="display:none; position:fixed; left:0; top:0; width:100%; height:100%; background:rgba(0,0,0,0.5);">
    <div style="background:#fff; padding:20px; max-width:360px; margin:80px auto; border-radius:6px; position:relative;">
        <h3>Posar nota</h3>
        <form id="formNota">
            <input type="hidden" name="entrega_id" id="entrega_id">
            <label>Nota (0-10):</label>
            <input type="number" step="0.01" min="0" max="10" name="nota" id="nota_input" required>
            <div style="margin-top:10px; display:flex; gap:8px; justify-content:flex-end;">
                <button type="button" onclick="closeNota()">Cancel·lar</button>
                <button type="submit">Desar</button>
            </div>
        </form>
        <button onclick="closeNota()" style="position:absolute; right:8px; top:8px;">×</button>
    </div>
</div>

<script>
function openNota(entregaId, nota){
    document.getElementById('entrega_id').value = entregaId;
    document.getElementById('nota_input').value = nota || '';
    document.getElementById('notaModal').style.display = 'block';
}
function closeNota(){
    document.getElementById('notaModal').style.display = 'none';
}
document.getElementById('formNota').addEventListener('submit', function(e){
    e.preventDefault();
    var form = e.target;
    var data = new FormData(form);
    fetch('php/guardar_nota.php', {method:'POST', body:data})
    .then(r => r.json())
    .then(j => {
        if(j.success){
            alert('Nota desada');
            location.reload();
        } else {
            alert('Error: ' + (j.error || 'no esperado'));
        }
    }).catch(err=>{ alert('Error de xarxa'); });
});

function eliminarAlumno(claseId, alumnoId){
    if(!confirm('Eliminar aquest alumne de la classe?')) return;
    var body = 'clase_id=' + encodeURIComponent(claseId) + '&alumno_id=' + encodeURIComponent(alumnoId);
    fetch('php/eliminar_alumno.php', {
        method: 'POST',
        headers: {'Content-Type':'application/x-www-form-urlencoded'},
        body: body
    }).then(r=>r.json()).then(j=>{
        if(j.success){
            alert('Alumne eliminat de la classe');
            location.reload();
        } else {
            alert('Error: ' + (j.error || 'no esperado'));
        }
    }).catch(()=>{ alert('Error de xarxa'); });
}

document.getElementById('btnEliminarClase')?.addEventListener('click', function(){
    if(!confirm('Eliminar la classe i totes les seves activitats i entregues? Aquesta acció no es pot desfer.')) return;
    var claseId = <?php echo json_encode($clase_id); ?>;
    fetch('php/eliminar_clase.php', {
        method: 'POST',
        headers: {'Content-Type':'application/x-www-form-urlencoded'},
        body: 'clase_id=' + encodeURIComponent(claseId)
    }).then(r=>r.json()).then(j=>{
        if(j.success){
            alert('Classe eliminada correctament.');
            window.location.href = 'mainPage.php';
        } else {
            alert('Error: ' + (j.error || 'no esperado'));
        }
    }).catch(()=>{ alert('Error de xarxa'); });
});
</script>

</body>
</html>