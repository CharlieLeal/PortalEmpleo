<?php
require_once("../Funciones/funciones.php");
require '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable('../');
$dotenv->load();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['submit'])) {
        $usuario = infoUsuario($_POST['user']);
        print_r($usuario);
       
        if (isset($usuario['error'])) { ?>
            <script>
                alert('El usuario introducido no pertenece a ningún usuario válido');
                window.location.href = './resetPassword.php';
            </script>
        <?php } else {
            $mandarPass = mandarNuevaPass($usuario['idUsuarioPortalEmpleo']);
            header('Location: ./login.php');
        }
    } //de if 
}
