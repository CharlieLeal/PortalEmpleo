<?php
require_once("../Funciones/funciones.php");
require '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable('../');
$dotenv->load();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['aniadirUrl'])) {
        if (empty($_POST['url'])) { ?>
            <script>
                alert('No has añadido ninguna URL');
                window.location.href = './index.php';
            </script>
        <?php } else {
            $url = aniadirUrl($_POST['idUsuario'], urlencode($_POST['url']));
        ?>
            <script>
                //alert('Perfil añadido correctamente');
                window.location.href = './index.php#miUrl';
            </script>
        <?php
        }
    }
    if (isset($_POST['borrarButtonUrl'])) {
        borrarUrl($_POST['idUsuario'], $_POST['borrarButtonUrl']); ?>
        <script>
            //alert('Perfil eliminado correctamente');
            window.location.href = './index.php#miUrl';
        </script>
<?php }
}
