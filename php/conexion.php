<?php
    $dsn = 'mysql:dbname=gymAppDEC;host=127.0.0.1;port=3307';
    $user = 'root';
    $psw = 'root';

    try{

        $resultados = new PDO($dsn, $user, $psw);
        $resultados->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $resultados->exec("SET CHARACTER SET utf8");

    }catch(PDOException $e){
        echo 'Fallo en la conexión' . $e->getMessage();
    }
?>