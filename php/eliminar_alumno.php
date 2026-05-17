<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

// Aquest fitxer treu un alumne d'una classe (només la seva inscripció).
// Explicació senzilla:
// - No esborrem l'usuari del sistema, només fem que deixi de pertànyer a aquesta classe.
// - Només el professor responsable pot fer aquesta acció.

if(!isset($_SESSION['id']) || ($_SESSION['rol'] ?? '') !== 'profesor'){
    echo json_encode(['success' => false, 'error' => 'No autorizado']);
    exit();
}

include 'conexion.php';

$clase_id = $_POST['clase_id'] ?? null;
$alumno_id = $_POST['alumno_id'] ?? null;
if(!$clase_id || !$alumno_id){
    // Ens calen l'id de la classe i l'id de l'alumne per poder eliminar la relació
    echo json_encode(['success' => false, 'error' => 'Faltan parametros']);
    exit();
}

$clase_id = intval($clase_id);
$alumno_id = intval($alumno_id);

// Comprobar que el profesor es el propietario de la clase
$stmt = $conn->prepare("SELECT profesor_id FROM clases WHERE id = ?");
$stmt->bind_param('i', $clase_id);
$stmt->execute();
$res = $stmt->get_result();
if(!$res || $res->num_rows === 0){ echo json_encode(['success'=>false,'error'=>'Clase no encontrada']); exit(); }
$row = $res->fetch_assoc();
if(intval($row['profesor_id']) !== intval($_SESSION['id'])){
    echo json_encode(['success'=>false,'error'=>'No eres el profesor de esta clase']);
    exit();
}

// Borrar relación alumno-clase
$stmt = $conn->prepare("DELETE FROM alumnos_clases WHERE clase_id = ? AND alumno_id = ?");
if(!$stmt){ echo json_encode(['success'=>false,'error'=>'Error DB']); exit(); }
$stmt->bind_param('ii', $clase_id, $alumno_id);
$ok = $stmt->execute();

if($ok){
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'No se pudo eliminar']);
}

?>
