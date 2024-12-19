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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
        <script src="../Js/home.js"></script>
        <script src="../Js/datosContratacion.js"></script>
        <link rel="stylesheet" href="../CSS/common.css">
        <link rel="stylesheet" href="../CSS/datosContratacion.css">

        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Portal de candidatos empresa de trabajo temporal">
        <title>AgioGlobal Portal Candidatos</title>
        <link rel="shortcut icon" href="../Img/AgioGlobal i Azul Oscuro.png">
    </head>

    <body id="contenidoPDF" onscroll="mostrarMenuSombra(this)">
        <?php
        generarMenuHorizontal();
        $infoUsuario = login($_COOKIE['mailUsuario'], $_COOKIE['pwd'], ' '); ?>
        <h2 class="headlineEnter">Datos de Contratación</h2>
        <div class="datosWrap">
            <?php if (!is_null($infoUsuario['foto'])) { ?>
                <div class="iniciales">
                    <!-- Botón de enviar con la clase 'iniciales' -->
                    <img src="<?php echo $infoUsuario['foto']; ?>" alt="Foto perfil">

                </div>
            <?php } else {
                $iniciales = getIniciales(quitarAcentos($infoUsuario['nombre'] . ' ' . $infoUsuario['apellido1'])); ?>
                <div class="iniciales ver">
                    <?php echo $iniciales; ?>
                </div>
            <?php } ?>
            <div class="formulario">
                <form style='width: 100%;' action="./actualizarDatosContratacion.php" enctype="multipart/form-data" method="post" class="form borrar" id="uploadForm">
                    <div class="editarButton blue personal" onclick="mostrarEditarDatosContratacion(this);">Editar</div>
                    <div class="datoContratacion">
                        <div class="dato">
                            <b>
                                Fecha Nacimiento:
                            </b>
                            <div class="together">
                                <?php
                                if (!empty($infoUsuario['fechaNacimiento'])) {
                                    $fechaNacimiento = new DateTime($infoUsuario['fechaNacimiento']);
                                    $fechaFormateada = $fechaNacimiento->format('d/m/Y');
                                    echo $fechaFormateada;
                                } else {
                                    $fechaNacimiento = '';
                                }
                                ?>
                            </div>
                            <?php if (!isset($_GET['emailUsuario']) && !isset($_GET['enter'])) { ?> <div class="separated">
                                    <?php
                                    if (empty($infoUsuario['fechaNacimiento'])) {
                                        $fechaInput = "";
                                    } else {
                                        $fechaInput = $fechaNacimiento->format('Y-m-d');
                                    }
                                    ?>
                                    <input type="date" id="fechaNacimiento" name="fechaNacimiento" disabled value="<?php echo $fechaInput; ?>">
                                </div>
                            <?php } ?>
                        </div>

                        <div class="dato">
                            <b>Lugar de Nacimiento:</b>
                            <div class="together">
                                <?php
                                if (!empty($infoUsuario['lugarNacimiento'])) {
                                    echo mb_convert_case(mb_strtolower($infoUsuario['lugarNacimiento'], 'UTF-8'), MB_CASE_TITLE, 'UTF-8');
                                } else {
                                    echo '';
                                }
                                ?>
                            </div>
                            <?php if (!isset($_GET['emailUsuario']) && !isset($_GET['enter'])) { ?>
                                <div class="separated">
                                    <?php
                                    if (empty($infoUsuario['lugarNacimiento'])) {
                                        $lugar = "";
                                    } else {
                                        $lugar = mb_convert_case(mb_strtolower($infoUsuario['lugarNacimiento'], 'UTF-8'), MB_CASE_TITLE, 'UTF-8');
                                    }
                                    ?>
                                    <input type="text" name="lugarNacimiento" disabled value="<?php echo $lugar; ?>">
                                </div>
                            <?php } ?>
                        </div>
                        <script>
                            $(document).ready(function() {
                                // Límite de edad (18 años)
                                const fechaLimite = new Date();
                                fechaLimite.setFullYear(fechaLimite.getFullYear() - 18);

                                // Función para validar si el usuario es menor de 18
                                function validarEdad(fechaNacimiento) {
                                    const fechaNac = new Date(fechaNacimiento);
                                    return fechaNac > fechaLimite; // Devuelve true si es menor de 18
                                }

                                // Función para mostrar u ocultar el HTML
                                function comprobarEdad() {
                                    const fechaNacimiento = $('#fechaNacimiento').val();
                                    if (fechaNacimiento && validarEdad(fechaNacimiento)) {
                                        $('#representanteLegal').show(); // Mostrar el HTML
                                    } else {
                                        $('#representanteLegal').hide(); // Ocultar el HTML
                                    }
                                }

                                // Ejecutar al cargar la página
                                comprobarEdad();

                                // Ejecutar al cambiar la fecha de nacimiento
                                $('#fechaNacimiento').on('change', function() {
                                    comprobarEdad();
                                });
                            });
                        </script>

                        <div class="dato">
                            <b>Fecha Caducidad <?php echo $infoUsuario['tipoDocumento']; ?>: </b>
                            <div class="together">
                                <?php if (!empty($infoUsuario['fechaCaducidadDNI'])) {
                                    $fechaCaducidadDNI = new DateTime($infoUsuario['fechaCaducidadDNI']);
                                    $fechaCaducidadDNI = $fechaCaducidadDNI->format('d/m/Y');
                                    echo $fechaCaducidadDNI;
                                } else {
                                    echo '';
                                } ?>
                            </div>
                            <?php if (!isset($_GET['emailUsuario']) && !isset($_GET['enter'])) { ?> <div class="separated">
                                    <?php
                                    if (empty($infoUsuario['fechaCaducidadDNI'])) {
                                        $fechaInput = "";
                                    } else {
                                        $fechaCaducidadDNI = new DateTime($infoUsuario['fechaCaducidadDNI']);

                                        $fechaInput = $fechaCaducidadDNI->format('Y-m-d');
                                    }
                                    ?>
                                    <input type="date" id="fechaCaducidadDNI" name="fechaCaducidadDNI" disabled value="<?php echo $fechaInput; ?>">
                                </div>
                            <?php } ?>
                        </div>

                        <div class="dato" id="representanteLegal">
                            <b>
                                Representante legal:
                            </b>
                            <div class="together">
                                <?php
                                echo "Nombre del Representante: " . ucfirst(strtolower($infoUsuario['nomRepresentante'])) .
                                    ", NIF del Representante: " . $infoUsuario['nifRepresentante'] .
                                    ", Tipo de Representante: " . $infoUsuario['tipoRepresentante'];
                                ?>
                            </div>
                            <?php if (!isset($_GET['emailUsuario']) && !isset($_GET['enter'])) { ?> <div class="separated">
                                    <input type="text" name="nomRepre" placeholder="Nombre representante" value="<?php echo $infoUsuario['nomRepresentante']; ?>">
                                    <input type="text" name="nifRepre" placeholder="NIF representante" value="<?php echo $infoUsuario['nifRepresentante']; ?>">

                                    <?php $tiposRepresentante = [
                                        "Padre",
                                        "Madre",
                                        "Tutor"
                                    ]; ?>
                                    <select name="tipoRepre" id="">
                                        <option value="" selected disabled>--Seleccione un tipo de representante--</option>
                                        <?php foreach ($tiposRepresentante as $tipo) {
                                            if ($tipo == $infoUsuario['tipoRepresentante']) { ?>
                                                <option selected value="<?php echo $tipo; ?>"><?php echo $tipo; ?></option>
                                            <?php } else { ?>
                                                <option value="<?php echo $tipo; ?>"><?php echo $tipo; ?></option>
                                        <?php }
                                        } ?>
                                    </select>
                                </div>
                            <?php } ?>
                        </div>

                        <!-- <div class="dato especial">
                                    <b>
                                        <div class="icon">&#x26a4</div>Género:
                                    </b>
                                    <div class="together">
                                        <?php //echo $infoUsuario['sexo']; 
                                        ?>
                                    </div>
                                    <div class="separated">
                                        <?php
                                        /*if ($infoUsuario['sexo'] == 'M') { ?>
                                            <input type="radio" disabled id="H" name="sexo" value="H">
                                            <label for="H">Hombre</label>
                                            <input type="radio" checked disabled id="M" name="sexo" value="M">
                                            <label for="M">Mujer</label>
                                        <?php } else { ?>
                                            <input type="radio" checked disabled id="H" name="sexo" value="H">
                                            <label for="H">Hombre</label>
                                            <input type="radio" disabled id="M" name="sexo" value="M">
                                            <label for="M">Mujer</label>
                                        <?php } */ ?>
                                    </div>
                                </div> -->
                        <div class="dato">
                            <b>
                                Nacionalidad
                            </b>
                            <div class="together"><?php echo mb_convert_case(mb_strtolower($infoUsuario['nacionalidad'], 'UTF-8'), MB_CASE_TITLE, 'UTF-8'); ?></div>
                            <?php if (!isset($_GET['emailUsuario']) && !isset($_GET['enter'])) { ?>
                                <div class="separated">
                                    <?php $nacionalidades = nacionalidades(); ?>
                                    <select name="nacionalidad" id="nacionalidadesSelect">
                                        <option value="" selected disabled>--Seleccione una nacionalidad--</option>
                                        <?php foreach ($nacionalidades as $nacionalidad) {
                                            if (mb_convert_case(mb_strtolower($nacionalidad['descripcion'], 'UTF-8'), MB_CASE_TITLE, 'UTF-8') == mb_convert_case(mb_strtolower($infoUsuario['nacionalidad'], 'UTF-8'), MB_CASE_TITLE, 'UTF-8')) { ?>
                                                <option selected value="<?php echo $nacionalidad['id'] ?>" data-pertenece-ue="<?php echo $nacionalidad['perteneceUE'] ?>">
                                                    <?php echo mb_convert_case(mb_strtolower($nacionalidad['descripcion'], 'UTF-8'), MB_CASE_TITLE, 'UTF-8'); ?>
                                                </option>
                                            <?php } else { ?>
                                                <option value="<?php echo $nacionalidad['id'] ?>" data-pertenece-ue="<?php if ($nacionalidad['perteneceUE']) {
                                                                                                                            echo 'T';
                                                                                                                        } else {
                                                                                                                            echo 'F';
                                                                                                                        }
                                                                                                                        ?>">
                                                    <?php echo mb_convert_case(mb_strtolower($nacionalidad['descripcion'], 'UTF-8'), MB_CASE_TITLE, "UTF-8"); ?>
                                                </option>
                                        <?php }
                                        } ?>
                                    </select>
                                    <!-- El campo de texto que se actualizará -->
                                    <input type="text" class="ocultar" name="perteneceUE" id="ueStatusInput" placeholder="Pertenece a la UE" readonly>
                                </div>
                            <?php } ?>

                        </div>
                        <?php if ($infoUsuario['perteneceUE'] == false) { ?>
                            <div class="dato" id='permisoTrabajoContainer'>
                                <b>
                                    Permiso de trabajo:
                                </b>

                                <div class="together">
                                    <?php
                                    if (!is_null($infoUsuario['fechaConcesionPermisoTrabajo'])) {
                                        $fechaInicio = new DateTime($infoUsuario['fechaConcesionPermisoTrabajo']);
                                        $fechaInicio = $fechaInicio->format('d/m/Y');

                                        $fechaFin = new DateTime($infoUsuario['fechaCaducidadPermisoTrabajo']);
                                        $fechaFin = $fechaFin->format('d/m/Y');

                                        echo $fechaInicio . ' -- ' . $fechaFin;
                                    } else {
                                        echo '';
                                    }
                                    ?>
                                </div>
                                <?php if (!isset($_GET['emailUsuario']) && !isset($_GET['enter'])) { ?> <div class="separated">
                                        <?php $fechaInicio = new DateTime($infoUsuario['fechaConcesionPermisoTrabajo']);
                                        $fechaInicio = $fechaInicio->format('Y-m-d');

                                        $fechaFin = new DateTime($infoUsuario['fechaCaducidadPermisoTrabajo']);
                                        $fechaFin = $fechaFin->format('Y-m-d'); ?>
                                        <input type="date" name="fechaInicioPermisoTrabajo" disabled value="<?php echo $fechaInicio; ?>" id="">
                                        <input type="date" name="fechaFinPermisoTrabajo" disabled value="<?php echo $fechaFin; ?>" id="">
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } else { ?>
                            <div class="dato" id='permisoTrabajoContainer' style="display: none;">
                                <b>
                                    Permiso de trabajo:
                                </b>

                                <div class="together">
                                    <?php

                                    if (!empty($infoUsuario['fechaConcesionPermisoTrabajo'])) {
                                        $fechaInicio = new DateTime($infoUsuario['fechaConcesionPermisoTrabajo']);
                                        $fechaInicio = $fechaInicio->format('d/m/Y');

                                        $fechaFin = new DateTime($infoUsuario['fechaCaducidadPermisoTrabajo']);
                                        $fechaFin = $fechaFin->format('d/m/Y');

                                        echo $fechaInicio . ' -- ' . $fechaFin;
                                    } else {
                                        $fechaInicio = '';
                                        $fechaFin = '';
                                    } ?>
                                </div>
                                <?php if (!isset($_GET['emailUsuario']) && !isset($_GET['enter'])) { ?>
                                    <div class="separated">
                                        <?php
                                        // Verificar que ambas fechas estén presentes y no vacías
                                        if (!empty($infoUsuario['fechaConcesionPermisoTrabajo']) && !empty($infoUsuario['fechaCaducidadPermisoTrabajo'])) {
                                            try {
                                                // Depuración: Mostrar el valor de las fechas antes de formatear
                                                echo "Valor fechaConcesionPermisoTrabajo: " . $infoUsuario['fechaConcesionPermisoTrabajo'] . "<br>";
                                                echo "Valor fechaCaducidadPermisoTrabajo: " . $infoUsuario['fechaCaducidadPermisoTrabajo'] . "<br>";

                                                // Crear objetos DateTime para ambas fechas
                                                $fechaInicio = new DateTime($infoUsuario['fechaConcesionPermisoTrabajo']);
                                                $fechaInicio = $fechaInicio->format('Y-m-d');

                                                $fechaFin = new DateTime($infoUsuario['fechaCaducidadPermisoTrabajo']);
                                                $fechaFin = $fechaFin->format('Y-m-d');

                                                // Mostrar inputs con fechas
                                        ?>
                                                <input type="date" name="fechaInicioPermisoTrabajo" disabled value="<?php echo $fechaInicio; ?>" id="">
                                                <input type="date" name="fechaFinPermisoTrabajo" disabled value="<?php echo $fechaFin; ?>" id="">
                                            <?php
                                            } catch (Exception $e) {
                                                // Si hay una excepción, mostrar mensaje de error y inputs vacíos
                                                echo "Error en la conversión de fechas.";
                                            ?>
                                                <input type="date" name="fechaInicioPermisoTrabajo" disabled value="" id="">
                                                <input type="date" name="fechaFinPermisoTrabajo" disabled value="" id="">
                                            <?php
                                            }
                                        } else {
                                            // Mostrar inputs vacíos si alguna fecha está ausente
                                            ?>
                                            <input type="date" name="fechaInicioPermisoTrabajo" disabled value="" id="">
                                            <input type="date" name="fechaFinPermisoTrabajo" disabled value="" id="">
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } ?>
                        <script>
                            document.getElementById('nacionalidadesSelect').addEventListener('change', function() {
                                // Obtén la opción seleccionada
                                var selectedOption = this.options[this.selectedIndex];

                                // Verifica el atributo personalizado 'data-pertenece-ue'
                                var perteneceUE = selectedOption.getAttribute('data-pertenece-ue');
                                var permisoTrabajoContainer = document.getElementById('permisoTrabajoContainer');

                                // Actualiza el campo de texto según si pertenece o no a la UE
                                var ueStatusInput = document.getElementById('ueStatusInput');

                                if (perteneceUE == 'T') {
                                    ueStatusInput.value = 'Pertenece a la UE';
                                    //permisoTrabajoContainer.style.display = 'none';
                                    $('#permisoTrabajoContainer').css("display", "none");
                                } else {
                                    ueStatusInput.value = 'No pertenece a la UE';
                                    //permisoTrabajoContainer.style.display = 'flex';
                                    $('#permisoTrabajoContainer').css("display", "flex");
                                }
                            });
                        </script>
                    </div>
                    <input type="text" class="ocultar" name="idUsuario" value="<?php echo $infoUsuario['idUsuarioPortalEmpleo']; ?>">
                    <input type="submit" class="actualizarDatos" name="actualizarDatosContratacion" value="Actualizar">
                </form>
            </div>
        </div>
        <div class="subirAutomatico" onclick="subir()">
            <img src="../Img/flecha-arriba.png" alt="Flecha Subir">
        </div>
    </body>

    <?php generarFooter() ?>

    </html>
<?php } else {
    header('Location: ../Login/login.php');
}
