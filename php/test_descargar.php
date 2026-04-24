<?php
$ruta = "../uploads/Monitoritzacio-de-sistemes-Linux.pdf";

echo realpath($ruta) . "<br>";
echo file_exists($ruta) ? "EXISTE" : "NO EXISTE";
