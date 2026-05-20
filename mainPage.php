<?php
session_start();

// verificamos si el usuario no ha iniciado sesion, si no lo envia al login.html
if(!isset($_SESSION['id'])){
    header("Location: login.html");
    exit();
}

// Guardamos el nombre y rol del usuario para mostrar en la página
$nombre = $_SESSION['nombre'];
$rol = $_SESSION['rol'];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>EduMain - Pàgina principal</title>
    <link rel="stylesheet" href="mainPage.css">
    <link rel="icon" href="uploads/logo.png" type="image/png">
    <script>

        function togglePerfilMenu() {
            document.getElementById("perfilMenu").classList.toggle("show");
        }

    </script>

    <div class="perfil-container">

    <div id="perfilMenu" class="perfil-menu">
        <a href="perfil.php">Veure perfil</a>
        <a href="editarPerfil.php">Editar nom i foto</a>
        <a href="cambiarContrasena.php">Canviar contrasenya</a>
        <a href="logout.php">Tancar sessió</a>
    </div>
</div>

</head>

<body>

<!-- meuno de arriba (benvingut alum, mis clases etc.) -->
<div class="menu">
    <h2>Benvingut, <?php echo $nombre; ?> (<?php echo $rol; ?>)</h2>
    <ul>
        <?php if($rol == "profesor"): ?>
        <li><a href="clase/crearclase.html">Crear classe</a></li>
        <?php endif; ?>
        <li><a href="php/logout.php">Tancar sessió</a></li>
    </ul>

    <!-- formulario para que el alumno se una a una clase con el codigo-->
    <?php if($rol == "alumno"): ?>
    <form action="php/unirse.php" method="POST">
        <input type="text" name="codigo" placeholder="Codi de la classe" required>
        <input type="submit" value="Unir-se a la classe">
    </form>
    <?php endif; ?>
</div class="chatBot">

<script>
  window.addEventListener('mouseover', initLandbot, { once: true });
  window.addEventListener('touchstart', initLandbot, { once: true });
  var myLandbot;
  function initLandbot() {
    if (!myLandbot) {
      var s = document.createElement('script');
      s.type = "module"
      s.async = true;
      s.addEventListener('load', function() {
        var myLandbot = new Landbot.Livechat({
          configUrl: 'https://storage.googleapis.com/landbot.online/v3/H-3435081-D68MAJ7HAJZ2AW94/index.json',
          container: 'landbot-container'
        });
      });
      s.src = 'https://cdn.landbot.io/landbot-3/landbot-3.0.0.mjs';
      var x = document.getElementsByTagName('script')[0];
      x.parentNode.insertBefore(s, x);
    }
  }
</script>

</div>

<div class="perfilDiv">
    <a class="botonPerfil" href="perfil.php">Perfil</a>
</div>

<h3>Les meves classes</h3>

<?php
include 'php/conexion.php'; // nos conectamos a la base de datos

if (!isset($_COOKIE['cookies_aceptadas'])) {
    $mostrarFooterCookies = true;
} else {
    $mostrarFooterCookies = false;
}

// Muestra las clases depende si eres profe o alumno
if($rol == 'alumno'){
    $alumno_id = $_SESSION['id'];
    $sql = "SELECT c.* FROM clases c
            INNER JOIN alumnos_clases ac ON c.id = ac.clase_id
            WHERE ac.alumno_id='$alumno_id'";
    $res = $conn->query($sql);
    echo "<div class='cuadrado-clases'>";
    while($clase = $res->fetch_assoc()){
        echo "<a class='clase' href='clases.php?id=".htmlspecialchars($clase['id'])."'>"
        .htmlspecialchars($clase['nombre']).
        "</a>";
    }
    echo "</div>";
}

if($rol == 'profesor'){
    $profesor_id = $_SESSION['id'];
    $sql = "SELECT * FROM clases WHERE profesor_id='$profesor_id'";
    $res = $conn->query($sql);
    echo "<div class='cuadrado-clases'>";
    while($clase = $res->fetch_assoc()){
        echo "<a class='clase' href='clases.php?id=".htmlspecialchars($clase['id'])."'>"
        .htmlspecialchars($clase['nombre']).
        "</a>";

    }
    echo "</div>";
}

$conn->close();
?>

<?php if ($mostrarFooterCookies): ?>
<footer class="footerCookies">
    Aquest lloc utilitza cookies per millorar l'experiència.
    <form action="cookiesHandler.php" method="POST" style="display:inline;">
        <button  class="botonAceptar" type="submit" name="opcion" value="Aceptar">Acceptar</button>
    </form>

    <form action="cookiesHandler.php" method="POST" style="display:inline;">
        <button class="botonAceptarEsenc" type="submit" name="opcion" value="Aceptar esenciales">Acceptar només essencials</button>
    </form>

    <form action="cookiesHandler.php" method="POST" style="display:inline;">
        <button class="botonRechazar" type="submit" name="opcion" value="Rechazar">Rebutjar</button>
    </form>

   
    <details style="margin-top: 10px; padding: 10px; background: transparent; border-radius: 5px; width: 99%">
    <summary class="botonMasDeta">Més detalls</summary>
    <div class="content">
        <h4>Necessàries</h4>
        <p>
            Les cookies necessàries ajuden a fer que un lloc web sigui utilitzable permetent funcions bàsiques
            com la navegació per la pàgina i l'accés a àrees segures del lloc web.
            El lloc web no pot funcionar correctament sense aquestes cookies.
        </p>

        <h4>Estadístiques</h4>
        <p>
            Les cookies estadístiques ajuden els propietaris de llocs web a entendre com interactuen els visitants
            amb els llocs web mitjançant la recopilació i la presentació d'informació de manera anònima.
        </p>

        <h4>Preferències</h4>
        <p>
            Les cookies de preferències permeten que un lloc web recordi informació que canvia el comportament
            o l'aspecte del lloc web, com ara el vostre idioma preferit o la regió on us trobeu.
        </p>

        <h4>Màrqueting</h4>
        <p>
            Les cookies de màrqueting s'utilitzen per fer un seguiment dels visitants a través de llocs web.
            La intenció és mostrar anuncis que siguin rellevants i atractius per a l'usuari individual i,
            per tant, més valuosos per als editors i anunciants externs.
        </p>
    </div>
</details>

</footer>
<?php endif; ?>

</body>
</html>