<?php
require_once("../Funciones/funciones.php");
require '../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable('../');
$dotenv->load();
if (isset($_COOKIE['mailUsuario']) && isset($_GET['nameOf'])) { ?>

    <html lang="es" dir="ltr">

    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="../Js/home.js"></script>
        <link rel="stylesheet" href="../CSS/common.css">
        <link rel="stylesheet" href="../CSS/ofertasCompletas.css">

        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Portal de candidatos empresa de trabajo temporal">
        <title>AgioGlobal Portal Candidatos</title>
        <link rel="shortcut icon" href="../Img/AgioGlobal i Azul Oscuro.png">
    </head>

    <body onscroll="mostrarMenuSombra(this)">
        <?php generarMenuHorizontal();
        $infoUsuario = login($_COOKIE['mailUsuario'], $_COOKIE['pwd'], ' ');
        $listadoOfertas = listadoOfertas($_GET['nameOf'], true);
        ?>
        <div class="descripcionOfertaWrap">
            <div class="imagenBanner">
                <h2 class="headline"><?php echo $listadoOfertas[0]['titulo'] ?></h2>
            </div>
            <div class="descripcionOferta">
            <form action="./inscripcionOferta.php" enctype="multipart/form-data" method="post" class="form ajustes">
            <input type="text" class="ocultar" name="idUsuario" value="<?php echo $infoUsuario['idUsuarioPortalEmpleo']; ?>">
                    <input type="text" class="ocultar" name="idOferta" value="<?php echo $_GET['nameOf']; ?>">
                    <input type="submit" value="Inscribirme" name="inscripcion">
                </form>
                <div class="up">
                <?php if (is_null($listadoOfertas[0]['logoAG'])) { ?>
                                <img src="../Img/Logos/LogoColor.png" alt="Logo Oferta">
                            <?php } else { ?>
                                <img src="<?php echo $listadoOfertas[0]['logoAG']; ?>" alt="Logo Oferta">
                            <?php } ?>
                    <div class="info">
                        <div class="ubicacion"><?php echo $listadoOfertas[0]['poblacion'] . ' | ' . mb_convert_case(mb_strtolower($listadoOfertas[0]['provincia'], 'UTF-8'), MB_CASE_TITLE, "UTF-8") . ' | ' . mb_convert_case(mb_strtolower($listadoOfertas[0]['pais'], 'UTF-8'), MB_CASE_TITLE, "UTF-8"); ?></div>
                        <div class="fecha">
                            <?php
                            $fechaPublicacion = new DateTime($listadoOfertas[0]['fechaPublicacion']);
                            $fechaSistema = new DateTime();
                            $diferencia = $fechaSistema->diff($fechaPublicacion);
                            if ($diferencia->days < 1) {
                                // Si es menos de un día, mostramos las horas
                                $horas = $diferencia->h + ($diferencia->days * 24); // Incluye las horas completas
                                echo "hace " . $horas . "h";
                            } else {
                                // Si es un día o más, mostramos los días
                                echo "hace " . $diferencia->days . " días";
                            }
                            ?>
                        </div>
                        <div class="data">
                            <div class="puesto"> <b>Puesto: </b> <?php echo $listadoOfertas[0]['puesto'] ?></div>
                            <div class="jornada"> <b>Jornada: </b> <?php echo $listadoOfertas[0]['jornada'] ?></div>
                            <div class="experiencia"><b>Experiencia: </b><?php echo $listadoOfertas[0]['experiencia'] ?></div>
                            <?php if (!is_null($listadoOfertas[0]['salarioMinimo']) && !is_null($listadoOfertas[0]['salarioMaximo'])) { ?>
                                <div class="salario"> <b>Salario:</b> <?php echo $listadoOfertas[0]['salarioMinimo'] . ' -- ' .  $listadoOfertas[0]['salarioMaximo'] . ' brutos/año'; ?> </div>
                            <?php } elseif (!is_null($listadoOfertas[0]['salarioMinimo']) && is_null($listadoOfertas[0]['salarioMaximo'])) { ?>
                                <div class="salario"> <b>Salario:</b> <?php echo $listadoOfertas[0]['salarioMinimo'] . ' brutos/año'; ?> </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="down">
                    <div class="descripcion">
                        <h2>Descripción del puesto</h2>
                        <div class="info">
                            <div class="txt"><?php echo $listadoOfertas[0]['descripcion']; ?></div>
                            <h3>Funciones: </h3>
                            <div class="requisitos">
                                <?php foreach ($listadoOfertas[0]['funciones'] as $funcion) { ?>
                                    <div class="requisito"><?php echo $funcion['funcion']; ?></div>
                                <?php } ?>
                            </div>
                            <h3>Ofrecemos: </h3>
                            <div class="requisitos">
                                <?php foreach ($listadoOfertas[0]['seOfrece'] as $ofrece) { ?>
                                    <div class="requisito"><?php echo $ofrece['seOfrece']; ?></div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="requisitosWrap">
                        <h2>Requisitos</h2>
                        <div class="info">
                            <div class="requisitos">
                                <?php foreach ($listadoOfertas[0]['requisitos'] as $requisito) { ?>
                                    <div class="requisito"><?php echo $requisito['requisito']; ?></div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="valorable">
                        <h2>Valorable</h2>
                        <div class="info">
                            <div class="requisitos">
                                <?php foreach ($listadoOfertas[0]['seValorara'] as $seValorara) { ?>
                                    <div class="requisito"><?php echo $seValorara['seValorara']; ?></div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
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


<?php
} else {
    header('Location: ../Login/login.php');
}
