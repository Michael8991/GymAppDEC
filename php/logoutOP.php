<?php
    session_start();
    session_destroy(); // Destruir todas las variables de sesión
    setcookie("savedSession_cookie", "", time() - 3600, "/", "", false, true);//Borramos la cookie
    header("Location: ../index.php"); // Redirigir al usuario a la página de inicio de sesión
    exit();
?>