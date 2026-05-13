<?php
session_start();
include "php/conexion.php";

$opcion = $_POST['opcion'];

setcookie("cookies_aceptadas", $opcion, time() + 10, "/");

if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];

    $sql = "UPDATE usuarios SET cookies = ?, horaCookies = NOW() WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $opcion, $id);
    $stmt->execute();
}

header("Location: mainPage.php");
exit;
?>