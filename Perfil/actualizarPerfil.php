<?php
require_once("../Funciones/funciones.php");
require '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable('../');
$dotenv->load();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['actualizarPerfil'])) {
        // Comprobación de cada variable. Si no existe o está vacía, se le asigna NULL.
        $nombre = isset($_POST['nombreUsuario']) && !empty($_POST['nombreUsuario']) ? $_POST['nombreUsuario'] : NULL;
        $apellido1 = isset($_POST['apellido1']) && !empty($_POST['apellido1']) ? $_POST['apellido1'] : NULL;
        $apellido2 = isset($_POST['apellido2']) && !empty($_POST['apellido2']) ? $_POST['apellido2'] : NULL;
        $tipoDocumento = isset($_POST['tipoDocumento']) && !empty($_POST['tipoDocumento']) ? $_POST['tipoDocumento'] : NULL;
        $valorDocumento = isset($_POST['numDocumento']) && !empty($_POST['numDocumento']) ? $_POST['numDocumento'] : NULL;
        $tipoVia = isset($_POST['tipoVia']) && !empty($_POST['tipoVia']) ? $_POST['tipoVia'] : NULL;
        $direccion = isset($_POST['direccionName']) && !empty($_POST['direccionName']) ? $_POST['direccionName'] : NULL;
        $codPostal = isset($_POST['codPostal']) && !empty($_POST['codPostal']) ? $_POST['codPostal'] : NULL;
        $municipio = isset($_POST['municipioName']) && !empty($_POST['municipioName']) ? $_POST['municipioName'] : NULL;
        $provincia = isset($_POST['codProvincia']) && !empty($_POST['codProvincia']) ? $_POST['codProvincia'] : NULL;
        $telefono = isset($_POST['telefono']) && !empty($_POST['telefono']) ? $_POST['telefono'] : NULL;
        $telefonoFijo = isset($_POST['telefonoFijo']) && !empty($_POST['telefonoFijo']) ? $_POST['telefonoFijo'] : NULL;
        
        // Forzar tipo booleano para las variables correspondientes
        $permisoConducir = isset($_POST['conducir']) ? (bool)$_POST['conducir'] : NULL;
        $vehiculoPropio = isset($_POST['vehiculo']) ? (bool)$_POST['vehiculo'] : NULL;
        $trabajando = isset($_POST['trabajando']) ? (bool)$_POST['trabajando'] : NULL;
        $viajar = isset($_POST['viajar']) ? (bool)$_POST['viajar'] : NULL;
        $incorporacion = isset($_POST['incorporacion']) && !empty($_POST['incorporacion']) ? $_POST['incorporacion'] : NULL;
        $disponibilidadHoraria = isset($_POST['disponibildadHoraria']) && !empty($_POST['disponibildadHoraria']) ? $_POST['disponibildadHoraria'] : NULL;
        $rangoSalarial = isset($_POST['rangoSalarial']) && !empty($_POST['rangoSalarial']) ? $_POST['rangoSalarial'] : NULL;
        //
        $idUsuario = $_POST['idUsuario'];    
       

        actualizarDatos(
            $nombre,
            $apellido1,
            $apellido2,
            $tipoDocumento,
            $valorDocumento,
            $tipoVia,
            $direccion,
            $codPostal,
            $municipio,
            $provincia,
            $telefono,
            $telefonoFijo,
            $permisoConducir,
            $vehiculoPropio,
            $trabajando,
            $viajar,           
            $incorporacion,
            $disponibilidadHoraria,
            $rangoSalarial,
            $idUsuario
        );
        header('Location: ./index.php');
    }
}
