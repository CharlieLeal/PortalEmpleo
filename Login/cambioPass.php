<?php
require_once("../Funciones/funciones.php");

require '../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable('../');
$dotenv->load();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['submit'])) {
        if (md5($_POST['passwd']) == md5($_POST['passwd2'])) {
            $infoUsuario = infoUsuario($_COOKIE['mailUsuario']);
            nuevaPass($infoUsuario['idUsuarioPortalEmpleo'], $_POST['passwd']);
            setcookie("pwd", md5($_POST['passwd']), time() + (86400 * 30), "/",".agioglobal.com",true);
?>
            <script>
                alert('Contraseña cambiada correctamente');
                window.location.href = '../Home/index.php';
            </script>

        <?php } else { ?>
            <script>
                alert('Las contraseñas no coinciden');
            </script>
<?php }
    } //de if 
}
?>

<!DOCTYPE html>
<html lang="es" dir="ltr">

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="../Js/login.js"></script>
    <link rel="stylesheet" href="../Css/common.css">
    <link rel="stylesheet" href="../Css/login.css">
    <link rel="stylesheet" href="../Css/waveEffects.css">
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
                        Debes cambiar tu contraseña:
                    </div>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="form">
                        <div class="registro">
                            <div class="passwd">Contraseña
                                <input type="password" name="passwd" placeholder="Contraseña" required>
                                <div class="mostrar" onclick="mostrarPass(this)"><img src="../Img/ojo.png" alt="Mostrar" /></div>
                            </div>

                            <div class="passwd">Repita Contraseña
                                <input type="password" name="passwd2" placeholder="Contraseña" required>
                                <div class="mostrar" onclick="mostrarPass(this)"><img src="../Img/ojo.png" alt="Mostrar" /></div>
                            </div>
                        </div>
                        <div class="buttons">
                            <input class="loginButton" type="submit" name="submit" value="Login" />
                            <a href="./resetPassword.php">¿Ha olvidado su contraseña?</a>
                        </div>
                        <div class="crearCuenta">
                            -- o -- <br>
                            <a href="../CrearCuenta/index.php">Cree una cuenta</a>
                        </div>
                    </form>
                </div>
            </div>
            <!-- FIN -->
        </div>

        <!--Waves Container-->
        <div>
            <svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
                <defs>
                    <path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
                </defs>
                <g class="parallax">
                    <use xlink:href="#gentle-wave" x="48" y="0" fill="var(--lightBlue)" />
                    <use xlink:href="#gentle-wave" x="48" y="3" fill="var(--darkBlue)" />
                    <use xlink:href="#gentle-wave" x="48" y="5" fill="var(--lightBlue)" />
                    <use xlink:href="#gentle-wave" x="48" y="7" fill="var(--darkBlue)" />
                </g>
            </svg>
        </div>
        <!--Waves end-->

    </div>
    <!--Header ends-->
</body>

</html>