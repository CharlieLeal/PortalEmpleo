<?php

require '../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable('../');
$dotenv->load();

/* FUNCIONES GLOBALES */

function getToken($usuario, $passwd)
{
    if ($_ENV['MODE'] == 'development') {
        $url = $_ENV['ENDPOINT_URL_D'] . 'getToken';
    } else {
        $url = $_ENV['ENDPOINT_URL_P'] . 'getToken';
    }
    $ch = curl_init($url);

    //setup request to send json via POST
    $data = array(
        "userName" => $usuario,
        "password" => $passwd,
    );

    $payload = json_encode($data);


    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

    //set the content type to application/json
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

    //return response instead of outputting
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

    curl_setopt($ch, CURLOPT_ENCODING, "");

    //execute the POST request
    $result = curl_exec($ch);
    $idResult = json_decode($result, true);
    //print_r($idResult);
    return $idResult;
}

function getIniciales($nombre)
{
    $iniciales = explode(" ", $nombre);
    return $iniciales[0][0] . $iniciales[1][0];
}

function quitarAcentos($cadena)
{
    $acentos = array(
        'á',
        'é',
        'í',
        'ó',
        'ú',
        'Á',
        'É',
        'Í',
        'Ó',
        'Ú',
        'à',
        'è',
        'ì',
        'ò',
        'ù',
        'À',
        'È',
        'Ì',
        'Ò',
        'Ù',
        'ä',
        'ë',
        'ï',
        'ö',
        'ü',
        'Ä',
        'Ë',
        'Ï',
        'Ö',
        'Ü',
        'â',
        'ê',
        'î',
        'ô',
        'û',
        'Â',
        'Ê',
        'Î',
        'Ô',
        'Û',
        'ã',
        'õ',
        'Ã',
        'Õ',
        'å',
        'Å',
        'æ',
        'Æ',
        'ç',
        'Ç',
        'ø',
        'Ø',
        'œ',
        'Œ',
        'ñ',
        'Ñ',
        'ü',
        'Ü'
    );
    $sin_acentos = array(
        'a',
        'e',
        'i',
        'o',
        'u',
        'A',
        'E',
        'I',
        'O',
        'U',
        'a',
        'e',
        'i',
        'o',
        'u',
        'A',
        'E',
        'I',
        'O',
        'U',
        'a',
        'e',
        'i',
        'o',
        'u',
        'A',
        'E',
        'I',
        'O',
        'U',
        'a',
        'e',
        'i',
        'o',
        'u',
        'A',
        'E',
        'I',
        'O',
        'U',
        'a',
        'o',
        'A',
        'O',
        'a',
        'A',
        'ae',
        'AE',
        'c',
        'C',
        'o',
        'O',
        'oe',
        'OE',
        'n',
        'N',
        'u',
        'U'
    );

    return str_replace($acentos, $sin_acentos, $cadena);
}

function mandarNuevaPass($id)
{
    $curl = curl_init();
    $token = getToken('portalempleado', 'zV.8d5<dV72w');

    if ($_ENV['MODE'] == "development") {
        $url = $_ENV['ENDPOINT_URL_D'];
    } else {
        $url = $_ENV['ENDPOINT_URL_P'];
    }

    curl_setopt_array(
        $curl,
        array(
            CURLOPT_URL => $url  . 'Candidatos/' . $id . '/ResetearContraseña',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_HTTPHEADER => array('Content-Type: 
            application/json', 'Content-Length: 0', 'Authorization: Bearer ' . $token['token']),
        )
    );
    $response = curl_exec($curl);
    //print_r($response);
    $idResult = json_decode($response, true);
    curl_close($curl);
    return $idResult;
}

/* FIN FUNCIONES GLOBALES */

/* FUNCIONES MI PERFIL */

function aniadirUrl($idUsuario, $urlAniadir)
{
    $curl = curl_init();
    $token = getToken($_COOKIE['mailUsuario'], $_COOKIE['pwd']);

    if ($_ENV['MODE'] == "development") {
        $url = $_ENV['ENDPOINT_URL_D'];
    } else {
        $url = $_ENV['ENDPOINT_URL_P'];
    }

    //echo $urlAniadir;
    curl_setopt_array(
        $curl,
        array(
            CURLOPT_URL => $url  . 'Candidatos/' . $idUsuario . '/AñadirURL/' . $urlAniadir,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => array(
                'Content-Length: 0',
                'Authorization: Bearer ' . $token['token']
            ),
        )
    );

    $response = curl_exec($curl);
    $idResult = json_decode($response, true);
    curl_close($curl);
    //print_r($response);
    return $idResult;
}

function inscribirseAOferta($idUsuario, $idOferta)
{

    $curl = curl_init();
    $token = getToken($_COOKIE['mailUsuario'], $_COOKIE['pwd']);

    if ($_ENV['MODE'] == "development") {
        $url = $_ENV['ENDPOINT_URL_D'];
    } else {
        $url = $_ENV['ENDPOINT_URL_P'];
    }

    //echo $urlAniadir;
    curl_setopt_array(
        $curl,
        array(
            CURLOPT_URL => $url  . 'Candidatos/' . $idUsuario . '/AñadirAOferta/' . $idOferta,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => array(
                'Content-Length: 0',
                'Authorization: Bearer ' . $token['token']
            ),
        )
    );

    $response = curl_exec($curl);
    $idResult = json_decode($response, true);
    curl_close($curl);
    //print_r($idResult);
    return $idResult;
}

function ofertasCandidato($idUsuario){
    $curl = curl_init();
    $token = getToken('portalempleado', 'zV.8d5<dV72w');

    if ($_ENV['MODE'] == "development") {
        $url = $_ENV['ENDPOINT_URL_D'];
    } else {
        $url = $_ENV['ENDPOINT_URL_P'];
    }

    curl_setopt_array(
        $curl,
        array(
            CURLOPT_URL => $url  . 'Ofertas/DameOfertasCandidato/' . $idUsuario ,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $token['token']
            ),
        )
    );

    $response = curl_exec($curl);
    $idResult = json_decode($response, true);
    curl_close($curl);
    return $idResult;
}

function infoUsuario($usuario)
{
    $curl = curl_init();
    $token = getToken('portalempleado', 'zV.8d5<dV72w');

    if ($_ENV['MODE'] == "development") {
        $url = $_ENV['ENDPOINT_URL_D'];
    } else {
        $url = $_ENV['ENDPOINT_URL_P'];
    }

    curl_setopt_array(
        $curl,
        array(
            CURLOPT_URL => $url  . 'Candidato/' . $usuario . '/Datos',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $token['token']
            ),
        )
    );

    $response = curl_exec($curl);
    $idResult = json_decode($response, true);
    curl_close($curl);
    return $idResult;
}

function login($usuario, $pass, $token)
{
    $curl = curl_init();

    if ($token == ' ') {
        $token = getToken($usuario, $pass)['token'];
    } else {
        $token = $token;
    }

    if ($_ENV['MODE'] == "development") {
        $url = $_ENV['ENDPOINT_URL_D'];
    } else {
        $url = $_ENV['ENDPOINT_URL_P'];
    }

    curl_setopt_array(
        $curl,
        array(
            CURLOPT_URL => $url  . 'Candidato/' . $usuario . '/Datos',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $token
            ),
        )
    );

    $response = curl_exec($curl);
    $idResult = json_decode($response, true);
    curl_close($curl);
    return $idResult;
}

function darAlta($nombre, $apellido1, $apellido2, $mail, $pass1, $telf)
{
    $curl = curl_init();
    $token = getToken('portalempleado', 'zV.8d5<dV72w');

    if ($_ENV['MODE'] == "development") {
        $url = $_ENV['ENDPOINT_URL_D'];
    } else {
        $url = $_ENV['ENDPOINT_URL_P'];
    }

    $salida = array("nombre" => $nombre, "apellido1" => $apellido1, "apellido2" => $apellido2, "email" => $mail, "pass" => $pass1, "telefono" => $telf);

    $salida = json_encode($salida);
    curl_setopt_array(
        $curl,
        array(
            CURLOPT_URL => $url  . 'Candidatos/crearNuevo',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $salida,
            CURLOPT_HTTPHEADER => array('Content-Type: 
            application/json', 'Authorization: Bearer ' . $token['token']),
        )
    );

    $response = curl_exec($curl);
    $idResult = json_decode($response, true);
    curl_close($curl);
    //print_r($idResult);
    return $idResult;
}

function enviarCV($id, $nombreDocumento, $extension, $base64)
{
    $curl = curl_init();
    $token = getToken($_COOKIE['mailUsuario'], $_COOKIE['pwd']);

    if ($_ENV['MODE'] == "development") {
        $url = $_ENV['ENDPOINT_URL_D'];
    } else {
        $url = $_ENV['ENDPOINT_URL_P'];
    }

    $salida = array("nombreDocumento" => $nombreDocumento, "extension" => $extension, "documentoBase64" => $base64);
    $salida = json_encode($salida);
    //print_r($salida);
    curl_setopt_array(
        $curl,
        array(
            CURLOPT_URL => $url  . 'Candidatos/' . $id . '/subirCurriculum',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $salida,
            CURLOPT_HTTPHEADER => array('Content-Type: 
            application/json', 'Authorization: Bearer ' . $token['token']),
        )
    );

    $response = curl_exec($curl);
    $idResult = json_decode($response, true);
    curl_close($curl);
    //print_r($response);
    return $idResult;
}

function perfiles()
{
    $curl = curl_init();
    $token = getToken($_COOKIE['mailUsuario'], $_COOKIE['pwd']);

    if ($_ENV['MODE'] == "development") {
        $url = $_ENV['ENDPOINT_URL_D'];
    } else {
        $url = $_ENV['ENDPOINT_URL_P'];
    }

    curl_setopt_array(
        $curl,
        array(
            CURLOPT_URL => $url  . 'Perfiles',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $token['token']
            ),
        )
    );

    $response = curl_exec($curl);
    $idResult = json_decode($response, true);
    curl_close($curl);
    return $idResult;
}

function idiomas()
{
    $curl = curl_init();
    $token = getToken($_COOKIE['mailUsuario'], $_COOKIE['pwd']);

    if ($_ENV['MODE'] == "development") {
        $url = $_ENV['ENDPOINT_URL_D'];
    } else {
        $url = $_ENV['ENDPOINT_URL_P'];
    }

    curl_setopt_array(
        $curl,
        array(
            CURLOPT_URL => $url  . 'Idiomas',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $token['token']
            ),
        )
    );

    $response = curl_exec($curl);
    $idResult = json_decode($response, true);
    curl_close($curl);
    return $idResult;
}

function nivelesIdioma()
{
    $curl = curl_init();
    $token = getToken($_COOKIE['mailUsuario'], $_COOKIE['pwd']);

    if ($_ENV['MODE'] == "development") {
        $url = $_ENV['ENDPOINT_URL_D'];
    } else {
        $url = $_ENV['ENDPOINT_URL_P'];
    }

    curl_setopt_array(
        $curl,
        array(
            CURLOPT_URL => $url  . 'NivelesIdioma',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $token['token']
            ),
        )
    );

    $response = curl_exec($curl);
    $idResult = json_decode($response, true);
    curl_close($curl);
    return $idResult;
}

function nivelesHerramientas()
{
    $curl = curl_init();
    $token = getToken($_COOKIE['mailUsuario'], $_COOKIE['pwd']);

    if ($_ENV['MODE'] == "development") {
        $url = $_ENV['ENDPOINT_URL_D'];
    } else {
        $url = $_ENV['ENDPOINT_URL_P'];
    }

    curl_setopt_array(
        $curl,
        array(
            CURLOPT_URL => $url  . 'Niveles',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $token['token']
            ),
        )
    );

    $response = curl_exec($curl);
    $idResult = json_decode($response, true);
    curl_close($curl);
    return $idResult;
}

function aniadirPerfil($idUsuario, $perfil)
{
    $curl = curl_init();
    $token = getToken($_COOKIE['mailUsuario'], $_COOKIE['pwd']);

    if ($_ENV['MODE'] == "development") {
        $url = $_ENV['ENDPOINT_URL_D'];
    } else {
        $url = $_ENV['ENDPOINT_URL_P'];
    }
    curl_setopt_array(
        $curl,
        array(
            CURLOPT_URL => $url  . 'Candidatos/' . $idUsuario . '/AñadirPerfil/' . $perfil,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => array(
                'Content-Length: 0',
                'Authorization: Bearer ' . $token['token']
            ),
        )
    );

    $response = curl_exec($curl);
    $idResult = json_decode($response, true);
    curl_close($curl);
    //print_r($response);
    return $idResult;
}

function borrarHabilidad($idUsuario, $habilidad)
{
    $curl = curl_init();
    $token = getToken($_COOKIE['mailUsuario'], $_COOKIE['pwd']);

    if ($_ENV['MODE'] == "development") {
        $url = $_ENV['ENDPOINT_URL_D'];
    } else {
        $url = $_ENV['ENDPOINT_URL_P'];
    }
    curl_setopt_array(
        $curl,
        array(
            CURLOPT_URL => $url  . 'Candidatos/' . $idUsuario . '/Habilidad/' . $habilidad,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_CUSTOMREQUEST => 'DELETE',
            CURLOPT_HTTPHEADER => array(
                'Content-Length: 0',
                'Authorization: Bearer ' . $token['token']
            ),
        )
    );

    $response = curl_exec($curl);
    $idResult = json_decode($response, true);
    curl_close($curl);
    //print_r($response);
    return $idResult;
}

function borrarUrl($idUsuario, $idUrl)
{
    $curl = curl_init();
    $token = getToken($_COOKIE['mailUsuario'], $_COOKIE['pwd']);

    if ($_ENV['MODE'] == "development") {
        $url = $_ENV['ENDPOINT_URL_D'];
    } else {
        $url = $_ENV['ENDPOINT_URL_P'];
    }
    curl_setopt_array(
        $curl,
        array(
            CURLOPT_URL => $url  . 'Candidatos/' . $idUsuario . '/URL/' . $idUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_CUSTOMREQUEST => 'DELETE',
            CURLOPT_HTTPHEADER => array(
                'Content-Length: 0',
                'Authorization: Bearer ' . $token['token']
            ),
        )
    );

    $response = curl_exec($curl);
    $idResult = json_decode($response, true);
    curl_close($curl);
    //print_r($response);
    return $idResult;
}

function borrarPerfil($idUsuario, $perfil)
{
    $curl = curl_init();
    $token = getToken($_COOKIE['mailUsuario'], $_COOKIE['pwd']);

    if ($_ENV['MODE'] == "development") {
        $url = $_ENV['ENDPOINT_URL_D'];
    } else {
        $url = $_ENV['ENDPOINT_URL_P'];
    }
    curl_setopt_array(
        $curl,
        array(
            CURLOPT_URL => $url  . 'Candidatos/' . $idUsuario . '/Perfil/' . $perfil,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_CUSTOMREQUEST => 'DELETE',
            CURLOPT_HTTPHEADER => array(
                'Content-Length: 0',
                'Authorization: Bearer ' . $token['token']
            ),
        )
    );

    $response = curl_exec($curl);
    $idResult = json_decode($response, true);
    curl_close($curl);
    //print_r($response);
    return $idResult;
}

function borrarExperiencias($experiencia)
{
    $curl = curl_init();
    $token = getToken($_COOKIE['mailUsuario'], $_COOKIE['pwd']);

    if ($_ENV['MODE'] == "development") {
        $url = $_ENV['ENDPOINT_URL_D'];
    } else {
        $url = $_ENV['ENDPOINT_URL_P'];
    }
    curl_setopt_array(
        $curl,
        array(
            CURLOPT_URL => $url  . 'Experiencia/' . $experiencia,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_CUSTOMREQUEST => 'DELETE',
            CURLOPT_HTTPHEADER => array(
                'Content-Length: 0',
                'Authorization: Bearer ' . $token['token']
            ),
        )
    );

    $response = curl_exec($curl);
    $idResult = json_decode($response, true);
    curl_close($curl);
    //print_r($response);
    return $idResult;
}

function borrarIdioma($idUsuario, $perfil)
{
    $curl = curl_init();
    $token = getToken($_COOKIE['mailUsuario'], $_COOKIE['pwd']);

    if ($_ENV['MODE'] == "development") {
        $url = $_ENV['ENDPOINT_URL_D'];
    } else {
        $url = $_ENV['ENDPOINT_URL_P'];
    }
    curl_setopt_array(
        $curl,
        array(
            CURLOPT_URL => $url  . 'Candidatos/' . $idUsuario . '/Idioma/' . $perfil,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_CUSTOMREQUEST => 'DELETE',
            CURLOPT_HTTPHEADER => array(
                'Content-Length: 0',
                'Authorization: Bearer ' . $token['token']
            ),
        )
    );

    $response = curl_exec($curl);
    $idResult = json_decode($response, true);
    curl_close($curl);
    //print_r($response);
    return $idResult;
}

function borrarEstudios($idUsuario, $perfil)
{
    $curl = curl_init();
    $token = getToken($_COOKIE['mailUsuario'], $_COOKIE['pwd']);

    if ($_ENV['MODE'] == "development") {
        $url = $_ENV['ENDPOINT_URL_D'];
    } else {
        $url = $_ENV['ENDPOINT_URL_P'];
    }
    curl_setopt_array(
        $curl,
        array(
            CURLOPT_URL => $url  . 'Candidatos/' . $idUsuario . '/Estudio/' . $perfil,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_CUSTOMREQUEST => 'DELETE',
            CURLOPT_HTTPHEADER => array(
                'Content-Length: 0',
                'Authorization: Bearer ' . $token['token']
            ),
        )
    );

    $response = curl_exec($curl);
    $idResult = json_decode($response, true);
    curl_close($curl);
    //print_r($response);
    return $idResult;
}

function borrarHerramienta($idUsuario, $perfil)
{
    $curl = curl_init();
    $token = getToken($_COOKIE['mailUsuario'], $_COOKIE['pwd']);

    if ($_ENV['MODE'] == "development") {
        $url = $_ENV['ENDPOINT_URL_D'];
    } else {
        $url = $_ENV['ENDPOINT_URL_P'];
    }
    curl_setopt_array(
        $curl,
        array(
            CURLOPT_URL => $url  . 'Candidatos/' . $idUsuario . '/HerramientasInformatica/' . $perfil,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_CUSTOMREQUEST => 'DELETE',
            CURLOPT_HTTPHEADER => array(
                'Content-Length: 0',
                'Authorization: Bearer ' . $token['token']
            ),
        )
    );

    $response = curl_exec($curl);
    $idResult = json_decode($response, true);
    curl_close($curl);
    //print_r($response);
    return $idResult;
}


function aniadirIdioma($idUsuario, $idIdioma, $nivelOral, $nivelEscrito)
{
    $curl = curl_init();
    $token = getToken($_COOKIE['mailUsuario'], $_COOKIE['pwd']);

    if ($_ENV['MODE'] == "development") {
        $url = $_ENV['ENDPOINT_URL_D'];
    } else {
        $url = $_ENV['ENDPOINT_URL_P'];
    }


    $salida = array("idIdioma" => $idIdioma, "nivelHablado" => $nivelOral, "nivelEscrito" => $nivelEscrito);

    $salida = json_encode($salida);
    //print_r($salida);
    curl_setopt_array(
        $curl,
        array(
            CURLOPT_URL => $url  . 'Candidatos/' . $idUsuario . '/AñadirIdioma',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $salida,
            CURLOPT_HTTPHEADER => array('Content-Type: 
            application/json', 'Authorization: Bearer ' . $token['token']),
        )
    );

    $response = curl_exec($curl);
    $idResult = json_decode($response, true);
    curl_close($curl);
    //print_r($idResult);
    return $idResult;
}

function aniadirHerramienta($idUsuario, $idHerramienta, $nivel)
{
    $curl = curl_init();
    $token = getToken($_COOKIE['mailUsuario'], $_COOKIE['pwd']);

    if ($_ENV['MODE'] == "development") {
        $url = $_ENV['ENDPOINT_URL_D'];
    } else {
        $url = $_ENV['ENDPOINT_URL_P'];
    }


    $salida = array("idHerramienta" => $idHerramienta, "nivel" => $nivel);

    $salida = json_encode($salida);
    //print_r($salida);
    curl_setopt_array(
        $curl,
        array(
            CURLOPT_URL => $url  . 'Candidatos/' . $idUsuario . '/AñadirHerramientaInformatica',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $salida,
            CURLOPT_HTTPHEADER => array('Content-Type: 
            application/json', 'Authorization: Bearer ' . $token['token']),
        )
    );

    $response = curl_exec($curl);
    $idResult = json_decode($response, true);
    curl_close($curl);
    //print_r($idResult);
    return $idResult;
}

function actualizarFoto($id, $extension, $base64)
{
    $curl = curl_init();
    $token = getToken($_COOKIE['mailUsuario'], $_COOKIE['pwd']);

    if ($_ENV['MODE'] == "development") {
        $url = $_ENV['ENDPOINT_URL_D'];
    } else {
        $url = $_ENV['ENDPOINT_URL_P'];
    }

    $salida = array("foto" => $base64, "extension" => $extension);
    $salida = json_encode($salida);
    //print_r($salida);
    curl_setopt_array(
        $curl,
        array(
            CURLOPT_URL => $url  . 'Candidatos/' . $id . '/SubirFoto',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $salida,
            CURLOPT_HTTPHEADER => array('Content-Type: 
            application/json', 'Authorization: Bearer ' . $token['token']),
        )
    );

    $response = curl_exec($curl);
    //print_r($response);
    $idResult = json_decode($response, true);
    curl_close($curl);
    return $idResult;
}

function tipoVia()
{
    $curl = curl_init();
    $token = getToken($_COOKIE['mailUsuario'], $_COOKIE['pwd']);

    if ($_ENV['MODE'] == "development") {
        $url = $_ENV['ENDPOINT_URL_D'];
    } else {
        $url = $_ENV['ENDPOINT_URL_P'];
    }

    curl_setopt_array(
        $curl,
        array(
            CURLOPT_URL => $url  . 'TiposVia',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $token['token']
            ),
        )
    );

    $response = curl_exec($curl);
    $idResult = json_decode($response, true);
    curl_close($curl);
    return $idResult;
}

function horarios()
{
    $curl = curl_init();
    $token = getToken($_COOKIE['mailUsuario'], $_COOKIE['pwd']);

    if ($_ENV['MODE'] == "development") {
        $url = $_ENV['ENDPOINT_URL_D'];
    } else {
        $url = $_ENV['ENDPOINT_URL_P'];
    }

    curl_setopt_array(
        $curl,
        array(
            CURLOPT_URL => $url  . 'DisponibilidadHoraria',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $token['token']
            ),
        )
    );

    $response = curl_exec($curl);
    $idResult = json_decode($response, true);
    curl_close($curl);
    return $idResult;
}

function actualizarDatosContratacion($fechaNacimiento, $lugarNacimiento, $nacionalidad, $nombreRepre, $nifRepre, $tipoRepre, $fechaInicioPermisoTrabajo, $fechaFinPermisoTrabajo, $idUsuario, $fechaCaducidadDNI)
{
    $curl = curl_init();
    $token = getToken($_COOKIE['mailUsuario'], $_COOKIE['pwd']);

    if ($_ENV['MODE'] == "development") {
        $url = $_ENV['ENDPOINT_URL_D'];
    } else {
        $url = $_ENV['ENDPOINT_URL_P'];
    }

    $salida = array(
        "lugarNacimiento" => $lugarNacimiento,
        "fechaCaducidadDNI" => $fechaCaducidadDNI,
        "fechaNacimiento" => $fechaNacimiento,
        "nacionalidad" => $nacionalidad,
    );
    $salida = json_encode($salida);
    //print_r($salida);
    curl_setopt_array(
        $curl,
        array(
            CURLOPT_URL => $url  . 'Candidatos/' . $idUsuario . '/ActualizarDatosContratacion',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $salida,
            CURLOPT_HTTPHEADER => array('Content-Type: 
            application/json', 'Authorization: Bearer ' . $token['token']),
        )
    );

    $response = curl_exec($curl);
    $idResult = json_decode($response, true);
    curl_close($curl);
    //print_r($response);
    return $idResult;
}

function actualizarDatos(
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
) {
    $curl = curl_init();
    $token = getToken($_COOKIE['mailUsuario'], $_COOKIE['pwd']);

    if ($_ENV['MODE'] == "development") {
        $url = $_ENV['ENDPOINT_URL_D'];
    } else {
        $url = $_ENV['ENDPOINT_URL_P'];
    }

    $salida = array(
        "nombre" => $nombre,
        "apellido1" => $apellido1,
        "apellido2" => $apellido2,
        "tipoDocumento" => $tipoDocumento,
        "nif" => $valorDocumento,
        "lugarNacimiento" => null,
        "tipoVia" => $tipoVia,
        "direccion" => $direccion,
        "codPostal" => $codPostal,
        "municipio" => $municipio,
        "provincia" => $provincia,
        "telefonoMovil" => $telefono,
        "telefonoFijo" => $telefonoFijo,
        "carnetConducir" => $permisoConducir,
        "vehiculoPropio" => $vehiculoPropio,
        "estaTrabajando" => $trabajando,
        "disponibilidadParaViajar" => $viajar,
        "disponibilidadIncorporacion" => $incorporacion,
        "disponibilidadHoraria" => $disponibilidadHoraria,
        "rangoSalarial" => $rangoSalarial
    );
    $salida = json_encode($salida);
    //print_r($salida);
    curl_setopt_array(
        $curl,
        array(
            CURLOPT_URL => $url  . 'Candidatos/' . $idUsuario . '/ActualizarDatos',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $salida,
            CURLOPT_HTTPHEADER => array('Content-Type: 
            application/json', 'Authorization: Bearer ' . $token['token']),
        )
    );

    $response = curl_exec($curl);
    $idResult = json_decode($response, true);
    curl_close($curl);
    //print_r($response);
    return $idResult;
}

function actualizarExperiencias($empresa, $puesto, $fechaDesde, $actualmente, $fechaFin, $tecnologias, $descripcion, $salario, $idUsuario)
{
    $curl = curl_init();
    $token = getToken($_COOKIE['mailUsuario'], $_COOKIE['pwd']);

    if ($_ENV['MODE'] == "development") {
        $url = $_ENV['ENDPOINT_URL_D'];
    } else {
        $url = $_ENV['ENDPOINT_URL_P'];
    }

    $salida = array(
        "empresa" => $empresa,
        "puesto" => $puesto,
        "fechaDesde" => $fechaDesde,
        "fechaHasta" => $fechaFin,
        "trabajoAquiActualmente" => $actualmente,
        "tecnologiasUtilizadas" => $tecnologias,
        "descripcionDelPuesto" => $descripcion,
        "salario" => $salario,
    );
    $salida = json_encode($salida);
    //print_r($salida);
    curl_setopt_array(
        $curl,
        array(
            CURLOPT_URL => $url  . 'Experiencia/' . $idUsuario . '/ActualizarExperiencia',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_POSTFIELDS => $salida,
            CURLOPT_HTTPHEADER => array('Content-Type: 
            application/json', 'Authorization: Bearer ' . $token['token']),
        )
    );

    $response = curl_exec($curl);
    $idResult = json_decode($response, true);
    curl_close($curl);
    //print_r($response);
    return $idResult;
}

function borrarReferencia($idExperiencia, $idReferencia)
{
    $curl = curl_init();
    $token = getToken($_COOKIE['mailUsuario'], $_COOKIE['pwd']);

    if ($_ENV['MODE'] == "development") {
        $url = $_ENV['ENDPOINT_URL_D'];
    } else {
        $url = $_ENV['ENDPOINT_URL_P'];
    }
    curl_setopt_array(
        $curl,
        array(
            CURLOPT_URL => $url  . 'Experiencia/' . $idExperiencia . '/Referencia/' . $idReferencia,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_CUSTOMREQUEST => 'DELETE',
            CURLOPT_HTTPHEADER => array(
                'Content-Length: 0',
                'Authorization: Bearer ' . $token['token']
            ),
        )
    );

    $response = curl_exec($curl);
    $idResult = json_decode($response, true);
    curl_close($curl);
    //    print_r($idResult);
    return $idResult;
}

function aniadirReferencia($nombreReferencia, $puestoReferencia, $mailReferencia, $idExperiencia)
{
    $curl = curl_init();
    $token = getToken($_COOKIE['mailUsuario'], $_COOKIE['pwd']);

    if ($_ENV['MODE'] == "development") {
        $url = $_ENV['ENDPOINT_URL_D'];
    } else {
        $url = $_ENV['ENDPOINT_URL_P'];
    }

    $salida = array(
        "nombre" => $nombreReferencia,
        "cargo" => $puestoReferencia,
        "email" => $mailReferencia,
    );
    $salida = json_encode($salida);
    //print_r($salida);
    curl_setopt_array(
        $curl,
        array(
            CURLOPT_URL => $url  . 'Experiencia/' . $idExperiencia . '/AñadirReferencia',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $salida,
            CURLOPT_HTTPHEADER => array('Content-Type: 
            application/json', 'Authorization: Bearer ' . $token['token']),
        )
    );

    $response = curl_exec($curl);
    $idResult = json_decode($response, true);
    curl_close($curl);
    //print_r($response);
    return $idResult;
}

function aniadirHabilidad($idUsuario, $habilidad)
{
    $curl = curl_init();
    $token = getToken($_COOKIE['mailUsuario'], $_COOKIE['pwd']);

    if ($_ENV['MODE'] == "development") {
        $url = $_ENV['ENDPOINT_URL_D'];
    } else {
        $url = $_ENV['ENDPOINT_URL_P'];
    }
    curl_setopt_array(
        $curl,
        array(
            CURLOPT_URL => $url  . 'Candidatos/' . $idUsuario . '/AñadirHabilidad/' . $habilidad,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => array('Content-Type: 
            application/json', 'Content-Length: 0', 'Authorization: Bearer ' . $token['token']),
        )
    );

    $response = curl_exec($curl);
    $idResult = json_decode($response, true);
    curl_close($curl);
    //print_r($response);
    return $idResult;
}

function aniadirExperiencia($empresa, $puesto, $fechaDesde, $actualmente, $fechaFin, $tecnologias, $descripcion, $salario, $idUsuario)
{
    $curl = curl_init();
    $token = getToken($_COOKIE['mailUsuario'], $_COOKIE['pwd']);

    if ($_ENV['MODE'] == "development") {
        $url = $_ENV['ENDPOINT_URL_D'];
    } else {
        $url = $_ENV['ENDPOINT_URL_P'];
    }

    $salida = array(
        "empresa" => $empresa,
        "puesto" => $puesto,
        "fechaDesde" => $fechaDesde,
        "fechaHasta" => $fechaFin,
        "trabajoAquiActualmente" => $actualmente,
        "tecnologiasUtilizadas" => $tecnologias,
        "descripcionDelPuesto" => $descripcion,
        "salario" => $salario,
    );
    $salida = json_encode($salida);
    //print_r($salida);
    curl_setopt_array(
        $curl,
        array(
            CURLOPT_URL => $url  . 'Candidatos/' . $idUsuario . '/AñadirExperiencia',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $salida,
            CURLOPT_HTTPHEADER => array('Content-Type: 
            application/json', 'Authorization: Bearer ' . $token['token']),
        )
    );

    $response = curl_exec($curl);
    $idResult = json_decode($response, true);
    curl_close($curl);
    //print_r($response);
    return $idResult;
}

function nuevaPass($idUsuario, $nuevaPass)
{
    $curl = curl_init();
    $token = getToken('portalempleado', 'zV.8d5<dV72w');

    if ($_ENV['MODE'] == "development") {
        $url = $_ENV['ENDPOINT_URL_D'];
    } else {
        $url = $_ENV['ENDPOINT_URL_P'];
    }

    curl_setopt_array(
        $curl,
        array(
            CURLOPT_URL => $url  . 'Candidatos/' . $idUsuario . '/ModificarContraseña/' . $nuevaPass,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_HTTPHEADER => array('Content-Type: 
            application/json', 'Content-Length: 0', 'Authorization: Bearer ' . $token['token']),
        )
    );
    $response = curl_exec($curl);
    //print_r($response);
    $idResult = json_decode($response, true);
    curl_close($curl);
    return $idResult;
}

function cambiarPass($idUsuario, $nuevaPass)
{
    $curl = curl_init();
    $token = getToken($_COOKIE['mailUsuario'], $_COOKIE['pwd']);

    if ($_ENV['MODE'] == "development") {
        $url = $_ENV['ENDPOINT_URL_D'];
    } else {
        $url = $_ENV['ENDPOINT_URL_P'];
    }

    curl_setopt_array(
        $curl,
        array(
            CURLOPT_URL => $url  . 'Candidatos/' . $idUsuario . '/ModificarContraseña/' . $nuevaPass,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_HTTPHEADER => array('Content-Type: 
            application/json', 'Content-Length: 0', 'Authorization: Bearer ' . $token['token']),
        )
    );
    $response = curl_exec($curl);
    //print_r($response);
    $idResult = json_decode($response, true);
    curl_close($curl);
    return $idResult;
}

function cambiarMail($idUsuario, $nuevoMail)
{
    $curl = curl_init();
    $token = getToken($_COOKIE['mailUsuario'], $_COOKIE['pwd']);

    if ($_ENV['MODE'] == "development") {
        $url = $_ENV['ENDPOINT_URL_D'];
    } else {
        $url = $_ENV['ENDPOINT_URL_P'];
    }

    curl_setopt_array(
        $curl,
        array(
            CURLOPT_URL => $url  . 'Candidatos/' . $idUsuario . '/ModificarEmail/' . $nuevoMail,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_HTTPHEADER => array('Content-Type: 
            application/json', 'Content-Length: 0', 'Authorization: Bearer ' . $token['token']),
        )
    );
    $response = curl_exec($curl);
    //print_r($response);
    $idResult = json_decode($response, true);
    curl_close($curl);
    return $idResult;
}

function nacionalidades()
{
    $curl = curl_init();
    $token = getToken($_COOKIE['mailUsuario'], $_COOKIE['pwd']);

    if ($_ENV['MODE'] == "development") {
        $url = $_ENV['ENDPOINT_URL_D'];
    } else {
        $url = $_ENV['ENDPOINT_URL_P'];
    }

    curl_setopt_array(
        $curl,
        array(
            CURLOPT_URL => $url  . 'Nacionalidades',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $token['token']
            ),
        )
    );

    $response = curl_exec($curl);
    $idResult = json_decode($response, true);
    curl_close($curl);
    return $idResult;
}


function tipoDocumento()
{
    $curl = curl_init();
    $token = getToken($_COOKIE['mailUsuario'], $_COOKIE['pwd']);

    if ($_ENV['MODE'] == "development") {
        $url = $_ENV['ENDPOINT_URL_D'];
    } else {
        $url = $_ENV['ENDPOINT_URL_P'];
    }

    curl_setopt_array(
        $curl,
        array(
            CURLOPT_URL => $url  . 'TiposDocumento',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $token['token']
            ),
        )
    );

    $response = curl_exec($curl);
    $idResult = json_decode($response, true);
    curl_close($curl);
    return $idResult;
}

function aniadirEstudios($idUsuario, $idEstudio, $especialidad, $fechaInicio, $fechaFin)
{
    $curl = curl_init();
    $token = getToken($_COOKIE['mailUsuario'], $_COOKIE['pwd']);

    if ($_ENV['MODE'] == "development") {
        $url = $_ENV['ENDPOINT_URL_D'];
    } else {
        $url = $_ENV['ENDPOINT_URL_P'];
    }

    $salida = array("idEstudio" => $idEstudio, "especialidad" => $especialidad, "fechaDesde" => $fechaInicio, "fechaHasta" => $fechaFin);

    $salida = json_encode($salida);
    //print_r($salida);
    curl_setopt_array(
        $curl,
        array(
            CURLOPT_URL => $url  . 'Candidatos/' . $idUsuario . '/AñadirEstudio',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $salida,
            CURLOPT_HTTPHEADER => array('Content-Type: 
            application/json', 'Authorization: Bearer ' . $token['token']),
        )
    );

    $response = curl_exec($curl);
    $idResult = json_decode($response, true);
    curl_close($curl);
    //print_r($idResult);
    return $idResult;
}

function estudios()
{
    $curl = curl_init();
    $token = getToken($_COOKIE['mailUsuario'], $_COOKIE['pwd']);

    if ($_ENV['MODE'] == "development") {
        $url = $_ENV['ENDPOINT_URL_D'];
    } else {
        $url = $_ENV['ENDPOINT_URL_P'];
    }

    curl_setopt_array(
        $curl,
        array(
            CURLOPT_URL => $url  . 'Estudios',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $token['token']
            ),
        )
    );

    $response = curl_exec($curl);
    $idResult = json_decode($response, true);
    curl_close($curl);
    return $idResult;
}

function herramientas()
{
    $curl = curl_init();
    $token = getToken($_COOKIE['mailUsuario'], $_COOKIE['pwd']);

    if ($_ENV['MODE'] == "development") {
        $url = $_ENV['ENDPOINT_URL_D'];
    } else {
        $url = $_ENV['ENDPOINT_URL_P'];
    }

    curl_setopt_array(
        $curl,
        array(
            CURLOPT_URL => $url  . 'HerramientasInformatica',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $token['token']
            ),
        )
    );

    $response = curl_exec($curl);
    $idResult = json_decode($response, true);
    curl_close($curl);
    //print_r($idResult);
    return $idResult;
}


function especialidades($id)
{
    $curl = curl_init();
    $token = getToken($_COOKIE['mailUsuario'], $_COOKIE['pwd']);

    if ($_ENV['MODE'] == "development") {
        $url = $_ENV['ENDPOINT_URL_D'];
    } else {
        $url = $_ENV['ENDPOINT_URL_P'];
    }

    curl_setopt_array(
        $curl,
        array(
            CURLOPT_URL => $url  . 'Estudio/' . $id . '/Especialidades',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $token['token']
            ),
        )
    );

    $response = curl_exec($curl);
    $idResult = json_decode($response, true);
    curl_close($curl);
    return $idResult;
}

if (isset($_GET['accion']) && $_GET['accion'] === 'especialidades' && isset($_GET['id'])) {
    $id = intval($_GET['id']); // Asegúrate de que el ID sea un entero
    $especialidades = especialidades($id); // Llama a la función especialidades

    header('Content-Type: application/json'); // Establecer tipo de contenido a JSON
    echo json_encode($especialidades); // Devuelve las especialidades en formato JSON
    exit; // Salir del script
}
/* FIN FUNCIONES PERFIL */

/* FUNCIONES OFERTAS */

function listadoOfertas($id, $conexion)
{
    $curl = curl_init();
    if ($conexion == true) {
        $token = getToken($_COOKIE['mailUsuario'], $_COOKIE['pwd']);
    } else {
        $token = getToken('portalempleado', 'zV.8d5<dV72w');
    }

    if ($_ENV['MODE'] == "development") {
        $url = $_ENV['ENDPOINT_URL_D'];
    } else {
        $url = $_ENV['ENDPOINT_URL_P'];
    }

    curl_setopt_array(
        $curl,
        array(
            CURLOPT_URL => $url  . 'Ofertas/' . $id .'?activas=true',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $token['token']
            ),
        )
    );

    $response = curl_exec($curl);
    $idResult = json_decode($response, true);
    curl_close($curl);
    return $idResult;
}

/* FIN FUNCIONES OFERTAS */

function generarMenuHorizontal()
{ ?>
    <div class="menuHorizontal">
        <div class="cabeceraNoHome">
            <a href="https://www.agioglobal.com/home/index.php" target="_blank">
                <img src="../Img/LogoColor.png" alt="Logo">
            </a>
            <div class="iniciales">
                <!-- Botón de enviar con la clase 'iniciales' -->
                <a href="../Home/index.php"><img src="../Img/casaColor.png" alt="Foto perfil"></a>
                <img onclick="mostrarMenuHorizontal(this)" class="etiqueta" src="../Img/menuColor.png" alt="Flecha Abajo">
            </div>
        </div>
        <div class="menuBarraHorizontal">
            <a href="../Perfil/index.php">Mi perfil</a>
            <a href="../MisCandidaturas/index.php">Mis candidaturas</a>
            <?php
            $infoUsuario = login($_COOKIE['mailUsuario'], $_COOKIE['pwd'], ' ');
            if ($infoUsuario['role'] == 3) { ?>
                <a href="../DatosContratacion/index.php">Datos de contratación</a>
                <a href="<?php echo $_ENV['ENTORNO'] . '/PortalEmpleado/portalEmpleado.php' ?>">Mis Test</a>
                <a href="<?php echo $_ENV['ENTORNO'] . '/RGPD/rgpd.php' ?>">RGPD</a>
                <a href="<?php echo $_ENV['ENTORNO'] . '/Llamamientos/listadoLlamamientos.php' ?>">Mis llamamientos</a>
            <?php } ?>
            <a href="../Ajustes/index.php">Configuración</a>
            <a class="" href="../CerrarSesion/index.php"><img src="../Img/fuerzaColor.png" alt="Apagar Button"></a>
        </div>
    </div>
<?php }

function generarMenuHome()
{ ?>
    <div class="menu">
        <div class="cabecera">
            <div class="topCabecera">
                <a href="https://www.agioglobal.com/home/index.php" target="_blank">
                    <img src="../Img/LogoBlanco.png" alt="Logo">
                </a>
                <div class="enlaces">
                    <?php if (isset($_COOKIE['mailUsuario'])) {
                        $infoUsuario = login($_COOKIE['mailUsuario'], $_COOKIE['pwd'], ' ');
                    ?>
                        <?php if (!is_null($infoUsuario['foto'])) { ?>
                            <div class="iniciales">
                                <!-- Botón de enviar con la clase 'iniciales' -->
                                <a href="../Perfil/index.php"><img src="<?php echo $infoUsuario['foto']; ?>" alt="Foto perfil"></a>
                                <img onclick="mostrarOpcionesLogin(this)" class="etiqueta" src="../Img/menu.png" alt="Flecha Abajo">
                            </div>
                        <?php } else {
                            $iniciales = getIniciales(quitarAcentos($infoUsuario['nombre'] . ' ' . $infoUsuario['apellido1'])); ?>
                            <div class="iniciales ver">
                                <a href="../Perfil/index.php"><?php echo $iniciales; ?></a>
                                <img onclick="mostrarOpcionesLogin(this)" class="etiqueta" src="../Img/menu.png" alt="Flecha Abajo">
                            </div>
                        <?php } ?>

                        <div class="verOpcionesLogin">
                            <a href="../Perfil/index.php">Mi perfil</a>
                            <a href="../MisCandidaturas/index.php">Mis candidaturas</a>
                            <?php
                            $infoUsuario = login($_COOKIE['mailUsuario'], $_COOKIE['pwd'], ' ');
                            if ($infoUsuario['role'] == 3) { ?>
                                <a href="../DatosContratacion/index.php">Datos de contratación</a>
                                <a href="<?php echo $_ENV['ENTORNO'] . '/PortalEmpleado/portalEmpleado.php' ?>">Mis Test</a>
                                <a href="<?php echo $_ENV['ENTORNO'] . '/RGPD/rgpd.php' ?>">RGPD</a>
                                <a href="<?php echo $_ENV['ENTORNO'] . '/Llamamientos/listadoLlamamientos.php' ?>">Mis llamamientos</a>
                            <?php } ?>
                            <a href="../Ajustes/index.php">Configuración</a>
                            <a class="" href="../CerrarSesion/index.php"><img src="../Img/fuerza.png" alt="Apagar Button"></a>
                        </div>
                    <?php } else { ?>
                        <a class="special" href="../Login/login.php">Login</a>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="overlay"></div>
        <div class="cuadroBuscar">
            <h2>Buscar ofertas...</h2>
            <div class="buscador">
                <input type="text" id="buscadorPuesto" placeholder="Puesto...">
                <input type="text" id="buscadorMunicipio" placeholder="Municipio...">
                <select name="provincias" id="provincias">
                    <option value="" selected>Toda España...</option>
                    <option value="Álava">Álava</option>
                    <option value="Albacete">Albacete</option>
                    <option value="Alicante">Alicante</option>
                    <option value="Almería">Almería</option>
                    <option value="Asturias">Asturias</option>
                    <option value="Ávila">Ávila</option>
                    <option value="Badajoz">Badajoz</option>
                    <option value="Baleares">Baleares</option>
                    <option value="Barcelona">Barcelona</option>
                    <option value="Burgos">Burgos</option>
                    <option value="Cáceres">Cáceres</option>
                    <option value="Cádiz">Cádiz</option>
                    <option value="Cantabria">Cantabria</option>
                    <option value="Castellón">Castellón</option>
                    <option value="Ceuta">Ceuta</option>
                    <option value="Ciudad Real">Ciudad Real</option>
                    <option value="Córdoba">Córdoba</option>
                    <option value="Cuenca">Cuenca</option>
                    <option value="Girona">Girona</option>
                    <option value="Granada">Granada</option>
                    <option value="Guadalajara">Guadalajara</option>
                    <option value="Guipúzcoa">Guipúzcoa</option>
                    <option value="Huelva">Huelva</option>
                    <option value="Huesca">Huesca</option>
                    <option value="Jaén">Jaén</option>
                    <option value="La Coruña">La Coruña</option>
                    <option value="La Rioja">La Rioja</option>
                    <option value="Las Palmas">Las Palmas</option>
                    <option value="León">León</option>
                    <option value="Lleida">Lleida</option>
                    <option value="Lugo">Lugo</option>
                    <option value="Madrid">Madrid</option>
                    <option value="Málaga">Málaga</option>
                    <option value="Melilla">Melilla</option>
                    <option value="Murcia">Murcia</option>
                    <option value="Navarra">Navarra</option>
                    <option value="Ourense">Ourense</option>
                    <option value="Palencia">Palencia</option>
                    <option value="Pontevedra">Pontevedra</option>
                    <option value="Salamanca">Salamanca</option>
                    <option value="Segovia">Segovia</option>
                    <option value="Sevilla">Sevilla</option>
                    <option value="Soria">Soria</option>
                    <option value="Tarragona">Tarragona</option>
                    <option value="Tenerife">Tenerife</option>
                    <option value="Teruel">Teruel</option>
                    <option value="Toledo">Toledo</option>
                    <option value="Valencia">Valencia</option>
                    <option value="Valladolid">Valladolid</option>
                    <option value="Vizcaya">Vizcaya</option>
                    <option value="Zamora">Zamora</option>
                    <option value="Zaragoza">Zaragoza</option>
                </select>
            </div>
            <div class="infoFiltro">
                <label for="technology">Mostrar solo ofertas de tecnología</label>
                <input type="checkbox" id="technology" onchange="filtrarOfertas()">
            </div>
        </div>
    </div>
<?php }

function generarFooter()
{ ?>
    <footer>
        <div class="footer">
            <div class="footer-col footer-logo">
                <a href="../Home/index.php"><img src="../Img/LogoBlanco.png" alt="AgioGlobal"></a>
                <a href="https://fundacionagioglobal.org" target="_blank" rel="noopener noreferrer"><img src="../Img/Fundacion AgioGlobal Horizontal Blanco.png" alt="Logo Fundacion"></a>
                <div class="social-icons">
                    <a target="_blank" href="https://www.facebook.com/AgioGlobal"><img src="../Img/facebook.png" alt="Facebook"></a>
                    <a target="_blank" href="https://www.linkedin.com/company/agioglobal-working-together/mycompany/"><img src="../Img/linkedin.png" alt="LinkedIn"></a>
                    <a target="_blank" href="https://www.instagram.com/agioglobal/"><img src="../Img/instagram.png" alt="Instagram"></a>
                    <a target="_blank" href="https://whatsapp.com/channel/0029VanCxhjLY6d3RxUfvc2f/"><img src="../Img/whatsapp.png" alt="Whatsapp"></a>

                </div>

                <img class="ofertasImg" src="../Img/canalOfertas.png" alt="Canal Whatsapp">
            </div>
            <div class="footer-col">
                <p>Localízanos en cualquiera de nuestras delegaciones o llamándonos al:</p>
                <p><a href="tel:+34914444460">914 444 460</a></p>
                <p><a href="https://maps.app.goo.gl/W7YCJqYGwycQJLTs8" target="_blank" rel="noopener noreferrer">Sede Central: Calle de Luchana 23, 3ª Planta, 28010, Madrid</a></p>
                <p><a href="mailto:info@agioglobal.es">info@agioglobal.es</a></p>
            </div>
            <div class="footer-col">
                <ul>
                    <li><a href="../SobreNosotros/index.php">Sobre Nosotros</a></li>
                    <li><a href="../GeneralTT/index.php">Trabajo Temporal</a></li>
                    <li><a href="../GeneralOutsourcing/index.php">Outsourcing</a></li>
                    <li><a href="../Sales&Marketing/index.php">Sales & Marketing</a></li>
                    <li><a href="../OutsourcingTechnology/index.php">Technology</a></li>
                    <li><a target="_blank" href="https://www.infojobs.net/jobsearch/search-results/list.xhtml?keyword=Agioglobal&segmentId=&page=1&sortBy=PUBLICATION_DATE&onlyForeignCountry=false&countryIds=17&sinceDate=ANY">Ofertas de Empleo</a></li>

                </ul>
            </div>
            <div class="footer-col">
                <ul>
                    <li><a href="../AvisoLegal/index.php">Aviso legal</a></li>
                    <li><a href="../PoliticaPrivacidad/index.php">Política de privacidad</a></li>
                    <li><a href="../CanalDenuncias/index.php">Canal de denuncias</a></li>
                    <li><a href="../CompromisoEtico/index.php">Compromiso ético</a></li>
                    <li><a href="../PoliticaCookies/index.php">Política de cookies</a></li>
                    <li><a href="../ISO/index.php">Certificados ISO y Política Integrada</a></li>
                    <li><a href="../DondeEstamos/index.php">Dónde estamos</a></li>
                    <li><a href="../Contacto/index.php">Contacto</a></li>
                </ul>
            </div>
        </div>
        <div class="copyright">
            <p>Copyright © 2024 AgioGlobal</p>
        </div>
    </footer>
<?php }
