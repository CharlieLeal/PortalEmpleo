<?php
require_once("../Funciones/funciones.php");

require '../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable('../');
$dotenv->load();
?>

<!DOCTYPE html>
<html lang="es" dir="ltr">

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="../Js/login.js"></script>
    <link rel="stylesheet" href="../Css/common.css">
    <link rel="stylesheet" href="../Css/login.css">
    <link rel="stylesheet" href="../Css/waveEffects.css">
    <link rel="stylesheet" href="../Css/darAlta.css">

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Portal de ofertas trabajo temporal">
    <link rel="shortcut icon" href="../Img/AgioGlobal i Azul Oscuro.png">
    <title>AgioGlobal</title>
</head>

<body style="width: 100%;">

    <div class="header">
        <!--Content before waves-->
        <div class="inner-header flex">
            <!--Just the logo.. Don't mind this-->
            <!-- AQUI -->
            <div class="inicio">
                <div class="login">
                    <div class="logo">
                        <img src="../Img/logoColor.png" alt="Logo Agio" class="logo">
                    </div>
                    <div class="welcome">
                        Rellene los siguientes campos:
                    </div>
                    <form action="./enviarNuevoUsuario.php" enctype="multipart/form-data" method="post" class="form aniadir">
                        <div class="infoAlta">
                            <div class="dato">
                                <label for="nombre">Nombre: <b>*</b> </label>
                                <input type="text" placeholder="Nombre" id="Nombre" name="Nombre" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+" title="Solo se permiten letras" required>
                            </div>
                            <div class="dato">
                                <label for="ape1">Primer Apellido: <b>*</b></label>
                                <input type="text" placeholder="Primer Apellido" id="ape1" name="ape1" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+" title="Solo se permiten letras" required>
                            </div>
                            <div class="dato">
                                <label for="ape2">Segundo Apellido:</label>
                                <input type="text" placeholder="Segundo Apellido" id="ape2" name="ape2" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+" title="Solo se permiten letras">
                            </div>
                            <div class="dato">
                                <label for="mail">Email: <b>*</b></label>
                                <input type="email" placeholder="Email" id="mail" name="mail" required>
                            </div>
                            <div class="dato">
                                <label for="telf">Teléfono: <b>*</b></label>
                                <input type="tel" placeholder="Nº de telefono" id="telf" name="telf" pattern="^\d{9}$" required>
                            </div>
                            <!-- <div class="dato">
                                <label for="date">Fecha Nacimiento: <b>*</b></label>
                                <input type="date" placeholder="Email" id="date" name="date" title="Tienes que tener mínimo 16 años" required>
                            </div> -->
                            <div class="dato passwd"><label>Contraseña: <b>*</b></label>
                                <input title="No acepta ni Ñ ni carácteres especiales" type="password" name="passwd" placeholder="Contraseña" pattern="^[a-zA-Z0-9@#$%^&*()\-_=+{}[\]\\|;:'\,.<>?/!`~]{6,}$" required>
                                <div class="mostrar" onclick="mostrarPass(this)"><img src="../Img/ojo.png" alt="Mostrar" /></div>
                            </div>
                            <div class="dato passwd"><label for="passwdRepeat">Confirmar Contraseña: <b>*</b></label>
                                <input title="No acepta ni Ñ ni carácteres especiales" type="password" name="passwdRepeat" id="passwdRepeat" placeholder="Contraseña" pattern="^[a-zA-Z0-9@#$%^&*()\-_=+{}[\]\\|;:'\,.<>?/!`~]{6,}$" required>
                                <div class="mostrar" onclick="mostrarPass(this)"><img src="../Img/ojo.png" alt="Mostrar" /></div>
                            </div>
                        </div>
                        <input type="submit" name="darAlta" id="" value="Darme de alta">
                        <p><i>Los campos marcados con <b>*</b> son obligatorios </i></p>
                    </form>
                </div>
            </div>
            <!-- FIN -->

            <!-- <script>
                window.addEventListener('DOMContentLoaded', function() {
                    // Obtener la fecha actual
                    const today = new Date();
                    // Calcular la fecha de hace 17 años
                    const year = today.getFullYear() - 16;
                    const month = today.getMonth() + 1; // Los meses en JS empiezan en 0
                    const day = today.getDate();

                    // Dar formato a la fecha para el atributo max
                    const maxDate = `${year}-${month.toString().padStart(2, '0')}-${day.toString().padStart(2, '0')}`;

                    // Asignar la fecha calculada al input como valor máximo
                    document.getElementById('date').setAttribute('max', maxDate);
                });
            </script> -->
        </div>

        <!--Waves Container-->
        <div style="padding-top: 4rem;margin-top:4rem">
            <svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
                <defs>
                    <path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
                </defs>
                <g class="parallax">
                    <use xlink:href="#gentle-wave" x="48" y="0" fill="var(--lightBlue)" />
                    <use xlink:href="#gentle-wave" x="48" y="3" fill="var(--darkBlue)" />
                    <use xlink:href="#gentle-wave" x="48" y="5" fill="var(--lightBlue)" />
                </g>
            </svg>
        </div>
        <!--Waves end-->

    </div>
    <!--Header ends-->
</body>

</html>