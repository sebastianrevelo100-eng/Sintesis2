<?php
session_start();
include 'php/conexion.php';

if(!isset($_SESSION['id'])){
    header("Location: login.html");
    exit();
}

$deber_id = $_GET['id'] ?? '';

// Aquesta pàgina mostra una activitat concreta.
// Explicació per a qui no sap programar:
// - Rebem un número que identifica la tasca (de l'enllaç).
// - Si aquest número no existeix, mostrem un missatge.
if(empty($deber_id)){
    echo "Activitat no trobada.";
    exit();
}

$sql = "SELECT d.*, c.nombre AS clase_nombre, u.nombre AS profesor_nombre
        FROM deberes d
        JOIN clases c ON d.clase_id = c.id
        JOIN usuarios u ON d.creada_por = u.id
        WHERE d.id = '$deber_id'";

$res = $conn->query($sql);

if(!$res || $res->num_rows === 0){
    echo "Activitat no trobada.";
    exit();
}

$deber = $res->fetch_assoc();
$clase_id = $deber['clase_id'];

$entrega_usuario = null;

if($_SESSION['rol'] !== 'profesor'){
    $sql_entrega = "SELECT * FROM entregas WHERE id_deberes='$deber_id' AND id_alumno='".$_SESSION['id']."' ORDER BY fecha_entrega DESC LIMIT 1";
    $res_entrega = $conn->query($sql_entrega);

    if($res_entrega && $res_entrega->num_rows > 0){
        $entrega_usuario = $res_entrega->fetch_assoc();
    }
}

$sql_entregas = "SELECT COUNT(*) AS total FROM entregas WHERE id_deberes='$deber_id'";
$res_count = $conn->query($sql_entregas);

$entregas_count = 0;

if($res_count && $res_count->num_rows > 0){
    $entregas_count = $res_count->fetch_assoc()['total'];
}

$basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($deber['titulo']); ?> - Activitat</title>
    <link rel="stylesheet" href="<?php echo $basePath; ?>/clases.css">
    <link rel="stylesheet" href="actividad.css">
    <link rel="icon" href="uploads/logo.png" type="image/png">
</head>
<body>

<div class="container">
    <a class="volver" href="<?php echo $basePath; ?>/clases.php?id=<?php echo $clase_id; ?>&tab=actividades">← Tornar a Activitats</a>

    <div class="actividad-detalle">
        <div class="actividad-header">
            <div>
                <h1><?php echo htmlspecialchars($deber['titulo']); ?></h1>
                <p><?php echo htmlspecialchars($deber['clase_nombre']); ?></p>

                <div class="actividad-meta">
                    <span class="meta-item">Data límit: <?php echo htmlspecialchars($deber['fecha_limite']); ?></span>
                    <span class="meta-item">Professor: <?php echo htmlspecialchars($deber['profesor_nombre']); ?></span>
                </div>
            </div>

            <div class="actividad-badge">Tasca</div>
        </div>

        <div class="actividad-main">

            <section class="actividad-contenido">
                <h2>Instruccions</h2>
                <p><?php echo nl2br(htmlspecialchars($deber['descripcion'])); ?></p>
            </section>

            <aside class="actividad-aside">

                <div class="actividad-card">
                    <h3>Estat de l'entrega</h3>

                    <?php if($_SESSION['rol'] === 'profesor'): ?>

                        <p>Total d'entregues: <?php echo $entregas_count; ?></p>

                        <a class="boton-verde" href="<?php echo $basePath; ?>/clases.php?id=<?php echo $clase_id; ?>&tab=entregas">Veure entregues</a>

                        <div style="margin-top:12px;">
                            <button id="btnEliminarClase" style="background:#c0392b; color:#fff; border:none; padding:8px 10px; border-radius:4px; cursor:pointer;">Eliminar classe</button>
                        </div>

                    <?php else: ?>

                        <?php if($entrega_usuario): ?>

                            <p>Última entrega: <?php echo htmlspecialchars($entrega_usuario['fecha_entrega']); ?></p>

                            <p>Fitxer: <?php echo htmlspecialchars($entrega_usuario['archivo_nombre']); ?></p>

                            <a class="boton-verde" href="<?php echo $basePath; ?>/entregar.php?id=<?php echo $deber_id; ?>&clase_id=<?php echo $clase_id; ?>">Reemplaçar entrega</a>

                        <?php else: ?>

                            <p>Encara no has entregat res.</p>

                            <a class="boton-verde" href="<?php echo $basePath; ?>/entregar.php?id=<?php echo $deber_id; ?>&clase_id=<?php echo $clase_id; ?>">Entregar tasca</a>

                        <?php endif; ?>

                    <?php endif; ?>
                </div>

            </aside>
        </div>
    </div>
</div>

</body>

<script>
document.getElementById('btnEliminarClase')?.addEventListener('click', function(){

    if(!confirm('Eliminar la classe i totes les seves activitats i entregues? Aquesta acció no es pot desfer.')) return;

    var claseId = <?php echo json_encode($clase_id); ?>;

    fetch('php/eliminar_clase.php', {
        method: 'POST',
        headers: {'Content-Type':'application/x-www-form-urlencoded'},
        body: 'clase_id=' + encodeURIComponent(claseId)
    })
    .then(r=>r.json())
    .then(j=>{

        if(j.success){
            alert('Classe eliminada correctament.');
            window.location.href = 'mainPage.php';
        } else {
            alert('Error: ' + (j.error || 'no esperado'));
        }

    }).catch(()=>{
        alert('Error de xarxa');
    });
});
</script>

</html>