<?php
session_start();
header('Content-Type: application/json; charset=utf-8');


# Comprovacions bàsiques
if(!isset($_SESSION['id']) || ($_SESSION['rol'] ?? '') !== 'profesor'){
    # Si la persona no està identificada com a professor, no permetem l'acció.
    echo json_encode(['success' => false, 'error' => 'No autorizado']);
    exit();
}

include 'conexion.php';

$entrega_id = $_POST['entrega_id'] ?? null;
$nota = $_POST['nota'] ?? null;


# Si deixa la nota buida, torna error
if(!$entrega_id || $nota === null){
    echo json_encode(['success' => false, 'error' => 'Faltan parametros']);
    exit();
}

# Si posa una nota que no sigui un numero, torna error
if(!is_numeric($nota)){
    echo json_encode(['success' => false, 'error' => 'Nota no válida']);
    exit();
}

# Si la nota esta fora del rang 0 - 10, torna error
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
