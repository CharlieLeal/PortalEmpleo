<?php
require_once("../Funciones/funciones.php");
require '../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable('../');
$dotenv->load();
if (isset($_COOKIE['mailUsuario'])) { ?>

    <html lang="es" dir="ltr">

    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="../Js/home.js"></script>
        <script src="../Js/candidaturas.js"></script>
        <link rel="stylesheet" href="../CSS/common.css">
        <link rel="stylesheet" href="../CSS/candidaturas.css">

        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Portal de candidatos empresa de trabajo temporal">
        <title>AgioGlobal Portal Candidatos</title>
        <link rel="shortcut icon" href="../Img/AgioGlobal i Azul Oscuro.png">
    </head>

    <body onscroll="mostrarMenuSombra(this)">
        <?php generarMenuHorizontal();
        $infoUsuario = login($_COOKIE['mailUsuario'], $_COOKIE['pwd'], ' ');
        $ofertasCandidato = ofertasCandidato($infoUsuario['idUsuarioPortalEmpleo']);
        ?>
        <h2 class="headlineEnter">Mis candidaturas</h2>

        <div class="filtros">
            <img src="../Img/filtrar.png" alt="Imagen de filtro" id="filtroImagen">
            <div class="estadosFiltro" id='filtroOpciones'>
                <label>Estado de la candidatura:</label>
                <div>
                    <input type="radio" id="estadoTodos" name="estadoCandidatura" value="" checked onclick="filtrarOfertasPorEstado()">
                    <label for="estadoTodos">Todas</label>
                </div>
                <div>
                    <input type="radio" id="estadoPendiente" name="estadoCandidatura" value="A la espera" onclick="filtrarOfertasPorEstado()">
                    <label for="estadoPendiente">A la espera</label>
                </div>
                <div>
                    <input type="radio" id="estadoProceso" name="estadoCandidatura" value="En Proceso" onclick="filtrarOfertasPorEstado()">
                    <label for="estadoTodos">En proceso</label>
                </div>
                <div>
                    <input type="radio" id="estadoAceptada" name="estadoCandidatura" value="Aceptado" onclick="filtrarOfertasPorEstado()">
                    <label for="estadoAceptada">Aceptada</label>
                </div>
                <div>
                    <input type="radio" id="estadoRechazada" name="estadoCandidatura" value="Descartado" onclick="filtrarOfertasPorEstado()">
                    <label for="estadoRechazada">Descartado</label>
                </div>
            </div>
        </div>

        <div class="ofertasCandidato">
            <?php foreach ($ofertasCandidato as $ofertas) { ?>
                <a href="../Ofertas/index.php?<?php echo 'nameOf=' . $ofertas['idOferta']; ?>">
                    <div class="ofertaResumen" data-estado="<?php echo $ofertas['estado']; ?>">
                        <div class="imagen">
                        <?php if (is_null($ofertas['logoAG'])) { ?>
                                <img src="../Img/Logos/LogoColor.png" alt="Logo Oferta">
                            <?php } else { ?>
                                <img src="<?php echo $ofertas['logoAG'];?>" alt="Logo Oferta">
                            <?php } ?>
                        </div>
                        <div class="ofertaResumenEstado">
                            <div class="columnas">
                                <div class="titulo"><?php echo $ofertas['titulo']; ?></div>
                                <div class="fecha">
                                    <?php
                                    $fechaPublicacion = new DateTime($ofertas['fechaPublicacion']);
                                    $fechaSistema = new DateTime();
                                    $diferencia = $fechaSistema->diff($fechaPublicacion);
                                    if ($diferencia->days < 1) {
                                        $horas = $diferencia->h + ($diferencia->days * 24);
                                        echo "hace " . $horas . "h";
                                    } else {
                                        echo "hace " . $diferencia->days . " días";
                                    }
                                    ?>
                                </div>
                                <div class="ubicacion">
                                    <?php echo $ofertas['poblacion'] . ' | ' . mb_convert_case(mb_strtolower($ofertas['provincia'], 'UTF-8'), MB_CASE_TITLE, "UTF-8"); ?>
                                </div>
                            </div>
                            <div class="estado">
                                <?php
                                echo 'Estado: <b style="color:' . $ofertas['colorEstado'] . ';">' . $ofertas['estado'] . '</b>';
                                ?>
                            </div>
                        </div>
                    </div>
                </a>
            <?php } ?>
        </div>

        <!-- Contenedor del paginador -->
        <div id="paginador"></div>

        <script>
            // Función para alternar el filtro con el efecto de desvanecimiento
            // Función para alternar el filtro con el efecto de desvanecimiento
            document.getElementById('filtroImagen').addEventListener('click', function() {
                $('.estadosFiltro').slideToggle(600);
                $('.estadosFiltro').toggleClass('open');
            });
        </script>

    </body>
    <?php generarFooter(); ?>

    </html>
<?php
} else {
    header('Location: ../Login/login.php');
}
