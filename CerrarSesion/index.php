<?php
setcookie("mailUsuario", "", time() - 3600, "/",".agioglobal.com",true);
setcookie("pwd", "", time() - 3600, "/",".agioglobal.com",true);
setcookie("empleado", "", time() - 3600, "/",".agioglobal.com",true);
setcookie("nameUser", "", time() - 3600, "/",".agioglobal.com",true);
header("location: ../Home/index.php");
?>