<?php

    session_start(); 
    
    if (!isset($_SESSION['userEmail']) && !isset($_COOKIE['savedSession_cookie'])) {
        header("location: ../index.php");
        exit();
    }elseif(!isset($_SESSION['userEmail']) && isset($_COOKIE['savedSession_cookie'])){
        $_SESSION['userEmail'] = $_COOKIE['savedSession_cookie'];
    }
    include 'conexion.php';
    
    $data = json_decode(file_get_contents('php://input'), true);
    
    if ($data && isset($data['weekday']) && isset($data['ejerciciosJSON'])) {

        try{
            $userEmail = $_SESSION['userEmail'];
            $stmtID = $resultados->prepare("SELECT userID FROM Users WHERE userEmail = :userEmail");
            $stmtID->bindParam(':userEmail', $userEmail, PDO::PARAM_STR);
            $stmtID->execute();

            $userID = $stmtID->fetchColumn();

        }catch(PDOException $e){
            echo json_encode(array('message' => 'Error en la selección del ID: ' . $e->getMessage()));
        }
        
        $weekday = $data['weekday'];
        $ejerciciosJSON = $data['ejerciciosJSON'];
    
        $diasSemana = array('lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado', 'domingo');
        //Validamos el día de la semana
        if (in_array($weekday, $diasSemana)) {
            //Validamos que no este intentando crear una rutina vacía
            if(!empty($ejerciciosJSON) && $ejerciciosJSON !== null && $ejerciciosJSON !== '[]'){

                try{
                    $stmtDay = $resultados->prepare("SELECT day FROM quickRoutine WHERE day = :weekday && userID = :userID");
                    $stmtDay->bindParam(':weekday', $weekday, PDO::PARAM_STR);
                    $stmtDay->bindParam(':userID', $userID, PDO::PARAM_INT);
                    $stmtDay->execute();
                    $row=$stmtDay->fetch(PDO::FETCH_ASSOC);
                    if($row){
                        try {
                            $stmtUpdate = $resultados->prepare("UPDATE quickRoutine SET routine = :ejerciciosJSON WHERE day = :weekday && userID = :userID");
                            $stmtUpdate->bindParam(':weekday', $weekday, PDO::PARAM_STR);
                            $stmtUpdate->bindParam(':ejerciciosJSON', $ejerciciosJSON, PDO::PARAM_STR);
                            $stmtUpdate->bindParam(':userID', $userID, PDO::PARAM_INT);
                            $stmtUpdate->execute();
                
                            header("Content-Type: application/json");
                            echo json_encode(array('success' => true, 'message' => 'Rutina Actualizada'));
                            exit();
                        } catch(PDOException $e) {
                            echo json_encode(array('message' => 'Error en la inserción de datos actualizados: ' . $e->getMessage()));
                        }
                    }else{
                        try {
                            $stmt = $resultados->prepare("INSERT INTO quickRoutine (day, routine, userID) VALUES (:weekday, :ejerciciosJSON, :userID)");
                            $stmt->bindParam(':weekday', $weekday, PDO::PARAM_STR);
                            $stmt->bindParam(':ejerciciosJSON', $ejerciciosJSON, PDO::PARAM_STR);
                            $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
                            $stmt->execute();
                
                            header("Content-Type: application/json");
                            echo json_encode(array('success' => true, 'message' => 'Rutina Guardada'));
                            exit();
                        } catch(PDOException $e) {
                            echo json_encode(array('message' => 'Error en la inserción: ' . $e->getMessage()));
                        }
                    }
                }catch(PDOException $e){
                    echo json_encode(array('message' => 'Error en la selección de días: ' . $e->getMessage()));
                }
            }else{
                echo json_encode(array('message' => 'La rutina no puede estar vacía'));
            }
        } else {
            echo json_encode(array('message' => 'El día de la semana no es válido'. $weekday));
        }
    } else {
        echo json_encode(array('message' => 'No se recibieron datos válidos'));
    }
?>
    