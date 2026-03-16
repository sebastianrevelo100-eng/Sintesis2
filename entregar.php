<?php
session_start();
$id_deberes = $_GET['id'];
$clase_id = $_GET['clase_id']; // ← AÑADIDO
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Entregar deber</title>
</head>
<body>

<h2>Subir entrega</h2>

<form action="php/subir_entrega.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id_deberes" value="<?php echo $id_deberes; ?>">
    <input type="hidden" name="clase_id" value="<?php echo $clase_id; ?>"> <!-- ← AÑADIDO -->
    <input type="file" name="archivo" required>
    <button type="submit">Subir entrega</button>
</form>

</body>
</html>
