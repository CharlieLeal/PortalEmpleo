<?php
require_once("../Funciones/funciones.php");
require '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable('../');
$dotenv->load();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['aniadirAptitud'])) {
        if (!empty($_POST['nombreHabilidad'])) {
            $habilidad = $_POST['nombreHabilidad'];
           // echo $_POST['idUsuario'];
            aniadirHabilidad($_POST['idUsuario'], str_replace(" ", "%20", $habilidad)); ?>
            <script>
                window.location.href = './index.php#misHabilidades';
            </script>
<?php
        }
    }
    if (isset($_POST['borrarButton'])) {
        borrarHabilidad($_POST['idUsuario'], $_POST['borrarButton']); ?>
        <script>
            //alert('Estudio eliminado correctamente');
            window.location.href = './index.php#misHabilidades';
        </script>
<?php }
}
