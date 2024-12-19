<?php
require_once("../Funciones/funciones.php");
require '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable('../');
$dotenv->load();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['aniadirIdioma'])) {
        if (empty($_POST['idiomaName'])) { ?>
            <script>
                alert('No has añadido ningún idioma');
                window.location.href = './index.php';
            </script>
        <?php } else {
            aniadirIdioma($_POST['idUsuario'], $_POST['idIdioma'], $_POST['rangeInput'], $_POST['rangeInputEscrito'])
        ?>
            <script>
                //alert('Idioma añadido correctamente');
                window.location.href = './index.php#misIdiomas';
            </script>
        <?php
        }
    }
    if (isset($_POST['borrarButton'])) {
        borrarIdioma($_POST['idUsuario'], $_POST['borrarButton']); ?>
        <script>
            //alert('Idioma eliminado correctamente');
            window.location.href = './index.php#misIdiomas';
        </script>
<?php }
}
