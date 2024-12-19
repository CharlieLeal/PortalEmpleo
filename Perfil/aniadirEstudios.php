<?php
require_once("../Funciones/funciones.php");
require '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable('../');
$dotenv->load();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['aniadirEstudio'])) {
        if (!empty($_POST['especialidadName'])) {
            $especialidad = $_POST['especialidadName'];
        } else if (isset($_POST['especialidadNameSelect'])) {
            $especialidad = $_POST['especialidadNameSelect'];
        }
        if ($especialidad == "" && empty($especialidad)) {
            $especialidad = null;
        }

        $fechaInicio = $_POST['fechaInicioEstudio'];
        $fechaFin = $_POST['fechaFinEstudio'];

        if($fechaFin == ''){
            $fechaFin = null;
        }
        else{
            $fechaFin = $fechaFin;
        }

        aniadirEstudios($_POST['idUsuario'], $_POST['estudioId'], $especialidad,$fechaInicio,$fechaFin);
?>
        <script>
           // alert('Estudio añadido correctamente');
            window.location.href = './index.php#misEstudios';
        </script>
    <?php
    }
    if (isset($_POST['borrarButton'])) {
        borrarEstudios($_POST['idUsuario'], $_POST['borrarButton']); ?>
        <script>
            //alert('Estudio eliminado correctamente');
            window.location.href = './index.php#misEstudios';
        </script>
<?php }
}
