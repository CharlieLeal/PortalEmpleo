<?php
require_once("../Funciones/funciones.php");
require '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable('../');
$dotenv->load();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['enviarCV'])) {
        $id = $_POST['idUsuario'];
        $nombreDocumento = $_FILES['cv']['name'];
        $extension = '.' . pathinfo($nombreDocumento, PATHINFO_EXTENSION);
        $base64 = base64_encode(file_get_contents($_FILES['cv']['tmp_name']));

        enviarCV($id, $nombreDocumento, $extension, $base64);

?>
        <script>
            //alert('CV actualizado');
            window.location.href = '../Perfil/index.php';
        </script>
<?php
    }
}
