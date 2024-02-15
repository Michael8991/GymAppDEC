<?php 

include 'conexion.php';

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $email = $_POST['register-email'];
        $userName = $_POST['register-name'];
        $psw = $_POST['register-psw'];
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            try{
                $stmtCorreoExistente = $resultados->prepare("SELECT userEmail FROM users WHERE userEmail = :email");
                $stmtCorreoExistente->bindParam(':email', $email);
                $stmtCorreoExistente->execute();
                $correoExistente = $stmtCorreoExistente->fetch(PDO::FETCH_ASSOC);

                if($correoExistente ==  false){
                    try{

                        $pswEncrypted = password_hash($psw, PASSWORD_BCRYPT);

                        $stmt = $resultados->prepare("INSERT INTO users(userEmail, userName, userPsw) VALUES (:email, :userName, :pswEncrypted)");
                        $stmt->bindParam(":email", $email);
                        $stmt->bindParam(":userName", $userName, PDO::PARAM_STR);
                        $stmt->bindParam(":pswEncrypted", $pswEncrypted);
                        $stmt->execute();

                        header("Content-Type: application/json");
                        echo json_encode(array('success' => true, 'message' => 'Las credenciales de acceso son correctas'));
                        exit();
                    
                        
                    }catch(PDOException $e){
                        echo 'Operación de registro fallida' . $e->getMessage();
                    }
                }else{
                    echo json_encode(array('message' => 'El correo ya se encuentra registrado'));
                }
            }catch(PDOException $e){
                echo 'Fallo en el login' . $e->getMessage();
            }
        }else{
            echo json_encode(array('message' => 'Formato de email incorrecto'));
        }
    }



?>