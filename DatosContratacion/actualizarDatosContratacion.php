<?php
require_once("../Funciones/funciones.php");
require '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable('../');
$dotenv->load();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['actualizarDatosContratacion'])) {
        // Comprobación de cada variable. Si no existe o está vacía, se le asigna NULL.
        $fechaNacimiento = isset($_POST['fechaNacimiento']) && !empty($_POST['fechaNacimiento']) ? $_POST['fechaNacimiento'] : NULL;
        $nacionalidad = isset($_POST['nacionalidad']) && !empty($_POST['nacionalidad']) ? $_POST['nacionalidad'] : NULL;
        $fechaInicioPermisoTrabajo = isset($_POST['fechaInicioPermisoTrabajo']) && !empty($_POST['fechaInicioPermisoTrabajo']) ? $_POST['fechaInicioPermisoTrabajo'] : NULL;
        $fechaFinPermisoTrabajo = isset($_POST['fechaFinPermisoTrabajo']) && !empty($_POST['fechaFinPermisoTrabajo']) ? $_POST['fechaFinPermisoTrabajo'] : NULL;
        $lugarNacimiento = isset($_POST['lugarNacimiento']) && !empty($_POST['lugarNacimiento']) ? $_POST['lugarNacimiento'] : NULL;
        $fechaCaducidadDNI = isset($_POST['fechaCaducidadDNI']) && !empty($_POST['fechaCaducidadDNI']) ? $_POST['fechaCaducidadDNI'] : NULL;

        // Forzar tipo booleano para las variables correspondientes
        $nombreRepre = isset($_POST['nombreRepre']) && !empty($_POST['nombreRepre']) ? $_POST['nombreRepre'] : NULL;
        $nifRepre = isset($_POST['nifRepre']) && !empty($_POST['nifRepre']) ? $_POST['nifRepre'] : NULL;
        $tipoRepre = isset($_POST['tipoRepre']) && !empty($_POST['tipoRepre']) ? $_POST['tipoRepre'] : NULL;
        //
        $idUsuario = $_POST['idUsuario'];


        actualizarDatosContratacion($fechaNacimiento,$lugarNacimiento,$nacionalidad,$nombreRepre,$nifRepre,$tipoRepre,$fechaInicioPermisoTrabajo,$fechaFinPermisoTrabajo,$idUsuario,$fechaCaducidadDNI);
        header('Location: ./index.php');
    }
}
