<?php
require_once("../Funciones/funciones.php");
require '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable('../');
$dotenv->load();

// Asegúrate de que la cabecera de contenido esté configurada para JSON
header('Content-Type: application/json');

if (isset($_GET['codPostal'])) {
    $codPostal = $_GET['codPostal'];
    $provincias = provincias($codPostal);

    // Verificar si se obtuvo un resultado y devolverlo en JSON
    if ($provincias) {
        echo json_encode($provincias);
    } else {
        echo json_encode(['error' => 'No se encontraron provincias para el código postal proporcionado.']);
    }
    exit();
} else {
    echo json_encode(['error' => 'No se ha proporcionado el código postal']);
    exit();
}

function provincias($codigoPostal) {
    $curl = curl_init();
    $token = getToken($_COOKIE['mailUsuario'], $_COOKIE['pwd']);

    if ($_ENV['MODE'] == "development") {
        $url = $_ENV['ENDPOINT_URL_D'];
    } else {
        $url = $_ENV['ENDPOINT_URL_P'];
    }

    curl_setopt_array($curl, array(
        CURLOPT_URL => $url . 'Codpostal/' . $codigoPostal . '/Provincia',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer ' . $token['token']
        ),
    ));

    $response = curl_exec($curl);
    if ($response === false) {
        // Maneja el error de CURL
        return [];
    }

    // Verifica que la respuesta esté bien formada
    $idResult = json_decode($response, true);
    curl_close($curl);
    return $idResult ?: [];
}
?>
