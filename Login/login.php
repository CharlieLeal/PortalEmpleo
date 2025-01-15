<?php
require_once("../Funciones/funciones.php");

require '../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable('../');
$dotenv->load();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['submit'])) {
        $login = getToken($_POST['user'], md5($_POST['passwd']));

        if (isset($login['status']) && $login['status'] == 401) {

            if (isset($_POST['nameOf'])) {
                header('Location: ./errorLogin.php?nameOf=' . $_POST['nameOf']);
            } else {
                header('Location: ./errorLogin.php');
            }
        } else if (isset($login['token'])) {
            $infoUsuario = login($_POST['user'], md5($_POST['passwd']), ' ');

            if (isset($_COOKIE['mailUsuario'])) {
                setcookie("mailUsuario", "", time() - 3600, "/", ".agioglobal.com", true);
            }
            setcookie("mailUsuario", $infoUsuario['email'], time() + (86400 * 30), "/", ".agioglobal.com", true);
            if ($infoUsuario['role'] == '3') {

                if (isset($_COOKIE['mailUsuario'])) {
                    setcookie("empleado", "", time() - 3600, "/", ".agioglobal.com", true);
                }

                if (isset($_COOKIE['nameUser'])) {
                    setcookie("nameUser", "", time() - 3600, "/", ".agioglobal.com", true);
                }

                setcookie("empleado", $infoUsuario['email'], time() + (86400 * 30), "/", ".agioglobal.com", true);
                setcookie("nameUser", $infoUsuario['nombre'] . ' ' . $infoUsuario['apellido1'] . ' ' . $infoUsuario['apellido2'], time() + (86400 * 30), "/", ".agioglobal.com", true);
            }
            if ($infoUsuario['resetPassword'] == true) {
                header('Location: ./cambioPass.php');
            } else {
                if (isset($_COOKIE['pwd'])) {
                    setcookie("pwd", "", time() - 3600, "/", ".agioglobal.com", true);
                }
                setcookie("pwd", md5($_POST['passwd']), time() + (86400 * 30), "/", ".agioglobal.com", true);
                if (isset($_POST['nameOf'])) {
                    header('Location: ../Ofertas/index.php?nameOf=' . $_POST['nameOf']);
                } else {
                    header('Location: ../Home/index.php');
                }
            }
        }
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
                        Bienvenido, por favor introduzca sus credenciales:
                    </div>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="form">
                        <div class="registro">
                            <div class="user">Usuario <input type="text" name="user" placeholder="Usuario" required> </div>
                            <div class="passwd">Contraseña
                                <input type="password" name="passwd" placeholder="Contraseña" required>
                                <div class="mostrar" onclick="mostrarPass(this)"><img src="../Img/ojo.png" alt="Mostrar" /></div>
                            </div>
                        </div>
                        <div class="buttons">
                            <?php if (isset($_GET['nameOf'])) { ?>
                                <input class="ocultar" type="text" name="nameOf" value="<?php echo $_GET['nameOf']; ?>">
                            <?php } ?>

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
                </g>
            </svg>
        </div>
        <!--Waves end-->

    </div>
    <!--Header ends-->
</body>

</html>