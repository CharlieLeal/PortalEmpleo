<?php
require_once("../Funciones/funciones.php");
require '../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable('../');
$dotenv->load();
if (isset($_COOKIE['mailUsuario'])) { ?>
    <!DOCTYPE html>
    <html lang="es" dir="ltr">

    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
            <script src="../Js/home.js"></script>
        <script src="../Js/login.js"></script>
        <link rel="stylesheet" href="../CSS/common.css">
        <link rel="stylesheet" href="../CSS/ajustes.css">
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Portal de candidatos empresa de trabajo temporal">
        <title>AgioGlobal Portal Candidatos</title>
        <link rel="shortcut icon" href="../Img/AgioGlobal i Azul Oscuro.png">
    </head>

    <body onscroll="mostrarMenuSombra(this)">
        <?php generarMenuHorizontal();
        $infoUsuario = login($_COOKIE['mailUsuario'], $_COOKIE['pwd'],' '); ?>
        <h2 class="headlineEnter">Configuración</h2>
        <div class="ajustesWrap">
            <div class="foto">
                <?php if (!is_null($infoUsuario['foto'])) { ?>
                    <div class="iniciales">
                        <img src="<?php echo $infoUsuario['foto']; ?>" alt="Foto perfil">
                    </div>
                <?php } else {
                    $iniciales = getIniciales(quitarAcentos($infoUsuario['nombre'] . ' ' . $infoUsuario['apellido1'])); ?>
                    <div class="iniciales">
                        <?php echo $iniciales; ?>
                    </div>
                <?php } ?>
            </div>
            <div class="ajustesForm">
                <h2>Ajustes</h2>
                <form action="./ajustes.php" enctype="multipart/form-data" method="post" class="form ajustes">
                    <div class="dato">
                        <label for="cambioMail">Cambiar mi email</label>
                        <div class="buttons">
                            <input type="email" name="cambioMail" id="cambioMail" placeholder="Introduzca su email" value="<?php echo $infoUsuario['email']; ?>">
                            <input type="submit" name="cambioMailButton" value="Cambiar email">
                        </div>
                    </div>
                    <div class="dato">
                        <label for="cambioPass">Cambiar mi contraseña</label>
                        <div class="buttons">
                            <input type="password" name="cambioPass" id="cambioPass" placeholder="Introduzca su nueva contraseña">
                            <div class="mostrar" onclick="mostrarPass2(this)"><img src="../Img/ojo.png" alt="Mostrar" /></div>
                            <input type="submit" name="cambioPassButton" value="Cambiar contraseña">
                        </div>
                    </div>
                    <input type="text" class="ocultar" name="idUsuario" value="<?php echo $infoUsuario['idUsuarioPortalEmpleo']; ?>">
                </form>
            </div>
        </div>
        <div id="loading-screen">
            <div class="spinner"></div>
            <div class="loading-text">Actualizando datos...</div>
        </div>
        <script>
            // Capturar el envío del formulario
            $('form').on('submit', function(e) {
                // Mostrar pantalla de carga cuando se envía el formulario
                $('#loading-screen').fadeIn();

                // Dejar que el formulario se envíe de forma natural (no cancelamos el envío)
            });

            // Ocultar la pantalla de carga cuando se recargue la página o finalice el proceso
            $(window).on('load', function() {
                $('#loading-screen').fadeOut();

            });
        </script>
        <div class="subirAutomatico" onclick="subir()">
            <img src="../Img/flecha-arriba.png" alt="Flecha Subir">
        </div>
        
    </body>
    <?php generarFooter(); ?>

    </html>
<?php } else {
    header('Location: ../Login/login.php');
}
