<?php
session_start();
header('Content-Type: application/json; charset=utf-8');
// Aquest fitxer s'encarrega d'eliminar una classe sencera.
// Per a persones no tècniques:
// - Només el professor que és propietari pot fer-ho.
// - Quan s'elimina una classe, s'esborren també les tasques, les entregues i la inscripció dels alumnes.
// - Aquesta acció no és reversible des d'aquí, així que hem de confirmar qui la demana.

if(!isset($_SESSION['id']) || ($_SESSION['rol'] ?? '') !== 'profesor'){
    // La persona ha d'estar identificada com a professor
    echo json_encode(['success' => false, 'error' => 'No autorizado']);
    exit();
}

include 'conexion.php';

$clase_id = $_POST['clase_id'] ?? null;
if(!$clase_id){
    // Ens hem d'assegurar que rebem l'identificador de la classe a eliminar
    echo json_encode(['success' => false, 'error' => 'Falta clase_id']);
    exit();
}
$clase_id = intval($clase_id);

// Comprobar que el profesor es el propietario de la clase
$stmt = $conn->prepare("SELECT profesor_id FROM clases WHERE id = ?");
if(!$stmt){ echo json_encode(['success'=>false,'error'=>'Error DB']); exit(); }
$stmt->bind_param('i', $clase_id);
$stmt->execute();
$res = $stmt->get_result();
if(!$res || $res->num_rows === 0){ echo json_encode(['success'=>false,'error'=>'Clase no encontrada']); exit(); }
$row = $res->fetch_assoc();
if(intval($row['profesor_id']) !== intval($_SESSION['id'])){
    echo json_encode(['success'=>false,'error'=>'No eres el profesor de esta clase']);
    exit();
}

// Borrado en transacción
try{
    $conn->begin_transaction();

    // 1) borrar entregas asociadas
    $stmt = $conn->prepare("DELETE e FROM entregas e JOIN deberes d ON e.id_deberes = d.id WHERE d.clase_id = ?");
    $stmt->bind_param('i', $clase_id);
    $stmt->execute();

    // 2) borrar deberes
    $stmt = $conn->prepare("DELETE FROM deberes WHERE clase_id = ?");
    $stmt->bind_param('i', $clase_id);
    $stmt->execute();

    // 3) borrar relaciones alumnos_clases
    $stmt = $conn->prepare("DELETE FROM alumnos_clases WHERE clase_id = ?");
    $stmt->bind_param('i', $clase_id);
    $stmt->execute();

    // 4) borrar la clase
    $stmt = $conn->prepare("DELETE FROM clases WHERE id = ?");
    $stmt->bind_param('i', $clase_id);
    $stmt->execute();

    $conn->commit();
    echo json_encode(['success' => true]);
} catch(Exception $e){
    $conn->rollback();
    echo json_encode(['success' => false, 'error' => 'Error al eliminar']);
}

?>
