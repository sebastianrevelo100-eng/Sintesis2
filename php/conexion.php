<?php
$servername = "localhost"; #IP del servidor de la base de dades
$username = "root"; #Usuario de la base de dades
$password = ""; 
$dbname = "edumain"; #El nom de la base de dades



$conn = new mysqli($servername, $username, $password, $dbname); #Crea la conexio amb la base de dades



# Comprova si la conexio ha sigut exitosa, sino, mostra un error
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}


