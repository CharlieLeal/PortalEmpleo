<?php
require_once("../Funciones/funciones.php");
require '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable('../');
$dotenv->load();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['darAlta'])) {
        $pass1 = $_POST['passwd'];
        $pass2 = $_POST['passwdRepeat'];

        if ($pass1 != $pass2) { ?>
            <script>
                alert('Las contraseñas no coinciden');
                window.location.href = '../CrearCuenta/index.php';
            </script>
            <?php
        } else {
            $nombre = $_POST['Nombre'];
            $apellido1 = $_POST['ape1'];
            if (!empty($_POST['ape2'])) {
                $apellido2 = $_POST['ape2'];
            } else {
                $apellido2 = '';
            }
            $mail = $_POST['mail'];
            $telf = $_POST['telf'];            

            $darAlta = darAlta($nombre, $apellido1, $apellido2, $mail, $pass1,$telf);           

            if (isset($darAlta['error'])) { ?>
                <script>
                    alert(<?php echo json_encode($darAlta['error']); ?>);
                    window.location.href = './index.php';
                </script>
            <?php } else {
                setcookie("mailUsuario", $darAlta['email'], time() + (86400 * 30), "/",".agioglobal.com",true);
                setcookie("pwd", md5($pass1), time() + (86400 * 30), "/",".agioglobal.com",true);
            ?>
                <script>
                    alert('Cuenta creada correctamente');
                    window.location.href = '../Home/index.php';
                </script>
<?php }
        }
    }
}
