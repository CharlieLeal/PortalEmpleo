<?php
require_once("../Funciones/funciones.php");
require '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable('../');
$dotenv->load();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['aniadirExperiencia'])) {
        $empresa = isset($_POST['empresa']) && !empty(trim($_POST['empresa'])) ? $_POST['empresa'] : NULL;

        // Puesto
        $puesto = isset($_POST['puesto']) && !empty(trim($_POST['puesto'])) ? $_POST['puesto'] : NULL;

        // Fecha desde
        $fechaDesde = isset($_POST['fechaDesde']) && !empty($_POST['fechaDesde']) ? $_POST['fechaDesde'] : NULL;

        // Actualmente trabajando
        $actualmente = isset($_POST['actualmente']) ? ($_POST['actualmente'] === 'Sí' ? true : false) : NULL;

        // Fecha hasta (solo si no está trabajando actualmente)
        $fechaFin = isset($_POST['fechaFIn']) && !empty($_POST['fechaFIn']) && $actualmente === 'No' ? $_POST['fechaFIn'] : NULL;

        // Tecnologías usadas
        $tecnologias = isset($_POST['tecnologias']) && !empty(trim($_POST['tecnologias'])) ? $_POST['tecnologias'] : NULL;

        // Descripción del puesto
        $descripcion = isset($_POST['descripcion']) && !empty(trim($_POST['descripcion'])) ? $_POST['descripcion'] : NULL;

        $salario = isset($_POST['salario']) && !empty(trim($_POST['salario'])) ? $_POST['salario'] : NULL;

        aniadirExperiencia($empresa, $puesto, $fechaDesde, $actualmente, $fechaFin, $tecnologias, $descripcion, $salario, $_POST['idUsuario']);

        // Validación adicional o guardar los datos en la base de datos
?>
        <script>
            // alert('Estudio añadido correctamente');
            window.location.href = './index.php#misExperiencias';
        </script>
    <?php
    }

    if (isset($_POST['actualizarExperiencia'])) {
        $empresa = isset($_POST['empresa2']) && !empty(trim($_POST['empresa2'])) ? $_POST['empresa2'] : NULL;

        // Puesto
        $puesto = isset($_POST['puesto2']) && !empty(trim($_POST['puesto2'])) ? $_POST['puesto2'] : NULL;

        // Fecha desde
        $fechaDesde = isset($_POST['fechaDesde2']) && !empty($_POST['fechaDesde2']) ? $_POST['fechaDesde2'] : NULL;

        // Actualmente trabajando
        $actualmente = isset($_POST['actualmente2']) ? ($_POST['actualmente2'] === 'Sí' ? true : false) : NULL;

        // Fecha hasta (solo si no está trabajando actualmente)
        $fechaFin = isset($_POST['fechaFIn2']) && !empty($_POST['fechaFIn2']) && $actualmente === 'No' ? $_POST['fechaFIn2'] : NULL;

        // Tecnologías usadas
        $tecnologias = isset($_POST['tecnologias2']) && !empty(trim($_POST['tecnologias2'])) ? $_POST['tecnologias2'] : NULL;

        // Descripción del puesto
        $descripcion = isset($_POST['descripcion2']) && !empty(trim($_POST['descripcion2'])) ? $_POST['descripcion2'] : NULL;

        $salario = isset($_POST['salario2']) && !empty(trim($_POST['salario2'])) ? $_POST['salario2'] : NULL;

        actualizarExperiencias($empresa, $puesto, $fechaDesde, $actualmente, $fechaFin, $tecnologias, $descripcion, $salario, $_POST['idUsuario2']);
    ?>
        <script>
            // alert('Estudio añadido correctamente');
            window.location.href = './index.php#misExperiencias';
        </script>
    <?php
    }

    if (isset($_POST['borrarButtonExperiencias'])) {
        print_r(borrarExperiencias($_POST['idUsuario2']));
    ?>
        <script>
            //alert('Estudio eliminado correctamente');
            window.location.href = './index.php#misExperiencias';
        </script>
    <?php }
    if (isset($_POST['aniadirReferencia'])) {
        $nombreReferencia = isset($_POST['nombreReferencia']) && !empty(trim($_POST['nombreReferencia'])) ? $_POST['nombreReferencia'] : NULL;

        $puestoReferencia = isset($_POST['puestoReferencia']) && !empty(trim($_POST['puestoReferencia'])) ? $_POST['puestoReferencia'] : NULL;

        $mailReferencia = isset($_POST['mailReferencia']) && !empty(trim($_POST['mailReferencia'])) ? $_POST['mailReferencia'] : NULL;

        $idExperiencia = $_POST['idExperiencia'];


       aniadirReferencia($nombreReferencia, $puestoReferencia, $mailReferencia, $idExperiencia); ?>
        <script>
            //alert('Estudio eliminado correctamente');
            window.location.href = './index.php#misExperiencias';
        </script>
    <?php
    }
    if (isset($_POST['borrarReferencia'])) {

        borrarReferencia(str_replace(' ', '', $_POST['idExperiencia']), str_replace(' ', '', $_POST['borrarReferencia'])); ?>
        <script>
            //alert('Estudio eliminado correctamente');
            window.location.href = './index.php#misExperiencias';
        </script>
<?php
    }
}
