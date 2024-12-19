<?php
require_once("../Funciones/funciones.php");
require '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable('../');
$dotenv->load();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['inscripcion'])) {
        $idUsario = $_POST['idUsuario'];
        $idOferta = $_POST['idOferta'];
        $inscripcion = inscribirseAOferta($idUsario, $idOferta);

        if (isset($inscripcion['error'])) { ?>
            <script>
                alert('Ya estabas inscrito en esta oferta');
                window.location.href = '../Home/index.php';
            </script>
        <?php
        } else { ?>
            <script>
                alert('Te has inscrito en la oferta correctamente');
                window.location.href='../MisCandidaturas/index.php';
            </script>
<?php
        }
    }
}
