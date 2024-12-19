<?php
require_once("../Funciones/funciones.php");
require '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable('../');
$dotenv->load();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['cambioMailButton'])) {
        $idUsuario = $_POST['idUsuario'];
        $nuevoMail = $_POST['cambioMail'];
        $cambiarMail = cambiarMail($idUsuario, $nuevoMail);

        if (isset($cambiarMail['error'])) { ?>
            <script>
                alert('<?php echo $cambiarMail['error']; ?>');
                window.location.href = './index.php';
            </script>
        <?php } else {
            setcookie("mailUsuario", $nuevoMail, time() + (86400 * 30), "/",".agioglobal.com",true);
            setcookie("empleado", $nuevoMail, time() + (86400 * 30), "/",".agioglobal.com",true);
            header('Location: ./index.php');
        }
    }

    if (isset($_POST['cambioPassButton'])) {
        $idUsuario = $_POST['idUsuario'];
        $nuevaPass = $_POST['cambioPass'];
        $cambiarPass = cambiarPass($idUsuario, $nuevaPass);

        if (isset($cambiarPass['error'])) { ?>
            <script>
                alert('<?php echo $cambiarPass['error']; ?>');
                window.location.href = './index.php';
            </script>
        <?php } else {
            setcookie("pwd", md5($nuevaPass), time() + (86400 * 30), "/",".agioglobal.com",true); ?>
            <script>
                alert('Contraseña cambiada correctamente');
                window.location.href = './index.php';
            </script>
<?php }
    }
}
