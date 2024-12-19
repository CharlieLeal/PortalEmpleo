<?php
require_once("../Funciones/funciones.php");
?>

<!DOCTYPE html>
<html lang="es" dir="ltr">

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="../Js/home.js"></script>
    <script src="../Js/ofertas.js"></script>
    <link rel="stylesheet" href="../CSS/common.css">
    <link rel="stylesheet" href="../CSS/ofertas.css">

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Portal de candidatos empresa de trabajo temporal">
    <title>AgioGlobal Portal Candidatos</title>
    <link rel="shortcut icon" href="../Img/AgioGlobal i Azul Oscuro.png">
</head>

<body>
    <?php generarMenuHome();
    //generarMenuHorizontalBlanco(); 
    ?>

    <div class="cuerpoHome">
        <div class="enlacesPortalEmpleo">
            <a target="_blank" href="https://www.linkedin.com/company/agioglobal-working-together/mycompany/">
                <img src="../Img/linkedin.png" alt="Logo Portal Empleo">
            </a>
            <a target="_blank" href="https://www.infojobs.net/jobsearch/search-results/list.xhtml?keyword=Agioglobal&segmentId=&page=1&sortBy=PUBLICATION_DATE&onlyForeignCountry=false&countryIds=17&sinceDate=ANY">
                <img src="../Img/logoInfoJobsWhite.svg" alt="Logo Portal Empleo">
            </a>
            <a target="_blank" href="https://jobtoday.com/es/trabajos-agioglobal">
                <img src="../Img/jobToday.png" alt="Logo Portal Empleo">
            </a>
        </div>

        <div class="ofertasWrap">
            <h2 class="headline">
                Tenemos las mejores ofertas pensadas para ti...
            </h2>
            <div class="listadoOfertas">
                <?php
                if (!isset($_GET['idOferta'])) {

                    if (isset($_COOKIE['mailUsuario'])) {
                        $listadoOfertas = listadoOfertas('0', true);
                    } else {
                        $listadoOfertas = listadoOfertas('0', false);
                    }

                    foreach ($listadoOfertas as $oferta) { ?>
                        <div class="oferta" data-titulo="<?php echo $oferta['titulo']; ?>" data-descripcion="<?php echo $oferta['descripcion']; ?>" data-poblacion="<?php echo $oferta['poblacion']; ?>" data-ubicacion="<?php echo $oferta['provincia']; ?>" data-technology="<?php echo $oferta['esTechnology'] ? 'true' : 'false'; ?>">
                            <img src="<?php echo $oferta['logoAG']; ?>" alt="Logo Oferta">
                            <div class="infoOferta">
                                <div class="tit"><?php echo $oferta['titulo']; ?></div>
                                <div class="puesto"><?php echo $oferta['puesto'] . ' (' . $oferta['jornada'] . ')'; ?></div>

                                <?php if ($oferta['teletrabajo'] == true) { ?>
                                    <div class="ubicacion"><?php echo $oferta['poblacion'] . ' | ' . mb_convert_case(mb_strtolower($oferta['provincia'], 'UTF-8'), MB_CASE_TITLE, "UTF-8") . ' | ' . mb_convert_case(mb_strtolower($oferta['pais'], 'UTF-8'), MB_CASE_TITLE, "UTF-8") . ' | Teletrabajo'; ?></div>
                                <?php } else { ?>
                                    <div class="ubicacion"><?php echo $oferta['poblacion'] . ' | ' . mb_convert_case(mb_strtolower($oferta['provincia'], 'UTF-8'), MB_CASE_TITLE, "UTF-8") . ' | ' . mb_convert_case(mb_strtolower($oferta['pais'], 'UTF-8'), MB_CASE_TITLE, "UTF-8") . ' | Presencial'; ?></div>
                                <?php  } ?>

                                <div class="fecha">
                                    <?php
                                    $fechaPublicacion = new DateTime($oferta['fechaPublicacion']);
                                    $fechaSistema = new DateTime();

                                    // Comparar solo las fechas (sin horas)
                                    if ($fechaPublicacion->format('Y-m-d') === $fechaSistema->format('Y-m-d')) {
                                        echo "<p class = hoy>hoy</p>";
                                    } else {
                                        $diferencia = $fechaSistema->diff($fechaPublicacion);

                                        if ($diferencia->days < 1) {
                                            // Si es menos de un día, mostramos las horas
                                            $horas = $diferencia->h + ($diferencia->days * 24); // Incluye las horas completas
                                            echo "hace " . $horas . "h";
                                        } else {
                                            // Si es un día o más, mostramos los días
                                            echo "hace " . $diferencia->days . " días";
                                        }
                                    }
                                    ?>
                                </div>

                                <div class="descripcionPuesto">
                                    <?php echo '<b>Descripción: </b> ' . $oferta['descripcionCorta']; ?>
                                </div>
                                <a href="<?php echo '../Ofertas/index.php?nameOf=' . $oferta['id']; ?>" class="buttonInscripcion"> Saber más </a>
                            </div>
                        </div>
                    <?php } //de for each 
                } else {
                    if (isset($_COOKIE['mailUsuario'])) {
                        $listadoOfertas = listadoOfertas($_GET['idOferta'], true);
                    } else {
                        $listadoOfertas = listadoOfertas($_GET['idOferta'], false);
                    }

                    foreach ($listadoOfertas as $oferta) { ?>
                        <div class="oferta" data-titulo="<?php echo $oferta['titulo']; ?>" data-descripcion="<?php echo $oferta['descripcion']; ?>" data-poblacion="<?php echo $oferta['poblacion']; ?>" data-ubicacion="<?php echo $oferta['provincia']; ?>" data-technology="<?php echo $oferta['esTechnology'] ? 'true' : 'false'; ?>"> <img src="../Img/LogoColor.png" alt="Logo Oferta">
                            <div class="infoOferta">
                                <div class="tit"><?php echo $oferta['titulo']; ?></div>
                                <div class="puesto"><?php echo $oferta['puesto'] . ' (' . $oferta['jornada'] . ')'; ?></div>

                                <?php if ($oferta['teletrabajo'] == true) { ?>
                                    <div class="ubicacion"><?php echo $oferta['poblacion'] . ' | ' . mb_convert_case(mb_strtolower($oferta['provincia'], 'UTF-8'), MB_CASE_TITLE, "UTF-8") . ' | ' . mb_convert_case(mb_strtolower($oferta['pais'], 'UTF-8'), MB_CASE_TITLE, "UTF-8") . ' | Teletrabajo'; ?></div>
                                <?php } else { ?>
                                    <div class="ubicacion"><?php echo $oferta['poblacion'] . ' | ' . mb_convert_case(mb_strtolower($oferta['provincia'], 'UTF-8'), MB_CASE_TITLE, "UTF-8") . ' | ' . mb_convert_case(mb_strtolower($oferta['pais'], 'UTF-8'), MB_CASE_TITLE, "UTF-8") . ' | Presencial'; ?></div>
                                <?php  } ?>

                                <div class="fecha">
                                    <?php
                                    $fechaPublicacion = new DateTime($oferta['fechaPublicacion']);
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
                                <div class="descripcionPuesto">
                                    <?php echo '<b>Descripción: </b> ' . $oferta['descripcion']; ?>
                                </div>
                                <div class="descripcionPuesto masInformacion">
                                    <?php echo '<b>Funciones: </b> ';
                                    foreach ($oferta['funciones'] as $funcion) {
                                        echo $funcion['funcion'] . ' | ';
                                    }
                                    echo '<br><b>Experiencia mínima: </b> ' . $oferta['experiencia'];
                                    echo '<br><b>Requisitos: </b> ';
                                    foreach ($oferta['requisitos'] as $requisito) {
                                        echo $requisito['requisito'] . ' | ';
                                    }
                                    ?>
                                </div>
                                <div class="verMas" onclick="verMasDescripcionOferta(this)">Ver más +</div>
                                <a href="<?php echo '../Ofertas/index.php?nameOf=' . $oferta['id']; ?>" class="buttonInscripcion"> Inscribirme </a>
                            </div>
                        </div>
                <?php
                    }
                }
                ?>
            </div>
            <!-- Contenedor del paginador -->
            <div id="paginador"></div>
        </div>
    </div>

    <div class="subirAutomatico" onclick="subir()">
        <img src="../Img/flecha-arriba.png" alt="Flecha Subir">
    </div>
    <script>
        // Agregar eventos a los inputs y el select
        document.getElementById("buscadorPuesto").addEventListener("keyup", filtrarOfertas);
        document.getElementById("buscadorMunicipio").addEventListener("keyup", filtrarOfertas);
        document.getElementById("provincias").addEventListener("change", filtrarOfertas);
    </script>
</body>

<?php generarFooter(); ?>