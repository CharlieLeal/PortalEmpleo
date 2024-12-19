<?php
require_once("../Funciones/funciones.php");
require '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable('../');
$dotenv->load();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['aniadirHerramienta'])) {
        if (empty($_POST['utilName'])) { ?>
            <script>
                alert('No has añadido ninguna herramienta');
                window.location.href = './index.php#misHerramientas';
            </script>
        <?php } else {
            aniadirHerramienta($_POST['idUsuario'], $_POST['herramientaId'], $_POST['rangeInput']);            
        ?>
            <script>
                //alert('Herramienta añadido correctamente');
                window.location.href = './index.php#misHerramientas';
            </script>
        <?php
        }
    }
    if (isset($_POST['borrarButton'])) {
        borrarHerramienta($_POST['idUsuario'], $_POST['borrarButton']); ?>
        <script>
            //alert('Perfil eliminado correctamente');
            window.location.href = './index.php#misHerramientas';
        </script>
<?php }
}