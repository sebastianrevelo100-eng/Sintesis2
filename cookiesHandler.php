<?php
session_start();
include "php/conexion.php";

$rawOpcion = isset($_POST['opcion']) ? trim((string)$_POST['opcion']) : null;

$opcionesValidas = [
    'Aceptar' => 'aceptar',
    'Aceptar esenciales' => 'aceptar_esenciales',
    'Rechazar' => 'rechazar',
];

if ($rawOpcion === null || !isset($opcionesValidas[$rawOpcion])) {
    if (!headers_sent()) {
        header("Location: mainPage.php");
        exit;
    } else {
        echo '<script>location.href="mainPage.php";</script>';
        exit;
    }
}

$opcion = $opcionesValidas[$rawOpcion];

$cookie_lifetime = 86400 * 30; // 30 días
$cookieDomain = explode(':', $_SERVER['HTTP_HOST'], 2)[0];
setcookie("cookies_aceptadas", $opcion, [
    'expires' => time() + $cookie_lifetime,
    'path' => '/',
    'domain' => $cookieDomain,
    'secure' => false,
    'httponly' => false,
    'samesite' => 'Lax',
]);

$_COOKIE['cookies_aceptadas'] = $opcion;

if (isset($_SESSION['id'])) {
    $id = (int)$_SESSION['id'];

    $sql = "UPDATE usuarios SET cookies = ?, horaCookies = NOW() WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("si", $opcion, $id);
        $stmt->execute();
        $stmt->close();
    } else {
        error_log("DB prepare failed in cookiesHandler.php: " . $conn->error);
    }
}

if (!headers_sent()) {
    header("Location: mainPage.php");
    exit;
} else {
    echo '<script>location.href="mainPage.php";</script>';
    exit;
}
?>