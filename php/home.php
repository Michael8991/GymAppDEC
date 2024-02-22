<?php

    session_start(); 
    
    if (!isset($_SESSION['userEmail']) && !isset($_COOKIE['savedSession_cookie'])) {
        header("location: ../index.php");
        exit();
    }elseif(!isset($_SESSION['userEmail']) && isset($_COOKIE['savedSession_cookie'])){
        $_SESSION['userEmail'] = $_COOKIE['savedSession_cookie'];
    }
        
        include 'conexion.php';
        
            $userEmail = $_SESSION['userEmail'];
            try{
                error_reporting(E_ALL);
                ini_set('display_errors', 1);
                $stmt = $resultados->prepare("SELECT userID, userName FROM Users WHERE userEmail = :email");
                $stmt->bindParam(":email", $userEmail);
                $stmt->execute();

                $resultadosConsulta = $stmt->fetch(PDO::FETCH_ASSOC);

                $userName = $resultadosConsulta['userName'];
                $userID = $resultadosConsulta['userID'];
            }catch(PDOException $e){
                echo 'Fallo en el acceso a datos de usuario'.$e->getMessage();
            }
        
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="../css/home.css">


    <script src="https://kit.fontawesome.com/e63352ce10.js" crossorigin="anonymous"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Italiana&family=Oswald:wght@400;700&family=Varela+Round:wght@400;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Chivo:wght@300;900&family=Italiana&family=Oswald:wght@400;700&display=swap" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
</head>
<body>
    <div class="left-menu">
        <div class="logo-wrapper">
            <div class="logo-container">
                <div class="logo">
                    <img src="../images/logoSimpleNaranja.webp" alt="">
                </div>
                <div class="logo-text">FitTracks</div>
            </div>
        </div>
        <hr>
        <div class="nav-wrapper">
            <a class="btn-navleft" href=""><i class="fa-solid fa-home"></i> Inicio</a>
            <a class="active-btn-navleft active" href=""><i class="fa-solid fa-bolt"></i> Crear sesión rapida</a>
        </div>

        <div class="logout-wrapper">
            <a class="logout-btn" href="../php/logoutOP.php"><i class="fa-solid fa-arrow-right-from-bracket"></i> Salir</a>
        </div>

    </div>

    <div class="right-menu">
        <div class="header-right">
            <div class="welcome-wrapper">
                <p id="greeting"></p>
                <p>¡Bienvenido de vuelta <?php echo $userName?>!</p>
            </div>

            <div class="dateweather-wrapper" onclick="openModalWeather()">
                <p id="date"></p>
                <p id="weather"></p>
            </div>
        </div>

        <div class="body-right">
                <div class="session-list-wrapper bento-card">
                    <div class="title-bento-card">
                        <i class="fa-solid fa-award"></i>
                        <p>Objetivos de la sesión</p>
                    </div>
                    <form action="">
                        <div class="inputs-container">
                            <label for="weekdays">Día: </label>
                            <select id="weekdays" name="weekdays">
                                <option value="lunes">Lunes</option>
                                <option value="martes">Martes</option>
                                <option value="miércoles">Miércoles</option>
                                <option value="jueves">Jueves</option>
                                <option value="viernes">Viernes</option>
                                <option value="sábado">Sábado</option>
                                <option value="domingo">Domingo</option>
                            </select>
                        </div>
                        <div class="session-list" id="exercises-session-list">
                        
                        </div>
                        <div class="mensaje-sesion-rapida" id="mensajeSesionRapida">
                            
                        </div>
                        <input type="submit" id="saveSession" class="save-session-btn" value="Guardar">
                    </form>
                </div>
                <div class="exercises-list-wrapper bento-card">
                    <div class="inputs-container">
                        <label for="musculos" >Músculo:</label>
                        <select id="muscles" name="musculo">
                            <option value="abdominals">Abdominales</option>
                            <option value="abductors">Abductores</option>
                            <option value="adductors">Aductores</option>
                            <option value="biceps">Bíceps</option>
                            <option value="calves">Gemelos</option>
                            <option value="chest">Pecho</option>
                            <option value="forearms">Antebrazos</option>
                            <option value="glutes">Glúteos</option>
                            <option value="hamstrings">Isquiotibiales</option>
                            <option value="lats">Dorsales</option>
                            <option value="lower_back">Parte baja de la espalda</option>
                            <option value="middle_back">Parte media de la espalda</option>
                            <option value="neck">Cuello</option>
                            <option value="quadriceps">Cuádriceps</option>
                            <option value="traps">Trapecios</option>
                            <option value="triceps">Tríceps</option>
                        </select>
                    </div>
                    <div class="session-list" id="exercises-api-list">
                       
                    </div>
                </div>
        </div>
    </div>
    <div id="modalWeather" class="modal">
        <div class="modal-content">
            <form id="form-weather">
                <div class="inputs-container">
                    <label for="country">País:</label>
                    <input type="text" id="country" name="country" placeholder="Ingrese el país...">
                </div>
                <div class="inputs-container">
                    <label for="city">Ciudad:</label>
                    <input type="text" id="city" name="city" placeholder="Ingrese la ciudad...">
                </div>
                <div class="inputs-container">
                    <input id="submit-modalWeather" type="submit" value="Aceptar">
                    <button class="cancelWeather" onclick="closeModalWeather()">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
    <div id="modalInformacion" class="modal-informacion">
        <div class="modal-contenido">
            <span class="cerrar" onclick="cerrarModalInformacion()">&times;</span>
            <h2 id="exerciseNameInfo"></h2>
            <p id="exerciseInfo"></p>
        </div>
    </div>
    <script src="../js/home.js"></script>
</body>
</html>