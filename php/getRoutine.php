<?php
    session_start(); 
        
    if (!isset($_SESSION['userEmail']) && !isset($_COOKIE['savedSession_cookie'])) {
        header("location: ../index.php");
        exit();
    }elseif(!isset($_SESSION['userEmail']) && isset($_COOKIE['savedSession_cookie'])){
        $_SESSION['userEmail'] = $_COOKIE['savedSession_cookie'];
    }
    include 'conexion.php';

    try{
        $userEmail = $_SESSION['userEmail'];
        $stmtID = $resultados->prepare("SELECT userID FROM Users WHERE userEmail = :userEmail");
        $stmtID->bindParam(':userEmail', $userEmail, PDO::PARAM_STR);
        $stmtID->execute();

        $userID = $stmtID->fetchColumn();

    }catch(PDOException $e){
        echo json_encode(array('message' => 'Error en la selección del ID: ' . $e->getMessage()));
    }

    $data = json_decode(file_get_contents('php://input'), true);
    $day = $data['day'];
    try{
        $stmt = $resultados->prepare("SELECT routine FROM quickRoutine WHERE day = :day && userID = :userID");
        $stmt->bindParam(':day', $day, PDO::PARAM_STR);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($row) {
            
            $jsonData = json_decode($row['routine'], true);
            
            echo json_encode($jsonData);
        } else {
            
            echo json_encode(array('success' => true, 'message' => 'No hay rutina asignada.'));
        }
    }catch(PDOException $e){
        echo json_encode(array('error' => 'Error en la selección: ' . $e->getMessage()));
    }
?>