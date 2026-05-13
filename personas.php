include 'conexion.php';

$clase_id = $_GET['id']; // id de la clase

$sql = "SELECT u.nombre, u.id 
        FROM usuarios u
        INNER JOIN alumnos_clases ac ON u.id = ac.alumno_id
        WHERE ac.clase_id = '$clase_id'";

$res = $conn->query($sql);