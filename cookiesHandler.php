<?php
session_start();
include "php/conexion.php"; 


$opcion = $_POST['opcion'];


setcookie("cookies_aceptadas", $opcion, time() + 10, "/"); //reinicia el footer de les cookies als 10 segons


if (isset($_SESSION['id'])) { //agafa el id de la sessió
    $id = $_SESSION['id'];

    $sql = "UPDATE usuarios SET cookies = ? WHERE id = ?"; //actualiza la taula de cookies a la base de dades
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $opcion, $id);
    $stmt->execute();
}

header("Location: mainPage.php");
exit;
?>

