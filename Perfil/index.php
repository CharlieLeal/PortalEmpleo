<?php
require_once("../Funciones/funciones.php");
require '../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable('../');
$dotenv->load();
if (isset($_COOKIE['mailUsuario']) || (isset($_GET['emailUsuario']) && isset($_GET['enter']))) { ?>

    <!DOCTYPE html>
    <html lang="es" dir="ltr">

    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
        <script src="../Js/home.js"></script>
        <script src="../Js/perfil.js"></script>
        <link rel="stylesheet" href="../CSS/common.css">
        <link rel="stylesheet" href="../CSS/perfilCompleto.css">

        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Portal de candidatos empresa de trabajo temporal">
        <title>AgioGlobal Portal Candidatos</title>
        <link rel="shortcut icon" href="../Img/AgioGlobal i Azul Oscuro.png">
    </head>

    <body id="contenidoPDF" onscroll="mostrarMenuSombra(this)">
        <?php
        if (isset($_GET['emailUsuario']) && isset($_GET['enter'])) {
            $infoUsuario = login($_GET['emailUsuario'], ' ', $_GET['enter']); ?>
            <div class="menuNoHome">
                <div class="cabecera cabeceraNoHome" style="padding:2rem 0rem;width: 100%;display:block">
                    <img id="cabeceraIMG" style="display:block;margin: 0 auto; width: 20rem" src="../Img/LogoColor.png" alt="Logo">
                </div>
            </div>
        <?php
        } else {
            //generarMenuNoHome();
            generarMenuHorizontal();
            $infoUsuario = login($_COOKIE['mailUsuario'], $_COOKIE['pwd'], ' ');
        }
        if (!isset($_GET['emailUsuario']) && !isset($_GET['enter'])) { ?>
            <h2 class="headlineEnter">Mi perfil</h2>
        <?php } else {
            echo "<br><br>";
        } ?>
        <div class="perfilWrap">
            <div class="foto">
                <form action="./actualizarFoto.php" enctype="multipart/form-data" method="post" class="form aniadir" id="uploadFormFoto">
                    <input class="ocultar" name="idUsuario" type="text" value="<?php echo $infoUsuario['idUsuarioPortalEmpleo']; ?>">

                    <?php if (!is_null($infoUsuario['foto'])) { ?>
                        <div class="iniciales">
                            <!-- Botón de enviar con la clase 'iniciales' -->
                            <?php if (!isset($_GET['emailUsuario']) && !isset($_GET['enter'])) { ?>
                                <button type="button" class="iniciales" id="botonIniciales">
                                    <img src="<?php echo $infoUsuario['foto']; ?>" alt="Foto perfil">
                                    <p><img src="../Img/lapiz.png" alt="Editar"></p>
                                </button>
                            <?php } else { ?>
                                <img src="<?php echo $infoUsuario['foto']; ?>" alt="Foto perfil">
                            <?php } ?>
                        </div>
                    <?php } else {
                        $iniciales = getIniciales(quitarAcentos($infoUsuario['nombre'] . ' ' . $infoUsuario['apellido1'])); ?>
                        <div class="iniciales ver">
                            <!-- Botón de enviar con la clase 'iniciales' -->
                            <?php if (!isset($_GET['emailUsuario']) && !isset($_GET['enter'])) { ?>
                                <button type="button" class="iniciales" id="botonIniciales">
                                    <?php echo $iniciales; ?>
                                    <p><img src="../Img/lapiz.png" alt="Editar"></p>
                                </button>
                            <?php } else { ?>
                                <?php echo $iniciales; ?>
                            <?php } ?>
                        </div>
                    <?php } ?>

                    <!-- Input de archivo solo para PNG -->
                    <input type="file" name="foto" id="fileInputFoto" accept="image/png" style="display: none;">

                    <!-- Botón personalizado para subir archivo -->
                    <!-- <label for="fileInputFoto" class="custom-file-label">Actualizar foto</label> -->

                    <!-- Texto para mostrar el nombre del archivo seleccionado -->
                    <span id="file-name-display" style="display: none;"></span>

                    <!-- Botón de submit que estará oculto inicialmente -->
                    <input type="submit" value="Subir Foto" name="enviarFoto" id="submitFotoBtn" class="custom-submit" style="display:none;">
                </form>

                <script>
                    const fileInputFoto = document.getElementById('fileInputFoto');
                    const fileNameDisplay = document.getElementById('file-name-display');
                    const submitFotoBtn = document.getElementById('submitFotoBtn');
                    const botonIniciales = document.getElementById('botonIniciales');

                    // Evento para que el botón iniciales active el input de archivo
                    botonIniciales.addEventListener('click', function() {
                        fileInputFoto.click(); // Simula un clic en el input de archivo
                    });

                    // Validar el archivo seleccionado
                    fileInputFoto.addEventListener('change', function() {
                        const file = fileInputFoto.files[0];
                        if (file) {
                            if (file.type === "image/png") {
                                fileNameDisplay.textContent = file.name;
                                fileNameDisplay.style.display = 'block'; // Mostrar nombre de archivo válido
                                submitFotoBtn.style.display = 'block'; // Mostrar botón de enviar
                            } else {
                                fileNameDisplay.textContent = "El archivo debe ser una imagen PNG.";
                                fileNameDisplay.style.display = 'block'; // Mostrar mensaje de error
                                submitFotoBtn.style.display = 'none'; // Ocultar botón de enviar si el archivo no es válido
                            }
                        } else {
                            fileNameDisplay.style.display = 'none'; // Ocultar mensaje si no se selecciona un archivo
                            submitFotoBtn.style.display = 'none'; // Ocultar el botón de enviar
                        }
                    });
                </script>

                <?php
                if (is_null($infoUsuario['rutaCurriculum'])) { ?>
                    <form action="./subirCurriculum.php" enctype="multipart/form-data" method="post" class="form aniadir" id="uploadForm">
                        <div class="dato">
                            <input type="file" name="cv" id="fileInput">
                            <input class="ocultar" name="idUsuario" type="text" value="<?php echo $infoUsuario['idUsuarioPortalEmpleo']; ?>">

                            <!-- Botón personalizado -->
                            <label for="fileInput" class="custom-file-label">Subir CV</label>

                            <!-- Texto donde se mostrará el nombre del archivo seleccionado -->
                            <span id="file-name">No se ha seleccionado ningún archivo</span>

                            <!-- Botón de enviar que estará oculto inicialmente -->
                            <input type="submit" value="Enviar CV" name="enviarCV" id="submit-btn" style="display:none;">
                            <div id="error-message"></div>
                        </div>
                    </form>

                    <?php } else {
                    if (explode('.', explode('\\', $infoUsuario['rutaCurriculum'])[3])[1] == 'docx') { ?>
                        <a href="<?php echo $infoUsuario['rutaCurriculum']; ?>" title="Ver mi CV" download target="_blank" rel="noopener noreferrer"><img src="../Img/cv.png" alt="Icon CV" id="cv"></a>
                    <?php } else { ?>
                        <a href="<?php echo $infoUsuario['rutaCurriculum']; ?>" target="_blank" rel="noopener noreferrer"><img src="../Img/cv.png" alt="Icon CV" id="cv"></a>
                    <?php }  ?>

                    <form action="./subirCurriculum.php" enctype="multipart/form-data" method="post" class="form aniadir" id="uploadForm">
                        <div class="dato">
                            <input type="file" name="cv" id="fileInput">
                            <input class="ocultar" name="idUsuario" type="text" value="<?php echo $infoUsuario['idUsuarioPortalEmpleo']; ?>">

                            <!-- Botón personalizado -->
                            <?php if (!isset($_GET['emailUsuario']) && !isset($_GET['enter'])) { ?>
                                <label for="fileInput" class="custom-file-label">Actualizar CV</label>
                            <?php } ?>

                            <!-- Texto donde se mostrará el nombre del archivo seleccionado -->
                            <?php if (!isset($_GET['emailUsuario']) && !isset($_GET['enter'])) { ?>
                                <span id="file-name">No se ha seleccionado ningún archivo</span>
                            <?php } ?>

                            <!-- Botón de enviar que estará oculto inicialmente -->
                            <input type="submit" value="Enviar CV" name="enviarCV" id="submit-btn" style="display:none;">
                            <div id="error-message"></div>
                        </div>
                    </form>
                <?php } ?>

                <div class="datosProfesionales">
                    <div class="sobreMi misDatos" id="sobreMi">
                        <div class="headline">
                            <h2>Tengo interés en:</h2>
                            <?php if (!isset($_GET['emailUsuario']) && !isset($_GET['enter'])) { ?>
                                <div class="editarButton white" onclick="mostrarAniadirPerfil(this);">Editar</div>
                            <?php } ?>
                        </div>
                        <?php if (!isset($_GET['emailUsuario']) && !isset($_GET['enter'])) { ?>
                            <div class="datoModificar">
                                <div class="aniadir aniadirPerfil">
                                    <div class="button-abrir" onclick="habilitarAniadir(this);"> Añadir </div>
                                    <div class="informacion">
                                        <form action="./aniadirPerfil.php" enctype="multipart/form-data" method="post" class="form aniadir">
                                            <div class="dato">
                                                <?php
                                                $perfiles = perfiles();
                                                ?>
                                                <label for="search-input-perfil">Mis Perfiles:</label>
                                                <input type="text" id="search-input-perfil" name="perfilName" placeholder="Buscar perfiles..." autocomplete="off">
                                                <ul id="search-results-perfil" style="display: none;"></ul>
                                            </div>
                                            <input class="ocultar" name="idUsuario" type="text" value="<?php echo $infoUsuario['idUsuarioPortalEmpleo']; ?>">
                                            <input type="submit" class="button-abrir" name="aniadirPerfil" value="Añadir">
                                        </form>

                                        <script>
                                            // Convertir los perfiles de PHP a un array de JavaScript
                                            const perfiles = <?php echo json_encode($perfiles); ?>;
                                            const searchInput = document.getElementById('search-input-perfil');
                                            const searchResults = document.getElementById('search-results-perfil');

                                            // Mostrar la lista completa cuando se haga clic en el input
                                            searchInput.addEventListener('focus', function() {
                                                // Mostrar todos los perfiles al hacer clic en el input
                                                searchResults.innerHTML = ''; // Limpiar resultados anteriores
                                                perfiles.forEach(perfil => {
                                                    const li = document.createElement('li');
                                                    li.textContent = perfil.perfil.charAt(0).toUpperCase() + perfil.perfil.slice(1).toLowerCase();
                                                    li.addEventListener('click', function() {
                                                        searchInput.value = perfil.perfil.charAt(0).toUpperCase() + perfil.perfil.slice(1).toLowerCase();
                                                        searchResults.innerHTML = ''; // Limpiar la lista al seleccionar
                                                        searchResults.style.display = 'none'; // Ocultar la lista al seleccionar
                                                    });
                                                    searchResults.appendChild(li);
                                                });
                                                searchResults.style.display = 'flex'; // Mostrar la lista completa
                                            });

                                            // Filtrar los resultados mientras el usuario escribe
                                            searchInput.addEventListener('input', function() {
                                                const query = searchInput.value.toLowerCase();
                                                searchResults.innerHTML = ''; // Limpiar resultados anteriores

                                                if (query.length > 0) {
                                                    // Filtrar los perfiles localmente en función de lo que el usuario escribe
                                                    const resultadosFiltrados = perfiles.filter(perfil => perfil.perfil.toLowerCase().includes(query));

                                                    // Mostrar los resultados filtrados
                                                    resultadosFiltrados.forEach(perfil => {
                                                        const li = document.createElement('li');
                                                        li.textContent = perfil.perfil.charAt(0).toUpperCase() + perfil.perfil.slice(1).toLowerCase();
                                                        li.addEventListener('click', function() {
                                                            searchInput.value = perfil.perfil.charAt(0).toUpperCase() + perfil.perfil.slice(1).toLowerCase();
                                                            searchResults.innerHTML = ''; // Limpiar la lista al seleccionar
                                                            searchResults.style.display = 'none'; // Ocultar la lista al seleccionar
                                                        });
                                                        searchResults.appendChild(li);
                                                    });

                                                    // Si no hay resultados, mostrar un mensaje
                                                    if (resultadosFiltrados.length === 0) {
                                                        const li = document.createElement('li');
                                                        li.textContent = 'No se encontraron resultados';
                                                        searchResults.appendChild(li);
                                                    }
                                                } else {
                                                    // Si el input está vacío, mostrar la lista completa de nuevo
                                                    perfiles.forEach(perfil => {
                                                        const li = document.createElement('li');
                                                        li.textContent = perfil.perfil;
                                                        li.addEventListener('click', function() {
                                                            searchInput.value = perfil.perfil.charAt(0).toUpperCase() + perfil.perfil.slice(1).toLowerCase();
                                                            searchResults.innerHTML = '';
                                                            searchResults.style.display = 'none';
                                                        });
                                                        searchResults.appendChild(li);
                                                    });
                                                }
                                            });

                                            // Ocultar la lista si se hace clic fuera del input
                                            /* document.addEventListener('click', function(event) {
                                                if (!searchInput.contains(event.target) && !searchResults.contains(event.target)) {
                                                    searchResults.style.display = 'none';
                                                }
                                            }); */
                                        </script>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="dato oficial">
                            <form action="./aniadirPerfil.php" enctype="multipart/form-data" method="post" class="form borrar" id="uploadForm">
                                <?php foreach ($infoUsuario['perfiles'] as $perfil) {
                                    if (!isset($_GET['emailUsuario']) && !isset($_GET['enter'])) {
                                        $txt = '<button type="submit" name="borrarButton" value="' . $perfil["id"] . '" class="boton-borrar">
                                    <img src="../Img/papelera.png" alt="Icono Papelera">
                                    </button>';

                                        echo '<div class=data>' . mb_convert_case(mb_strtolower($perfil['perfil'], 'UTF-8'), MB_CASE_TITLE, "UTF-8")  . ' ' . $txt . ' </div>';
                                    } else {
                                        echo '<div class=data>' . mb_convert_case(mb_strtolower($perfil['perfil'], 'UTF-8'), MB_CASE_TITLE, "UTF-8") . '</div>';
                                    }
                                } ?>
                                <input type="text" class="ocultar" name="idUsuario" value="<?php echo $infoUsuario['idUsuarioPortalEmpleo']; ?>">
                            </form>
                        </div>
                    </div>
                    <div class="misIdiomas misDatos" id="misIdiomas">
                        <div class="headline">
                            <h2>Mis idiomas:</h2>
                            <?php if (!isset($_GET['emailUsuario']) && !isset($_GET['enter'])) { ?>
                                <div class="editarButton white" onclick="mostrarAniadirPerfil(this);">Editar</div>
                            <?php } ?>
                        </div>
                        <?php if (!isset($_GET['emailUsuario']) && !isset($_GET['enter'])) { ?> <div class="datoModificar">
                                <div class="aniadir aniadirIdioma">
                                    <div class="button-abrir" onclick="habilitarAniadir(this);"> Añadir </div>
                                    <div class="informacion">
                                        <form action="./aniadirIdioma.php" enctype="multipart/form-data" method="post" class="form aniadir">
                                            <div class="dato">
                                                <?php
                                                $idiomas = idiomas();
                                                $nivelesIdioma = nivelesIdioma();
                                                usort($nivelesIdioma, function ($a, $b) {
                                                    return $a['numNivel'] <=> $b['numNivel'];
                                                });
                                                ?>
                                                <label for="search-input-idiom">Mis idiomas:</label>
                                                <input type="text" id="search-input-idiom" name="idiomaName" placeholder="Buscar idiomas..." autocomplete="off">
                                                <ul id="search-results-idiom"></ul>

                                                <!-- Input oculto para almacenar el ID del idioma seleccionado -->
                                                <input class="ocultar" type="text" id="idIdiomaSeleccionado" name="idIdioma" value="">

                                                <!-- Ocultamos inicialmente la sección de nivel de idioma -->
                                                <div class="nivelIdioma nivel" style="display:none;">
                                                    Indique su nivel (de 0 a 6):
                                                    <label for="rangeInput">Nivel Oral:</label>
                                                    <input type="range" id="rangeInput" name="rangeInput" min="10" max="60" value="0" step="10" list="lista-rango">
                                                    <datalist id="lista-rango">
                                                        <?php foreach ($nivelesIdioma as $idiomaNivel) { ?>
                                                            <option value="<?php echo $idiomaNivel['numNivel'] ?>">
                                                            <?php } ?>
                                                    </datalist>
                                                    <span id="rangeValue">BAJO</span>

                                                    <label for="rangeInputEscrito">Nivel Escrito:</label>
                                                    <input type="range" id="rangeInputEscrito" name="rangeInputEscrito" min="10" max="60" value="0" step="10" list="lista-rango-escrito">
                                                    <datalist id="lista-rango-escrito">
                                                        <?php foreach ($nivelesIdioma as $idiomaNivel) { ?>
                                                            <option value="<?php echo $idiomaNivel['numNivel'] ?>">
                                                            <?php } ?>
                                                    </datalist>
                                                    <span id="rangeValueEscrito">BAJO</span>
                                                </div>
                                            </div>
                                            <input class="ocultar" name="idUsuario" type="text" value="<?php echo $infoUsuario['idUsuarioPortalEmpleo']; ?>">
                                            <input type="submit" name="aniadirIdioma" value="Añadir">
                                        </form>
                                    </div>

                                    <script>
                                        const idiomas = <?php echo json_encode($idiomas); ?>;
                                        const nivelesIdioma = <?php echo json_encode($nivelesIdioma); ?>;
                                        const searchInputIdiom = document.getElementById('search-input-idiom');
                                        const searchResultsIdiom = document.getElementById('search-results-idiom');
                                        const nivelIdioma = document.querySelector('.nivelIdioma'); // La sección a mostrar/ocultar
                                        const idIdiomaSeleccionado = document.getElementById('idIdiomaSeleccionado'); // Campo oculto para el ID del idioma

                                        // Ocultar inicialmente la lista de resultados
                                        searchResultsIdiom.style.display = 'none';

                                        const rangeInput = document.getElementById('rangeInput');
                                        const rangeValue = document.getElementById('rangeValue');

                                        const rangeInputEscrito = document.getElementById('rangeInputEscrito');
                                        const rangeValueEscrito = document.getElementById('rangeValueEscrito');

                                        // Mapeo de niveles a descripciones
                                        const nivelMap = {};
                                        nivelesIdioma.forEach(nivel => {
                                            nivelMap[nivel.numNivel] = nivel.descripcion;
                                        });

                                        // Actualizar el valor mostrado cuando el usuario cambia el rango
                                        rangeInput.addEventListener('input', function() {
                                            const selectedValue = parseInt(rangeInput.value, 10);
                                            rangeValue.textContent = nivelMap[selectedValue] || 'Nivel no definido';
                                        });

                                        rangeInputEscrito.addEventListener('input', function() {
                                            const selectedValue = parseInt(rangeInputEscrito.value, 10);
                                            rangeValueEscrito.textContent = nivelMap[selectedValue] || 'Nivel no definido';
                                        });

                                        // Mostrar la lista completa al hacer clic en el input
                                        searchInputIdiom.addEventListener('focus', function() {
                                            searchResultsIdiom.innerHTML = ''; // Limpiar resultados anteriores
                                            // Mostrar todos los idiomas al hacer clic en el input
                                            idiomas.forEach(idioma => {
                                                const li = document.createElement('li');
                                                li.textContent = idioma.descripcion.charAt(0).toUpperCase() + idioma.descripcion.slice(1).toLowerCase();
                                                li.addEventListener('click', function() {
                                                    searchInputIdiom.value = idioma.descripcion.charAt(0).toUpperCase() + idioma.descripcion.slice(1).toLowerCase();
                                                    searchResultsIdiom.innerHTML = ''; // Limpiar la lista al seleccionar
                                                    searchResultsIdiom.style.display = 'none'; // Ocultar la lista al seleccionar

                                                    // Mostrar la sección de nivel del idioma seleccionado
                                                    nivelIdioma.style.display = 'flex';
                                                    idIdiomaSeleccionado.value = idioma.id; // Guardar el ID del idioma seleccionado
                                                });
                                                searchResultsIdiom.appendChild(li);
                                            });
                                            searchResultsIdiom.style.display = 'block'; // Mostrar la lista
                                        });

                                        // Filtrar los resultados mientras el usuario escribe
                                        searchInputIdiom.addEventListener('input', function() {
                                            const query = searchInputIdiom.value.toLowerCase();
                                            searchResultsIdiom.innerHTML = ''; // Limpiar resultados anteriores
                                            nivelIdioma.style.display = 'none'; // Ocultar el nivelIdioma inicialmente

                                            if (query.length > 0) {
                                                searchResultsIdiom.style.display = 'block';
                                                const resultadosFiltrados = idiomas.filter(idioma => idioma.descripcion.toLowerCase().includes(query));

                                                resultadosFiltrados.forEach(idioma => {
                                                    const li = document.createElement('li');
                                                    li.textContent = idioma.descripcion.charAt(0).toUpperCase() + idioma.descripcion.slice(1).toLowerCase();;
                                                    li.addEventListener('click', function() {
                                                        searchInputIdiom.value = idioma.descripcion.charAt(0).toUpperCase() + idioma.descripcion.slice(1).toLowerCase();;
                                                        searchResultsIdiom.innerHTML = ''; // Limpiar la lista al seleccionar
                                                        searchResultsIdiom.style.display = 'none'; // Ocultar la lista al seleccionar

                                                        // Mostrar la sección de nivel del idioma seleccionado
                                                        nivelIdioma.style.display = 'flex';
                                                        idIdiomaSeleccionado.value = idioma.id; // Guardar el ID del idioma seleccionado
                                                    });
                                                    searchResultsIdiom.appendChild(li);
                                                });

                                                if (resultadosFiltrados.length === 0) {
                                                    const li = document.createElement('li');
                                                    li.textContent = 'No se encontraron resultados';
                                                    searchResultsIdiom.appendChild(li);
                                                }
                                            } else {
                                                searchResultsIdiom.style.display = 'none';
                                            }
                                        });

                                        // Escuchar cuando el usuario borre el texto manualmente
                                        searchInputIdiom.addEventListener('blur', function() {
                                            if (searchInputIdiom.value.trim() === "") {
                                                nivelIdioma.style.display = 'none'; // Ocultar los niveles si se borra el idioma
                                                idIdiomaSeleccionado.value = ""; // Limpiar el ID del idioma si se borra el texto
                                            }
                                        });
                                    </script>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="dato oficial idioma">
                            <form action="./aniadirIdioma.php" enctype="multipart/form-data" method="post" class="form aniadir">
                                <?php foreach ($infoUsuario['idiomas'] as $idioma) {
                                    if (!isset($_GET['emailUsuario']) && !isset($_GET['enter'])) {
                                        $txt = '<button type="submit" name="borrarButton" value="' . $idioma["id"] . '" class="boton-borrar">
                                    <img src="../Img/papelera.png" alt="Icono Papelera">
                                    </button>';
                                        echo '<div class=data>' . mb_convert_case(mb_strtolower($idioma['idioma'], 'UTF-8'), MB_CASE_TITLE, "UTF-8") . ': '; ?></b>
                                    <?php echo 'Nivel Escrito: ' .  mb_convert_case(mb_strtolower($idioma['nivelEscrito'], 'UTF-8'), MB_CASE_TITLE, "UTF-8") . ' &#x2507 ' . 'Nivel Oral: ' .  mb_convert_case(mb_strtolower($idioma['nivelHablado'], 'UTF-8'), MB_CASE_TITLE, "UTF-8") . ' ' . $txt . '</div>';
                                    } else {
                                        echo '<div class=data>' . mb_convert_case(mb_strtolower($idioma['idioma'], 'UTF-8'), MB_CASE_TITLE, "UTF-8") . ': '; ?></b> <?php echo 'Nivel Escrito: ' .  mb_convert_case(mb_strtolower($idioma['nivelEscrito'], 'UTF-8'), MB_CASE_TITLE, "UTF-8") . ' &#x2507 ' . 'Nivel Oral: ' .  mb_convert_case(mb_strtolower($idioma['nivelHablado'], 'UTF-8'), MB_CASE_TITLE, "UTF-8") . '</div>';
                                                                                                                                                                }
                                                                                                                                                            } ?>
                                <input type="text" class="ocultar" name="idUsuario" value="<?php echo $infoUsuario['idUsuarioPortalEmpleo']; ?>">
                            </form>
                        </div>
                    </div>

                    <div class="misHabilidades misDatos" id="misHabilidades">
                        <div class="headline">
                            <h2>Mis aptitudes:</h2>
                            <?php if (!isset($_GET['emailUsuario']) && !isset($_GET['enter'])) { ?>
                                <div class="editarButton white" onclick="mostrarAniadirPerfil(this);">Editar</div>
                            <?php } ?>
                        </div>
                        <?php if (!isset($_GET['emailUsuario']) && !isset($_GET['enter'])) { ?>
                            <div class="datoModificar">
                                <div class="aniadir aniadirPerfil">
                                    <div class='button-abrir' onclick="habilitarAniadir(this);">Añadir</div>

                                    <div class="informacion">
                                        <form action="./aniadirHabilidades.php" enctype="multipart/form-data" method="post" class="form borrar" id="uploadForm">
                                            <label for="nombreHabilidad">Aptitud:</label>
                                            <input type="text" name="nombreHabilidad" id="nombreHabilidad" placeholder="Escribe una aptitud">
                                            <input type="text" class="ocultar" name="idUsuario" value="<?php echo $infoUsuario['idUsuarioPortalEmpleo']; ?>" id="">
                                            <input type="submit" name="aniadirAptitud" value="Añadir">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="dato oficial tecno">
                            <form action="./aniadirHabilidades.php" enctype="multipart/form-data" method="post" class="form borrar" id="uploadForm">
                                <input type="text" class="ocultar" name="idUsuario" value="<?php echo $infoUsuario['idUsuarioPortalEmpleo']; ?>" id="">
                                <?php foreach ($infoUsuario['habilidades'] as $habilidad) {
                                    if (!isset($_GET['emailUsuario']) && !isset($_GET['enter'])) {
                                        $txt = '<button type="submit" name="borrarButton" value="' . $habilidad["id"] . '" class="boton-borrar">
                                                            <img src="../Img/papelera.png" alt="Icono Papelera">
                                                            </button>';
                                        echo "<div class='data'>" . $habilidad['habilidad'] . $txt . "</div>";
                                    } else {
                                        echo "<div class='data'>" . $habilidad['habilidad'] .  "</div>";
                                    }
                                } ?>
                            </form>
                        </div>
                    </div>

                    <div class="misHerramientas misDatos" id="misHerramientas">
                        <div class="headline">
                            <h2>Mis herramientas informáticas:</h2>
                            <?php if (!isset($_GET['emailUsuario']) && !isset($_GET['enter'])) { ?>
                                <div class="editarButton white" onclick="mostrarAniadirPerfil(this);">Editar</div>
                            <?php } ?>
                        </div>
                        <?php if (!isset($_GET['emailUsuario']) && !isset($_GET['enter'])) { ?> <div class="datoModificar">
                                <div class="aniadir aniadirPerfil">
                                    <div class='button-abrir' onclick="habilitarAniadir(this);">Añadir</div>
                                    <div class="informacion">
                                        <form action="./aniadirHerramientas.php" enctype="multipart/form-data" method="post" class="form borrar" id="uploadForm">
                                            <div class="dato">
                                                <?php
                                                $herramientas = herramientas(); // Obtener herramientas
                                                $nivelesHerramientas = nivelesHerramientas(); // Obtener niveles de herramientas
                                                usort($nivelesHerramientas, function ($a, $b) {
                                                    return $a['numNivel'] <=> $b['numNivel']; // Ordenar niveles
                                                });
                                                ?>
                                                <label for="search-input-utils">Mis herramientas:</label>
                                                <input type="text" id="search-input-utils" name="utilName" placeholder="Buscar herramientas..." autocomplete="off">
                                                <ul id="search-results-utils" style="display: none;"></ul>
                                                <div class="nivelHerramienta" style="display: none;">
                                                    Indique su nivel (de 0 a 6):
                                                    <label for="rangeInput">Nivel:</label>
                                                    <input type="range" id="rangeInputUtils" name="rangeInput" min="10" max="60" value="0" step="10" list="lista-rango-herramientas">
                                                    <datalist id="lista-rango-herramientas">
                                                        <?php foreach ($nivelesHerramientas as $nivelHerramienta) { ?>
                                                            <option value="<?php echo $nivelHerramienta['numNivel']; ?>"><?php echo $nivelHerramienta['descripcion']; ?></option>
                                                        <?php } ?>
                                                    </datalist>
                                                    <span id="rangeValueUtils">BAJO</span>
                                                </div>

                                                <!-- Campo oculto para almacenar el ID de la herramienta seleccionada -->
                                                <input type="text" class="ocultar" id="herramienta-id" name="herramientaId" value="">
                                            </div>
                                            <input class="ocultar" name="idUsuario" type="text" value="<?php echo $infoUsuario['idUsuarioPortalEmpleo']; ?>">
                                            <input type="submit" name="aniadirHerramienta" value="Añadir">
                                        </form>
                                    </div>

                                    <script>
                                        const herramientas = <?php echo json_encode($herramientas); ?>;
                                        const nivelesHerramientas = <?php echo json_encode($nivelesHerramientas); ?>;
                                        const searchInputUtils = document.getElementById('search-input-utils');
                                        const searchResultsUtils = document.getElementById('search-results-utils');
                                        const nivelHerramienta = document.querySelector('.nivelHerramienta');
                                        const rangeInputUtils = document.getElementById('rangeInputUtils');
                                        const rangeValueUtils = document.getElementById('rangeValueUtils');
                                        const herramientaIdInput = document.getElementById('herramienta-id'); // Campo oculto para el ID de la herramienta

                                        // Crear un mapeo de numNivel a descripcion
                                        const nivelMapUtils = {};
                                        nivelesHerramientas.forEach(nivel => {
                                            nivelMapUtils[nivel.numNivel] = nivel.descripcion;
                                        });

                                        // Actualizar la etiqueta de nivel según el valor del rango
                                        rangeInputUtils.addEventListener('input', function() {
                                            const selectedValue = parseInt(rangeInputUtils.value, 10);
                                            rangeValueUtils.textContent = nivelMapUtils[selectedValue] || 'Nivel no definido';
                                        });

                                        // Mostrar todos los resultados al hacer clic en el campo de búsqueda
                                        searchInputUtils.addEventListener('focus', function() {
                                            searchResultsUtils.innerHTML = ''; // Limpiar resultados anteriores
                                            herramientas.forEach(herramienta => {
                                                const li = document.createElement('li');
                                                li.textContent = herramienta.descripcion;
                                                li.addEventListener('click', function() {
                                                    searchInputUtils.value = herramienta.descripcion;
                                                    searchResultsUtils.innerHTML = ''; // Limpiar la lista al seleccionar
                                                    searchResultsUtils.style.display = 'none';
                                                    nivelHerramienta.style.display = 'flex';
                                                    nivelHerramienta.style.flexDirection = 'column';

                                                    // Guardar el ID de la herramienta seleccionada en el campo oculto
                                                    herramientaIdInput.value = herramienta.id; // Asignar el ID al campo oculto
                                                });
                                                searchResultsUtils.appendChild(li);
                                            });
                                            searchResultsUtils.style.display = 'block'; // Mostrar la lista completa
                                        });

                                        // Filtrar los resultados mientras el usuario escribe
                                        searchInputUtils.addEventListener('input', function() {
                                            const query = searchInputUtils.value.toLowerCase().trim();
                                            searchResultsUtils.innerHTML = '';
                                            nivelHerramienta.style.display = 'none';

                                            if (query.length > 0) {
                                                searchResultsUtils.style.display = 'block';
                                                const resultadosFiltrados = herramientas.filter(herramienta =>
                                                    herramienta.descripcion.toLowerCase().includes(query)
                                                );

                                                resultadosFiltrados.forEach(herramienta => {
                                                    const li = document.createElement('li');
                                                    li.textContent = herramienta.descripcion;

                                                    li.addEventListener('click', function() {
                                                        searchInputUtils.value = herramienta.descripcion;
                                                        searchResultsUtils.innerHTML = '';
                                                        searchResultsUtils.style.display = 'none';
                                                        nivelHerramienta.style.display = 'flex';
                                                        nivelHerramienta.style.flexDirection = 'column';

                                                        // Guardar el ID de la herramienta seleccionada en el campo oculto
                                                        herramientaIdInput.value = herramienta.id;
                                                    });

                                                    searchResultsUtils.appendChild(li);
                                                });

                                                if (resultadosFiltrados.length === 0) {
                                                    const li = document.createElement('li');
                                                    li.textContent = 'No se encontraron resultados';
                                                    searchResultsUtils.appendChild(li);
                                                }
                                            } else {
                                                searchResultsUtils.style.display = 'none';
                                            }
                                        });
                                    </script>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="dato oficial tecno">
                            <form action="./aniadirHerramientas.php" enctype="multipart/form-data" method="post" class="form borrar" id="uploadForm">

                                <?php foreach ($infoUsuario['herramientasInformaticas'] as $herramienta) {
                                    // Obtener el nombre de la herramienta y su nivel
                                    $nombreHerramienta = ucfirst(strtolower(quitarAcentos($herramienta['herramienta'])));
                                    $nivelHerramienta = ucfirst(strtolower($herramienta['nivel']));

                                    // Asignar estrellas según el nivel de la herramienta
                                    $estrellas = '';
                                    switch ($nivelHerramienta) {
                                        case 'Experto':
                                            $estrellas = '&#x2605;&#x2605;&#x2605;&#x2605;&#x2605;&#x2605'; // 6 estrellas
                                            break;
                                        case 'Alto':
                                            $estrellas = '&#x2605;&#x2605;&#x2605;&#x2605;&#x2605;&#x2606'; // 5 estrellas
                                            break;
                                        case 'Medio-alto':
                                            $estrellas = '&#x2605;&#x2605;&#x2605;&#x2605;&#x2606;&#x2606'; // 4 estrellas (simulada con una estrella vacía)
                                            break;
                                        case 'Medio':
                                            $estrellas = '&#x2605;&#x2605;&#x2605;&#x2606;&#x2606;&#x2606;'; // 3 estrellas
                                            break;
                                        case 'Medio-bajo':
                                            $estrellas = '&#x2605;&#x2605;&#x2606;&#x2606;&#x2606;&#x2606;'; // 2 estrellas
                                            break;
                                        case 'Bajo':
                                            $estrellas = '&#x2605;&#x2606;&#x2606;&#x2606;&#x2606;&#x2606;'; // 1 estrella
                                            break;
                                        default:
                                            $estrellas = ''; // No mostrar estrellas si el nivel no coincide
                                            break;
                                    }
                                    if (!isset($_GET['emailUsuario']) && !isset($_GET['enter'])) {
                                        $txt = '<button type="submit" name="borrarButton" value="' . $herramienta["id"] . '" class="boton-borrar">
                                                            <img src="../Img/papelera.png" alt="Icono Papelera">
                                                            </button>';
                                        echo "<div class='data'>" . $nombreHerramienta . ": " . $estrellas . " " . $txt . "</div>";
                                    } else {
                                        echo "<div class='data'>" . $nombreHerramienta . ": " . $estrellas . " " .  "</div>";
                                    }
                                } ?>
                                <input type="text" class="ocultar" name="idUsuario" value="<?php echo $infoUsuario['idUsuarioPortalEmpleo']; ?>">

                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="informacionPerfil">
                <div class="datosPersonales">
                    <form action="./actualizarPerfil.php" enctype="multipart/form-data" method="post" class="form borrar" id="uploadForm">
                        <input type="text" class="ocultar" name="idUsuario" value=<?php echo $infoUsuario['idUsuarioPortalEmpleo']; ?>>
                        <div class="dato">
                            <b>
                                Nombre:
                            </b>
                            <div class="together">
                                <?php echo ucfirst(strtolower($infoUsuario['nombre'])) . ' ' . ucfirst(strtolower($infoUsuario['apellido1'])) . ' ' . ucfirst(strtolower($infoUsuario['apellido2'])); ?>
                            </div>
                            <?php if (!isset($_GET['emailUsuario']) && !isset($_GET['enter'])) { ?> <div class="separated">
                                    <input type="text" disabled name="nombreUsuario" value="<?php echo ucfirst(strtolower($infoUsuario['nombre'])); ?>">
                                    <input type="text" disabled name='apellido1' value="<?php echo ucfirst(strtolower($infoUsuario['apellido1'])); ?>">
                                    <input type="text" disabled name="apellido2" value="<?php echo ucfirst(strtolower($infoUsuario['apellido2'])); ?>">
                                </div>
                            <?php } ?>
                        </div>

                        <div class="dato">
                            <b>

                                <?php
                                if (is_null($infoUsuario['tipoDocumento'])) {
                                    echo "Tipo documento: ";
                                } else {
                                    echo $infoUsuario['tipoDocumento'];
                                }
                                ?>
                            </b>
                            <div class="together">
                                <?php echo $infoUsuario['nif']; ?>
                            </div>
                            <?php if (!isset($_GET['emailUsuario']) && !isset($_GET['enter'])) { ?> <div class="separated">
                                    <?php $tiposDocumento = tipoDocumento(); ?>
                                    <select name="tipoDocumento" id="">
                                        <?php
                                        foreach ($tiposDocumento as $tipo) {
                                            if ($tipo['descripcion'] == $infoUsuario['tipoDocumento']) { ?>
                                                <option value="<?php echo $tipo['id']; ?>" selected><?php echo $tipo['descripcion']; ?></option>
                                            <?php } else { ?>
                                                <option value="<?php echo $tipo['id']; ?>"><?php echo $tipo['descripcion']; ?></option>
                                        <?php }
                                        }
                                        ?>
                                    </select>
                                    <input type="text" name="numDocumento" placeholder="Nº Documento" value="<?php echo $infoUsuario['nif']; ?>">
                                </div>
                            <?php } ?>
                        </div>

                        <div class="dato">
                            <b>
                                Dirección:
                            </b>
                            <div class="together">
                                <?php echo ucfirst(strtolower($infoUsuario['tipoVia'])) . ' ' . ucfirst(strtolower($infoUsuario['direccion'])) . ', ' . $infoUsuario['codPostal'] . ', ' . ucfirst(strtolower($infoUsuario['provincia'])) . ', ' . ucfirst(strtolower($infoUsuario['municipio'])); ?>
                            </div>
                            <?php if (!isset($_GET['emailUsuario']) && !isset($_GET['enter'])) { ?> <div class="separated">
                                    <?php
                                    $tipoVia = tipoVia();
                                    ?>

                                    <select name="tipoVia" id="">
                                        <option value="" selected disabled>--Seleccione un tipo de vía--</option>
                                        <?php
                                        foreach ($tipoVia as $via) {
                                            if ($via['descripcion'] == $infoUsuario['tipoVia']) { ?>
                                                <option selected value="<?php echo $via['codigo']; ?>"><?php echo mb_convert_case(mb_strtolower($via['descripcion'], 'UTF-8'), MB_CASE_TITLE, "UTF-8"); ?></option>
                                            <?php } else { ?>
                                                <option value="<?php echo $via['codigo']; ?>"><?php echo mb_convert_case(mb_strtolower($via['descripcion'], 'UTF-8'), MB_CASE_TITLE, "UTF-8"); ?></option>
                                        <?php }
                                        }
                                        ?>
                                    </select>

                                    <input type="text" value="<?php echo ucfirst(strtolower($infoUsuario['direccion'])); ?>" placeholder="Escriba su dirección" name="direccionName">

                                    <input type="text" id="codPostal" value="<?php echo $infoUsuario['codPostal']; ?>" name="codPostal" placeholder="Ingrese su código postal">

                                    <select id="provincias" name="codProvincia">
                                        <option value="<?php echo $infoUsuario['codProvincia']; ?>" selected><?php echo mb_convert_case(mb_strtolower($infoUsuario['provincia'], 'UTF-8'), MB_CASE_TITLE, 'UTF-8'); ?></option>
                                    </select>

                                    <select id="municipios" name='municipioName'>
                                        <option value="<?php echo ucfirst(strtolower($infoUsuario['municipio'])); ?>" selected><?php echo ucfirst(strtolower($infoUsuario['municipio'])); ?></option>
                                    </select>

                                    <script>
                                        document.getElementById('codPostal').addEventListener('focusout', function() {
                                            var codPostal = this.value;

                                            // Verifica que el campo no esté vacío antes de hacer la llamada
                                            if (!codPostal.trim()) {
                                                console.error('Código postal vacío');
                                                return;
                                            }

                                            var xhr = new XMLHttpRequest();
                                            xhr.open("GET", "provincias.php?codPostal=" + codPostal, true);
                                            xhr.onload = function() {
                                                if (xhr.status === 200) {
                                                    try {
                                                        var provincias = JSON.parse(xhr.responseText);
                                                        var select = document.getElementById('provincias');
                                                        select.innerHTML = ''; // Limpiar opciones previas

                                                        if (Array.isArray(provincias) && provincias.length > 0) {
                                                            provincias.forEach(function(provincia) {
                                                                var option = document.createElement('option');
                                                                option.value = provincia.codProvincia;
                                                                option.text = provincia.descripcion.charAt(0).toUpperCase() + provincia.descripcion.slice(1).toLowerCase();
                                                                select.appendChild(option);
                                                            });
                                                        }
                                                    } catch (e) {
                                                        console.error('Error al parsear JSON:', e);
                                                    }
                                                } else {
                                                    console.error('Error en la solicitud:', xhr.status);
                                                }
                                            };
                                            xhr.onerror = function() {
                                                console.error('Error de conexión');
                                            };
                                            xhr.send();
                                        });
                                        document.getElementById('provincias').addEventListener('click', function() {
                                            var codProvincia = this.value; // Captura el valor de la provincia seleccionada

                                            // Verifica que el campo no esté vacío antes de hacer la llamada
                                            if (!codProvincia.trim()) {
                                                console.error('Provincia no seleccionada');
                                                return; // Si no hay provincia seleccionada, no hace la solicitud
                                            }

                                            // Crear una solicitud HTTP para obtener los municipios
                                            var xhr = new XMLHttpRequest();
                                            xhr.open("GET", "municipios.php?codProvincia=" + codProvincia, true); // Llama a un script PHP que devuelve municipios
                                            xhr.onload = function() {
                                                if (xhr.status === 200) { // Si la solicitud es exitosa
                                                    try {
                                                        var municipios = JSON.parse(xhr.responseText); // Convierte la respuesta JSON en un array
                                                        var selectMunicipios = document.getElementById('municipios');
                                                        selectMunicipios.innerHTML = ''; // Limpia las opciones anteriores del select

                                                        // Si hay municipios en la respuesta, los agrega al select
                                                        if (Array.isArray(municipios) && municipios.length > 0) {
                                                            municipios.forEach(function(municipio) {
                                                                var option = document.createElement('option');
                                                                option.value = municipio.descripcion; // Código del municipio
                                                                option.text = municipio.descripcion; // Nombre del municipio
                                                                selectMunicipios.appendChild(option); // Añade la opción al select
                                                            });
                                                        }
                                                    } catch (e) {
                                                        console.error('Error al parsear JSON:', e); // Si ocurre un error al parsear
                                                    }
                                                } else {
                                                    console.error('Error en la solicitud:', xhr.status); // Si hay un error en la solicitud
                                                }
                                            };
                                            xhr.onerror = function() {
                                                console.error('Error de conexión'); // Si hay un error de conexión
                                            };
                                            xhr.send(); // Envía la solicitud al servidor
                                        });
                                    </script>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="dato">
                            <b>
                                Teléfono:
                            </b>
                            <div class="together">
                                <?php echo $infoUsuario['telefonoMovil']; ?>
                            </div>
                            <?php if (!isset($_GET['emailUsuario']) && !isset($_GET['enter'])) { ?> <div class="separated">
                                    <input name="telefono" type="text" title="El telefono debe contener solo 9 dígitos" pattern="^\d{9}$" disabled value="<?php echo ucfirst(strtolower($infoUsuario['telefonoMovil'])); ?>">
                                </div>
                            <?php } ?>
                        </div>

                        <div class="dato">
                            <b>
                                Teléfono Fijo:
                            </b>
                            <div class="together">
                                <?php echo $infoUsuario['telefonoFijo']; ?>
                            </div>
                            <?php if (!isset($_GET['emailUsuario']) && !isset($_GET['enter'])) { ?> <div class="separated">
                                    <input name="telefonoFijo" type="text" title="El telefono debe contener solo 9 dígitos" pattern="^\d{9}$" disabled value="<?php echo ucfirst(strtolower($infoUsuario['telefonoFijo'])); ?>">
                                </div>
                            <?php } ?>
                        </div>


                        <div class="dato especial">
                            <b>
                                Permiso de conducir:
                            </b>
                            <div class="together">
                                <?php
                                if ($infoUsuario['carnetConducir'] == true) {
                                    echo 'Sí';
                                } else {
                                    echo 'No';
                                } ?>
                            </div>
                            <?php if (!isset($_GET['emailUsuario']) && !isset($_GET['enter'])) { ?> <div class="separated">
                                    <?php
                                    if ($infoUsuario['carnetConducir'] == true) { ?>
                                        <input type="radio" checked disabled id="S" name="conducir" value="1">
                                        <label for="S">Sí</label>
                                        <input type="radio" disabled id="N" name="conducir" value="0">
                                        <label for="N">No</label>
                                    <?php } else { ?>
                                        <input type="radio" disabled id="S" name="conducir" value="1">
                                        <label for="S">Sí</label>
                                        <input type="radio" checked disabled id="N" name="conducir" value="0">
                                        <label for="N">No</label>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="dato especial">
                            <b>
                                Vehículo Propio:
                            </b>
                            <div class="together">
                                <?php
                                if ($infoUsuario['vehiculoPropio'] == true) {
                                    echo 'Sí';
                                } else {
                                    echo 'No';
                                } ?>
                            </div>
                            <?php if (!isset($_GET['emailUsuario']) && !isset($_GET['enter'])) { ?> <div class="separated">
                                    <?php
                                    if ($infoUsuario['vehiculoPropio'] == true) { ?>
                                        <input type="radio" checked disabled id="S" name="vehiculo" value="1">
                                        <label for="S">Sí</label>
                                        <input type="radio" disabled id="N" name="vehiculo" value="0">
                                        <label for="N">No</label>
                                    <?php } else { ?>
                                        <input type="radio" disabled id="S" name="vehiculo" value="1">
                                        <label for="S">Sí</label>
                                        <input type="radio" checked disabled id="N" name="vehiculo" value="0">
                                        <label for="N">No</label>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="dato especial">
                            <b>
                                Esta trabajando:
                            </b>
                            <div class="together">
                                <?php
                                if ($infoUsuario['estaTrabajando'] == true) {
                                    echo 'Sí';
                                } else {
                                    echo 'No';
                                } ?>
                            </div>
                            <?php if (!isset($_GET['emailUsuario']) && !isset($_GET['enter'])) { ?> <div class="separated">
                                    <?php
                                    if ($infoUsuario['estaTrabajando'] == true) { ?>
                                        <input type="radio" checked disabled id="S" name="trabajando" value="1">
                                        <label for="S">Sí</label>
                                        <input type="radio" disabled id="N" name="trabajando" value="0">
                                        <label for="N">No</label>
                                    <?php } else { ?>
                                        <input type="radio" disabled id="S" name="trabajando" value="1">
                                        <label for="S">Sí</label>
                                        <input type="radio" checked disabled id="N" name="trabajando" value="0">
                                        <label for="N">No</label>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="dato especial">
                            <b>
                                Disponibilidad para viajar:
                            </b>
                            <div class="together">
                                <?php
                                if ($infoUsuario['disponibilidadParaViajar'] == true) {
                                    echo 'Sí';
                                } else {
                                    echo 'No';
                                } ?>
                            </div>
                            <?php if (!isset($_GET['emailUsuario']) && !isset($_GET['enter'])) { ?> <div class="separated">
                                    <?php
                                    if ($infoUsuario['disponibilidadParaViajar'] == true) { ?>
                                        <input type="radio" checked disabled id="S" name="viajar" value="1">
                                        <label for="S">Sí</label>
                                        <input type="radio" disabled id="N" name="viajar" value="0">
                                        <label for="N">No</label>
                                    <?php } else { ?>
                                        <input type="radio" disabled id="S" name="viajar" value="1">
                                        <label for="S">Sí</label>
                                        <input type="radio" checked disabled id="N" name="viajar" value="0">
                                        <label for="N">No</label>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="dato">
                            <b>
                                Disponibilidad incorporación:
                            </b>
                            <div class="together">
                                <?php
                                echo $infoUsuario['disponibilidadIncorporacion'];
                                ?>
                            </div>
                            <?php if (!isset($_GET['emailUsuario']) && !isset($_GET['enter'])) { ?> <div class="separated">
                                    <input type="text" pattern="^[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9\s]+$" name="incorporacion" id="" value="<?php echo $infoUsuario['disponibilidadIncorporacion']; ?>">
                                </div>
                            <?php } ?>
                        </div>
                        <div class="dato">
                            <b>
                                Disponibilidad Horaria:
                            </b>
                            <div class="together">
                                <?php
                                echo $infoUsuario['disponibilidadHoraria'];
                                ?>
                            </div>
                            <?php if (!isset($_GET['emailUsuario']) && !isset($_GET['enter'])) { ?> <div class="separated">
                                    <?php $horarios = horarios(); ?>
                                    <select name="disponibildadHoraria" id="">
                                        <option value="" selected disabled>--Seleccione una opción--</option>
                                        <?php foreach ($horarios as $horario) {
                                            if ($horario['descripcion'] == $infoUsuario['disponibilidadHoraria']) { ?>
                                                <option value="<?php echo $horario['id']; ?>" selected><?php echo $horario['descripcion']; ?></option>
                                            <?php } else { ?>
                                                <option value="<?php echo $horario['id']; ?>"><?php echo $horario['descripcion']; ?></option>
                                        <?php }
                                        } ?>
                                    </select>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="dato">
                            <b>
                                Rango Salarial:
                            </b>
                            <div class="together">
                                <?php
                                if ($infoUsuario['rangoSalarial'] != '') {
                                    echo $infoUsuario['rangoSalarial'] . ' brutos/año';
                                }
                                ?>
                            </div>
                            <?php if (!isset($_GET['emailUsuario']) && !isset($_GET['enter'])) { ?> <div class="separated">
                                    <input type="text" name="rangoSalarial" title="Solo se permiten números" placeholder="Rango salarial" value="<?php echo $infoUsuario['rangoSalarial']; ?>"> brutos/año
                                </div>
                            <?php } ?>
                        </div>

                        <?php if ($infoUsuario['role'] == 3) { ?>

                        <?php }
                        if (!isset($_GET['emailUsuario']) && !isset($_GET['enter'])) { ?>
                            <input type="submit" value="Actualizar perfil" name="actualizarPerfil" class="actualizarPerfil">
                        <?php } ?>
                    </form>
                    <?php if (!isset($_GET['emailUsuario']) && !isset($_GET['enter'])) { ?>
                        <!-- <img src="../Img/lapiz.png" alt="Icon Editar" onclick="mostrarEditarDatosPersonales(this);"> -->
                        <div class="editarButton blue personal" onclick="mostrarEditarDatosPersonales(this);">Editar</div>
                    <?php } ?>
                </div>

                <div class="misEstudios misDatos" id="misEstudios">
                    <div class="headline">
                        <h2>Datos académicos:</h2>
                        <?php if (!isset($_GET['emailUsuario']) && !isset($_GET['enter'])) { ?>
                            <!--                             <img src="../Img/lapiz.png" alt="Icon Editar" onclick="mostrarAniadirPerfil(this);">
 -->
                            <div class="editarButton blue" onclick="mostrarAniadirPerfilBis(this);">Editar</div>
                        <?php } ?>
                    </div>
                    <div class="dato oficial study">
                        <?php foreach ($infoUsuario['estudios'] as $estudio) { ?>
                            <div><b><?php echo mb_convert_case(mb_strtolower($estudio['estudio'], 'UTF-8'), MB_CASE_TITLE, 'UTF-8'); ?>:</b>
                                <?php
                                if (!is_null($estudio['especialidad'])) {
                                    echo mb_convert_case(mb_strtolower($estudio['especialidad'], 'UTF-8'), MB_CASE_TITLE, 'UTF-8');
                                }

                                if (!is_null($estudio['fechaHasta'])) {
                                    $fechaInicioCurso = new DateTime($estudio['fechaDesde']);
                                    $fechaInicioCurso = $fechaInicioCurso->format('d/m/Y');

                                    $fechaFinCurso = new DateTime($estudio['fechaHasta']);
                                    $fechaFinCurso = $fechaFinCurso->format('d/m/Y');

                                    echo ' (' . $fechaInicioCurso . ' -- ' . $fechaFinCurso . ')';
                                } else {
                                    $fechaInicioCurso = new DateTime($estudio['fechaDesde']);
                                    $fechaInicioCurso = $fechaInicioCurso->format('d/m/Y');
                                    echo ' (' . $fechaInicioCurso . ' -- Actualidad)';
                                }
                                ?> </div>
                        <?php } ?>
                    </div>
                    <?php if (!isset($_GET['emailUsuario']) && !isset($_GET['enter'])) { ?>
                        <div class="datoModificar">
                            <div class="aniadir aniadirPerfil blue">
                                <!-- <img onclick="habilitarAniadir(this);" src="../Img/mas.png" alt="Icono Mas"> -->
                                <div class="button-abrir blue" onclick="habilitarAniadir(this);"> Añadir </div>
                                <div class="informacion">
                                    <form style='width: 100%;' action="./aniadirEstudios.php" enctype="multipart/form-data" method="post" class="form borrar" id="uploadForm">
                                        <div class="dato" style="flex-direction: column; width: 100%;">
                                            <?php
                                            $estudios = estudios();
                                            ?>
                                            <label for="search-input-estudios">Estudio:</label>
                                            <input type="text" id="search-input-estudios" name="estudioName" placeholder="Buscar estudios..." autocomplete="off" style="border-bottom:2px solid var(--darkBlue); color: var(--darkBlue)">
                                            <ul id="search-results-estudios" style="width: 100%;"></ul>
                                            <div id="especialidad-container" style="display: none;">
                                                <label for="especialidad-select">Selecciona una especialidad:</label>
                                                <select id="especialidad-select" style="border-radius:1px;" name="especialidadNameSelect">
                                                    <option selected value="">--Seleccione--</option>
                                                </select>
                                            </div>
                                            <div id="especialidad-input-container" style="display: none; flex-direction: column; margin-top: 0rem;">
                                                <label for="especialidad-input">Escribe una especialidad:</label>
                                                <input type="text" id="especialidad-input" name="especialidadName" placeholder="Escribe aquí...">
                                            </div>

                                            <!-- Campo oculto para almacenar el ID del estudio seleccionado -->
                                            <input type="text" class="ocultar" id="estudio-id" name="estudioId" value="">
                                        </div>

                                        <!-- Contenedor de fechas (inicialmente oculto) -->
                                        <div id="fechas-estudio-container" class="fechaContainer" style="display: none;">
                                            <div class="fecha">
                                                <label for="fecha-inicio-estudio">Fecha de inicio del estudio:</label>
                                                <input type="date" id="fecha-inicio-estudio" name="fechaInicioEstudio" required>
                                            </div>
                                            <div class="fecha">
                                                <label for="fecha-fin-estudio">Fecha de fin del estudio:</label>
                                                <input type="date" id="fecha-fin-estudio" name="fechaFinEstudio">
                                            </div>
                                        </div>

                                        <!-- Campo oculto para el ID del usuario -->
                                        <input class="ocultar" name="idUsuario" type="text" value="<?php echo $infoUsuario['idUsuarioPortalEmpleo']; ?>">
                                        <input type="submit" name="aniadirEstudio" value="Añadir">
                                    </form>
                                </div>

                                <script>
                                    const estudios = <?php echo json_encode($estudios); ?>;
                                    const searchInputEstudios = document.getElementById('search-input-estudios');
                                    const searchResultsEstudios = document.getElementById('search-results-estudios');
                                    const especialidadContainer = document.getElementById('especialidad-container');
                                    const especialidadInputContainer = document.getElementById('especialidad-input-container');
                                    const especialidadSelect = document.getElementById('especialidad-select');
                                    const especialidadInput = document.getElementById('especialidad-input');
                                    const estudioIdInput = document.getElementById('estudio-id'); // Campo oculto para el ID del estudio
                                    const fechasEstudioContainer = document.getElementById('fechas-estudio-container'); // Contenedor de fechas

                                    // Ocultar inicialmente la lista de resultados y el contenedor de fechas
                                    searchResultsEstudios.style.display = 'none';
                                    fechasEstudioContainer.style.display = 'none';

                                    // Mostrar todos los estudios al hacer clic en el input
                                    searchInputEstudios.addEventListener('focus', function() {
                                        searchResultsEstudios.innerHTML = ''; // Limpiar resultados anteriores
                                        estudios.forEach(estudio => {
                                            const li = document.createElement('li');
                                            li.textContent = estudio.descripcion;
                                            li.addEventListener('click', function() {
                                                searchInputEstudios.value = estudio.descripcion;
                                                searchResultsEstudios.innerHTML = ''; // Limpiar la lista al seleccionar
                                                searchResultsEstudios.style.display = 'none'; // Ocultar la lista al seleccionar

                                                // Guardar el ID del estudio seleccionado en el campo oculto
                                                estudioIdInput.value = estudio.id;

                                                // Limpiar el select de especialidades
                                                especialidadSelect.innerHTML = '<option value="">--Seleccione--</option>';

                                                // Verificar si el estudio tiene especialidades
                                                if (estudio.tieneEspecialidad) {
                                                    <?php
                                                    foreach ($estudios as $estudio) {
                                                        if ($estudio['tieneEspecialidad']) {
                                                            $especialidades = especialidades($estudio['id']);
                                                            if (empty($especialidades)) {
                                                                echo "if (estudio.id === {$estudio['id']}) {";
                                                                echo "especialidadInputContainer.style.display = 'flex';";
                                                                echo "especialidadContainer.style.display = 'none';";
                                                                echo "}";
                                                            } else {
                                                                foreach ($especialidades as $especialidad) {
                                                                    echo "if (estudio.id === {$estudio['id']}) {";
                                                                    echo "const option = document.createElement('option');";
                                                                    echo "option.value = '{$especialidad['descripcion']}';";
                                                                    echo "option.textContent = '{$especialidad['descripcion']}';";
                                                                    echo "especialidadSelect.appendChild(option);";
                                                                    echo "especialidadContainer.style.display = 'block';";
                                                                    echo "especialidadInputContainer.style.display = 'none';";
                                                                    echo "}";
                                                                }
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                } else {
                                                    especialidadContainer.style.display = 'none';
                                                    especialidadInputContainer.style.display = 'none';
                                                }

                                                // Mostrar los campos de fechas cuando se selecciona un estudio
                                                fechasEstudioContainer.style.display = 'flex';
                                            });
                                            searchResultsEstudios.appendChild(li);
                                        });
                                        searchResultsEstudios.style.display = 'block'; // Mostrar la lista completa
                                    });

                                    // Filtrar los resultados mientras el usuario escribe
                                    searchInputEstudios.addEventListener('input', function() {
                                        const query = searchInputEstudios.value.toLowerCase();
                                        searchResultsEstudios.innerHTML = ''; // Limpiar resultados anteriores
                                        especialidadContainer.style.display = 'none';
                                        especialidadInputContainer.style.display = 'none';

                                        if (query.length > 0) {
                                            searchResultsEstudios.style.display = 'block';
                                            const resultadosFiltrados = estudios.filter(estudio => estudio.descripcion.toLowerCase().includes(query));

                                            resultadosFiltrados.forEach(estudio => {
                                                const li = document.createElement('li');
                                                li.textContent = estudio.descripcion;
                                                li.addEventListener('click', function() {
                                                    searchInputEstudios.value = estudio.descripcion;
                                                    searchResultsEstudios.innerHTML = ''; // Limpiar la lista al seleccionar
                                                    searchResultsEstudios.style.display = 'none'; // Ocultar la lista al seleccionar

                                                    // Guardar el ID del estudio seleccionado en el campo oculto
                                                    estudioIdInput.value = estudio.id;

                                                    // Limpiar el select de especialidades
                                                    especialidadSelect.innerHTML = '<option value="">--Seleccione--</option>';

                                                    // Verificar si el estudio tiene especialidades
                                                    if (estudio.tieneEspecialidad) {
                                                        <?php
                                                        foreach ($estudios as $estudio) {
                                                            if ($estudio['tieneEspecialidad']) {
                                                                $especialidades = especialidades($estudio['id']);
                                                                if (empty($especialidades)) {
                                                                    echo "if (estudio.id === {$estudio['id']}) {";
                                                                    echo "especialidadInputContainer.style.display = 'flex';";
                                                                    echo "especialidadContainer.style.display = 'none';";
                                                                    echo "}";
                                                                } else {
                                                                    foreach ($especialidades as $especialidad) {
                                                                        echo "if (estudio.id === {$estudio['id']}) {";
                                                                        echo "const option = document.createElement('option');";
                                                                        echo "option.value = '{$especialidad['descripcion']}';";
                                                                        echo "option.textContent = '{$especialidad['descripcion']}';";
                                                                        echo "especialidadSelect.appendChild(option);";
                                                                        echo "especialidadContainer.style.display = 'block';";
                                                                        echo "especialidadInputContainer.style.display = 'none';";
                                                                        echo "}";
                                                                    }
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                    } else {
                                                        especialidadContainer.style.display = 'none';
                                                        especialidadInputContainer.style.display = 'none';
                                                    }

                                                    // Mostrar los campos de fechas cuando se selecciona un estudio
                                                    fechasEstudioContainer.style.display = 'block';
                                                });
                                                searchResultsEstudios.appendChild(li);
                                            });

                                            if (resultadosFiltrados.length === 0) {
                                                const li = document.createElement('li');
                                                li.textContent = 'No se encontraron resultados';
                                                searchResultsEstudios.appendChild(li);
                                            }
                                        } else {
                                            searchResultsEstudios.style.display = 'none';
                                        }
                                    });
                                </script>
                            </div>
                            <form action="./aniadirEstudios.php" enctype="multipart/form-data" method="post" class="form borrar" id="uploadForm">
                                <?php foreach ($infoUsuario['estudios'] as $estudio) { ?>
                                    <div class="data">
                                        <div class="name">
                                            <b><?php echo mb_convert_case(mb_strtolower($estudio['estudio'], 'UTF-8'), MB_CASE_TITLE, 'UTF-8'); ?>:</b>
                                            <?php
                                            if (!is_null($estudio['especialidad'])) {
                                                echo mb_convert_case(mb_strtolower($estudio['especialidad'], 'UTF-8'), MB_CASE_TITLE, 'UTF-8');
                                            }
                                            if (!is_null($estudio['fechaHasta'])) {
                                                $fechaInicioCurso = new DateTime($estudio['fechaDesde']);
                                                $fechaInicioCurso = $fechaInicioCurso->format('d/m/Y');

                                                $fechaFinCurso = new DateTime($estudio['fechaHasta']);
                                                $fechaFinCurso = $fechaFinCurso->format('d/m/Y');

                                                echo ' (' . $fechaInicioCurso . ' -- ' . $fechaFinCurso . ')';
                                            } else {
                                                $fechaInicioCurso = new DateTime($estudio['fechaDesde']);
                                                $fechaInicioCurso = $fechaInicioCurso->format('d/m/Y');
                                                echo ' (' . $fechaInicioCurso . ' -- Actualidad)';
                                            }
                                            ?>
                                        </div>
                                        <button type="submit" name="borrarButton" value="<?php echo $estudio['id']; ?>" class="boton-borrar">
                                            <img src="../Img/papelera.png" alt="Icono Papelera">
                                        </button>
                                    </div>
                                <?php } ?>
                                <input type="text" class="ocultar" name="idUsuario" value="<?php echo $infoUsuario['idUsuarioPortalEmpleo']; ?>">
                            </form>

                        </div>
                    <?php } ?>
                </div>

                <div class="misExperiencias misDatos" id="misExperiencias">
                    <div class="headline">
                        <h2>Experiencia laboral:</h2>
                        <?php if (!isset($_GET['emailUsuario']) && !isset($_GET['enter'])) { ?>
                            <!-- <img src="../Img/mas.png" alt="Icon Editar" onclick="mostrarAniadirExperiencia(this);"> -->
                            <div class="editarButton blue" onclick="mostrarAniadirExperiencia(this);">Editar</div>
                        <?php } ?>
                    </div>

                    <div class="button-abrir blue" onclick="habilitarAniadirExperiencia(this);"> Añadir </div>

                    <?php if (!isset($_GET['emailUsuario']) && !isset($_GET['enter'])) { ?>
                        <div class="aniadirExperiencia aniadir">
                            <form action="./aniadirExperiencias.php" enctype="multipart/form-data" method="post" class="form borrarExperiencia" id="uploadForm">
                                <div class="dato">
                                    <label for="empresa">Nombre de la empresa:</label>
                                    <input type="text" id="empresa" name="empresa" pattern="[A-Za-zÀ-ÿ0-9\s]+" placeholder="Nombre de la empresa">
                                </div>
                                <div class="dato">
                                    <label for="puesto">Puesto:</label>
                                    <input type="text" id="puesto" name="puesto" pattern="[A-Za-zÀ-ÿ0-9\s]+" placeholder="Puesto">
                                </div>
                                <div class="dato">
                                    <label for="fechaDesde">Desde:</label>
                                    <input type="date" id="fechaDesde" name="fechaDesde" placeholder="Fecha Desde">
                                </div>
                                <div class="dato especial">
                                    <b>Trabajando aquí actualmente:</b>
                                    <input type="radio" id="si" name="actualmente" value="Sí" onclick="noMostrarFechaFin(this);">
                                    <label for="si">Si</label>
                                    <input type="radio" id="no" name="actualmente" value="No" onclick="mostrarFechaFin(this);">
                                    <label for="no">No</label>
                                </div>
                                <div class="dato fechaFin">
                                    <label for="fechaFIn">Hasta:</label>
                                    <input type="date" id="fechaFIn" name="fechaFIn" placeholder="Fecha Fin">
                                </div>
                                <div class="dato">
                                    <label for="tecnologias">Herramientas y tecnologías usadas:</label>
                                    <input type="text" id="tecnologias" name="tecnologias" placeholder="Tecnologías usadas">
                                </div>
                                <div class="dato">
                                    <label for="descripcion">Descripción del puesto:</label>
                                    <textarea id="descripcion" name="descripcion" rows="4" cols="50" placeholder="Descripcion del puesto"></textarea>
                                </div>
                                <div class="dato">
                                    <label for="salario">Salario:</label>
                                    <input type="text" id="salario" name="salario" pattern="[A-Za-zÀ-ÿ0-9\s]+" placeholder="Salario">
                                </div>
                                <input type="text" class="ocultar" value="<?php echo $infoUsuario['idUsuarioPortalEmpleo']; ?>" name="idUsuario">
                                <input type="submit" value="Añadir experiencia" name="aniadirExperiencia">
                            </form>
                        </div>
                    <?php } ?>
                    <div class="dato oficial expe">
                        <?php
                        foreach ($infoUsuario['experiencias'] as $experiencia) {
                            // Obtener el nombre de la herramienta y su nivel
                            $nombreExperiencia = ucfirst(strtolower(quitarAcentos($experiencia['empresa'])));
                            $puesto = ucfirst(strtolower(quitarAcentos($experiencia['puesto'])));
                            $fechaInicio = new DateTime($experiencia['fechaDesde']);
                            $fechaInicio = $fechaInicio->format('d/m/Y');
                            $fechaFin = new DateTime($experiencia['fechaHasta']);
                            $fechaFin = $fechaFin->format('d/m/Y');
                            $trabajandoAqui = $experiencia['trabajoAquiActualmente'];
                            $descripcionPuesto = $experiencia['descripcionDelPuesto'];
                            $salario = $experiencia['salario'];
                            $idExperiencia = $experiencia['id'];
                            $tecnologias = $experiencia['tecnologiasUtilizadas']; ?>
                            <form action="./aniadirExperiencias.php" enctype="multipart/form-data" method="post" class="form borrarExperiencia" id="uploadForm">
                                <div class="experienciaFormulario editarExperiencia">
                                    <div class="icon">&#x26eb</div>
                                    <div class="dato">
                                        <label for="empresa">Nombre de la empresa:</label>
                                        <input type="text" id="empresa" name="empresa2" pattern="[A-Za-zÀ-ÿ0-9\s]+" placeholder="Nombre de la empresa" value="<?php echo $nombreExperiencia; ?>">
                                    </div>
                                    <div class="dato">
                                        <label for="puesto">Puesto:</label>
                                        <input type="text" id="puesto" name="puesto2" pattern="[A-Za-zÀ-ÿ0-9\s]+" placeholder="Puesto" value="<?php echo $puesto; ?>">
                                    </div>
                                    <div class="dato">
                                        <label for="fechaDesde">Desde:</label>
                                        <?php
                                        $fechaEditInicio = new DateTime($experiencia['fechaDesde']);
                                        $fechaEditInicio = $fechaEditInicio->format('Y-m-d'); ?>
                                        <input type="date" id="fechaDesde" name="fechaDesde2" placeholder="Fecha Desde" value="<?php echo $fechaEditInicio; ?>">
                                    </div>
                                    <div class="dato especial">
                                        <b>Trabajando aquí actualmente:</b>
                                        <?php

                                        $trabajandoAqui = isset($trabajandoAqui) ? (bool)$trabajandoAqui : false;
                                        //echo $trabajandoAqui;
                                        if ($trabajandoAqui == false) { ?>
                                            <input type="radio" id="si" name="actualmente2" value="Sí" onclick="noMostrarFechaFin2(this);">
                                            <label for="si">Si</label>
                                            <input type="radio" checked id="no" name="actualmente2" value="No" onclick="mostrarFechaFin2(this);">
                                            <label for="no">No</label>
                                        <?php } else { ?>
                                            <input checked type="radio" id="si" name="actualmente2" value="Sí" onclick="noMostrarFechaFin2(this);">
                                            <label for="si">Si</label>
                                            <input type="radio" id="no" name="actualmente2" value="No" onclick="mostrarFechaFin2(this);">
                                            <label for="no">No</label>
                                        <?php } ?>
                                    </div>
                                    <div class="dato fechaFin">
                                        <?php
                                        $fechaEditFin = new DateTime($experiencia['fechaHasta']);
                                        $fechaEditFin = $fechaEditFin->format('Y-m-d'); ?>
                                        <label for="fechaFIn">Hasta:</label>
                                        <input type="date" id="fechaFIn" name="fechaFIn2" placeholder="Fecha Fin" value="<?php echo $fechaEditFin; ?>">
                                    </div>
                                    <div class="dato">
                                        <label for="tecnologias">Tecnologías usadas:</label>
                                        <input type="text" id="tecnologias" name="tecnologias2" placeholder="Tecnologías usadas" value="<?php echo $tecnologias; ?>">
                                    </div>
                                    <div class="dato">
                                        <label for="descripcion">Descripción del puesto:</label>
                                        <textarea id="descripcion" name="descripcion2" rows="4" cols="50" placeholder="Descripcion del puesto"><?php echo $descripcionPuesto; ?></textarea>
                                    </div>
                                    <div class="dato">
                                        <label for="salario">Salario:</label>
                                        <input type="text" id="salario" name="salario2" pattern="[A-Za-zÀ-ÿ0-9\s]+" placeholder="Salario" value="<?php echo $salario ?>"> brutos/año
                                    </div>
                                    <input type="text" class="ocultar" value="<?php echo $idExperiencia; ?>" name="idUsuario2">
                                    <div class="buttonsExperiencias">
                                        <input type="submit" value="Actualizar" name="actualizarExperiencia" />
                                        <input type="submit" class="eliminarButton" value="Eliminar" name="borrarButtonExperiencias" />
                                    </div>
                                    <div class="referenciasWrap">
                                        <div class="referencias salario">
                                            <b>Referencias:</b>
                                            <?php if (!isset($_GET['emailUsuario']) && !isset($_GET['enter'])) { ?>
                                                <img src="../Img/mas.png" onclick="mostrarAniadirReferencia(this);" alt="Aniadir Referencia">
                                            <?php } ?>
                                            <input type="text" class="ocultar" name="idExperiencia" value="<?php echo $idExperiencia; ?>">
                                            <div class="refs">
                                                <?php foreach ($experiencia['referencias'] as $referencia) { ?>
                                                    <?php if (!isset($_GET['emailUsuario']) && !isset($_GET['enter'])) { ?>
                                                        <div class="ref">
                                                            <?php echo '<div> ▶ ' . htmlspecialchars($referencia['nombre']) . ' (' . htmlspecialchars($referencia['email']) . ' -- ' . htmlspecialchars($referencia['cargo']) . ')</div>'; ?>
                                                            <button type="submit" name="borrarReferencia" value="<?php echo htmlspecialchars($referencia['id']); ?>" class="boton-borrar">
                                                                <img src="../Img/cancelar.png" alt="Icono Papelera">
                                                            </button>
                                                        </div>

                                                    <?php } else { ?>
                                                        <div class="ref">
                                                            <div>
                                                                ▶ <?php echo htmlspecialchars($referencia['nombre']); ?> (<?php echo htmlspecialchars($referencia['email']); ?> -- <?php echo htmlspecialchars($referencia['cargo']); ?>)
                                                            </div>
                                                        </div>
                                                <?php }
                                                } ?>
                                                <div class="aniadirReferencias">
                                                    <div class="dato">
                                                        <label for="nombreReferencia">Nombre:</label>
                                                        <input id="nombreReferencia" type="text" name="nombreReferencia" placeholder="Nombre" pattern="[A-Za-zÀ-ÿ0-9\s]+">
                                                    </div>
                                                    <div class="dato">
                                                        <label for="puestoReferencia">Puesto </label>
                                                        <input id='puestoReferencia' name="puestoReferencia" type="text" placeholder="Puesto" pattern="[A-Za-zÀ-ÿ0-9\s]+">
                                                    </div>
                                                    <div class="dato">
                                                        <label for="mailReferencia">Email </label>
                                                        <input id='mailReferencia' name="mailReferencia" type="email" placeholder="Email">
                                                    </div>
                                                    <input type="text" class="ocultar" name="idExperiencia" value="<?php echo $idExperiencia; ?>">
                                                    <input type="submit" value="Añadir" name="aniadirReferencia">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="experiencia oficial">
                                    <div class="icon">&#x26eb</div>
                                    <div class="datosExperiencia">
                                        <div class="nombreEmpresa">
                                            <?php echo $nombreExperiencia;
                                            if ($trabajandoAqui != true) { ?>
                                                <div class="fechas">
                                                    <?php echo '(' . $fechaInicio . ' -- ' . $fechaFin . ')';  ?>

                                                </div>
                                            <?php } else {  ?>
                                                <div class="fechas">
                                                    <?php echo '(' . $fechaInicio . ' -- Hoy)';  ?>
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <div class="puesto"><b>Puesto:</b> <?php echo $puesto; ?></div>
                                        <div class="descripcionPuesto">
                                            <b>Mis funciones:</b><?php echo $descripcionPuesto; ?>
                                        </div>

                                        <div class="descripcionPuesto">
                                            <b>Habilidades usadas:</b><?php echo $tecnologias; ?>
                                        </div>

                                        <?php if (!is_null($salario)) { ?>
                                            <div class="salario"><b>Salario:</b><?php echo $salario . ' brutos/año'; ?></div>
                                        <?php } ?>
                                        <div class="referencias salario">
                                            <b>Referencias:</b>
                                            <input type="text" class="ocultar" name="idExperiencia" value="<?php echo $idExperiencia; ?>">
                                            <div class="refs">
                                                <?php foreach ($experiencia['referencias'] as $referencia) { ?>
                                                    <div class="ref">
                                                        <div>
                                                            ▶ <?php echo htmlspecialchars($referencia['nombre']); ?> (<?php echo htmlspecialchars($referencia['email']); ?> -- <?php echo htmlspecialchars($referencia['cargo']); ?>)
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        <?php } ?>
                    </div>
                </div>

                <div class="misDatos misUrls" id="miUrl">
                    <div class="headline">
                        <h2>Mi presencia en internet:</h2>
                        <?php if (!isset($_GET['emailUsuario']) && !isset($_GET['enter'])) { ?>
                            <!-- <img src="../Img/mas.png" alt="Icon Editar" onclick="mostrarUrl(this);"> -->
                            <div class="editarButton blue" onclick="mostrarUrl(this);">Editar</div>
                        <?php } ?>
                    </div>
                    <?php if (!isset($_GET['emailUsuario']) && !isset($_GET['enter'])) { ?>
                        <div class="aniadirUrl aniadir">
                            <form action="./aniadirUrls.php" enctype="multipart/form-data" method="post" class="form borrarExperiencia" id="uploadForm">
                                <div class="dato">
                                    <label for="url">URL:</label>
                                    <input type="url" name="url" id="url" placeholder="https://URL...">
                                </div>
                                <input type="text" class="ocultar" name="idUsuario" value="<?php echo $infoUsuario['idUsuarioPortalEmpleo']; ?>">
                                <input type="submit" value="Añadir Url" name="aniadirUrl">
                            </form>
                        </div>
                    <?php } ?>
                    <div class="dato oficial url">
                        <form action="./aniadirUrls.php" enctype="multipart/form-data" method="post" class="form borrarUrl" id="uploadForm" style="display: flex; gap: 3rem;    flex-wrap: wrap;">
                            <input type=" text" class="ocultar" name="idUsuario" value="<?php echo $infoUsuario['idUsuarioPortalEmpleo']; ?>">
                            <?php foreach ($infoUsuario['urls'] as $url) { ?>
                                <div class="url">
                                    <a href="<?php echo urldecode($url['url']); ?>" target="_blank" rel="noopener noreferrer"><?php echo urldecode($url['url']); ?> </a>
                                    <?php if (!isset($_GET['emailUsuario']) && !isset($_GET['enter'])) { ?>
                                        <button type="submit" name="borrarButtonUrl" value="<?php echo $url['id']; ?>" class="boton-borrar">
                                            <img src="../Img/papelera.png" alt="Icono Papelera">
                                        </button>
                                    <?php } ?>
                                </div>
                            <?php  } ?>
                        </form>
                    </div>

                </div>

            </div>
            <script>
                const fileInput = document.getElementById('fileInput');
                const fileNameSpan = document.getElementById('file-name');
                const submitBtn = document.getElementById('submit-btn');
                const errorMessage = document.getElementById('error-message');

                // Extensiones permitidas
                const allowedExtensions = ['docx', 'pdf'];

                function validateFileExtension(fileName) {
                    const fileExtension = fileName.split('.').pop().toLowerCase();
                    return allowedExtensions.includes(fileExtension);
                }

                fileInput.addEventListener('change', function() {
                    if (fileInput.files.length > 0) {
                        const fileName = fileInput.files[0].name;

                        if (validateFileExtension(fileName)) {
                            fileNameSpan.textContent = fileName;
                            submitBtn.style.display = 'inline-block';
                            errorMessage.textContent = '';
                        } else {
                            fileNameSpan.textContent = "No se ha seleccionado ningún archivo válido";
                            submitBtn.style.display = 'none';
                            errorMessage.textContent = 'Error: Solo se permiten archivos con las siguientes extensiones: ' + allowedExtensions.join(', ');
                        }
                    } else {
                        fileNameSpan.textContent = "No se ha seleccionado ningún archivo";
                        submitBtn.style.display = 'none';
                        errorMessage.textContent = '';
                    }
                });

                document.getElementById('uploadForm').addEventListener('submit', function(event) {
                    if (!fileInput.files.length || !validateFileExtension(fileInput.files[0].name)) {
                        event.preventDefault();
                        errorMessage.textContent = 'Por favor selecciona un archivo válido antes de enviar.';
                    }
                });
            </script>
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

        <?php if (isset($_GET['emailUsuario']) && isset($_GET['enter'])) { ?>

            <button id="btnGenerarPDF"> <img src="../Img/expediente.png" alt="Descargar PDF"> Generar PDF</button>

            <script>
                document.getElementById("btnGenerarPDF").addEventListener("click", function() {
                    // Selecciona el contenido que quieres exportar
                    var imagenes = document.querySelectorAll('.foto .iniciales img');
                    imagenes.forEach(function(img) {
                        $('.foto .iniciales').css({
                            "text-align": "center"
                        });
                        $(imagenes).css({
                            "margin": "0 auto",
                            "width": "50%",
                            "height": "auto"
                        });
                        $('#cv').css({
                            "display": "none"
                        });
                        $('footer').css({
                            "display": "none"
                        });
                        $('.foto').css({
                            "gap": "0rem"
                        });
                        $('h2').css({
                            "font-size": "20px"
                        });
                        $('.misHerramientas .tecno, .misEstudios .study, .misIdiomas .idioma').css({
                            "gap": "20px"
                        });
                        $('.perfilWrap').css({
                            "margin": "0px",
                            "padding": "0rem"
                        });
                        $('.misDatos').css({
                            "padding": ".7rem",
                            "gap": ".5rem"
                        });
                        $('.misExperiencias .experiencia .nombreEmpresa').css({
                            "font-size": "20px"
                        });
                        $('.misHerramientas .tecno > div::before').css({
                            "content": " "
                        });
                        $('#cabeceraIMG').css({
                            "width": "10rem"
                        });
                        $('#btnGenerarPDF').css({
                            'display': 'none'
                        });
                        $('.borrarUrl').css({
                            'display': 'initial'
                        });
                        $('.dato.oficial form').css({
                            "display": "flex",
                            "flex-direction": "column",
                            "flex-wrap": "wrap",
                            "gap": ".1rem",
                            "align-items": "flex-start",
                        });
                        $('.headlineEnter').css({
                            "display": "none",
                        });
                    });
                    var elemento = document.getElementById('contenidoPDF');

                    // Configuración básica de html2pdf
                    var opt = {
                        margin: [5, 0, 5, 0],
                        filename: 'CV.pdf',
                        image: {
                            type: 'png',
                            quality: 0.98
                        },
                        html2canvas: {
                            scale: 3
                        },
                        jsPDF: {
                            unit: 'mm',
                            format: 'a4',
                            orientation: 'portrait'
                        }
                    };

                    // Genera el PDF
                    html2pdf().set(opt).from(elemento).save();
                    setTimeout(function() {
                        location.reload();
                    }, 30000);
                });
            </script>
        <?php } ?>

    </body>
    <?php generarFooter() ?>

    </html>
<?php } else {
    header('Location: ../Login/login.php');
}
