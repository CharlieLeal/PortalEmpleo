<?php
require_once("../Funciones/funciones.php");
require '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable('../');
$dotenv->load();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['enviarFoto'])) {
        $id = $_POST['idUsuario'];
        
        $nombreDocumento = $_FILES['foto']['name'];
        $extension = '.' . pathinfo($nombreDocumento, PATHINFO_EXTENSION);
        $base64 = base64_encode(file_get_contents($_FILES['foto']['tmp_name']));

        $foto = actualizarFoto($id, $extension, $base64); 
        /* print_r($foto); */
        ?>
        <script>
            window.location.href = '../Perfil/index.php'
        </script>
<?php
    }
}
