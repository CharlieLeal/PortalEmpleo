<?php
require_once("../Funciones/funciones.php");
require '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable('../');
$dotenv->load();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['aniadirPerfil'])) {
        if (empty($_POST['perfilName'])) { ?>
            <script>
                alert('No has añadido ningún perfil');
                window.location.href = './index.php';
            </script>
        <?php } else {
            $perfil = aniadirPerfil($_POST['idUsuario'], str_replace(' ', '%20', $_POST['perfilName']));            
        ?>
            <script>
                //alert('Perfil añadido correctamente');
                window.location.href = './index.php#sobreMi';
            </script>
        <?php
        }
    }
    if (isset($_POST['borrarButton'])) {
        borrarPerfil($_POST['idUsuario'], $_POST['borrarButton']); ?>
        <script>
            //alert('Perfil eliminado correctamente');
            window.location.href = './index.php#sobreMi';
        </script>
<?php }
}
