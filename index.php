<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Gym App</title>
    <link rel="stylesheet" href="css/index.css">
</head>
<body id="body-register" class="">
    <header>
        <div class="header-container">
            <div class="logo-wrapper">
                <img src="images/logoSimpleWallet.png" alt="">
                <div class="logo-text">
                    <p>FitTracks</p>
                    <p>Rastre tu progreso, alcanza tu objetivo.</p>
                </div>
            </div>

            <div class="menu">
                <div class="menu-container">
                    <a href="#">Login</a>
                </div>
            </div>
        </div>
    </header>

    <div class="home">
        <div class="home-container">
           <div class="forms-container">
                <div id="central-image" class="central-image">
                    <img src="images/indexImage-women.png" alt="">
                </div>
                <div id="biombo-wrapper" class="biombo-wrapper">
                    <div id="biombo" class="biombo"></div>
                </div>
                <div id="login-form-wrapper" class="login-form-wrapper">
                    <form id="login-form" class="login-form" action="php/loginOP.php" method="POST" autocomplete="off">
                        <h4>Login</h4>
                        <h6 id="openRegister">¿No estás registrado? Regístrate aquí.</h6>
                        <div id="email-wrapper" class="email-wrapper">
                            <div class="input-wrapper">
                                <label id="email-label" class="" for="email">Correo Elecrtónico:</label>
                                <input type="email" id="email" name="email">
                            </div>
                            <i class="fa-solid fa-address-card"></i>
                        </div>
                        <div id="psw-wrapper" class="psw-wrapper">
                            <div class="input-wrapper">
                                <label id="psw-label" class="" for="psw">Contraseña:</label>
                                <input type="password" name="psw" id="psw">
                            </div>
                            <i class="fa-solid fa-lock"></i>
                        </div>
                        <div class="input-wrapper">
                            <label for="">
                                <input type="checkbox" name="mantenerSesionAbierta"> Mantener la sesión abierta
                            </label>
                        </div>
                        <div class="submit-wrapper">
                            <input id="login-submit" type="submit" value="Acceder">
                        </div>
                    </form>
                    <div id="login-error-message" class="error-message">
                        
                    </div>
                </div>
                <div id="register-form-wrapper" class="register-form-wrapper hidden">
                    <form id="register-form" class="register-form" action="php/registerOP.php" method="POST" autocomplete="off">
                        <h4>Sign up</h4>
                        <h6 id="openLogin">Ya tengo cuenta. Iniciar sesión.</h6>
                        <div id="register-email-wrapper" class="register-email-wrapper">
                            <div class="register-input-wrapper">
                                <label id="register-email-label" class="" for="register-email">Correo Elecrtónico:</label>
                                <input type="email" id="register-email" name="register-email" REQUIRED>
                            </div>
                            <i class="fa-solid fa-address-card"></i>
                        </div>
                        <div id="register-name-wrapper" class="register-name-wrapper">
                            <div class="register-input-wrapper">
                                <label id="register-name-label" class="" for="register-name">Nombre:</label>
                                <input type="text" id="register-name" name="register-name" REQUIRED>
                            </div>
                            <i class="fa-solid fa-user"></i>
                        </div>
                        <div id="register-psw-wrapper" class="register-psw-wrapper">
                            <div class="register-input-wrapper">
                                <label id="register-psw-label" class="" for="register-psw">Contraseña:</label>
                                <input type="password" name="register-psw" id="register-psw" REQUIRED>
                            </div>
                            <i class="fa-solid fa-lock"></i>
                        </div>
                        <div id="alertNotMatch" class="alertNotMatch">
                            <div class="alertNotMatch-container">
                                <i class="fa-solid fa-triangle-exclamation"></i>
                                Las contraseñas no coinciden
                            </div>
                        </div>
                        <div id="register-psw-confirm-wrapper" class="register-psw-wrapper">
                            <div class="register-input-wrapper">
                                <label id="register-psw-confirm-label" class="" for="register-psw-confirm">Confirmar contraseña:</label>
                                <input type="password" name="register-psw-confirm" id="register-psw-confirm" REQUIRED>
                            </div>
                            <i class="fa-solid fa-lock"></i>
                        </div>
                        <div id="alertNotMatch2" class="alertNotMatch">
                            <div class="alertNotMatch-container">
                                <i class="fa-solid fa-triangle-exclamation"></i>
                                Las contraseñas no coinciden
                            </div>
                        </div>
                        <div class="register-submit-wrapper">
                            <input id="register-submit" type="submit" value="Acceder" disabled="true">
                        </div>
                    </form>
                    <div id="register-error-message" class="error-message">
                        
                    </div>
                </div>
           </div>
        </div>
    </div>
    <script src="js/index.js"></script>
</body>
</html>