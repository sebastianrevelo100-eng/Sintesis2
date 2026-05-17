<?php
session_start();
header('Content-Type: application/json; charset=utf-8');
// Aquest fitxer guarda la nota que el professor introdueix.
// Explicació per a persones no tècniques:
// - El professor introdueix una nota i el navegador envia aquesta dada aquí.
// - Aquí comprovem que qui fa això és un professor i que la nota és vàlida.
// - Si tot és correcte, guardem la nota i retornem un missatge d'èxit.

// Comprovacions bàsiques
if(!isset($_SESSION['id']) || ($_SESSION['rol'] ?? '') !== 'profesor'){
    // Si la persona no està identificada com a professor, no permetem l'acció.
    echo json_encode(['success' => false, 'error' => 'No autorizado']);
    exit();
}

include 'conexion.php';

$entrega_id = $_POST['entrega_id'] ?? null;
$nota = $_POST['nota'] ?? null;

if(!$entrega_id || $nota === null){
    echo json_encode(['success' => false, 'error' => 'Faltan parametros']);
    exit();
}

if(!is_numeric($nota)){
    echo json_encode(['success' => false, 'error' => 'Nota no válida']);
    exit();
}

$nota = floatval($nota);
if($nota < 0 || $nota > 10){
    echo json_encode(['success' => false, 'error' => 'Nota fuera de rango']);
    exit();
}

$entrega_id = intval($entrega_id);

$stmt = $conn->prepare("UPDATE entregas SET nota = ? WHERE id = ?");
if(!$stmt){
    echo json_encode(['success' => false, 'error' => 'Error en la consulta']);
    exit();
}
$stmt->bind_param('di', $nota, $entrega_id);
$ok = $stmt->execute();

if($ok){
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'No se pudo guardar']);
}

?>
