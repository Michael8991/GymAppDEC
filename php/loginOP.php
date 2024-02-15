<?php 

include 'conexion.php';

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        
        $email = $_POST['email'];
        $psw = $_POST['psw'];
        if(filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($email)){
            try{
                $stmt = $resultados->prepare("SELECT userEmail, userPsw FROM Users WHERE userEmail = :email");
                $stmt->bindParam(":email", $email);
                $stmt->execute();

                $resultados = $stmt->fetch(PDO::FETCH_ASSOC);
                if($resultados !== false){
                    $storedHashedPassword = $resultados['userPsw'];
                    if(password_verify($psw, $storedHashedPassword)){
                        if(isset($_POST['mantenerSesionAbierta'])){
                            $savedSession = $_POST['email'];
                            $durationCookie = ($savedSession) ? time() + (30 * 24 * 60 * 60) : 0;
                            setcookie("savedSession_cookie", $savedSession, $durationCookie, "/", "", false, true);
                        }
                        session_start();
                        $_SESSION['userEmail'] = $email;
                        header("Content-Type: application/json");
                        echo json_encode(array('success' => true, 'message' => 'Las credenciales de acceso son correctas'));
                        exit();
                    }else{
                        echo json_encode(array('message' => '!!Login incorrecto !!!Usuario o contraseña incorrecta'));
                    }
                }else{
                    echo json_encode(array('message' => '!!Login incorrecto !!!Usuario o contraseña incorrecta'));
                }
            }catch(PDOException $e){
                echo 'Fallo en el login' . $e->getMessage();
            }
        }else{
            echo json_encode(array('message' => 'Formato de email incorrecto'));
        }

    }

?>

